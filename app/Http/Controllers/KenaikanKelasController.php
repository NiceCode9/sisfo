<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\RiwayatKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        // Hanya ambil kelas yang bisa dinaikkan (bukan kelas 12)
        $kelas = Kelas::where('tingkat', '<', 12)
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('master.kenaikan-kelas.index', compact('kelas'));
    }

    public function getSiswa(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $tahunAjaranAktif = TahunAjaran::aktif()->first();
        if (!$tahunAjaranAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tahun ajaran aktif'
            ], 400);
        }

        $kelas = Kelas::find($request->kelas_id);

        // Pastikan kelas bukan kelas 12
        if ($kelas->tingkat >= 12) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa kelas 12 tidak bisa dinaikkan lagi'
            ], 400);
        }

        $siswa = $kelas->siswaAktif($tahunAjaranAktif->id)
            ->with('calonSiswa')
            ->get()
            ->map(function ($siswa) {
                return [
                    'id' => $siswa->id,
                    'nis' => $siswa->nis,
                    'nama' => $siswa->calonSiswa->nama_lengkap,
                    'kelas_awal' => $siswa->kelas_awal
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $siswa,
            'kelas' => $kelas
        ]);
    }

    public function getKelasTujuan(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $kelasAsal = Kelas::find($request->kelas_id);
        $tingkatTujuan = $kelasAsal->tingkat + 1;

        // Jika kelas asal adalah tingkat 9 (kelas 12), kembalikan opsi lulus
        if ($kelasAsal->tingkat == 9) {
            return response()->json([
                'success' => true,
                'data' => [['id' => 'lulus', 'nama_kelas' => 'Lulus', 'tingkat' => 'lulus']],
                'is_lulus' => true
            ]);
        }

        // Validasi untuk memastikan tidak melebihi tingkat 9
        if ($tingkatTujuan > 9) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kelas tujuan yang tersedia'
            ]);
        }

        $kelasTujuan = Kelas::where('tingkat', $tingkatTujuan)
            ->orderBy('nama_kelas')
            ->get(['id', 'nama_kelas', 'tingkat', 'jurusan']);

        if ($kelasTujuan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kelas tujuan yang tersedia untuk tingkat ' . $tingkatTujuan
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $kelasTujuan,
            'is_lulus' => false
        ]);
    }

    public function prosesKenaikan(Request $request)
    {
        $request->validate([
            'kelas_asal_id' => 'required|exists:kelas,id',
            'kelas_tujuan_id' => 'required',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:siswa,id'
        ], [
            'siswa_ids.required' => 'Pilih minimal satu siswa',
            'siswa_ids.min' => 'Pilih minimal satu siswa',
        ]);

        DB::beginTransaction();
        try {
            $tahunAjaranAktif = TahunAjaran::aktif()->first();
            if (!$tahunAjaranAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada tahun ajaran aktif'
                ], 400);
            }

            $kelasAsal = Kelas::find($request->kelas_asal_id);
            $isLulus = $kelasAsal->tingkat == 9; // Kelas 12 (tingkat 9)

            // Jika proses kelulusan (kelas 12)
            if ($isLulus) {
                $berhasilDiproses = 0;
                $errors = [];

                foreach ($request->siswa_ids as $siswaId) {
                    $siswa = Siswa::find($siswaId);

                    // Cek apakah siswa masih aktif di kelas asal
                    $riwayatAktif = $siswa->riwayatKelas()
                        ->where('kelas_id', $request->kelas_asal_id)
                        ->where('status', 'aktif')
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->first();

                    if (!$riwayatAktif) {
                        $errors[] = "Siswa {$siswa->nis} tidak aktif di kelas asal";
                        continue;
                    }

                    // Update status menjadi lulus
                    $riwayatAktif->update([
                        'status' => 'lulus',
                        'keterangan' => 'Telah lulus'
                    ]);

                    $berhasilDiproses++;
                }

                DB::commit();

                $message = "Kelulusan berhasil diproses untuk {$berhasilDiproses} siswa";
                if (!empty($errors)) {
                    $message .= ". Errors: " . implode(', ', $errors);
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'processed' => $berhasilDiproses,
                    'errors' => $errors
                ]);
            }
            // Jika proses kenaikan kelas biasa
            else {
                $kelasTujuan = Kelas::find($request->kelas_tujuan_id);

                // Validasi tingkat kelas
                if ($kelasTujuan->tingkat != $kelasAsal->tingkat + 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kelas tujuan harus satu tingkat lebih tinggi dari kelas asal'
                    ], 400);
                }

                $berhasilDiproses = 0;
                $errors = [];

                foreach ($request->siswa_ids as $siswaId) {
                    $siswa = Siswa::find($siswaId);

                    // Cek apakah siswa masih aktif di kelas asal
                    $riwayatAktif = $siswa->riwayatKelas()
                        ->where('kelas_id', $request->kelas_asal_id)
                        ->where('status', 'aktif')
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->first();

                    if (!$riwayatAktif) {
                        $errors[] = "Siswa {$siswa->nis} tidak aktif di kelas asal";
                        continue;
                    }

                    // Non-aktifkan kelas lama
                    $riwayatAktif->update(['status' => 'non-aktif']);

                    // Buat riwayat kelas baru
                    $siswa->riwayatKelas()->create([
                        'kelas_id' => $request->kelas_tujuan_id,
                        'tahun_ajaran_id' => $tahunAjaranAktif->id,
                        'status' => 'aktif',
                        'keterangan' => 'Kenaikan kelas'
                    ]);

                    $berhasilDiproses++;
                }

                DB::commit();

                $message = "Kenaikan kelas berhasil diproses untuk {$berhasilDiproses} siswa";
                if (!empty($errors)) {
                    $message .= ". Errors: " . implode(', ', $errors);
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'processed' => $berhasilDiproses,
                    'errors' => $errors
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function getKelasTujuan(Request $request)
    // {
    //     $request->validate([
    //         'kelas_id' => 'required|exists:kelas,id'
    //     ]);

    //     $kelasAsal = Kelas::find($request->kelas_id);
    //     $tingkatTujuan = $kelasAsal->tingkat + 1;

    //     // Validasi maksimal tingkat 12
    //     if ($tingkatTujuan > 9) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Siswa sudah mencapai tingkat tertinggi. Maka akan langsung diluluskan.'
    //         ]);
    //     }

    //     $kelasTujuan = Kelas::where('tingkat', $tingkatTujuan)
    //         ->orderBy('nama_kelas')
    //         ->get(['id', 'nama_kelas', 'tingkat', 'jurusan']);

    //     if ($kelasTujuan->isEmpty()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Tidak ada kelas tujuan yang tersedia untuk tingkat ' . $tingkatTujuan
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $kelasTujuan
    //     ]);
    // }

    // public function prosesKenaikan(Request $request)
    // {
    //     $request->validate([
    //         'kelas_asal_id' => 'required|exists:kelas,id',
    //         'kelas_tujuan_id' => 'required|exists:kelas,id',
    //         'siswa_ids' => 'required|array|min:1',
    //         'siswa_ids.*' => 'exists:siswa,id'
    //     ], [
    //         'siswa_ids.required' => 'Pilih minimal satu siswa',
    //         'siswa_ids.min' => 'Pilih minimal satu siswa',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $tahunAjaranAktif = TahunAjaran::aktif()->first();
    //         if (!$tahunAjaranAktif) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Tidak ada tahun ajaran aktif'
    //             ], 400);
    //         }

    //         $kelasAsal = Kelas::find($request->kelas_asal_id);
    //         $kelasTujuan = Kelas::find($request->kelas_tujuan_id);

    //         // Validasi tingkat kelas
    //         if ($kelasAsal->tingkat > 9) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Siswa kelas 9 tidak dapat dinaikkan melainkan langsung diluluskan'
    //             ], 400);
    //         }

    //         if ($kelasTujuan->tingkat != $kelasAsal->tingkat + 1) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Kelas tujuan harus satu tingkat lebih tinggi dari kelas asal'
    //             ], 400);
    //         }

    //         $berhasilDiproses = 0;
    //         $errors = [];

    //         foreach ($request->siswa_ids as $siswaId) {
    //             $siswa = Siswa::find($siswaId);

    //             // Cek apakah siswa masih aktif di kelas asal
    //             $riwayatAktif = $siswa->riwayatKelas()
    //                 ->where('kelas_id', $request->kelas_asal_id)
    //                 ->where('status', 'aktif')
    //                 ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //                 ->first();

    //             if (!$riwayatAktif) {
    //                 $errors[] = "Siswa {$siswa->nis} tidak aktif di kelas asal";
    //                 continue;
    //             }

    //             // Non-aktifkan kelas lama
    //             $riwayatAktif->update(['status' => 'non-aktif']);

    //             // Tentukan status baru
    //             $statusBaru = ($kelasTujuan->tingkat == 9) ? 'lulus' : 'aktif';

    //             // Buat riwayat kelas baru
    //             $siswa->riwayatKelas()->create([
    //                 'kelas_id' => $request->kelas_tujuan_id,
    //                 'tahun_ajaran_id' => $tahunAjaranAktif->id,
    //                 'status' => $statusBaru,
    //                 'keterangan' => $statusBaru == 'lulus' ? 'Naik ke kelas 12 (Calon lulusan)' : 'Kenaikan kelas'
    //             ]);

    //             $berhasilDiproses++;
    //         }

    //         DB::commit();

    //         $message = "Kenaikan kelas berhasil diproses untuk {$berhasilDiproses} siswa";
    //         if (!empty($errors)) {
    //             $message .= ". Errors: " . implode(', ', $errors);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => $message,
    //             'processed' => $berhasilDiproses,
    //             'errors' => $errors
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal memproses kenaikan kelas: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function kelulusan()
    // {
    //     // Method terpisah untuk mengelola kelulusan siswa kelas 12
    //     $tahunAjaranAktif = TahunAjaran::aktif()->first();
    //     $siswaKelas12 = Siswa::whereHas('riwayatKelas', function ($query) use ($tahunAjaranAktif) {
    //         $query->where('status', 'lulus')
    //             ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //             ->whereHas('kelas', function ($q) {
    //                 $q->where('tingkat', 12);
    //             });
    //     })->with(['calonSiswa', 'riwayatKelas.kelas'])->get();

    //     // return view('master.kelulusan.index', compact('siswaKelas12'));
    // }

    // public function prosesKelulusan(Request $request)
    // {
    //     $request->validate([
    //         'siswa_ids' => 'required|array|min:1',
    //         'siswa_ids.*' => 'exists:siswa,id'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $tahunAjaranAktif = TahunAjaran::aktif()->first();

    //         foreach ($request->siswa_ids as $siswaId) {
    //             $siswa = Siswa::find($siswaId);

    //             // Update status menjadi lulus
    //             $siswa->riwayatKelas()
    //                 ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //                 ->where('status', 'lulus')
    //                 ->update([
    //                     'status' => 'lulus',
    //                     'keterangan' => 'Telah lulus'
    //                 ]);
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Proses kelulusan berhasil'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal memproses kelulusan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
