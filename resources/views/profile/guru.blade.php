@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile Guru</h4>
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

                        <div class="row">
                            <!-- Profile Information -->
                            <div class="col-md-8">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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
                                                        <label for="gelar" class="form-label">Gelar</label>
                                                        <input type="text"
                                                            class="form-control @error('gelar') is-invalid @enderror"
                                                            id="gelar" name="gelar"
                                                            value="{{ old('gelar', $user->guru->gelar ?? '') }}"
                                                            placeholder="S.Pd., M.Pd., Dr., dll">
                                                        @error('gelar')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="telp" class="form-label">No. Telepon</label>
                                                        <input type="text"
                                                            class="form-control @error('telp') is-invalid @enderror"
                                                            id="telp" name="telp"
                                                            value="{{ old('telp', $user->guru->telp ?? '') }}">
                                                        @error('telp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->guru->alamat ?? '') }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="foto_path" class="form-label">Foto Profil</label>
                                                <input type="file"
                                                    class="form-control @error('foto_path') is-invalid @enderror"
                                                    id="foto_path" name="foto_path" accept="image/*">
                                                @error('foto_path')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Maksimal 2MB. Format: JPG, PNG, GIF</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Informasi Profesional</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                                <textarea class="form-control @error('bidang_keahlian') is-invalid @enderror" id="bidang_keahlian"
                                                    name="bidang_keahlian" rows="3" placeholder="Sebutkan bidang keahlian atau spesialisasi Anda...">{{ old('bidang_keahlian', $user->guru->bidang_keahlian ?? '') }}</textarea>
                                                @error('bidang_keahlian')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="biografi" class="form-label">Biografi</label>
                                                <textarea class="form-control @error('biografi') is-invalid @enderror" id="biografi" name="biografi" rows="4"
                                                    placeholder="Ceritakan tentang latar belakang pendidikan dan pengalaman mengajar Anda...">{{ old('biografi', $user->guru->biografi ?? '') }}</textarea>
                                                @error('biografi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="bio" class="form-label">Bio Singkat</label>
                                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="2"
                                                    maxlength="1000" placeholder="Bio singkat untuk ditampilkan di profil...">{{ old('bio', $user->bio) }}</textarea>
                                                @error('bio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Media -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Media Sosial</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="fb" class="form-label">Facebook</label>
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
                                                        <label for="ig" class="form-label">Instagram</label>
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
                                                        <label for="x" class="form-label">Twitter/X</label>
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
                                                        <label for="li" class="form-label">LinkedIn</label>
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
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
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
                                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                                <input type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    id="current_password" name="current_password" required>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password Baru</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Password
                                                    Baru</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" required>
                                            </div>

                                            <button type="submit" class="btn btn-warning">Update Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Summary -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Informasi Guru</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            @if ($user->guru && $user->guru->foto_path)
                                                <img src="{{ Storage::url($user->guru->foto_path) }}"
                                                    alt="Foto {{ $user->name }}" class="rounded-circle"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            @else
                                                <div class="avatar-lg mx-auto">
                                                    <div class="avatar-title rounded-circle bg-success text-white fs-1">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                            @endif
                                            <h5 class="mt-2">{{ $user->name }}</h5>
                                            @if ($user->guru && $user->guru->gelar)
                                                <p class="text-muted">{{ $user->guru->gelar }}</p>
                                            @endif
                                            <p class="text-muted">{{ $user->email }}</p>
                                            <span class="badge bg-success">Guru</span>
                                        </div>

                                        <hr>

                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                @if ($user->guru && $user->guru->nip)
                                                    <tr>
                                                        <td><strong>NIP:</strong></td>
                                                        <td>{{ $user->guru->nip }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><strong>Username:</strong></td>
                                                    <td>{{ $user->username }}</td>
                                                </tr>
                                                @if ($user->guru && $user->guru->telp)
                                                    <tr>
                                                        <td><strong>Telepon:</strong></td>
                                                        <td>{{ $user->guru->telp }}</td>
                                                    </tr>
                                                @endif
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
                                                    <td><strong>Bergabung:</strong></td>
                                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        @if ($user->guru && $user->guru->alamat)
                                            <hr>
                                            <h6>Alamat</h6>
                                            <p class="small">{{ $user->guru->alamat }}</p>
                                        @endif

                                        @if ($user->guru && $user->guru->bidang_keahlian)
                                            <hr>
                                            <h6>Bidang Keahlian</h6>
                                            <p class="small">{{ $user->guru->bidang_keahlian }}</p>
                                        @endif

                                        <!-- Mata Pelajaran yang diajar -->
                                        @if ($user->guru && $user->guru->mataPelajaran->count() > 0)
                                            <hr>
                                            <h6>Mata Pelajaran</h6>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($user->guru->mataPelajaran as $mapel)
                                                    <span class="badge bg-info">{{ $mapel->nama }}</span>
                                                @endforeach
                                            </div>
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
                                            <div class="d-flex gap-2">
                                                @if ($user->fb)
                                                    <a href="{{ $user->fb }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fab fa-facebook"></i>
                                                    </a>
                                                @endif
                                                @if ($user->ig)
                                                    <a href="{{ $user->ig }}" target="_blank"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                @endif
                                                @if ($user->x)
                                                    <a href="{{ $user->x }}" target="_blank"
                                                        class="btn btn-sm btn-outline-dark">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                @endif
                                                @if ($user->li)
                                                    <a href="{{ $user->li }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fab fa-linkedin"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Delete Account -->
                                <div class="card border-danger mt-4">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="mb-0">Zona Berbahaya</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-danger">Menghapus akun akan menghilangkan semua data secara
                                            permanen.</p>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteAccountModal">
                                            Hapus Akun
                                        </button>
                                    </div>
                                </div>
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
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Masukkan Password untuk Konfirmasi</label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger">Hapus Akun</button>
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
    </style>
@endsection
