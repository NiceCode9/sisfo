<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $tag = Tag::first();
        // dd($tag->is_active, $tag->getOriginal('is_active'));
        if ($request->ajax()) {
            $tags = Tag::select(['id', 'name', 'slug', 'description', 'is_active', 'created_at']);

            return DataTables::of($tags)
                ->addColumn('status', function ($tag) {
                    return $tag->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('articles_count', function ($tag) {
                    return $tag->articles()->count();
                })
                ->addColumn('action', function ($tag) {
                    $editBtn = '<button class="btn btn-sm btn-primary edit-btn" data-id="' . $tag->id . '"><i class="fas fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $tag->id . '"><i class="fas fa-trash"></i></button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->editColumn('created_at', function ($tag) {
                    return $tag->created_at->format('d M Y H:i');
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('artikel.tag.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tags' => 'required|array|min:1',
            'tags.*.name' => 'required|string|max:255|unique:tags,name',
            'tags.*.description' => 'nullable|string',
            'tags.*.meta_title' => 'nullable|string|max:255',
            'tags.*.meta_description' => 'nullable|string',
            'tags.*.is_active' => 'nullable|boolean'
        ]);

        $createdTags = [];

        foreach ($request->tags as $tagData) {
            $tag = Tag::create([
                'name' => $tagData['name'],
                'description' => $tagData['description'] ?? null,
                'meta_title' => $tagData['meta_title'] ?? null,
                'meta_description' => $tagData['meta_description'] ?? null,
                'is_active' => isset($tagData['is_active']) ? (bool)$tagData['is_active'] : false
            ]);

            $createdTags[] = $tag;
        }

        return response()->json([
            'success' => true,
            'message' => count($createdTags) . ' tag(s) berhasil dibuat',
            'data' => $createdTags
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : false
        ];

        $tag->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil diperbarui',
            'data' => $tag
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Check if tag has articles
        if ($tag->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tag tidak dapat dihapus karena masih memiliki artikel'
            ], 400);
        }

        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil dihapus'
        ]);
    }
}
