<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentApproved;
use App\Mail\CommentRejected;

class KomentarController extends Controller
{
    /**
     * Display a listing of comments
     */
    public function index(Request $request)
    {
        $query = Komentar::with(['article', 'parent'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by article
        if ($request->filled('article_id')) {
            $query->where('article_id', $request->article_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('author_email', 'like', "%{$search}%");
            });
        }

        $comments = $query->paginate(20);
        $articles = Artikel::select('id', 'title')->get();

        return view('artikel.komentar.komentar', compact('comments', 'articles'));
    }

    /**
     * Show the form for creating a new comment (for admin)
     */
    public function create()
    {
        // $articles = Artikel::published()->select('id', 'title')->get();
        // return view('artikel.komentar.create', compact('articles'));
    }

    /**
     * Store a newly created comment (for admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:artikel,id',
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:komentar,id',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $comment = Komentar::create([
            'article_id' => $request->article_id,
            'parent_id' => $request->parent_id,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'author_website' => $request->author_website,
            'content' => $request->content,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $request->status
        ]);

        // Update comment count on article
        $this->updateArticleCommentCount($comment->article_id);

        return redirect()->route('artikel.komentar.index')
            ->with('success', 'Komentar berhasil dibuat.');
    }

    /**
     * Display the specified comment
     */
    public function show(Komentar $komentar)
    {
        // $komentar->load(['article', 'parent', 'replies' => function ($query) {
        //     $query->with('replies');
        // }]);

        // return view('artikel.komentar.show', compact('komentar'));
    }

    /**
     * Show the form for editing the specified comment
     */
    public function edit(Komentar $komentar)
    {
        // $articles = Artikel::select('id', 'title')->get();
        // $parentComments = Komentar::where('article_id', $komentar->article_id)
        //     ->whereNull('parent_id')
        //     ->where('id', '!=', $komentar->id)
        //     ->get();

        // return view('artikel.komentar.edit', compact('komentar', 'articles', 'parentComments'));
    }

    /**
     * Update the specified comment
     */
    // public function update(Request $request, Komentar $komentar)
    // {
    //     $request->validate([
    //         'article_id' => 'required|exists:artikel,id',
    //         'author_name' => 'required|string|max:255',
    //         'author_email' => 'required|email|max:255',
    //         'author_website' => 'nullable|url|max:255',
    //         'content' => 'required|string|max:1000',
    //         'parent_id' => 'nullable|exists:komentar,id',
    //         'status' => 'required|in:pending,approved,rejected'
    //     ]);

    //     $oldArticleId = $komentar->article_id;
    //     $oldStatus = $komentar->status;

    //     $komentar->update([
    //         'article_id' => $request->article_id,
    //         'parent_id' => $request->parent_id,
    //         'author_name' => $request->author_name,
    //         'author_email' => $request->author_email,
    //         'author_website' => $request->author_website,
    //         'content' => $request->content,
    //         'status' => $request->status
    //     ]);

    //     // Update comment count if article changed
    //     if ($oldArticleId != $request->article_id) {
    //         $this->updateArticleCommentCount($oldArticleId);
    //         $this->updateArticleCommentCount($request->article_id);
    //     } else {
    //         $this->updateArticleCommentCount($request->article_id);
    //     }

    //     // Send notification if status changed
    //     if ($oldStatus != $request->status) {
    //         $this->sendStatusChangeNotification($komentar, $request->status);
    //     }

    //     return redirect()->route('artikel.komentar.index')
    //         ->with('success', 'Komentar berhasil diperbarui.');
    // }

    private function updateCommentStatus($commentIds, $status)
    {
        // Convert single ID to array for unified processing
        $ids = is_array($commentIds) ? $commentIds : [$commentIds];

        $comments = Komentar::whereIn('id', $ids)->get();

        // Update status for all comments
        Komentar::whereIn('id', $ids)->update(['status' => $status]);

        // Update comment counts for affected articles
        $articleIds = $comments->pluck('article_id')->unique();
        foreach ($articleIds as $articleId) {
            $this->updateArticleCommentCount($articleId);
        }

        return $comments->count();
    }

    private function deleteComments($commentIds)
    {
        // Convert single ID to array for unified processing
        $ids = is_array($commentIds) ? $commentIds : [$commentIds];

        $comments = Komentar::with('replies')->whereIn('id', $ids)->get();
        $articleIds = $comments->pluck('article_id')->unique();

        // Delete all replies first
        foreach ($comments as $comment) {
            $comment->replies()->delete();
        }

        // Delete the comments
        Komentar::whereIn('id', $ids)->delete();

        // Update comment counts for affected articles
        foreach ($articleIds as $articleId) {
            $this->updateArticleCommentCount($articleId);
        }

        return count($ids);
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Komentar $komentar)
    {
        $this->deleteComments($komentar->id);

        return redirect()->route('artikel.komentar.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Approve a comment
     */
    public function approve(Komentar $komentar)
    {
        $this->updateCommentStatus($komentar->id, 'approved');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil disetujui.',
            'status' => 'approved'
        ]);
    }

    /**
     * Reject a comment
     */
    public function reject(Komentar $komentar)
    {
        $this->updateCommentStatus($komentar->id, 'trash');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditolak.',
            'status' => 'rejected'
        ]);
    }

    /**
     * Bulk approve comments
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:komentar,id'
        ]);

        $count = $this->updateCommentStatus($request->comment_ids, 'approved');

        return response()->json([
            'success' => true,
            'message' => "$count komentar berhasil disetujui."
        ]);
    }

    /**
     * Bulk reject comments
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:komentar,id'
        ]);

        $count = $this->updateCommentStatus($request->comment_ids, 'trash');

        return response()->json([
            'success' => true,
            'message' => "$count komentar berhasil ditolak."
        ]);
    }

    /**
     * Bulk delete comments
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:komentar,id'
        ]);

        $count = $this->deleteComments($request->comment_ids);

        return response()->json([
            'success' => true,
            'message' => "$count komentar berhasil dihapus."
        ]);
    }

    /**
     * Get comments for a specific article (for AJAX)
     */
    public function getByArticle(Artikel $artikel)
    {
        $comments = Komentar::with(['parent', 'replies'])
            ->where('article_id', $artikel->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Get comment statistics
     */
    public function stats()
    {
        $stats = [
            'total' => Komentar::count(),
            'pending' => Komentar::where('status', 'pending')->count(),
            'approved' => Komentar::where('status', 'approved')->count(),
            'rejected' => Komentar::where('status', 'rejected')->count(),
            'today' => Komentar::whereDate('created_at', today())->count(),
            'this_week' => Komentar::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Komentar::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Store a new comment from frontend
     */
    public function storeFromFrontend(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:artikel,id',
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:komentar,id',
            'g-recaptcha-response' => 'required|captcha' // Assuming you have captcha validation
        ]);

        // Check for spam (basic implementation)
        if ($this->isSpam($request->content, $request->author_email)) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar terdeteksi sebagai spam.'
            ], 422);
        }

        $comment = Komentar::create([
            'article_id' => $request->article_id,
            'parent_id' => $request->parent_id,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'author_website' => $request->author_website,
            'content' => $request->content,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending' // Default to pending for frontend submissions
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim dan menunggu persetujuan.',
            'data' => $comment
        ]);
    }

    /**
     * Update article comment count
     */
    private function updateArticleCommentCount($articleId)
    {
        $count = Komentar::where('article_id', $articleId)
            ->where('status', 'approved')
            ->count();

        Artikel::where('id', $articleId)->update(['comments_count' => $count]);
    }

    /**
     * Send notification when comment status changes
     */
    // private function sendStatusChangeNotification(Komentar $comment, $status)
    // {
    //     try {
    //         if ($status === 'approved') {
    //             Mail::to($comment->author_email)->send(new CommentApproved($comment));
    //         } elseif ($status === 'rejected') {
    //             Mail::to($comment->author_email)->send(new CommentRejected($comment));
    //         }
    //     } catch (\Exception $e) {
    //         // Log error but don't break the flow
    //         logger()->error('Failed to send comment notification: ' . $e->getMessage());
    //     }
    // }

    /**
     * Basic spam detection
     */
    private function isSpam($content, $email)
    {
        // Convert to lowercase for checking
        $content = strtolower($content);

        // Common spam keywords
        $spamKeywords = [
            'viagra',
            'casino',
            'poker',
            'loan',
            'mortgage',
            'forex',
            'bitcoin',
            'cryptocurrency',
            'investment',
            'make money',
            'work from home',
            'click here',
            'free money',
            'get rich'
        ];

        // Check for spam keywords
        foreach ($spamKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                return true;
            }
        }

        // Check for excessive links
        if (substr_count($content, 'http') > 2) {
            return true;
        }

        // Check for repeated characters
        if (preg_match('/(.)\1{4,}/', $content)) {
            return true;
        }

        // Check for suspicious email patterns
        if (preg_match('/\d+@/', $email)) {
            return true;
        }

        return false;
    }
}
