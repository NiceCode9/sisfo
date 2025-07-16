@extends('layouts.app')

@section('title', 'Detail Artikel: ' . $artikel->title)

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .admin-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .admin-header .container {
            position: relative;
            z-index: 1;
        }

        .status-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 10;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .status-draft {
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            color: #2d3436;
        }

        .status-published {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: white;
        }

        .status-archived {
            background: linear-gradient(135deg, #636e72 0%, #2d3436 100%);
            color: white;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            border: none;
            position: relative;
        }

        .card-header-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .featured-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .featured-image-container img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .featured-image-container:hover img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 2rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .featured-image-container:hover .image-overlay {
            transform: translateY(0);
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #2d3436;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1.5rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h1,
        .article-content h2,
        .article-content h3 {
            color: #2d3436;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .metric-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
        }

        .metric-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .metric-label {
            color: #636e72;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tag-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0.25rem;
            display: inline-block;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }

        .tag-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .seo-score-container {
            position: relative;
            display: inline-block;
        }

        .seo-score-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            position: relative;
            margin: 0 auto 1rem;
        }

        .seo-excellent {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
        }

        .seo-good {
            background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
        }

        .seo-poor {
            background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-custom {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-success-custom {
            background: var(--success-gradient);
            color: white;
        }

        .btn-warning-custom {
            background: var(--warning-gradient);
            color: white;
        }

        .btn-danger-custom {
            background: var(--danger-gradient);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
        }

        .btn-outline-custom:hover {
            background: var(--primary-gradient);
            color: white;
        }

        .author-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .author-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: var(--primary-gradient);
            border-radius: 0 0 50% 50%;
        }

        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid white;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            background: var(--primary-gradient);
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1.5rem;
            width: 2px;
            height: calc(100% + 1rem);
            background: linear-gradient(to bottom, #667eea, transparent);
        }

        .timeline-item:last-child::after {
            display: none;
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-preview {
            max-height: 300px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .content-preview::-webkit-scrollbar {
            width: 6px;
        }

        .content-preview::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .content-preview::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .floating-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar-custom {
            background: var(--primary-gradient);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .admin-header {
                padding: 1.5rem 0;
            }

            .metric-card {
                margin-bottom: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .floating-action {
                bottom: 1rem;
                right: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Status Indicator -->
    <div class="status-indicator">
        <span class="status-badge status-{{ $artikel->status }}">
            @if ($artikel->status === 'draft')
                <i class="fas fa-edit me-1"></i> Draft
            @elseif($artikel->status === 'published')
                <i class="fas fa-globe me-1"></i> Published
            @else
                <i class="fas fa-archive me-1"></i> Archived
            @endif
        </span>
    </div>

    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-newspaper me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h6 class="mb-0 opacity-75">MANAJEMEN ARTIKEL</h6>
                            <h1 class="mb-0">Detail Artikel</h1>
                        </div>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('artikel.artikel.index') }}"
                                    class="text-white-50">Artikel</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ Str::limit($artikel->title, 50) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end">
                        @if ($artikel->is_featured)
                            <span class="badge bg-warning me-2">
                                <i class="fas fa-star me-1"></i> Unggulan
                            </span>
                        @endif
                        @if ($artikel->is_breaking)
                            <span class="badge bg-danger">
                                <i class="fas fa-bolt me-1"></i> Breaking
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Article Overview -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Artikel
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <h2 class="mb-3">{{ $artikel->title }}</h2>
                        <p class="lead text-muted mb-4">{{ $artikel->excerpt }}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="timeline-item">
                                    <h6 class="mb-1">Kategori</h6>
                                    <p class="text-primary">{{ $artikel->category->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="timeline-item">
                                    <h6 class="mb-1">Slug</h6>
                                    <p class="text-muted">{{ $artikel->slug }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="timeline-item">
                                    <h6 class="mb-1">Dibuat</h6>
                                    <p class="text-muted">{{ $artikel->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="timeline-item">
                                    <h6 class="mb-1">Terakhir Diperbarui</h6>
                                    <p class="text-muted">{{ $artikel->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @if ($artikel->published_at)
                                <div class="col-md-6">
                                    <div class="timeline-item">
                                        <h6 class="mb-1">Dipublikasikan</h6>
                                        <p class="text-success">{{ $artikel->published_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($artikel->featured_image)
                    <div class="featured-image-container animate-fade-in">
                        <img src="{{ asset('storage/' . $artikel->featured_image) }}"
                            alt="{{ $artikel->featured_image_alt }}" class="img-fluid">
                        <div class="image-overlay">
                            <h5 class="mb-2">Gambar Utama</h5>
                            @if ($artikel->featured_image_alt)
                                <p class="mb-1"><strong>Alt Text:</strong> {{ $artikel->featured_image_alt }}</p>
                            @endif
                            @if ($artikel->featured_image_caption)
                                <p class="mb-0"><strong>Caption:</strong> {{ $artikel->featured_image_caption }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Content Preview -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>
                            Konten Artikel
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="content-preview">
                            <div class="article-content">
                                {!! $artikel->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                @if ($artikel->tags->count() > 0)
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header-custom">
                            <h5 class="mb-0">
                                <i class="fas fa-tags me-2"></i>
                                Tags
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @foreach ($artikel->tags as $tag)
                                <a href="#" class="tag-badge">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- SEO Information -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-search me-2"></i>
                            Informasi SEO
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="seo-score-container">
                                    <div
                                        class="seo-score-circle {{ $artikel->seo_score >= 80 ? 'seo-excellent' : ($artikel->seo_score >= 60 ? 'seo-good' : 'seo-poor') }}">
                                        {{ $artikel->seo_score ?? 0 }}/100
                                    </div>
                                    <h6 class="text-muted">SEO Score</h6>
                                </div>
                            </div>
                            <div class="col-md-8">
                                @if ($artikel->meta_title)
                                    <div class="mb-3">
                                        <h6 class="text-primary">Meta Title</h6>
                                        <p class="text-muted">{{ $artikel->meta_title }}</p>
                                        <div class="progress-custom">
                                            <div class="progress-bar-custom"
                                                style="width: {{ min(100, (strlen($artikel->meta_title) / 60) * 100) }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ strlen($artikel->meta_title) }}/60 karakter</small>
                                    </div>
                                @endif

                                @if ($artikel->meta_description)
                                    <div class="mb-3">
                                        <h6 class="text-primary">Meta Description</h6>
                                        <p class="text-muted">{{ $artikel->meta_description }}</p>
                                        <div class="progress-custom">
                                            <div class="progress-bar-custom"
                                                style="width: {{ min(100, (strlen($artikel->meta_description) / 160) * 100) }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ strlen($artikel->meta_description) }}/160
                                            karakter</small>
                                    </div>
                                @endif

                                @if ($artikel->canonical_url)
                                    <div>
                                        <h6 class="text-primary">Canonical URL</h6>
                                        <p class="text-muted">
                                            <a href="{{ $artikel->canonical_url }}" target="_blank"
                                                class="text-decoration-none">
                                                {{ $artikel->canonical_url }}
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons animate-fade-in">
                    <a href="{{ route('artikel.artikel.edit', $artikel->slug) }}"
                        class="btn btn-custom btn-primary-custom">
                        <i class="fas fa-edit me-2"></i> Edit Artikel
                    </a>
                    <a href="{{ $artikel->url }}" target="_blank" class="btn btn-custom btn-success-custom">
                        <i class="fas fa-eye me-2"></i> Lihat Publik
                    </a>
                    <button type="button" class="btn btn-custom btn-warning-custom"
                        onclick="toggleStatus('{{ $artikel->slug }}')">
                        <i class="fas fa-toggle-on me-2"></i>
                        {{ $artikel->status === 'published' ? 'Unpublish' : 'Publish' }}
                    </button>
                    <button type="button" class="btn btn-custom btn-danger-custom"
                        onclick="deleteArticle('{{ $artikel->slug }}')">
                        <i class="fas fa-trash me-2"></i> Hapus
                    </button>
                    <a href="{{ route('artikel.artikel.index') }}" class="btn btn-custom btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-6 animate-fade-in">
                        <div class="metric-card">
                            <div class="metric-number">{{ number_format($artikel->views_count ?? 0) }}</div>
                            <div class="metric-label">Views</div>
                        </div>
                    </div>
                    <div class="col-6 animate-fade-in">
                        <div class="metric-card">
                            <div class="metric-number">{{ $artikel->comments_count ?? 0 }}</div>
                            <div class="metric-label">Comments</div>
                        </div>
                    </div>
                    <div class="col-6 animate-fade-in">
                        <div class="metric-card">
                            <div class="metric-number">{{ $artikel->reading_time ?? 0 }}</div>
                            <div class="metric-label">Min Read</div>
                        </div>
                    </div>
                    <div class="col-6 animate-fade-in">
                        <div class="metric-card">
                            <div class="metric-number">{{ number_format($artikel->word_count ?? 0) }}</div>
                            <div class="metric-label">Words</div>
                        </div>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="author-card mb-4 animate-fade-in">
                    @if ($artikel->author->avatar)
                        <img src="{{ asset('storage/' . $artikel->author->avatar) }}" alt="{{ $artikel->author->name }}"
                            class="author-avatar">
                    @else
                        <div
                            class="author-avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                            {{ substr($artikel->author->name, 0, 1) }}
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $artikel->author->name }}</h5>
                    <p class="text-muted mb-2">Author</p>
                    @if ($artikel->author->bio)
                        <p class="small text-muted">{{ $artikel->author->bio }}</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm"
                                onclick="duplicateArticle('{{ $artikel->slug }}')">
                                <i class="fas fa-copy me-2"></i> Duplicate
                            </button>
                            <button class="btn btn-outline-secondary btn-sm"
                                onclick="exportArticle('{{ $artikel->slug }}')">
                                <i class="fas fa-download me-2"></i> Export
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="shareArticle('{{ $artikel->url }}')">
                                <i class="fas fa-share me-2"></i> Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card animate-fade-in">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>
                            Recent Activity
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline-item">
                            <h6 class="mb-1">Artikel dibuat</h6>
                            <small class="text-muted">{{ $artikel->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="timeline-item">
                            <h6 class="mb-1">Terakhir diperbarui</h6>
                            <small class="text-muted">{{ $artikel->updated_at->diffForHumans() }}</small>
                        </div>
                        @if ($artikel->published_at)
                            <div class="timeline-item">
                                <h6 class="mb-1">Dipublikasikan</h6>
                                <small class="text-success">{{ $artikel->published_at->diffForHumans() }}</small>
                            </div>
                        @endif
                        @if ($artikel->last_viewed_at)
                            <div class="timeline-item">
                                <h6 class="mb-1">Terakhir dilihat</h6>
                                <small class="text-muted">{{ $artikel->last_viewed_at->diffForHumans() }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <button class="floating-btn" onclick="scrollToTop()" title="Scroll to top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Smooth scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all animation elements
            document.querySelectorAll('.animate-fade-in').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(el);
            });
        });

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Toggle article status
        function toggleStatus(articleId) {
            Swal.fire({
                title: 'Ubah Status Artikel?',
                text: 'Apakah Anda yakin ingin mengubah status artikel ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, Ubah!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'animate__animated animate__zoomIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/artikel/artikel/${articleId}/toogle-status`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Delete article
        function deleteArticle(articleId) {
            Swal.fire({
                title: 'Hapus Artikel?',
                text: 'Artikel yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'animate__animated animate__zoomIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('artikel.artikel.destroy', ':id') }}`.replace('id', articleId);

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Duplicate article
        function duplicateArticle(articleId) {
            Swal.fire({
                title: 'Duplikasi Artikel?',
                text: 'Artikel akan diduplikasi sebagai draft baru.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, Duplikasi!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'animate__animated animate__zoomIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Export article
        function exportArticle(articleId) {
            Swal.fire({
                title: 'Pilih Format Export',
                text: 'Pilih format yang ingin Anda export:',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'PDF',
                denyButtonText: 'Word',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74c3c',
                denyButtonColor: '#3498db',
                cancelButtonColor: '#95a5a6',
                background: '#fff',
                customClass: {
                    popup: 'animate__animated animate__zoomIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Export as PDF
                } else if (result.isDenied) {
                    // Export as Word
                }
            });
        }

        // Share article
        function shareArticle(articleUrl) {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $artikel->title }}',
                    text: '{{ $artikel->excerpt }}',
                    url: articleUrl
                }).catch(console.error);
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(articleUrl).then(() => {
                    Swal.fire({
                        title: 'Link Disalin!',
                        text: 'Link artikel telah disalin ke clipboard.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#fff',
                        customClass: {
                            popup: 'animate__animated animate__zoomIn'
                        }
                    });
                });
            }
        }

        // Image lazy loading
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        });

        // Floating button hide/show on scroll
        let lastScrollTop = 0;
        const floatingBtn = document.querySelector('.floating-action');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scrolling down
                floatingBtn.style.transform = 'translateY(100px)';
            } else {
                // Scrolling up
                floatingBtn.style.transform = 'translateY(0)';
            }

            lastScrollTop = scrollTop;
        });

        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + E = Edit
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                window.location.href = '{{ route('artikel.artikel.edit', $artikel->slug) }}';
            }

            // Ctrl/Cmd + D = Duplicate
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                duplicateArticle('{{ $artikel->slug }}');
            }

            // Ctrl/Cmd + Shift + P = Toggle Status
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                toggleStatus('{{ $artikel->slug }}');
            }
        });

        // Print functionality
        function printArticle() {
            window.print();
        }

        // Add print styles
        const printStyles = `
            @media print {
                .admin-header, .action-buttons, .floating-action, .card-header-custom {
                    display: none !important;
                }
                .card {
                    box-shadow: none !important;
                    border: 1px solid #ddd !important;
                }
                .article-content {
                    font-size: 12pt !important;
                    line-height: 1.5 !important;
                }
            }
        `;

        const styleSheet = document.createElement('style');
        styleSheet.type = 'text/css';
        styleSheet.innerText = printStyles;
        document.head.appendChild(styleSheet);
    </script>
@endpush
