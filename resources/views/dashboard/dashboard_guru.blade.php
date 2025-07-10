@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    <div class="container-fluid">
        <h2 class="mb-4">Selamat Datang, Guru!</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Mengajar Hari Ini</h5>
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
                        <h5 class="card-title">Jumlah Kelas Diampu</h5>
                        <p class="card-text">{{ $jumlahKelas ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tugas Perlu Diperiksa</h5>
                        <p class="card-text">{{ $tugasPerluDiperiksa ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
