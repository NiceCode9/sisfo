@extends('layouts.app')

@section('title', 'Kelola Komentar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Kelola Komentar</h1>
                    <a href="{{ route('artikel.artikel.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Artikel
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
                        <form method="GET" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Cari Komentar</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Konten, nama, atau email...">
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('artikel.komentar.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button class="btn btn-outline-success btn-sm me-2" id="bulkApproveBtn">
                                    <i class="fas fa-check-circle"></i> Setujui
                                </button>
                                <button class="btn btn-outline-danger btn-sm me-2" id="bulkRejectBtn">
                                    <i class="fas fa-times-circle"></i> Tolak
                                </button>
                                <button class="btn btn-outline-dark btn-sm" id="bulkDeleteBtn">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                            <div class="text-muted">
                                Total: {{ $comments->count() }} komentar
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th>Komentar</th>
                                        <th>Artikel</th>
                                        <th>Penulis</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($comments as $comment)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="comment-checkbox" value="{{ $comment->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @if ($comment->parent_id)
                                                        <span class="me-2 text-muted" title="Balasan">
                                                            <i class="fas fa-reply"></i>
                                                        </span>
                                                    @endif
                                                    <div>
                                                        <p class="mb-1">{{ Str::limit($comment->content, 100) }}</p>
                                                        <small class="text-muted">
                                                            {{ $comment->ip_address }} • {{ $comment->user_agent }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('artikel.artikel.show', $comment->article->slug) }}"
                                                    target="_blank">
                                                    {{ Str::limit($comment->article->title, 30) }}
                                                </a>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $comment->author_name }}</strong>
                                                    <small class="d-block text-muted">{{ $comment->author_email }}</small>
                                                    @if ($comment->author_website)
                                                        <small class="d-block">
                                                            <a href="{{ $comment->author_website }}" target="_blank">
                                                                {{ parse_url($comment->author_website, PHP_URL_HOST) }}
                                                            </a>
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ $comment->created_at->format('d M Y, H:i') }}</small>
                                            </td>
                                            <td>
                                                @if ($comment->status === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($comment->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if ($comment->status !== 'approved')
                                                        <button class="btn btn-sm btn-outline-success approve-btn"
                                                            data-id="{{ $comment->id }}" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                    @if ($comment->status !== 'rejected')
                                                        <button class="btn btn-sm btn-outline-warning reject-btn"
                                                            data-id="{{ $comment->id }}" title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="{{ $comment->id }}" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-comments fa-3x mb-3"></i>
                                                    <p>Tidak ada komentar yang ditemukan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        {{-- @if ($comments->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $comments->links() }}
                            </div>
                        @endif --}}
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
                    <p>Apakah Anda yakin ingin menghapus komentar ini?</p>
                    <p class="text-danger"><small>Tindakan ini akan menghapus semua balasan terkait dan tidak dapat
                            dibatalkan.</small></p>
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

    <!-- Bulk Actions Modal -->
    <div class="modal fade" id="bulkActionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkActionTitle">Bulk Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="bulkActionBody">
                    <!-- Content will be filled by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmBulkAction">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .comment-reply {
            background-color: #f8f9fa;
            border-left: 3px solid #dee2e6;
            padding-left: 15px;
            margin-left: 20px;
        }

        .comment-checkbox {
            margin-top: 0.3rem;
        }

        #selectAll {
            margin-top: 0.3rem;
        }
    </style>
@endpush

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        $(document).ready(function() {
            // Delete button click
            $(document).on('click', '.delete-btn', function() {
                let commentId = $(this).data('id');
                confirmDelete(commentId);
            });

            // Approve button click
            $(document).on('click', '.approve-btn', function() {
                let commentId = $(this).data('id');
                approveComment(commentId);
            });

            // Reject button click
            $(document).on('click', '.reject-btn', function() {
                let commentId = $(this).data('id');
                rejectComment(commentId);
            });

            // Select all checkbox
            $('#selectAll').change(function() {
                $('.comment-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Bulk approve
            $('#bulkApproveBtn').click(function() {
                const selected = getSelectedComments();
                if (selected.length > 0) {
                    showBulkActionModal('Setujui Komentar',
                        `Anda akan menyetujui ${selected.length} komentar. Lanjutkan?`,
                        'approve', selected);
                } else {
                    Swal.fire('Peringatan', 'Pilih setidaknya satu komentar', 'warning');
                }
            });

            // Bulk reject
            $('#bulkRejectBtn').click(function() {
                const selected = getSelectedComments();
                if (selected.length > 0) {
                    showBulkActionModal('Tolak Komentar',
                        `Anda akan menolak ${selected.length} komentar. Lanjutkan?`,
                        'reject', selected);
                } else {
                    Swal.fire('Peringatan', 'Pilih setidaknya satu komentar', 'warning');
                }
            });

            // Bulk delete
            $('#bulkDeleteBtn').click(function() {
                const selected = getSelectedComments();
                if (selected.length > 0) {
                    showBulkActionModal('Hapus Komentar',
                        `Anda akan menghapus ${selected.length} komentar beserta semua balasannya. Tindakan ini tidak dapat dibatalkan. Lanjutkan?`,
                        'delete', selected);
                } else {
                    Swal.fire('Peringatan', 'Pilih setidaknya satu komentar', 'warning');
                }
            });

            // Confirm bulk action
            $('#confirmBulkAction').click(function() {
                const action = $(this).data('action');
                const commentIds = $(this).data('commentIds');

                $.ajax({
                    url: '/manage-artikel/komentar/bulk-action',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action,
                        comment_ids: commentIds
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Sukses', response.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan saat memproses permintaan',
                            'error');
                    }
                });
            });
        });

        function confirmDelete(commentId) {
            const form = document.getElementById('deleteForm');
            form.action = `/manage-artikel/komentar/${commentId}`;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        function approveComment(commentId) {
            Swal.fire({
                title: 'Setujui Komentar?',
                text: 'Komentar akan ditampilkan di halaman artikel.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/manage-artikel/komentar/${commentId}/approve`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Sukses', response.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan saat menyetujui komentar', 'error');
                        }
                    });
                }
            });
        }

        function rejectComment(commentId) {
            Swal.fire({
                title: 'Tolak Komentar?',
                text: 'Komentar tidak akan ditampilkan di halaman artikel.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/artikel/komentar/${commentId}/reject`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Sukses', response.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan saat menolak komentar', 'error');
                        }
                    });
                }
            });
        }

        function getSelectedComments() {
            const selected = [];
            $('.comment-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            return selected;
        }

        function showBulkActionModal(title, message, action, commentIds) {
            $('#bulkActionTitle').text(title);
            $('#bulkActionBody').html(`<p>${message}</p>`);
            $('#confirmBulkAction')
                .data('action', action)
                .data('commentIds', commentIds);

            const modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
            modal.show();
        }
    </script>
@endpush
