@extends('layouts.app')

@section('title', 'Daftar Guru Kelas')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        .filter-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .filter-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
        }
    </style>
@endpush

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
                    <li class="breadcrumb-item active" aria-current="page">Management Guru Kelas</li>
                </ol>
            </nav>
            <h2 class="h4">Manajemen Data Guru Kelas</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createGuruKelasModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Guru Kelas
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-title">
            <i class="fas fa-filter me-2"></i>Filter Data
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="filter_guru" class="form-label">Guru</label>
                    <select class="form-select" id="filter_guru">
                        <option value="">Semua Guru</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="filter_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                    <select class="form-select" id="filter_mata_pelajaran">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach ($mataPelajaran as $mp)
                            <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="filter_kelas" class="form-label">Kelas</label>
                    <select class="form-select" id="filter_kelas">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="filter_tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <select class="form-select" id="filter_tahun_ajaran">
                        <option value="">Semua Tahun</option>
                        @foreach ($allTahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>
                                {{ $ta->nama_tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="filter_status" class="form-label">Status</label>
                    <select class="form-select" id="filter_status">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary me-2" id="btnFilter">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <button type="button" class="btn btn-secondary" id="btnReset">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="guruKelasTable">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="createGuruKelasModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modalTitle">Tambah Guru Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="guruKelasForm">
                    @csrf
                    <input type="hidden" name="id" id="guru_kelas_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guru_mata_pelajaran_id">Guru & Mata Pelajaran</label>
                            <select class="form-select" id="guru_mata_pelajaran_id" name="guru_mata_pelajaran_id"
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
                            <label for="tahun_ajaran_id">Tahun Ajaran</label>
                            <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($allTahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>
                                        {{ $ta->nama_tahun_ajaran }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" id="status" name="aktif" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-gray-600 ms-auto"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#guruKelasTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('guru-kelas.datatable') }}",
                    data: function(d) {
                        d.guru_id = $('#filter_guru').val();
                        d.mata_pelajaran_id = $('#filter_mata_pelajaran').val();
                        d.kelas_id = $('#filter_kelas').val();
                        d.tahun_ajaran_id = $('#filter_tahun_ajaran').val();
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'kelas',
                        name: 'kelas.nama_kelas'
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahunAjaran.nama_tahun_ajaran'
                    },
                    {
                        data: 'status',
                        name: 'aktif'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Event listener untuk filter
            $('#btnFilter').on('click', function() {
                table.ajax.reload();
            });

            // Event listener untuk reset filter
            $('#btnReset').on('click', function() {
                $('#filter_guru').val('');
                $('#filter_mata_pelajaran').val('');
                $('#filter_kelas').val('');
                $('#filter_tahun_ajaran').val('');
                $('#filter_status').val('');
                table.ajax.reload();
            });

            // Auto filter ketika dropdown berubah
            $('#filter_guru, #filter_mata_pelajaran, #filter_kelas, #filter_tahun_ajaran, #filter_status').on(
                'change',
                function() {
                    table.ajax.reload();
                });

            // Handle form submission
            $('#guruKelasForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#guru_kelas_id').val();
                let url = id ? `/admin/guru-kelas/${id}` : '/admin/guru-kelas';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createGuruKelasModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                let input = $(`[name="${key}"]`);
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').text(errors[key][0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });

            // Handle edit button
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $('#modalTitle').text('Edit Data Guru Kelas');

                $.get(`/admin/guru-kelas/${id}`, function(data) {
                    $('#guru_kelas_id').val(data.id);
                    $('#guru_mata_pelajaran_id').val(data.guru_mata_pelajaran_id);
                    $('#kelas_id').val(data.kelas_id);
                    $('#tahun_ajaran_id').val(data.tahun_ajaran_id);
                    $('#status').val(data.aktif ? '1' : '0');
                    $('#keterangan').val(data.keterangan);
                    $('#createGuruKelasModal').modal('show');
                });
            });

            // Handle delete button
            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/guru-kelas/${id}`,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message
                                });
                            }
                        });
                    }
                });
            });

            // Reset form when modal is closed
            $('#createGuruKelasModal').on('hidden.bs.modal', function() {
                $('#guruKelasForm')[0].reset();
                $('#guru_kelas_id').val('');
                $('#modalTitle').text('Tambah Guru Kelas');
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
