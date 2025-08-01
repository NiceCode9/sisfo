<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\GeneralProfile;
use App\Models\Guru;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function pendaftaran()
    {
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();
        $jalurPendaftarans = \App\Models\JalurPendaftaran::where('aktif', true)
            ->with(['kuotaPendaftaran' => function ($query) use ($tahunAjaranAktif) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            }])
            ->get();

        // Get PPDB schedules
        $jadwalPpdb = \App\Models\JadwalPpdb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->orderBy('tanggal_mulai')
            ->get();

        return view('landing.pendaftaran', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'jalurPendaftarans' => $jalurPendaftarans,
            'jadwalPpdb' => $jadwalPpdb
        ]);
    }

    public function artikel(Request $request)
    {
        // Get all categories for filter
        $categories = Kategori::all();

        // Get sorting option
        $sort = $request->get('sort', 'latest');

        // Base query
        $query = Artikel::published()
            ->with(['category', 'author', 'tags'])
            ->withCount('comments');

        // Search filter
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Tag filter
        if ($request->has('tag')) {
            $query->byTag($request->tag);
        }

        // Sorting
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default: // latest
                $query->recent();
                break;
        }

        // Get featured articles (only if no search or category filter)
        $featuredArticles = collect();
        if (!$request->has('search') && !$request->has('category') && !$request->has('tag')) {
            $featuredArticles = Artikel::published()
                ->featured()
                ->recent()
                ->limit(2)
                ->get();
        }

        // Get popular articles for sidebar
        $popularArticles = Artikel::published()
            ->popular()
            ->limit(5)
            ->get();

        // Paginate results
        $articles = $query->paginate(9);

        return view('landing.artikel.indexv2', [
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'popularArticles' => $popularArticles,
            'categories' => $categories,
        ]);
    }

    public function showArtikel($slug)
    {
        // Get the article with relationships
        $article = Artikel::published()
            ->with(['category', 'author', 'tags', 'approvedComments', 'relatedArticles'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $article->incrementViews();

        // Get popular articles for sidebar
        $popularArticles = Artikel::published()
            ->where('id', '!=', $article->id)
            ->popular()
            ->limit(5)
            ->get();

        // Generate SEO data if not exists
        if (empty($article->schema_data)) {
            $article->schema_data = $article->generateSchemaMarkup();
        }

        if (empty($article->og_data)) {
            $article->og_data = $article->generateOgData();
        }

        // Update SEO score
        $article->updateSeoScore();

        return view('landing.artikel.showv2', [
            'article' => $article,
            'popularArticles' => $popularArticles,
        ]);
    }

    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'content' => 'required|string|min:5|max:1000',
            'parent_id' => 'nullable|exists:komentar,id' // Tambahkan validasi untuk parent_id
        ]);

        $article = Artikel::where('slug', $slug)->firstOrFail();

        $comment = new Komentar([
            'article_id' => $article->id,
            'parent_id' => $request->parent_id, // Tambahkan parent_id jika ada
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'author_website' => $request->author_website,
            'content' => $request->content,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'status' => 'pending',
        ]);

        $comment->save();

        // Update comment count on article
        $article->increment('comments_count');

        return redirect()->to(url()->previous() . '#comments')->with('success', 'Komentar Anda telah berhasil dikirim dan menunggu persetujuan.');
    }

    public function aboutUs()
    {
        $profile = GeneralProfile::first();
        $guruCount = Guru::count();
        $siswaCount = Siswa::whereHas('riwayatKelas', function ($query) {
            $query->where('tahun_ajaran_id', TahunAjaran::aktif()->first()->value('id'))->where('status', 'aktif');
        })->count();

        return view('landing.aboutv2', compact('profile', 'guruCount', 'siswaCount'));
    }

    public function guru()
    {
        $gurus = Guru::with(['user', 'mataPelajaran'])
            ->whereHas('user') // Only show gurus with user accounts
            ->orderBy('created_at', 'desc')
            ->get();

        // Add some statistics
        $stats = [
            'total_guru' => $gurus->count(),
            'guru_s1' => $gurus->filter(function ($guru) {
                return strpos(strtolower($guru->gelar ?? ''), 's.pd') !== false ||
                    strpos(strtolower($guru->gelar ?? ''), 's1') !== false;
            })->count(),
            'guru_s2' => $gurus->filter(function ($guru) {
                return strpos(strtolower($guru->gelar ?? ''), 'm.pd') !== false ||
                    strpos(strtolower($guru->gelar ?? ''), 's2') !== false;
            })->count(),
        ];

        return view('landing.guru', compact('gurus', 'stats'));
    }

    public function showGuru($id)
    {
        $guru = Guru::with(['user', 'mataPelajaran'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $guru->id,
                'nama' => $guru->user->name ?? 'Nama tidak tersedia',
                'nip' => $guru->nip,
                'biografi' => $guru->biografi,
                'bidang_keahlian' => $guru->bidang_keahlian,
                'alamat' => $guru->alamat,
                'gelar' => $guru->gelar,
                'telp' => $guru->telp,
                'foto' => $guru->foto_path ? asset('storage/' . $guru->foto_path) : asset('images/default-avatar.png'),
                'mata_pelajaran' => $guru->mataPelajaran->map(function ($mp) {
                    return [
                        'id' => $mp->id,
                        'nama' => $mp->nama,
                        'icon' => $this->getMataPelajaranIcon($mp->nama)
                    ];
                })->toArray(),
                'kelas_yang_diajar' => $guru->kelasYangDiajar()->pluck('nama')->toArray()
            ]
        ]);
    }

    /**
     * Search gurus based on query
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $gurus = Guru::with(['user', 'mataPelajaran'])
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhere('bidang_keahlian', 'like', '%' . $query . '%')
            ->orWhere('gelar', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $gurus->map(function ($guru) {
                return [
                    'id' => $guru->id,
                    'nama' => $guru->user->name ?? 'Nama tidak tersedia',
                    'gelar' => $guru->gelar,
                    'bidang_keahlian' => $guru->bidang_keahlian,
                    'foto' => $guru->foto_path ? asset('storage/' . $guru->foto_path) : asset('images/default-avatar.png'),
                    'biografi_preview' => \Str::limit($guru->biografi, 80)
                ];
            })
        ]);
    }

    /**
     * Get icon for mata pelajaran
     */
    private function getMataPelajaranIcon($nama)
    {
        $icons = [
            'matematika' => 'fas fa-calculator',
            'bahasa indonesia' => 'fas fa-book',
            'bahasa inggris' => 'fas fa-globe',
            'ipa' => 'fas fa-flask',
            'ips' => 'fas fa-map',
            'fisika' => 'fas fa-atom',
            'kimia' => 'fas fa-vial',
            'biologi' => 'fas fa-seedling',
            'sejarah' => 'fas fa-landmark',
            'geografi' => 'fas fa-mountain',
            'ekonomi' => 'fas fa-chart-line',
            'sosiologi' => 'fas fa-users',
            'pkn' => 'fas fa-flag',
            'agama' => 'fas fa-pray',
            'seni budaya' => 'fas fa-palette',
            'olahraga' => 'fas fa-running',
            'tik' => 'fas fa-laptop',
            'prakarya' => 'fas fa-tools',
        ];

        $namaLower = strtolower($nama);

        foreach ($icons as $subject => $icon) {
            if (strpos($namaLower, $subject) !== false) {
                return $icon;
            }
        }

        return 'fas fa-book'; // default icon
    }
}
