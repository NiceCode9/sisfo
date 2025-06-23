@extends('layouts.app')

@section('title', 'Form Biaya Pendaftaran')

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
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('biaya-pendaftaran.index') }}">Biaya
                            Pendaftaran</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
                </ol>
            </nav>
            <h2 class="h4">Tambah Biaya Pendaftaran</h2>
            {{-- <p class="mb-0">Your web analytics dashboard template.</p> --}}
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('biaya-pendaftaran.index') }}"
                class="btn btn-sm btn-gray-500 d-inline-flex align-items-center">
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ isset($biaya) ? 'Edit Biaya Pendaftaran' : 'Tambah Biaya Pendaftaran Baru' }}
            </h6>
        </div>
        <div class="card-body">
            <form
                action="{{ isset($biaya) ? route('biaya-pendaftaran.update', $biaya->id) : route('biaya-pendaftaran.store') }}"
                method="POST">
                @csrf
                @if (isset($biaya))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunAjarans as $tahunAjaran)
                            <option value="{{ $tahunAjaran->id }}"
                                {{ isset($biaya) && $biaya->tahun_ajaran_id == $tahunAjaran->id ? 'selected' : '' }}>
                                {{ $tahunAjaran->nama_tahun_ajaran }}</option>
                        @endforeach
                    </select>
                    @error('tahun_ajaran_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jenis_biaya" class="form-label">Jenis Biaya</label>
                    <input type="text" class="form-control @error('jenis_biaya') is-invalid @enderror" id="jenis_biaya"
                        name="jenis_biaya" value="{{ old('jenis_biaya', $biaya->jenis_biaya ?? '') }}" required>
                    @error('jenis_biaya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                        name="jumlah" value="{{ old('jumlah', $biaya->jumlah ?? '') }}" required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Wajib Bayar</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="wajib_bayar" id="wajib_bayar_ya" value="1"
                            {{ isset($biaya) && $biaya->wajib_bayar ? 'checked' : '' }} required>
                        <label class="form-check-label" for="wajib_bayar_ya">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="wajib_bayar" id="wajib_bayar_tidak"
                            value="0" {{ isset($biaya) && !$biaya->wajib_bayar ? 'checked' : '' }} required>
                        <label class="form-check-label" for="wajib_bayar_tidak">Tidak</label>
                    </div>
                    @error('wajib_bayar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                        rows="3">{{ old('keterangan', $biaya->keterangan ?? '') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-{{ isset($biaya) ? 'warning' : 'primary    ' }} btn-block">
                    {{ isset($biaya) ? 'Update Biaya Pendaftaran' : 'Tambah Biaya Pendaftaran' }}
                </button>
            </form>
        </div>
    </div>

@endsection
