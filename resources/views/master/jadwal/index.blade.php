@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')

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
                    <li class="breadcrumb-item active" aria-current="page">Jadwal Pelajaran</li>
                </ol>
            </nav>
            <h2 class="h4">Manajemen Jadwal Pelajaran</h2>
            <p class="mb-0">Halaman untuk mengatur jadwal pelajaran setiap kelas.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createJadwalModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Jadwal
            </button>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="jadwalTable">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createJadwalModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="h6 modal-title">Tambah Jadwal Pelajaran</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="guru_mata_pelajaran_id">Guru & Mata Pelajaran</label>
                            <select class="form-select" id="guru_mata_pelajaran_id" name="guru_mata_pelajaran_id" required>
                                <option value="">Pilih Guru & Mata Pelajaran</option>
                                @foreach ($guruMataPelajaran as $gmp)
                                    <option value="{{ $gmp->id }}">
                                        {{ $gmp->guru->user->name }} - {{ $gmp->mataPelajaran->nama_pelajaran }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="hari">Hari</label>
                            <select class="form-select" id="hari" name="hari" required>
                                <option value="">Pilih Hari</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ruangan">Ruangan</label>
                            <input type="text" class="form-control" id="ruangan" name="ruangan">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-gray ms-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editJadwalModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="h6 modal-title">Edit Jadwal Pelajaran</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_kelas_id">Kelas</label>
                            <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_guru_mata_pelajaran_id">Guru & Mata Pelajaran</label>
                            <select class="form-select" id="edit_guru_mata_pelajaran_id" name="guru_mata_pelajaran_id"
                                required>
                                <option value="">Pilih Guru & Mata Pelajaran</option>
                                @foreach ($guruMataPelajaran as $gmp)
                                    <option value="{{ $gmp->id }}">
                                        {{ $gmp->guru->user->name }} - {{ $gmp->mataPelajaran->nama_pelajaran }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_hari">Hari</label>
                            <select class="form-select" id="edit_hari" name="hari" required>
                                <option value="">Pilih Hari</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_jam_mulai">Jam Mulai</label>
                                    <input type="time" class="form-control" id="edit_jam_mulai" name="jam_mulai"
                                        required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_jam_selesai">Jam Selesai</label>
                                    <input type="time" class="form-control" id="edit_jam_selesai" name="jam_selesai"
                                        required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ruangan">Ruangan</label>
                            <input type="text" class="form-control" id="edit_ruangan" name="ruangan">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-gray ms-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#jadwalTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('jadwal.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kelas.nama_kelas',
                        name: 'kelas.nama_kelas'
                    },
                    {
                        data: 'guru',
                        name: 'guruMataPelajaran.guru.user.name'
                    },
                    {
                        data: 'mata_pelajaran',
                        name: 'guruMataPelajaran.mataPelajaran.nama_pelajaran'
                    },
                    {
                        data: 'hari',
                        name: 'hari',
                        render: function(data) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        }
                    },
                    {
                        data: null,
                        name: 'jam',
                        render: function(data) {
                            return data.jam_mulai + ' - ' + data.jam_selesai;
                        }
                    },
                    {
                        data: 'ruangan',
                        name: 'ruangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Create form submission
            $('#createForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('jadwal.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createJadwalModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                var input = $('#' + key);
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(errors[key][
                                    0
                                ]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });

            // Edit button click
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.get("/admin/jadwal/" + id, function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_kelas_id').val(data.kelas_id);
                    $('#edit_guru_mata_pelajaran_id').val(data.guru_mata_pelajaran_id);
                    $('#edit_hari').val(data.hari);
                    $('#edit_jam_mulai').val(data.jam_mulai);
                    $('#edit_jam_selesai').val(data.jam_selesai);
                    $('#edit_ruangan').val(data.ruangan);
                    $('#editJadwalModal').modal('show');
                });
            });

            // Edit form submission
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: "/admin/jadwal/" + id,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editJadwalModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                var input = $('#edit_' + key);
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(errors[key][
                                    0
                                ]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });

            // Delete button click
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data jadwal yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/jadwal/" + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON.message
                                });
                            }
                        });
                    }
                });
            });

            // Reset form when modal is closed
            $('.modal').on('hidden.bs.modal', function() {
                var form = $(this).find('form');
                form[0].reset();
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').empty();
            });
        });
    </script>
@endpush
