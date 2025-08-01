@extends('layouts.app')

@section('title', 'Import Data Siswa')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('siswa.index') }}">Data Siswa</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Import</li>
                </ol>
            </nav>
            <h2 class="h4">Import Data Siswa</h2>
            <p class="mb-0">Import data siswa dari file Excel.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('siswa.download-template') }}"
                class="btn btn-sm btn-success d-inline-flex align-items-center me-2 text-white">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Download Template
            </a>
            <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Upload File Excel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.process-import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                                name="file" accept=".xlsx,.xls,.csv">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Format yang didukung: .xlsx, .xls, .csv. Maksimal ukuran file: 5MB
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary" id="btnImport">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="loadingSpinner"></span>
                                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card shadow border-0 mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Petunjuk Import</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Format File Excel:</h6>
                        <ol class="mb-0 small">
                            <li>Download template terlebih dahulu</li>
                            <li>Isi data sesuai kolom yang tersedia</li>
                            <li>Pastikan NIK, NISN, dan NIS unik</li>
                            <li>Format tanggal: YYYY-MM-DD atau DD/MM/YYYY</li>
                            <li>Jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
                            <li>Pastikan kelas yang diisi sudah tersedia di sistem</li>
                        </ol>
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Perhatian:</h6>
                        <ul class="mb-0 small">
                            <li>Data dengan NIK/NISN/NIS yang sudah ada akan dilewati</li>
                            <li>Username akan dibuat otomatis dari NIK</li>
                            <li>Password default: <code>password123</code></li>
                            <li>Email yang kosong akan diisi otomatis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('errors'))
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Error Log</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-danger">
                    <h6>Ditemukan {{ count(session('errors')) }} error:</h6>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <ul class="mb-0">
                            @foreach (session('errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#importForm').on('submit', function() {
                const btnImport = $('#btnImport');
                const loadingSpinner = $('#loadingSpinner');

                btnImport.prop('disabled', true);
                loadingSpinner.removeClass('d-none');
                btnImport.find('.icon').addClass('d-none');
                btnImport.contents().last()[0].textContent = ' Mengimport...';
            });

            // Validation file size and type
            $('#file').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // Convert to MB
                    const allowedTypes = [
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel', 'text/csv'
                    ];

                    if (fileSize > 5) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 5MB'
                        });
                        this.value = '';
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Valid',
                            text: 'Hanya file Excel (.xlsx, .xls) dan CSV yang diperbolehkan'
                        });
                        this.value = '';
                        return;
                    }
                }
            });
        });
    </script>
@endpush
