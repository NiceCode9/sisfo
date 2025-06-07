@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Tugas</h3>
                        @if (auth()->user()->hasRole('guru'))
                            <div class="card-tools">
                                <a href="{{ route('admin.tugas.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Tugas Baru
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Metode Pengerjaan</th>
                                        <th>Batas Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tugas as $t)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->guruMataPelajaran->mataPelajaran->nama }}</td>
                                            <td>{{ $t->judul }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ucfirst(str_replace('_', ' ', $t->jenis)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $t->metode_pengerjaan === 'online' ? 'bg-primary' : 'bg-success' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $t->metode_pengerjaan)) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $t->batas_waktu->format('d M Y H:i') }}
                                                @if ($t->batas_waktu->isPast())
                                                    <span class="badge bg-danger">Berakhir</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $status = 'Belum Dikumpulkan';
                                                    $statusClass = 'bg-warning';

                                                    if (auth()->user()->hasRole('siswa')) {
                                                        $pengumpulan = $t
                                                            ->pengumpulanTugas()
                                                            ->where('siswa_id', auth()->user()->siswa->id)
                                                            ->first();

                                                        if ($pengumpulan) {
                                                            $status = $pengumpulan->nilai
                                                                ? 'Sudah Dinilai'
                                                                : 'Menunggu Penilaian';
                                                            $statusClass = $pengumpulan->nilai
                                                                ? 'bg-success'
                                                                : 'bg-info';
                                                        }
                                                    } else {
                                                        $total = $t->pengumpulanTugas->count();
                                                        $dinilai = $t->pengumpulanTugas->whereNotNull('nilai')->count();
                                                        $status = "$dinilai / $total Dinilai";
                                                        $statusClass = $total === $dinilai ? 'bg-success' : 'bg-info';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.tugas.show', $t->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (auth()->user()->hasRole('guru') && $t->guruMataPelajaran->guru->user_id === auth()->id())
                                                        <a href="{{ route('admin.tugas.edit', $t->id) }}"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="confirmDelete('{{ $t->id }}')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @elseif(auth()->user()->hasRole('siswa') && !$t->batas_waktu->isPast())
                                                        @if (!$t->pengumpulanTugas()->where('siswa_id', auth()->user()->siswa->id)->exists())
                                                            <a href="{{ route('admin.pengumpulan-tugas.create', ['tugas' => $t->id]) }}"
                                                                class="btn btn-sm btn-success" title="Kumpulkan">
                                                                <i class="fas fa-upload"></i> Kumpulkan
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>

                                                @if (auth()->user()->hasRole('guru') && $t->guruMataPelajaran->guru->user_id === auth()->id())
                                                    <form id="delete-form-{{ $t->id }}"
                                                        action="{{ route('admin.tugas.destroy', $t->id) }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada tugas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $tugas->links() }}
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
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
