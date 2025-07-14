@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Tambah Artikel</h1>
                    <a href="{{ route('artikel.artikel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('artikel.artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Dasar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Artikel *</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="excerpt" class="form-label">Ringkasan *</label>
                                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt') }}</textarea>
                                        <small class="form-text text-muted">Maksimal 500 karakter</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Konten *</label>
                                        <textarea class="form-control" id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Pengaturan SEO</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title') }}">
                                        <small class="form-text text-muted">Optimal: 50-60 karakter</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                        <small class="form-text text-muted">Optimal: 150-160 karakter</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="canonical_url" class="form-label">Canonical URL</label>
                                        <input type="url" class="form-control" id="canonical_url" name="canonical_url"
                                            value="{{ old('canonical_url') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Publish Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Pengaturan Publikasi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                                Published</option>
                                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                                Archived</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tags</label>
                                        <div class="row">
                                            @foreach ($tags as $tag)
                                                <div class="col-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                                            value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tag_{{ $tag->id }}">
                                                            {{ $tag->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Artikel Unggulan
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_breaking"
                                            value="1" id="is_breaking" {{ old('is_breaking') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_breaking">
                                            Berita Terkini
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Gambar Unggulan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="featured_image" class="form-label">Upload Gambar</label>
                                        <input type="file" class="form-control" id="featured_image"
                                            name="featured_image" accept="image/*" onchange="previewImage(event)">
                                        <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal
                                            2MB</small>
                                    </div>

                                    <div id="image-preview" class="mb-3" style="display: none;">
                                        <img id="preview-img" src="" class="img-fluid rounded"
                                            style="max-height: 200px;">
                                    </div>

                                    <div class="mb-3">
                                        <label for="featured_image_alt" class="form-label">Alt Text</label>
                                        <input type="text" class="form-control" id="featured_image_alt"
                                            name="featured_image_alt" value="{{ old('featured_image_alt') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="featured_image_caption" class="form-label">Caption</label>
                                        <textarea class="form-control" id="featured_image_caption" name="featured_image_caption" rows="2">{{ old('featured_image_caption') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save"></i> Simpan Artikel
                                        </button>
                                        <a href="{{ route('artikel.artikel.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Auto-generate meta title from title
        document.getElementById('title').addEventListener('input', function() {
            const metaTitle = document.getElementById('meta_title');
            if (!metaTitle.value) {
                metaTitle.value = this.value;
            }
        });

        // Auto-generate meta description from excerpt
        document.getElementById('excerpt').addEventListener('input', function() {
            const metaDescription = document.getElementById('meta_description');
            if (!metaDescription.value) {
                metaDescription.value = this.value;
            }
        });

        // Character counters
        function addCharacterCounter(inputId, maxLength) {
            const input = document.getElementById(inputId);
            const counterDiv = document.createElement('div');
            counterDiv.className = 'form-text text-muted';
            counterDiv.style.textAlign = 'right';
            input.parentNode.appendChild(counterDiv);

            function updateCounter() {
                const length = input.value.length;
                counterDiv.textContent = `${length}/${maxLength} karakter`;

                if (length > maxLength) {
                    counterDiv.className = 'form-text text-danger';
                } else if (length > maxLength * 0.9) {
                    counterDiv.className = 'form-text text-warning';
                } else {
                    counterDiv.className = 'form-text text-muted';
                }
            }

            input.addEventListener('input', updateCounter);
            updateCounter();
        }

        // Add character counters
        addCharacterCounter('title', 255);
        addCharacterCounter('excerpt', 500);
        addCharacterCounter('meta_title', 60);
        addCharacterCounter('meta_description', 160);
    </script>
@endpush
