@extends('layouts.app')

@section('title', 'Detail Soal')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Soal</h3>
                        @if (auth()->user()->hasRole('guru'))
                            <div class="card-tools">
                                <a href="{{ route('soal.edit', $soal->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Soal
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="alert alert-info">
                                    <h5><i class="fas fa-info-circle"></i> Informasi Tugas</h5>
                                    <p class="mb-0">
                                        <strong>Judul Tugas:</strong> {{ $soal->tugas->judul }} <br>
                                        <strong>Mata Pelajaran:</strong>
                                        {{ $soal->tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}
                                        <br>
                                        <strong>Guru:</strong>
                                        {{ $soal->tugas->guruKelas->guruMataPelajaran->guru->user->name }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3">Detail Soal</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Urutan</th>
                                        <td>{{ $soal->urutan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Soal</th>
                                        <td>
                                            <span
                                                class="badge {{ $soal->jenis_soal === 'pilihan_ganda' ? 'bg-info' : 'bg-primary' }}">
                                                {{ ucfirst(str_replace('_', ' ', $soal->jenis_soal)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Poin</th>
                                        <td>{{ $soal->poin }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pertanyaan</h5>
                                    </div>
                                    <div class="card-body">
                                        {{ $soal->pertanyaan }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($soal->jenis_soal === 'pilihan_ganda')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Pilihan Jawaban</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Jawaban</th>
                                                            <th width="15%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($soal->jawaban as $jawaban)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $jawaban->teks_jawaban }}</td>
                                                                <td>
                                                                    @if ($jawaban->jawaban_benar)
                                                                        <span class="badge bg-success">Benar</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Salah</span>
                                                                    @endif
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
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('tugas.show', $soal->tugas_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Detail Tugas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
