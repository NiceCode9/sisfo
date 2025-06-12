@extends('layouts.app')
@section('title', 'Materi Pembelajaran')

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
                    <li class="breadcrumb-item active" aria-current="page">Materi Pembelajaran</li>
                </ol>
            </nav>
            <h2 class="h4">Manajemen Materi Pembelajaran</h2>
            <p class="mb-0">Halaman untuk mengelola materi pembelajaran.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createMateriModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Materi
            </button>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="materiTable">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            @if (auth()->user()->hasRole('superadmin'))
                                <th>Guru</th>
                            @endif
                            <th>Mata Pelajaran</th>
                            <th>Judul</th>
                            <th>File</th>
                            <th>Status</th>
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
    <div class="modal fade" id="createMateriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="h6 modal-title">Tambah Materi</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guru_kelas_id">Mata Pelajaran</label>
                            <select class="form-select" id="guru_kelas_id" name="guru_kelas_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($guruKelas as $gmp)
                                    <option value="{{ $gmp->id }}">
                                        {{ $gmp->guruMataPelajaran->mataPelajaran->nama_pelajaran }} -
                                        {{ $gmp->kelas->nama_kelas }}
                                        @if (auth()->user()->hasRole('superadmin'))
                                            - {{ $gmp->guruMataPelajar->guru->user->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="judul">Judul Materi</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="konten">Konten</label>
                            <textarea class="form-control" id="konten" name="konten" rows="5" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="file">File Lampiran (Optional)</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <small class="text-muted">Format yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX. Maksimal
                                10MB.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="diterbitkan" name="diterbitkan"
                                    value="1">
                                <label class="form-check-label" for="diterbitkan">Terbitkan Materi</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editMateriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="h6 modal-title">Edit Materi</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_guru_kelas_id">Mata Pelajaran</label>
                            <select class="form-select" id="edit_guru_kelas_id" name="guru_kelas_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($guruKelas as $gmp)
                                    <option value="{{ $gmp->id }}">
                                        {{ $gmp->guruMataPelajaran->mataPelajaran->nama_pelajaran }} -
                                        {{ $gmp->kelas->nama_kelas }}
                                        @if (auth()->user()->hasRole('superadmin'))
                                            - {{ $gmp->guruMataPelajaran->guru->user->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_judul">Judul Materi</label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_konten">Konten</label>
                            <textarea class="form-control" id="edit_konten" name="konten" rows="5" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_file">File Lampiran (Optional)</label>
                            <input type="file" class="form-control" id="edit_file" name="file">
                            <small class="text-muted">Format yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX. Maksimal
                                10MB.</small>
                            <div id="current_file" class="mt-2"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_diterbitkan" name="diterbitkan"
                                    value="1">
                                <label class="form-check-label" for="edit_diterbitkan">Terbitkan Materi</label>
                            </div>
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
            var table = $('#materiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.materi.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    @if (auth()->user()->hasRole('superadmin'))
                        {
                            data: 'guru',
                            name: 'guruKelas.guruMataPelajaran.guru.user.name'
                        },
                    @endif {
                        data: 'mata_pelajaran',
                        name: 'guruKelas.guruMataPelajaran.mataPelajaran.nama_pelajaran'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'file',
                        name: 'path_file',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'diterbitkan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Initialize rich text editor
            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor.create(document.querySelector('#konten'))
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor.create(document.querySelector('#edit_konten'))
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Create form submission
            $('#createForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.materi.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#createMateriModal').modal('hide');
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
                            console.log(errors);
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
                $.get("/admin/materi/" + id, function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_guru_kelas_id').val(data.guru_kelas_id);
                    $('#edit_judul').val(data.judul);
                    $('#edit_konten').val(data.konten);
                    $('#edit_diterbitkan').prop('checked', data.diterbitkan);

                    if (data.path_file) {
                        $('#current_file').html(
                            '<strong>File saat ini:</strong> <a href="/admin/materi/' + data
                            .id + '/download" target="_blank">' +
                            data.path_file.split('/').pop() + '</a>'
                        );
                    } else {
                        $('#current_file').html('<strong>Tidak ada file</strong>');
                    }

                    $('#editMateriModal').modal('show');
                });
            });

            // Edit form submission
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = new FormData(this);

                $.ajax({
                    url: "/admin/materi/" + id,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editMateriModal').modal('hide');
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
                    text: "Data materi yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/materi/" + id,
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
                $('#current_file').empty();
            });
        });
    </script>
@endpush
