@extends('layouts.app')

@section('title', 'Dashboard Superadmin')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 fw-bold text-primary animate-fade-in">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard Superadmin
            </h1>
            <div class="text-muted animate-fade-in-delay">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ date('d M Y') }}
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary border-0 shadow-sm animate-slide-up" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-shield fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="alert-heading mb-1">Selamat Datang, Superadmin!</h4>
                            <p class="mb-0">Kelola sistem pendaftaran siswa dengan mudah dan efisien.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="row g-4 mb-4">
            <!-- Total User -->
            <div class="col-lg-3 col-md-6 animate-card-1">
                <div class="card stat-card bg-gradient-primary text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Total User</h6>
                                <h2 class="mb-0 counter" data-target="{{ $totalUser ?? 0 }}">0</h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Siswa -->
            <div class="col-lg-3 col-md-6 animate-card-2">
                <div class="card stat-card bg-gradient-success text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Total Siswa Aktif</h6>
                                <h2 class="mb-0 counter" data-target="{{ $totalSiswa ?? 0 }}">0</h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="col-lg-3 col-md-6 animate-card-3">
                <div class="card stat-card bg-gradient-info text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Total Guru</h6>
                                <h2 class="mb-0 counter" data-target="{{ $totalGuru ?? 0 }}">0</h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calon Pendaftar -->
            <div class="col-lg-3 col-md-6 animate-card-4">
                <div class="card stat-card bg-gradient-warning text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Calon Pendaftar {{ $tahunAkademis }}</h6>
                                <h2 class="mb-0">
                                    <a href="{{ route('calon-siswa.index') }}"
                                        class="text-white text-decoration-none hover-scale">
                                        {{ $totalCasis }}
                                    </a>
                                </h2>
                                <small class="text-white-75">
                                    <i class="fas fa-bullseye me-1"></i>Kuota: {{ $totalKuota ?? '0' }} |
                                    <i class="fas fa-check me-1"></i>Terisi: {{ $totalTerisi ?? '0' }}
                                </small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pembayaran -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-md-6 animate-card-5">
                <div class="card stat-card bg-gradient-purple text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Pembayaran Diterima</h6>
                                <h2 class="mb-0 counter" data-target="{{ $pembayaranDiterima ?? 0 }}">0</h2>
                                <small class="text-white-75">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    Rp {{ number_format($totalPembayaranDiterima ?? 0, 0, ',', '.') }}
                                </small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 animate-card-6">
                <div class="card stat-card bg-gradient-orange text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Pembayaran Pending</h6>
                                <h2 class="mb-0 counter" data-target="{{ $pembayaranPending ?? 0 }}">0</h2>
                                <small class="text-white-75">
                                    <i class="fas fa-clock me-1"></i>Menunggu verifikasi
                                </small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 animate-card-7">
                <div class="card stat-card bg-gradient-danger text-white border-0 shadow-lg h-100">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="card-title text-white-50 mb-2">Pembayaran Ditolak</h6>
                                <h2 class="mb-0 counter" data-target="{{ $pembayaranDitolak ?? 0 }}">0</h2>
                                <small class="text-white-75">
                                    <i class="fas fa-times me-1"></i>Perlu perbaikan
                                </small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="stat-icon-bg">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart dan Informasi -->
        <div class="row g-4 mb-4">
            <!-- Chart Pendaftar -->
            <div class="col-lg-8 animate-slide-up">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                            Statistik Pendaftaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <canvas id="chartPendaftar"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <canvas id="chartPendaftarPerJalur"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengumuman Terbaru -->
            <div class="col-lg-4 animate-slide-up-delay">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bullhorn text-warning me-2"></i>
                                Pengumuman Terbaru
                            </h5>
                            <a href="" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-eye me-1"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($pengumumanTerbaru as $index => $pengumuman)
                                <a href=""
                                    class="list-group-item list-group-item-action border-0 py-3 announcement-item"
                                    style="animation-delay: {{ $index * 0.1 }}s">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-bell text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 fw-semibold">{{ $pengumuman->judul }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $pengumuman->tanggal_pengumuman->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="list-group-item border-0 py-4 text-center">
                                    <i class="fas fa-info-circle text-muted fa-2x mb-2"></i>
                                    <p class="text-muted mb-0">Tidak ada pengumuman</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kuota Pendaftaran per Jalur -->
        <div class="row">
            <div class="col-12 animate-slide-up">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie text-success me-2"></i>
                            Kuota Pendaftaran per Jalur
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">
                                            <i class="fas fa-route me-1"></i>Jalur Pendaftaran
                                        </th>
                                        <th class="fw-semibold text-center">
                                            <i class="fas fa-bullseye me-1"></i>Kuota
                                        </th>
                                        <th class="fw-semibold text-center">
                                            <i class="fas fa-users me-1"></i>Terisi
                                        </th>
                                        <th class="fw-semibold text-center">
                                            <i class="fas fa-user-plus me-1"></i>Sisa
                                        </th>
                                        <th class="fw-semibold">
                                            <i class="fas fa-percentage me-1"></i>Persentase
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kuotaPendaftaran as $index => $kuota)
                                        @php
                                            $persentase =
                                                $kuota->kuota > 0
                                                    ? round(($kuota->terisi / $kuota->kuota) * 100, 2)
                                                    : 0;
                                            $progressClass =
                                                $persentase >= 90
                                                    ? 'bg-danger'
                                                    : ($persentase >= 70
                                                        ? 'bg-warning'
                                                        : 'bg-success');
                                            $textClass =
                                                $persentase >= 90
                                                    ? 'text-danger'
                                                    : ($persentase >= 70
                                                        ? 'text-warning'
                                                        : 'text-success');
                                        @endphp
                                        <tr class="table-row-animate" style="animation-delay: {{ $index * 0.1 }}s">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-graduation-cap text-primary"></i>
                                                    </div>
                                                    <span
                                                        class="fw-medium">{{ $kuota->jalurPendaftaran->nama_jalur ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark fs-6">{{ $kuota->kuota }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary fs-6">{{ $kuota->terisi }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-secondary fs-6">{{ $kuota->kuota - $kuota->terisi }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar {{ $progressClass }} progress-bar-animated"
                                                            role="progressbar" style="width: {{ $persentase }}%"
                                                            aria-valuenow="{{ $persentase }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="fw-semibold {{ $textClass }}">{{ $persentase }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #3a7bd5 0%, #3a6073 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --orange-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --danger-gradient: linear-gradient(135deg, #fc2c77 0%, #6c5ce7 100%);
        }

        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }

        .bg-gradient-success {
            background: var(--success-gradient) !important;
        }

        .bg-gradient-info {
            background: var(--info-gradient) !important;
        }

        .bg-gradient-warning {
            background: var(--warning-gradient) !important;
        }

        .bg-gradient-purple {
            background: var(--purple-gradient) !important;
        }

        .bg-gradient-orange {
            background: var(--orange-gradient) !important;
        }

        .bg-gradient-danger {
            background: var(--danger-gradient) !important;
        }

        /* Animation Keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Animation Classes */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-fade-in-delay {
            animation: fadeIn 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }

        .animate-slide-up-delay {
            animation: slideUp 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }

        .animate-card-1 {
            animation: scaleIn 0.6s ease-out 0.1s forwards;
            opacity: 0;
        }

        .animate-card-2 {
            animation: scaleIn 0.6s ease-out 0.2s forwards;
            opacity: 0;
        }

        .animate-card-3 {
            animation: scaleIn 0.6s ease-out 0.3s forwards;
            opacity: 0;
        }

        .animate-card-4 {
            animation: scaleIn 0.6s ease-out 0.4s forwards;
            opacity: 0;
        }

        .animate-card-5 {
            animation: scaleIn 0.6s ease-out 0.5s forwards;
            opacity: 0;
        }

        .animate-card-6 {
            animation: scaleIn 0.6s ease-out 0.6s forwards;
            opacity: 0;
        }

        .animate-card-7 {
            animation: scaleIn 0.6s ease-out 0.7s forwards;
            opacity: 0;
        }

        .announcement-item {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .table-row-animate {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        /* Card Enhancements */
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 15px !important;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .stat-icon-bg {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 6rem;
            opacity: 0.1;
            pointer-events: none;
        }

        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Progress Bar Animation */
        .progress-bar-animated {
            animation: progress-bar-stripes 2s linear infinite;
        }

        @keyframes progress-bar-stripes {
            0% {
                background-position: 1rem 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        /* Custom Badges */
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        /* Custom Table */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Card Header */
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }

            .stat-card {
                margin-bottom: 1rem;
            }
        }

        /* Loading animation for counters */
        .counter {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 700;
        }

        /* Text utilities */
        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        /* Ripple effect for buttons */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Enhanced card shadows */
        .shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
        }

        .shadow-lg {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* Improved focus states */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Loading spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Counter Animation
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 16);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            const counters = document.querySelectorAll('.counter');
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px 0px -50px 0px'
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.dataset.target);
                        animateCounter(entry.target, target);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            counters.forEach(counter => observer.observe(counter));

            // Chart.js global config
            Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#6c757d';

            // Chart Pendaftar per Tahun Ajaran
            const ctxPendaftar = document.getElementById('chartPendaftar');
            if (ctxPendaftar) {
                new Chart(ctxPendaftar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartTahunAjaran->pluck('label') ?? []) !!},
                        datasets: [{
                            label: 'Jumlah Pendaftar',
                            data: {!! json_encode($chartTahunAjaran->pluck('jumlah') ?? []) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Pendaftar per Tahun Ajaran',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: 20
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart Pendaftar per Jalur
            const ctxPendaftarJalur = document.getElementById('chartPendaftarPerJalur');
            if (ctxPendaftarJalur) {
                new Chart(ctxPendaftarJalur.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartPendaftarPerJalur->pluck('label') ?? []) !!},
                        datasets: [{
                            data: {!! json_encode($chartPendaftarPerJalur->pluck('jumlah') ?? []) !!},
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'right'
                            },
                            title: {
                                display: true,
                                text: 'Pendaftar per Jalur',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: 20
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: true
                            }
                        },
                        cutout: '60%'
                    }
                });
            }
        });
    </script>
@endpush
