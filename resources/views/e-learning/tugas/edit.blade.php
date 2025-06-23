@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Tugas</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tugas.update', $tuga->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="guru_kelas_id">Mata Pelajaran</label>
                                <select class="form-control @error('guru_kelas_id') is-invalid @enderror" id="guru_kelas_id"
                                    name="guru_kelas_id" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($kelasYangDiajar as $kyd)
                                        <option value="{{ $kyd->id }}"
                                            {{ $kyd->id == old('guru_kelas_id', $tuga->guru_kelas_id) ? 'selected' : '' }}>
                                            {{ $kyd->guruMataPelajaran->mataPelajaran->nama_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="judul">Judul Tugas</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $tuga->judul) }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi Tugas</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    required>{{ old('deskripsi', $tuga->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="batas_waktu">Batas Waktu Pengumpulan</label>
                                <input type="datetime-local" class="form-control @error('batas_waktu') is-invalid @enderror"
                                    id="batas_waktu" name="batas_waktu"
                                    value="{{ old('batas_waktu', $tuga->batas_waktu->format('Y-m-d\TH:i')) }}" required>
                                @error('batas_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="total_nilai">Total Nilai</label>
                                <input type="number" class="form-control @error('total_nilai') is-invalid @enderror"
                                    id="total_nilai" name="total_nilai"
                                    value="{{ old('total_nilai', $tuga->total_nilai) }}" required>
                                @error('total_nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="metode_pengerjaan">Metode Pengerjaan</label>
                                <input type="text" class="form-control"
                                    value="{{ ucfirst(str_replace('_', ' ', $tuga->metode_pengerjaan)) }}" readonly
                                    disabled>
                                <small class="text-muted">Metode pengerjaan tidak dapat diubah setelah tugas dibuat</small>
                            </div>

                            @if ($tuga->metode_pengerjaan === 'upload_file')
                                <div class="form-group mb-3" id="file_tugas_container">
                                    <label for="file_tugas">File Tugas</label>
                                    @if ($tuga->file_tugas)
                                        <div class="mb-2">
                                            <strong>File saat ini:</strong>
                                            <a href="{{ Storage::url($tuga->file_tugas) }}" target="_blank">
                                                Lihat File
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('file_tugas') is-invalid @enderror"
                                        id="file_tugas" name="file_tugas">
                                    @error('file_tugas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format yang diizinkan: PDF, DOC, DOCX. Maksimal 2MB</small>
                                </div>
                            @else
                                <div class="form-group mb-3">
                                    <label for="jenis">Jenis Soal</label>
                                    <input type="text" class="form-control"
                                        value="{{ ucfirst(str_replace('_', ' ', $tuga->jenis)) }}" readonly disabled>
                                    <small class="text-muted">Jenis soal tidak dapat diubah setelah tugas dibuat</small>
                                </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('tugas.index') }}" class="btn btn-secondary">Batal</a>
                                @if ($tuga->metode_pengerjaan === 'online')
                                    <a href="{{ route('tugas.show', $tuga->id) }}" class="btn btn-info">
                                        Kelola Soal
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
