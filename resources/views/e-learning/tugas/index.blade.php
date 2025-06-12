@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Daftar Tugas</h3>
                        @if (auth()->user()->hasRole('guru'))
                            <div>
                                <a href="{{ route('admin.tugas.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Tugas Baru
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun_ajaran_id">Tahun Ajaran</label>
                                    <select class="form-control select2" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                        <option value="">Semua Tahun Ajaran</option>
                                        @foreach ($tahunAjaran as $ta)
                                            <option value="{{ $ta->id }}">
                                                {{ \Carbon\Carbon::parse($ta->tanggal_mulai)->translatedFormat('d F Y') }} /
                                                {{ \Carbon\Carbon::parse($ta->tanggal_selesai)->translatedFormat('d F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select class="form-control select2" id="kelas_id" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                    <select class="form-control select2" id="mata_pelajaran_id" name="mata_pelajaran_id">
                                        <option value="">Semua Mata Pelajaran</option>
                                        @foreach ($mataPelajaran as $mp)
                                            <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="tugas-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        @if (auth()->user()->hasRole('superadmin'))
                                            <th>Guru</th>
                                        @endif
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Metode Pengerjaan</th>
                                        <th>Batas Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($tugas ?? [] as $t)
        <form id="delete-form-{{ $t->id }}" action="{{ route('admin.tugas.destroy', $t->id) }}" method="POST"
            class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#tugas-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('admin.tugas.index') }}",
                    data: function(d) {
                        d.tahun_ajaran_id = $('#tahun_ajaran_id').val();
                        d.kelas_id = $('#kelas_id').val();
                        d.mata_pelajaran_id = $('#mata_pelajaran_id').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mata_pelajaran',
                        name: 'guruKelas.guruMataPelajaran.mataPelajaran.nama_pelajaran'
                    },
                    {
                        data: 'kelas',
                        name: 'guruKelas.kelas.nama_kelas'
                    },
                    @if (auth()->user()->hasRole('superadmin'))
                        {
                            data: 'guru',
                            name: 'guruKelas.guruMataPelajaran.guru.user.name'
                        },
                    @endif {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'metode_pengerjaan',
                        name: 'metode_pengerjaan'
                    },
                    {
                        data: 'batas_waktu',
                        name: 'batas_waktu'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [7, 'desc']
                ]
            });

            $('#tahun_ajaran_id, #kelas_id, #mata_pelajaran_id').change(function() {
                table.draw();
            });
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
