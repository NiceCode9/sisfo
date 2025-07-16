@extends('landing.guest')

@section('title', $article->meta_title)

@push('styles')
    <meta name="description" content="{{ $article->meta_description }}">
    <meta name="keywords" content="{{ $article->meta_keywords }}">
    <meta name="author" content="{{ $article->author->name }}">

    <!-- Open Graph -->
    @if ($article->og_data)
        @foreach ($article->og_data as $property => $content)
            @if (is_array($content))
                @foreach ($content as $item)
                    <meta property="{{ $property }}" content="{{ $item }}">
                @endforeach
            @else
                <meta property="{{ $property }}" content="{{ $content }}">
            @endif
        @endforeach
    @endif


    <!-- Schema.org -->
    @if ($article->schema_data)
        <script type="application/ld+json">
        {!! json_encode($article->schema_data) !!}
    </script>
    @endif

    <style>
        .article-content {
            line-height: 1.8;
        }

        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            margin: 2rem 0 1rem 0;
            font-weight: 600;
            color: #374151;
        }

        .article-content h1 {
            font-size: 2.25rem;
        }

        .article-content h2 {
            font-size: 1.875rem;
        }

        .article-content h3 {
            font-size: 1.5rem;
        }

        .article-content h4 {
            font-size: 1.25rem;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            color: #4b5563;
            text-align: justify;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary);
            margin: 2rem 0;
            padding: 1rem 2rem;
            background: #f8f9fa;
            font-style: italic;
            border-radius: 0 8px 8px 0;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .article-content a {
            color: var(--primary);
            text-decoration: underline;
        }

        .article-content a:hover {
            color: var(--secondary);
        }

        .article-content code {
            background: #f1f5f9;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .article-content pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 2rem 0;
        }

        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }

        .article-content th,
        .article-content td {
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            text-align: left;
        }

        .article-content th {
            background: #f3f4f6;
            font-weight: 600;
        }

        .share-sticky {
            position: sticky;
            top: 50%;
            transform: translateY(-50%);
        }

        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            z-index: 9999;
            transition: width 0.3s ease;
        }

        .toc {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
            border-left: 4px solid var(--primary);
        }

        .toc ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .toc li {
            margin: 0.5rem 0;
        }

        .toc a {
            color: #4b5563;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .toc a:hover {
            color: var(--primary);
        }

        .toc .active {
            color: var(--primary);
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <!-- Reading Progress Bar -->
    <div class="progress-bar" id="progressBar"></div>

    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-primary transition duration-300">
                    <i class="fas fa-home"></i> Home
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('artikel.index') }}" class="hover:text-primary transition duration-300">
                    Artikel
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('artikel.index', ['category' => $article->category->slug]) }}"
                    class="hover:text-primary transition duration-300">
                    {{ $article->category->name }}
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-800 font-medium">{{ $article->title }}</span>
            </div>
        </div>
    </nav>

    <!-- Article Header -->
    <article class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Article Meta -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center gap-4 mb-4">
                        <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $article->category->name }}
                        </span>

                        @if ($article->is_breaking)
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <i class="fas fa-bolt mr-1"></i>Breaking News
                            </span>
                        @endif

                        @if ($article->is_featured)
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <i class="fas fa-star mr-1"></i>Featured
                            </span>
                        @endif
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-6 leading-tight">
                        {{ $article->title }}
                    </h1>

                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        {{ $article->excerpt }}
                    </p>

                    <div class="flex items-center justify-center gap-8 text-gray-600">
                        <div class="flex items-center gap-2">
                            <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->author->name) }}"
                                alt="{{ $article->author->name }}" class="w-10 h-10 rounded-full object-cover">
                            <div class="text-left">
                                <p class="font-medium text-gray-800">{{ $article->author->name }}</p>
                                <p class="text-sm text-gray-500">{{ $article->author->title ?? 'Author' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $article->formatted_published_at }}</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="fas fa-clock"></i>
                            <span>{{ $article->reading_time }} menit baca</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($article->views_count) }} views</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($article->featured_image)
                    <div class="mb-12">
                        <img src="{{ asset('storage/' . $article->featured_image) }}"
                            alt="{{ $article->featured_image_alt ?: $article->title }}"
                            class="w-full max-h-[600px] object-cover rounded-2xl shadow-2xl">

                        @if ($article->featured_image_caption)
                            <p class="text-sm text-gray-600 text-center mt-4 italic">
                                {{ $article->featured_image_caption }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </article>

    <!-- Article Content -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Social Share Sidebar -->
                <div class="lg:col-span-1 order-2 lg:order-1">
                    <div class="share-sticky">
                        <div class="flex lg:flex-col items-center gap-4">
                            <button onclick="shareArticle('facebook')"
                                class="w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </button>

                            <button onclick="shareArticle('twitter')"
                                class="w-12 h-12 bg-blue-400 hover:bg-blue-500 text-white rounded-full flex items-center justify-center transition duration-300">
                                <i class="fab fa-twitter"></i>
                            </button>

                            <button onclick="shareArticle('whatsapp')"
                                class="w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition duration-300">
                                <i class="fab fa-whatsapp"></i>
                            </button>

                            <button onclick="shareArticle('linkedin')"
                                class="w-12 h-12 bg-blue-700 hover:bg-blue-800 text-white rounded-full flex items-center justify-center transition duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </button>

                            <button onclick="copyLink()"
                                class="w-12 h-12 bg-gray-600 hover:bg-gray-700 text-white rounded-full flex items-center justify-center transition duration-300">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-8 order-1 lg:order-2">
                    <div class="article-content">
                        <!-- Table of Contents -->
                        @if (strpos($article->content, '<h2') !== false)
                            <div class="toc">
                                <h3 class="text-xl font-bold mb-4">Daftar Isi</h3>
                                <ul id="tocList"></ul>
                            </div>
                        @endif

                        {!! $article->content !!}
                    </div>

                    <!-- Article Tags -->
                    @if ($article->tags->count() > 0)
                        <div class="mt-12">
                            <h3 class="text-xl font-bold mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ route('artikel.index', ['tag' => $tag->slug]) }}"
                                        class="bg-gray-100 hover:bg-primary hover:text-white px-4 py-2 rounded-full text-sm transition duration-300">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Article Author Bio -->
                    <div class="mt-12 bg-gray-50 rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->author->name) }}"
                                alt="{{ $article->author->name }}"
                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $article->author->name }}</h3>
                                @if ($article->author->bio)
                                    <p class="text-gray-600 mb-4">{{ $article->author->bio }}</p>
                                @endif
                                <div class="flex gap-4">
                                    @if ($article->author->facebook)
                                        <a href="{{ $article->author->facebook }}" target="_blank"
                                            class="text-gray-500 hover:text-blue-600">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if ($article->author->twitter)
                                        <a href="{{ $article->author->twitter }}" target="_blank"
                                            class="text-gray-500 hover:text-blue-400">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if ($article->author->instagram)
                                        <a href="{{ $article->author->instagram }}" target="_blank"
                                            class="text-gray-500 hover:text-pink-600">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                    @if ($article->author->website)
                                        <a href="{{ $article->author->website }}" target="_blank"
                                            class="text-gray-500 hover:text-primary">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    @if ($article->relatedArticles->count() > 0)
                        <div class="mt-16">
                            <h3 class="text-2xl font-bold mb-8">Artikel Terkait</h3>
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($article->relatedArticles as $related)
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                                        <a href="{{ $related->url }}">
                                            @if ($related->featured_image)
                                                <img src="{{ asset('storage/' . $related->featured_image) }}"
                                                    alt="{{ $related->featured_image_alt }}"
                                                    class="w-full h-48 object-cover">
                                            @endif
                                            <div class="p-6">
                                                <span
                                                    class="text-xs font-semibold text-primary">{{ $related->category->name }}</span>
                                                <h4 class="text-lg font-bold mt-2 mb-3 line-clamp-2">{{ $related->title }}
                                                </h4>
                                                <div class="flex items-center text-sm text-gray-500 gap-3">
                                                    <span>{{ $related->reading_time }} min read</span>
                                                    <span>•</span>
                                                    <span>{{ $related->formatted_published_at }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="mt-16" id="comments">
                        <h3 class="text-2xl font-bold mb-8">Komentar ({{ $article->comments_count }})</h3>

                        @if ($article->approvedComments->count() > 0)
                            <div class="space-y-6 mb-8">
                                @foreach ($article->approvedComments as $comment)
                                    <div class="bg-white rounded-xl shadow-sm p-6">
                                        <div class="flex items-center gap-4 mb-4">
                                            <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                                alt="{{ $comment->user->name }}"
                                                class="w-12 h-12 rounded-full object-cover">
                                            <div>
                                                <h4 class="font-bold">{{ $comment->user->name }}</h4>
                                                <span
                                                    class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @auth
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h4 class="text-lg font-bold mb-4">Tinggalkan Komentar</h4>
                                <form action="{{ route('artikel.comment.store', $article->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <textarea name="content" rows="4"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                            placeholder="Tulis komentar Anda..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium transition duration-300">
                                        Kirim Komentar
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                                <p class="mb-4">Anda harus login untuk meninggalkan komentar.</p>
                                <a href="{{ route('login') }}"
                                    class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium transition duration-300">
                                    Login
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-3 order-3">
                    <!-- SEO Score Widget -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4">SEO Score</h3>
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-32 h-32">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path
                                        d="M18 2.0845
                                                                                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="#e6e6e6" stroke-width="3" stroke-dasharray="100, 100" />
                                    <path
                                        d="M18 2.0845
                                                                                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="{{ $article->seo_status === 'excellent' ? '#10b981' : ($article->seo_status === 'good' ? '#f59e0b' : '#ef4444') }}"
                                        stroke-width="3" stroke-dasharray="{{ $article->seo_score }}, 100" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-bold">{{ round($article->seo_score) }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                      {{ $article->seo_status === 'excellent' ? 'bg-green-100 text-green-800' : ($article->seo_status === 'good' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($article->seo_status) }}
                            </span>
                        </div>

                        @if (count($article->seo_suggestions) > 0)
                            <div class="mt-6">
                                <h4 class="font-bold mb-2">Saran Perbaikan SEO:</h4>
                                <ul class="space-y-2 text-sm">
                                    @foreach ($article->seo_suggestions as $suggestion)
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-info-circle text-primary mt-0.5"></i>
                                            <span>{{ $suggestion }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Popular Articles -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4">Artikel Populer</h3>
                        <div class="space-y-4">
                            @foreach ($popularArticles as $popular)
                                <a href="{{ $popular->url }}" class="block group">
                                    <div class="flex items-center gap-3">
                                        @if ($popular->featured_image)
                                            <img src="{{ asset('storage/' . $popular->featured_image) }}"
                                                alt="{{ $popular->title }}" class="w-16 h-16 object-cover rounded-lg">
                                        @endif
                                        <div>
                                            <h4
                                                class="font-medium text-gray-800 group-hover:text-primary transition duration-300 line-clamp-2">
                                                {{ $popular->title }}</h4>
                                            <span
                                                class="text-xs text-gray-500">{{ $popular->formatted_published_at }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="bg-gradient-to-r from-primary to-secondary rounded-xl shadow-sm p-6 text-white mb-8">
                        <h3 class="text-xl font-bold mb-2">Berlangganan Newsletter</h3>
                        <p class="text-sm mb-4">Dapatkan artikel terbaru langsung ke email Anda</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" placeholder="Alamat Email Anda"
                                    class="w-full px-4 py-3 rounded-lg text-gray-800 focus:outline-none">
                            </div>
                            <button type="submit"
                                class="w-full px-4 py-3 bg-white text-primary rounded-lg font-medium hover:bg-opacity-90 transition duration-300">
                                Berlangganan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Update reading progress bar
        window.onscroll = function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        };

        // Generate table of contents
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.article-content');
            const headings = content.querySelectorAll('h2');
            const tocList = document.getElementById('tocList');

            if (headings.length > 0 && tocList) {
                headings.forEach((heading, index) => {
                    const id = `heading-${index}`;
                    heading.id = id;

                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    a.href = `#${id}`;
                    a.textContent = heading.textContent;
                    a.classList.add('toc-link');

                    li.appendChild(a);
                    tocList.appendChild(li);
                });

                // Highlight active TOC item while scrolling
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const id = entry.target.getAttribute('id');
                        const tocLink = document.querySelector(`.toc a[href="#${id}"]`);

                        if (entry.isIntersecting) {
                            document.querySelectorAll('.toc a').forEach(link => {
                                link.classList.remove('active');
                            });
                            if (tocLink) tocLink.classList.add('active');
                        }
                    });
                }, {
                    threshold: 0.5
                });

                headings.forEach(heading => {
                    observer.observe(heading);
                });
            }
        });

        // Social share functions
        function shareArticle(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            let shareUrl;

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title} ${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
                    break;
                default:
                    return;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    </script>
@endpush
