<?php

namespace App\Http\Controllers;

use App\Models\Sitemap;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemaps = Sitemap::orderBy('type')
            ->orderBy('last_modified', 'desc')
            ->paginate(50);

        return view('admin.sitemap.index', compact('sitemaps'));
    }

    public function generate()
    {
        try {
            // Clear existing sitemap entries
            Sitemap::truncate();

            $totalEntries = 0;

            // Add homepage
            Sitemap::create([
                'url' => route('home'),
                'type' => 'static',
                'changefreq' => 'daily',
                'priority' => 1.0,
                'last_modified' => now()
            ]);
            $totalEntries++;

            // Add static pages
            $totalEntries += $this->addStaticPages();

            // Add published articles
            $totalEntries += $this->addArticles();

            // Add active categories
            $totalEntries += $this->addCategories();

            // Add published pages
            $totalEntries += $this->addPages();

            // Clear sitemap cache
            Cache::forget('sitemap_xml');

            Log::info('Sitemap generated successfully', ['total_entries' => $totalEntries]);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sitemap berhasil di-generate.',
                    'total' => $totalEntries
                ]);
            }

            return redirect()->route('admin.sitemap.index')
                ->with('success', "Sitemap berhasil di-generate dengan {$totalEntries} entries.");
        } catch (\Exception $e) {
            Log::error('Error generating sitemap: ' . $e->getMessage());

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat generate sitemap: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Terjadi kesalahan saat generate sitemap: ' . $e->getMessage());
        }
    }

    private function addStaticPages()
    {
        $staticPages = [
            [
                'route' => 'about',
                'changefreq' => 'monthly',
                'priority' => 0.5
            ],
            [
                'route' => 'contact',
                'changefreq' => 'monthly',
                'priority' => 0.5
            ],
            [
                'route' => 'privacy',
                'changefreq' => 'yearly',
                'priority' => 0.3
            ],
            [
                'route' => 'terms',
                'changefreq' => 'yearly',
                'priority' => 0.3
            ]
        ];

        $count = 0;
        foreach ($staticPages as $page) {
            if (Route::has($page['route'])) {
                try {
                    Sitemap::create([
                        'url' => route($page['route']),
                        'type' => 'static',
                        'changefreq' => $page['changefreq'],
                        'priority' => $page['priority'],
                        'last_modified' => now()
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    Log::warning("Could not add static page {$page['route']}: " . $e->getMessage());
                }
            }
        }

        return $count;
    }

    private function addArticles()
    {
        if (!class_exists('App\Models\Artikel')) {
            Log::warning('Artikel model not found, skipping articles');
            return 0;
        }

        $count = 0;
        try {
            Artikel::published()
                ->with('category')
                ->chunk(100, function ($articles) use (&$count) {
                    foreach ($articles as $article) {
                        try {
                            Sitemap::create([
                                'url' => $article->url ?? route('article.show', $article->slug),
                                'type' => 'article',
                                'reference_id' => $article->id,
                                'changefreq' => 'weekly',
                                'priority' => $this->calculateArticlePriority($article),
                                'last_modified' => $article->updated_at
                            ]);
                            $count++;
                        } catch (\Exception $e) {
                            Log::warning("Could not add article {$article->id}: " . $e->getMessage());
                        }
                    }
                });
        } catch (\Exception $e) {
            Log::error('Error adding articles to sitemap: ' . $e->getMessage());
        }

        return $count;
    }

    private function addCategories()
    {
        if (!class_exists('App\Models\Kategori')) {
            Log::warning('Kategori model not found, skipping categories');
            return 0;
        }

        $count = 0;
        try {
            Kategori::active()
                ->whereHas('articles', function ($query) {
                    $query->published();
                })
                ->chunk(50, function ($categories) use (&$count) {
                    foreach ($categories as $category) {
                        try {
                            Sitemap::create([
                                'url' => $category->url ?? route('category.show', $category->slug),
                                'type' => 'category',
                                'reference_id' => $category->id,
                                'changefreq' => 'weekly',
                                'priority' => $this->calculateCategoryPriority($category),
                                'last_modified' => $category->updated_at
                            ]);
                            $count++;
                        } catch (\Exception $e) {
                            Log::warning("Could not add category {$category->id}: " . $e->getMessage());
                        }
                    }
                });
        } catch (\Exception $e) {
            Log::error('Error adding categories to sitemap: ' . $e->getMessage());
        }

        return $count;
    }

    private function addPages()
    {
        if (!class_exists('App\Models\Page')) {
            Log::warning('Page model not found, skipping pages');
            return 0;
        }

        $count = 0;
        try {
            Page::published()
                ->chunk(50, function ($pages) use (&$count) {
                    foreach ($pages as $page) {
                        try {
                            Sitemap::create([
                                'url' => $page->url ?? route('page.show', $page->slug),
                                'type' => 'page',
                                'reference_id' => $page->id,
                                'changefreq' => 'monthly',
                                'priority' => $this->calculatePagePriority($page),
                                'last_modified' => $page->updated_at
                            ]);
                            $count++;
                        } catch (\Exception $e) {
                            Log::warning("Could not add page {$page->id}: " . $e->getMessage());
                        }
                    }
                });
        } catch (\Exception $e) {
            Log::error('Error adding pages to sitemap: ' . $e->getMessage());
        }

        return $count;
    }

    private function calculateArticlePriority($article)
    {
        $priority = 0.6; // Base priority

        // Boost for featured articles
        if (isset($article->is_featured) && $article->is_featured) {
            $priority += 0.2;
        }

        // Boost for recent articles
        if (isset($article->published_at) && $article->published_at->diffInDays(now()) <= 7) {
            $priority += 0.1;
        }

        // Boost for popular articles
        if (isset($article->views_count) && $article->views_count > 1000) {
            $priority += 0.1;
        }

        return min($priority, 1.0); // Cap at 1.0
    }

    private function calculateCategoryPriority($category)
    {
        $priority = 0.5; // Base priority

        // Boost for categories with many articles
        try {
            $articleCount = $category->articles()->published()->count();
            if ($articleCount > 50) {
                $priority += 0.2;
            } elseif ($articleCount > 10) {
                $priority += 0.1;
            }
        } catch (\Exception $e) {
            Log::warning("Could not calculate category priority: " . $e->getMessage());
        }

        return min($priority, 0.9); // Cap at 0.9
    }

    private function calculatePagePriority($page)
    {
        $priority = 0.4; // Base priority

        // Boost for important pages
        $importantPages = ['about', 'contact', 'services'];
        if (isset($page->slug) && in_array($page->slug, $importantPages)) {
            $priority += 0.3;
        }

        return min($priority, 0.8); // Cap at 0.8
    }

    public function xml()
    {
        $sitemaps = Cache::remember('sitemap_xml', 3600, function () {
            return Sitemap::orderBy('priority', 'desc')
                ->orderBy('last_modified', 'desc')
                ->get();
        });

        return response()->view('sitemap.xml', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }

    public function destroy(Sitemap $sitemap)
    {
        try {
            $sitemap->delete();

            // Clear sitemap cache
            Cache::forget('sitemap_xml');

            return redirect()->route('admin.sitemap.index')
                ->with('success', 'Entry sitemap berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting sitemap entry: ' . $e->getMessage());

            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Terjadi kesalahan saat menghapus entry sitemap.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'exists:sitemaps,id'
        ]);

        try {
            $count = count($request->selected);
            Sitemap::whereIn('id', $request->selected)->delete();

            // Clear sitemap cache
            Cache::forget('sitemap_xml');

            return redirect()->route('admin.sitemap.index')
                ->with('success', "{$count} entry sitemap berhasil dihapus.");
        } catch (\Exception $e) {
            Log::error('Error bulk deleting sitemap entries: ' . $e->getMessage());

            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Terjadi kesalahan saat menghapus entry sitemap.');
        }
    }

    public function updatePriority(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sitemaps,id',
            'priority' => 'required|numeric|min:0|max:1'
        ]);

        try {
            $sitemap = Sitemap::findOrFail($request->id);
            $sitemap->update(['priority' => $request->priority]);

            // Clear sitemap cache
            Cache::forget('sitemap_xml');

            return response()->json([
                'success' => true,
                'message' => 'Priority berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating sitemap priority: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui priority.'
            ], 500);
        }
    }

    public function updateChangefreq(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sitemaps,id',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never'
        ]);

        try {
            $sitemap = Sitemap::findOrFail($request->id);
            $sitemap->update(['changefreq' => $request->changefreq]);

            // Clear sitemap cache
            Cache::forget('sitemap_xml');

            return response()->json([
                'success' => true,
                'message' => 'Change frequency berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating sitemap changefreq: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui change frequency.'
            ], 500);
        }
    }

    public function getStats()
    {
        try {
            $stats = [
                'articles' => Sitemap::where('type', 'article')->count(),
                'categories' => Sitemap::where('type', 'category')->count(),
                'pages' => Sitemap::where('type', 'page')->count(),
                'static' => Sitemap::where('type', 'static')->count(),
                'total' => Sitemap::count()
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error getting sitemap stats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil statistik.'
            ], 500);
        }
    }

    public function validateUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->head($request->url, [
                'allow_redirects' => true,
                'timeout' => 10,
                'http_errors' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (compatible; SitemapValidator/1.0)'
                ]
            ]);

            return response()->json([
                'success' => true,
                'status_code' => $response->getStatusCode(),
                'status_text' => $response->getReasonPhrase(),
                'is_valid' => $response->getStatusCode() === 200
            ]);
        } catch (\Exception $e) {
            Log::error('Error validating URL: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error validating URL: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addCustomUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url|unique:sitemaps,url',
            'type' => 'required|in:static,custom',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'priority' => 'required|numeric|min:0|max:1'
        ]);

        try {
            $sitemap = Sitemap::create([
                'url' => $request->url,
                'type' => $request->type,
                'changefreq' => $request->changefreq,
                'priority' => $request->priority,
                'last_modified' => now()
            ]);

            Cache::forget('sitemap_xml');

            return response()->json([
                'success' => true,
                'message' => 'Custom URL berhasil ditambahkan ke sitemap.',
                'data' => $sitemap
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding custom URL: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan URL: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function export()
    // {
    //     try {
    //         // Check if export class exists
    //         if (!class_exists('App\Exports\SitemapExport')) {
    //             throw new \Exception('SitemapExport class not found');
    //         }

    //         return Excel::download(new SitemapExport, 'sitemap-export-' . now()->format('Y-m-d') . '.xlsx');
    //     } catch (\Exception $e) {
    //         Log::error('Error exporting sitemap: ' . $e->getMessage());

    //         return redirect()->route('admin.sitemap.index')
    //             ->with('error', 'Terjadi kesalahan saat mengekspor sitemap.');
    //     }
    // }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx,xls,csv'
    //     ]);

    //     try {
    //         // Check if import class exists
    //         if (!class_exists('App\Imports\SitemapImport')) {
    //             throw new \Exception('SitemapImport class not found');
    //         }

    //         Excel::import(new SitemapImport, $request->file('file'));

    //         Cache::forget('sitemap_xml');

    //         return redirect()->route('admin.sitemap.index')
    //             ->with('success', 'Sitemap berhasil diimpor.');
    //     } catch (\Exception $e) {
    //         Log::error('Error importing sitemap: ' . $e->getMessage());

    //         return redirect()->route('admin.sitemap.index')
    //             ->with('error', 'Terjadi kesalahan saat mengimpor sitemap: ' . $e->getMessage());
    //     }
    // }
}
