@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-school"></i> Management Profile Sekolah
                        </h4>
                    </div>
                    <div class="card-body">
                        {{-- Alert Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Profile Form --}}
                        <form
                            action="{{ $profile ? route('general-profile.update', $profile->id) : route('general-profile.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($profile)
                                @method('PUT')
                            @endif

                            <div class="row">
                                {{-- Informasi Dasar --}}
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Dasar</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="nama_sekolah" class="form-label">Nama Sekolah <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama_sekolah"
                                                    name="nama_sekolah"
                                                    value="{{ old('nama_sekolah', $profile->nama_sekolah ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_kepsek" class="form-label">Nama Kepala Sekolah <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama_kepsek"
                                                    name="nama_kepsek"
                                                    value="{{ old('nama_kepsek', $profile->nama_kepsek ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tahun_berdiri" class="form-label">Tahun Berdiri <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="tahun_berdiri"
                                                    name="tahun_berdiri"
                                                    value="{{ old('tahun_berdiri', $profile->tahun_berdiri ?? '') }}"
                                                    min="1900" max="{{ date('Y') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kontak & Media --}}
                                <div class="col-md-6">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-phone"></i> Kontak & Media</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="telp" class="form-label">Telepon <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="telp" name="telp"
                                                    value="{{ old('telp', $profile->telp ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email', $profile->email ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="map" class="form-label">Link Google Maps</label>
                                                <input type="url" class="form-control" id="map" name="map"
                                                    value="{{ old('map', $profile->map ?? '') }}"
                                                    placeholder="https://maps.google.com/...">
                                            </div>

                                            {{-- Logo & Favicon --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="logo" class="form-label">Logo Sekolah</label>
                                                        <input type="file" class="form-control" id="logo"
                                                            name="logo" accept="image/*">
                                                        @if ($profile && $profile->logo)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . $profile->logo) }}"
                                                                    alt="Logo" class="img-thumbnail"
                                                                    style="max-width: 100px;">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="favicon" class="form-label">Favicon</label>
                                                        <input type="file" class="form-control" id="favicon"
                                                            name="favicon" accept="image/*">
                                                        @if ($profile && $profile->favicon)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . $profile->favicon) }}"
                                                                    alt="Favicon" class="img-thumbnail"
                                                                    style="max-width: 50px;">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Sosial Media --}}
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0"><i class="fab fa-facebook"></i> Media Sosial</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="sosmed_facebook" class="form-label">
                                                            <i class="fab fa-facebook text-primary"></i> Facebook
                                                        </label>
                                                        <input type="url" class="form-control" id="sosmed_facebook"
                                                            name="sosmed[facebook]"
                                                            value="{{ old('sosmed.facebook', $profile->sosmed['facebook'] ?? '') }}"
                                                            placeholder="https://facebook.com/...">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="sosmed_instagram" class="form-label">
                                                            <i class="fab fa-instagram text-danger"></i> Instagram
                                                        </label>
                                                        <input type="url" class="form-control" id="sosmed_instagram"
                                                            name="sosmed[instagram]"
                                                            value="{{ old('sosmed.instagram', $profile->sosmed['instagram'] ?? '') }}"
                                                            placeholder="https://instagram.com/...">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="sosmed_youtube" class="form-label">
                                                            <i class="fab fa-youtube text-danger"></i> YouTube
                                                        </label>
                                                        <input type="url" class="form-control" id="sosmed_youtube"
                                                            name="sosmed[youtube]"
                                                            value="{{ old('sosmed.youtube', $profile->sosmed['youtube'] ?? '') }}"
                                                            placeholder="https://youtube.com/...">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="sosmed_twitter" class="form-label">
                                                            <i class="fab fa-twitter text-info"></i> Twitter
                                                        </label>
                                                        <input type="url" class="form-control" id="sosmed_twitter"
                                                            name="sosmed[twitter]"
                                                            value="{{ old('sosmed.twitter', $profile->sosmed['twitter'] ?? '') }}"
                                                            placeholder="https://twitter.com/...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Visi & Misi --}}
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="mb-0"><i class="fas fa-eye"></i> Visi</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <textarea class="form-control" id="visi" name="visi" rows="5" required
                                                    placeholder="Masukkan visi sekolah...">{{ old('visi', $profile->visi ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-secondary">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="mb-0"><i class="fas fa-bullseye"></i> Misi</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="misi-container">
                                                @if ($profile && $profile->misi)
                                                    @foreach ($profile->misi as $index => $misiItem)
                                                        <div class="mb-3 misi-item">
                                                            <label for="misi_{{ $index }}" class="form-label">Misi
                                                                {{ $index + 1 }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="misi_{{ $index }}" name="misi[{{ $index }}]" rows="2"
                                                                    required placeholder="Masukkan misi {{ $index + 1 }}...">{{ old('misi.' . $index, $misiItem) }}</textarea>
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-misi"
                                                                    onclick="removeMisi(this)" title="Hapus Misi">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="mb-3 misi-item">
                                                        <label for="misi_0" class="form-label">Misi 1</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" id="misi_0" name="misi[0]" rows="2" required
                                                                placeholder="Masukkan misi 1...">{{ old('misi.0') }}</textarea>
                                                            <button type="button"
                                                                class="btn btn-outline-danger remove-misi"
                                                                onclick="removeMisi(this)" title="Hapus Misi">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addMisi()">
                                                <i class="fas fa-plus"></i> Tambah Misi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save"></i>
                                            {{ $profile ? 'Update Profile' : 'Simpan Profile' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let misiCounter = {{ $profile && $profile->misi ? count($profile->misi) : 1 }};

        function addMisi() {
            const container = document.getElementById('misi-container');
            const newMisiItem = document.createElement('div');
            newMisiItem.className = 'mb-3 misi-item';
            newMisiItem.innerHTML = `
            <label for="misi_${misiCounter}" class="form-label">Misi ${misiCounter + 1}</label>
            <div class="input-group">
                <textarea class="form-control" id="misi_${misiCounter}"
                    name="misi[${misiCounter}]" rows="2" required
                    placeholder="Masukkan misi ${misiCounter + 1}..."></textarea>
                <button type="button" class="btn btn-outline-danger remove-misi"
                    onclick="removeMisi(this)" title="Hapus Misi">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
            container.appendChild(newMisiItem);
            misiCounter++;
            updateMisiLabels();
        }

        function removeMisi(button) {
            const misiItems = document.querySelectorAll('.misi-item');
            if (misiItems.length > 1) {
                button.closest('.misi-item').remove();
                updateMisiLabels();
            } else {
                alert('Minimal harus ada 1 misi!');
            }
        }

        function updateMisiLabels() {
            const misiItems = document.querySelectorAll('.misi-item');
            misiItems.forEach((item, index) => {
                const label = item.querySelector('label');
                const textarea = item.querySelector('textarea');
                const newId = `misi_${index}`;

                label.textContent = `Misi ${index + 1}`;
                label.setAttribute('for', newId);
                textarea.id = newId;
                textarea.name = `misi[${index}]`;
                textarea.placeholder = `Masukkan misi ${index + 1}...`;
            });
        }

        // Existing JavaScript for image previews and alerts...
        // Preview image before upload
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    const existingPreview = document.querySelector('#logo-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Create new preview
                    const preview = document.createElement('div');
                    preview.id = 'logo-preview';
                    preview.className = 'mt-2';
                    preview.innerHTML =
                        `<img src="${e.target.result}" alt="Logo Preview" class="img-thumbnail" style="max-width: 100px;">`;
                    document.getElementById('logo').parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('favicon').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    const existingPreview = document.querySelector('#favicon-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Create new preview
                    const preview = document.createElement('div');
                    preview.id = 'favicon-preview';
                    preview.className = 'mt-2';
                    preview.innerHTML =
                        `<img src="${e.target.result}" alt="Favicon Preview" class="img-thumbnail" style="max-width: 50px;">`;
                    document.getElementById('favicon').parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush

@push('styles')
    <style>
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
        }

        .img-thumbnail {
            border-radius: 8px;
        }
    </style>
@endpush
