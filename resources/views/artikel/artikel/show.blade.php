@extends('layouts.app')

@section('title', $artikel->title)

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .article-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }

        .article-meta {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
            border-left: 4px solid #667eea;
        }

        .article-tags .badge {
            font-size: 0.9rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0.8rem;
            border-radius: 50px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .featured-image {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .featured-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-draft {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-published {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-archived {
            background-color: #f8d7da;
            color: #721c24;
        }

        .author-info {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .seo-score {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }

        .seo-excellent {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .seo-good {
            background-color: #fff3cd;
            color: #856404;
        }

        .seo-poor {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-buttons .btn {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-item {
            border-left: 3px solid #667eea;
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="article-header animate-fade-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="d-flex justify-content-center mb-3">
                        @foreach ($artikel->tags as $tag)
                            <span class="badge bg-secondary me-2">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <h1 class="display-5 fw-bold mb-3">{{ $artikel->title }}</h1>
                    <p class="lead mb-4">{{ $artikel->excerpt }}</p>

                    <div class="d-flex justify-content-center align-items-center">
                        <div class="me-4">
                            <i class="fas fa-user me-2"></i>
                            {{ $artikel->author->name }}
                        </div>
                        <div class="me-4">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ $artikel->published_at->format('d M Y') }}
                        </div>
                        <div>
                            <i class="fas fa-clock me-2"></i>
                            {{ $artikel->reading_time }} min read
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Article Meta -->
                <div class="article-meta animate-fade-in">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="author-info">
                                @if ($artikel->author->avatar)
                                    <img src="{{ asset('storage/' . $artikel->author->avatar) }}"
                                        alt="{{ $artikel->author->name }}" class="author-avatar">
                                @else
                                    <div
                                        class="author-avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                                        {{ substr($artikel->author->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $artikel->author->name }}</h6>
                                    <small class="text-muted">Dipublikasikan
                                        {{ $artikel->published_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex flex-md-row flex-column justify-content-md-end align-items-md-center">
                                <span class="status-badge status-{{ $artikel->status }} me-md-2 mb-md-0 mb-2">
                                    @if ($artikel->status === 'draft')
                                        <i class="fas fa-edit me-1"></i> Draft
                                    @elseif($artikel->status === 'published')
                                        <i class="fas fa-globe me-1"></i> Published
                                    @else
                                        <i class="fas fa-archive me-1"></i> Archived
                                    @endif
                                </span>
                                @if ($artikel->is_featured)
                                    <span class="badge bg-warning me-md-2 mb-md-0 mb-2">
                                        <i class="fas fa-star me-1"></i> Unggulan
                                    </span>
                                @endif
                                @if ($artikel->is_breaking)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-bolt me-1"></i> Berita Terkini
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($artikel->featured_image)
                    <div class="featured-image animate-fade-in">
                        <img src="{{ asset('storage/' . $artikel->featured_image) }}"
                            alt="{{ $artikel->featured_image_alt }}" class="img-fluid">
                        @if ($artikel->featured_image_caption)
                            <div class="text-center mt-2 text-muted">
                                <small>{{ $artikel->featured_image_caption }}</small>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Article Content -->
                <div class="article-content animate-fade-in">
                    {!! $artikel->content !!}
                </div>

                <!-- Article Footer -->
                <div class="d-flex justify-content-between align-items-center mt-5 mb-4 animate-fade-in">
                    <div class="article-tags">
                        @foreach ($artikel->tags as $tag)
                            <span class="badge">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <div class="text-muted">
                        <small>Terakhir diperbarui {{ $artikel->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- SEO Info -->
                @if ($artikel->seo_score)
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Informasi SEO
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <span
                                    class="seo-score {{ $artikel->seo_score >= 80 ? 'seo-excellent' : ($artikel->seo_score >= 60 ? 'seo-good' : 'seo-poor') }}">
                                    <i
                                        class="fas fa-{{ $artikel->seo_score >= 80 ? 'check-circle' : ($artikel->seo_score >= 60 ? 'exclamation-circle' : 'times-circle') }}"></i>
                                    SEO Score: {{ $artikel->seo_score }}/100
                                </span>
                            </div>
                            @if ($artikel->meta_title)
                                <div class="mb-2">
                                    <strong>Meta Title:</strong>
                                    <p>{{ $artikel->meta_title }}</p>
                                </div>
                            @endif
                            @if ($artikel->meta_description)
                                <div class="mb-2">
                                    <strong>Meta Description:</strong>
                                    <p>{{ $artikel->meta_description }}</p>
                                </div>
                            @endif
                            @if ($artikel->canonical_url)
                                <div>
                                    <strong>Canonical URL:</strong>
                                    <p><a href="{{ $artikel->canonical_url }}"
                                            target="_blank">{{ $artikel->canonical_url }}</a></p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons mb-5 animate-fade-in">
                    <a href="{{ route('artikel.artikel.edit', $artikel->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Artikel
                    </a>
                    <a href="{{ route('artikel.artikel.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Author Info -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>
                            Tentang Penulis
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if ($artikel->author->avatar)
                                <img src="{{ asset('storage/' . $artikel->author->avatar) }}"
                                    alt="{{ $artikel->author->name }}" class="author-avatar me-3">
                            @else
                                <div
                                    class="author-avatar bg-secondary d-flex align-items-center justify-content-center text-white me-3">
                                    {{ substr($artikel->author->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $artikel->author->name }}</h5>
                                <small class="text-muted">Penulis</small>
                            </div>
                        </div>
                        @if ($artikel->author->bio)
                            <p class="mb-0">{{ $artikel->author->bio }}</p>
                        @else
                            <p class="text-muted mb-0">Tidak ada deskripsi penulis</p>
                        @endif
                    </div>
                </div>

                <!-- Related Articles -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-newspaper me-2"></i>
                            Artikel Terkait
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($artikel->relatedArticles->count() > 0)
                            @foreach ($artikel->relatedArticles as $related)
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="mb-1">
                                        <a href="{{ route('artikel.artikel.show', $related->slug) }}"
                                            class="text-dark">{{ $related->title }}</a>
                                    </h6>
                                    <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Tidak ada artikel terkait</p>
                        @endif
                    </div>
                </div>

                <!-- Article Stats -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Artikel
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Views:</span>
                            <strong>{{ number_format($artikel->views) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Komentar:</span>
                            <strong>{{ $artikel->comments->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Waktu Baca:</span>
                            <strong>{{ $artikel->reading_time }} menit</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add any necessary JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to all links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Highlight code blocks (if any)
            if (typeof hljs !== 'undefined') {
                document.querySelectorAll('pre code').forEach((block) => {
                    hljs.highlightBlock(block);
                });
            }
        });
    </script>
@endpush
