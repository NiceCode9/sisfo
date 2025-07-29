@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="container-fluid">
        <div class="profile-header">
            <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/80x80/ffffff/667eea?text=GURU" alt="Profile"
                    class="profile-avatar me-4">
                <div>
                    <h2 class="mb-1">Selamat Datang, {{ $guru->nama_guru ?? 'Bapak/Ibu Guru' }}!</h2>
                    <p class="mb-0 opacity-75">NIP: {{ $guru->nip ?? '-' }} • Bidang: {{ $guru->bidang_studi ?? '-' }}</p>
                    <p class="mb-0 opacity-75">{{ $tahunAjaranAktif->nama_tahun_ajaran ?? 'Tahun Ajaran' }} • Semester
                        {{ $tahunAjaranAktif->semester ?? 'Ganjil' }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card primary">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number">{{ $stats['total_kelas'] }}</div>
                            <h6 class="text-muted">Kelas Diajar</h6>
                        </div>
                        <i class="bi bi-people stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card secondary">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number">{{ $stats['total_siswa'] }}</div>
                            <h6 class="text-muted">Total Siswa</h6>
                        </div>
                        <i class="bi bi-person-check stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card success">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number">{{ $stats['total_materi'] }}</div>
                            <h6 class="text-muted">Materi Aktif</h6>
                        </div>
                        <i class="bi bi-journal-text stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card warning">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number">{{ $stats['total_tugas_aktif'] }}</div>
                            <h6 class="text-muted">Tugas Aktif</h6>
                        </div>
                        <i class="bi bi-clipboard-check stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('materi.index') }}">
                <div class="quick-action-card">
                    <i class="bi bi-plus-circle quick-action-icon"></i>
                    <h6>Buat Materi</h6>
                    <p class="text-muted small">Tambah materi pembelajaran baru</p>
                </div>
            </a>
            <a href="{{ route('tugas.index') }}">
                <div class="quick-action-card">
                    <i class="bi bi-clipboard-plus quick-action-icon"></i>
                    <h6>Buat Tugas</h6>
                    <p class="text-muted small">Berikan tugas kepada siswa</p>
                </div>
            </a>
            <a href="">
                <div class="quick-action-card">
                    <i class="bi bi-calendar-plus quick-action-icon"></i>
                    <h6>Atur Jadwal</h6>
                    <p class="text-muted small">Kelola jadwal mengajar</p>
                </div>
            </a>
            <a href="{{ route('tugas.index') }}">
                <div class="quick-action-card">
                    <i class="bi bi-bar-chart-line quick-action-icon"></i>
                    <h6>Lihat Nilai</h6>
                    <p class="text-muted small">Pantau progress siswa</p>
                </div>
            </a>
        </div>

        <div class="row">
            <!-- Kelas Yang Diajar -->
            <div class="col-lg-8 mb-4">
                <div class="modern-table">
                    <div class="p-4 border-bottom">
                        <h5 class="mb-0">Kelas Yang Diajar</h5>
                    </div>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Jumlah Siswa</th>
                                <th>Jadwal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelasYangDiajar as $kelas)
                                <tr>
                                    <td>
                                        <strong>{{ $kelas['nama_kelas'] }}</strong>
                                        @if ($kelas['jurusan'])
                                            <br><small class="text-muted">{{ $kelas['jurusan'] }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $kelas['mata_pelajaran'] }}</td>
                                    <td>
                                        <span class="badge badge-modern bg-primary">
                                            {{ $kelas['jumlah_siswa'] }} Siswa
                                        </span>
                                    </td>
                                    <td>
                                        @if ($kelas['jadwal'])
                                            {{ $kelas['jadwal']['hari'] }},
                                            {{ $kelas['jadwal']['jam_mulai'] }}-{{ $kelas['jadwal']['jam_selesai'] }}
                                            @if ($kelas['jadwal']['ruangan'])
                                                <br><small class="text-muted">{{ $kelas['jadwal']['ruangan'] }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-modern"
                                            onclick="viewKelasDetail({{ $kelas['id'] }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-4"></i>
                                            <p class="mt-2">Belum ada kelas yang diajar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-lg-4 mb-4">
                <div class="recent-activity">
                    <h5 class="mb-4">Aktivitas Terbaru</h5>

                    @forelse($aktivitasTerbaru as $aktivitas)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $aktivitas['title'] }}</strong>
                                <span class="activity-time">
                                    @if ($aktivitas['timestamp'])
                                        {{ $aktivitas['timestamp']->diffForHumans() }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <p class="mb-0 text-muted">{{ $aktivitas['description'] }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-clock-history display-4"></i>
                                <p class="mt-2">Belum ada aktivitas terbaru</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tugas Terbaru -->
        <div class="row">
            <div class="col-12">
                <div class="modern-table">
                    <div class="p-4 border-bottom">
                        <h5 class="mb-0">Tugas Terbaru</h5>
                    </div>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Kelas</th>
                                <th>Batas Waktu</th>
                                <th>Dikumpulkan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugasTerbaru as $tugas)
                                <tr>
                                    <td>
                                        <strong>{{ $tugas['judul'] }}</strong>
                                        @if ($tugas['jenis'])
                                            <br><small class="text-muted">{{ ucfirst($tugas['jenis']) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $tugas['nama_kelas'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tugas['batas_waktu'])->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 80px; height: 8px;">
                                                <div class="progress-bar
                                                    @if ($tugas['persentase_pengumpulan'] >= 80) bg-success
                                                    @elseif($tugas['persentase_pengumpulan'] >= 50) bg-warning
                                                    @else bg-danger @endif"
                                                    style="width: {{ $tugas['persentase_pengumpulan'] }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="small">{{ $tugas['total_pengumpulan'] }}/{{ $tugas['total_siswa'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match ($tugas['status']) {
                                                'aktif' => 'bg-success',
                                                'belum_terbit' => 'bg-info',
                                                'expired' => 'bg-secondary',
                                                'nonaktif' => 'bg-danger',
                                                default => 'bg-primary',
                                            };
                                            $statusText = match ($tugas['status']) {
                                                'aktif' => 'Aktif',
                                                'belum_terbit' => 'Belum Terbit',
                                                'expired' => 'Berakhir',
                                                'nonaktif' => 'Nonaktif',
                                                default => 'Unknown',
                                            };
                                        @endphp
                                        <span class="badge badge-modern {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-modern me-1"
                                            onclick="viewTugas({{ $tugas['id'] }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary btn-modern"
                                            onclick="editTugas({{ $tugas['id'] }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-clipboard-x display-4"></i>
                                            <p class="mt-2">Belum ada tugas yang dibuat</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Detail Kelas -->
    <div class="modal fade" id="kelasDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="kelasDetailContent">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stats-card.primary::before {
            background: var(--primary-gradient);
        }

        .stats-card.secondary::before {
            background: var(--secondary-gradient);
        }

        .stats-card.success::before {
            background: var(--success-gradient);
        }

        .stats-card.warning::before {
            background: var(--warning-gradient);
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-icon {
            font-size: 3rem;
            opacity: 0.1;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .modern-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modern-table .table thead {
            background: var(--primary-gradient);
            color: white;
        }

        .modern-table .table thead th {
            border: none;
            padding: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table .table tbody td {
            padding: 15px 20px;
            border-color: #f8f9fa;
            vertical-align: middle;
        }

        .modern-table .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .badge-modern {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            background: var(--primary-gradient);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
        }

        .chart-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .quick-action-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .quick-action-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .recent-activity {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .activity-item {
            padding: 20px;
            border-left: 4px solid var(--primary-gradient);
            margin-bottom: 15px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 0 10px 10px 0;
        }

        .activity-time {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .stats-number {
                font-size: 2rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.navbar-toggler');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !toggleBtn?.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Animate stats numbers on load
            const statsNumbers = document.querySelectorAll('.stats-number');
            statsNumbers.forEach(number => {
                const finalValue = parseInt(number.textContent);
                if (!isNaN(finalValue) && finalValue > 0) {
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 50);
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(timer);
                        }
                        number.textContent = currentValue;
                    }, 30);
                }
            });

            // Add hover effects to quick action cards
            const actionCards = document.querySelectorAll('.quick-action-card');
            actionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click handlers for navigation
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                });
            });
        });

        // Function to view class details
        function viewKelasDetail(guruKelasId) {
            const modal = new bootstrap.Modal(document.getElementById('kelasDetailModal'));
            const content = document.getElementById('kelasDetailContent');

            // Show loading
            content.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            modal.show();

            // Fetch class details
            fetch(`/dashboard/kelas-detail/${guruKelasId}`)
                .then(response => response.json())
                .then(data => {
                    content.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Informasi Kelas</h6>
                                <p><strong>Nama Kelas:</strong> ${data.guru_kelas.kelas.nama_kelas}</p>
                                <p><strong>Mata Pelajaran:</strong> ${data.guru_kelas.guru_mata_pelajaran.mata_pelajaran.nama_pelajaran}</p>
                                <p><strong>Tingkat:</strong> ${data.guru_kelas.kelas.tingkat}</p>
                                <p><strong>Jurusan:</strong> ${data.guru_kelas.kelas.jurusan || '-'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Statistik</h6>
                                <p><strong>Total Siswa:</strong> ${data.total_siswa}</p>
                                <p><strong>Tahun Ajaran:</strong> ${data.guru_kelas.tahun_ajaran.nama_tahun_ajaran}</p>
                            </div>
                        </div>
                        <hr>
                        <h6>Daftar Siswa</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.siswa.map((siswa, index) => `
                                                                                                <tr>
                                                                                                    <td>${index + 1}</td>
                                                                                                    <td>${siswa.nama_lengkap}</td>
                                                                                                    <td>${siswa.email}</td>
                                                                                                </tr>
                                                                                            `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            Gagal memuat detail kelas. Silakan coba lagi.
                        </div>
                    `;
                });
        }

        // Function to view tugas
        function viewTugas(tugasId) {
            // Implement navigation to tugas detail
            window.location.href = `/tugas/${tugasId}`;
        }

        // Function to edit tugas
        function editTugas(tugasId) {
            // Implement navigation to tugas edit
            window.location.href = `/tugas/${tugasId}/edit`;
        }
    </script>
@endpush
