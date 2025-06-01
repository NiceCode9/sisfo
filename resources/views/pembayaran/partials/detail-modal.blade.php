<div class="modal-header">
    <h5 class="modal-title">Detail Pembayaran</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="text-muted mb-3">Informasi Pembayaran</h6>
            <table class="table table-borderless">
                <tr>
                    <td width="40%">Kode Pembayaran</td>
                    <td width="60%">: {{ $pembayaran->kode_pembayaran }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:
                        {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->locale('id')->isoFormat('D MMMM YYYY') }}
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:
                        @if ($pembayaran->status === 'sukses')
                            <span class="badge bg-success">Sukses</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>: {{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted mb-3">Informasi Pembayar</h6>
            <table class="table table-borderless">
                <tr>
                    <td width="40%">Nama</td>
                    <td width="60%">: {{ $pembayaran->calonSiswa->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>No Pendaftaran</td>
                    <td>: {{ $pembayaran->calonSiswa->no_pendaftaran }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h6 class="text-muted mb-3">Detail Biaya</h6>
            <table class="table table-bordered">
                <tr>
                    <th>Jenis Biaya</th>
                    <th class="text-end">Jumlah</th>
                </tr>
                <tr>
                    <td>{{ $pembayaran->biayaPendaftaran->jenis_biaya }}</td>
                    <td class="text-end">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if ($pembayaran->bukti_pembayaran_path)
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-muted mb-3">Bukti Pembayaran</h6>
                <div class="text-center">
                    @if (Str::endsWith($pembayaran->bukti_pembayaran_path, ['.jpg', '.jpeg', '.png']))
                        <img src="{{ Storage::url($pembayaran->bukti_pembayaran_path) }}" class="img-fluid"
                            style="max-height: 300px;" alt="Bukti Pembayaran">
                    @else
                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran_path) }}" class="btn btn-sm btn-primary"
                            target="_blank">
                            Lihat Bukti Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($pembayaran->catatan)
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-muted mb-2">Catatan</h6>
                <p class="mb-0">{{ $pembayaran->catatan }}</p>
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
