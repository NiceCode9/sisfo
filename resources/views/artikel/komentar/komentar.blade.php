@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Manajemen Komentar</h1>
                    <a href="{{ route('artikel.komentar.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Komentar
                    </a>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Total Komentar</h6>
                                        <h2 class="mb-0" id="total-comments">{{ $comments->total() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-comments fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Menunggu Persetujuan</h6>
                                        <h2 class="mb-0" id="pending-comments">
                                            {{ $comments->where('status', 'pending')->count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Disetujui</h6>
                                        <h2 class="mb-0" id="approved-comments">
                                            {{ $comments->where('status', 'approved')->count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Ditolak</h6>
                                        <h2 class="mb-0" id="rejected-comments">
                                            {{ $comments->where('status', 'trash')->count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-times-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter and Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('artikel.komentar.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="trash" {{ request('status') == 'trash' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="article_id" class="form-label">Artikel</label>
                                <select name="article_id" id="article_id" class="form-select">
                                    <option value="">Semua Artikel</option>
                                    @foreach ($articles as $article)
                                        <option value="{{ $article->id }}"
                                            {{ request('article_id') == $article->id ? 'selected' : '' }}>
                                            {{ Str::limit($article->title, 50) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="search" class="form-label">Cari</label>
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Cari komentar, nama, atau email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Comments Table -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Daftar Komentar</h5>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm" id="bulk-approve" disabled>
                                    <i class="fas fa-check"></i> Setujui Terpilih
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" id="bulk-reject" disabled>
                                    <i class="fas fa-times"></i> Tolak Terpilih
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" id="bulk-delete" disabled>
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($comments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                            </th>
                                            <th>Penulis</th>
                                            <th>Artikel</th>
                                            <th>Komentar</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $comment)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input comment-checkbox"
                                                        value="{{ $comment->id }}">
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $comment->author_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $comment->author_email }}</small>
                                                        @if ($comment->author_website)
                                                            <br>
                                                            <a href="{{ $comment->author_website }}" target="_blank"
                                                                class="text-decoration-none">
                                                                <small>{{ $comment->author_website }}</small>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('artikel.artikel.show', $comment->article->slug) }}"
                                                        target="_blank" class="text-decoration-none">
                                                        {{ Str::limit($comment->article->title, 40) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="comment-content">
                                                        {{ Str::limit($comment->content, 80) }}
                                                        @if ($comment->parent_id)
                                                            <br>
                                                            <small class="text-muted">
                                                                <i class="fas fa-reply"></i> Balasan untuk:
                                                                {{ Str::limit($comment->parent->content, 30) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($comment->status == 'pending')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif($comment->status == 'approved')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($comment->status == 'trash')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{ $comment->created_at->format('d M Y') }}</small>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $comment->created_at->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        {{-- <a href="{{ route('artikel.komentar.show', $comment) }}"
                                                            class="btn btn-outline-primary" title="Lihat">
                                                            <i class="fas fa-eye"></i>
                                                        </a> --}}
                                                        <a href="{{ route('artikel.komentar.edit', $comment) }}"
                                                            class="btn btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($comment->status == 'pending')
                                                            <button type="button"
                                                                class="btn btn-outline-success approve-btn"
                                                                data-id="{{ $comment->id }}" title="Setujui">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-outline-danger reject-btn"
                                                                data-id="{{ $comment->id }}" title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn btn-outline-danger delete-btn"
                                                            data-id="{{ $comment->id }}" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $comments->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>Tidak ada komentar</h5>
                                <p class="text-muted">Belum ada komentar yang tersedia.</p>
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
                    <p>Apakah Anda yakin ingin menghapus komentar ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            // Select all checkbox
            $('#select-all').change(function() {
                $('.comment-checkbox').prop('checked', $(this).is(':checked'));
                toggleBulkButtons();
            });

            // Individual checkbox change
            $('.comment-checkbox').change(function() {
                toggleBulkButtons();

                // Update select all checkbox
                if ($('.comment-checkbox:checked').length === $('.comment-checkbox').length) {
                    $('#select-all').prop('checked', true);
                } else {
                    $('#select-all').prop('checked', false);
                }
            });

            // Toggle bulk action buttons
            function toggleBulkButtons() {
                const checkedCount = $('.comment-checkbox:checked').length;
                $('#bulk-approve, #bulk-reject, #bulk-delete').prop('disabled', checkedCount === 0);
            }

            // Approve comment
            $('.approve-btn').click(function() {
                const commentId = $(this).data('id');
                const button = $(this);

                $.ajax({
                    url: `/manage-artikel/komentar/${commentId}/approve`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'Terjadi kesalahan saat menyetujui komentar.');
                    }
                });
            });

            // Reject comment
            $('.reject-btn').click(function() {
                const commentId = $(this).data('id');

                $.ajax({
                    url: `/manage-artikel/komentar/${commentId}/reject`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'Terjadi kesalahan saat menolak komentar.');
                    }
                });
            });

            // Delete comment
            $('.delete-btn').click(function() {
                const commentId = $(this).data('id');
                $('#deleteForm').attr('action', `/manage-artikel/komentar/${commentId}`);
                $('#deleteModal').modal('show');
            });

            // Bulk approve
            $('#bulk-approve').click(function() {
                const selectedIds = $('.comment-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) return;

                $.ajax({
                    url: '/manage-artikel/komentar/bulk/approve',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        comment_ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'Terjadi kesalahan saat menyetujui komentar.');
                    }
                });
            });

            // Bulk reject
            $('#bulk-reject').click(function() {
                const selectedIds = $('.comment-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) return;

                $.ajax({
                    url: '/manage-artikel/komentar/bulk/reject',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        comment_ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'Terjadi kesalahan saat menolak komentar.');
                    }
                });
            });

            // Bulk delete
            $('#bulk-delete').click(function() {
                const selectedIds = $('.comment-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) return;

                if (confirm('Apakah Anda yakin ingin menghapus semua komentar yang dipilih?')) {
                    $.ajax({
                        url: '/manage-artikel/komentar/bulk/delete',
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            comment_ids: selectedIds
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                                showAlert('success', response.message);
                            }
                        },
                        error: function() {
                            showAlert('error', 'Terjadi kesalahan saat menghapus komentar.');
                        }
                    });
                }
            });

            // Show alert function
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top
                $('.container-fluid').prepend(alertHtml);

                // Auto hide after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }
        });
    </script>
@endpush --}}

