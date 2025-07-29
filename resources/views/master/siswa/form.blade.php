@extends('layouts.app')

@section('title', isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa')

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
                    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                    <li class="breadcrumb-item active">{{ isset($siswa) ? 'Edit' : 'Tambah' }} Siswa</li>
                </ol>
            </nav>
            <h2 class="h4">Manajemen Data Siswa</h2>
            <p class="mb-0">{{ isset($siswa) ? 'Form Edit Data Siswa' : 'Form Tambah Data Siswa Baru' }}</p>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i> {{ isset($siswa) ? 'Edit' : 'Tambah' }} Data Siswa
            </h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($siswa) ? route('siswa.update', $siswa->id) : route('siswa.store') }}" method="POST">
                @csrf
                @if (isset($siswa))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    <!-- Student Identity Section -->
                    <div class="col-12">
                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="mb-3 text-primary"><i class="fas fa-id-card me-2"></i> Identitas Siswa</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" maxlength="16" minlength="16"
                                        placeholder="Masukkan 16 digit NIK"
                                        value="{{ old('nik', isset($siswa) ? $siswa->calonSiswa->nik : '') }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn" maxlength="10" minlength="10"
                                        placeholder="Masukkan 10 digit NISN"
                                        value="{{ old('nisn', isset($siswa) ? $siswa->nisn : '') }}" required>
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                                    <input type="text" name="nis"
                                        class="form-control @error('nis') is-invalid @enderror" id="nis"
                                        maxlength="8" minlength="8" placeholder="Masukkan 8 digit NIS"
                                        value="{{ old('nis', isset($siswa) ? $siswa->nis : '') }}" required>
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="col-12">
                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="mb-3 text-primary"><i class="fas fa-user me-2"></i> Data Pribadi</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap Siswa"
                                        value="{{ old('nama_lengkap', isset($siswa) ? $siswa->calonSiswa->nama_lengkap : '') }}"
                                        required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="L"
                                            {{ old('jenis_kelamin', isset($siswa) ? $siswa->calonSiswa->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P"
                                            {{ old('jenis_kelamin', isset($siswa) ? $siswa->calonSiswa->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir"
                                        value="{{ old('tempat_lahir', isset($siswa) ? $siswa->calonSiswa->tempat_lahir : '') }}"
                                        required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', isset($siswa) ? $siswa->calonSiswa->tanggal_lahir : '') }}"
                                        required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="agama" class="form-label">Agama <span
                                            class="text-danger">*</span></label>
                                    <select name="agama" id="agama"
                                        class="form-select @error('agama') is-invalid @enderror" required>
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option value="Islam"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="Kristen"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katolik"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="Hindu"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Buddha"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Buddha' ? 'selected' : '' }}>
                                            Buddha</option>
                                        <option value="Konghucu"
                                            {{ old('agama', isset($siswa) ? $siswa->calonSiswa->agama : '') == 'Konghucu' ? 'selected' : '' }}>
                                            Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span
                                            class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                        required>{{ old('alamat', isset($siswa) ? $siswa->calonSiswa->alamat : '') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="col-12">
                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="mb-3 text-primary"><i class="fas fa-address-book me-2"></i> Kontak & Pendidikan
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">Nomor HP/Whatsapp</label>
                                    <input type="tel" class="form-control @error('no_hp') is-invalid @enderror"
                                        id="no_hp" name="no_hp" placeholder="Masukkan Nomor Telephone Siswa"
                                        value="{{ old('no_hp', isset($siswa) ? $siswa->calonSiswa->no_hp : '') }}">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email Siswa"
                                        value="{{ old('email', isset($siswa) ? $siswa->calonSiswa->email : '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                    <input type="text"
                                        class="form-control @error('asal_sekolah') is-invalid @enderror"
                                        id="asal_sekolah" name="asal_sekolah" placeholder="Masukkan Asal Sekolah"
                                        value="{{ old('asal_sekolah', isset($siswa) ? $siswa->calonSiswa->asal_sekolah : '') }}">
                                    @error('asal_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="kelas_id" class="form-label">Kelas Saat Ini</label>
                                    <select name="kelas_id" id="kelas_id"
                                        class="form-select @error('kelas_id') is-invalid @enderror">
                                        <option value="" selected>Pilih Kelas</option>
                                        @foreach ($kelas as $kelasItem)
                                            <option value="{{ $kelasItem->id }}"
                                                {{ old('kelas_id', isset($siswa) ? $siswa->kelasAktif()->kelas_id : '') == $kelasItem->id ? 'selected' : '' }}>
                                                {{ $kelasItem->tingkat . '' . $kelasItem->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information Section -->
                    <div class="col-12">
                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="mb-3 text-primary"><i class="fas fa-users me-2"></i> Data Orang Tua</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                        id="nama_ayah" name="nama_ayah" placeholder="Masukkan Nama Ayah"
                                        value="{{ old('nama_ayah', isset($siswa) ? $siswa->calonSiswa->nama_ayah : '') }}">
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                                        id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Masukkan Pekerjaan Ayah"
                                        value="{{ old('pekerjaan_ayah', isset($siswa) ? $siswa->calonSiswa->pekerjaan_ayah : '') }}">
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                        id="nama_ibu" name="nama_ibu" placeholder="Masukkan Nama Ibu"
                                        value="{{ old('nama_ibu', isset($siswa) ? $siswa->calonSiswa->nama_ibu : '') }}">
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                                        id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Masukkan Pekerjaan Ibu"
                                        value="{{ old('pekerjaan_ibu', isset($siswa) ? $siswa->calonSiswa->pekerjaan_ibu : '') }}">
                                    @error('pekerjaan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="no_hp_orang_tua" class="form-label">Nomor HP Orang Tua</label>
                                    <input type="tel"
                                        class="form-control @error('no_hp_orang_tua') is-invalid @enderror"
                                        id="no_hp_orang_tua" name="no_hp_orang_tua"
                                        placeholder="Masukkan Nomor HP Orang Tua"
                                        value="{{ old('no_hp_orang_tua', isset($siswa) ? $siswa->calonSiswa->no_hp_orang_tua : '') }}">
                                    @error('no_hp_orang_tua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> {{ isset($siswa) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Format NIK input
        document.getElementById('nik').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format NISN input
        document.getElementById('nisn').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format NIS input
        document.getElementById('nis').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format phone numbers
        document.getElementById('no_hp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('no_hp_orang_tua').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endpush
