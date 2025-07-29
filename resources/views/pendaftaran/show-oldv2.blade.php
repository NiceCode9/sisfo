@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')
    <!-- Header Section with Gradient Background -->
    <div class="bg-gradient-primary text-white py-4 mb-4 rounded-3">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('calon-siswa.index') }}" class="text-white-50 text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('calon-siswa.index') }}" class="text-white-50 text-decoration-none">
                                    Data Pendaftaran
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Detail Pendaftaran</li>
                        </ol>
                    </nav>
                    <h2 class="h3 mb-0 fw-bold">
                        <i class="fas fa-user-graduate me-2"></i>Detail Pendaftaran
                    </h2>
                    <p class="mb-0 opacity-75">{{ $calonSiswa->nama_lengkap }} - {{ $calonSiswa->no_pendaftaran }}</p>
                </div>
                <div class="text-end">
                    <span
                        class="badge fs-6 px-3 py-2 {{ $calonSiswa->status_pendaftaran === 'diterima' ? 'bg-success' : ($calonSiswa->status_pendaftaran === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                        <i
                            class="fas {{ $calonSiswa->status_pendaftaran === 'diterima' ? 'fa-check-circle' : ($calonSiswa->status_pendaftaran === 'ditolak' ? 'fa-times-circle' : 'fa-clock') }} me-1"></i>
                        {{ ucfirst($calonSiswa->status_pendaftaran) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle text-danger me-2 fs-5 mt-1"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <!-- Data Pendaftar Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user me-2"></i>Data Pendaftar
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light btn-sm">
                            <i class="fas fa-print me-1"></i>Print
                        </button>
                        <button type="button" class="btn btn-light btn-sm">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">No. Pendaftaran</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->no_pendaftaran }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">NIK</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->nik }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">NISN</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->nisn }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                                    <div class="fw-bold text-dark fs-5">{{ $calonSiswa->nama_lengkap }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Jenis Kelamin</label>
                                    <div class="fw-bold text-dark">
                                        <i
                                            class="fas {{ $calonSiswa->jenis_kelamin === 'L' ? 'fa-mars text-primary' : 'fa-venus text-danger' }} me-1"></i>
                                        {{ $calonSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Tempat, Tanggal Lahir</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-calendar-alt text-info me-1"></i>
                                        {{ $calonSiswa->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="info-item">
                                    <label class="form-label text-muted small fw-semibold">Agama</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->agama }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-map-marker-alt me-2"></i>Kontak & Pendidikan
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Alamat</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->alamat }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">No. HP</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-phone text-success me-1"></i>
                                        <a href="tel:{{ $calonSiswa->no_hp }}"
                                            class="text-decoration-none">{{ $calonSiswa->no_hp }}</a>
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Email</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-envelope text-info me-1"></i>
                                        <a href="mailto:{{ $calonSiswa->email }}"
                                            class="text-decoration-none">{{ $calonSiswa->email }}</a>
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Asal Sekolah</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-school text-warning me-1"></i>
                                        {{ $calonSiswa->asal_sekolah }}
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Tahun Ajaran</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->tahunAjaran->nama_tahun_ajaran }}</div>
                                </div>
                                <div class="info-item">
                                    <label class="form-label text-muted small fw-semibold">Jalur Pendaftaran</label>
                                    <div class="fw-bold text-dark">
                                        @if ($calonSiswa->jalurPendaftaran)
                                            {{ $calonSiswa->jalurPendaftaran->nama_jalur }}
                                            <span
                                                class="badge {{ $calonSiswa->jalurPendaftaran->aktif ? 'bg-success' : 'bg-danger' }} ms-2">
                                                {{ $calonSiswa->jalurPendaftaran->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-users me-2"></i>Data Orang Tua
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="parent-info p-3 bg-light rounded-3">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-user-tie me-2"></i>Data Ayah
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Nama Ayah</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->nama_ayah }}</div>
                                </div>
                                <div class="info-item">
                                    <label class="form-label text-muted small fw-semibold">Pekerjaan</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-briefcase text-primary me-1"></i>
                                        {{ $calonSiswa->pekerjaan_ayah }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="parent-info p-3 bg-light rounded-3">
                                <h6 class="text-danger fw-bold mb-3">
                                    <i class="fas fa-user me-2"></i>Data Ibu
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Nama Ibu</label>
                                    <div class="fw-bold text-dark">{{ $calonSiswa->nama_ibu }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted small fw-semibold">Pekerjaan</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-briefcase text-danger me-1"></i>
                                        {{ $calonSiswa->pekerjaan_ibu }}
                                    </div>
                                </div>
                                <div class="info-item">
                                    <label class="form-label text-muted small fw-semibold">No. HP Orang Tua</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-phone text-success me-1"></i>
                                        <a href="tel:{{ $calonSiswa->no_hp_orang_tua }}"
                                            class="text-decoration-none">{{ $calonSiswa->no_hp_orang_tua }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <!-- Berkas Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-folder-open me-2"></i>Berkas Pendaftaran
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if ($calonSiswa->berkasCalonSiswa)
                        <div class="list-group list-group-flush">
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->foto_path) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-camera text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Pas Foto</div>
                                        <small class="text-muted">Foto 3x4</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat
                                </span>
                            </a>
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->ijazah_path) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-certificate text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Ijazah</div>
                                        <small class="text-muted">Ijazah/STTB</small>
                                    </div>
                                </div>
                                <span class="badge bg-success rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat
                                </span>
                            </a>
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->kk_path) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Kartu Keluarga</div>
                                        <small class="text-muted">KK Asli</small>
                                    </div>
                                </div>
                                <span class="badge bg-warning rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat
                                </span>
                            </a>
                            @if ($calonSiswa->berkasCalonSiswa->akta_path)
                                <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->akta_path) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Akta Kelahiran</div>
                                            <small class="text-muted">Akta Asli</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-info rounded-pill">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </span>
                                </a>
                            @endif
                            @if ($calonSiswa->berkasCalonSiswa->skl_path)
                                <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->skl_path) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-sm bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-graduation-cap text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Surat Keterangan Lulus</div>
                                            <small class="text-muted">SKL Asli</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary rounded-pill">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </span>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-folder-open text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada berkas yang diupload</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Pembayaran Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-history me-2"></i>Riwayat Pembayaran
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if ($calonSiswa->pembayaran->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Jenis</th>
                                        <th class="px-4 py-3">Jumlah</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calonSiswa->pembayaran as $pembayaran)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="fw-semibold">
                                                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') }}
                                                </div>
                                                <small class="text-muted">{{ $pembayaran->kode_pembayaran }}</small>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="fw-semibold">{{ $pembayaran->biayaPendaftaran->jenis_biaya }}
                                                </div>
                                                <small
                                                    class="text-muted">{{ ucfirst($pembayaran->jenis_pembayaran) }}</small>
                                                @if ($pembayaran->keterangan_angsuran)
                                                    <div class="text-muted small">{{ $pembayaran->keterangan_angsuran }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="fw-bold text-success">Rp
                                                    {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="badge {{ $pembayaran->status === 'berhasil' ? 'bg-success' : ($pembayaran->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                    <i
                                                        class="fas {{ $pembayaran->status === 'berhasil' ? 'fa-check' : ($pembayaran->status === 'pending' ? 'fa-clock' : 'fa-times') }} me-1"></i>
                                                    {{ ucfirst($pembayaran->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($pembayaran->bukti_pembayaran_path)
                                                    <a href="{{ Storage::url($pembayaran->bukti_pembayaran_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-receipt text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada riwayat pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Biaya Pendaftaran Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-money-bill-wave me-2"></i>Rincian Biaya
                    </h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalPembayaran">
                        <i class="fas fa-plus me-1"></i>Tambah
                    </button>
                </div>
                <div class="card-body p-4">

                    @php
                        $totalBiaya = 0;
                        $totalBayar = 0;
                        $biayaBelumLunas = [];
                        $rencanaAngsuran = $calonSiswa->pembayaran->where('jenis_pembayaran', 'dp_angsuran')->first();

                        foreach ($calonSiswa->tahunAjaran->biayaPendaftaran as $biaya) {
                            $totalBiaya += $biaya->jumlah;

                            // Hitung total pembayaran untuk biaya ini
                            $totalPembayaranBiaya = $calonSiswa->pembayaran
                                ->where('biaya_pendaftaran_id', $biaya->id)
                                ->where('status', 'berhasil')
                                ->sum('jumlah');

                            if ($totalPembayaranBiaya > 0) {
                                $totalBayar += $totalPembayaranBiaya;

                                // Jika belum lunas penuh, masih masuk ke daftar belum lunas
                                if ($totalPembayaranBiaya < $biaya->jumlah) {
                                    $biayaBelumLunas[] = [
                                        'id' => $biaya->id,
                                        'jenis' => $biaya->jenis_biaya,
                                        'jumlah' => $biaya->jumlah,
                                        'terbayar' => $totalPembayaranBiaya,
                                        'sisa' => $biaya->jumlah - $totalPembayaranBiaya,
                                        'wajib' => $biaya->wajib_bayar,
                                        'mata_uang' => $biaya->mata_uang,
                                        'keterangan' => $biaya->keterangan,
                                        'dapat_diangsur' => $biaya->dapat_diangsur,
                                        'min_dp' => $biaya->min_dp,
                                    ];
                                }
                            } else {
                                // Belum ada pembayaran sama sekali
                                $biayaBelumLunas[] = [
                                    'id' => $biaya->id,
                                    'jenis' => $biaya->jenis_biaya,
                                    'jumlah' => $biaya->jumlah,
                                    'terbayar' => 0,
                                    'sisa' => $biaya->jumlah,
                                    'wajib' => $biaya->wajib_bayar,
                                    'mata_uang' => $biaya->mata_uang,
                                    'keterangan' => $biaya->keterangan,
                                    'dapat_diangsur' => $biaya->dapat_diangsur,
                                    'min_dp' => $biaya->min_dp,
                                ];
                            }
                        }

                        $totalBelumBayar = $totalBiaya - $totalBayar;
                    @endphp

                    <!-- Payment Summary -->
                    <div
                        class="payment-summary p-4 rounded-3 mb-4 {{ $totalBelumBayar > 0 ? 'bg-warning bg-opacity-10 border border-warning' : 'bg-success bg-opacity-10 border border-success' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 {{ $totalBelumBayar > 0 ? 'text-warning' : 'text-success' }}">
                                    <i
                                        class="fas {{ $totalBelumBayar > 0 ? 'fa-exclamation-triangle' : 'fa-check-circle' }} me-2"></i>
                                    {{ $totalBelumBayar > 0 ? 'Sisa Pembayaran' : 'Lunas' }}
                                </h6>
                                <div class="h4 mb-0 fw-bold {{ $totalBelumBayar > 0 ? 'text-warning' : 'text-success' }}">
                                    Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}
                                </div>
                                <small class="text-muted">
                                    Total: Rp {{ number_format($totalBiaya, 0, ',', '.') }} |
                                    Terbayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                </small>
                            </div>
                            @if ($totalBelumBayar > 0)
                                <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#modalPembayaran">
                                    <i class="fas fa-credit-card me-2"></i>Bayar
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Angsuran Info -->
                    @if ($rencanaAngsuran)
                        @php
                            $rencana = App\Models\RencanaAngsuran::with('detailAngsuran')
                                ->where('calon_siswa_id', $calonSiswa->id)
                                ->where('biaya_pendaftaran_id', $rencanaAngsuran->biaya_pendaftaran_id)
                                ->first();
                            $detailAngsuran = $rencana->detailAngsuran ?? null;
                        @endphp

                        <div class="angsuran-info p-4 rounded-3 mb-4 bg-info bg-opacity-10 border border-info">
                            <h6 class="fw-bold mb-3 text-info">
                                <i class="fas fa-calendar-check me-2"></i>Info Angsuran
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small fw-semibold">Total Biaya</label>
                                        <div class="fw-bold">Rp {{ number_format($rencana->total_biaya, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small fw-semibold">DP Dibayar</label>
                                        <div class="fw-bold">Rp {{ number_format($rencana->dp_dibayar, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small fw-semibold">Sisa Hutang</label>
                                        <div class="fw-bold">Rp {{ number_format($rencana->sisa_hutang, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small fw-semibold">Jumlah Cicilan</label>
                                        <div class="fw-bold">{{ $rencana->jumlah_cicilan }}x</div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3 text-info">
                                <i class="fas fa-list-ol me-2"></i>Daftar Cicilan
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Cicilan Ke</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailAngsuran as $angsuran)
                                            <tr>
                                                <td>{{ $angsuran->cicilan_ke }}</td>
                                                <td>{{ \Carbon\Carbon::parse($angsuran->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                                </td>
                                                <td>Rp {{ number_format($angsuran->nominal_cicilan, 0, ',', '.') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $angsuran->status === 'dibayar' ? 'bg-success' : ($angsuran->status === 'belum_bayar' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                        {{ ucfirst(str_replace('_', ' ', $angsuran->status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($angsuran->status === 'belum_bayar')
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            onclick="setAngsuranId('{{ $angsuran->id }}', '{{ $angsuran->nominal_cicilan }}', '{{ $angsuran->rencanaAngsuran->biayaPendaftaran->mata_uang }}', '{{ $angsuran->rencanaAngsuran->biayaPendaftaran->id }}')"
                                                            data-bs-toggle="modal" data-bs-target="#modalPembayaran">
                                                            Bayar
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if (count($biayaBelumLunas) > 0)
                        <h6 class="fw-bold mb-3 text-danger">
                            <i class="fas fa-list-ul me-2"></i>Biaya yang Belum Dibayar
                        </h6>
                        <div class="unpaid-fees">
                            @foreach ($biayaBelumLunas as $biaya)
                                <div class="fee-item p-3 border border-warning rounded-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <h6 class="mb-0 fw-bold">{{ $biaya['jenis'] }}</h6>
                                                @if ($biaya['wajib'])
                                                    <span class="badge bg-danger ms-2">Wajib</span>
                                                @endif
                                                @if ($biaya['dapat_diangsur'])
                                                    <span class="badge bg-info ms-2">Dapat Diangsur</span>
                                                @endif
                                            </div>
                                            <div class="h5 mb-1 fw-bold text-primary">
                                                {{ $biaya['mata_uang'] }}
                                                {{ number_format($biaya['jumlah'], 0, ',', '.') }}
                                            </div>
                                            @if ($biaya['keterangan'])
                                                <small class="text-muted">{{ $biaya['keterangan'] }}</small>
                                            @endif
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="setBiayaId('{{ $biaya['id'] }}', '{{ $biaya['jumlah'] }}', '{{ $biaya['mata_uang'] }}', {{ $biaya['dapat_diangsur'] ? 'true' : 'false' }}, {{ $biaya['min_dp'] ?? 0 }})"
                                                data-bs-toggle="modal" data-bs-target="#modalPembayaran">
                                                <i class="fas fa-credit-card me-1"></i>Bayar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-success fw-bold mb-2">Pembayaran Lunas!</h5>
                            <p class="text-muted mb-0">Semua biaya pendaftaran sudah dibayar</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Pembayaran -->
            <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold" id="modalPembayaranLabel">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Pembayaran
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pembayaran.store', $calonSiswa->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <input type="hidden" id="selected_biaya_id" name="biaya_pendaftaran_id">
                                <input type="hidden" id="selected_detail_angsuran_id" name="detail_angsuran_id">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="jenis_pembayaran" class="form-label fw-semibold">
                                            <i class="fas fa-money-bill-wave text-success me-1"></i>Jenis Pembayaran
                                        </label>
                                        <select class="form-select form-select-lg" id="jenis_pembayaran"
                                            name="jenis_pembayaran" required>
                                            <option value="">Pilih jenis pembayaran</option>
                                            <option value="penuh">💵 Pembayaran Penuh</option>
                                            <option value="dp_angsuran">💳 DP + Angsuran</option>
                                            <option value="cicilan_angsuran">🔄 Pembayaran Cicilan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="metode_pembayaran" class="form-label fw-semibold">
                                            <i class="fas fa-credit-card text-primary me-1"></i>Metode Pembayaran
                                        </label>
                                        <select class="form-select form-select-lg" id="metode_pembayaran"
                                            name="metode_pembayaran" required>
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="transfer">💳 Transfer Bank</option>
                                            <option value="tunai">💵 Tunai</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="jumlah" class="form-label fw-semibold">
                                            <i class="fas fa-money-bill-wave text-success me-1"></i>Jumlah Pembayaran
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-success text-white fw-bold"
                                                id="mata-uang-addon">Rp</span>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                required placeholder="0">
                                        </div>
                                        <small id="min-dp-info" class="text-danger d-none">Minimal DP: Rp <span
                                                id="min-dp-value">0</span></small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tanggal_pembayaran" class="form-label fw-semibold">
                                            <i class="fas fa-calendar-alt text-info me-1"></i>Tanggal Pembayaran
                                        </label>
                                        <input type="date" class="form-control form-control-lg"
                                            id="tanggal_pembayaran" name="tanggal_pembayaran" required
                                            value="{{ date('Y-m-d') }}">
                                    </div>

                                    <!-- Angsuran Fields (Hidden by Default) -->
                                    <div id="angsuran-fields" class="row g-3 d-none">
                                        <div class="col-md-6">
                                            <label for="jumlah_cicilan" class="form-label fw-semibold">
                                                <i class="fas fa-calendar-day text-info me-1"></i>Jumlah Cicilan
                                            </label>
                                            <select class="form-select form-select-lg" id="jumlah_cicilan"
                                                name="jumlah_cicilan">
                                                <option value="">Pilih jumlah cicilan</option>
                                                @for ($i = 2; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}x</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_mulai_cicilan" class="form-label fw-semibold">
                                                <i class="fas fa-calendar-plus text-info me-1"></i>Tanggal Mulai Cicilan
                                            </label>
                                            <input type="date" class="form-control form-control-lg"
                                                id="tanggal_mulai_cicilan" name="tanggal_mulai_cicilan">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="bukti_pembayaran" class="form-label fw-semibold">
                                            <i class="fas fa-file-upload text-warning me-1"></i>Bukti Pembayaran
                                        </label>
                                        <input type="file" class="form-control form-control-lg" id="bukti_pembayaran"
                                            name="bukti_pembayaran">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, PDF. Maksimal: 2MB
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="catatan" class="form-label fw-semibold">
                                            <i class="fas fa-sticky-note text-secondary me-1"></i>Catatan
                                        </label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                            placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-1"></i>Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Action Card for Status Update -->
            @if ($calonSiswa->status_pendaftaran === 'menunggu')
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-gradient-warning text-dark py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-clipboard-check me-2"></i>Tindakan Verifikasi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-info me-2 fs-5"></i>
                                <div>
                                    <strong>Perhatian!</strong><br>
                                    Pendaftaran ini masih dalam status <strong>menunggu</strong> dan memerlukan verifikasi
                                    dari admin.
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('calon-siswa.update-status', $calonSiswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="status_pendaftaran" class="form-label fw-semibold">
                                        <i class="fas fa-clipboard-list text-primary me-1"></i>Status Pendaftaran
                                    </label>
                                    <select class="form-select form-select-lg" id="status_pendaftaran"
                                        name="status_pendaftaran" required>
                                        <option value="">Pilih keputusan...</option>
                                        <option value="diterima" class="text-success">✅ Diterima</option>
                                        <option value="ditolak" class="text-danger">❌ Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-12" style="display: none;" id="kelasSelect">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="catatan" class="form-label fw-semibold">
                                        <i class="fas fa-comment-alt text-info me-1"></i>Catatan/Alasan
                                    </label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4"
                                        placeholder="Berikan catatan atau alasan untuk keputusan ini..."></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-check-circle me-2"></i>Update Status Pendaftaran
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <!-- Custom CSS for enhanced styling -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        }

        .avatar-sm {
            width: 2.5rem;
            height: 2.5rem;
        }

        .info-item {
            transition: all 0.2s ease;
        }

        .fee-item {
            transition: all 0.3s ease;
        }

        .fee-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .payment-summary {
            transition: all 0.3s ease;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .list-group-item {
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            padding-left: 1.5rem !important;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .modal-content {
            border-radius: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .badge {
            font-size: 0.75em;
            padding: 0.5em 0.75em;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
        }

        .parent-info {
            transition: all 0.3s ease;
        }

        .parent-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem !important;
            }

            .modal-dialog {
                margin: 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- Enhanced JavaScript -->
    <script>
        // Function to set biaya ID for payment modal
        function setBiayaId(biayaId, jumlah, mataUang, dapatDiangsur = false, minDp = 0) {
            document.getElementById('selected_biaya_id').value = biayaId;
            document.getElementById('selected_detail_angsuran_id').value = '';
            document.getElementById('jumlah').value = jumlah;
            document.getElementById('mata-uang-addon').textContent = mataUang;

            // Reset form fields
            document.getElementById('jenis_pembayaran').value = '';
            document.getElementById('metode_pembayaran').value = '';
            document.getElementById('jumlah_cicilan').value = '';
            document.getElementById('tanggal_mulai_cicilan').value = '';
            document.getElementById('angsuran-fields').classList.add('d-none');

            // Show/hide DP info
            const minDpInfo = document.getElementById('min-dp-info');
            if (dapatDiangsur && minDp > 0) {
                minDpInfo.classList.remove('d-none');
                document.getElementById('min-dp-value').textContent = minDp.toLocaleString('id-ID');
            } else {
                minDpInfo.classList.add('d-none');
            }

            // Auto-select payment type based on installments
            if (dapatDiangsur) {
                document.getElementById('jenis_pembayaran').value = 'dp_angsuran';
                toggleAngsuranFields('dp_angsuran');
            } else {
                document.getElementById('jenis_pembayaran').value = 'penuh';
            }
        }

        // Function to set angsuran ID for payment modal
        function setAngsuranId(angsuranId, nominal, mataUang, biayaId = '') {
            console.log(biayaId)
            document.getElementById('selected_detail_angsuran_id').value = angsuranId;
            document.getElementById('selected_biaya_id').value = biayaId;
            document.getElementById('jumlah').value = nominal;
            document.getElementById('mata-uang-addon').textContent = mataUang;

            // Reset form fields
            document.getElementById('jenis_pembayaran').value = 'cicilan_angsuran';
            document.getElementById('metode_pembayaran').value = '';
            document.getElementById('jumlah_cicilan').value = '';
            document.getElementById('tanggal_mulai_cicilan').value = '';
            document.getElementById('angsuran-fields').classList.add('d-none');
            document.getElementById('min-dp-info').classList.add('d-none');
        }

        // Toggle angsuran fields based on payment type
        function toggleAngsuranFields(paymentType) {
            const angsuranFields = document.getElementById('angsuran-fields');
            if (paymentType === 'dp_angsuran') {
                angsuranFields.classList.remove('d-none');
            } else {
                angsuranFields.classList.add('d-none');
            }
        }

        // Enhanced form validation and UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to cards on load
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add hover effects to info items
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                    this.style.borderRadius = '0.375rem';
                    this.style.padding = '0.5rem';
                    this.style.transition = 'all 0.2s ease';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'transparent';
                    this.style.padding = '0';
                });
            });

            // Format currency input
            const jumlahInput = document.getElementById('jumlah');
            if (jumlahInput) {
                jumlahInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    this.value = value;
                });
            }

            // Add confirmation for status update
            const statusForm = document.querySelector('form[action*="update-status"]');
            if (statusForm) {
                statusForm.addEventListener('submit', function(e) {
                    const status = document.getElementById('status_pendaftaran').value;
                    const confirmMessage = status === 'diterima' ?
                        'Apakah Anda yakin ingin MENERIMA pendaftar ini?' :
                        'Apakah Anda yakin ingin MENOLAK pendaftar ini?';

                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                    }
                });
            }

            // Toggle angsuran fields based on payment type
            const jenisPembayaran = document.getElementById('jenis_pembayaran');
            if (jenisPembayaran) {
                jenisPembayaran.addEventListener('change', function() {
                    toggleAngsuranFields(this.value);
                });
            }

            // Toggle kelas select based on status
            $('#status_pendaftaran').change(function(e) {
                e.preventDefault();

                let val = $(this).val();
                if (val == 'diterima') {
                    $('#kelasSelect').show();
                } else {
                    $('#kelasSelect').hide();
                }
            });

            // Smooth scroll to unpaid fees when payment button is clicked
            function scrollToUnpaidFees() {
                document.querySelector('.unpaid-fees')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        });
    </script>
@endpush