@push('scripts')
    <script>
        $(document).ready(function() {
            // Select all checkbox
            $('#select-all').change(function() {
                $('.comment-checkbox').prop('checked', $(this).is(':checked'));
                toggleBulkButtons();
            });

            // Individual checkbox change
            $('.comment-checkbox').change(function() {
                toggleBulkButtons();
                updateSelectAllCheckbox();
            });

            // Toggle bulk action buttons
            function toggleBulkButtons() {
                const checkedCount = $('.comment-checkbox:checked').length;
                $('#bulk-approve, #bulk-reject, #bulk-delete').prop('disabled', checkedCount === 0);
            }

            // Update select all checkbox
            function updateSelectAllCheckbox() {
                $('#select-all').prop('checked',
                    $('.comment-checkbox:checked').length === $('.comment-checkbox').length
                );
            }

            // Handle status change (approve/reject)
            function changeStatus(commentId, action) {
                const url = `/manage-artikel/komentar/${commentId}/${action}`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error',
                            `Terjadi kesalahan saat ${action === 'approve' ? 'menyetujui' : 'menolak'} komentar.`
                        );
                    }
                });
            }

            // Handle bulk action
            function bulkAction(action) {
                const selectedIds = $('.comment-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(action)

                if (selectedIds.length === 0) return;

                const actionMap = {
                    'approve': {
                        url: '/manage-artikel/comment/bulk-approve',
                        confirmMsg: 'Apakah Anda yakin ingin menyetujui komentar yang dipilih?',
                        successMsg: 'Komentar berhasil disetujui.'
                    },
                    'trash': {
                        url: '/manage-artikel/comment/bulk-trash',
                        confirmMsg: 'Apakah Anda yakin ingin menolak komentar yang dipilih?',
                        successMsg: 'Komentar berhasil ditolak.'
                    },
                    'delete': {
                        url: '/manage-artikel/comment/bulk-delete',
                        confirmMsg: 'Apakah Anda yakin ingin menghapus komentar yang dipilih?',
                        successMsg: 'Komentar berhasil dihapus.',
                        method: 'DELETE'
                    }
                };

                const config = actionMap[action];

                if (action === 'delete' && !confirm(config.confirmMsg)) {
                    return;
                }

                $.ajax({
                    url: config.url,
                    type: config.method || 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        comment_ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            showAlert('success', response.message || config.successMsg);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);
                        showAlert('error', `Terjadi kesalahan saat melakukan aksi ${action}.`);
                    }
                });
            }

            // Event handlers
            $('.approve-btn').click(function() {
                changeStatus($(this).data('id'), 'approve');
            });

            $('.reject-btn').click(function() {
                changeStatus($(this).data('id'), 'trash');
            });

            $('.delete-btn').click(function() {
                const commentId = $(this).data('id');
                $('#deleteForm').attr('action', `/manage-artikel/komentar/${commentId}`);
                $('#deleteModal').modal('show');
            });

            $('#bulk-approve').click(() => bulkAction('approve'));
            $('#bulk-reject').click(() => bulkAction('trash'));
            $('#bulk-delete').click(() => bulkAction('delete'));

            // Show alert function
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

                $('.alert').remove();
                $('.container-fluid').prepend(alertHtml);

                setTimeout(() => $('.alert').fadeOut(), 5000);
            }
        });
    </script>
@endpush
