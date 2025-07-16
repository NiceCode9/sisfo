@extends('layouts.app')

@section('title', 'Edit Artikel')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
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

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .btn {
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
            border: none;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e0a800 0%, #e07b00 100%);
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .tag-checkbox {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .tag-checkbox:hover {
            background: #e9ecef;
        }

        .tag-checkbox.selected {
            background: rgba(102, 126, 234, 0.1);
            border: 2px solid #667eea;
        }

        .image-preview-container {
            position: relative;
            border: 2px dashed #dee2e6;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .image-preview-container:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .image-preview-container.has-image {
            border-style: solid;
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }

        .character-counter {
            position: absolute;
            right: 0.75rem;
            bottom: 0.75rem;
            font-size: 0.75rem;
            color: #6c757d;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .progress-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .feature-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .feature-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3);
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

        .floating-save {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            border-radius: 50px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .floating-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 1rem 2rem rgba(102, 126, 234, 0.6);
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

        .section-divider {
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            margin: 2rem 0;
            border-radius: 1px;
        }

        .tooltip-custom {
            position: relative;
            display: inline-block;
        }

        .tooltip-custom .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #555;
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip-custom:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .article-info {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #667eea;
        }

        .article-info small {
            color: #6c757d;
        }

        .history-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #e9ecef;
            color: #495057;
        }

        .current-image {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .change-image-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .change-image-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <div class="page-header animate-fade-in">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Artikel
                    </h1>
                    <p class="mb-0 opacity-75">Perbarui artikel yang sudah ada</p>
                </div>
                <div>
                    <a href="{{ route('artikel.artikel.show', $artikel->slug) }}" class="btn btn-outline-light me-2">
                        <i class="fas fa-eye me-2"></i>Lihat Artikel
                    </a>
                    <a href="{{ route('artikel.artikel.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Article Information -->
        <div class="article-info animate-fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="history-badge">
                            <i class="fas fa-calendar-alt"></i>
                            Dibuat: {{ $artikel->created_at->format('d M Y H:i') }}
                        </div>
                        <div class="history-badge">
                            <i class="fas fa-edit"></i>
                            Diperbarui: {{ $artikel->updated_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <span class="status-badge status-{{ $artikel->status }}">
                            @if ($artikel->status === 'draft')
                                <i class="fas fa-edit me-1"></i>Draft
                            @elseif($artikel->status === 'published')
                                <i class="fas fa-globe me-1"></i>Published
                            @else
                                <i class="fas fa-archive me-1"></i>Archived
                            @endif
                        </span>
                        @if ($artikel->is_featured)
                            <span class="badge bg-warning">
                                <i class="fas fa-star me-1"></i>Unggulan
                            </span>
                        @endif
                        @if ($artikel->is_breaking)
                            <span class="badge bg-danger">
                                <i class="fas fa-bolt me-1"></i>Berita Terkini
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terdapat kesalahan:
                </h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('artikel.artikel.update', $artikel->slug) }}" method="POST" enctype="multipart/form-data"
            id="articleForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic Information -->
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-edit me-2"></i>
                                Informasi Dasar
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    Judul Artikel *
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">Judul yang menarik akan meningkatkan engagement</span>
                                    </span>
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title', $artikel->title) }}" required
                                        placeholder="Masukkan judul artikel yang menarik...">
                                    <span class="character-counter" id="title-counter">0/255</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="excerpt" class="form-label">
                                    Ringkasan *
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">Ringkasan yang baik akan muncul di hasil pencarian</span>
                                    </span>
                                </label>
                                <div class="position-relative">
                                    <textarea class="form-control" id="excerpt" name="excerpt" rows="4" required
                                        placeholder="Tulis ringkasan artikel yang akan menarik pembaca...">{{ old('excerpt', $artikel->excerpt) }}</textarea>
                                    <span class="character-counter" id="excerpt-counter">0/500</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label">
                                    Konten Artikel *
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">Gunakan editor untuk memformat konten dengan baik</span>
                                    </span>
                                </label>
                                <div id="editor-container">
                                    <textarea class="form-control" id="content" name="content" rows="20" required
                                        placeholder="Mulai menulis konten artikel Anda di sini...">{{ old('content', $artikel->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Pengaturan SEO
                                <span class="float-end" id="seo-score">
                                    @if ($artikel->seo_score)
                                        <span
                                            class="seo-score {{ $artikel->seo_score >= 80 ? 'seo-excellent' : ($artikel->seo_score >= 60 ? 'seo-good' : 'seo-poor') }}">
                                            <i
                                                class="fas fa-{{ $artikel->seo_score >= 80 ? 'check-circle' : ($artikel->seo_score >= 60 ? 'exclamation-circle' : 'times-circle') }}"></i>
                                            SEO Score: {{ $artikel->seo_score }}/100
                                        </span>
                                    @endif
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="meta_title" class="form-label">
                                    Meta Title
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">Judul yang muncul di hasil pencarian Google</span>
                                    </span>
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title', $artikel->meta_title) }}"
                                        placeholder="Otomatis diisi dari judul artikel">
                                    <span class="character-counter" id="meta-title-counter">0/60</span>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-lightbulb text-warning me-1"></i>
                                    Optimal: 30-60 karakter
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="meta_description" class="form-label">
                                    Meta Description
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">Deskripsi yang muncul di hasil pencarian Google</span>
                                    </span>
                                </label>
                                <div class="position-relative">
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                        placeholder="Otomatis diisi dari ringkasan artikel">{{ old('meta_description', $artikel->meta_description) }}</textarea>
                                    <span class="character-counter" id="meta-desc-counter">0/160</span>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-lightbulb text-warning me-1"></i>
                                    Optimal: 120-160 karakter
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="canonical_url" class="form-label">
                                    Canonical URL
                                    <span class="tooltip-custom">
                                        <i class="fas fa-info-circle text-muted ms-1"></i>
                                        <span class="tooltip-text">URL canonical untuk mencegah duplicate content</span>
                                    </span>
                                </label>
                                <input type="url" class="form-control" id="canonical_url" name="canonical_url"
                                    value="{{ old('canonical_url', $artikel->canonical_url) }}"
                                    placeholder="https://example.com/artikel-saya">
                            </div>

                            <!-- SEO Suggestions Container -->
                            <div id="seo-suggestions">
                                @if ($artikel->seo_analysis && isset($artikel->seo_analysis['suggestions']))
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Saran Perbaikan SEO:
                                        </h6>
                                        <ul class="mb-0">
                                            @foreach ($artikel->seo_analysis['suggestions'] as $suggestion)
                                                <li>{{ $suggestion }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Publish Settings -->
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cog me-2"></i>
                                Pengaturan Publikasi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Publikasi *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft"
                                        {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>
                                        <i class="fas fa-edit"></i> Draft
                                    </option>
                                    <option value="published"
                                        {{ old('status', $artikel->status) == 'published' ? 'selected' : '' }}>
                                        <i class="fas fa-globe"></i> Published
                                    </option>
                                    <option value="archived"
                                        {{ old('status', $artikel->status) == 'archived' ? 'selected' : '' }}>
                                        <i class="fas fa-archive"></i> Archived
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $artikel->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <div class="row">
                                    @foreach ($tags as $tag)
                                        <div class="col-12 mb-2">
                                            <div
                                                class="tag-checkbox {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                                        value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                                        {{ in_array($tag->id, old('tags', $selectedTags)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="tag_{{ $tag->id }}">
                                                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="section-divider">

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                        id="is_featured" {{ old('is_featured', $artikel->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        Artikel Unggulan
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_breaking" value="1"
                                        id="is_breaking" {{ old('is_breaking', $artikel->is_breaking) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_breaking">
                                        <i class="fas fa-bolt text-danger me-1"></i>
                                        Berita Terkini
                                    </label>
                                </div>
                            </div>

                            @if ($artikel->published_at)
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Dipublikasikan: {{ $artikel->published_at->format('d M Y H:i') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card mb-4 animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-image me-2"></i>
                                Gambar Unggulan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="image-preview-container {{ $artikel->featured_image ? 'has-image' : '' }}"
                                id="image-drop-zone">
                                <div id="image-preview"
                                    style="{{ $artikel->featured_image ? 'display: block;' : 'display: none;' }}">
                                    <div class="position-relative">
                                        <img id="preview-img"
                                            src="{{ $artikel->featured_image ? asset('storage/' . $artikel->featured_image) : '' }}"
                                            class="current-image mb-3" style="max-height: 200px;">
                                        <button type="button" class="change-image-btn" onclick="showImageUpload()">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                                <div id="upload-placeholder"
                                    style="{{ $artikel->featured_image ? 'display: none;' : 'display: block;' }}">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">Drag & drop gambar di sini atau klik untuk memilih</p>
                                    <input type="file" class="form-control" id="featured_image" name="featured_image"
                                        accept="image/*" onchange="previewImage(event)" style="display: none;">
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="document.getElementById('featured_image').click()">
                                        <i class="fas fa-upload me-1"></i>Pilih Gambar
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB
                            </small>

                            <div class="mt-3">
                                <label for="featured_image_alt" class="form-label">Alt Text</label>
                                <input type="text" class="form-control" id="featured_image_alt"
                                    name="featured_image_alt"
                                    value="{{ old('featured_image_alt', $artikel->featured_image_alt) }}"
                                    placeholder="Deskripsi gambar untuk SEO">
                            </div>

                            <div class="mt-3">
                                <label for="featured_image_caption" class="form-label">Caption</label>
                                <textarea class="form-control" id="featured_image_caption" name="featured_image_caption" rows="2"
                                    placeholder="Caption gambar (opsional)">{{ old('featured_image_caption', $artikel->featured_image_caption) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card animate-fade-in">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i>Perbarui Artikel
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                                    <i class="fas fa-edit me-2"></i>Simpan sebagai Draft
                                </button>
                                <a href="{{ route('artikel.artikel.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Floating Save Button -->
        <button type="button" class="floating-save" onclick="document.getElementById('articleForm').submit()">
            <i class="fas fa-save me-2"></i>Simpan
        </button>
    </div>
@endsection

@push('scripts')
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px }',
            menubar: 'file edit view insert format tools table help',
            branding: false,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        // Image preview and drag & drop
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                    document.getElementById('upload-placeholder').style.display = 'none';
                    document.getElementById('image-drop-zone').classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        }

        function showImageUpload() {
            document.getElementById('featured_image').click();
        }

        function removeImage() {
            document.getElementById('featured_image').value = '';
            document.getElementById('preview-img').src = '';
            document.getElementById('image-preview').style.display = 'none';
            document.getElementById('upload-placeholder').style.display = 'block';
            document.getElementById('image-drop-zone').classList.remove('has-image');
        }

        // Drag & Drop functionality
        const dropZone = document.getElementById('image-drop-zone');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#667eea';
            dropZone.style.background = 'rgba(102, 126, 234, 0.1)';
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.background = '#f8f9fa';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.background = '#f8f9fa';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('featured_image').files = files;
                previewImage({
                    target: {
                        files: files
                    }
                });
            }
        });

        // Auto-generate meta title from title
        document.getElementById('title').addEventListener('input', function() {
            const metaTitle = document.getElementById('meta_title');
            if (!metaTitle.value) {
                metaTitle.value = this.value;
            }
            updateCharacterCounter('title', this.value.length, 255);
        });

        // Auto-generate meta description from excerpt
        document.getElementById('excerpt').addEventListener('input', function() {
            const metaDescription = document.getElementById('meta_description');
            if (!metaDescription.value) {
                metaDescription.value = this.value;
            }
            updateCharacterCounter('excerpt', this.value.length, 500);
        });

        // Character counters
        function updateCharacterCounter(fieldId, currentLength, maxLength) {
            const counter = document.getElementById(fieldId + '-counter');
            if (counter) {
                counter.textContent = `${currentLength}/${maxLength}`;

                if (currentLength > maxLength) {
                    counter.className = 'character-counter text-danger';
                } else if (currentLength > maxLength * 0.9) {
                    counter.className = 'character-counter text-warning';
                } else {
                    counter.className = 'character-counter text-muted';
                }
            }
        }

        // Add character counters to all relevant fields
        document.getElementById('meta_title').addEventListener('input', function() {
            updateCharacterCounter('meta-title', this.value.length, 60);
        });

        document.getElementById('meta_description').addEventListener('input', function() {
            updateCharacterCounter('meta-desc', this.value.length, 160);
        });

        // Save as draft function
        function saveDraft() {
            document.getElementById('status').value = 'draft';
            document.getElementById('articleForm').submit();
        }

        // Initialize character counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCharacterCounter('title', document.getElementById('title').value.length, 255);
            updateCharacterCounter('excerpt', document.getElementById('excerpt').value.length, 500);
            updateCharacterCounter('meta-title', document.getElementById('meta_title').value.length, 60);
            updateCharacterCounter('meta-desc', document.getElementById('meta_description').value.length, 160);
        });

        // Form validation
        document.getElementById('articleForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const excerpt = document.getElementById('excerpt').value.trim();
            const content = tinymce.get('content').getContent();
            const categoryId = document.getElementById('category_id').value;

            let errors = [];

            // Validate required fields
            if (!title) {
                errors.push('Judul artikel wajib diisi');
            }

            if (!excerpt) {
                errors.push('Ringkasan artikel wajib diisi');
            }

            if (!content || content.trim() === '') {
                errors.push('Konten artikel wajib diisi');
            }

            if (!categoryId) {
                errors.push('Kategori wajib dipilih');
            }

            // Validate field lengths
            if (title.length > 255) {
                errors.push('Judul artikel maksimal 255 karakter');
            }

            if (excerpt.length > 500) {
                errors.push('Ringkasan artikel maksimal 500 karakter');
            }

            const metaTitle = document.getElementById('meta_title').value;
            if (metaTitle.length > 60) {
                errors.push('Meta title maksimal 60 karakter');
            }

            const metaDescription = document.getElementById('meta_description').value;
            if (metaDescription.length > 160) {
                errors.push('Meta description maksimal 160 karakter');
            }

            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                showErrorMessage(errors);
                return false;
            }

            // Show loading state
            showLoadingState();
        });

        function showErrorMessage(errors) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show animate-fade-in';
            alertDiv.innerHTML = `
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terdapat kesalahan:
                </h5>
                <ul class="mb-0">
                    ${errors.map(error => `<li>${error}</li>`).join('')}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const container = document.querySelector('.container-fluid');
            const existingAlert = container.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            container.insertBefore(alertDiv, container.firstChild);

            // Scroll to top to show error
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showLoadingState() {
            const submitBtn = document.querySelector('button[type="submit"]');
            const floatingBtn = document.querySelector('.floating-save');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            floatingBtn.disabled = true;
            floatingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        }

        // SEO Score Calculator
        // function calculateSeoScore() {
        //     const title = document.getElementById('title').value.trim();
        //     const excerpt = document.getElementById('excerpt').value.trim();
        //     const content = tinymce.get('content').getContent({
        //         format: 'text'
        //     });
        //     const metaTitle = document.getElementById('meta_title').value.trim();
        //     const metaDescription = document.getElementById('meta_description').value.trim();

        //     let score = 0;
        //     let maxScore = 100;
        //     let suggestions = [];

        //     // Title evaluation (20 points)
        //     if (title.length >= 30 && title.length <= 60) {
        //         score += 20;
        //     } else if (title.length > 0) {
        //         score += 10;
        //         suggestions.push('Judul sebaiknya 30-60 karakter');
        //     }

        //     // Excerpt evaluation (15 points)
        //     if (excerpt.length >= 120 && excerpt.length <= 160) {
        //         score += 15;
        //     } else if (excerpt.length > 0) {
        //         score += 8;
        //         suggestions.push('Ringkasan sebaiknya 120-160 karakter');
        //     }

        //     // Content length evaluation (20 points)
        //     const wordCount = content.trim().split(/\s+/).filter(word => word.length > 0).length;
        //     if (wordCount >= 300) {
        //         score += 20;
        //     } else if (wordCount >= 150) {
        //         score += 15;
        //     } else if (wordCount > 0) {
        //         score += 5;
        //         suggestions.push('Konten sebaiknya minimal 300 kata');
        //     }

        //     // Meta title evaluation (15 points)
        //     if (metaTitle.length >= 30 && metaTitle.length <= 60) {
        //         score += 15;
        //     } else if (metaTitle.length > 0) {
        //         score += 8;
        //         suggestions.push('Meta title sebaiknya 30-60 karakter');
        //     }

        //     // Meta description evaluation (15 points)
        //     if (metaDescription.length >= 120 && metaDescription.length <= 160) {
        //         score += 15;
        //     } else if (metaDescription.length > 0) {
        //         score += 8;
        //         suggestions.push('Meta description sebaiknya 120-160 karakter');
        //     }

        //     // Featured image evaluation (10 points)
        //     const featuredImage = document.getElementById('featured_image').files[0];
        //     if (featuredImage || '{{ $artikel->featured_image }}') {
        //         score += 10;
        //     } else {
        //         suggestions.push('Tambahkan gambar unggulan');
        //     }

        //     // Category evaluation (5 points)
        //     const categoryId = document.getElementById('category_id').value;
        //     if (categoryId) {
        //         score += 5;
        //     } else {
        //         suggestions.push('Pilih kategori artikel');
        //     }

        //     // updateSeoScoreDisplay(score, suggestions);
        // }

        // function updateSeoScoreDisplay(score, suggestions) {
        //     const seoScoreEl = document.getElementById('seo-score');
        //     const seoSuggestionsEl = document.getElementById('seo-suggestions');

        //     if (seoScoreEl) {
        //         let className = 'seo-poor';
        //         let icon = 'fas fa-times-circle';

        //         if (score >= 80) {
        //             className = 'seo-excellent';
        //             icon = 'fas fa-check-circle';
        //         } else if (score >= 60) {
        //             className = 'seo-good';
        //             icon = 'fas fa-exclamation-circle';
        //         }

        //         seoScoreEl.className = `seo-score ${className}`;
        //         seoScoreEl.innerHTML = `
    //             <i class="${icon}"></i>
    //             SEO Score: ${score}/100
    //         `;
        //     }

        //     if (seoSuggestionsEl) {
        //         if (suggestions.length > 0) {
        //             seoSuggestionsEl.innerHTML = `
    //                 <div class="mt-2">
    //                     <strong>Saran Perbaikan:</strong>
    //                     <ul class="mb-0 mt-1">
    //                         ${suggestions.map(suggestion => `<li>${suggestion}</li>`).join('')}
    //                     </ul>
    //                 </div>
    //             `;
        //         } else {
        //             seoSuggestionsEl.innerHTML = `
    //                 <div class="mt-2 text-success">
    //                     <i class="fas fa-check me-1"></i>
    //                     SEO sudah optimal!
    //                 </div>
    //             `;
        //         }
        //     }
        // }

        // Real-time SEO score calculation
        // function bindSeoCalculation() {
        //     const fieldsToWatch = ['title', 'excerpt', 'meta_title', 'meta_description', 'category_id'];

        //     fieldsToWatch.forEach(fieldId => {
        //         const field = document.getElementById(fieldId);
        //         if (field) {
        //             field.addEventListener('input', calculateSeoScore);
        //         }
        //     });

        //     // Watch for TinyMCE content changes
        //     tinymce.get('content').on('keyup', calculateSeoScore);

        //     // Watch for featured image changes
        //     document.getElementById('featured_image').addEventListener('change', calculateSeoScore);
        // }

        // SEO Score Calculator - Fixed Version
        function calculateSeoScore() {
            const title = document.getElementById('title').value.trim();
            const excerpt = document.getElementById('excerpt').value.trim();
            const metaTitle = document.getElementById('meta_title').value.trim();
            const metaDescription = document.getElementById('meta_description').value.trim();
            const categoryId = document.getElementById('category_id').value;
            const canonicalUrl = document.getElementById('canonical_url').value.trim();
            const featuredImageAlt = document.getElementById('featured_image_alt').value.trim();

            // Get content from TinyMCE
            let content = '';
            try {
                content = tinymce.get('content').getContent({
                    format: 'text'
                });
            } catch (e) {
                content = document.getElementById('content').value;
            }

            // Check if featured image exists (current or new)
            const featuredImage = document.getElementById('featured_image').files[0];
            const hasExistingImage = document.getElementById('preview-img').src &&
                document.getElementById('preview-img').src !== window.location.origin + '/';
            const hasFeaturedImage = featuredImage || hasExistingImage;

            // Check selected tags
            const selectedTags = document.querySelectorAll('input[name="tags[]"]:checked');

            let score = 0;
            const maxScore = 10;
            let suggestions = [];

            // 1. Title length evaluation (2 points)
            const titleLength = title.length;
            if (titleLength >= 30 && titleLength <= 60) {
                score += 2;
            } else if (titleLength >= 20 && titleLength <= 80) {
                score += 1;
            } else if (titleLength > 0) {
                if (titleLength < 30) {
                    suggestions.push('Judul terlalu pendek. Ideal: 30-60 karakter');
                } else {
                    suggestions.push('Judul terlalu panjang. Ideal: 30-60 karakter');
                }
            }

            // 2. Meta description evaluation (2 points)
            const effectiveMetaDesc = metaDescription || excerpt;
            const metaDescLength = effectiveMetaDesc.length;
            if (metaDescLength >= 120 && metaDescLength <= 160) {
                score += 2;
            } else if (metaDescLength >= 100 && metaDescLength <= 180) {
                score += 1;
            } else if (metaDescLength > 0) {
                if (metaDescLength < 120) {
                    suggestions.push('Meta description terlalu pendek. Ideal: 120-160 karakter');
                } else {
                    suggestions.push('Meta description terlalu panjang. Ideal: 120-160 karakter');
                }
            }

            // 3. Featured image evaluation (1 point)
            if (hasFeaturedImage) {
                score += 1;
            } else {
                suggestions.push('Tambahkan gambar unggulan untuk meningkatkan SEO');
            }

            // 4. Image alt text evaluation (1 point)
            if (hasFeaturedImage && featuredImageAlt) {
                score += 1;
            } else if (hasFeaturedImage && !featuredImageAlt) {
                suggestions.push('Tambahkan alt text untuk gambar unggulan');
            }

            // 5. Content length evaluation (2 points)
            const wordCount = content.trim().split(/\s+/).filter(word => word.length > 0).length;
            if (wordCount >= 300) {
                score += 2;
            } else if (wordCount >= 150) {
                score += 1;
            } else if (wordCount > 0) {
                suggestions.push(`Konten terlalu pendek (${wordCount} kata). Minimal 300 kata untuk SEO optimal`);
            }

            // 6. Tags evaluation (1 point)
            if (selectedTags.length > 0) {
                score += 1;
            } else {
                suggestions.push('Tambahkan tag untuk meningkatkan kategorisasi');
            }

            // 7. Canonical URL evaluation (1 point)
            if (canonicalUrl) {
                score += 1;
            } else {
                suggestions.push('Tambahkan canonical URL untuk mencegah duplicate content');
            }

            // Convert to percentage
            const scorePercentage = Math.round((score / maxScore) * 100);

            // Additional suggestions based on other factors
            if (!categoryId) {
                suggestions.push('Pilih kategori artikel');
            }

            if (!metaTitle && title) {
                suggestions.push('Meta title akan otomatis diisi dari judul');
            }

            if (!metaDescription && excerpt) {
                suggestions.push('Meta description akan otomatis diisi dari ringkasan');
            }

            updateSeoScoreDisplay(scorePercentage, suggestions, {
                titleLength,
                metaDescLength,
                wordCount,
                hasFeaturedImage,
                hasImageAlt: featuredImageAlt.length > 0,
                hasTagsSelected: selectedTags.length > 0,
                hasCanonicalUrl: canonicalUrl.length > 0
            });

            return scorePercentage;
        }

        function updateSeoScoreDisplay(score, suggestions, details) {
            const seoScoreEl = document.getElementById('seo-score');
            const seoSuggestionsEl = document.getElementById('seo-suggestions');

            if (seoScoreEl) {
                let className = 'seo-poor';
                let icon = 'fas fa-times-circle';
                let statusText = 'Perlu Perbaikan';

                if (score >= 80) {
                    className = 'seo-excellent';
                    icon = 'fas fa-check-circle';
                    statusText = 'Excellent';
                } else if (score >= 60) {
                    className = 'seo-good';
                    icon = 'fas fa-exclamation-circle';
                    statusText = 'Good';
                }

                seoScoreEl.innerHTML = `
                    <span class="seo-score ${className}">
                        <i class="${icon}"></i>
                        SEO Score: ${score}/100 (${statusText})
                    </span>
                `;
            }

            if (seoSuggestionsEl) {
                if (suggestions.length > 0) {
                    seoSuggestionsEl.innerHTML = `
                <div class="alert alert-info mt-3">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Saran Perbaikan SEO:
                    </h6>
                    <ul class="mb-0">
                        ${suggestions.map(suggestion => `<li>${suggestion}</li>`).join('')}
                    </ul>
                </div>
            `;
                } else {
                    seoSuggestionsEl.innerHTML = `
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>SEO sudah optimal!</strong> Artikel Anda siap dipublikasikan.
                </div>
            `;
                }

                // Add SEO details breakdown
                const detailsHtml = `
            <div class="seo-details mt-3">
                <h6>Detail SEO:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="${details.titleLength >= 30 && details.titleLength <= 60 ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.titleLength >= 30 && details.titleLength <= 60 ? 'check' : 'exclamation-triangle'}"></i>
                                Judul: ${details.titleLength} karakter
                            </li>
                            <li class="${details.metaDescLength >= 120 && details.metaDescLength <= 160 ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.metaDescLength >= 120 && details.metaDescLength <= 160 ? 'check' : 'exclamation-triangle'}"></i>
                                Meta Description: ${details.metaDescLength} karakter
                            </li>
                            <li class="${details.wordCount >= 300 ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.wordCount >= 300 ? 'check' : 'exclamation-triangle'}"></i>
                                Konten: ${details.wordCount} kata
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="${details.hasFeaturedImage ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.hasFeaturedImage ? 'check' : 'times'}"></i>
                                Gambar Unggulan: ${details.hasFeaturedImage ? 'Ada' : 'Tidak Ada'}
                            </li>
                            <li class="${details.hasImageAlt ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.hasImageAlt ? 'check' : 'times'}"></i>
                                Alt Text: ${details.hasImageAlt ? 'Ada' : 'Tidak Ada'}
                            </li>
                            <li class="${details.hasTagsSelected ? 'text-success' : 'text-warning'}">
                                <i class="fas fa-${details.hasTagsSelected ? 'check' : 'times'}"></i>
                                Tags: ${details.hasTagsSelected ? 'Dipilih' : 'Belum Dipilih'}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        `;

                seoSuggestionsEl.innerHTML += detailsHtml;
            }
        }

        // Improved event binding for real-time calculation
        function bindSeoCalculation() {
            const fieldsToWatch = ['title', 'excerpt', 'meta_title', 'meta_description', 'category_id', 'canonical_url',
                'featured_image_alt'
            ];

            fieldsToWatch.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', debounce(calculateSeoScore, 300));
                    field.addEventListener('change', calculateSeoScore);
                }
            });

            // Watch for TinyMCE content changes
            if (typeof tinymce !== 'undefined') {
                tinymce.get('content').on('keyup', debounce(calculateSeoScore, 500));
                tinymce.get('content').on('change', calculateSeoScore);
            }

            // Watch for featured image changes
            const featuredImageInput = document.getElementById('featured_image');
            if (featuredImageInput) {
                featuredImageInput.addEventListener('change', calculateSeoScore);
            }

            // Watch for tag selection changes
            const tagCheckboxes = document.querySelectorAll('input[name="tags[]"]');
            tagCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', calculateSeoScore);
            });
        }

        // Debounce function to prevent excessive calculations
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize SEO calculation
            // setTimeout(() => {
            //     bindSeoCalculation();
            //     calculateSeoScore();
            // }, 1000);

            const initSeo = () => {
                if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                    bindSeoCalculation();
                    calculateSeoScore();
                } else {
                    setTimeout(initSeo, 500);
                }
            };

            initSeo();

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Confirm before leaving page if there are unsaved changes
            let hasUnsavedChanges = false;

            document.getElementById('articleForm').addEventListener('input', function() {
                hasUnsavedChanges = true;
            });

            document.getElementById('articleForm').addEventListener('submit', function() {
                hasUnsavedChanges = false;
            });

            window.addEventListener('beforeunload', function(e) {
                if (hasUnsavedChanges) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                }
            });
        });
    </script>
@endpush
