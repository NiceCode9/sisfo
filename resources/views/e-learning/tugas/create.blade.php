@extends('layouts.app')

@section('title', 'Buat Tugas Baru')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800">
                            <i class="fas fa-plus-circle text-primary me-2"></i>
                            Buat Tugas Baru
                        </h1>
                        <p class="text-muted mb-0">Buat dan kelola tugas untuk siswa Anda</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tugas.index') }}" class="text-decoration-none">
                                    <i class="fas fa-tasks me-1"></i>Tugas
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Buat Baru</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-danger me-3 fs-4"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Terdapat kesalahan pada form:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="small">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary border-0 py-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                <i class="fas fa-clipboard-list text-white"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-1">Form Tugas Baru</h4>
                                <small class="opacity-75">Lengkapi informasi tugas dengan detail</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Mata Pelajaran Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="guru_kelas_id" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-book text-primary me-2"></i>Mata Pelajaran
                                        </label>
                                        <select
                                            class="form-select form-select-lg @error('guru_kelas_id') is-invalid @enderror"
                                            id="guru_kelas_id" name="guru_kelas_id" required>
                                            <option value="">🎯 Pilih Mata Pelajaran</option>
                                            @foreach ($kelasYangDiajar as $kyd)
                                                <option value="{{ $kyd->id }}"
                                                    {{ $kyd->id == old('guru_kelas_id') ? 'selected' : '' }}>
                                                    {{ $kyd->guruMataPelajaran->mataPelajaran->nama_pelajaran . ' - ' . $kyd->kelas->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('guru_kelas_id')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Information Section -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="judul" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-heading text-success me-2"></i>Judul Tugas
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul') }}"
                                            placeholder="Masukkan judul tugas yang menarik..." required>
                                        @error('judul')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_nilai" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>Total Nilai
                                        </label>
                                        <input type="number"
                                            class="form-control form-control-lg @error('total_nilai') is-invalid @enderror"
                                            id="total_nilai" name="total_nilai" value="{{ old('total_nilai', 100) }}"
                                            min="1" max="100" required>
                                        @error('total_nilai')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-align-left text-info me-2"></i>Deskripsi Tugas
                                        </label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5"
                                            placeholder="Jelaskan detail tugas, instruksi pengerjaan, dan kriteria penilaian..." required>{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Configuration Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="batas_waktu" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-clock text-danger me-2"></i>Batas Waktu Pengumpulan
                                        </label>
                                        <input type="datetime-local"
                                            class="form-control form-control-lg @error('batas_waktu') is-invalid @enderror"
                                            id="batas_waktu" name="batas_waktu" value="{{ old('batas_waktu') }}" required>
                                        @error('batas_waktu')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="metode_pengerjaan" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-cogs text-secondary me-2"></i>Metode Pengerjaan
                                        </label>
                                        <select
                                            class="form-select form-select-lg @error('metode_pengerjaan') is-invalid @enderror"
                                            id="metode_pengerjaan" name="metode_pengerjaan" required>
                                            <option value="online"
                                                {{ old('metode_pengerjaan') == 'online' ? 'selected' : '' }}>
                                                💻 Pengerjaan Online
                                            </option>
                                            <option value="upload_file"
                                                {{ old('metode_pengerjaan') == 'upload_file' ? 'selected' : '' }}>
                                                📎 Upload File
                                            </option>
                                        </select>
                                        @error('metode_pengerjaan')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Content Section -->
                            <div class="row mb-5">
                                <!-- Jenis Soal (Online) -->
                                <div class="col-12" id="jenis_soal_container">
                                    <div class="card bg-light border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="form-group mb-0">
                                                <label for="jenis" class="form-label fw-semibold text-dark mb-3">
                                                    <i class="fas fa-list-ul text-primary me-2"></i>Jenis Soal
                                                </label>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-card">
                                                            <input class="form-check-input" type="radio" name="jenis"
                                                                id="jenis_uraian" value="uraian"
                                                                {{ old('jenis', 'uraian') == 'uraian' ? 'checked' : '' }}>
                                                            <label class="form-check-label card h-100 border-2"
                                                                for="jenis_uraian">
                                                                <div class="card-body text-center p-3">
                                                                    <i class="fas fa-edit text-primary fs-2 mb-2"></i>
                                                                    <h6 class="mb-1">Uraian</h6>
                                                                    <small class="text-muted">Jawaban panjang</small>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-card">
                                                            <input class="form-check-input" type="radio" name="jenis"
                                                                id="jenis_pg" value="pilihan_ganda"
                                                                {{ old('jenis') == 'pilihan_ganda' ? 'checked' : '' }}>
                                                            <label class="form-check-label card h-100 border-2"
                                                                for="jenis_pg">
                                                                <div class="card-body text-center p-3">
                                                                    <i
                                                                        class="fas fa-check-circle text-success fs-2 mb-2"></i>
                                                                    <h6 class="mb-1">Pilihan Ganda</h6>
                                                                    <small class="text-muted">Multiple choice</small>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-card">
                                                            <input class="form-check-input" type="radio" name="jenis"
                                                                id="jenis_campuran" value="campuran"
                                                                {{ old('jenis') == 'campuran' ? 'checked' : '' }}>
                                                            <label class="form-check-label card h-100 border-2"
                                                                for="jenis_campuran">
                                                                <div class="card-body text-center p-3">
                                                                    <i
                                                                        class="fas fa-layer-group text-warning fs-2 mb-2"></i>
                                                                    <h6 class="mb-1">Campuran</h6>
                                                                    <small class="text-muted">Uraian + PG</small>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('jenis')
                                                    <div class="invalid-feedback d-block mt-2">
                                                        <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Upload (Upload File) -->
                                <div class="col-12" id="file_tugas_container" style="display: none;">
                                    <div class="card bg-light border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="form-group mb-0">
                                                <label for="file_tugas" class="form-label fw-semibold text-dark mb-3">
                                                    <i class="fas fa-cloud-upload-alt text-primary me-2"></i>File Tugas
                                                </label>
                                                <div
                                                    class="upload-area border-2 border-dashed border-primary rounded-3 p-4 text-center">
                                                    <input type="file"
                                                        class="form-control @error('file_tugas') is-invalid @enderror"
                                                        id="file_tugas" name="file_tugas" style="display: none;">
                                                    <div class="upload-content">
                                                        <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                                        <h6 class="mb-2">Klik untuk upload file atau drag & drop</h6>
                                                        <p class="text-muted small mb-3">Format: PDF, DOC, DOCX • Maksimal
                                                            2MB</p>
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="document.getElementById('file_tugas').click();">
                                                            <i class="fas fa-folder-open me-2"></i>Pilih File
                                                        </button>
                                                    </div>
                                                    <div class="file-info d-none">
                                                        <i class="fas fa-file-alt text-success fs-2 mb-2"></i>
                                                        <h6 class="text-success mb-1" id="file-name"></h6>
                                                        <small class="text-muted" id="file-size"></small>
                                                    </div>
                                                </div>
                                                @error('file_tugas')
                                                    <div class="invalid-feedback d-block mt-2">
                                                        <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('tugas.index') }}" class="btn btn-light px-4">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali
                                        </a>
                                        <div>
                                            <button type="reset" class="btn btn-outline-secondary px-4 me-2">
                                                <i class="fas fa-undo me-2"></i>Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="fas fa-save me-2"></i>Simpan Tugas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-check-card .form-check-input {
            display: none;
        }

        .form-check-card .form-check-label {
            cursor: pointer;
            transition: all 0.3s ease;
            border-color: #dee2e6 !important;
        }

        .form-check-card .form-check-label:hover {
            border-color: #007bff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .form-check-card .form-check-input:checked+.form-check-label {
            border-color: #007bff !important;
            background-color: rgba(0, 123, 255, 0.05);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .upload-area {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #007bff !important;
            background-color: rgba(0, 123, 255, 0.02);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .card {
            transition: all 0.3s ease;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            font-weight: bold;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            function toggleFormElements() {
                const metodePengerjaan = $('#metode_pengerjaan').val();
                if (metodePengerjaan === 'online') {
                    $('#jenis_soal_container').show().find('input[name="jenis"]').prop('required', true);
                    $('#file_tugas_container').hide();
                    $('#file_tugas').prop('required', false);
                } else {
                    $('#jenis_soal_container').hide().find('input[name="jenis"]').prop('required', false);
                    $('#file_tugas_container').show();
                    $('#file_tugas').prop('required', true);
                }
            }

            // File upload handling
            $('#file_tugas').change(function() {
                const file = this.files[0];
                const uploadArea = $('.upload-area');

                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

                    $('#file-name').text(fileName);
                    $('#file-size').text(fileSize);

                    uploadArea.find('.upload-content').addClass('d-none');
                    uploadArea.find('.file-info').removeClass('d-none');
                } else {
                    uploadArea.find('.upload-content').removeClass('d-none');
                    uploadArea.find('.file-info').addClass('d-none');
                }
            });

            // Upload area click handler
            $('.upload-area').click(function() {
                $('#file_tugas').click();
            });

            // Prevent form submission on upload area click
            $('.upload-area').click(function(e) {
                e.preventDefault();
            });

            // Initialize form state
            $('#metode_pengerjaan').change(toggleFormElements);
            toggleFormElements();

            // Set minimum datetime to current time
            const now = new Date();
            const minDateTime = now.toISOString().slice(0, 16);
            $('#batas_waktu').attr('min', minDateTime);
        });
    </script>
@endpush
