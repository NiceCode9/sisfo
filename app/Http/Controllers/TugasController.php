<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Tugas;
use App\Models\GuruMataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tahunAjaran = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();

        // Filter kelas dan mata pelajaran berdasarkan role
        if ($user->hasRole('guru')) {
            $guru = $user->guru;
            $tahunAjaranAktif = TahunAjaran::aktif()->first();

            // Ambil kelas yang diajar oleh guru
            $kelas = Kelas::whereHas('guruKelas.guruMataPelajaran', function ($query) use ($guru, $tahunAjaranAktif) {
                $query->where('guru_id', $guru->id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->where('aktif', true);
            })->orderBy('nama_kelas')->get();

            // Ambil mata pelajaran yang diajar oleh guru
            $mataPelajaran = MataPelajaran::whereHas('guruMataPelajaran', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })->orderBy('nama_pelajaran')->get();
        } else {
            // Jika superadmin, tampilkan semua
            $kelas = Kelas::orderBy('nama_kelas')->get();
            $mataPelajaran = MataPelajaran::orderBy('nama_pelajaran')->get();
        }

        if ($request->ajax()) {
            $user = Auth::user();
            $query = Tugas::with([
                'guruKelas.kelas',
                'guruKelas.guruMataPelajaran.mataPelajaran',
                'guruKelas.guruMataPelajaran.guru.user',
                'pengumpulanTugas'
            ]);

            // Filter berdasarkan role
            if ($user->hasRole('guru')) {
                $guru = $user->guru;
                $query->whereHas('guruKelas.guruMataPelajaran', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                });
            }

            // Filter tahun ajaran
            if ($request->filled('tahun_ajaran_id')) {
                $query->whereHas('guruKelas', function ($q) use ($request) {
                    $q->where('tahun_ajaran_id', $request->tahun_ajaran_id);
                });
            }

            // Filter kelas
            if ($request->filled('kelas_id')) {
                $query->whereHas('guruKelas', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                });
            }

            // Filter mata pelajaran
            if ($request->filled('mata_pelajaran_id')) {
                $query->whereHas('guruKelas.guruMataPelajaran', function ($q) use ($request) {
                    $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('mata_pelajaran', function ($tugas) {
                    return $tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran;
                })
                ->addColumn('kelas', function ($tugas) {
                    return $tugas->guruKelas->kelas->nama_kelas;
                })
                ->addColumn('guru', function ($tugas) {
                    return $tugas->guruKelas->guruMataPelajaran->guru->user->name;
                })
                ->addColumn('jenis', function ($tugas) {
                    return '<span class="badge bg-info">' . ucfirst(str_replace('_', ' ', $tugas->jenis)) . '</span>';
                })
                ->addColumn('metode_pengerjaan', function ($tugas) {
                    $class = $tugas->metode_pengerjaan === 'online' ? 'bg-primary' : 'bg-success';
                    return '<span class="badge ' . $class . '">' . ucfirst(str_replace('_', ' ', $tugas->metode_pengerjaan)) . '</span>';
                })
                ->addColumn('batas_waktu', function ($tugas) {
                    $html = $tugas->batas_waktu->format('d M Y H:i');
                    if ($tugas->batas_waktu->isPast()) {
                        $html .= ' <span class="badge bg-danger">Berakhir</span>';
                    }
                    return $html;
                })
                ->addColumn('status', function ($tugas) use ($user) {
                    $status = 'Belum Dikumpulkan';
                    $statusClass = 'bg-warning';

                    if ($user->hasRole('siswa')) {
                        $pengumpulan = $tugas->pengumpulanTugas()
                            ->where('siswa_id', $user->siswa->id)
                            ->first();

                        if ($pengumpulan) {
                            $status = $pengumpulan->nilai ? 'Sudah Dinilai' : 'Menunggu Penilaian';
                            $statusClass = $pengumpulan->nilai ? 'bg-success' : 'bg-info';
                        }
                    } else {
                        $total = $tugas->pengumpulanTugas->count();
                        $dinilai = $tugas->pengumpulanTugas->whereNotNull('nilai')->count();
                        $status = "$dinilai / $total Dinilai";
                        $statusClass = $total === $dinilai ? 'bg-success' : 'bg-info';
                    }

                    return '<span class="badge ' . $statusClass . '">' . $status . '</span>';
                })
                ->addColumn('action', function ($tugas) use ($user) {
                    $html = '<div class="btn-group">';
                    $html .= '<a href="' . route('admin.tugas.show', ['tuga' => $tugas->id]) . '" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>';

                    if ($user->hasRole('guru') && $tugas->guruKelas->guruMataPelajaran->guru->user->id === $user->id) {
                        $html .= '<a href="' . route('admin.tugas.edit', $tugas->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>';
                        $html .= '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\'' . $tugas->id . '\')" title="Hapus"><i class="fas fa-trash"></i></button>';
                    } elseif ($user->hasRole('siswa') && !$tugas->batas_waktu->isPast()) {
                        if (!$tugas->pengumpulanTugas()->where('siswa_id', $user->siswa->id)->exists()) {
                            $html .= '<a href="' . route('admin.pengumpulan-tugas.create', ['tugas' => $tugas->id]) . '" class="btn btn-sm btn-success" title="Kumpulkan"><i class="fas fa-upload"></i> Kumpulkan</a>';
                        }
                    }

                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['jenis', 'metode_pengerjaan', 'batas_waktu', 'status', 'action'])
                ->make(true);
        }

        return view('e-learning.tugas.index', compact('tahunAjaran', 'kelas', 'mataPelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tahunAjaranId = $request->tahun_ajaran_id ?? TahunAjaran::aktif()->first()->id;
        $kelasYangDiajar = GuruKelas::with([
            'kelas',
            'guruMataPelajaran.mataPelajaran'
        ])
            ->whereHas('guruMataPelajaran', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('aktif', true)
            ->get();
        return view('e-learning.tugas.create', compact('kelasYangDiajar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_kelas_id' => 'required|exists:guru_kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'batas_waktu' => 'required|date|after:now',
            'total_nilai' => 'required|integer|min:1|max:1000',
            'jenis' => 'required|in:uraian,pilihan_ganda,campuran',
            'metode_pengerjaan' => 'required|in:online,upload_file',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tanggal_terbit' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tugas = new Tugas($request->except('file_tugas'));

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $path = $file->store('tugas', 'public');
            $tugas->file_tugas = $path;
        }

        $tugas->save();

        if ($tugas->metode_pengerjaan === 'online') {
            return redirect()->route('admin.soal.create', ['tugas' => $tugas->id])
                ->with('success', 'Tugas berhasil dibuat, silahkan tambahkan soal.');
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tuga)
    {
        $tuga->load(['soal.jawaban', 'pengumpulanTugas']);
        return view('e-learning.tugas.show', compact('tuga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tuga)
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tahunAjaranId = $request->tahun_ajaran_id ?? TahunAjaran::aktif()->first()->id;
        $kelasYangDiajar = GuruKelas::with([
            'kelas',
            'guruMataPelajaran.mataPelajaran'
        ])
            ->whereHas('guruMataPelajaran', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('aktif', true)
            ->get();

        return view('e-learning.tugas.edit', compact('tuga', 'kelasYangDiajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tuga)
    {
        try {
            $rules = [
                'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'batas_waktu' => 'required|date',
                'total_nilai' => 'required|integer|min:0|max:100',
            ];

            // Hanya validasi file jika tugas tipe upload file
            if ($tuga->metode_pengerjaan === 'upload_file') {
                $rules['file_tugas'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            }

            $validator = Validator::make($request->all(), $rules, [
                'guru_mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih',
                'judul.required' => 'Judul tugas wajib diisi',
                'judul.max' => 'Judul tugas maksimal 255 karakter',
                'deskripsi.required' => 'Deskripsi tugas wajib diisi',
                'batas_waktu.required' => 'Batas waktu wajib diisi',
                'batas_waktu.date' => 'Format batas waktu tidak valid',
                'total_nilai.required' => 'Total nilai wajib diisi',
                'total_nilai.integer' => 'Total nilai harus berupa angka',
                'total_nilai.min' => 'Total nilai minimal 0',
                'total_nilai.max' => 'Total nilai maksimal 100',
                'file_tugas.mimes' => 'File tugas harus berformat PDF, DOC, atau DOCX',
                'file_tugas.max' => 'Ukuran file tugas maksimal 2MB'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            if ($request->hasFile('file_tugas')) {
                // Hapus file lama jika ada
                if ($tuga->file_tugas) {
                    Storage::disk('public')->delete($tuga->file_tugas);
                }
                $file = $request->file('file_tugas');
                $path = $file->store('tugas', 'public');
                $tuga->file_tugas = $path;
            }

            $tuga->update($request->except(['file_tugas', 'metode_pengerjaan', 'jenis']));

            DB::commit();

            return redirect()->route('admin.tugas.show', $tuga->id)
                ->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tuga)
    {
        if ($tuga->file_tugas) {
            Storage::disk('public')->delete($tuga->file_tugas);
        }

        $tuga->delete();

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
