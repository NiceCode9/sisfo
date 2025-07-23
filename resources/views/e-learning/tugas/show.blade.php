@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">{{ $tuga->judul }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}"
                                        class="text-decoration-none">Tugas</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2">
                        @if (auth()->user()->hasRole('guru') && $tuga->guruKelas->guruMataPelajaran->guru->user->id === auth()->id())
                            <a href="{{ route('tugas.edit', $tuga->id) }}" class="btn btn-warning btn-sm shadow-sm">
                                <i class="fas fa-edit me-1"></i> Edit Tugas
                            </a>
                            @if ($tuga->metode_pengerjaan === 'online')
                                <a href="{{ route('soal.create', ['tugas' => $tuga->id]) }}"
                                    class="btn btn-primary btn-sm shadow-sm">
                                    <i class="fas fa-plus me-1"></i> Tambah Soal
                                </a>
                            @endif
                        @endif
                        <a href="{{ route('tugas.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Task Information Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informasi Tugas
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">MATA PELAJARAN</label>
                                    <div class="fw-bold text-dark">
                                        {{ $tuga->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">GURU PENGAMPU</label>
                                    <div class="fw-bold text-dark">
                                        {{ $tuga->guruKelas->guruMataPelajaran->guru->user->name }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">JENIS TUGAS</label>
                                    <div>
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                            <i
                                                class="fas fa-tag me-1"></i>{{ ucfirst(str_replace('_', ' ', $tuga->jenis)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">METODE PENGERJAAN</label>
                                    <div>
                                        <span
                                            class="badge {{ $tuga->metode_pengerjaan === 'online' ? 'bg-primary text-white' : 'bg-success text-white' }} px-3 py-2 rounded-pill">
                                            <i
                                                class="fas {{ $tuga->metode_pengerjaan === 'online' ? 'fa-laptop' : 'fa-upload' }} me-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $tuga->metode_pengerjaan)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">BATAS WAKTU</label>
                                    <div class="d-flex align-items-center">
                                        <span
                                            class="fw-bold text-dark me-2">{{ $tuga->batas_waktu->format('d M Y H:i') }}</span>
                                        @if ($tuga->batas_waktu->isPast())
                                            <span class="badge bg-danger text-white px-2 py-1 rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Berakhir
                                            </span>
                                        @else
                                            <span class="badge bg-success text-white px-2 py-1 rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Aktif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small fw-semibold mb-1">TOTAL NILAI</label>
                                    <div class="fw-bold text-primary fs-5">{{ $tuga->total_nilai }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Tugas
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-0 lh-lg">{{ $tuga->deskripsi }}</p>
                    </div>
                </div>

                <!-- File Download Card -->
                @if ($tuga->metode_pengerjaan === 'upload_file' && $tuga->file_tugas)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white border-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-download me-2"></i>File Tugas
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1">File tugas tersedia untuk diunduh</h6>
                                    <small class="text-muted">Silakan unduh file tugas untuk melihat detail
                                        instruksi</small>
                                </div>
                                <a href="{{ Storage::url($tuga->file_tugas) }}" class="btn btn-success shadow-sm"
                                    target="_blank">
                                    <i class="fas fa-download me-2"></i>Download File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Questions Section for Online Tasks -->
                @if ($tuga->metode_pengerjaan === 'online')
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-question-circle me-2"></i>Daftar Soal
                                </h5>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    {{ $tuga->soal()->count() }} Soal
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @forelse($tuga->soal()->orderBy('urutan')->get() as $index => $soal)
                                <div class="border-bottom p-4 {{ $index % 2 == 0 ? 'bg-light-subtle' : '' }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start">
                                                <span
                                                    class="badge bg-secondary rounded-circle me-3 p-2 fs-6">{{ $soal->urutan }}</span>
                                                <div>
                                                    <div class="mb-2">
                                                        <span
                                                            class="badge {{ $soal->jenis_soal === 'pilihan_ganda' ? 'bg-info-subtle text-info-emphasis' : 'bg-warning-subtle text-warning-emphasis' }} px-2 py-1 rounded-pill">
                                                            <i
                                                                class="fas {{ $soal->jenis_soal === 'pilihan_ganda' ? 'fa-list-ul' : 'fa-edit' }} me-1"></i>
                                                            {{ ucfirst(str_replace('_', ' ', $soal->jenis_soal)) }}
                                                        </span>
                                                    </div>
                                                    <p class="mb-0 text-dark">{{ Str::limit($soal->pertanyaan, 150) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="fw-bold text-primary fs-5">{{ $soal->poin }}</div>
                                            <small class="text-muted">poin</small>
                                        </div>
                                        @if (auth()->user()->hasRole('guru'))
                                            <div class="col-md-2 text-end">
                                                <div class="btn-group shadow-sm">
                                                    <a href="{{ route('soal.show', $soal->id) }}"
                                                        class="btn btn-outline-info btn-sm" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('soal.edit', $soal->id) }}"
                                                        class="btn btn-outline-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="confirmDelete('{{ $soal->id }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-question-circle fa-3x mb-3 opacity-50"></i>
                                        <h5>Belum ada soal</h5>
                                        <p>Soal untuk tugas ini belum ditambahkan</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Student Action Card -->
                @if (auth()->user()->hasRole('siswa'))
                    <div class="card shadow-sm border-0 sticky-top" style="top: 2rem;">
                        <div class="card-header bg-success text-white border-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tasks me-2"></i>Status Pengumpulan
                            </h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            @if (!$tuga->pengumpulanTugas()->where('siswa_id', auth()->user()->siswa->id)->exists())
                                @if (!$tuga->batas_waktu->isPast())
                                    <div class="mb-3">
                                        <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                                        <h6 class="text-warning">Tugas Belum Dikumpulkan</h6>
                                        <small class="text-muted">Batas waktu:
                                            {{ $tuga->batas_waktu->format('d M Y H:i') }}</small>
                                    </div>
                                    <a href="{{ route('pengumpulan-tugas.create', ['tugas' => $tuga->id]) }}"
                                        class="btn btn-success btn-lg w-100 shadow-sm">
                                        <i class="fas fa-upload me-2"></i>Kumpulkan Tugas
                                    </a>
                                @else
                                    <div class="text-danger">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                        <h6>Batas Waktu Berakhir</h6>
                                        <small>Pengumpulan tugas telah ditutup</small>
                                    </div>
                                @endif
                            @else
                                <div class="text-success">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <h5>Tugas Sudah Dikumpulkan</h5>
                                    <small class="text-muted">Terima kasih telah mengumpulkan tugas tepat waktu</small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quick Stats Card -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light border-0">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>Statistik Cepat
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row text-center g-3">
                            @if ($tuga->metode_pengerjaan === 'online')
                                <div class="col-6">
                                    <div class="border rounded p-3">
                                        <div class="fs-4 fw-bold text-primary">{{ $tuga->soal()->count() }}</div>
                                        <small class="text-muted">Total Soal</small>
                                    </div>
                                </div>
                            @endif
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="fs-4 fw-bold text-success">{{ $tuga->total_nilai }}</div>
                                    <small class="text-muted">Max Nilai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        }

        /* Custom Card Styling */
        .card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Enhanced Headers */
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        /* Button Styling */
        .btn {
            transition: all 0.2s ease;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Badge Styling */
        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Info Item Styling */
        .info-item label {
            letter-spacing: 0.8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .info-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        /* Question Item Styling */
        .bg-light-subtle {
            background-color: rgba(248, 249, 250, 0.8) !important;
        }

        /* Status Colors */
        .text-primary {
            color: #007bff !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-info {
            color: #17a2b8 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Background Colors */
        .bg-primary {
            background-color: #007bff !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        /* Animation Classes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-item a:hover {
            color: #007bff;
        }

        /* Shadow Utilities */
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        /* Custom Number Badge */
        .badge.rounded-circle {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sticky Sidebar */
        .sticky-top {
            position: sticky;
            top: 2rem;
            z-index: 1020;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card:hover {
                transform: none;
            }

            .sticky-top {
                position: relative;
                top: 0;
            }
        }

        /* Enhanced spacing */
        .p-4 {
            padding: 1.5rem !important;
        }

        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        /* Border radius utilities */
        .rounded-pill {
            border-radius: 50rem !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Add smooth scrolling animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
    </style>
@endpush
