@extends('layouts.app')

@section('title', 'Detail Pengumpulan Tugas')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --shadow-light: 0 8px 32px rgba(31, 38, 135, 0.37);
        --shadow-dark: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .container-fluid {
        padding: 2rem;
    }

    .glassmorphism {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-light);
    }

    .info-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .info-card:hover::before {
        transform: scaleX(1);
    }

    .info-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .card-header-modern {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem;
        border-radius: 20px 20px 0 0;
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .card-header-modern:hover::before {
        transform: translateX(100%);
    }

    .card-body-modern {
        padding: 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .status-badge.bg-success {
        background: var(--success-gradient) !important;
        border: none;
    }

    .status-badge.bg-warning {
        background: var(--warning-gradient) !important;
        border: none;
    }

    .main-content {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 25px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-light);
        overflow: hidden;
    }

    .accordion-modern {
        border: none;
        background: transparent;
    }

    .accordion-item-modern {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .accordion-item-modern:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .accordion-header-modern {
        border: none;
        background: transparent;
    }

    .accordion-button-modern {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .accordion-button-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .accordion-button-modern:hover::before {
        left: 100%;
    }

    .accordion-button-modern:not(.collapsed) {
        background: var(--secondary-gradient);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .accordion-button-modern:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }

    .accordion-body-modern {
        padding: 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .question-container {
        background: linear-gradient(135deg, #f6f9fc 0%, #e9f4ff 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #3b82f6;
        position: relative;
        overflow: hidden;
    }

    .question-container::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        transform: translate(50%, -50%);
    }

    .answer-container {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .answer-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .answer-container:hover::before {
        transform: scaleY(1);
    }

    .answer-text {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        padding: 1.25rem;
        border-radius: 10px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        max-height: 200px;
        overflow-y: auto;
        font-family: 'Inter', sans-serif;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
        transition: all 0.3s ease;
        position: relative;
    }

    .answer-text.expanded {
        max-height: none;
    }

    .answer-text::-webkit-scrollbar {
        width: 6px;
    }

    .answer-text::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .answer-text::-webkit-scrollbar-thumb {
        background: var(--primary-gradient);
        border-radius: 10px;
    }

    .expand-btn {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .expand-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .grading-section {
        background: var(--secondary-gradient);
        border-radius: 25px;
        padding: 2.5rem;
        margin-top: 2rem;
        position: relative;
        overflow: hidden;
    }

    .grading-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .grading-section * {
        position: relative;
        z-index: 1;
    }

    .grading-section h5 {
        color: white;
        margin-bottom: 1.5rem;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .form-control-modern {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(255, 255, 255, 0.6);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    .btn-modern {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-modern:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .result-section {
        background: var(--success-gradient);
        border-radius: 25px;
        padding: 2.5rem;
        margin-top: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .result-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .score-display {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .score-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(45deg, #fff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
    }

    .file-download-btn {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 1rem 2rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .file-download-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .file-download-btn:hover::before {
        left: 100%;
    }

    .file-download-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .word-count {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .floating-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: float-particle 10s infinite linear;
    }

    @keyframes float-particle {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100vh) rotate(360deg);
            opacity: 0;
        }
    }

    .section-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 2rem;
        text-align: center;
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    .alert-modern {
        background: rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        color: #1e40af;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        .grading-section,
        .result-section {
            padding: 2rem;
        }

        .score-number {
            font-size: 2rem;
        }
    }

    .badge-modern {
        background: var(--primary-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 0.5rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .badge-modern.bg-info {
        background: var(--success-gradient);
    }

    .badge-modern.bg-secondary {
        background: var(--dark-gradient);
    }
</style>
@endpush

@section('content')
    <!-- Floating Particles Background -->
    <div class="floating-particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 7s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 8s;"></div>
    </div>

    <div class="container-fluid">
        <h1 class="section-title">📚 Detail Pengumpulan Tugas</h1>

        <!-- Header Information Cards -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="info-card">
                    <div class="card-header-modern">
                        <h5 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>
                            Informasi Tugas
                        </h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-bookmark text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Judul Tugas</small>
                                <div class="fw-bold">{{ $pengumpulanTuga->tugas->judul }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-book text-success me-3"></i>
                            <div>
                                <small class="text-muted">Mata Pelajaran</small>
                                <div class="fw-bold">{{ $pengumpulanTuga->tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-warning me-3"></i>
                            <div>
                                <small class="text-muted">Batas Waktu</small>
                                <div class="fw-bold">{{ $pengumpulanTuga->tugas->batas_waktu->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="info-card">
                    <div class="card-header-modern" style="background: var(--success-gradient);">
                        <h5 class="mb-0">
                            <i class="fas fa-user-check me-2"></i>
                            Informasi Pengumpulan
                        </h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Nama Siswa</small>
                                <div class="fw-bold">{{ $pengumpulanTuga->siswa->user->name }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar text-info me-3"></i>
                            <div>
                                <small class="text-muted">Waktu Pengumpulan</small>
                                <div class="fw-bold">{{ $pengumpulanTuga->waktu_pengumpulan->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-flag me-3"></i>
                            <div>
                                <small class="text-muted">Status Pengumpulan</small>
                                <div class="mt-1">
                                    @if ($pengumpulanTuga->waktu_pengumpulan <= $pengumpulanTuga->tugas->batas_waktu)
                                        <span class="status-badge bg-success">
                                            <i class="fas fa-check"></i> Tepat Waktu
                                        </span>
                                    @else
                                        <span class="status-badge bg-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="card-body-modern">
                @if ($pengumpulanTuga->tugas->metode_pengerjaan === 'upload_file')
                    <div class="mb-4">
                        <h5 class="mb-4">
                            <i class="fas fa-file-upload me-2"></i>
                            File Jawaban
                        </h5>
                        @if ($pengumpulanTuga->path_file)
                            <div class="text-center mb-4">
                                <a href="{{ Storage::url($pengumpulanTuga->path_file) }}"
                                   class="file-download-btn" target="_blank">
                                    <i class="fas fa-download"></i>
                                    Download File Jawaban
                                </a>
                            </div>
                        @endif

                        @if ($pengumpulanTuga->teks_pengumpulan)
                            <div class="question-container">
                                <h6 class="mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    Catatan Siswa
                                </h6>
                                <div class="answer-text">{{ $pengumpulanTuga->teks_pengumpulan }}</div>
                                <div class="word-count">
                                    📝 {{ str_word_count($pengumpulanTuga->teks_pengumpulan) }} kata
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mb-4">
                        <h5 class="mb-4">
                            <i class="fas fa-question-circle me-2"></i>
                            Jawaban Soal
                        </h5>

                        <div class="accordion accordion-modern" id="answersAccordion">
                            @foreach ($pengumpulanTuga->jawabanSiswa as $jawaban)
                                <div class="accordion-item-modern">
                                    <h2 class="accordion-header-modern" id="heading{{ $loop->iteration }}">
                                        <button class="accordion-button-modern {{ !$loop->first ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $loop->iteration }}"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $loop->iteration }}">
                                            <i class="fas fa-question me-2"></i>
                                            <strong>Soal {{ $loop->iteration }}</strong>
                                            @if ($jawaban->soal->jenis_soal === 'uraian')
                                                <span class="badge-modern bg-info">✍️ Uraian</span>
                                            @else
                                                <span class="badge-modern bg-secondary">☑️ Pilihan Ganda</span>
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $loop->iteration }}"
                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $loop->iteration }}"
                                         data-bs-parent="#answersAccordion">
                                        <div class="accordion-body-modern">
                                            <div class="question-container">
                                                <h6 class="mb-3">
                                                    <i class="fas fa-lightbulb me-2"></i>
                                                    Pertanyaan
                                                </h6>
                                                <div class="answer-text">{{ $jawaban->soal->pertanyaan }}</div>
                                            </div>

                                            @if ($jawaban->soal->jenis_soal === 'uraian')
                                                <div class="answer-container">
                                                    <h6 class="mb-3">
                                                        <i class="fas fa-pencil-alt me-2"></i>
                                                        Jawaban Siswa
                                                    </h6>
                                                    <div class="answer-text" id="answer-{{ $loop->iteration }}">
                                                        {{ $jawaban->jawaban_teks }}
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div class="word-count">
                                                            📝 <span id="word-count-{{ $loop->iteration }}">{{ str_word_count($jawaban->jawaban_teks) }}</span> kata
                                                        </div>
                                                        @if (strlen($jawaban->jawaban_teks) > 500)
                                                            <button class="expand-btn" onclick="toggleAnswer({{ $loop->iteration }})">
                                                                <i class="fas fa-expand-arrows-alt"></i>
                                                                <span>Lihat Selengkapnya</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="answer-container">
                                                    <h6 class="mb-3">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        Jawaban Siswa
                                                    </h6>
                                                    <div class="answer-text">
                                                    <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(59, 130, 246, 0.1);">
                                                        <div class="me-3">
                                                            <i class="fas fa-arrow-right text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $jawaban->jawaban_pilihan_ganda }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Grading Section -->
                @if (auth()->user()->hasRole('guru'))
                    <div class="grading-section">
                        <h5>
                            <i class="fas fa-star me-2"></i>
                            Penilaian Tugas
                        </h5>

                        <form action="{{ route('pengumpulan-tugas.grade', $pengumpulanTuga->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nilai" class="form-label text-white">
                                        <i class="fas fa-award me-2"></i>
                                        Nilai (0-100)
                                    </label>
                                    <input type="number"
                                           class="form-control form-control-modern"
                                           id="nilai"
                                           name="nilai"
                                           min="0"
                                           max="100"
                                           value="{{ old('nilai', $pengumpulanTuga->nilai) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label text-white">
                                        <i class="fas fa-clipboard-check me-2"></i>
                                        Status
                                    </label>
                                    <select class="form-control form-control-modern" id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="dinilai" {{ $pengumpulanTuga->status === 'dinilai' ? 'selected' : '' }}>
                                            Dinilai
                                        </option>
                                        <option value="perlu_revisi" {{ $pengumpulanTuga->status === 'perlu_revisi' ? 'selected' : '' }}>
                                            Perlu Revisi
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="feedback" class="form-label text-white">
                                    <i class="fas fa-comment-alt me-2"></i>
                                    Feedback untuk Siswa
                                </label>
                                <textarea class="form-control form-control-modern"
                                          id="feedback"
                                          name="feedback"
                                          rows="4"
                                          placeholder="Berikan feedback yang konstruktif untuk siswa...">{{ old('feedback', $pengumpulanTuga->feedback) }}</textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-modern">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Penilaian
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Result Section (if graded) -->
                @if ($pengumpulanTuga->nilai !== null)
                    <div class="result-section">
                        <div class="text-center">
                            <h5 class="mb-4">
                                <i class="fas fa-trophy me-2"></i>
                                Hasil Penilaian
                            </h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="score-display">
                                        <div class="score-number">{{ $pengumpulanTuga->nilai }}</div>
                                        <div class="mt-2">
                                            <strong>Nilai</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="score-display">
                                        <div class="h4 mb-0">
                                            @if ($pengumpulanTuga->nilai >= 90)
                                                <i class="fas fa-star text-warning"></i>
                                                <div class="mt-2">Sangat Baik</div>
                                            @elseif ($pengumpulanTuga->nilai >= 80)
                                                <i class="fas fa-thumbs-up text-success"></i>
                                                <div class="mt-2">Baik</div>
                                            @elseif ($pengumpulanTuga->nilai >= 70)
                                                <i class="fas fa-check text-info"></i>
                                                <div class="mt-2">Cukup</div>
                                            @else
                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                <div class="mt-2">Perlu Perbaikan</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="score-display">
                                        <div class="h4 mb-0">
                                            @if ($pengumpulanTuga->status === 'dinilai')
                                                <i class="fas fa-check-circle text-success"></i>
                                                <div class="mt-2">Selesai</div>
                                            @else
                                                <i class="fas fa-redo text-warning"></i>
                                                <div class="mt-2">Revisi</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($pengumpulanTuga->feedback)
                                <div class="mt-4">
                                    <h6 class="mb-3">
                                        <i class="fas fa-comment-dots me-2"></i>
                                        Feedback Guru
                                    </h6>
                                    <div class="p-4 rounded-3" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $pengumpulanTuga->feedback }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Navigation -->
                <div class="text-center mt-4">
                    <a href="{{ route('pengumpulan-tugas.index') }}" class="btn btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Pengumpulan
                    </a>
                </div>

                <!-- Alert for ungraded submissions -->
                @if (is_null($pengumpulanTuga->nilai) && !auth()->user()->hasRole('guru'))
                    <div class="alert-modern">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-3"></i>
                            <div>
                                <strong>Informasi:</strong> Tugas Anda sedang dalam proses penilaian. Hasil akan ditampilkan setelah guru selesai menilai.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleAnswer(index) {
            const answerElement = document.getElementById(`answer-${index}`);
            const button = event.target.closest('.expand-btn');

            if (answerElement.classList.contains('expanded')) {
                answerElement.classList.remove('expanded');
                button.innerHTML = '<i class="fas fa-expand-arrows-alt"></i> <span>Lihat Selengkapnya</span>';
            } else {
                answerElement.classList.add('expanded');
                button.innerHTML = '<i class="fas fa-compress-arrows-alt"></i> <span>Sembunyikan</span>';
            }
        }

        // Auto-expand short answers
        document.addEventListener('DOMContentLoaded', function() {
            const answers = document.querySelectorAll('.answer-text');
            answers.forEach((answer, index) => {
                if (answer.textContent.length <= 500) {
                    answer.classList.add('expanded');
                }
            });
        });

        // Smooth scroll for accordion
        document.querySelectorAll('.accordion-button-modern').forEach(button => {
            button.addEventListener('click', function() {
                setTimeout(() => {
                    this.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            });
        });

        // Form validation
        const gradeForm = document.querySelector('form[action*="grade"]');
        if (gradeForm) {
            gradeForm.addEventListener('submit', function(e) {
                const nilai = document.getElementById('nilai').value;
                const status = document.getElementById('status').value;

                if (!nilai || !status) {
                    e.preventDefault();
                    alert('Mohon lengkapi nilai dan status sebelum menyimpan.');
                    return;
                }

                if (nilai < 0 || nilai > 100) {
                    e.preventDefault();
                    alert('Nilai harus antara 0 dan 100.');
                    return;
                }

                // Confirmation for grading
                if (!confirm('Apakah Anda yakin ingin menyimpan penilaian ini?')) {
                    e.preventDefault();
                }
            });
        }

        // Add floating animation to particles
        function createParticles() {
            const container = document.querySelector('.floating-particles');
            if (!container) return;

            setInterval(() => {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = '0s';
                particle.style.animationDuration = (Math.random() * 5 + 5) + 's';
                container.appendChild(particle);

                setTimeout(() => {
                    particle.remove();
                }, 10000);
            }, 2000);
        }

        createParticles();
    </script>
    @endpush
@endsection
