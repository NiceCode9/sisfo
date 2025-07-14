@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Kelola Artikel</h1>
                    <a href="{{ route('artikel.artikel.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('artikel.artikel.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Cari Artikel</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Judul, excerpt, atau konten...">
                                </div>
                                <div class="col-md-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>
                                            Archived</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('artikel.artikel.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Articles Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Featured Image</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>SEO Score</th>
                                        <th>Views</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($articles as $article)
                                        <tr>
                                            <td>
                                                @if ($article->featured_image)
                                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                        class="img-thumbnail"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ Str::limit($article->title, 50) }}</h6>
                                                    <small
                                                        class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                                    @if ($article->is_featured)
                                                        <span class="badge bg-warning ms-1">Featured</span>
                                                    @endif
                                                    @if ($article->is_breaking)
                                                        <span class="badge bg-danger ms-1">Breaking</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $article->category->name }}</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm status-toggle" data-id="{{ $article->id }}"
                                                    data-status="{{ $article->status }}">
                                                    @if ($article->status === 'published')
                                                        <span class="badge bg-success">Published</span>
                                                    @elseif($article->status === 'draft')
                                                        <span class="badge bg-warning">Draft</span>
                                                    @else
                                                        <span class="badge bg-secondary">Archived</span>
                                                    @endif
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar
                                                        @if ($article->seo_score >= 8) bg-success
                                                        @elseif($article->seo_score >= 5) bg-warning
                                                        @else bg-danger @endif"
                                                            style="width: {{ ($article->seo_score / 10) * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small class="ms-2">{{ $article->seo_score }}/10</small>
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ number_format($article->views_count) }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $article->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('artikel.artikel.show', $article) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('artikel.artikel.edit', $article) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $article->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-newspaper fa-3x mb-3"></i>
                                                    <p>Tidak ada artikel yang ditemukan.</p>
                                                    <a href="{{ route('artikel.artikel.create') }}"
                                                        class="btn btn-primary">
                                                        Buat Artikel Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($articles->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $articles->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus artikel ini?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function confirmDelete(articleId) {
            const form = document.getElementById('deleteForm');
            form.action = `/artikel/artikel/${articleId}`;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Status toggle
        document.querySelectorAll('.status-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const articleId = this.dataset.id;
                const currentStatus = this.dataset.status;

                fetch(`/artikel/artikel/${articleId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan saat mengubah status.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status.');
                    });
            });
        });
    </script>
@endpush
