@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Guru</h1>
            <span class="badge badge-primary">Tahun Ajaran: {{ $tahunAjaranAktif->nama_tahun_ajaran ?? '-' }}</span>
        </div>

        <div class="row">
            <!-- Jadwal Hari Ini -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jadwal Mengajar Hari Ini ({{ $hariIni }})
                                </div>
                                @if ($jadwalHariIni->count() > 0)
                                    <div class="mt-3">
                                        @foreach ($jadwalHariIni as $jadwal)
                                            <div class="mb-3 p-2 border-bottom">
                                                <div class="font-weight-bold">
                                                    {{ $jadwal->guruKelas->mataPelajaran->nama_pelajaran ?? 'Mata Pelajaran Tidak Ditemukan' }}
                                                </div>
                                                <div>
                                                    Kelas: {{ $jadwal->guruKelas->kelas->nama_kelas ?? '-' }}
                                                </div>
                                                <div>
                                                    Jam: {{ $jadwal->jam_mulai->format('H:i') }} -
                                                    {{ $jadwal->jam_selesai->format('H:i') }}
                                                </div>
                                                <div>
                                                    Ruangan: {{ $jadwal->ruangan ?? '-' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted mt-2">Tidak ada jadwal mengajar hari ini</div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="col-xl-6 col-md-6 mb-4">
                <!-- Jumlah Kelas Diampu -->
                <div class="card border-left-success shadow h-100 py-2 mb-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kelas Yang Diampu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $jumlahKelas }}
                                </div>
                                <div class="mt-2">
                                    <a href="" class="text-xs text-success">
                                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tugas Perlu Diperiksa -->
                <div class="card border-left-warning shadow h-100 py-2 mb-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tugas Perlu Diperiksa
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $tugasPerluDiperiksa }}
                                </div>
                                <div class="mt-2">
                                    <a href="" class="text-xs text-warning">
                                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Materi Terbaru -->
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Materi Terbaru
                                </div>
                                @if ($materiTerbaru)
                                    <div class="mt-2">
                                        <div class="font-weight-bold">{{ $materiTerbaru->judul }}</div>
                                        <div class="text-xs">
                                            Untuk: {{ $materiTerbaru->guruKelas->kelas->nama_kelas ?? '-' }}
                                        </div>
                                        <div class="text-xs text-muted">
                                            {{ $materiTerbaru->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-muted mt-2">Belum ada materi</div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas Aktif -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tugas Aktif</h6>
                    </div>
                    <div class="card-body">
                        @if ($tugasAktif->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Kelas</th>
                                            <th>Mapel</th>
                                            <th>Batas Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugasAktif as $tugas)
                                            <tr>
                                                <td>{{ $tugas->judul }}</td>
                                                <td>{{ $tugas->guruKelas->kelas->nama_kelas ?? '-' }}</td>
                                                <td>{{ $tugas->guruKelas->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                                                <td>{{ $tugas->batas_waktu->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if ($tugas->status == 'aktif')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @elseif($tugas->status == 'expired')
                                                        <span class="badge badge-danger">Expired</span>
                                                    @elseif($tugas->status == 'belum_terbit')
                                                        <span class="badge badge-warning">Belum Terbit</span>
                                                    @else
                                                        <span class="badge badge-secondary">Nonaktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">Tidak ada tugas aktif saat ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
