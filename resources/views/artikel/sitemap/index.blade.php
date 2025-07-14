@extends('layouts.app')

@section('title', 'Kelola Sitemap')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Kelola Sitemap</h1>
                    <div>
                        <a href="{{ route('sitemap.xml') }}" class="btn btn-outline-info" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Lihat XML
                        </a>
                        <button type="button" class="btn btn-warning" onclick="generateSitemap()">
                            <i class="fas fa-refresh"></i> Generate Sitemap
                        </button>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-primary">{{ $sitemaps->where('type', 'article')->count() }}</h4>
                                <small class="text-muted">Artikel</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-success">{{ $sitemaps->where('type', 'category')->count() }}</h4>
                                <small class="text-muted">Kategori</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-info">{{ $sitemaps->where('type', 'page')->count() }}</h4>
                                <small class="text-muted">Halaman</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-warning">{{ $sitemaps->where('type', 'static')->count() }}</h4>
                                <small class="text-muted">Static</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sitemap Table -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar URL Sitemap</h5>
                            <form method="POST" action="{{ route('admin.sitemap.bulk-delete') }}" id="bulk-delete-form">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()" disabled
                                    id="bulk-delete-btn">
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th>URL</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Change Frequency</th>
                                        <th>Last Modified</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sitemaps as $sitemap)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected[]" value="{{ $sitemap->id }}"
                                                    class="sitemap-checkbox">
                                            </td>
                                            <td>
                                                <a href="{{ $sitemap->url }}" target="_blank" class="text-decoration-none">
                                                    {{ Str::limit($sitemap->url, 60) }}
                                                    <i class="fas fa-external-link-alt fa-xs ms-1"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($sitemap->type === 'article') bg-primary
                                                @elseif($sitemap->type === 'category') bg-success
                                                @elseif($sitemap->type === 'page') bg-info
                                                @else bg-warning @endif">
                                                    {{ ucfirst($sitemap->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress" style="width: 50px; height: 8px;">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ $sitemap->priority * 100 }}%"></div>
                                                    </div>
                                                    <small class="ms-2">{{ $sitemap->priority }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $sitemap->changefreq }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $sitemap->last_modified->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $sitemap->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-sitemap fa-3x mb-3"></i>
                                                    <p>Tidak ada entry sitemap yang ditemukan.</p>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="generateSitemap()">
                                                        Generate Sitemap
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($sitemaps->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $sitemaps->links() }}
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
                    <p>Apakah Anda yakin ingin menghapus entry sitemap ini?</p>
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

    <!-- Generate Sitemap Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Sitemap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Proses generate sitemap akan menghapus semua entry sitemap yang ada dan membuat ulang berdasarkan
                        data terbaru.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Proses ini mungkin memakan waktu beberapa menit tergantung jumlah
                        konten.
                    </div>
                    <div id="generateProgress" class="d-none">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"
                                id="progressBar"></div>
                        </div>
                        <div id="progressText">Memulai generate sitemap...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="startGenerate()">
                        <i class="fas fa-refresh"></i> Mulai Generate
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <span id="selectedCount">0</span> entry sitemap yang dipilih?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash"></i> Hapus Semua
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const sitemapCheckboxes = document.querySelectorAll('.sitemap-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                sitemapCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });

            // Individual checkbox change
            sitemapCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                    updateBulkDeleteButton();
                });
            });

            function updateSelectAllCheckbox() {
                const checkedCount = document.querySelectorAll('.sitemap-checkbox:checked').length;
                const totalCount = sitemapCheckboxes.length;

                selectAllCheckbox.checked = checkedCount === totalCount;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
            }

            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.sitemap-checkbox:checked').length;
                bulkDeleteBtn.disabled = checkedCount === 0;
            }
        });

        function confirmDelete(id) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/sitemap/${id}`;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        function generateSitemap() {
            const modal = new bootstrap.Modal(document.getElementById('generateModal'));
            modal.show();
        }

        function startGenerate() {
            const progressDiv = document.getElementById('generateProgress');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            progressDiv.classList.remove('d-none');
            progressBar.style.width = '10%';
            progressText.textContent = 'Memulai generate sitemap...';

            // Simulate progress
            let progress = 10;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 90) progress = 90;

                progressBar.style.width = progress + '%';

                if (progress < 30) {
                    progressText.textContent = 'Mengumpulkan data artikel...';
                } else if (progress < 60) {
                    progressText.textContent = 'Mengumpulkan data kategori dan halaman...';
                } else {
                    progressText.textContent = 'Menyimpan sitemap...';
                }
            }, 500);

            // Make actual request
            fetch('{{ route('admin.sitemap.generate') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    clearInterval(interval);
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Sitemap berhasil di-generate!';

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                })
                .catch(error => {
                    clearInterval(interval);
                    progressBar.classList.add('bg-danger');
                    progressText.textContent = 'Terjadi kesalahan saat generate sitemap.';
                    console.error('Error:', error);
                });
        }

        function bulkDelete() {
            const checkedBoxes = document.querySelectorAll('.sitemap-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Pilih setidaknya satu item untuk dihapus.');
                return;
            }

            document.getElementById('selectedCount').textContent = checkedBoxes.length;

            const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
            modal.show();
        }

        function confirmBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.sitemap-checkbox:checked');
            const form = document.getElementById('bulk-delete-form');

            // Add selected IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });

            form.submit();
        }

        // Auto-refresh statistics every 30 seconds
        setInterval(() => {
            fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update statistics cards
                    const currentStats = document.querySelectorAll('.card-body h4');
                    const newStats = doc.querySelectorAll('.card-body h4');

                    currentStats.forEach((stat, index) => {
                        if (newStats[index]) {
                            stat.textContent = newStats[index].textContent;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error updating statistics:', error);
                });
        }, 30000);
    </script>
@endsection
