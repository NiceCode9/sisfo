@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Kuota Pendaftaran</li>
                </ol>
            </nav>
            <h2 class="h4">Manajemen Kuota Pendaftaran</h2>
            <p class="mb-0">Halaman untuk mengatur kuota pendaftaran per jalur</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createKuotaModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Kuota
            </button>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="kuotaTable">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">Tahun Ajaran</th>
                            <th class="border-0">Jalur Pendaftaran</th>
                            <th class="border-0">Kuota</th>
                            <th class="border-0">Terisi</th>
                            <th class="border-0">Keterangan</th>
                            <th class="border-0 rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kuota as $k)
                            <tr>
                                <td>{{ $k->tahunAjaran->nama_tahun_ajaran }}</td>
                                <td>{{ $k->jalurPendaftaran->nama_jalur }}</td>
                                <td>{{ $k->kuota }}</td>
                                <td>{{ $k->terisi }}</td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm edit-btn"
                                        data-id="{{ $k->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-id="{{ $k->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createKuotaModal" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Tambah Kuota Pendaftaran</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tahun_ajaran_id">Tahun Ajaran</label>
                            <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->nama_tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jalur_pendaftaran_id">Jalur Pendaftaran</label>
                            <select class="form-select" id="jalur_pendaftaran_id" name="jalur_pendaftaran_id" required>
                                <option value="">Pilih Jalur</option>
                                @foreach ($jalurPendaftaran as $jp)
                                    <option value="{{ $jp->id }}">{{ $jp->nama_jalur }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kuota">Kuota</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" required
                                min="1">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Edit Kuota Pendaftaran</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_tahun_ajaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="edit_tahun_ajaran" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jalur">Jalur Pendaftaran</label>
                            <input type="text" class="form-control" id="edit_jalur" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kuota">Kuota</label>
                            <input type="number" class="form-control" id="edit_kuota" name="kuota" required
                                min="1">
                        </div>
                        <div class="mb-3">
                            <label for="edit_keterangan">Keterangan</label>
                            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            // DataTable initialization
            const table = $('#kuotaTable').DataTable({
                responsive: true
            });

            // Create form submission
            $('#createForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kuota-pendaftaran.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        });
                    }
                });
            });

            // Edit button click
            $('.edit-btn').on('click', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/kuota-pendaftaran/${id}`,
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#edit_tahun_ajaran').val(data.tahun_ajaran.nama_tahun_ajaran);
                            $('#edit_jalur').val(data.jalur_pendaftaran.nama_jalur);
                            $('#edit_kuota').val(data.kuota);
                            $('#edit_keterangan').val(data.keterangan);

                            $('#editForm').attr('data-id', id);
                            $('#editKuotaModal').modal('show');
                        }
                    }
                });
            });

            // Edit form submission
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const formData = new FormData(this);

                $.ajax({
                    url: `/admin/kuota-pendaftaran/${id}`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        });
                    }
                });
            });

            // Delete button click
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data kuota pendaftaran akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/kuota-pendaftaran/${id}`,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
