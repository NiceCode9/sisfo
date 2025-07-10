@extends('layouts.app')

@section('title', 'Riwayat Kelas Sebelumnaya')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Kelas</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatKelas as $rk)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rk->kelas->nama_kelas }}</td>
                                            <td>{{ $rk->tahunAjaran->nama_tahun_ajaran }}</td>
                                            <td>
                                                @if ($rk->status == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
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
    </div>
@endsection
