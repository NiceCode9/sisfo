@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile Siswa</h4>
                    </div>
                    <div class="card-body">
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> Profile telah diperbarui.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> Password telah diperbarui.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Profile Information -->
                            <div class="col-md-8">
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    <!-- Basic Information -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Informasi Dasar</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nama Lengkap <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name"
                                                            value="{{ old('name', $user->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            id="username" name="username"
                                                            value="{{ old('username', $user->username) }}" required>
                                                        @error('username')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($user->email_verified_at === null)
                                                    <div class="form-text text-warning">
                                                        <i class="fas fa-exclamation-triangle"></i> Email belum
                                                        diverifikasi.
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="bio" class="form-label">Bio</label>
                                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                                                    maxlength="1000" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                                                @error('bio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    <span id="bioCount">{{ strlen($user->bio ?? '') }}</span>/1000
                                                    karakter
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Academic Information (Read Only) -->
                                    @if ($user->siswa)
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5>Informasi Akademik</h5>
                                                <small class="text-muted">Informasi ini tidak dapat diubah oleh
                                                    siswa</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if ($user->siswa->nis)
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">NIS</label>
                                                                <input type="text" class="form-control bg-light"
                                                                    value="{{ $user->siswa->nis }}" readonly>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($user->siswa->nisn)
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">NISN</label>
                                                                <input type="text" class="form-control bg-light"
                                                                    value="{{ $user->siswa->nisn }}" readonly>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if ($user->siswa->tahunAjaran)
                                                    <div class="mb-3">
                                                        <label class="form-label">Tahun Ajaran</label>
                                                        <input type="text" class="form-control bg-light"
                                                            value="{{ $user->siswa->tahunAjaran->nama_tahun_ajaran ?? 'Tidak ada data' }}"
                                                            readonly>
                                                    </div>
                                                @endif

                                                @if ($user->siswa->kelasAwal)
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas Awal</label>
                                                        <input type="text" class="form-control bg-light"
                                                            value="{{ $user->siswa->kelasAwal->nama_kelas ?? 'Tidak ada data' }}"
                                                            readonly>
                                                    </div>
                                                @endif

                                                @php
                                                    $kelasAktif = $user->siswa->kelasAktif();
                                                @endphp
                                                @if ($kelasAktif && $kelasAktif->kelas)
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas Aktif</label>
                                                        <input type="text" class="form-control bg-light"
                                                            value="{{ $kelasAktif->kelas->nama_kelas }}" readonly>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Social Media -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Media Sosial</h5>
                                            <small class="text-muted">Opsional - masukkan URL lengkap</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="fb" class="form-label">
                                                            <i class="fab fa-facebook text-primary"></i> Facebook
                                                        </label>
                                                        <input type="url"
                                                            class="form-control @error('fb') is-invalid @enderror"
                                                            id="fb" name="fb"
                                                            value="{{ old('fb', $user->fb) }}"
                                                            placeholder="https://facebook.com/username">
                                                        @error('fb')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ig" class="form-label">
                                                            <i class="fab fa-instagram text-danger"></i> Instagram
                                                        </label>
                                                        <input type="url"
                                                            class="form-control @error('ig') is-invalid @enderror"
                                                            id="ig" name="ig"
                                                            value="{{ old('ig', $user->ig) }}"
                                                            placeholder="https://instagram.com/username">
                                                        @error('ig')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="x" class="form-label">
                                                            <i class="fab fa-twitter text-info"></i> Twitter/X
                                                        </label>
                                                        <input type="url"
                                                            class="form-control @error('x') is-invalid @enderror"
                                                            id="x" name="x"
                                                            value="{{ old('x', $user->x) }}"
                                                            placeholder="https://x.com/username">
                                                        @error('x')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="li" class="form-label">
                                                            <i class="fab fa-linkedin text-primary"></i> LinkedIn
                                                        </label>
                                                        <input type="url"
                                                            class="form-control @error('li') is-invalid @enderror"
                                                            id="li" name="li"
                                                            value="{{ old('li', $user->li) }}"
                                                            placeholder="https://linkedin.com/in/username">
                                                        @error('li')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                    </div>
                                </form>

                                <!-- Update Password -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Update Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('profile.password.update') }}">
                                            @csrf
                                            @method('patch')

                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Password Saat Ini <span
                                                        class="text-danger">*</span></label>
                                                <input type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    id="current_password" name="current_password" required>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password Baru <span
                                                        class="text-danger">*</span></label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Password
                                                    Baru <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" required>
                                            </div>

                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-key"></i> Update Password
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Summary -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Informasi Siswa</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <div class="avatar-lg mx-auto">
                                                <div class="avatar-title rounded-circle bg-info text-white fs-1">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <h5 class="mt-2">{{ $user->name }}</h5>
                                            <p class="text-muted">{{ $user->email }}</p>
                                            <span class="badge bg-info">Siswa</span>
                                        </div>

                                        <hr>

                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                @if ($user->siswa)
                                                    @if ($user->siswa->nis)
                                                        <tr>
                                                            <td><strong>NIS:</strong></td>
                                                            <td>{{ $user->siswa->nis }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($user->siswa->nisn)
                                                        <tr>
                                                            <td><strong>NISN:</strong></td>
                                                            <td>{{ $user->siswa->nisn }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                                <tr>
                                                    <td><strong>Username:</strong></td>
                                                    <td>{{ $user->username }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email Verified:</strong></td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $user->email_verified_at ? 'Ya' : 'Belum' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bergabung:</strong></td>
                                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Academic Information -->
                                        @if ($user->siswa)
                                            <hr>
                                            <h6>Informasi Akademik</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    @if ($user->siswa->tahunAjaran)
                                                        <tr>
                                                            <td><strong>Tahun Ajaran:</strong></td>
                                                            <td>{{ $user->siswa->tahunAjaran->nama_tahun_ajaran }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($user->siswa->kelasAwal)
                                                        <tr>
                                                            <td><strong>Kelas Awal:</strong></td>
                                                            <td>{{ $user->siswa->kelasAwal->nama_kelas }}</td>
                                                        </tr>
                                                    @endif
                                                    @php
                                                        $kelasAktif = $user->siswa->kelasAktif();
                                                    @endphp
                                                    @if ($kelasAktif && $kelasAktif->kelas)
                                                        <tr>
                                                            <td><strong>Kelas Aktif:</strong></td>
                                                            <td>
                                                                <span class="badge bg-primary">
                                                                    {{ $kelasAktif->kelas->nama_kelas }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>

                                            <!-- Data Calon Siswa -->
                                            @if ($user->siswa->calonSiswa)
                                                <hr>
                                                <h6>Data Pribadi</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        @if ($user->siswa->calonSiswa->tempat_lahir)
                                                            <tr>
                                                                <td><strong>Tempat Lahir:</strong></td>
                                                                <td>{{ $user->siswa->calonSiswa->tempat_lahir }}</td>
                                                            </tr>
                                                        @endif
                                                        @if ($user->siswa->calonSiswa->tanggal_lahir)
                                                            <tr>
                                                                <td><strong>Tanggal Lahir:</strong></td>
                                                                <td>{{ \Carbon\Carbon::parse($user->siswa->calonSiswa->tanggal_lahir)->format('d M Y') }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($user->siswa->calonSiswa->jenis_kelamin)
                                                            <tr>
                                                                <td><strong>Jenis Kelamin:</strong></td>
                                                                <td>{{ $user->siswa->calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($user->siswa->calonSiswa->alamat)
                                                            <tr>
                                                                <td><strong>Alamat:</strong></td>
                                                                <td class="small">
                                                                    {{ Str::limit($user->siswa->calonSiswa->alamat, 50) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            @endif
                                        @endif

                                        @if ($user->bio)
                                            <hr>
                                            <h6>Bio</h6>
                                            <p class="small">{{ $user->bio }}</p>
                                        @endif

                                        <!-- Social Media Links -->
                                        @if ($user->fb || $user->ig || $user->x || $user->li)
                                            <hr>
                                            <h6>Media Sosial</h6>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if ($user->fb)
                                                    <a href="{{ $user->fb }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary" title="Facebook">
                                                        <i class="fab fa-facebook"></i>
                                                    </a>
                                                @endif
                                                @if ($user->ig)
                                                    <a href="{{ $user->ig }}" target="_blank"
                                                        class="btn btn-sm btn-outline-danger" title="Instagram">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                @endif
                                                @if ($user->x)
                                                    <a href="{{ $user->x }}" target="_blank"
                                                        class="btn btn-sm btn-outline-dark" title="Twitter/X">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                @endif
                                                @if ($user->li)
                                                    <a href="{{ $user->li }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info" title="LinkedIn">
                                                        <i class="fab fa-linkedin"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Academic Stats -->
                                @if ($user->siswa && $user->siswa->pengumpulanTugas)
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <h5>Statistik Akademik</h5>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $pengumpulanTugas = $user->siswa->pengumpulanTugas;
                                                $totalTugasDikumpulkan = $pengumpulanTugas->count();

                                                // Hitung tugas tepat waktu dengan membandingkan waktu_pengumpulan dengan batas_waktu tugas
                                                $tugasTepat = $pengumpulanTugas
                                                    ->filter(function ($pengumpulan) {
                                                        return $pengumpulan->tugas &&
                                                            $pengumpulan->waktu_pengumpulan &&
                                                            $pengumpulan->tugas->batas_waktu &&
                                                            $pengumpulan->waktu_pengumpulan <=
                                                                $pengumpulan->tugas->batas_waktu;
                                                    })
                                                    ->count();

                                                $tugasTerlambat = $totalTugasDikumpulkan - $tugasTepat;

                                                // Hitung rata-rata nilai
                                                $rataRataNilai = $pengumpulanTugas
                                                    ->where('nilai', '!=', null)
                                                    ->avg('nilai');
                                                $jumlahTugasDinilai = $pengumpulanTugas
                                                    ->where('nilai', '!=', null)
                                                    ->count();
                                            @endphp

                                            <div class="row text-center">
                                                <div class="col-12 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><i class="fas fa-tasks text-primary"></i> Total Tugas</span>
                                                        <span
                                                            class="badge bg-primary fs-6">{{ $totalTugasDikumpulkan }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><i class="fas fa-check-circle text-success"></i> Tepat
                                                            Waktu</span>
                                                        <span class="badge bg-success fs-6">{{ $tugasTepat }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><i class="fas fa-clock text-danger"></i> Terlambat</span>
                                                        <span class="badge bg-danger fs-6">{{ $tugasTerlambat }}</span>
                                                    </div>
                                                </div>
                                                @if ($jumlahTugasDinilai > 0)
                                                    <div class="col-12">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span><i class="fas fa-star text-warning"></i> Rata-rata
                                                                Nilai</span>
                                                            <span
                                                                class="badge bg-warning fs-6">{{ number_format($rataRataNilai, 1) }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($totalTugasDikumpulkan > 0)
                                                <hr>
                                                <div class="text-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-chart-line"></i> Tingkat ketepatan:
                                                        <strong>{{ round(($tugasTepat / $totalTugasDikumpulkan) * 100, 1) }}%</strong>
                                                    </small>
                                                </div>

                                                <!-- Progress Bar -->
                                                <div class="progress mt-2" style="height: 6px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ ($tugasTepat / $totalTugasDikumpulkan) * 100 }}%">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    <p class="mt-2">Belum ada tugas yang dikumpulkan</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Delete Account -->
                                {{-- <div class="card border-danger mt-4">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-danger">
                                            <i class="fas fa-warning"></i>
                                            Menghapus akun akan menghilangkan semua data secara permanen dan tidak dapat
                                            dikembalikan.
                                        </p>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteAccountModal">
                                            <i class="fas fa-trash"></i> Hapus Akun
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus Akun
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin menghapus akun? Semua data berikut akan dihapus secara permanen:</p>
                    <ul class="text-muted">
                        <li>Informasi profil</li>
                        <li>Data akademik</li>
                        <li>Riwayat pengumpulan tugas</li>
                        <li>Semua data terkait lainnya</li>
                    </ul>

                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="delete_password" class="form-label">
                                Masukkan Password untuk Konfirmasi <span class="text-danger">*</span>
                            </label>
                            <input type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="delete_password" name="password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" form="deleteForm" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-lg {
            width: 100px;
            height: 100px;
        }

        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .table-sm td {
            padding: 0.3rem;
            vertical-align: middle;
        }

        .progress {
            border-radius: 10px;
        }

        .badge {
            font-size: 0.8em;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counter for bio
            const bioTextarea = document.getElementById('bio');
            const bioCount = document.getElementById('bioCount');

            if (bioTextarea && bioCount) {
                bioTextarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    bioCount.textContent = currentLength;

                    // Change color based on length
                    if (currentLength > 800) {
                        bioCount.style.color = 'red';
                    } else if (currentLength > 600) {
                        bioCount.style.color = 'orange';
                    } else {
                        bioCount.style.color = '';
                    }
                });
            }

            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                        // Re-enable after 5 seconds to prevent permanent disable
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            const originalText = submitBtn.getAttribute(
                                'data-original-text') || 'Submit';
                            submitBtn.innerHTML = originalText;
                        }, 5000);
                    }
                });
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('alert-success')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);
        });
    </script>
@endsection
