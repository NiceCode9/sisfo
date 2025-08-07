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
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
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
                                                <h3 class="fw-extrabold mb-2 total-pembayaran">
                                                    {{ $statistik['total_pembayaran'] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
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
                                                <h3 class="fw-extrabold mb-2 total-nominal">Rp
                                                    {{ number_format($statistik['total_nominal'], 0, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <div class="row d-block d-xl-flex align-items-center">
                                        <div
                                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-7 px-xl-0">
                                            <div class="d-none d-sm-block">
                                                <h2 class="h6 text-gray-400 mb-0">Pembayaran Berhasil</h2>
                                                <h3 class="fw-extrabold mb-2 total-berhasil">-</h3>
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
                                <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach ($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}">{{ $ta->nama_tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="jalur_pendaftaran_id" class="form-label">Jalur Pendaftaran</label>
                                <select class="form-select" id="jalur_pendaftaran_id" name="jalur_pendaftaran_id">
                                    <option value="">Semua Jalur</option>
                                    @foreach ($jalurPendaftaran as $jp)
                                        <option value="{{ $jp->id }}">{{ $jp->nama_jalur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status Pembayaran</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu">Menunggu</option>
                                    <option value="berhasil">Berhasil</option>
                                    <option value="gagal">Gagal</option>
                                    <option value="pending">Pending</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran">
                                    <option value="">Semua Jenis</option>
                                    <option value="penuh">Pembayaran Penuh</option>
                                    <option value="dp_angsuran">DP Angsuran</option>
                                    <option value="cicilan_angsuran">Cicilan Angsuran</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran">
                                    <option value="">Semua Metode</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="tunai">Tunai</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-gray-800">
                                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Filter
                                </button>
                                <button type="reset" class="btn btn-light">
                                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Reset
                                </button>
                                <button type="button" class="btn btn-info" id="refreshStats">
                                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Refresh Statistik
                                </button>
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
                                    <th class="border-0">Jenis Pembayaran</th>
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
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                ajax: {
                    url: "{{ route('laporan.pembayaran') }}",
                    type: "GET",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#tahun_ajaran_id').val();
                        d.jalur_pendaftaran_id = $('#jalur_pendaftaran_id').val();
                        d.status = $('#status').val();
                        d.jenis_pembayaran = $('#jenis_pembayaran').val();
                        d.metode_pembayaran = $('#metode_pembayaran').val();
                        d.tanggal_mulai = $('#tanggal_mulai').val();
                        d.tanggal_selesai = $('#tanggal_selesai').val();
                    }
                },
                columns: [{
                        data: 'tanggal_pembayaran',
                        name: 'tanggal_pembayaran',
                        orderable: true
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'calonSiswa.nama_lengkap',
                        orderable: true
                    },
                    {
                        data: 'nama_jalur',
                        name: 'calonSiswa.jalurPendaftaran.nama_jalur',
                        orderable: true
                    },
                    {
                        data: 'jenis_biaya',
                        name: 'biayaPendaftaran.jenis_biaya',
                        orderable: true
                    },
                    {
                        data: 'jenis_pembayaran',
                        name: 'jenis_pembayaran',
                        orderable: true
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        orderable: true
                    },
                    {
                        data: 'metode_pembayaran',
                        name: 'metode_pembayaran',
                        orderable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true
                    }
                ],
                order: [
                    [0, 'desc']
                ],
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

            // Update statistics when data is loaded
            table.on('xhr.dt', function(e, settings, json) {
                if (json && json.statistik) {
                    $('.total-pembayaran').text(new Intl.NumberFormat('id-ID').format(json.statistik
                        .total_pembayaran));
                    $('.total-nominal').text('Rp ' + new Intl.NumberFormat('id-ID').format(json.statistik
                        .total_nominal));

                    // Update berhasil count (you can add this to controller if needed)
                    $('.total-berhasil').text(json.statistik.total_berhasil || '-');
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

            // Refresh statistics
            $('#refreshStats').on('click', function() {
                table.ajax.reload();
                $(this).html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...').prop(
                    'disabled', true);

                setTimeout(() => {
                    $(this).html(
                        '<svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Refresh Statistik'
                    ).prop('disabled', false);
                }, 2000);
            });

            // Export handlers
            $('#exportExcel').on('click', function() {
                const params = new URLSearchParams();

                // Add all filter parameters
                if ($('#tahun_ajaran_id').val()) params.append('tahun_ajaran_id', $('#tahun_ajaran_id')
                    .val());
                if ($('#jalur_pendaftaran_id').val()) params.append('jalur_pendaftaran_id', $(
                    '#jalur_pendaftaran_id').val());
                if ($('#status').val()) params.append('status', $('#status').val());
                if ($('#jenis_pembayaran').val()) params.append('jenis_pembayaran', $('#jenis_pembayaran')
                    .val());
                if ($('#metode_pembayaran').val()) params.append('metode_pembayaran', $(
                    '#metode_pembayaran').val());
                if ($('#tanggal_mulai').val()) params.append('tanggal_mulai', $('#tanggal_mulai').val());
                if ($('#tanggal_selesai').val()) params.append('tanggal_selesai', $('#tanggal_selesai')
                    .val());

                const url = "{{ route('laporan.pembayaran.excel') }}" + (params.toString() ? '?' + params
                    .toString() : '');
                window.location.href = url;
            });

            $('#exportPdf').on('click', function() {
                const params = new URLSearchParams();

                // Add all filter parameters
                if ($('#tahun_ajaran_id').val()) params.append('tahun_ajaran_id', $('#tahun_ajaran_id')
                    .val());
                if ($('#jalur_pendaftaran_id').val()) params.append('jalur_pendaftaran_id', $(
                    '#jalur_pendaftaran_id').val());
                if ($('#status').val()) params.append('status', $('#status').val());
                if ($('#jenis_pembayaran').val()) params.append('jenis_pembayaran', $('#jenis_pembayaran')
                    .val());
                if ($('#metode_pembayaran').val()) params.append('metode_pembayaran', $(
                    '#metode_pembayaran').val());
                if ($('#tanggal_mulai').val()) params.append('tanggal_mulai', $('#tanggal_mulai').val());
                if ($('#tanggal_selesai').val()) params.append('tanggal_selesai', $('#tanggal_selesai')
                    .val());

                const url = "{{ route('laporan.pembayaran.pdf') }}" + (params.toString() ? '?' + params
                    .toString() : '');
                window.location.href = url;
            });

            // Auto-refresh every 5 minutes
            setInterval(function() {
                table.ajax.reload(null, false); // false to keep current page
            }, 300000); // 5 minutes

            // Show loading overlay during AJAX
            // $(document).ajaxStart(function() {
            //     $('#pembayaranTable').LoadingOverlay("show", {
            //         background: "rgba(165, 190, 100, 0.5)"
            //     });
            // });

            // $(document).ajaxStop(function() {
            //     $('#pembayaranTable').LoadingOverlay("hide");
            // });
        });
    </script>
@endpush
