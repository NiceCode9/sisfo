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
                    <li class="breadcrumb-item active" aria-current="page">Laporan Pembayaran</li>
                </ol>
            </nav>
            <h2 class="h4">Laporan Pembayaran</h2>
            <p class="mb-0">Laporan pembayaran pendaftaran siswa baru</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group ms-2 ms-lg-3">
                <button type="button" class="btn btn-sm btn-outline-gray-600" id="exportExcel">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export Excel
                </button>
                <button type="button" class="btn btn-sm btn-outline-gray-600" id="exportPdf">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Statistik Pembayaran</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-6 col-xl-3 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <div class="row d-block d-xl-flex align-items-center">
                                        <div
                                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-7 px-xl-0">
                                            <div class="d-none d-sm-block">
                                                <h2 class="h6 text-gray-400 mb-0">Total Pembayaran</h2>
                                                <h3 class="fw-extrabold mb-2">{{ $statistik['total_pembayaran'] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <div class="row d-block d-xl-flex align-items-center">
                                        <div
                                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                            <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-7 px-xl-0">
                                            <div class="d-none d-sm-block">
                                                <h2 class="h6 text-gray-400 mb-0">Total Nominal</h2>
                                                <h3 class="fw-extrabold mb-2">Rp
                                                    {{ number_format($statistik['total_nominal'], 0, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Filter Laporan</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="tahun_ajaran_id">Tahun Ajaran</label>
                                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach ($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}">{{ $ta->nama_tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="jalur_pendaftaran_id">Jalur Pendaftaran</label>
                                <select class="form-select" id="jalur_pendaftaran_id" name="jalur_pendaftaran_id">
                                    <option value="">Semua Jalur</option>
                                    @foreach ($jalurPendaftaran as $jp)
                                        <option value="{{ $jp->id }}">{{ $jp->nama_jalur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Status Pembayaran</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu">Menunggu</option>
                                    <option value="berhasil">Berhasil</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-gray-800">Filter</button>
                                <button type="reset" class="btn btn-light">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Data Pembayaran</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded" id="pembayaranTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">Tanggal</th>
                                    <th class="border-0">Nama Siswa</th>
                                    <th class="border-0">Jalur</th>
                                    <th class="border-0">Jenis Biaya</th>
                                    <th class="border-0">Nominal</th>
                                    <th class="border-0">Metode</th>
                                    <th class="border-0 rounded-end">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#pembayaranTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('laporan.pembayaran') }}",
                    type: "GET",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#tahun_ajaran_id').val();
                        d.jalur_pendaftaran_id = $('#jalur_pendaftaran_id').val();
                        d.status = $('#status').val();
                        d.tanggal_mulai = $('#tanggal_mulai').val();
                        d.tanggal_selesai = $('#tanggal_selesai').val();
                    }
                },
                columns: [{
                        data: 'tanggal_pembayaran',
                        name: 'tanggal_pembayaran'
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'calonSiswa.nama_lengkap'
                    },
                    {
                        data: 'nama_jalur',
                        name: 'calonSiswa.jalurPendaftaran.nama_jalur'
                    },
                    {
                        data: 'jenis_biaya',
                        name: 'biayaPendaftaran.jenis_biaya'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'metode_pembayaran',
                        name: 'metode_pembayaran'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ],
                order: [
                    [0, 'desc']
                ], // Sort by tanggal_pembayaran descending
                responsive: true,
                language: {
                    processing: "Memuat data...",
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "_MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 hingga 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Handle filter form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // Handle filter form reset
            $('#filterForm button[type="reset"]').on('click', function() {
                $('#filterForm')[0].reset();
                table.ajax.reload();
            });

            // Update statistics when data is loaded
            table.on('xhr.dt', function(e, settings, json) {
                if (json && json.statistik) {
                    $('.total-pembayaran').text(json.statistik.total_pembayaran);
                    $('.total-nominal').text('Rp ' + new Intl.NumberFormat('id-ID').format(json.statistik
                        .total_nominal));
                }
            });

            // Export handlers
            $('#exportExcel').on('click', function() {
                const params = new URLSearchParams({
                    tahun_ajaran_id: $('#tahun_ajaran_id').val(),
                    jalur_pendaftaran_id: $('#jalur_pendaftaran_id').val(),
                    status: $('#status').val(),
                    tanggal_mulai: $('#tanggal_mulai').val(),
                    tanggal_selesai: $('#tanggal_selesai').val()
                });
                window.location.href = "{{ route('laporan.pembayaran.excel') }}?" + params
                    .toString();
            });

            $('#exportPdf').on('click', function() {
                const params = new URLSearchParams({
                    tahun_ajaran_id: $('#tahun_ajaran_id').val(),
                    jalur_pendaftaran_id: $('#jalur_pendaftaran_id').val(),
                    status: $('#status').val(),
                    tanggal_mulai: $('#tanggal_mulai').val(),
                    tanggal_selesai: $('#tanggal_selesai').val()
                });
                window.location.href = "{{ route('laporan.pembayaran.pdf') }}?" + params.toString();
            });
        });
    </script>
@endpush
