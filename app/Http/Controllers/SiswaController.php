<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.siswa.index');
    }

    public function datatable()
    {
        $siswa = Siswa::with(['calonSiswa.tahunAjaran', 'riwayatKelas'])
            ->get();

        return datatables()->of($siswa)
            ->addIndexColumn()
            ->addColumn('nama_lengkap', function ($row) {
                return $row->calonSiswa->nama_lengkap;
            })
            ->addColumn('tempat_tanggal_lahir', function ($row) {
                return $row->calonSiswa->tempat_lahir . ', ' . Carbon::parse($row->calonSiswa->tanggal_lahir)->isoFormat('D MMMM Y');
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addColumn('tahun_masuk', function ($row) {
                return $row->calonSiswa->tahunAjaran ? $row->calonSiswa->tahunAjaran->nama_tahun_ajaran : 'Tidak diketahui';
            })
            ->addColumn('kelas_awal', function ($row) {
                return $row->kelas_awal;
            })
            ->addColumn('current_class', function ($row) {
                return $row->kelasAktif() ? $row->kelasAktif()->kelas->tingkat . '-' . $row->kelasAktif()->kelas->nama_kelas : 'Belum ada kelas';
            })
            ->addColumn('status', function ($row) {
                $status = $row->kelasAktif() ? $row->kelasAktif()->status : 'Belum Ada Kelas';
                $badges = [
                    'aktif' => 'success',
                    'lulus' => 'primary',
                    'pindah' => 'warning',
                    'dropout' => 'danger',
                    'Belum Ada Kelas' => 'secondary'
                ];
                $color = $badges[$status] ?? 'secondary';
                return "<span class='badge bg-{$color}'>{$status}</span>";
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . route('siswa.edit', $row->id) . '" class="btn btn-sm btn-warning me-1">Edit</a>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('master.siswa.form', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nik' => 'required|string|max:16',
                'nisn' => 'required|string|max:10',
                'nis' => 'required|string|max:10',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|string|max:50',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'email' => 'nullable|email|max:255',
                'asal_sekolah' => 'nullable|string|max:255',
                'nama_ayah' => 'required|string|max:255',
                'pekerjaan_ayah' => 'required|string|max:100',
                'nama_ibu' => 'required|string|max:255',
                'pekerjaan_ibu' => 'required|string|max:100',
                'no_hp_orang_tua' => 'nullable|string|max:15',
                'kelas_id' => 'required|exists:kelas,id',
            ]);

            $validated = $request->except(['kelas_id', 'nis']);
            $validated['tahun_ajaran_id'] = TahunAjaran::where('status_aktif', true)->first()->id;
            $validated['no_pendaftaran'] = 'IMPRT-' . Carbon::now()->format('YmdHis');
            $validated['status_pendaftaran'] = 'diterima';

            $casis_dt = CalonSiswa::create($validated);

            $siswa = $casis_dt->siswa()->create([
                'tahun_ajaran_id' => $casis_dt->tahun_ajaran_id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'kelas_awal' => '7',
            ]);

            $siswa->riwayatKelas()->create([
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $casis_dt->tahun_ajaran_id,
                'status' => 'aktif',
                'keterangan' => 'Import data lama ke app baru',
            ]);

            $siswa->user()->create([
                'name' => $casis_dt->nama_lengkap,
                'email' => $casis_dt->email ?? 'smppiri@sekolah.com',
                'username' => $casis_dt->nik,
                'password' => bcrypt('password'),
                'slug' => Str::slug($casis_dt->nama_lengkap . '-' . $casis_dt->nik),
            ]);

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan siswa: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('master.siswa.form', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nik' => 'required|string|max:16',
                'nisn' => 'required|string|max:10',
                'nis' => 'required|string|max:10',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|string|max:50',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'email' => 'nullable|email|max:255',
                'asal_sekolah' => 'nullable|string|max:255',
                'nama_ayah' => 'required|string|max:255',
                'pekerjaan_ayah' => 'required|string|max:100',
                'nama_ibu' => 'required|string|max:255',
                'pekerjaan_ibu' => 'required|string|max:100',
                'no_hp_orang_tua' => 'nullable|string|max:15',
                'kelas_id' => 'required|exists:kelas,id',
            ]);

            // Update data calon siswa
            $calonSiswa = $siswa->calonSiswa;
            $validated = $request->except(['kelas_id', 'nis']);

            $calonSiswa->update($validated);

            // Update data siswa
            $siswa->update([
                'nis' => $request->nis,
                'nisn' => $request->nisn
            ]);

            // Update kelas jika berbeda dengan kelas aktif saat ini
            $kelasAktif = $siswa->kelasAktif();
            if ($kelasAktif && $kelasAktif->kelas_id != $request->kelas_id) {
                // Non-aktifkan kelas lama
                $kelasAktif->update(['status' => 'non-aktif']);

                // Buat riwayat kelas baru
                $siswa->riwayatKelas()->create([
                    'kelas_id' => $request->kelas_id,
                    'tahun_ajaran_id' => $calonSiswa->tahun_ajaran_id,
                    'status' => 'aktif',
                    'keterangan' => 'Perpindahan kelas via edit data'
                ]);
            }

            // Update user terkait
            $siswa->user()->update([
                'name' => $request->nama_lengkap,
                'email' => $request->email ?? 'smppiri@sekolah.com',
                'username' => $request->nik,
                'slug' => Str::slug($request->nama_lengkap . '-' . $request->nik)
            ]);

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            DB::beginTransaction();

            // Hapus riwayat kelas
            $siswa->riwayatKelas()->delete();

            // Hapus user terkait
            $siswa->user()->delete();

            // Hapus calon siswa
            $siswa->calonSiswa()->delete();

            // Hapus siswa
            $siswa->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data siswa: ' . $th->getMessage()
            ], 500);
        }
    }
}
