@extends('landing.guest')

@section('title', 'Pendaftaran Siswa Baru')

@section('content')
    <section id="pendaftaran" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pendaftaran Siswa Baru</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Tahun Ajaran
                    {{ \Carbon\Carbon::now()->format('Y') }}/{{ \Carbon\Carbon::now()->addYear()->format('Y') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-primary p-12 text-white">
                        <h3 class="text-2xl font-bold mb-6">Persyaratan Pendaftaran</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-1 mr-3"></i>
                                <span>Fotokopi akte kelahiran dan kartu keluarga</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-1 mr-3"></i>
                                <span>Fotokopi rapor SD kelas 4-6</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-1 mr-3"></i>
                                <span>Pas foto 3x4 (3 lembar)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-1 mr-3"></i>
                                <span>Mengisi formulir pendaftaran</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-1 mr-3"></i>
                                <span>Mengikuti tes masuk (Matematika, IPA, Bahasa)</span>
                            </li>
                        </ul>

                        <div class="mt-10 bg-white bg-opacity-20 p-6 rounded-lg">
                            <h4 class="font-bold mb-3">Jadwal Penting</h4>
                            <p><i class="far fa-calendar-alt mr-2"></i> Pendaftaran: {{ $jadwalPendaftaran }}</p>
                            <p><i class="far fa-clock mr-2"></i> Tes Masuk: {{ $jadwalTesMasuk }}</p>
                            <p><i class="far fa-bell mr-2"></i> Pengumuman: {{ $jadwalPengumuman }}</p>
                        </div>
                    </div>

                    <div class="md:w-1/2 p-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Formulir Pendaftaran Online</h3>

                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                <!-- Data Pribadi -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-lg font-medium text-gray-800 mb-3">Data Pribadi</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nama_lengkap"
                                                class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap*</label>
                                            <input type="text" id="nama_lengkap" name="nama_lengkap" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('nama_lengkap') border-red-500 @enderror"
                                                value="{{ old('nama_lengkap') }}">
                                            @error('nama_lengkap')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="jenis_kelamin"
                                                class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin*</label>
                                            <select id="jenis_kelamin" name="jenis_kelamin" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('jenis_kelamin') border-red-500 @enderror">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Tambahkan field lainnya -->
                                </div>

                                <!-- Data Orang Tua -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-lg font-medium text-gray-800 mb-3">Data Orang Tua</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                Ayah*</label>
                                            <input type="text" id="nama_ayah" name="nama_ayah" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('nama_ayah') border-red-500 @enderror"
                                                value="{{ old('nama_ayah') }}">
                                            @error('nama_ayah')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pekerjaan_ayah"
                                                class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah*</label>
                                            <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('pekerjaan_ayah') border-red-500 @enderror"
                                                value="{{ old('pekerjaan_ayah') }}">
                                            @error('pekerjaan_ayah')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                Ibu*</label>
                                            <input type="text" id="nama_ibu" name="nama_ibu" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('nama_ibu') border-red-500 @enderror"
                                                value="{{ old('nama_ibu') }}">
                                            @error('nama_ibu')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pekerjaan_ibu"
                                                class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu*</label>
                                            <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('pekerjaan_ibu') border-red-500 @enderror"
                                                value="{{ old('pekerjaan_ibu') }}">
                                            @error('pekerjaan_ibu')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="no_hp_orang_tua"
                                                class="block text-sm font-medium text-gray-700 mb-1">No. HP Orang
                                                Tua*</label>
                                            <input type="tel" id="no_hp_orang_tua" name="no_hp_orang_tua" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('no_hp_orang_tua') border-red-500 @enderror"
                                                value="{{ old('no_hp_orang_tua') }}">
                                            @error('no_hp_orang_tua')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Berkas -->
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 mb-3">Upload Berkas</h4>

                                    <div class="space-y-4">

                                        <div>
                                            <label for="ijazah_path"
                                                class="block text-sm font-medium text-gray-700 mb-1">Upload Ijazah
                                                (PDF)*</label>
                                            <input type="file" id="ijazah_path" name="ijazah_path" accept=".pdf"
                                                required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('ijazah_path') border-red-500 @enderror">
                                            @error('ijazah_path')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="kk_path"
                                                class="block text-sm font-medium text-gray-700 mb-1">Upload Kartu Keluarga
                                                (PDF)*</label>
                                            <input type="file" id="kk_path" name="kk_path" accept=".pdf" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('kk_path') border-red-500 @enderror">
                                            @error('kk_path')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="akta_path"
                                                class="block text-sm font-medium text-gray-700 mb-1">Upload Akta Kelahiran
                                                (PDF)*</label>
                                            <input type="file" id="akta_path" name="akta_path" accept=".pdf"
                                                required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('akta_path') border-red-500 @enderror">
                                            @error('akta_path')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="foto_path"
                                                class="block text-sm font-medium text-gray-700 mb-1">Upload Pas Foto
                                                (JPG/PNG)*</label>
                                            <input type="file" id="foto_path" name="foto_path" accept="image/*"
                                                required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('foto_path') border-red-500 @enderror">
                                            @error('foto_path')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="skl_path"
                                                class="block text-sm font-medium text-gray-700 mb-1">Upload Surat
                                                Keterangan Lulus (PDF)*</label>
                                            <input type="file" id="skl_path" name="skl_path" accept=".pdf" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary @error('skl_path') border-red-500 @enderror">
                                            @error('skl_path')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-secondary text-white py-3 px-6 rounded-md font-medium transition duration-300 transform hover:scale-105">
                                        Daftar Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
