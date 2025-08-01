@extends('layouts.app')

@section('title', 'Data Pendaftaran')

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
                    <li class="breadcrumb-item active" aria-current="page">Data Pendaftaran</li>
                </ol>
            </nav>
            <h2 class="h4">Data Pendaftaran</h2>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="tahun_ajaran_filter" class="form-label">Tahun Ajaran</label>
                    <select class="form-select" id="tahun_ajaran_filter">
                        @foreach ($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $tahunAjaranId == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama_tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="status_filter" class="form-label">Status</label>
                    <select class="form-select" id="status_filter">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Calon Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="calon-siswa-table" style="width: 100%;">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>No. Pendaftaran</th>
                            <th>NIK</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat, Tanggal Lahir</th>
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

@endsection

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#calon-siswa-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('calon-siswa.index') }}",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#tahun_ajaran_filter').val();
                        d.status_filter = $('#status_filter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'no_pendaftaran',
                        name: 'no_pendaftaran',
                        width: '12%'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                        width: '12%'
                    },
                    {
                        data: 'nisn',
                        name: 'nisn',
                        width: '10%'
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap',
                        width: '18%'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        width: '8%',
                        render: function(data) {
                            return data === 'L' ? 'Laki-laki' : 'Perempuan';
                        }
                    },
                    {
                        data: 'ttl',
                        name: 'ttl',
                        orderable: false,
                        width: '15%'
                    },
                    {
                        data: 'status_badge',
                        name: 'status_pendaftaran',
                        width: '10%',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                // language: {
                //     processing: "Memproses...",
                //     search: "Pencarian:",
                //     lengthMenu: "Tampilkan _MENU_ data per halaman",
                //     info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                //     infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                //     infoFiltered: "(disaring dari _MAX_ total data)",
                //     loadingRecords: "Memuat...",
                //     zeroRecords: "Tidak ada data yang cocok",
                //     emptyTable: "Tidak ada data tersedia",
                //     paginate: {
                //         first: "Pertama",
                //         previous: "Sebelumnya",
                //         next: "Selanjutnya",
                //         last: "Terakhir"
                //     }
                // },
                // dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                //     '<"row"<"col-sm-12"tr>>' +
                //     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // Filter by Tahun Ajaran
            $('#tahun_ajaran_filter').change(function() {
                table.draw();
            });

            // Filter by Status
            $('#status_filter').change(function() {
                table.draw();
            });

            // Custom search functionality
            $('#calon-siswa-table_filter input').attr('placeholder',
                'Cari berdasarkan nama, NIK, NISN, atau nomor pendaftaran...');
        });
    </script>
@endpush
