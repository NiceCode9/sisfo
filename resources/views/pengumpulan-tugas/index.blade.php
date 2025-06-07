@extends('layouts.app')

@section('title', 'Daftar Pengumpulan Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pengumpulan Tugas</h3>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->hasRole('siswa'))
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $pengumpulan->where('nilai', '!=', null)->count() }}</h3>
                                            <p>Sudah Dinilai</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $pengumpulan->where('nilai', null)->count() }}</h3>
                                            <p>Menunggu Penilaian</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (auth()->user()->hasRole('guru'))
                                            <th>Siswa</th>
                                        @endif
                                        <th>Tugas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Waktu Pengumpulan</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengumpulan as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if (auth()->user()->hasRole('guru'))
                                                <td>{{ $p->siswa->nama }}</td>
                                            @endif
                                            <td>{{ $p->tugas->judul }}</td>
                                            <td>{{ $p->tugas->guruMataPelajaran->mataPelajaran->nama }}</td>
                                            <td>
                                                {{ $p->waktu_pengumpulan->format('d M Y H:i') }}
                                                @if ($p->waktu_pengumpulan > $p->tugas->batas_waktu)
                                                    <span class="badge bg-warning">Terlambat</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->nilai)
                                                    <span class="badge bg-success">Sudah Dinilai</span>
                                                @else
                                                    <span class="badge bg-warning">Menunggu Penilaian</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->nilai)
                                                    {{ $p->nilai }}/{{ $p->tugas->total_nilai }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.pengumpulan-tugas.show', $p->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (auth()->user()->hasRole('siswa') && !$p->nilai)
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="confirmDelete('{{ $p->id }}')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                @if (auth()->user()->hasRole('siswa') && !$p->nilai)
                                                    <form id="delete-form-{{ $p->id }}"
                                                        action="{{ route('admin.pengumpulan-tugas.destroy', $p->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data pengumpulan tugas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $pengumpulan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengumpulan tugas ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
