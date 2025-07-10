<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun_ajaranId = TahunAjaran::where('status_aktif', true)->value('id');
        $user = auth()->user();
        $role = $user->getRoleNames()->first() ?? 'siswa';

        switch ($role) {
            case 'super-admin':
                // Statistik chart pendaftar per tahun ajaran
                $tahunAjaran = \App\Models\TahunAjaran::orderBy('tanggal_mulai')->get();
                $chartTahunAjaran = $tahunAjaran->map(function ($ta) {
                    return [
                        'label' => $ta->nama_tahun_ajaran,
                        'jumlah' => $ta->calonSiswa()->count(),
                    ];
                });
                $data = [
                    'totalUser' => User::count(),
                    'totalSiswa' => Siswa::whereHas('riwayatKelas', function ($query) {
                        $query->where('status', 'aktif')
                            ->whereHas('tahunAjaran', function ($q) {
                                $q->where('status_aktif', true);
                            });
                    })->count(),
                    'totalGuru' => Guru::count(),
                    'chartTahunAjaran' => $chartTahunAjaran,
                ];
                return view('dashboard.dashboard_superadmin', $data);
            case 'guru':
                $guru = $user->guru;
                $hariIni = now()->isoFormat('dddd');
                $jadwalHariIni = [];
                $jumlahKelas = 0;
                $tugasPerluDiperiksa = 0;
                if ($guru) {
                    // Ambil semua kelas yang diampu
                    $kelasIds = $guru->guruKelas->pluck('kelas_id');
                    $jumlahKelas = $kelasIds->unique()->count();
                    // Jadwal hari ini
                    $jadwal = Jadwal::whereIn('guru_kelas_id', $guru->guruKelas->pluck('id'))
                        ->where('hari', $hariIni)
                        ->get();
                    foreach ($jadwal as $j) {
                        $jadwalHariIni[] = $j->jam_mulai . ' - ' . $j->jam_selesai . ' ' . ($j->guruKelas->kelas->nama_kelas ?? '-');
                    }
                    // Tugas perlu diperiksa (tugas yang ada pengumpulan belum dinilai)
                    $tugasIds = $guru->guruKelas->flatMap->tugas->pluck('id');
                    $tugasPerluDiperiksa = \App\Models\PengumpulanTugas::whereIn('tugas_id', $tugasIds)
                        ->whereNull('nilai')->count();
                }
                $data = [
                    'jadwalHariIni' => $jadwalHariIni,
                    'jumlahKelas' => $jumlahKelas,
                    'tugasPerluDiperiksa' => $tugasPerluDiperiksa,
                ];
                return view('dashboard.dashboard_guru', $data);
            case 'siswa':
            default:
                $siswa = $user->siswa;
                $jadwalHariIni = [];
                $statusPembayaran = '-';
                $pengumumanTerbaru = [];
                if ($siswa) {
                    $hariIni = now()->isoFormat('dddd');
                    $kelasAktif = $siswa->kelasAktif();
                    if ($kelasAktif) {
                        $jadwal = Jadwal::whereHas('guruKelas', function ($q) use ($kelasAktif) {
                            $q->where('kelas_id', $kelasAktif->kelas_id);
                        })->where('hari', $hariIni)->get();
                        foreach ($jadwal as $j) {
                            $jadwalHariIni[] = $j->jam_mulai . ' - ' . $j->jam_selesai . ' ' . ($j->guruKelas->kelas->nama_kelas ?? '-');
                        }
                    }
                    // Status pembayaran
                    $pembayaran = Pembayaran::where('calon_siswa_id', $siswa->calon_siswa_id)->latest('tanggal_pembayaran')->first();
                    $statusPembayaran = $pembayaran->status ?? '-';
                }
                // Pengumuman terbaru
                $pengumumanTerbaru = Pengumuman::where('status_aktif', true)->orderByDesc('tanggal_pengumuman')->limit(5)->pluck('judul')->toArray();
                $data = [
                    'jadwalHariIni' => $jadwalHariIni,
                    'statusPembayaran' => $statusPembayaran,
                    'pengumumanTerbaru' => $pengumumanTerbaru,
                ];
                return view('dashboard.dashboard_siswa', $data);
        }
    }
}
