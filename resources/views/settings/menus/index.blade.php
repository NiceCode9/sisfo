@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Menu</h6>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Menu
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover display nowrap responsive dataTable" id="menuTable">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Menu</th>
                            <th>Icon</th>
                            <th>Tipe</th>
                            <th>Parent</th>
                            <th>Permission</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr data-id="{{ $menu->id }}">
                                <td class="text-center">
                                    <i class="fas fa-arrows-alt handle" style="cursor: move;"></i>
                                    {{ $menu->order }}
                                </td>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    @if ($menu->icon)
                                        {!! $menu->icon_html !!}
                                        <small class="text-muted">{{ $menu->icon }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($menu->is_header)
                                        <span class="badge bg-info">Header</span>
                                    @elseif($menu->parent_id)
                                        <span class="badge bg-secondary">Submenu</span>
                                    @else
                                        <span class="badge bg-primary">Menu</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($menu->parent)
                                        {{ $menu->parent->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($menu->permission)
                                        <span class="badge bg-success">{{ $menu->permission }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($menu->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                            class="btn btn-sm btn-warning me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuTable = document.getElementById('menuTable');
            const tbody = menuTable.querySelector('tbody');

            // Inisialisasi Sortable
            const initSortable = () => {
                new Sortable(tbody, {
                    handle: '.handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        const rows = tbody.querySelectorAll('tr');
                        const order = Array.from(rows).map(row => row.getAttribute('data-id'));

                        fetch('{{ route('admin.menus.update-order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    order: order
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Perbarui nomor urut
                                    rows.forEach((row, index) => {
                                        const orderCell = row.querySelector(
                                            'td:first-child');
                                        if (orderCell) {
                                            const handleIcon =
                                                '<i class="fas fa-arrows-alt handle" style="cursor: move;"></i>';
                                            orderCell.innerHTML = handleIcon + ' ' + (
                                                index + 1);
                                        }
                                    });

                                    // Re-inisialisasi Sortable setelah update
                                    initSortable();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Reload halaman jika terjadi error
                                window.location.reload();
                            });
                    }
                });
            };

            // Inisialisasi pertama
            initSortable();
        });
    </script>
@endpush

@push('styles')
    <style>
        .handle {
            cursor: move;
            margin-right: 5px;
        }

        .sortable-ghost {
            opacity: 0.5;
            background: #c8ebfb;
        }

        .sortable-chosen {
            background-color: #f8f9fa;
        }

        .sortable-drag {
            opacity: 1 !important;
            background-color: #e9ecef;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
