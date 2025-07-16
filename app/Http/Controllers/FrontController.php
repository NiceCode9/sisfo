<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
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

        return view('landing.artikel.index', [
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
            ->with(['category', 'author', 'tags', 'approvedComments.user', 'relatedArticles'])
            ->where('slug', $slug)
            ->firstOrFail();
        // dd($article->og_data);

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

        return view('landing.artikel.show', [
            'article' => $article,
            'popularArticles' => $popularArticles,
        ]);
    }
}
