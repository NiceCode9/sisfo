@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
        }

        .gradient-card {
            background: var(--primary-gradient);
            border-radius: 15px;
            color: white;
            transition: all 0.3s ease;
            border: none;
            box-shadow: var(--card-shadow);
        }

        .gradient-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .gradient-card.success {
            background: var(--success-gradient);
        }

        .gradient-card.warning {
            background: var(--warning-gradient);
        }

        .gradient-card.info {
            background: var(--info-gradient);
        }

        .gradient-card.danger {
            background: var(--danger-gradient);
        }

        .modern-card {
            border-radius: 15px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .progress-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(from 0deg, #667eea 0%, #764ba2 var(--percentage, 0%), #e9ecef var(--percentage, 0%), #e9ecef 100%);
            position: relative;
        }

        .progress-circle::before {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
        }

        .progress-text {
            position: relative;
            z-index: 1;
            font-weight: bold;
            color: #667eea;
        }

        .schedule-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .schedule-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .assignment-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .assignment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .assignment-priority {
            width: 4px;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .priority-high {
            background: #dc3545;
        }

        .priority-medium {
            background: #ffc107;
        }

        .priority-low {
            background: #28a745;
        }

        .material-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        }

        .material-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .announcement-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%);
            border-left: 4px solid #ef4444;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .time-indicator {
            font-size: 0.875rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .time-indicator i {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .welcome-banner {
                padding: 1.5rem;
            }

            .gradient-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        {{-- Welcome Banner --}}
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-6 fw-bold mb-2">Selamat Datang, {{ $siswa->calonSiswa->nama_lengkap }}!</h1>
                    <p class="lead mb-0">
                        @if ($kelasAktif)
                            Kelas {{ $kelasAktif->kelas->nama_kelas }} • {{ $tahunAjaranAktif->nama_tahun_ajaran }}
                        @else
                            Selamat datang di portal pembelajaran
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="badge-modern badge bg-light text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        @if (!$kelasAktif)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning rounded-3 shadow-sm">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Anda belum terdaftar di kelas aktif untuk tahun ajaran ini.
                    </div>
                </div>
            </div>
        @else
            {{-- Statistics Cards --}}
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card gradient-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-light mb-1">Total Tugas</h6>
                                    <h2 class="mb-0 fw-bold">{{ $statistik['total_tugas'] }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-tasks fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card gradient-card success">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-light mb-1">Tugas Selesai</h6>
                                    <h2 class="mb-0 fw-bold">{{ $statistik['tugas_selesai'] }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card gradient-card warning">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-light mb-1">Tugas Pending</h6>
                                    <h2 class="mb-0 fw-bold">{{ $statistik['tugas_pending'] }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card gradient-card info">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-light mb-1">Rata-rata Nilai</h6>
                                    <h2 class="mb-0 fw-bold">{{ $statistik['rata_nilai'] }}</h2>
                                </div>
                                <div class="progress-circle" style="--percentage: {{ $statistik['rata_nilai'] }}%">
                                    <div class="progress-text">{{ $statistik['rata_nilai'] }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Jadwal Hari Ini --}}
                <div class="col-lg-8">
                    <div class="card modern-card">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>
                                    Jadwal Hari Ini
                                </h5>
                                <span class="badge bg-primary">{{ now()->format('l, d M Y') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($jadwalHariIni->count() > 0)
                                <div class="row g-3">
                                    @foreach ($jadwalHariIni as $jadwal)
                                        <div class="col-md-6">
                                            <div class="schedule-item">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <h6 class="mb-0 text-primary">
                                                        {{ $jadwal->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}
                                                    </h6>
                                                    <span
                                                        class="badge bg-light text-dark">{{ $jadwal->jam_mulai->format('H:i') }}
                                                        - {{ $jadwal->jam_selesai->format('H:i') }}</span>
                                                </div>
                                                <div class="small text-muted mb-1">
                                                    <i
                                                        class="fas fa-user me-1"></i>{{ $jadwal->guruKelas->guruMataPelajaran->guru->nama_guru }}
                                                </div>
                                                <div class="small text-muted">
                                                    <i
                                                        class="fas fa-map-marker-alt me-1"></i>{{ $jadwal->ruangan ?? 'Ruangan belum ditentukan' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Tidak ada jadwal hari ini</h6>
                                    <p class="text-muted mb-0">Nikmati waktu istirahat Anda!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tugas Terbaru --}}
                    <div class="card modern-card mt-4">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-clipboard-list text-warning me-2"></i>
                                    Tugas Terbaru
                                </h5>
                                <a href="#" class="btn btn-sm btn-outline-primary btn-modern">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($tugasTerbaru->count() > 0)
                                <div class="row g-3">
                                    @foreach ($tugasTerbaru as $tugas)
                                        <div class="col-12">
                                            <div class="assignment-card card position-relative">
                                                <div
                                                    class="assignment-priority {{ $tugas->batas_waktu->diffInDays(now()) <= 1 ? 'priority-high' : ($tugas->batas_waktu->diffInDays(now()) <= 3 ? 'priority-medium' : 'priority-low') }}">
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start justify-content-between">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">{{ $tugas->judul }}</h6>
                                                            <p class="text-muted mb-2 small">
                                                                {{ $tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}
                                                            </p>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="time-indicator">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span>{{ $tugas->batas_waktu->diffForHumans() }}</span>
                                                                </div>
                                                                <span
                                                                    class="badge {{ $tugas->batas_waktu->diffInDays(now()) <= 1 ? 'bg-danger' : 'bg-warning' }}">
                                                                    {{ $tugas->batas_waktu->format('d M Y H:i') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3">
                                                            <a href="#"
                                                                class="btn btn-sm btn-outline-primary btn-modern">
                                                                <i class="fas fa-eye me-1"></i>Lihat
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada tugas terbaru</h6>
                                    <p class="text-muted mb-0">Tugas baru akan muncul di sini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    {{-- Pengumuman --}}
                    <div class="card modern-card mb-4">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bullhorn text-danger me-2"></i>
                                Pengumuman
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($pengumuman->count() > 0)
                                @foreach ($pengumuman as $announce)
                                    <div class="announcement-card p-3 mb-3">
                                        <h6 class="mb-2">{{ $announce->judul }}</h6>
                                        <p class="text-muted mb-2 small">{{ Str::limit($announce->isi, 100) }}</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <small class="text-muted">
                                                <i
                                                    class="fas fa-calendar me-1"></i>{{ $announce->tanggal_pengumuman->format('d M Y') }}
                                            </small>
                                            <a href="#" class="btn btn-sm btn-outline-primary btn-modern">Baca</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada pengumuman</h6>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Materi Terbaru --}}
                    <div class="card modern-card">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-book-open text-success me-2"></i>
                                Materi Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($materiTerbaru->count() > 0)
                                @foreach ($materiTerbaru as $materi)
                                    <div class="material-card card mb-3">
                                        <div class="card-body p-3">
                                            <h6 class="mb-2">{{ $materi->judul }}</h6>
                                            <p class="text-muted mb-2 small">
                                                {{ $materi->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}
                                            </p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <small class="text-muted">
                                                    <i
                                                        class="fas fa-calendar me-1"></i>{{ $materi->created_at->format('d M Y') }}
                                                </small>
                                                <a href="#" class="btn btn-sm btn-outline-success btn-modern">
                                                    <i class="fas fa-download me-1"></i>Unduh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada materi</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Animate progress circles
        document.addEventListener('DOMContentLoaded', function() {
            const progressCircles = document.querySelectorAll('.progress-circle');

            progressCircles.forEach(circle => {
                const percentage = circle.style.getPropertyValue('--percentage');
                if (percentage) {
                    // Add animation delay for smooth loading
                    setTimeout(() => {
                        circle.style.setProperty('--percentage', percentage);
                    }, 500);
                }
            });
        });

        // Add smooth hover effects
        document.querySelectorAll('.gradient-card, .modern-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endpush
