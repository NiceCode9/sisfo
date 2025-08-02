<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\GeneralProfile;
use App\Models\Kategori;
use App\Models\Tag;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TahunAjaran;
use App\Models\JadwalPpdb;
use App\Models\JalurPendaftaran;
use App\Models\BiayaPendaftaran;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    private $openaiApiKey;

    public function __construct()
    {
        $this->openaiApiKey = config('services.openai.api_key');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->input('message');

        try {
            // Ambil data terkini dari database
            $contextData = $this->getContextData();

            // Buat prompt dengan context data
            $systemPrompt = $this->buildSystemPrompt($contextData);

            // Tester openrouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openaiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-r1-0528-qwen3-8b:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
            ]);

            $result = $response->json();
            $botReply = $result['choices'][0]['message']['content'];

            return response()->json([
                'success' => true,
                'message' => $botReply
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    private function getContextData()
    {
        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();

        $data = [
            'tahun_ajaran' => null,
            'jadwal_ppdb' => [],
            'jalur_pendaftaran' => [],
            'biaya_pendaftaran' => [],
            'profile_sekolah' => null,
            'artikel' => [
                'terbaru' => [],
                'populer' => [],
                'kategori' => [],
                'tags' => [],
                'statistik' => []
            ],
            'guru' => [
                'daftar_guru' => [],
                'mata_pelajaran' => [],
                'statistik' => []
            ]
        ];

        // Data PPDB (existing code)
        if ($tahunAjaranAktif) {
            $data['tahun_ajaran'] = [
                'nama' => $tahunAjaranAktif->nama_tahun_ajaran,
                'tanggal_mulai' => $tahunAjaranAktif->tanggal_mulai,
                'tanggal_selesai' => $tahunAjaranAktif->tanggal_selesai
            ];

            // Ambil jadwal PPDB
            $jadwalPpdb = JadwalPpdb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->orderBy('tanggal_mulai')
                ->get();

            foreach ($jadwalPpdb as $jadwal) {
                $data['jadwal_ppdb'][] = [
                    'nama' => $jadwal->nama_jadwal,
                    'tanggal_mulai' => $jadwal->tanggal_mulai,
                    'tanggal_selesai' => $jadwal->tanggal_selesai,
                    'keterangan' => $jadwal->keterangan,
                    'status' => $this->getJadwalStatus($jadwal)
                ];
            }

            // Ambil biaya pendaftaran
            $biayaPendaftaran = BiayaPendaftaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

            foreach ($biayaPendaftaran as $biaya) {
                $data['biaya_pendaftaran'][] = [
                    'jenis' => $biaya->jenis_biaya,
                    'jumlah' => $biaya->jumlah,
                    'mata_uang' => $biaya->mata_uang,
                    'wajib_bayar' => $biaya->wajib_bayar,
                    'keterangan' => $biaya->keterangan
                ];
            }
        }

        // Ambil jalur pendaftaran yang aktif
        $jalurPendaftaran = JalurPendaftaran::where('aktif', true)->get();

        foreach ($jalurPendaftaran as $jalur) {
            $data['jalur_pendaftaran'][] = [
                'nama' => $jalur->nama_jalur,
                'deskripsi' => $jalur->deskripsi
            ];
        }

        // Ambil data profil sekolah
        $profileSekolah = GeneralProfile::first();
        if ($profileSekolah) {
            $data['profile_sekolah'] = [
                'nama_sekolah' => $profileSekolah->nama_sekolah,
                'nama_kepsek' => $profileSekolah->nama_kepsek,
                'alamat' => $profileSekolah->alamat,
                'telp' => $profileSekolah->telp,
                'email' => $profileSekolah->email,
                'visi' => $profileSekolah->visi,
                'misi' => $profileSekolah->misi,
                'tahun_berdiri' => $profileSekolah->tahun_berdiri,
                'sosmed' => $profileSekolah->sosmed
            ];
        }

        // Ambil data artikel
        $this->getArtikelData($data);

        // Ambil data guru
        $this->getGuruData($data);

        return $data;
    }

    private function getArtikelData(&$data)
    {
        // Artikel terbaru (5 artikel)
        $artikelTerbaru = Artikel::published()
            ->recent()
            ->limit(5)
            ->get(['title', 'slug', 'excerpt', 'published_at', 'views_count', 'likes_count']);

        foreach ($artikelTerbaru as $artikel) {
            $data['artikel']['terbaru'][] = [
                'title' => $artikel->title,
                'slug' => $artikel->slug,
                'excerpt' => substr($artikel->excerpt, 0, 100) . (strlen($artikel->excerpt) > 100 ? '...' : ''),
                'published_at' => $artikel->published_at->format('d M Y'),
                'views' => $artikel->views_count,
                'likes' => $artikel->likes_count,
                'url' => route('artikel.artikel.show', $artikel->slug)
            ];
        }

        // Artikel paling populer (5 artikel)
        $artikelPopuler = Artikel::published()
            ->popular()
            ->limit(5)
            ->get(['title', 'slug', 'excerpt', 'published_at', 'views_count', 'likes_count']);

        foreach ($artikelPopuler as $artikel) {
            $data['artikel']['populer'][] = [
                'title' => $artikel->title,
                'slug' => $artikel->slug,
                'excerpt' => substr($artikel->excerpt, 0, 100) . (strlen($artikel->excerpt) > 100 ? '...' : ''),
                'published_at' => $artikel->published_at->format('d M Y'),
                'views' => $artikel->views_count,
                'likes' => $artikel->likes_count,
                'url' => route('artikel.artikel.show', $artikel->slug)
            ];
        }

        // Kategori artikel dengan jumlah artikel (menggunakan relasi 'articles' yang benar)
        $kategori = Kategori::active()
            ->withCount(['articles' => function ($query) {
                $query->where('status', 'published')
                    ->where('published_at', '<=', now());
            }])
            ->having('articles_count', '>', 0)
            ->ordered()
            ->get(['name', 'slug', 'description']);

        foreach ($kategori as $kat) {
            $data['artikel']['kategori'][] = [
                'name' => $kat->name,
                'slug' => $kat->slug,
                'description' => $kat->description,
                'artikel_count' => $kat->articles_count
            ];
        }

        // Tags populer (menggunakan relasi 'articles' yang benar)
        $tagList = Tag::active()
            ->withCount(['articles' => function ($query) {
                $query->where('status', 'published')
                    ->where('published_at', '<=', now());
            }])
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->limit(10)
            ->get(['name', 'slug']);

        foreach ($tagList as $tag) {
            $data['artikel']['tags'][] = [
                'name' => $tag->name,
                'slug' => $tag->slug,
                'artikel_count' => $tag->articles_count
            ];
        }

        // Statistik artikel
        $data['artikel']['statistik'] = [
            'total_artikel' => Artikel::published()->count(),
            'total_views' => Artikel::published()->sum('views_count'),
            'total_likes' => Artikel::published()->sum('likes_count'),
            'artikel_featured' => Artikel::published()->featured()->count(),
            'artikel_breaking' => Artikel::published()->breaking()->count(),
            'artikel_bulan_ini' => Artikel::published()
                ->whereMonth('published_at', Carbon::now()->month)
                ->whereYear('published_at', Carbon::now()->year)
                ->count()
        ];
    }

    private function getGuruData(&$data)
    {
        // Ambil daftar guru dengan informasi lengkap
        $daftarGuru = Guru::with(['user', 'mataPelajaran'])
            ->get();

        foreach ($daftarGuru as $guru) {
            $mataPelajaranList = $guru->mataPelajaran->pluck('nama_pelajaran')->toArray();

            $data['guru']['daftar_guru'][] = [
                'nip' => $guru->nip,
                'nama' => $guru->user ? $guru->user->name : 'Tidak tersedia',
                'gelar' => $guru->gelar,
                'bidang_keahlian' => $guru->bidang_keahlian,
                'mata_pelajaran' => $mataPelajaranList,
                'biografi' => $guru->biografi ? substr($guru->biografi, 0, 150) . (strlen($guru->biografi) > 150 ? '...' : '') : null,
                'foto' => $guru->foto_path,
                'telp' => $guru->telp,
                'alamat' => $guru->alamat
            ];
        }

        // Ambil mata pelajaran dengan guru yang mengajar
        $mataPelajaran = MataPelajaran::with(['guru.user'])
            ->get();

        foreach ($mataPelajaran as $mapel) {
            $guruList = [];
            foreach ($mapel->guru as $guru) {
                if ($guru->user) {
                    $guruList[] = [
                        'nama' => $guru->user->name,
                        'gelar' => $guru->gelar,
                        'nip' => $guru->nip,
                        'bidang_keahlian' => $guru->bidang_keahlian
                    ];
                }
            }

            if (!empty($guruList)) {
                $data['guru']['mata_pelajaran'][] = [
                    'nama_pelajaran' => $mapel->nama_pelajaran,
                    'kode_pelajaran' => $mapel->kode_pelajaran ?? null,
                    'deskripsi' => $mapel->deskripsi ?? null,
                    'guru' => $guruList
                ];
            }
        }

        // Statistik guru
        $totalGuru = Guru::count();
        $guruDenganMataPelajaran = Guru::has('mataPelajaran')->count();
        $totalMataPelajaran = MataPelajaran::count();
        $mataPelajaranAktif = MataPelajaran::has('guru')->count();

        // Ambil data tambahan dari GuruMataPelajaran untuk statistik lebih detail
        $totalGuruMataPelajaran = GuruMataPelajaran::count();
        $guruDenganKelas = GuruMataPelajaran::has('guruKelas')->count();

        $data['guru']['statistik'] = [
            'total_guru' => $totalGuru,
            'guru_aktif_mengajar' => $guruDenganMataPelajaran,
            'total_mata_pelajaran' => $totalMataPelajaran,
            'mata_pelajaran_aktif' => $mataPelajaranAktif,
            'total_kombinasi_guru_mapel' => $totalGuruMataPelajaran,
            'guru_dengan_kelas' => $guruDenganKelas
        ];
    }

    private function getJadwalStatus($jadwal)
    {
        $today = Carbon::now()->toDateString();
        $mulai = $jadwal->tanggal_mulai;
        $selesai = $jadwal->tanggal_selesai;

        if ($today < $mulai) {
            return 'belum_dimulai';
        } elseif ($today >= $mulai && $today <= $selesai) {
            return 'sedang_berlangsung';
        } else {
            return 'sudah_selesai';
        }
    }

    private function buildSystemPrompt($contextData)
    {
        $prompt = "Anda adalah asisten virtual untuk SMP Harapan Bangsa. ";
        $prompt .= "Anda dapat membantu menjawab pertanyaan tentang PPDB, profil sekolah, guru, mata pelajaran, dan artikel/berita sekolah. ";
        $prompt .= "Jawab pertanyaan dengan ramah, informatif, dan sesuai dengan data yang tersedia. ";
        $prompt .= "Gunakan bahasa Indonesia yang formal namun tetap bersahabat.\n\n";

        $prompt .= "INFORMASI TERKINI:\n\n";

        // Profil Sekolah
        if ($contextData['profile_sekolah']) {
            $profile = $contextData['profile_sekolah'];
            $prompt .= "PROFIL SEKOLAH:\n";
            $prompt .= "- Nama Sekolah: " . $profile['nama_sekolah'] . "\n";
            $prompt .= "- Kepala Sekolah: " . $profile['nama_kepsek'] . "\n";
            $prompt .= "- Alamat: " . $profile['alamat'] . "\n";
            $prompt .= "- Telepon: " . $profile['telp'] . "\n";
            $prompt .= "- Email: " . $profile['email'] . "\n";
            if ($profile['tahun_berdiri']) {
                $prompt .= "- Tahun Berdiri: " . $profile['tahun_berdiri'] . "\n";
            }
            if ($profile['visi']) {
                $prompt .= "- Visi: " . $profile['visi'] . "\n";
            }
            if (!empty($profile['misi']) && is_array($profile['misi'])) {
                $prompt .= "- Misi:\n";
                foreach ($profile['misi'] as $misi) {
                    $prompt .= "  • " . $misi . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Statistik Guru
        if (!empty($contextData['guru']['statistik'])) {
            $statsGuru = $contextData['guru']['statistik'];
            $prompt .= "STATISTIK GURU:\n";
            $prompt .= "- Total Guru: " . $statsGuru['total_guru'] . " orang\n";
            $prompt .= "- Guru Aktif Mengajar: " . $statsGuru['guru_aktif_mengajar'] . " orang\n";
            $prompt .= "- Total Mata Pelajaran: " . $statsGuru['total_mata_pelajaran'] . " mata pelajaran\n";
            $prompt .= "- Mata Pelajaran Aktif: " . $statsGuru['mata_pelajaran_aktif'] . " mata pelajaran\n";
            if (isset($statsGuru['total_kombinasi_guru_mapel'])) {
                $prompt .= "- Total Kombinasi Guru-Mata Pelajaran: " . $statsGuru['total_kombinasi_guru_mapel'] . "\n";
            }
            if (isset($statsGuru['guru_dengan_kelas'])) {
                $prompt .= "- Guru yang Mengajar di Kelas: " . $statsGuru['guru_dengan_kelas'] . " orang\n";
            }
            $prompt .= "\n";
        }

        // Daftar Guru
        if (!empty($contextData['guru']['daftar_guru'])) {
            $prompt .= "DAFTAR GURU:\n";
            foreach ($contextData['guru']['daftar_guru'] as $guru) {
                $prompt .= "- " . $guru['nama'];
                if ($guru['gelar']) {
                    $prompt .= " (" . $guru['gelar'] . ")";
                }
                $prompt .= "\n";
                if ($guru['nip']) {
                    $prompt .= "  NIP: " . $guru['nip'] . "\n";
                }
                if ($guru['bidang_keahlian']) {
                    $prompt .= "  Bidang Keahlian: " . $guru['bidang_keahlian'] . "\n";
                }
                if (!empty($guru['mata_pelajaran'])) {
                    $prompt .= "  Mata Pelajaran: " . implode(', ', $guru['mata_pelajaran']) . "\n";
                }
                if ($guru['biografi']) {
                    $prompt .= "  Biografi: " . $guru['biografi'] . "\n";
                }
                if ($guru['telp']) {
                    $prompt .= "  Telepon: " . $guru['telp'] . "\n";
                }
                if ($guru['alamat']) {
                    $prompt .= "  Alamat: " . $guru['alamat'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Mata Pelajaran dan Guru Pengajar
        if (!empty($contextData['guru']['mata_pelajaran'])) {
            $prompt .= "MATA PELAJARAN DAN GURU PENGAJAR:\n";
            foreach ($contextData['guru']['mata_pelajaran'] as $mapel) {
                $prompt .= "- " . $mapel['nama_pelajaran'];
                if ($mapel['kode_pelajaran']) {
                    $prompt .= " (" . $mapel['kode_pelajaran'] . ")";
                }
                $prompt .= "\n";

                if ($mapel['deskripsi']) {
                    $prompt .= "  Deskripsi: " . $mapel['deskripsi'] . "\n";
                }

                $prompt .= "  Guru Pengajar: ";
                $guruNames = [];
                foreach ($mapel['guru'] as $guru) {
                    $guruName = $guru['nama'];
                    if ($guru['gelar']) {
                        $guruName .= " (" . $guru['gelar'] . ")";
                    }
                    if ($guru['bidang_keahlian']) {
                        $guruName .= " - " . $guru['bidang_keahlian'];
                    }
                    $guruNames[] = $guruName;
                }
                $prompt .= implode(', ', $guruNames) . "\n";
            }
            $prompt .= "\n";
        }

        // Tahun Ajaran
        if ($contextData['tahun_ajaran']) {
            $prompt .= "TAHUN AJARAN:\n";
            $prompt .= "- Tahun Ajaran: " . $contextData['tahun_ajaran']['nama'] . "\n";
            $prompt .= "- Periode: " . Carbon::parse($contextData['tahun_ajaran']['tanggal_mulai'])->format('d M Y') . " - " . Carbon::parse($contextData['tahun_ajaran']['tanggal_selesai'])->format('d M Y') . "\n\n";
        }

        // Jadwal PPDB
        if (!empty($contextData['jadwal_ppdb'])) {
            $prompt .= "JADWAL PPDB:\n";
            foreach ($contextData['jadwal_ppdb'] as $jadwal) {
                $status = '';
                switch ($jadwal['status']) {
                    case 'belum_dimulai':
                        $status = ' (Belum Dimulai)';
                        break;
                    case 'sedang_berlangsung':
                        $status = ' (Sedang Berlangsung)';
                        break;
                    case 'sudah_selesai':
                        $status = ' (Sudah Selesai)';
                        break;
                }

                $prompt .= "- " . $jadwal['nama'] . ": " . Carbon::parse($jadwal['tanggal_mulai'])->format('d M Y') . " - " . Carbon::parse($jadwal['tanggal_selesai'])->format('d M Y') . $status . "\n";
                if ($jadwal['keterangan']) {
                    $prompt .= "  Keterangan: " . $jadwal['keterangan'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Jalur Pendaftaran
        if (!empty($contextData['jalur_pendaftaran'])) {
            $prompt .= "JALUR PENDAFTARAN:\n";
            foreach ($contextData['jalur_pendaftaran'] as $jalur) {
                $prompt .= "- " . $jalur['nama'] . ": " . $jalur['deskripsi'] . "\n";
            }
            $prompt .= "\n";
        }

        // Biaya Pendaftaran
        if (!empty($contextData['biaya_pendaftaran'])) {
            $prompt .= "BIAYA PENDAFTARAN:\n";
            foreach ($contextData['biaya_pendaftaran'] as $biaya) {
                $prompt .= "- " . $biaya['jenis'] . ": Rp " . number_format($biaya['jumlah'], 0, ',', '.') . "\n";
                if ($biaya['keterangan']) {
                    $prompt .= "  Keterangan: " . $biaya['keterangan'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Statistik Artikel
        if (!empty($contextData['artikel']['statistik'])) {
            $stats = $contextData['artikel']['statistik'];
            $prompt .= "STATISTIK ARTIKEL/BERITA:\n";
            $prompt .= "- Total Artikel: " . $stats['total_artikel'] . " artikel\n";
            $prompt .= "- Total Pembaca: " . number_format($stats['total_views']) . " views\n";
            $prompt .= "- Total Likes: " . number_format($stats['total_likes']) . " likes\n";
            $prompt .= "- Artikel Unggulan: " . $stats['artikel_featured'] . " artikel\n";
            $prompt .= "- Artikel Breaking News: " . $stats['artikel_breaking'] . " artikel\n";
            $prompt .= "- Artikel Bulan Ini: " . $stats['artikel_bulan_ini'] . " artikel\n\n";
        }

        // Kategori Artikel
        if (!empty($contextData['artikel']['kategori'])) {
            $prompt .= "KATEGORI ARTIKEL:\n";
            foreach ($contextData['artikel']['kategori'] as $kategori) {
                $prompt .= "- " . $kategori['name'] . ": " . $kategori['artikel_count'] . " artikel\n";
                if ($kategori['description']) {
                    $prompt .= "  Deskripsi: " . $kategori['description'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Artikel Terbaru
        if (!empty($contextData['artikel']['terbaru'])) {
            $prompt .= "ARTIKEL TERBARU:\n";
            foreach ($contextData['artikel']['terbaru'] as $artikel) {
                $prompt .= "- " . $artikel['title'] . "\n";
                $prompt .= "  Tanggal: " . $artikel['published_at'] . " | Views: " . number_format($artikel['views']) . " | Likes: " . number_format($artikel['likes']) . "\n";
                $prompt .= "  Ringkasan: " . $artikel['excerpt'] . "\n";
                $prompt .= "  Link: " . $artikel['url'] . "\n";
            }
            $prompt .= "\n";
        }

        // Artikel Populer
        if (!empty($contextData['artikel']['populer'])) {
            $prompt .= "ARTIKEL PALING POPULER:\n";
            foreach ($contextData['artikel']['populer'] as $artikel) {
                $prompt .= "- " . $artikel['title'] . "\n";
                $prompt .= "  Tanggal: " . $artikel['published_at'] . " | Views: " . number_format($artikel['views']) . " | Likes: " . number_format($artikel['likes']) . "\n";
                $prompt .= "  Ringkasan: " . $artikel['excerpt'] . "\n";
                $prompt .= "  Link: " . $artikel['url'] . "\n";
            }
            $prompt .= "\n";
        }

        // Tags Populer
        if (!empty($contextData['artikel']['tags'])) {
            $prompt .= "TAG POPULER:\n";
            $tagList = [];
            foreach ($contextData['artikel']['tags'] as $tag) {
                $tagList[] = $tag['name'] . " (" . $tag['artikel_count'] . " artikel)";
            }
            $prompt .= implode(', ', $tagList) . "\n\n";
        }

        // Berkas yang diperlukan
        $prompt .= "BERKAS YANG DIPERLUKAN UNTUK PPDB:\n";
        $prompt .= "- Ijazah atau Surat Keterangan Lulus (SKL)\n";
        $prompt .= "- Kartu Keluarga (KK)\n";
        $prompt .= "- Akta Kelahiran\n";
        $prompt .= "- Pas Foto terbaru\n\n";

        $prompt .= "PANDUAN MENJAWAB:\n";
        $prompt .= "- Jika ditanya tentang informasi yang tidak ada dalam data, jelaskan bahwa informasi tersebut perlu dikonfirmasi langsung ke sekolah\n";
        $prompt .= "- Berikan jawaban yang spesifik berdasarkan data yang tersedia\n";
        $prompt .= "- Jika ada jadwal yang sedang berlangsung, tekankan hal tersebut\n";
        $prompt .= "- Untuk pertanyaan artikel/berita, selalu sertakan link artikel jika relevan\n";
        $prompt .= "- Jika ditanya artikel berdasarkan kategori, sebutkan kategori yang tersedia\n";
        $prompt .= "- Jika ditanya artikel populer atau terbaru, berikan daftar dengan link\n";
        $prompt .= "- Untuk pertanyaan profil sekolah, berikan informasi lengkap sesuai data\n";
        $prompt .= "- Jika ditanya tentang guru, berikan informasi lengkap termasuk mata pelajaran yang diajar\n";
        $prompt .= "- Jika ditanya tentang mata pelajaran tertentu, sebutkan guru yang mengajarnya\n";
        $prompt .= "- Jika ditanya tentang informasi kontak guru, berikan jika tersedia\n";
        $prompt .= "- Selalu akhiri dengan menanyakan apakah ada yang ingin ditanyakan lagi\n";
        $prompt .= "- Maksimal jawaban 400 kata\n";
        $prompt .= "- Jika user menanyakan artikel spesifik berdasarkan judul, cari yang paling mirip dari daftar artikel yang ada";

        return $prompt;
    }
}
