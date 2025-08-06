@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Detail Ekstrakurikuler</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $ekstrakurikuler->nama_ekskul }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            @if (!auth()->user()->hasRole('siswa'))
                                <a href="{{ route('ekstrakurikuler.edit', $ekstrakurikuler->slug) }}"
                                    class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        @if ($ekstrakurikuler->foto)
                            <img src="{{ asset('storage/' . $ekstrakurikuler->foto) }}"
                                alt="{{ $ekstrakurikuler->nama_ekskul }}" class="img-fluid rounded mb-3"
                                style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3"
                                style="height: 200px;">
                                <i class="fas fa-image text-muted fa-5x"></i>
                            </div>
                        @endif

                        <h5 class="card-title">{{ $ekstrakurikuler->nama_ekskul }}</h5>

                        <div class="mb-3">
                            @if ($ekstrakurikuler->status)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times-circle"></i> Tidak Aktif
                                </span>
                            @endif
                        </div>

                        <div class="row text-center">
                            <div class="col-12">
                                <div class="bg-primary text-white rounded p-3">
                                    <h2 class="mb-1">{{ number_format($totalAnggota) }}</h2>
                                    <p class="mb-0">Total Anggota Aktif</p>
                                    @if ($tahunAjaranAktif)
                                        <small>({{ $tahunAjaranAktif->nama_tahun_ajaran }})</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Informasi Ekstrakurikuler
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 fw-bold">Nama:</div>
                            <div class="col-sm-9">{{ $ekstrakurikuler->nama_ekskul }}</div>
                        </div>
                        <hr class="my-2">

                        <div class="row">
                            <div class="col-sm-3 fw-bold">Slug:</div>
                            <div class="col-sm-9">
                                <code>{{ $ekstrakurikuler->slug }}</code>
                            </div>
                        </div>
                        <hr class="my-2">

                        <div class="row">
                            <div class="col-sm-3 fw-bold">Status:</div>
                            <div class="col-sm-9">
                                @if ($ekstrakurikuler->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <hr class="my-2">

                        <div class="row">
                            <div class="col-sm-3 fw-bold">Dibuat:</div>
                            <div class="col-sm-9">{{ $ekstrakurikuler->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                        <hr class="my-2">

                        <div class="row">
                            <div class="col-sm-3 fw-bold">Terakhir Diupdate:</div>
                            <div class="col-sm-9">{{ $ekstrakurikuler->updated_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                        <hr class="my-2">

                        <div class="row">
                            <div class="col-sm-3 fw-bold">Deskripsi:</div>
                            <div class="col-sm-9">
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($ekstrakurikuler->deskripsi)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-users"></i> Daftar Anggota
                        </h6>
                        <div class="d-flex gap-2">
                            <!-- Filter Tahun Ajaran -->
                            <select id="filter-tahun-ajaran" class="form-select form-select-sm" style="width: auto;">
                                <option value="all">Semua Tahun Ajaran</option>
                                @foreach ($tahunAjarans as $ta)
                                    <option value="{{ $ta->id }}"
                                        {{ $tahunAjaranAktif && $tahunAjaranAktif->id == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama_tahun_ajaran }}
                                        @if ($ta->status)
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                            <!-- Filter Status -->
                            <select id="filter-status" class="form-select form-select-sm" style="width: auto;">
                                <option value="all">Semua Status</option>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>

                            @if (auth()->user()->hasRole('siswa'))
                                @if ($ekstrakurikuler->status)
                                    <button type="button" class="btn btn-success btn-sm" id="btn-daftar">
                                        <i class="fas fa-user-plus"></i> <span id="btn-daftar-text">Daftar
                                            Ekstrakurikuler</span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-times"></i> Pendaftaran Ditutup
                                    </button>
                                @endif
                            @elseif (!auth()->user()->hasRole('siswa') && $ekstrakurikuler->status)
                                <button type="button" class="btn btn-primary btn-sm" id="btn-add-member">
                                    <i class="fas fa-user-plus"></i> Tambah Anggota
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="members-table" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">NIS</th>
                                        <th width="20%">Nama Siswa</th>
                                        <th width="12%">Kelas</th>
                                        <th width="12%">Tahun Ajaran</th>
                                        <th width="10%">Tanggal Daftar</th>
                                        <th width="8%">Status</th>
                                        <th width="8%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pendaftaran untuk Siswa -->
    @if (auth()->user()->hasRole('siswa'))
        <div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pendaftaran Ekstrakurikuler</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="pendaftaran-form">
                        @csrf
                        <input type="hidden" name="ekstrakurikuler_id" value="{{ $ekstrakurikuler->id }}">

                        <div class="modal-body">
                            <div class="text-center mb-4">
                                @if ($ekstrakurikuler->foto)
                                    <img src="{{ asset('storage/' . $ekstrakurikuler->foto) }}"
                                        alt="{{ $ekstrakurikuler->nama_ekskul }}" class="img-fluid rounded mb-3"
                                        style="max-height: 150px;">
                                @endif
                                <h6 class="fw-bold">{{ $ekstrakurikuler->nama_ekskul }}</h6>
                                <p class="text-muted small">{{ Str::limit($ekstrakurikuler->deskripsi, 150) }}</p>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Anda akan mendaftarkan diri untuk ekstrakurikuler ini pada tahun
                                ajaran
                                <strong>{{ $tahunAjaranAktif ? $tahunAjaranAktif->nama_tahun_ajaran : '-' }}</strong>
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                    placeholder="Tulis alasan atau motivasi Anda mengikuti ekstrakurikuler ini..."></textarea>
                                <div class="form-text">Maksimal 500 karakter</div>
                                <div class="invalid-feedback" id="error-catatan"></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success" id="btn-submit-daftar">
                                <span id="submit-text">
                                    <i class="fas fa-check"></i> Daftar Sekarang
                                </span>
                                <span id="submit-loading" class="d-none">
                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                    Mendaftar...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Tambah Anggota untuk Admin/Guru -->
    @if (!auth()->user()->hasRole('siswa'))
        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="add-member-form">
                        @csrf
                        <input type="hidden" name="ekstrakurikuler_id" value="{{ $ekstrakurikuler->id }}">

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="siswa_id" class="form-label">Pilih Siswa <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="siswa_id" name="siswa_id" required>
                                    <option value="">-- Pilih Siswa --</option>
                                </select>
                                <div class="invalid-feedback" id="error-siswa_id"></div>
                            </div>

                            <div class="mb-3">
                                <label for="catatan_admin" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan_admin" name="catatan" rows="3"
                                    placeholder="Catatan untuk pendaftaran ini..."></textarea>
                                <div class="invalid-feedback" id="error-catatan_admin"></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-add">
                                <span id="add-text">
                                    <i class="fas fa-plus"></i> Tambah Anggota
                                </span>
                                <span id="add-loading" class="d-none">
                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                    Menambahkan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Detail Member -->
    <div class="modal fade" id="memberDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>NIS</strong></td>
                                    <td>: <span id="detail-nis"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Siswa</strong></td>
                                    <td>: <span id="detail-nama-siswa"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Kelas</strong></td>
                                    <td>: <span id="detail-kelas"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Ajaran</strong></td>
                                    <td>: <span id="detail-tahun-ajaran"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Tanggal Daftar</strong></td>
                                    <td>: <span id="detail-tanggal-daftar"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Ekstrakurikuler</strong></td>
                                    <td>: <span id="detail-ekstrakurikuler"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: <span id="detail-status"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <hr>
                            <strong>Catatan:</strong>
                            <div class="bg-light p-3 rounded mt-2">
                                <span id="detail-catatan"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            let table = $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('ekstrakurikuler.members', $ekstrakurikuler->slug) }}",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#filter-tahun-ajaran').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas',
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },
                    {
                        data: 'tanggal_daftar',
                        name: 'tanggal_daftar'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [5, 'desc']
                ],
                language: {
                    processing: "Memuat data...",
                    search: "Pencarian:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data anggota",
                    zeroRecords: "Tidak ditemukan data yang sesuai"
                }
            });

            // Filter by academic year
            $('#filter-tahun-ajaran').change(function() {
                table.draw();
            });

            // Filter by status
            $('#filter-status').change(function() {
                table.draw();
            });

            // Detail Member Button
            $(document).on('click', '.btn-detail', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: `/ekstrakurikuler/member/${id}/detail`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;

                            $('#detail-nis').text(data.siswa?.nis || '-');
                            $('#detail-nama-siswa').text(data.siswa?.calonSiswa?.nama_lengkap ||
                                data.siswa?.nama || '-');
                            $('#detail-kelas').text(data.siswa?.kelas?.nama_kelas || '-');
                            $('#detail-tahun-ajaran').text(data.tahun_ajaran
                                ?.nama_tahun_ajaran || '-');
                            $('#detail-tanggal-daftar').text(data.tanggal_daftar ?
                                new Date(data.tanggal_daftar).toLocaleDateString('id-ID') :
                                '-');
                            $('#detail-ekstrakurikuler').text(data.ekstrakurikuler
                                ?.nama_ekskul || '-');
                            $('#detail-status').html(data.status ?
                                '<span class="badge bg-success">Aktif</span>' :
                                '<span class="badge bg-secondary">Nonaktif</span>');
                            $('#detail-catatan').text(data.catatan || 'Tidak ada catatan');

                            $('#memberDetailModal').modal('show');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal memuat detail anggota', 'error');
                    }
                });
            });

            // Toggle Member Status Button
            $(document).on('click', '.btn-toggle-status', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const status = $(this).data('status');

                const actionText = status === 'aktif' ? 'mengaktifkan' : 'menonaktifkan';
                const statusText = status === 'aktif' ? 'aktif' : 'nonaktif';

                Swal.fire({
                    title: 'Konfirmasi Perubahan Status',
                    text: `Apakah Anda yakin ingin ${actionText} "${name}" dari ekstrakurikuler ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status === 'aktif' ? '#28a745' : '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Ya, ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}!`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/ekstrakurikuler/member/${id}/remove`,
                            type: 'POST',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                    table.draw(false);

                                    // Update total anggota counter
                                    updateMemberCount();
                                }
                            },
                            error: function(xhr) {
                                const message = xhr.responseJSON?.message ||
                                    'Gagal mengubah status anggota';
                                Swal.fire('Error!', message, 'error');
                            }
                        });
                    }
                });
            });

            // Check registration status for student
            @if (auth()->user()->hasRole('siswa'))
                function checkRegistrationStatus() {
                    $.ajax({
                        url: "{{ route('ekstrakurikuler.check-registration', $ekstrakurikuler->slug) }}",
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                if (response.is_registered) {
                                    $('#btn-daftar').removeClass('btn-success').addClass(
                                            'btn-secondary')
                                        .prop('disabled', true)
                                        .html('<i class="fas fa-check"></i> Sudah Terdaftar');
                                } else if (!response.ekstrakurikuler_active) {
                                    $('#btn-daftar').removeClass('btn-success').addClass(
                                            'btn-secondary')
                                        .prop('disabled', true)
                                        .html('<i class="fas fa-times"></i> Pendaftaran Ditutup');
                                }
                            }
                        }
                    });
                }

                // Check status on page load
                checkRegistrationStatus();

                // Student registration button
                $('#btn-daftar').click(function() {
                    if ($(this).prop('disabled')) return;
                    $('#pendaftaranModal').modal('show');
                });

                // Student registration form
                $('#pendaftaran-form').submit(function(e) {
                    e.preventDefault();

                    // Show loading
                    $('#submit-text').addClass('d-none');
                    $('#submit-loading').removeClass('d-none');
                    $('#btn-submit-daftar').prop('disabled', true);

                    // Clear errors
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    $.ajax({
                        url: "{{ route('ekstrakurikuler.daftar') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#pendaftaranModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                // Update button status
                                $('#btn-daftar').removeClass('btn-success').addClass(
                                        'btn-secondary')
                                    .prop('disabled', true)
                                    .html('<i class="fas fa-check"></i> Sudah Terdaftar');

                                // Refresh table and counter
                                table.draw(false);
                                setTimeout(() => location.reload(), 2000);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                for (const field in errors) {
                                    $(`#${field}`).addClass('is-invalid');
                                    $(`#error-${field}`).text(errors[field][0]);
                                }
                            } else {
                                const message = xhr.responseJSON?.message ||
                                    'Terjadi kesalahan sistem';
                                Swal.fire('Error!', message, 'error');
                            }
                        },
                        complete: function() {
                            // Hide loading
                            $('#submit-text').removeClass('d-none');
                            $('#submit-loading').addClass('d-none');
                            $('#btn-submit-daftar').prop('disabled', false);
                        }
                    });
                });
            @endif

            // Add Member Button (for admin/guru)
            @if (!auth()->user()->hasRole('siswa'))
                $('#btn-add-member').click(function() {
                    // Load students list
                    loadStudentsList();
                    $('#addMemberModal').modal('show');
                });

                // Load students for dropdown
                function loadStudentsList() {
                    $.ajax({
                        url: '/api/students', // You need to create this endpoint
                        type: 'GET',
                        success: function(response) {
                            const select = $('#siswa_id');
                            select.empty().append('<option value="">-- Pilih Siswa --</option>');

                            if (response.data && response.data.length > 0) {
                                response.data.forEach(function(siswa) {
                                    select.append(
                                        `<option value="${siswa.id}">${siswa.nis} - ${siswa.nama} (${siswa.kelas})</option>`
                                    );
                                });
                            }
                        },
                        error: function() {
                            console.log('Error loading students list');
                        }
                    });
                }

                // Add member form
                $('#add-member-form').submit(function(e) {
                    e.preventDefault();

                    // Show loading
                    $('#add-text').addClass('d-none');
                    $('#add-loading').removeClass('d-none');
                    $('#btn-submit-add').prop('disabled', true);

                    // Clear errors
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    $.ajax({
                        url: "{{ route('ekstrakurikuler.daftar') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#addMemberModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                // Clear form
                                $('#add-member-form')[0].reset();

                                // Refresh table and counter
                                table.draw(false);
                                updateMemberCount();
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                for (const field in errors) {
                                    const fieldId = field === 'catatan' ? 'catatan_admin' :
                                        field;
                                    $(`#${fieldId}`).addClass('is-invalid');
                                    $(`#error-${fieldId}`).text(errors[field][0]);
                                }
                            } else {
                                const message = xhr.responseJSON?.message ||
                                    'Terjadi kesalahan sistem';
                                Swal.fire('Error!', message, 'error');
                            }
                        },
                        complete: function() {
                            // Hide loading
                            $('#add-text').removeClass('d-none');
                            $('#add-loading').addClass('d-none');
                            $('#btn-submit-add').prop('disabled', false);
                        }
                    });
                });

                // Clear form when modal is hidden
                $('#addMemberModal').on('hidden.bs.modal', function() {
                    $('#add-member-form')[0].reset();
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                });
            @endif

            // Function to update member count
            function updateMemberCount() {
                // Make AJAX call to get updated count
                $.ajax({
                    url: "{{ route('ekstrakurikuler.show', $ekstrakurikuler->slug) }}",
                    type: 'GET',
                    success: function() {
                        // Reload the page to update counter
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            }

            // Refresh button functionality (optional)
            function refreshTable() {
                table.draw(false);
                updateMemberCount();
            }

            // Auto refresh every 30 seconds (optional - remove if not needed)
            // setInterval(function() {
            //     refreshTable();
            // }, 30000);

            // Clear modal forms when hidden
            $('#pendaftaranModal').on('hidden.bs.modal', function() {
                $('#pendaftaran-form')[0].reset();
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });

            $('#memberDetailModal').on('hidden.bs.modal', function() {
                // Clear detail modal content
                $('#detail-nis, #detail-nama-siswa, #detail-kelas, #detail-tahun-ajaran, #detail-tanggal-daftar, #detail-ekstrakurikuler, #detail-status, #detail-catatan')
                    .text('');
            });

            // Handle responsive table
            $(window).resize(function() {
                table.columns.adjust().responsive.recalc();
            });

            // Add loading overlay for better UX
            $(document).ajaxStart(function() {
                // You can add a loading overlay here if needed
            }).ajaxStop(function() {
                // Remove loading overlay
            });

            // Handle keyboard shortcuts (optional)
            $(document).keydown(function(e) {
                // ESC key to close modals
                if (e.keyCode === 27) {
                    $('.modal').modal('hide');
                }

                // F5 or Ctrl+R to refresh table
                if (e.keyCode === 116 || (e.ctrlKey && e.keyCode === 82)) {
                    e.preventDefault();
                    refreshTable();
                }
            });

            // Tooltip initialization (if using Bootstrap tooltips)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers (if using Bootstrap popovers)
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Custom validation for character count
            $('#catatan').on('input', function() {
                const maxLength = 500;
                const currentLength = $(this).val().length;
                const remaining = maxLength - currentLength;

                if (remaining < 0) {
                    $(this).val($(this).val().substring(0, maxLength));
                } else {
                    $(this).siblings('.form-text').text(`${remaining} karakter tersisa`);
                }
            });

            $('#catatan_admin').on('input', function() {
                const maxLength = 500;
                const currentLength = $(this).val().length;
                const remaining = maxLength - currentLength;

                if (remaining < 0) {
                    $(this).val($(this).val().substring(0, maxLength));
                }
            });

        });

        // Global function to handle errors
        function handleAjaxError(xhr, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);

            let message = 'Terjadi kesalahan sistem';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                message = 'Data tidak ditemukan';
            } else if (xhr.status === 403) {
                message = 'Akses ditolak';
            } else if (xhr.status === 500) {
                message = 'Terjadi kesalahan server';
            }

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message
            });
        }

        // Global AJAX error handler
        $(document).ajaxError(function(event, xhr, settings, thrownError) {
            if (xhr.status !== 422) { // Don't handle validation errors globally
                handleAjaxError(xhr, 'error', thrownError);
            }
        });

        // Print functionality (optional)
        function printMemberList() {
            const printWindow = window.open('', '_blank');
            const tableContent = $('#members-table').clone();

            // Remove action column from print version
            tableContent.find('th:last-child, td:last-child').remove();

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Daftar Anggota Ekstrakurikuler - {{ $ekstrakurikuler->nama_ekskul }}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            .no-print { display: none; }
                            body { font-size: 12px; }
                        }
                    </style>
                </head>
                <body>
                    <div class="container mt-4">
                        <h3 class="text-center">Daftar Anggota Ekstrakurikuler</h3>
                        <h4 class="text-center">{{ $ekstrakurikuler->nama_ekskul }}</h4>
                        <hr>
                        <div class="table-responsive">
                            ${tableContent[0].outerHTML}
                        </div>
                        <div class="mt-4">
                            <p>Dicetak pada: ${new Date().toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 250);
        }

        // Export to CSV functionality (optional)
        function exportToCSV() {
            const table = $('#members-table').DataTable();
            const data = table.data().toArray();

            let csv = 'No,NIS,Nama Siswa,Kelas,Tahun Ajaran,Tanggal Daftar,Status\n';

            data.forEach((row, index) => {
                csv +=
                    `${index + 1},"${row.nis}","${row.nama_siswa}","${row.kelas}","${row.tahun_ajaran}","${row.tanggal_daftar}","${row.status}"\n`;
            });

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download',
                `anggota_${encodeURIComponent('{{ $ekstrakurikuler->nama_ekskul }}')}_${new Date().toISOString().split('T')[0]}.csv`
            );
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    </script>
@endpush
