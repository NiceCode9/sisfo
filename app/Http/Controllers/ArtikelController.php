<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Sitemap;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Artikel::with(['category', 'author', 'tags']);

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Kategori::active()->get();

        return view('artikel.artikel.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Kategori::active()->get();
        $tags = Tag::active()->get();

        return view('artikel.artikel.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:kategori,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url'
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('articles', $imageName, 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set published_at if status is published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        $artikel = Artikel::create($data);

        // Attach tags
        if ($request->has('tags')) {
            $artikel->tags()->attach($request->tags);
        }

        // Update SEO score
        $artikel->updateSeoScore();

        // Update sitemap
        $this->updateSitemap($artikel);

        return redirect()->route('artikel.artikel.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        $artikel->load(['category', 'author', 'tags', 'comments']);
        return view('artikel.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        $categories = Kategori::active()->get();
        $tags = Tag::active()->get();
        $selectedTags = $artikel->tags->pluck('id')->toArray();

        return view('artikel.artikel.edit', compact('artikel', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:kategori,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->title);

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image
                if ($artikel->featured_image) {
                    Storage::disk('public')->delete($artikel->featured_image);
                }

                $image = $request->file('featured_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('articles', $imageName, 'public');
                $data['featured_image'] = $imagePath;
            }

            // Set published_at if status is published and not set before
            if ($request->status === 'published' && !$artikel->published_at) {
                $data['published_at'] = now();
            }

            $artikel->slug = null;
            $artikel->update($data);

            // Sync tags
            if ($request->has('tags')) {
                $artikel->tags()->sync($request->tags);
            } else {
                $artikel->tags()->detach();
            }

            // Update SEO score
            $artikel->updateSeoScore();

            // Update sitemap
            $this->updateSitemap($artikel);

            DB::commit();
            return redirect()->route('artikel.artikel.index')
                ->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('artikel.artikel.index')
                ->with('error', 'Artikel gagal diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        // Delete featured image
        if ($artikel->featured_image) {
            Storage::disk('public')->delete($artikel->featured_image);
        }

        // Remove from sitemap
        $this->removeSitemap($artikel);

        $artikel->delete();

        return redirect()->route('artikel.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function toggleStatus(Artikel $artikel)
    {
        $newStatus = $artikel->status == 'published' ? 'draft' : 'published';

        $artikel->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : null
        ]);

        // Update sitemap
        $this->updateSitemap($artikel);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => "Status artikel berhasil diubah menjadi {$newStatus}"
        ]);
    }

    public function getKomentar(Artikel $artikel, Request $request)
    {
        $comments = $artikel->comments();

        if ($request->filled('search')) {
            $comments->whereAny(
                [
                    'content',
                    'author_name',
                    'author_email',
                ],
                'LIKE',
                "%" . $request->search . "%"
            );
        }

        if ($request->filled('status')) {
            $comments->where('status', $request->status);
        }

        $comments->orderBy('created_at', 'DESC');
        $comments = $comments->get();

        return view('artikel.artikel.show_komentar', compact('comments'));
    }

    private function updateSitemap(Artikel $artikel)
    {
        if ($artikel->status === 'published') {
            Sitemap::updateOrCreate(
                [
                    'type' => 'article',
                    'reference_id' => $artikel->id
                ],
                [
                    'url' => $artikel->url,
                    'changefreq' => 'weekly',
                    'priority' => 0.8,
                    'last_modified' => $artikel->updated_at
                ]
            );
        } else {
            $this->removeSitemap($artikel);
        }
    }

    private function removeSitemap(Artikel $artikel)
    {
        Sitemap::where('type', 'article')
            ->where('reference_id', $artikel->id)
            ->delete();
    }
}
