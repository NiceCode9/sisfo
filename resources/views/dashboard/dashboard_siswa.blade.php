@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    <div class="container-fluid">
        <h2 class="mb-4">Selamat Datang, Siswa!</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Hari Ini</h5>
                        <ul class="list-group list-group-flush">
                            @forelse($jadwalHariIni ?? [] as $jadwal)
                                <li class="list-group-item">{{ $jadwal }}</li>
                            @empty
                                <li class="list-group-item">Tidak ada jadwal</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Status Pembayaran</h5>
                        <p class="card-text">{{ $statusPembayaran ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pengumuman Terbaru</h5>
                        <ul class="list-group list-group-flush">
                            @forelse($pengumumanTerbaru ?? [] as $pengumuman)
                                <li class="list-group-item">{{ $pengumuman }}</li>
                            @empty
                                <li class="list-group-item">Tidak ada pengumuman</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
