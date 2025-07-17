<div class="comment-card bg-white rounded-xl shadow-sm p-6 @if ($depth > 0) ml-12 @endif">
    <div class="flex items-center gap-4 mb-4">
        <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($comment->author_name) }}"
            alt="{{ $comment->author_name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
        <div>
            <h4 class="font-bold text-gray-800">{{ $comment->author_name }}</h4>
            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            @if ($comment->author_website)
                <a href="{{ $comment->author_website }}" target="_blank"
                    class="text-xs text-primary hover:underline">Website</a>
            @endif
        </div>
    </div>
    <p class="text-gray-700 mb-4">{{ $comment->content }}</p>

    <button onclick="setReplyTo({{ $comment->id }}, '{{ $comment->author_name }}')"
        class="text-sm text-primary hover:text-primary-dark font-medium">
        <i class="fas fa-reply mr-1"></i> Balas
    </button>

    <!-- Replies -->
    @if ($comment->replies->count() > 0)
        <div class="mt-6 space-y-6">
            @foreach ($comment->replies()->where('status', 'approved') as $reply)
                @include('landing.artikel.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>
