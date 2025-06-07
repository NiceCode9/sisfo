@extends('layouts.app')

@section('title', 'Daftar Soal')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Soal - {{ $tugas->judul }}</h3>
                        @if (auth()->user()->hasRole('guru'))
                            <div class="card-tools">
                                <a href="{{ route('admin.soal.create', ['tugas' => $tugas->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Soal
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Jenis Soal</th>
                                        <th>Pertanyaan</th>
                                        <th width="10%">Poin</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tugas->soal()->orderBy('urutan')->get() as $soal)
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
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.soal.show', $soal->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (auth()->user()->hasRole('guru'))
                                                        <a href="{{ route('admin.soal.edit', $soal->id) }}"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="confirmDelete('{{ $soal->id }}')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                @if (auth()->user()->hasRole('guru'))
                                                    <form id="delete-form-{{ $soal->id }}"
                                                        action="{{ route('admin.soal.destroy', $soal->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
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
