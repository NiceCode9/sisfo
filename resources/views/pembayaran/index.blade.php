@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                </ol>
            </nav>
            <h2 class="h4">Data Pembayaran</h2>
            {{-- <p class="mb-0">Data Pendaftaran</p> --}}
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <form action="{{ route('pembayaran.index') }}" method="GET" class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan kode atau nama" aria-label="Search">
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Dari</span>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Sampai</span>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                @if (request('search') || request('start_date') || request('end_date'))
                    <div class="col-12">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-link btn-sm ps-0">
                            <svg class="icon icon-xs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover display nowrap table-align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Kode Pembayaran</th>
                            <th scope="col">Nama Calon Siswa</th>
                            <th scope="col">Peruntukan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->kode_pembayaran }}</td>
                                <td>{{ $pembayaran->calonSiswa->nama_lengkap }}</td>
                                <td>{{ $pembayaran->biayaPendaftaran->jenis_biaya }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if ($pembayaran->status === 'sukses')
                                        <span class="badge bg-success">Sukses</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-detail"
                                        data-id="{{ $pembayaran->id }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($pembayarans->count() > 0)
            <div class="card-footer d-flex justify-content-between align-items-center">
                {{ $pembayarans->links() }}
            </div>
        @else
            <div class="card-footer text-center">
                Tidak ada data pembayaran yang ditemukan.
            </div>
        @endif
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Content will be loaded here -->
                <div class="modal-body">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalContent = document.querySelector('#detailModal .modal-content');

            document.querySelectorAll('.btn-detail').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    let url = '{{ route('pembayaran.show', ':id') }}'.replace(':id', id);

                    // Show loading state
                    modalContent.innerHTML = `
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    `;

                    modal.show();

                    // Fetch detail data
                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                modalContent.innerHTML = data.html;
                            } else {
                                modalContent.innerHTML = `
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                Gagal memuat data. Silakan coba lagi.
                            </div>
                        </div>
                    `;
                            }
                        })
                        .catch(error => {
                            modalContent.innerHTML = `
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            Terjadi kesalahan. Silakan coba lagi.
                        </div>
                    </div>
                `;
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endpush
