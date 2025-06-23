@extends('layouts.app')

@section('title', 'Data Pendaftaran')

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
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
            <h2 class="h4">Data Pendaftaran</h2>
            {{-- <p class="mb-0">Data Pendaftaran</p> --}}
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <form action="{{ route('calon-siswa.index') }}" method="GET" class="row">
                <div class="col-md-4">
                    <div class="input-group me-2 me-lg-3">
                        <span class="input-group-text">
                            <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan nama, NIK, NISN..." aria-label="Search">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="tahun_ajaran_id" onchange="this.form.submit()">
                        @foreach ($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}"
                                {{ request('tahun_ajaran_id', $tahunAjaranId) == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama_tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                {{-- <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                </div> --}}
            </form>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Role</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>NoMor Pendaftaran</th>
                            <th>NIK</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Status</th>
                            <th>Profile</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calonSiswa as $casis)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $casis->no_pendaftaran }}</td>
                                <td>{{ $casis->nik }}</td>
                                <td>{{ $casis->nisn }}</td>
                                <td>{{ $casis->nama_lengkap }}</td>
                                <td>{{ $casis->jenis_kelamin }}</td>
                                <td>{{ $casis->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($casis->tanggal_lahir)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($casis->status_pendaftaran == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($casis->status_pendaftaran == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($casis->status_pendaftaran == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('calon-siswa.show', $casis->id) }}"
                                        class="btn btn-primary btn-sm">Detail</a></td>
                                {{-- <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('calon-siswa.edit', $casis->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('calon-siswa.destroy', $casis->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
