@extends('layouts.app')

@push('styles')
    <!-- Custom Styles -->
    <style>
        .hover-effect:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .option-item {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-item:hover {
            border-color: #0d6efd !important;
            background-color: #f8f9ff;
        }

        .option-item input[type="radio"]:checked+label {
            color: #0d6efd;
            font-weight: 600;
        }

        .upload-section {
            transition: all 0.3s ease;
        }

        .upload-section:hover {
            border-color: #0d6efd !important;
            background-color: #f8f9ff !important;
        }

        .soal-item {
            transition: box-shadow 0.2s ease;
        }

        .soal-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .card {
            transition: all 0.2s ease;
        }

        .question-text {
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .soal-item {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush

@section('title', 'Kumpulkan Tugas')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 text-primary">
                            <i class="fas fa-tasks me-2"></i>{{ $tugas->judul }}
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Tugas</a></li>
                                <li class="breadcrumb-item active">Kumpulkan Tugas</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Timer Countdown (jika diperlukan) -->
                    <div class="text-end">
                        <div class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="fas fa-clock me-1"></i>
                            <span id="countdown">Memuat...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar dengan Detail Tugas -->
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Detail Tugas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small">MATA PELAJARAN</label>
                            <div class="fw-bold">{{ $tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">BATAS WAKTU</label>
                            <div class="fw-bold text-danger">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $tugas->batas_waktu->format('d M Y') }}
                                <br>
                                <i class="fas fa-clock me-1"></i>
                                {{ $tugas->batas_waktu->format('H:i') }} WIB
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">TOTAL NILAI</label>
                            <div class="fw-bold text-success fs-5">{{ $tugas->total_nilai }} Poin</div>
                        </div>

                        @if ($tugas->metode_pengerjaan === 'upload_file')
                            <div class="d-grid">
                                <a href="{{ Storage::url($tugas->file_tugas) }}" class="btn btn-outline-info"
                                    target="_blank">
                                    <i class="fas fa-download me-2"></i>Download File Tugas
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Deskripsi Tugas -->
                    <div class="card-footer bg-light">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-align-left me-1"></i>Deskripsi:
                        </h6>
                        <p class="mb-0 small">{{ $tugas->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8 col-xl-9">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-edit me-2"></i>Pengerjaan Tugas
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pengumpulan-tugas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">

                            @if ($tugas->metode_pengerjaan === 'upload_file')
                                <!-- Upload File Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <div
                                            class="upload-section p-4 bg-light rounded-3 border-2 border-dashed border-primary mb-4">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                                <h5 class="text-primary">Upload File Jawaban</h5>
                                            </div>

                                            <div class="mb-3">
                                                <input type="file"
                                                    class="form-control form-control-lg @error('file') is-invalid @enderror"
                                                    id="file" name="file" required>
                                                @error('file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="alert alert-info mb-0">
                                                <small>
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    <strong>Format:</strong> PDF, DOC, DOCX |
                                                    <strong>Ukuran Maksimal:</strong> 2MB
                                                </small>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="teks_pengumpulan" class="form-label">
                                                <i class="fas fa-sticky-note me-1"></i>Catatan Tambahan
                                            </label>
                                            <textarea class="form-control @error('teks_pengumpulan') is-invalid @enderror" id="teks_pengumpulan"
                                                name="teks_pengumpulan" rows="4" placeholder="Tambahkan catatan atau keterangan jika diperlukan...">{{ old('teks_pengumpulan') }}</textarea>
                                            @error('teks_pengumpulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Soal-soal Section -->
                                <div class="soal-container">
                                    @foreach ($tugas->soal as $index => $soal)
                                        <div class="soal-item mb-4 p-4 border rounded-3 bg-white shadow-sm">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="text-primary mb-0">
                                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                    Soal {{ $index + 1 }}
                                                </h5>
                                                <span class="badge bg-success">{{ $soal->poin }} Poin</span>
                                            </div>

                                            <div class="question-text mb-4 p-3 bg-light rounded">
                                                <p class="mb-0 fw-medium">{{ $soal->pertanyaan }}</p>
                                            </div>

                                            @if ($soal->jenis_soal === 'uraian')
                                                <div class="answer-section">
                                                    <label for="jawaban_{{ $soal->id }}" class="form-label fw-bold">
                                                        <i class="fas fa-pen me-1"></i>Jawaban Anda:
                                                    </label>
                                                    <textarea class="form-control form-control-lg @error('jawaban.' . $index . '.jawaban_teks') is-invalid @enderror"
                                                        id="jawaban_{{ $soal->id }}" name="jawaban[{{ $index }}][jawaban_teks]" rows="5" required
                                                        placeholder="Tulis jawaban Anda di sini...">{{ old('jawaban.' . $index . '.jawaban_teks') }}</textarea>
                                                    <input type="hidden" name="jawaban[{{ $index }}][soal_id]"
                                                        value="{{ $soal->id }}">
                                                    @error('jawaban.' . $index . '.jawaban_teks')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @else
                                                <div class="answer-section">
                                                    <label class="form-label fw-bold mb-3">
                                                        <i class="fas fa-list me-1"></i>Pilih Jawaban:
                                                    </label>
                                                    <div class="options-container">
                                                        @foreach ($soal->jawaban as $jawaban)
                                                            <div
                                                                class="form-check option-item p-3 mb-2 border rounded hover-effect">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jawaban[{{ $index }}][id_jawaban]"
                                                                    id="jawaban_{{ $soal->id }}_{{ $jawaban->id }}"
                                                                    value="{{ $jawaban->id }}" required>
                                                                <label class="form-check-label fw-medium"
                                                                    for="jawaban_{{ $soal->id }}_{{ $jawaban->id }}">
                                                                    {{ $jawaban->teks_jawaban }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="jawaban[{{ $index }}][soal_id]"
                                                        value="{{ $soal->id }}">
                                                    @error('jawaban.' . $index . '.id_jawaban')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                <a href="{{ route('tugas.show', $tugas->id) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Kumpulkan Tugas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Timer Script -->
    <script>
        // Timer countdown
        function updateCountdown() {
            const deadline = new Date('{{ $tugas->batas_waktu->format('Y-m-d H:i:s') }}');
            const now = new Date();
            const timeDiff = deadline - now;

            if (timeDiff > 0) {
                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                document.getElementById('countdown').innerHTML =
                    `${days}h ${hours}j ${minutes}m ${seconds}d`;
            } else {
                document.getElementById('countdown').innerHTML = 'Waktu Habis';
                document.getElementById('countdown').parentElement.classList.remove('bg-warning');
                document.getElementById('countdown').parentElement.classList.add('bg-danger', 'text-white');
            }
        }

        // Update setiap detik
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
@endpush
