@extends('layouts.app')
@section('title', 'Biaya Pendaftaran')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Biaya Pendaftaran</li>
                </ol>
            </nav>
            <h2 class="h4">Management Biaya Pendaftaran</h2>
            <p class="mb-0">Data Biaya Pendaftaran</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.biaya-pendaftaran.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Biaya Pendaftaran
            </a>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Biaya Pendaftaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dataTable display responsive nowrap" id="biayaPendaftaranTable"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Jenis Biaya</th>
                            <th>Jumlah</th>
                            <th>Wajib Bayar</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biayaPendaftarans as $b)
                            <tr>
                                <td>{{ $b->tahunAjaran->nama_tahun_ajaran }}</td>
                                <td>{{ $b->jenis_biaya }}</td>
                                <td>Rp. {{ number_format($b->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if ($b->wajib_bayar)
                                        <span class="badge bg-success">Ya</span>
                                    @else
                                        <span class="badge bg-warning">Tidak</span>
                                    @endif
                                </td>
                                <td>{{ $b->keterangan }}</td>
                                <td>
                                    {{-- <div class="btn-group" role="group" aria-label="Basic example"> --}}
                                    <a href="{{ route('admin.biaya-pendaftaran.edit', $b->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.biaya-pendaftaran.destroy', $b->id) }}" class="d-inline"
                                        method="POST" data-biaya-name="{{ $b->jenis_biaya }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                    </form>
                                    {{-- </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle delete confirmation
            $('.btn-delete').on('click', function() {
                const form = $(this).closest('form');
                const jalurName = form.data('biaya-name');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus biaya pendaftaran "${jalurName}"`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
