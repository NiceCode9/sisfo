<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\GuruKelas;
use App\Models\Jadwal;
use App\Models\JalurPendaftaran;
use App\Models\KuotaPendaftaran;
use App\Models\Materi;
use App\Models\Pembayaran;
use App\Models\PengumpulanTugas;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun_ajaranId = TahunAjaran::where('status_aktif', true)->value('id');
        $user = Auth::user();
        $role = $user->getRoleNames()->first() ?? 'siswa';

        switch ($role) {
            case 'super-admin':
                // Statistik chart pendaftar per tahun ajaran
                $tahunAjaran = TahunAjaran::orderBy('tanggal_mulai')->get();
                $chartTahunAjaran = $tahunAjaran->map(function ($ta) {
                    return [
                        'label' => $ta->nama_tahun_ajaran,
                        'jumlah' => $ta->calonSiswa()->count(),
                    ];
                });

                // Statistik pendaftar per jalur
                $jalurPendaftaran = JalurPendaftaran::withCount('calonSiswa')->get();
                $chartPendaftarPerJalur = $jalurPendaftaran->map(function ($jalur) {
                    return [
                        'label' => $jalur->nama_jalur,
                        'jumlah' => $jalur->calon_siswa_count,
                    ];
                });

                // Kuota pendaftaran
                $kuotaPendaftaran = KuotaPendaftaran::with('jalurPendaftaran')
                    ->where('tahun_ajaran_id', $tahun_ajaranId)
                    ->get();

                // Statistik pembayaran
                $pembayaranDiterima = Pembayaran::where('status', 'diterima')->count();
                $pembayaranPending = Pembayaran::where('status', 'pending')->count();
                $pembayaranDitolak = Pembayaran::where('status', 'ditolak')->count();
                $totalPembayaranDiterima = Pembayaran::where('status', 'diterima')->sum('jumlah');

                // Pengumuman terbaru
                $pengumumanTerbaru = Pengumuman::where('status_aktif', true)
                    ->orderByDesc('tanggal_pengumuman')
                    ->limit(5)
                    ->get();

                $data = [
                    'totalUser' => User::count(),
                    'totalSiswa' => Siswa::whereHas('riwayatKelas', function ($query) {
                        $query->where('status', 'aktif')
                            ->whereHas('tahunAjaran', function ($q) {
                                $q->where('status_aktif', true);
                            });
                    })->count(),
                    'totalGuru' => Guru::count(),
                    'totalCasis' => CalonSiswa::where('tahun_ajaran_id', $tahun_ajaranId)->count(),
                    'tahunAkademis' => TahunAjaran::where('status_aktif', true)->value('nama_tahun_ajaran'),
                    'totalKuota' => $kuotaPendaftaran->sum('kuota'),
                    'totalTerisi' => $kuotaPendaftaran->sum('terisi'),
                    'chartTahunAjaran' => $chartTahunAjaran,
                    'chartPendaftarPerJalur' => $chartPendaftarPerJalur,
                    'kuotaPendaftaran' => $kuotaPendaftaran,
                    'pembayaranDiterima' => $pembayaranDiterima,
                    'pembayaranPending' => $pembayaranPending,
                    'pembayaranDitolak' => $pembayaranDitolak,
                    'totalPembayaranDiterima' => $totalPembayaranDiterima,
                    'pengumumanTerbaru' => $pengumumanTerbaru,
                ];
                return view('dashboard.dashboard_superadmin', $data);
            case 'guru':
                $guru = $user->guru;
                // Ambil tahun ajaran aktif
                $tahunAjaranAktif = TahunAjaran::aktif()->first();

                // Get dashboard statistics
                $stats = $this->getDashboardStats($guru, $tahunAjaranAktif);

                // Get kelas yang diajar
                $kelasYangDiajar = $this->getKelasYangDiajar($guru, $tahunAjaranAktif);

                // Get tugas terbaru
                $tugasTerbaru = $this->getTugasTerbaru($guru, $tahunAjaranAktif);

                // Get aktivitas terbaru
                $aktivitasTerbaru = $this->getAktivitasTerbaru($guru, $tahunAjaranAktif);

                return view('dashboard.dashboard_guru', compact(
                    'guru',
                    'tahunAjaranAktif',
                    'stats',
                    'kelasYangDiajar',
                    'tugasTerbaru',
                    'aktivitasTerbaru'
                ));
            case 'siswa':
                $tahunAjaranAktif = TahunAjaran::aktif()->first();
                $siswa = $user->siswa;

                if (!$siswa || !$tahunAjaranAktif) {
                    return redirect()->back()->with('error', 'Data siswa atau tahun ajaran tidak ditemukan');
                }

                // Ambil kelas aktif siswa
                $kelasAktif = $siswa->kelasAktif($tahunAjaranAktif->id);
                // dd($kelasAktif);

                if (!$kelasAktif) {
                    return view('dashboard.dashboard_siswa', [
                        'siswa' => $siswa,
                        'tahunAjaran' => $tahunAjaranAktif,
                        'kelasAktif' => null,
                        'jadwalHariIni' => collect(),
                        'tugasTerbaru' => collect(),
                        'materiTerbaru' => collect(),
                        'pengumuman' => collect(),
                        'statistik' => [
                            'total_tugas' => 0,
                            'tugas_selesai' => 0,
                            'tugas_pending' => 0,
                            'rata_nilai' => 0
                        ]
                    ]);
                }

                // Ambil jadwal hari ini
                $hariIni = Carbon::now()->locale('id')->dayName;
                $jadwalHariIni = Jadwal::whereHas('guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                    $query->where('kelas_id', $kelasAktif->kelas_id)
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('aktif', true);
                })
                    ->where('hari', $hariIni)
                    ->with(['guruKelas.guruMataPelajaran.guru', 'guruKelas.guruMataPelajaran.mataPelajaran'])
                    ->orderBy('jam_mulai')
                    ->get();

                // Ambil tugas terbaru dan belum dikerjakan
                $tugasTerbaru = Tugas::whereHas('guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                    $query->where('kelas_id', $kelasAktif->kelas_id)
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('aktif', true);
                })
                    ->aktif()
                    ->with(['guruKelas.guruMataPelajaran.guru', 'guruKelas.guruMataPelajaran.mataPelajaran'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                // Ambil materi terbaru
                $materiTerbaru = Materi::whereHas('guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                    $query->where('kelas_id', $kelasAktif->kelas_id)
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('aktif', true);
                })
                    ->published()
                    ->with(['guruKelas.guruMataPelajaran.guru', 'guruKelas.guruMataPelajaran.mataPelajaran'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                // Ambil pengumuman terbaru
                $pengumuman = Pengumuman::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->where('status_aktif', true)
                    ->orderBy('tanggal_pengumuman', 'desc')
                    ->limit(3)
                    ->get();

                // Statistik tugas
                $totalTugas = Tugas::whereHas('guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                    $query->where('kelas_id', $kelasAktif->kelas_id)
                        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('aktif', true);
                })->aktif()->count();

                $tugasSelesai = PengumpulanTugas::where('siswa_id', $siswa->id)
                    ->whereHas('tugas.guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                        $query->where('kelas_id', $kelasAktif->kelas_id)
                            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                            ->where('aktif', true);
                    })->count();

                $tugasPending = $totalTugas - $tugasSelesai;

                // Rata-rata nilai
                $rataNilai = PengumpulanTugas::where('siswa_id', $siswa->id)
                    ->whereHas('tugas.guruKelas', function ($query) use ($kelasAktif, $tahunAjaranAktif) {
                        $query->where('kelas_id', $kelasAktif->kelas_id)
                            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                            ->where('aktif', true);
                    })
                    ->whereNotNull('nilai')
                    ->avg('nilai') ?? 0;

                $statistik = [
                    'total_tugas' => $totalTugas,
                    'tugas_selesai' => $tugasSelesai,
                    'tugas_pending' => $tugasPending,
                    'rata_nilai' => round($rataNilai, 2)
                ];

                return view('dashboard.dashboard_siswa', compact(
                    'siswa',
                    'tahunAjaranAktif',
                    'kelasAktif',
                    'jadwalHariIni',
                    'tugasTerbaru',
                    'materiTerbaru',
                    'pengumuman',
                    'statistik'
                ));
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

    /**
     * Get dashboard statistics for the guru
     *
     * @param Guru $guru
     * @param TahunAjaran $tahunAjaran
     * @return array
     */
    private function getDashboardStats(Guru $guru, TahunAjaran $tahunAjaran)
    {
        // Total kelas yang diajar
        $totalKelas = GuruKelas::whereHas('guruMataPelajaran', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->where('aktif', true)
            ->distinct('kelas_id')
            ->count();

        // Total siswa dari semua kelas yang diajar
        $totalSiswa = DB::table('siswa')
            ->join('riwayat_kelas', 'siswa.id', '=', 'riwayat_kelas.siswa_id')
            ->join('guru_kelas', 'riwayat_kelas.kelas_id', '=', 'guru_kelas.kelas_id')
            ->join('guru_mata_pelajaran', 'guru_kelas.guru_mata_pelajaran_id', '=', 'guru_mata_pelajaran.id')
            ->where('guru_mata_pelajaran.guru_id', $guru->id)
            ->where('guru_kelas.tahun_ajaran_id', $tahunAjaran->id)
            ->where('guru_kelas.aktif', true)
            ->where('riwayat_kelas.status', 'aktif')
            ->where('riwayat_kelas.tahun_ajaran_id', $tahunAjaran->id)
            ->distinct('siswa.id')
            ->count();

        // Total materi aktif
        $totalMateri = Materi::whereHas('guruKelas', function ($query) use ($guru, $tahunAjaran) {
            $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('aktif', true);
        })
            ->where('diterbitkan', true)
            ->count();

        // Total tugas aktif
        $totalTugasAktif = Tugas::whereHas('guruKelas', function ($query) use ($guru, $tahunAjaran) {
            $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('aktif', true);
        })
            ->where('aktif', true)
            ->where('batas_waktu', '>', now())
            ->count();

        return [
            'total_kelas' => $totalKelas,
            'total_siswa' => $totalSiswa,
            'total_materi' => $totalMateri,
            'total_tugas_aktif' => $totalTugasAktif
        ];
    }

    /**
     * Get kelas yang diajar by the guru
     *
     * @param Guru $guru
     * @param TahunAjaran $tahunAjaran
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getKelasYangDiajar(Guru $guru, TahunAjaran $tahunAjaran)
    {
        return GuruKelas::with([
            'kelas',
            'guruMataPelajaran.mataPelajaran',
            'jadwal' => function ($query) {
                $query->orderBy('hari')->orderBy('jam_mulai');
            }
        ])
            ->whereHas('guruMataPelajaran', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->where('aktif', true)
            ->get()
            ->map(function ($guruKelas) {
                // Count active students in this class
                $jumlahSiswa = DB::table('riwayat_kelas')
                    ->where('kelas_id', $guruKelas->kelas_id)
                    ->where('tahun_ajaran_id', $guruKelas->tahun_ajaran_id)
                    ->where('status', 'aktif')
                    ->count();

                // Get first schedule for display
                $jadwalPertama = $guruKelas->jadwal->first();

                return [
                    'id' => $guruKelas->id,
                    'nama_kelas' => $guruKelas->kelas->nama_kelas,
                    'tingkat' => $guruKelas->kelas->tingkat,
                    'jurusan' => $guruKelas->kelas->jurusan,
                    'mata_pelajaran' => $guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran,
                    'jumlah_siswa' => $jumlahSiswa,
                    'jadwal' => $jadwalPertama ? [
                        'hari' => $jadwalPertama->hari,
                        'jam_mulai' => $jadwalPertama->jam_mulai->format('H:i'),
                        'jam_selesai' => $jadwalPertama->jam_selesai->format('H:i'),
                        'ruangan' => $jadwalPertama->ruangan
                    ] : null
                ];
            });
    }

    private function getTugasTerbaru(Guru $guru, TahunAjaran $tahunAjaran)
    {
        return Tugas::with([
            'guruKelas.kelas',
            'guruKelas.guruMataPelajaran.mataPelajaran',
            'pengumpulanTugas'
        ])
            ->whereHas('guruKelas', function ($query) use ($guru, $tahunAjaran) {
                $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })
                    ->where('tahun_ajaran_id', $tahunAjaran->id)
                    ->where('aktif', true);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($tugas) {
                // Count total students in class
                $totalSiswa = DB::table('riwayat_kelas')
                    ->where('kelas_id', $tugas->guruKelas->kelas_id)
                    ->where('tahun_ajaran_id', $tugas->guruKelas->tahun_ajaran_id)
                    ->where('status', 'aktif')
                    ->count();

                // Count submissions
                $totalPengumpulan = $tugas->pengumpulanTugas->count();

                // Determine status
                $status = 'aktif';
                if (!$tugas->aktif) {
                    $status = 'nonaktif';
                } elseif ($tugas->tanggal_terbit && $tugas->tanggal_terbit > now()) {
                    $status = 'belum_terbit';
                } elseif ($tugas->batas_waktu < now()) {
                    $status = 'expired';
                }

                return [
                    'id' => $tugas->id,
                    'judul' => $tugas->judul,
                    'nama_kelas' => $tugas->guruKelas->kelas->nama_kelas,
                    'mata_pelajaran' => $tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran,
                    'batas_waktu' => $tugas->batas_waktu,
                    'total_siswa' => $totalSiswa,
                    'total_pengumpulan' => $totalPengumpulan,
                    'persentase_pengumpulan' => $totalSiswa > 0 ? round(($totalPengumpulan / $totalSiswa) * 100) : 0,
                    'status' => $status,
                    'jenis' => $tugas->jenis,
                    'total_nilai' => $tugas->total_nilai
                ];
            });
    }

    private function getAktivitasTerbaru(Guru $guru, TahunAjaran $tahunAjaran)
    {
        $aktivitas = collect();

        // Recent tugas created
        $tugasTerbaru = Tugas::with(['guruKelas.kelas', 'guruKelas.guruMataPelajaran.mataPelajaran'])
            ->whereHas('guruKelas', function ($query) use ($guru, $tahunAjaran) {
                $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })
                    ->where('tahun_ajaran_id', $tahunAjaran->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($tugasTerbaru as $tugas) {
            $aktivitas->push([
                'type' => 'tugas_created',
                'title' => 'Tugas Baru Dibuat',
                'description' => "Tugas \"{$tugas->judul}\" untuk kelas {$tugas->guruKelas->kelas->nama_kelas}",
                'timestamp' => $tugas->created_at,
                'icon' => 'clipboard-plus'
            ]);
        }

        // Recent materi published
        $materiTerbaru = Materi::with(['guruKelas.kelas', 'guruKelas.guruMataPelajaran.mataPelajaran'])
            ->whereHas('guruKelas', function ($query) use ($guru, $tahunAjaran) {
                $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })
                    ->where('tahun_ajaran_id', $tahunAjaran->id);
            })
            ->where('diterbitkan', true)
            ->orderBy('tanggal_terbit', 'desc')
            ->limit(2)
            ->get();

        foreach ($materiTerbaru as $materi) {
            $aktivitas->push([
                'type' => 'materi_published',
                'title' => 'Materi Diterbitkan',
                'description' => "Materi \"{$materi->judul}\" untuk kelas {$materi->guruKelas->kelas->nama_kelas}",
                'timestamp' => $materi->tanggal_terbit,
                'icon' => 'journal-text'
            ]);
        }

        // Recent submissions
        $pengumpulanTerbaru = PengumpulanTugas::with(['tugas.guruKelas.kelas', 'siswa.calonSiswa'])
            ->whereHas('tugas.guruKelas', function ($query) use ($guru, $tahunAjaran) {
                $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })
                    ->where('tahun_ajaran_id', $tahunAjaran->id);
            })
            ->orderBy('waktu_pengumpulan', 'desc')
            ->limit(2)
            ->get();

        foreach ($pengumpulanTerbaru as $pengumpulan) {
            $aktivitas->push([
                'type' => 'assignment_submitted',
                'title' => 'Pengumpulan Tugas',
                'description' => "Tugas \"{$pengumpulan->tugas->judul}\" dikumpulkan oleh {$pengumpulan->siswa->calonSiswa->nama_lengkap}",
                'timestamp' => $pengumpulan->waktu_pengumpulan,
                'icon' => 'file-earmark-check'
            ]);
        }

        // Sort by timestamp and limit
        return $aktivitas->sortByDesc('timestamp')->take(6)->values()->all();
    }

    public function getKelasDetail(Request $request, $guruKelasId)
    {
        $guru = Auth::user()->guru;

        $guruKelas = GuruKelas::with([
            'kelas',
            'guruMataPelajaran.mataPelajaran',
            'tahunAjaran',
            'jadwal'
        ])
            ->whereHas('guruMataPelajaran', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->where('id', $guruKelasId)
            ->where('aktif', true)
            ->firstOrFail();

        // Get students in this class
        $siswa = DB::table('siswa')
            ->join('calon_siswa', 'siswa.calon_siswa_id', '=', 'calon_siswa.id')
            ->join('riwayat_kelas', 'siswa.id', '=', 'riwayat_kelas.siswa_id')
            ->where('riwayat_kelas.kelas_id', $guruKelas->kelas_id)
            ->where('riwayat_kelas.tahun_ajaran_id', $guruKelas->tahun_ajaran_id)
            ->where('riwayat_kelas.status', 'aktif')
            ->select('siswa.*', 'calon_siswa.nama_lengkap', 'calon_siswa.email')
            ->get();

        return response()->json([
            'guru_kelas' => $guruKelas,
            'siswa' => $siswa,
            'total_siswa' => $siswa->count()
        ]);
    }

    public function getChartData(Request $request)
    {
        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->first();

        // Get monthly assignment submissions
        $monthlySubmissions = PengumpulanTugas::whereHas('tugas.guruKelas', function ($query) use ($guru, $tahunAjaran) {
            $query->whereHas('guruMataPelajaran', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
                ->where('tahun_ajaran_id', $tahunAjaran->id);
        })
            ->whereYear('waktu_pengumpulan', now()->year)
            ->selectRaw('MONTH(waktu_pengumpulan) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlySubmissions->get($i, 0);
        }

        return response()->json([
            'monthly_submissions' => $chartData,
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }
}
