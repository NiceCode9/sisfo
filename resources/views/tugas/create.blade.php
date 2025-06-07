@extends('layouts.app')

@section('title', 'Buat Tugas Baru')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buat Tugas Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tugas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="guru_mata_pelajaran_id">Mata Pelajaran</label>
                                <select class="form-control @error('guru_mata_pelajaran_id') is-invalid @enderror"
                                    id="guru_mata_pelajaran_id" name="guru_mata_pelajaran_id" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($guruMapel as $gmp)
                                        <option value="{{ $gmp->id }}">{{ $gmp->mataPelajaran->nama }}</option>
                                    @endforeach
                                </select>
                                @error('guru_mata_pelajaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="judul">Judul Tugas</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi Tugas</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="batas_waktu">Batas Waktu Pengumpulan</label>
                                <input type="datetime-local" class="form-control @error('batas_waktu') is-invalid @enderror"
                                    id="batas_waktu" name="batas_waktu" value="{{ old('batas_waktu') }}" required>
                                @error('batas_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="total_nilai">Total Nilai</label>
                                <input type="number" class="form-control @error('total_nilai') is-invalid @enderror"
                                    id="total_nilai" name="total_nilai" value="{{ old('total_nilai', 100) }}" required>
                                @error('total_nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="metode_pengerjaan">Metode Pengerjaan</label>
                                <select class="form-control @error('metode_pengerjaan') is-invalid @enderror"
                                    id="metode_pengerjaan" name="metode_pengerjaan" required>
                                    <option value="online">Pengerjaan Online</option>
                                    <option value="upload_file">Upload File</option>
                                </select>
                                @error('metode_pengerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="jenis_soal_container">
                                <label for="jenis">Jenis Soal</label>
                                <select class="form-control @error('jenis') is-invalid @enderror" id="jenis"
                                    name="jenis" required>
                                    <option value="uraian">Uraian</option>
                                    <option value="pilihan_ganda">Pilihan Ganda</option>
                                    <option value="campuran">Campuran</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="file_tugas_container" style="display: none;">
                                <label for="file_tugas">File Tugas</label>
                                <input type="file" class="form-control @error('file_tugas') is-invalid @enderror"
                                    id="file_tugas" name="file_tugas">
                                @error('file_tugas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format yang diizinkan: PDF, DOC, DOCX. Maksimal 2MB</small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.tugas.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function toggleFormElements() {
                const metodePengerjaan = $('#metode_pengerjaan').val();
                if (metodePengerjaan === 'online') {
                    $('#jenis_soal_container').show();
                    $('#file_tugas_container').hide();
                    $('#file_tugas').prop('required', false);
                    $('#jenis').prop('required', true);
                } else {
                    $('#jenis_soal_container').hide();
                    $('#file_tugas_container').show();
                    $('#file_tugas').prop('required', true);
                    $('#jenis').prop('required', false);
                }
            }

            $('#metode_pengerjaan').change(toggleFormElements);
            toggleFormElements();
        });
    </script>
@endpush
