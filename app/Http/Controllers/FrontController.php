<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\GeneralProfile;
use App\Models\Kategori;
use App\Models\Komentar;
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

    public function about()
    {
        $profile = GeneralProfile::firstOrFail();
        return view('landing.aboutv2', compact('profile'));
    }
}
