<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Tugas;
use App\Models\GuruMataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
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
                ->addColumn('progres_pengumpulan', function ($tugas) {
                    // Hitung jumlah siswa di kelas
                    $jumlahSiswa = $tugas->guruKelas->kelas->siswa()->count();
                    // Hitung jumlah yang sudah mengumpulkan
                    $jumlahMengumpulkan = $tugas->pengumpulanTugas->count();
                    return "<span class=\"badge bg-secondary\">$jumlahMengumpulkan / $jumlahSiswa</span>";
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
                    $html .= '<a href="' . route('tugas.show', ['tuga' => $tugas->id]) . '" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>';

                    if ($user->hasRole('guru') && $tugas->guruKelas->guruMataPelajaran->guru->user->id === $user->id) {
                        $html .= '<a href="' . route('tugas.edit', $tugas->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>';
                        $html .= '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\'' . $tugas->id . '\')" title="Hapus"><i class="fas fa-trash"></i></button>';
                    } elseif ($user->hasRole('siswa') && !$tugas->batas_waktu->isPast()) {
                        if (!$tugas->pengumpulanTugas()->where('siswa_id', $user->siswa->id)->exists()) {
                            $html .= '<a href="' . route('pengumpulan-tugas.create', ['tugas' => $tugas->id]) . '" class="btn btn-sm btn-success" title="Kumpulkan"><i class="fas fa-upload"></i> Kumpulkan</a>';
                        }
                    }

                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('lihat_pengumpulan', function ($tugas) use ($user) {
                    if ($user->hasRole('guru') && $tugas->guruKelas->guruMataPelajaran->guru->user->id === $user->id) {
                        return '<a href="' . route('tugas.submissions', ['tugas' => $tugas->id]) . '" class="btn btn-sm btn-info" title="Lihat Pengumpulan">Pengumpulan</a>';
                    }
                    return '';
                })
                ->rawColumns(['jenis', 'metode_pengerjaan', 'batas_waktu', 'progres_pengumpulan', 'status', 'action', 'lihat_pengumpulan'])
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
            return redirect()->route('soal.create', ['tugas' => $tugas->id])
                ->with('success', 'Tugas berhasil dibuat, silahkan tambahkan soal.');
        }

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tuga)
    {
        $tuga->load(['soal.jawaban', 'pengumpulanTugas.siswa', 'guruKelas.guruMataPelajaran.mataPelajaran']);
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

            return redirect()->route('tugas.show', $tuga->id)
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

    /**
     * Show submitted assignments and grading page
     */
    public function submissions(Tugas $tugas, Request $request)
    {
        $tugas->load([
            'guruKelas.kelas',
            'guruKelas.guruMataPelajaran.mataPelajaran',
            'pengumpulanTugas.siswa.user'
        ]);

        if ($request->ajax()) {
            $query = $tugas->pengumpulanTugas()
                ->with(['siswa.user'])
                ->select('pengumpulan_tugas.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama_siswa', function ($pengumpulan) {
                    return $pengumpulan->siswa->user->name;
                })
                ->addColumn('waktu_pengumpulan', function ($pengumpulan) {
                    return $pengumpulan->created_at->format('d M Y H:i');
                })
                ->addColumn('file_pengumpulan', function ($pengumpulan) {
                    if ($pengumpulan->file_pengumpulan) {
                        return '<a href="' . Storage::url($pengumpulan->file_pengumpulan) . '" class="btn btn-sm btn-primary" target="_blank" title="Lihat File"><i class="fas fa-file"></i> Lihat</a>';
                    }
                    return '<span class="badge bg-primary">Tidak Ada File</span>';
                })
                ->addColumn('status', function ($pengumpulan) {
                    if ($pengumpulan->nilai !== null) {
                        return '<span class="badge bg-success">Sudah Dinilai</span>';
                    }
                    return '<span class="badge bg-warning">Belum Dinilai</span>';
                })
                ->addColumn('nilai', function ($pengumpulan) {
                    if ($pengumpulan->nilai !== null) {
                        return $pengumpulan->nilai;
                    }
                    return '-';
                })
                ->addColumn('action', function ($pengumpulan) {
                    $html = '<div class="btn-group">';
                    // View submission details
                    $html .= '<button type="button" class="btn btn-sm btn-info" onclick="viewSubmission(' . $pengumpulan->id . ')" title="Lihat"><i class="fas fa-eye"></i></button>';

                    // Grade button if not graded yet
                    if ($pengumpulan->nilai === null) {
                        $html .= '<button type="button" class="btn btn-sm btn-primary" onclick="showGradeModal(' . $pengumpulan->id . ')" title="Nilai"><i class="fas fa-star"></i></button>';
                    } else {
                        // Edit grade if already graded
                        $html .= '<button type="button" class="btn btn-sm btn-warning" onclick="showGradeModal(' . $pengumpulan->id . ')" title="Edit Nilai"><i class="fas fa-edit"></i></button>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('e-learning.tugas.submissions', compact('tugas'));
    }

    /**
     * Save grade for a submission
     */
    public function grade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengumpulan_id' => 'required|exists:pengumpulan_tugas,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pengumpulan = PengumpulanTugas::findOrFail($request->pengumpulan_id);

        // Check if user has permission to grade
        $user = Auth::user();
        if (!$user->hasRole('guru') || $pengumpulan->tugas->guruKelas->guruMataPelajaran->guru->user->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pengumpulan->nilai = $request->nilai;
        $pengumpulan->umpan_balik = $request->komentar;
        $pengumpulan->save();

        return response()->json([
            'message' => 'Nilai berhasil disimpan',
            'pengumpulan' => $pengumpulan
        ]);
    }

    /**
     * Get submission details
     */
    public function submissionDetail($id)
    {
        $pengumpulan = \App\Models\PengumpulanTugas::with([
            'siswa.user',
            'tugas.soal',
            'jawabanSiswa.soal',
        ])->findOrFail($id);

        $user = Auth::user();
        if (!$user->hasRole(['guru', 'admin']) && ($user->hasRole('siswa') && $pengumpulan->siswa_id !== $user->siswa->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Siapkan data jawaban per soal
        $soalList = $pengumpulan->tugas->soal;
        $jawabanSiswa = $pengumpulan->jawabanSiswa->keyBy('soal_id');
        $soalJawaban = $soalList->map(function ($soal) use ($jawabanSiswa) {
            $jawaban = $jawabanSiswa->get($soal->id);
            return [
                'soal_id' => $soal->id,
                'pertanyaan' => $soal->pertanyaan,
                'tipe' => $soal->tipe,
                'jawaban_siswa' => $jawaban ? $jawaban->jawaban : null,
                'nilai' => $jawaban ? $jawaban->nilai : null,
            ];
        });

        $result = $pengumpulan->toArray();
        $result['soal_jawaban'] = $soalJawaban;

        return response()->json($result);
    }

    public function destroySubmission($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);

        // Check permission
        $user = Auth::user();
        if (!$user->hasRole('guru') || $pengumpulan->tugas->guruKelas->guruMataPelajaran->guru->user->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete file if exists
        if ($pengumpulan->file_pengumpulan) {
            Storage::disk('public')->delete($pengumpulan->file_pengumpulan);
        }

        $pengumpulan->delete();

        return response()->json(['message' => 'Pengumpulan tugas berhasil dihapus']);
    }
}
