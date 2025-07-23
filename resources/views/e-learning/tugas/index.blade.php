@extends('layouts.app')

@section('title', 'Daftar Tugas')

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }

        .hero-section {
            background: var(--primary-gradient);
            border-radius: 20px;
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.25);
        }

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .main-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            border-bottom: 3px solid #e9ecef;
            padding: 2rem;
            border-radius: 20px 20px 0 0 !important;
        }

        .filter-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        .form-control-modern {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-modern {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success-modern {
            background: var(--success-gradient);
            border: none;
            color: white;
        }

        .btn-danger-modern {
            background: var(--secondary-gradient);
            border: none;
            color: white;
        }

        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-modern thead th {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 1.2rem 1rem;
            border: none;
            position: relative;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .table-modern tbody tr:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1rem;
            border-color: #f1f3f4;
            vertical-align: middle;
        }

        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-aktif {
            background: linear-gradient(135deg, #00c851 0%, #007e33 100%);
            color: white;
        }

        .status-selesai {
            background: linear-gradient(135deg, #2196f3 0%, #0d47a1 100%);
            color: white;
        }

        .status-lewat {
            background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
            color: white;
        }

        .progress-modern {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar-modern {
            background: var(--success-gradient);
            transition: width 0.6s ease;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-sm-modern {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .fab-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .fab-btn:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
        }

        .filter-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-title-modern {
            font-size: 2rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 400;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 1.5rem;
                border-radius: 15px;
            }

            .main-card {
                border-radius: 15px;
            }

            .floating-action {
                bottom: 1rem;
                right: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.3rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <!-- Hero Section -->
        <div class="hero-section animate-fade-in">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="display-4 fw-bold mb-3">📚 Daftar Tugas</h1>
                        <p class="lead mb-0">Kelola dan pantau semua tugas pembelajaran dengan mudah</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="stats-card">
                            <h3 class="fw-bold mb-1" id="total-tugas">0</h3>
                            <small>Total Tugas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="main-card animate-fade-in animate-delay-1">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h3 class="card-title-modern">Manajemen Tugas</h3>
                        <p class="card-subtitle mb-0">Lihat, kelola, dan monitor progress tugas siswa</p>
                    </div>
                    @if (auth()->user()->hasRole('guru'))
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('tugas.create') }}" class="btn btn-primary-modern btn-modern">
                                <i class="fas fa-plus me-2"></i>Buat Tugas Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Filter Section -->
                <div class="filter-section animate-fade-in animate-delay-2">
                    <h5 class="mb-4">
                        <i class="fas fa-filter text-primary me-2"></i>Filter & Pencarian
                    </h5>
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <label for="tahun_ajaran_id" class="filter-label">Tahun Ajaran</label>
                            <select class="form-control form-control-modern select2" id="tahun_ajaran_id"
                                name="tahun_ajaran_id">
                                <option value="">🗓️ Semua Tahun Ajaran</option>
                                @foreach ($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">
                                        {{ \Carbon\Carbon::parse($ta->tanggal_mulai)->translatedFormat('d F Y') }} /
                                        {{ \Carbon\Carbon::parse($ta->tanggal_selesai)->translatedFormat('d F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (!auth()->user()->hasRole('siswa'))
                            <div class="col-lg-4 col-md-6">
                                <label for="kelas_id" class="filter-label">Kelas</label>
                                <select class="form-control form-control-modern select2" id="kelas_id" name="kelas_id">
                                    <option value="">🏫 Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-lg-4 col-md-6">
                            <label for="mata_pelajaran_id" class="filter-label">Mata Pelajaran</label>
                            <select class="form-control form-control-modern select2" id="mata_pelajaran_id"
                                name="mata_pelajaran_id">
                                <option value="">📖 Semua Mata Pelajaran</option>
                                @foreach ($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive animate-fade-in animate-delay-3">
                    <table class="table table-modern" id="tugas-table">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>📖 Mata Pelajaran</th>
                                <th>🏫 Kelas</th>
                                @if (auth()->user()->hasRole('superadmin'))
                                    <th>👨‍🏫 Guru</th>
                                @endif
                                <th>📝 Judul Tugas</th>
                                <th>🏷️ Jenis</th>
                                <th>⚙️ Metode</th>
                                <th>⏰ Batas Waktu</th>
                                <th>📊 Status</th>
                                <th>📈 Progress</th>
                                <th>👁️ Lihat</th>
                                <th width="120">🔧 Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Floating Action Button for Mobile -->
        @if (auth()->user()->hasRole('guru'))
            <div class="floating-action d-md-none">
                <a href="{{ route('tugas.create') }}" class="fab-btn">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Forms -->
    @foreach ($tugas ?? [] as $t)
        <form id="delete-form-{{ $t->id }}" action="{{ route('tugas.destroy', $t->id) }}" method="POST"
            class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable with modern styling
            let table = $('#tugas-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                language: {
                    processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                ajax: {
                    url: "{{ route('tugas.index') }}",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#tahun_ajaran_id').val();
                        d.kelas_id = $('#kelas_id').val();
                        d.mata_pelajaran_id = $('#mata_pelajaran_id').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center fw-bold'
                    },
                    {
                        data: 'mata_pelajaran',
                        name: 'guruKelas.guruMataPelajaran.mataPelajaran.nama_pelajaran',
                        render: function(data) {
                            return `<span class="badge bg-info text-white">${data}</span>`;
                        }
                    },
                    {
                        data: 'kelas',
                        name: 'guruKelas.kelas.nama_kelas',
                        render: function(data) {
                            return `<span class="badge bg-secondary text-white">${data}</span>`;
                        }
                    },
                    @if (auth()->user()->hasRole('superadmin'))
                        {
                            data: 'guru',
                            name: 'guruKelas.guruMataPelajaran.guru.user.name'
                        },
                    @endif {
                        data: 'judul',
                        name: 'judul',
                        render: function(data) {
                            return `<strong class="text-primary">${data}</strong>`;
                        }
                    },
                    {
                        data: 'jenis',
                        name: 'jenis',
                        render: function(data) {
                            return `<span class="badge badge-modern bg-info">${data}</span>`;
                        }
                    },
                    {
                        data: 'metode_pengerjaan',
                        name: 'metode_pengerjaan',
                        render: function(data) {
                            const icon = data === 'Online' ? '💻' : '📝';
                            return `${icon} ${data}`;
                        }
                    },
                    {
                        data: 'batas_waktu',
                        name: 'batas_waktu',
                        render: function(data) {
                            return `<small class="text-muted"><i class="fas fa-clock me-1"></i>${data}</small>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let badgeClass = 'status-aktif';
                            if (data.includes('Selesai')) badgeClass = 'status-selesai';
                            if (data.includes('Lewat')) badgeClass = 'status-lewat';
                            return `<span class="badge badge-modern ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: 'progres_pengumpulan',
                        name: 'progres_pengumpulan',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<div class="progress progress-modern" style="height: 8px;">
                        <div class="progress-bar progress-bar-modern" role="progressbar" style="width: ${data}%" aria-valuenow="${data}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">${data}%</small>`;
                        }
                    },
                    {
                        data: 'lihat_pengumpulan',
                        name: 'lihat_pengumpulan',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return `<div class="action-buttons">${data}</div>`;
                        }
                    }
                ],
                drawCallback: function() {
                    // Update total count
                    const info = this.api().page.info();
                    $('#total-tugas').text(info.recordsTotal);

                    // Add modern styling to action buttons
                    $('.btn').addClass('btn-sm-modern');
                    $('.btn-primary').addClass('btn-primary-modern');
                    $('.btn-success').addClass('btn-success-modern');
                    $('.btn-danger').addClass('btn-danger-modern');
                }
            });

            // Filter change handlers
            $('#tahun_ajaran_id, #kelas_id, #mata_pelajaran_id').change(function() {
                table.draw();
            });

            // Initialize Select2 with modern styling
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: true
            });
        });

        // Enhanced delete confirmation with SweetAlert style
        function confirmDelete(id) {
            // Create custom modal for better UX
            const modal = document.createElement('div');
            modal.innerHTML = `
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header" style="background: var(--secondary-gradient); color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        </div>
                        <h6>Apakah Anda yakin ingin menghapus tugas ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger-modern btn-modern" onclick="executeDelete(${id})">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    `;

            document.body.appendChild(modal);
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();

            // Remove modal after hiding
            document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        }

        function executeDelete(id) {
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            document.getElementById('delete-form-' + id).submit();
        }
    </script>
@endpush
