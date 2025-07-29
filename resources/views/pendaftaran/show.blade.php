@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')
    <!-- Modern Header Section -->
    <div class="header-section">
        <div class="container-fluid px-4">
            <div class="header-content">
                <div class="header-info">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb breadcrumb-modern">
                            <li class="breadcrumb-item">
                                <a href="{{ route('calon-siswa.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-house-door me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('calon-siswa.index') }}" class="breadcrumb-link">
                                    Data Pendaftaran
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Detail Pendaftaran</li>
                        </ol>
                    </nav>
                    <h1 class="page-title">
                        <i class="bi bi-person-badge me-3"></i>Detail Pendaftaran
                    </h1>
                    <p class="page-subtitle">{{ $calonSiswa->nama_lengkap }} • {{ $calonSiswa->no_pendaftaran }}</p>
                </div>
                <div class="header-actions">
                    <span class="status-badge status-{{ $calonSiswa->status_pendaftaran }}">
                        <i
                            class="bi {{ $calonSiswa->status_pendaftaran === 'diterima' ? 'bi-check-circle' : ($calonSiswa->status_pendaftaran === 'ditolak' ? 'bi-x-circle' : 'bi-clock') }}"></i>
                        {{ ucfirst($calonSiswa->status_pendaftaran) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-modern" role="alert">
            <div class="alert-content">
                <i class="bi bi-check-circle-fill alert-icon"></i>
                <div class="alert-text">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-modern" role="alert">
            <div class="alert-content">
                <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                <div class="alert-text">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <!-- Student Data Card -->
            <div class="card modern-card">
                <div class="card-header card-header-primary">
                    <div class="card-header-content">
                        <h5 class="card-title">
                            <i class="bi bi-person-fill me-2"></i>Data Pendaftar
                        </h5>
                        <div class="card-actions">
                            <button type="button" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Personal Info -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="section-title">
                                    <i class="bi bi-person-vcard me-2"></i>Informasi Pribadi
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <label class="info-label">No. Pendaftaran</label>
                                        <div class="info-value">{{ $calonSiswa->no_pendaftaran }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">NIK</label>
                                        <div class="info-value">{{ $calonSiswa->nik }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">NISN</label>
                                        <div class="info-value">{{ $calonSiswa->nisn }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Nama Lengkap</label>
                                        <div class="info-value primary">{{ $calonSiswa->nama_lengkap }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Jenis Kelamin</label>
                                        <div class="info-value">
                                            <i
                                                class="bi {{ $calonSiswa->jenis_kelamin === 'L' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' }} me-2"></i>
                                            {{ $calonSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Tempat, Tanggal Lahir</label>
                                        <div class="info-value">
                                            <i class="bi bi-calendar-event text-info me-2"></i>
                                            {{ $calonSiswa->tempat_lahir }},
                                            {{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d F Y') }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Agama</label>
                                        <div class="info-value">{{ $calonSiswa->agama }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contact & Education Info -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="section-title">
                                    <i class="bi bi-geo-alt me-2"></i>Kontak & Pendidikan
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <label class="info-label">Alamat</label>
                                        <div class="info-value">{{ $calonSiswa->alamat }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">No. HP</label>
                                        <div class="info-value">
                                            <i class="bi bi-telephone text-success me-2"></i>
                                            <a href="tel:{{ $calonSiswa->no_hp }}"
                                                class="contact-link">{{ $calonSiswa->no_hp }}</a>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Email</label>
                                        <div class="info-value">
                                            <i class="bi bi-envelope text-info me-2"></i>
                                            <a href="mailto:{{ $calonSiswa->email }}"
                                                class="contact-link">{{ $calonSiswa->email }}</a>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Asal Sekolah</label>
                                        <div class="info-value">
                                            <i class="bi bi-building text-warning me-2"></i>
                                            {{ $calonSiswa->asal_sekolah }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Tahun Ajaran</label>
                                        <div class="info-value">{{ $calonSiswa->tahunAjaran->nama_tahun_ajaran }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Jalur Pendaftaran</label>
                                        <div class="info-value">
                                            @if ($calonSiswa->jalurPendaftaran)
                                                {{ $calonSiswa->jalurPendaftaran->nama_jalur }}
                                                <span
                                                    class="badge badge-{{ $calonSiswa->jalurPendaftaran->aktif ? 'success' : 'danger' }}">
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
            </div>

            <!-- Parent Data Card -->
            <div class="card modern-card">
                <div class="card-header card-header-success">
                    <h5 class="card-title">
                        <i class="bi bi-people-fill me-2"></i>Data Orang Tua
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="parent-card parent-father">
                                <div class="parent-header">
                                    <i class="bi bi-person-fill-gear me-2"></i>Data Ayah
                                </div>
                                <div class="parent-info">
                                    <div class="info-item">
                                        <label class="info-label">Nama Ayah</label>
                                        <div class="info-value">{{ $calonSiswa->nama_ayah }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Pekerjaan</label>
                                        <div class="info-value">
                                            <i class="bi bi-briefcase text-primary me-2"></i>
                                            {{ $calonSiswa->pekerjaan_ayah }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="parent-card parent-mother">
                                <div class="parent-header">
                                    <i class="bi bi-person-heart me-2"></i>Data Ibu
                                </div>
                                <div class="parent-info">
                                    <div class="info-item">
                                        <label class="info-label">Nama Ibu</label>
                                        <div class="info-value">{{ $calonSiswa->nama_ibu }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">Pekerjaan</label>
                                        <div class="info-value">
                                            <i class="bi bi-briefcase text-danger me-2"></i>
                                            {{ $calonSiswa->pekerjaan_ibu }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="info-label">No. HP Orang Tua</label>
                                        <div class="info-value">
                                            <i class="bi bi-telephone text-success me-2"></i>
                                            <a href="tel:{{ $calonSiswa->no_hp_orang_tua }}"
                                                class="contact-link">{{ $calonSiswa->no_hp_orang_tua }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <!-- Documents Card -->
            <div class="card modern-card">
                <div class="card-header card-header-info">
                    <h5 class="card-title">
                        <i class="bi bi-folder2-open me-2"></i>Berkas Pendaftaran
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if ($calonSiswa->berkasCalonSiswa)
                        <div class="document-list">
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->foto_path) }}" target="_blank"
                                class="document-item">
                                <div class="document-icon bg-primary">
                                    <i class="bi bi-camera-fill"></i>
                                </div>
                                <div class="document-info">
                                    <div class="document-name">Pas Foto</div>
                                    <div class="document-desc">Foto 3x4</div>
                                </div>
                                <div class="document-action">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                            </a>
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->ijazah_path) }}" target="_blank"
                                class="document-item">
                                <div class="document-icon bg-success">
                                    <i class="bi bi-award-fill"></i>
                                </div>
                                <div class="document-info">
                                    <div class="document-name">Ijazah</div>
                                    <div class="document-desc">Ijazah/STTB</div>
                                </div>
                                <div class="document-action">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                            </a>
                            <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->kk_path) }}" target="_blank"
                                class="document-item">
                                <div class="document-icon bg-warning">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="document-info">
                                    <div class="document-name">Kartu Keluarga</div>
                                    <div class="document-desc">KK Asli</div>
                                </div>
                                <div class="document-action">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                            </a>
                            @if ($calonSiswa->berkasCalonSiswa->akta_path)
                                <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->akta_path) }}" target="_blank"
                                    class="document-item">
                                    <div class="document-icon bg-info">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </div>
                                    <div class="document-info">
                                        <div class="document-name">Akta Kelahiran</div>
                                        <div class="document-desc">Akta Asli</div>
                                    </div>
                                    <div class="document-action">
                                        <i class="bi bi-eye-fill"></i>
                                    </div>
                                </a>
                            @endif
                            @if ($calonSiswa->berkasCalonSiswa->skl_path)
                                <a href="{{ Storage::url($calonSiswa->berkasCalonSiswa->skl_path) }}" target="_blank"
                                    class="document-item">
                                    <div class="document-icon bg-secondary">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <div class="document-info">
                                        <div class="document-name">Surat Keterangan Lulus</div>
                                        <div class="document-desc">SKL Asli</div>
                                    </div>
                                    <div class="document-action">
                                        <i class="bi bi-eye-fill"></i>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-folder2-open empty-icon"></i>
                            <p class="empty-text">Belum ada berkas yang diupload</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment History Card -->
            <div class="card modern-card">
                <div class="card-header card-header-warning">
                    <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if ($calonSiswa->pembayaran->count() > 0)
                        <div class="payment-history">
                            @foreach ($calonSiswa->pembayaran as $pembayaran)
                                <div class="payment-item">
                                    <div class="payment-date">
                                        <div class="date-main">
                                            {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') }}
                                        </div>
                                        <div class="date-code">{{ $pembayaran->kode_pembayaran }}</div>
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-type">{{ $pembayaran->biayaPendaftaran->jenis_biaya }}</div>
                                        <div class="payment-method">{{ ucfirst($pembayaran->jenis_pembayaran) }}</div>
                                        @if ($pembayaran->keterangan_angsuran)
                                            <div class="payment-note">{{ $pembayaran->keterangan_angsuran }}</div>
                                        @endif
                                    </div>
                                    <div class="payment-amount">
                                        <div class="amount">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</div>
                                        <div class="status-badge status-{{ $pembayaran->status }}">
                                            <i
                                                class="bi {{ $pembayaran->status === 'berhasil' ? 'bi-check-circle' : ($pembayaran->status === 'pending' ? 'bi-clock' : 'bi-x-circle') }}"></i>
                                            {{ ucfirst($pembayaran->status) }}
                                        </div>
                                    </div>
                                    <div class="payment-proof">
                                        @if ($pembayaran->bukti_pembayaran_path)
                                            <a href="{{ Storage::url($pembayaran->bukti_pembayaran_path) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-receipt empty-icon"></i>
                            <p class="empty-text">Belum ada riwayat pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fee Details Card -->
            <div class="card modern-card">
                <div class="card-header card-header-dark">
                    <div class="card-header-content">
                        <h5 class="card-title">
                            <i class="bi bi-currency-dollar me-2"></i>Rincian Biaya
                        </h5>
                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalPembayaran">
                            <i class="bi bi-plus-circle me-1"></i>Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body">
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
                    <div class="payment-summary payment-summary-{{ $totalBelumBayar > 0 ? 'pending' : 'complete' }}">
                        <div class="summary-content">
                            <div class="summary-info">
                                <div class="summary-title">
                                    <i
                                        class="bi {{ $totalBelumBayar > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }}"></i>
                                    {{ $totalBelumBayar > 0 ? 'Sisa Pembayaran' : 'Lunas' }}
                                </div>
                                <div class="summary-amount">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</div>
                                <div class="summary-detail">
                                    Total: Rp {{ number_format($totalBiaya, 0, ',', '.') }} •
                                    Terbayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                </div>
                            </div>
                            @if ($totalBelumBayar > 0)
                                <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#modalPembayaran">
                                    <i class="bi bi-credit-card me-2"></i>Bayar
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Installment Info -->
                    @if ($rencanaAngsuran)
                        @php
                            $rencana = App\Models\RencanaAngsuran::with('detailAngsuran')
                                ->where('calon_siswa_id', $calonSiswa->id)
                                ->where('biaya_pendaftaran_id', $rencanaAngsuran->biaya_pendaftaran_id)
                                ->first();
                            $detailAngsuran = $rencana->detailAngsuran ?? null;
                        @endphp

                        <div class="installment-info">
                            <h6 class="installment-title">
                                <i class="bi bi-calendar-check me-2"></i>Info Angsuran
                            </h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="installment-item">
                                        <label>Total Biaya</label>
                                        <div class="value">Rp {{ number_format($rencana->total_biaya, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="installment-item">
                                        <label>DP Dibayar</label>
                                        <div class="value">Rp {{ number_format($rencana->dp_dibayar, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="installment-item">
                                        <label>Sisa Hutang</label>
                                        <div class="value">Rp {{ number_format($rencana->sisa_hutang, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="installment-item">
                                        <label>Jumlah Cicilan</label>
                                        <div class="value">{{ $rencana->jumlah_cicilan }}x</div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="installment-list-title">
                                <i class="bi bi-list-ol me-2"></i>Daftar Cicilan
                            </h6>
                            <div class="installment-list">
                                @foreach ($detailAngsuran as $angsuran)
                                    <div class="installment-row">
                                        <div class="installment-number">{{ $angsuran->cicilan_ke }}</div>
                                        <div class="installment-details">
                                            <div class="installment-date">
                                                {{ \Carbon\Carbon::parse($angsuran->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                            </div>
                                            <div class="installment-amount">Rp
                                                {{ number_format($angsuran->nominal_cicilan, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="installment-status">
                                            <span
                                                class="status-badge status-{{ $angsuran->status === 'dibayar' ? 'berhasil' : ($angsuran->status === 'belum_bayar' ? 'pending' : 'ditolak') }}">
                                                {{ ucfirst(str_replace('_', ' ', $angsuran->status)) }}
                                            </span>
                                        </div>
                                        <div class="installment-action">
                                            @if ($angsuran->status === 'belum_bayar')
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="setAngsuranId('{{ $angsuran->id }}', '{{ $angsuran->nominal_cicilan }}', '{{ $angsuran->rencanaAngsuran->biayaPendaftaran->mata_uang }}', '{{ $angsuran->rencanaAngsuran->biayaPendaftaran->id }}')"
                                                    data-bs-toggle="modal" data-bs-target="#modalPembayaran">
                                                    Bayar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (count($biayaBelumLunas) > 0)
                        <h6 class="unpaid-title">
                            <i class="bi bi-list-ul me-2"></i>Biaya yang Belum Dibayar
                        </h6>
                        <div class="unpaid-fees">
                            @foreach ($biayaBelumLunas as $biaya)
                                <div class="fee-item">
                                    <div class="fee-info">
                                        <div class="fee-header">
                                            <h6 class="fee-name">{{ $biaya['jenis'] }}</h6>
                                            <div class="fee-badges">
                                                @if ($biaya['wajib'])
                                                    <span class="badge badge-danger">Wajib</span>
                                                @endif
                                                @if ($biaya['dapat_diangsur'])
                                                    <span class="badge badge-info">Dapat Diangsur</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fee-amount">{{ $biaya['mata_uang'] }}
                                            {{ number_format($biaya['jumlah'], 0, ',', '.') }}</div>
                                        @if ($biaya['keterangan'])
                                            <div class="fee-desc">{{ $biaya['keterangan'] }}</div>
                                        @endif
                                    </div>
                                    <div class="fee-action">
                                        <button type="button" class="btn btn-primary"
                                            onclick="setBiayaId('{{ $biaya['id'] }}', '{{ $biaya['jumlah'] }}', '{{ $biaya['mata_uang'] }}', {{ $biaya['dapat_diangsur'] ? 'true' : 'false' }}, {{ $biaya['min_dp'] ?? 0 }})"
                                            data-bs-toggle="modal" data-bs-target="#modalPembayaran">
                                            <i class="bi bi-credit-card me-1"></i>Bayar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-check-circle-fill empty-icon text-success"></i>
                            <h5 class="empty-title">Pembayaran Lunas!</h5>
                            <p class="empty-text">Semua biaya pendaftaran sudah dibayar</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Modal -->
            <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPembayaranLabel">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Pembayaran
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pembayaran.store', $calonSiswa->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="selected_biaya_id" name="biaya_pendaftaran_id">
                                <input type="hidden" id="selected_detail_angsuran_id" name="detail_angsuran_id">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="jenis_pembayaran" class="form-label">
                                            <i class="bi bi-cash-coin text-success me-1"></i>Jenis Pembayaran
                                        </label>
                                        <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran"
                                            required>
                                            <option value="">Pilih jenis pembayaran</option>
                                            <option value="penuh">💵 Pembayaran Penuh</option>
                                            <option value="dp_angsuran">💳 DP + Angsuran</option>
                                            <option value="cicilan_angsuran">🔄 Pembayaran Cicilan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="metode_pembayaran" class="form-label">
                                            <i class="bi bi-credit-card text-primary me-1"></i>Metode Pembayaran
                                        </label>
                                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran"
                                            required>
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="transfer">💳 Transfer Bank</option>
                                            <option value="tunai">💵 Tunai</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="jumlah" class="form-label">
                                            <i class="bi bi-currency-dollar text-success me-1"></i>Jumlah Pembayaran
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="mata-uang-addon">Rp</span>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                required placeholder="0">
                                        </div>
                                        <small id="min-dp-info" class="text-danger d-none">Minimal DP: Rp <span
                                                id="min-dp-value">0</span></small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tanggal_pembayaran" class="form-label">
                                            <i class="bi bi-calendar-event text-info me-1"></i>Tanggal Pembayaran
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_pembayaran"
                                            name="tanggal_pembayaran" required value="{{ date('Y-m-d') }}">
                                    </div>

                                    <!-- Angsuran Fields (Hidden by Default) -->
                                    <div id="angsuran-fields" class="row g-3 d-none">
                                        <div class="col-md-6">
                                            <label for="jumlah_cicilan" class="form-label">
                                                <i class="bi bi-calendar-range text-info me-1"></i>Jumlah Cicilan
                                            </label>
                                            <select class="form-select" id="jumlah_cicilan" name="jumlah_cicilan">
                                                <option value="">Pilih jumlah cicilan</option>
                                                @for ($i = 2; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}x</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_mulai_cicilan" class="form-label">
                                                <i class="bi bi-calendar-plus text-info me-1"></i>Tanggal Mulai Cicilan
                                            </label>
                                            <input type="date" class="form-control" id="tanggal_mulai_cicilan"
                                                name="tanggal_mulai_cicilan">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="bukti_pembayaran" class="form-label">
                                            <i class="bi bi-cloud-upload text-warning me-1"></i>Bukti Pembayaran
                                        </label>
                                        <input type="file" class="form-control" id="bukti_pembayaran"
                                            name="bukti_pembayaran">
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>Format: JPG, PNG, PDF. Maksimal: 2MB
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="catatan" class="form-label">
                                            <i class="bi bi-chat-text text-secondary me-1"></i>Catatan
                                        </label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                            placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Status Update Card -->
            @if ($calonSiswa->status_pendaftaran === 'menunggu')
                <div class="card modern-card">
                    <div class="card-header card-header-warning">
                        <h5 class="card-title">
                            <i class="bi bi-clipboard-check me-2"></i>Tindakan Verifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info alert-modern mb-4">
                            <div class="alert-content">
                                <i class="bi bi-info-circle-fill alert-icon"></i>
                                <div class="alert-text">
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
                                    <label for="status_pendaftaran" class="form-label">
                                        <i class="bi bi-clipboard-data text-primary me-1"></i>Status Pendaftaran
                                    </label>
                                    <select class="form-select" id="status_pendaftaran" name="status_pendaftaran"
                                        required>
                                        <option value="">Pilih keputusan...</option>
                                        <option value="diterima">✅ Diterima</option>
                                        <option value="ditolak">❌ Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-12 d-none" id="kelasSelect">
                                    <label for="kelas_id" class="form-label">
                                        <i class="bi bi-people text-success me-1"></i>Kelas
                                    </label>
                                    <select name="kelas_id" id="kelas_id" class="form-select">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="catatan" class="form-label">
                                        <i class="bi bi-chat-text text-info me-1"></i>Catatan/Alasan
                                    </label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4"
                                        placeholder="Berikan catatan atau alasan untuk keputusan ini..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-check-circle me-2"></i>Update Status Pendaftaran
                                    </button>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        /* Modern CSS Variables */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);

            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            --border-radius: 1rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Global Styles */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Header Section */
        .header-section {
            background: var(--primary-gradient);
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            overflow: hidden;
            position: relative;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .breadcrumb-modern {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-link:hover {
            color: white;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-badge.status-diterima {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: white;
        }

        .status-badge.status-ditolak {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .status-badge.status-menunggu {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
            color: #333;
        }

        .status-badge.status-berhasil {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: white;
        }

        .status-badge.status-pending {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
            color: #333;
        }

        /* Modern Cards */
        .modern-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        /* Card Headers */
        .card-header-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-header-success {
            background: var(--success-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-header-warning {
            background: var(--warning-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-header-info {
            background: var(--info-gradient);
            color: #333;
            border: none;
            padding: 1.5rem;
        }

        .card-header-dark {
            background: var(--dark-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Info Sections */
        .info-section {
            height: 100%;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .info-grid {
            display: grid;
            gap: 1.25rem;
        }

        .info-item {
            padding: 1rem;
            border-radius: 0.75rem;
            background: #f8f9fa;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .info-item:hover {
            background: #e9ecef;
            border-left-color: #667eea;
            transform: translateX(5px);
        }

        .info-label {
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .info-value {
            font-weight: 600;
            color: #212529;
            font-size: 1rem;
        }

        .info-value.primary {
            font-size: 1.25rem;
            color: #667eea;
        }

        .contact-link {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        .contact-link:hover {
            color: #667eea;
        }

        /* Parent Cards */
        .parent-card {
            background: #f8f9fa;
            border-radius: var(--border-radius);
            overflow: hidden;
            height: 100%;
            transition: var(--transition);
        }

        .parent-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .parent-father .parent-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .parent-mother .parent-header {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .parent-header {
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .parent-info {
            padding: 1.5rem;
        }

        /* Document List */
        .document-list {
            padding: 0;
        }

        .document-item {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
            border-bottom: 1px solid #e9ecef;
        }

        .document-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .document-item:last-child {
            border-bottom: none;
        }

        .document-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-size: 1.25rem;
        }

        .document-info {
            flex: 1;
        }

        .document-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .document-desc {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .document-action {
            color: #667eea;
            font-size: 1.25rem;
        }

        /* Payment History */
        .payment-history {
            padding: 0;
        }

        .payment-item {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: 1rem;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            transition: var(--transition);
        }

        .payment-item:hover {
            background: #f8f9fa;
        }

        .payment-item:last-child {
            border-bottom: none;
        }

        .payment-date {
            text-align: center;
        }

        .date-main {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .date-code {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .payment-details {
            flex: 1;
        }

        .payment-type {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .payment-method,
        .payment-note {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .payment-amount {
            text-align: right;
        }

        .amount {
            font-weight: 700;
            color: #51cf66;
            margin-bottom: 0.25rem;
        }

        /* Payment Summary */
        .payment-summary {
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .payment-summary-pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #ffc107;
        }

        .payment-summary-complete {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 2px solid #17a2b8;
        }

        .summary-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-summary-pending .summary-title {
            color: #856404;
        }

        .payment-summary-complete .summary-title {
            color: #0c5460;
        }

        .summary-amount {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .payment-summary-pending .summary-amount {
            color: #856404;
        }

        .payment-summary-complete .summary-amount {
            color: #0c5460;
        }

        .summary-detail {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* Installment Info */
        .installment-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid #2196f3;
        }

        .installment-title,
        .installment-list-title {
            color: #1976d2;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .installment-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 0.5rem;
        }

        .installment-item label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            display: block;
        }

        .installment-item .value {
            font-weight: 700;
            color: #1976d2;
        }

        .installment-list {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .installment-row {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(25, 118, 210, 0.1);
        }

        .installment-row:last-child {
            border-bottom: none;
        }

        .installment-number {
            width: 2rem;
            height: 2rem;
            background: #1976d2;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .installment-date {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .installment-amount {
            font-weight: 600;
            color: #1976d2;
        }

        /* Fee Items */
        .unpaid-title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }

        .unpaid-fees {
            display: grid;
            gap: 1rem;
        }

        .fee-item {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: var(--transition);
        }

        .fee-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 193, 7, 0.2);
        }

        .fee-info {
            margin-bottom: 1rem;
        }

        .fee-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .fee-name {
            margin: 0;
            font-weight: 600;
            color: #856404;
        }

        .fee-badges {
            display: flex;
            gap: 0.5rem;
        }

        .fee-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #856404;
            margin-bottom: 0.5rem;
        }

        .fee-desc {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .fee-action {
            display: flex;
            justify-content: flex-end;
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        /* Alerts */
        .alert-modern {
            border: none;
            border-radius: var(--border-radius);
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }

        .alert-text {
            flex: 1;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #6c757d;
            margin: 0;
        }

        /* Buttons */
        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
            color: #333;
            box-shadow: 0 4px 12px rgba(255, 212, 59, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 212, 59, 0.4);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .btn-outline-light:hover {
            border-color: white;
            background: white;
            color: #333;
        }

        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
        }

        /* Forms */
        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            background: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .input-group-text {
            border: 2px solid #e9ecef;
            border-right: none;
            background: #667eea;
            color: white;
            font-weight: 600;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            margin: 0;
        }

        .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            background: #f8f9fa;
            border: none;
            padding: 1.5rem 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .card-header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .summary-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .fee-header {
                flex-direction: column;
                gap: 0.5rem;
            }

            .payment-item {
                grid-template-columns: 1fr;
                gap: 0.5rem;
                text-align: center;
            }

            .installment-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
                text-align: center;
            }

            .document-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .btn-lg {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in-left {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideInLeft 0.6s ease forwards;
        }

        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in-right {
            opacity: 0;
            transform: translateX(20px);
            animation: slideInRight 0.6s ease forwards;
        }

        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Utility Classes */
        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Loading Animation */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Enhanced JavaScript with modern animations and interactions

        // Function to set biaya ID for payment modal
        function setBiayaId(biayaId, jumlah, mataUang, dapatDiangsur = false, minDp = 0) {
            document.getElementById('selected_biaya_id').value = biayaId;
            document.getElementById('selected_detail_angsuran_id').value = '';
            document.getElementById('jumlah').value = jumlah;
            document.getElementById('mata-uang-addon').textContent = mataUang;

            // Reset form fields with animation
            const form = document.querySelector('#modalPembayaran form');
            form.style.opacity = '0.7';
            setTimeout(() => {
                document.getElementById('jenis_pembayaran').value = '';
                document.getElementById('metode_pembayaran').value = '';
                document.getElementById('jumlah_cicilan').value = '';
                document.getElementById('tanggal_mulai_cicilan').value = '';
                document.getElementById('angsuran-fields').classList.add('d-none');
                form.style.opacity = '1';
            }, 200);

            // Show/hide DP info with animation
            const minDpInfo = document.getElementById('min-dp-info');
            if (dapatDiangsur && minDp > 0) {
                minDpInfo.classList.remove('d-none');
                minDpInfo.style.animation = 'fadeIn 0.3s ease';
                document.getElementById('min-dp-value').textContent = minDp.toLocaleString('id-ID');
            } else {
                minDpInfo.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => minDpInfo.classList.add('d-none'), 300);
            }

            // Auto-select payment type based on installments
            setTimeout(() => {
                if (dapatDiangsur) {
                    document.getElementById('jenis_pembayaran').value = 'dp_angsuran';
                    toggleAngsuranFields('dp_angsuran');
                } else {
                    document.getElementById('jenis_pembayaran').value = 'penuh';
                }
            }, 250);
        }

        // Function to set angsuran ID for payment modal
        function setAngsuranId(angsuranId, nominal, mataUang, biayaId = '') {
            document.getElementById('selected_detail_angsuran_id').value = angsuranId;
            document.getElementById('selected_biaya_id').value = biayaId;
            document.getElementById('jumlah').value = nominal;
            document.getElementById('mata-uang-addon').textContent = mataUang;

            // Reset form fields with smooth transition
            const form = document.querySelector('#modalPembayaran form');
            form.style.transition = 'opacity 0.3s ease';
            form.style.opacity = '0.7';

            setTimeout(() => {
                document.getElementById('jenis_pembayaran').value = 'cicilan_angsuran';
                document.getElementById('metode_pembayaran').value = '';
                document.getElementById('jumlah_cicilan').value = '';
                document.getElementById('tanggal_mulai_cicilan').value = '';
                document.getElementById('angsuran-fields').classList.add('d-none');
                document.getElementById('min-dp-info').classList.add('d-none');
                form.style.opacity = '1';
            }, 300);
        }

        // Enhanced toggle angsuran fields with animation
        function toggleAngsuranFields(paymentType) {
            const angsuranFields = document.getElementById('angsuran-fields');

            if (paymentType === 'dp_angsuran') {
                angsuranFields.style.maxHeight = '0';
                angsuranFields.style.opacity = '0';
                angsuranFields.classList.remove('d-none');

                setTimeout(() => {
                    angsuranFields.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    angsuranFields.style.maxHeight = '200px';
                    angsuranFields.style.opacity = '1';
                }, 10);
            } else {
                angsuranFields.style.transition = 'all 0.3s ease';
                angsuranFields.style.maxHeight = '0';
                angsuranFields.style.opacity = '0';

                setTimeout(() => {
                    angsuranFields.classList.add('d-none');
                }, 300);
            }
        }

        // Enhanced DOM ready functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            initializeAnimations();

            // Initialize form enhancements
            initializeFormEnhancements();

            // Initialize card interactions
            initializeCardInteractions();

            // Initialize tooltips and popovers
            initializeTooltips();
        });

        function initializeAnimations() {
            // Animate cards on load with stagger effect
            const cards = document.querySelectorAll('.modern-card');
            cards.forEach((card, index) => {
                card.classList.add('fade-in');
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Animate info items
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach((item, index) => {
                item.classList.add('slide-in-left');
                item.style.animationDelay = `${index * 0.05}s`;
            });

            // Animate document items
            const docItems = document.querySelectorAll('.document-item');
            docItems.forEach((item, index) => {
                item.classList.add('slide-in-right');
                item.style.animationDelay = `${index * 0.1}s`;
            });

            // Animate payment items
            const paymentItems = document.querySelectorAll('.payment-item');
            paymentItems.forEach((item, index) => {
                item.classList.add('fade-in');
                item.style.animationDelay = `${index * 0.1}s`;
            });
        }

        function initializeFormEnhancements() {
            // Enhanced currency input formatting
            const jumlahInput = document.getElementById('jumlah');
            if (jumlahInput) {
                jumlahInput.addEventListener('input', function(e) {
                    let value = this.value.replace(/\D/g, '');

                    // Add loading effect
                    this.classList.add('loading');
                    setTimeout(() => this.classList.remove('loading'), 300);

                    this.value = value;

                    // Real-time validation feedback
                    if (value) {
                        this.style.borderColor = '#51cf66';
                        this.style.boxShadow = '0 0 0 0.2rem rgba(81, 207, 102, 0.25)';
                    } else {
                        this.style.borderColor = '#e9ecef';
                        this.style.boxShadow = 'none';
                    }
                });

                // Add focus animation
                jumlahInput.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                    this.parentElement.style.transition = 'transform 0.2s ease';
                });

                jumlahInput.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            }

            // Enhanced select animations
            const selects = document.querySelectorAll('.form-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                });
            });

            // Enhanced status form confirmation
            const statusForm = document.querySelector('form[action*="update-status"]');
            if (statusForm) {
                statusForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const status = document.getElementById('status_pendaftaran').value;
                    const studentName = document.querySelector('.page-subtitle').textContent.split(' • ')[0];

                    // Create custom confirmation modal
                    const confirmMessage = status === 'diterima' ?
                        `Apakah Anda yakin ingin MENERIMA ${studentName}?` :
                        `Apakah Anda yakin ingin MENOLAK ${studentName}?`;

                    if (confirm(confirmMessage)) {
                        // Add loading state
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Memproses...';
                        submitBtn.disabled = true;

                        // Submit form
                        this.submit();
                    }
                });
            }

            // Enhanced payment type toggle
            const jenisPembayaran = document.getElementById('jenis_pembayaran');
            if (jenisPembayaran) {
                jenisPembayaran.addEventListener('change', function() {
                    // Add visual feedback
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                        toggleAngsuranFields(this.value);
                    }, 150);
                });
            }

            // Enhanced class selection toggle
            const statusSelect = document.getElementById('status_pendaftaran');
            if (statusSelect) {
                statusSelect.addEventListener('change', function(e) {
                    const kelasSelect = document.getElementById('kelasSelect');
                    const value = this.value;

                    if (value === 'diterima') {
                        kelasSelect.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                        kelasSelect.style.maxHeight = '0';
                        kelasSelect.style.opacity = '0';
                        kelasSelect.classList.remove('d-none');

                        setTimeout(() => {
                            kelasSelect.style.maxHeight = '100px';
                            kelasSelect.style.opacity = '1';
                        }, 10);
                    } else {
                        kelasSelect.style.transition = 'all 0.3s ease';
                        kelasSelect.style.maxHeight = '0';
                        kelasSelect.style.opacity = '0';

                        setTimeout(() => {
                            kelasSelect.classList.add('d-none');
                        }, 300);
                    }
                });
            }
        }

        function initializeCardInteractions() {
            // Enhanced card hover effects
            const cards = document.querySelectorAll('.modern-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Enhanced info item interactions
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)';
                    this.style.borderLeftColor = '#667eea';
                    this.style.borderLeftWidth = '6px';
                    this.style.transform = 'translateX(10px) scale(1.02)';
                    this.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.15)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.background = '#f8f9fa';
                    this.style.borderLeftColor = 'transparent';
                    this.style.borderLeftWidth = '4px';
                    this.style.transform = 'translateX(0) scale(1)';
                    this.style.boxShadow = 'none';
                });
            });

            // Enhanced document item interactions
            const docItems = document.querySelectorAll('.document-item');
            docItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%)';
                    this.style.transform = 'translateX(10px) scale(1.02)';
                    this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';

                    const icon = this.querySelector('.document-icon');
                    if (icon) {
                        icon.style.transform = 'scale(1.1) rotate(5deg)';
                        icon.style.transition = 'transform 0.3s ease';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    this.style.background = 'transparent';
                    this.style.transform = 'translateX(0) scale(1)';
                    this.style.boxShadow = 'none';

                    const icon = this.querySelector('.document-icon');
                    if (icon) {
                        icon.style.transform = 'scale(1) rotate(0deg)';
                    }
                });
            });

            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });

                button.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(0) scale(0.95)';
                });

                button.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                });
            });
        }

        function initializeTooltips() {
            // Initialize Bootstrap tooltips if available
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Custom tooltip-like effects for status badges
            const statusBadges = document.querySelectorAll('.status-badge');
            statusBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.filter = 'brightness(1.1)';
                });

                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.filter = 'brightness(1)';
                });
            });
        }

        // Smooth scroll utility
        function smoothScrollTo(element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Enhanced loading states
        function showLoading(element) {
            element.classList.add('loading');
            element.style.pointerEvents = 'none';
        }

        function hideLoading(element) {
            element.classList.remove('loading');
            element.style.pointerEvents = 'auto';
        }

        // Modern notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-modern position-fixed`;
            notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        `;

            notification.innerHTML = `
            <div class="alert-content">
                <i class="bi bi-check-circle-fill alert-icon"></i>
                <div class="alert-text">${message}</div>
            </div>
        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Enhanced form validation
        function validateForm(form) {
            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#dc3545';
                    input.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                    isValid = false;

                    // Add shake animation
                    input.style.animation = 'shake 0.5s ease';
                    setTimeout(() => {
                        input.style.animation = '';
                    }, 500);
                } else {
                    input.style.borderColor = '#51cf66';
                    input.style.boxShadow = '0 0 0 0.2rem rgba(81, 207, 102, 0.25)';
                }
            });

            return isValid;
        }

        // Add shake animation keyframes dynamically
        const style = document.createElement('style');
        style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
        document.head.appendChild(style);
    </script>
@endpush
