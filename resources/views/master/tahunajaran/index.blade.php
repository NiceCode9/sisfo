@extends('layouts.app')
@section('title', 'Tahun Ajaran')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tahun Ajaran</li>
                </ol>
            </nav>
            <h2 class="h4">Management Tahun Ajaran</h2>
            <p class="mb-0">Data Tahun Ajaran.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#createTahunAjaranModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Create New Tahun Ajaran
            </a>
        </div>
    </div>

    {{-- <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <div class="input-group me-2 me-lg-3 fmxw-400">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" name="s" placeholder="Cari Tahun Ajaran..."
                        aria-label="Cari Tahun Ajaran...">
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Role</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover dataTable display responsve nowrap" id="tahunAjaranTable"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tahunAjarans as $ta)
                            <tr>
                                <td>{{ $ta->nama_tahun_ajaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($ta->tanggal_mulai)->locale('ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($ta->tanggal_selesai)->locale('ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>
                                    @if ($ta->status_aktif == true)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                        data-id="{{ $ta->id }}" data-nama="{{ $ta->nama_tahun_ajaran }}"
                                        data-mulai="{{ $ta->tanggal_mulai }}" data-selesai="{{ $ta->tanggal_selesai }}"
                                        data-status="{{ $ta->status_aktif }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('tahun-ajaran.destroy', $ta->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Tahun Ajaran Modal -->
    <div class="modal fade" id="createTahunAjaranModal" tabindex="-1" aria-labelledby="createTahunAjaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTahunAjaranModalLabel">Create New Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tahun-ajaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control @error('nama_tahun_ajaran') is-invalid @enderror"
                                id="nama_tahun_ajaran" name="nama_tahun_ajaran" value="{{ old('nama_tahun_ajaran') }}"
                                required>
                            @error('nama_tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status_aktif">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tahun Ajaran Modal -->
    <div class="modal fade" id="editTahunAjaranModal" tabindex="-1" aria-labelledby="editTahunAjaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTahunAjaranModalLabel">Edit Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control @error('nama_tahun_ajaran') is-invalid @enderror"
                                id="edit_nama_tahun_ajaran" name="nama_tahun_ajaran" required>
                            @error('nama_tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                id="edit_tanggal_mulai" name="tanggal_mulai" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                id="edit_tanggal_selesai" name="tanggal_selesai" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="edit_status"
                                name="status_aktif">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle click on edit button
            $('.edit-btn').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const mulai = $(this).data('mulai');
                const selesai = $(this).data('selesai');
                const status = $(this).data('status');

                // Set form action
                $('#editForm').attr('action', `/admin/tahun-ajaran/${id}`);

                // Fill form fields
                $('#edit_nama_tahun_ajaran').val(nama);
                $('#edit_tanggal_mulai').val(mulai);
                $('#edit_tanggal_selesai').val(selesai);
                $('#edit_status').val(status);

                // Show modal
                $('#editTahunAjaranModal').modal('show');
            });

            $(document).on('click', '.btn-delete', function() {
                const form = $(this).closest('form');
                const tahunAjaranName = form.data('tahun-ajaran-name') || 'Tahun Ajaran';

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus ${tahunAjaranName}.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
