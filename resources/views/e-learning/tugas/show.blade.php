@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Tugas</h3>
                        <div class="card-tools d-flex justify-content-end">
                            @if (auth()->user()->hasRole('guru') && $tuga->guruKelas->guruMataPelajaran->guru->user->id === auth()->id())
                                <a href="{{ route('tugas.edit', $tuga->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit Tugas
                                </a>
                                @if ($tuga->metode_pengerjaan === 'online')
                                    <a href="{{ route('soal.create', ['tugas' => $tuga->id]) }}"
                                        class="btn btn-primary btn-sm me-2">
                                        <i class="fas fa-plus"></i> Tambah Soal
                                    </a>
                                @endif
                            @endif
                            <a href="{{ route('tugas.index') }}" class="btn btn-gray-200 btn-sm me-2">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tugas
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Informasi Tugas</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Mata Pelajaran</th>
                                        <td>{{ $tuga->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Guru</th>
                                        <td>{{ $tuga->guruKelas->guruMataPelajaran->guru->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Judul</th>
                                        <td>{{ $tuga->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $tuga->deskripsi }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Detail Pengerjaan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Jenis</th>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst(str_replace('_', ' ', $tuga->jenis)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pengerjaan</th>
                                        <td>
                                            <span
                                                class="badge {{ $tuga->metode_pengerjaan === 'online' ? 'bg-primary' : 'bg-success' }}">
                                                {{ ucfirst(str_replace('_', ' ', $tuga->metode_pengerjaan)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Batas Waktu</th>
                                        <td>
                                            {{ $tuga->batas_waktu->format('d M Y H:i') }}
                                            @if ($tuga->batas_waktu->isPast())
                                                <span class="badge bg-danger">Berakhir</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Nilai</th>
                                        <td>{{ $tuga->total_nilai }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($tuga->metode_pengerjaan === 'upload_file' && $tuga->file_tugas)
                            <div class="mb-3">
                                <h5>File Tugas</h5>
                                <a href="{{ Storage::url($tuga->file_tugas) }}" class="btn btn-info" target="_blank">
                                    <i class="fas fa-download"></i> Download File Tugas
                                </a>
                            </div>
                        @endif

                        @if ($tuga->metode_pengerjaan === 'online')
                            <div class="soal-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Daftar Soal</h5>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Jenis Soal</th>
                                                <th>Pertanyaan</th>
                                                <th width="10%">Poin</th>
                                                @if (auth()->user()->hasRole('guru'))
                                                    <th width="15%">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($tuga->soal()->orderBy('urutan')->get() as $soal)
                                                <tr>
                                                    <td>{{ $soal->urutan }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $soal->jenis_soal === 'pilihan_ganda' ? 'bg-info' : 'bg-primary' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $soal->jenis_soal)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ Str::limit($soal->pertanyaan, 100) }}</td>
                                                    <td>{{ $soal->poin }}</td>
                                                    @if (auth()->user()->hasRole('guru'))
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('soal.show', $soal->id) }}"
                                                                    class="btn btn-sm btn-info" title="Detail">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('soal.edit', $soal->id) }}"
                                                                    class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="confirmDelete('{{ $soal->id }}')"
                                                                    title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada soal</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->hasRole('siswa'))
                            <div class="mt-3">
                                @if (!$tuga->pengumpulanTugas()->where('siswa_id', auth()->user()->siswa->id)->exists())
                                    @if (!$tuga->batas_waktu->isPast())
                                        <a href="{{ route('pengumpulan-tugas.create', ['tugas' => $tuga->id]) }}"
                                            class="btn btn-success text-white">
                                            <i class="fas fa-upload"></i> Kumpulkan Tugas
                                        </a>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Batas waktu pengumpulan tugas telah
                                            berakhir
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i> Anda sudah mengumpulkan tugas ini
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
