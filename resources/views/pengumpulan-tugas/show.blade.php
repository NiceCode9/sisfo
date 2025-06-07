@extends('layouts.app')

@section('title', 'Detail Pengumpulan Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pengumpulan Tugas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Informasi Tugas</h5>
                                <p><strong>Judul:</strong> {{ $pengumpulanTuga->tugas->judul }}</p>
                                <p><strong>Mata Pelajaran:</strong>
                                    {{ $pengumpulanTuga->tugas->guruMataPelajaran->mataPelajaran->nama }}</p>
                                <p><strong>Batas Waktu:</strong>
                                    {{ $pengumpulanTuga->tugas->batas_waktu->format('d M Y H:i') }}</p>
                                <p><strong>Total Nilai:</strong> {{ $pengumpulanTuga->tugas->total_nilai }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Informasi Pengumpulan</h5>
                                <p><strong>Siswa:</strong> {{ $pengumpulanTuga->siswa->nama }}</p>
                                <p><strong>Waktu Pengumpulan:</strong>
                                    {{ $pengumpulanTuga->waktu_pengumpulan->format('d M Y H:i') }}</p>
                                <p><strong>Status:</strong>
                                    @if ($pengumpulanTuga->waktu_pengumpulan <= $pengumpulanTuga->tugas->batas_waktu)
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    @else
                                        <span class="badge bg-warning">Terlambat</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if ($pengumpulanTuga->tugas->metode_pengerjaan === 'upload_file')
                            <div class="mb-4">
                                <h5>File Jawaban</h5>
                                @if ($pengumpulanTuga->path_file)
                                    <a href="{{ Storage::url($pengumpulanTuga->path_file) }}" class="btn btn-info"
                                        target="_blank">
                                        <i class="fas fa-download"></i> Download File Jawaban
                                    </a>
                                @endif

                                @if ($pengumpulanTuga->teks_pengumpulan)
                                    <div class="mt-3">
                                        <h6>Catatan Siswa:</h6>
                                        <p>{{ $pengumpulanTuga->teks_pengumpulan }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="mb-4">
                                <h5>Jawaban</h5>
                                @foreach ($pengumpulanTuga->jawabanSiswa as $jawaban)
                                    <div class="soal-item mb-3">
                                        <p><strong>Soal {{ $loop->iteration }}:</strong> {{ $jawaban->soal->pertanyaan }}
                                        </p>

                                        @if ($jawaban->soal->jenis_soal === 'uraian')
                                            <p><strong>Jawaban:</strong> {{ $jawaban->jawaban_teks }}</p>
                                        @else
                                            <p><strong>Jawaban:</strong> {{ $jawaban->jawaban->teks_jawaban }}</p>
                                            <p>
                                                <strong>Status:</strong>
                                                @if ($jawaban->jawaban->jawaban_benar)
                                                    <span class="badge bg-success">Benar</span>
                                                @else
                                                    <span class="badge bg-danger">Salah</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (auth()->user()->hasRole('guru'))
                            <div class="penilaian-section">
                                <h5>Penilaian</h5>
                                <form action="{{ route('admin.pengumpulan-tugas.update', $pengumpulanTuga->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label for="nilai">Nilai</label>
                                        <input type="number" class="form-control @error('nilai') is-invalid @enderror"
                                            id="nilai" name="nilai"
                                            value="{{ old('nilai', $pengumpulanTuga->nilai) }}" min="0"
                                            max="{{ $pengumpulanTuga->tugas->total_nilai }}" required>
                                        @error('nilai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="umpan_balik">Umpan Balik</label>
                                        <textarea class="form-control @error('umpan_balik') is-invalid @enderror" id="umpan_balik" name="umpan_balik"
                                            rows="3">{{ old('umpan_balik', $pengumpulanTuga->umpan_balik) }}</textarea>
                                        @error('umpan_balik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                                    </div>
                                </form>
                            </div>
                        @elseif(auth()->user()->hasRole('siswa'))
                            @if ($pengumpulanTuga->nilai)
                                <div class="nilai-section">
                                    <h5>Hasil Penilaian</h5>
                                    <p><strong>Nilai:</strong> {{ $pengumpulanTuga->nilai }} /
                                        {{ $pengumpulanTuga->tugas->total_nilai }}</p>
                                    @if ($pengumpulanTuga->umpan_balik)
                                        <p><strong>Umpan Balik:</strong></p>
                                        <p>{{ $pengumpulanTuga->umpan_balik }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Tugas belum dinilai
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
