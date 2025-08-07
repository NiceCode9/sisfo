@extends('landing.guest')

@section('title', 'Tentang Kami')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen hero-bg flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-secondary/80 to-accent/90"></div>

        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent/20 rounded-full blur-3xl animate-pulse animation-delay-1000">
            </div>
            <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-secondary/10 rounded-full blur-2xl animate-float"></div>
        </div>

        <div class="relative z-10 text-center px-4">
            <div class="animate-fade-in">
                <h1
                    class="text-6xl md:text-8xl font-bold mb-6 bg-gradient-to-r from-white via-accent to-white bg-clip-text text-transparent">
                    Tentang <span class="text-accent drop-shadow-lg animate-pulse">Kami</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90 leading-relaxed">
                    Mengenal lebih dekat {{ $profile->nama_sekolah ?? 'SMP Harapan Bangsa' }} -
                    Institusi pendidikan yang berkomitmen membentuk generasi masa depan
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#profil"
                        class="bg-gradient-to-r from-accent to-orange-500 hover:from-orange-500 hover:to-accent text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <i class="fas fa-rocket mr-2"></i>
                        Jelajahi Profil
                    </a>
                    <a href="#kontak"
                        class="bg-gradient-to-r from-white/20 to-white/30 hover:from-white/30 hover:to-white/40 backdrop-blur-sm text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 border border-white/20">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <a href="#profil" class="flex flex-col items-center text-white/80 hover:text-accent transition-colors">
                <span class="text-sm mb-2">Scroll Down</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-accent/60 rounded-full mt-2 animate-bounce"></div>
                </div>
            </a>
        </div>
    </section>

    <!-- Profile Overview -->
    <section id="profil" class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <div class="mb-8">
                        <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                            <i class="fas fa-school text-primary text-2xl"></i>
                        </div>
                        <h2
                            class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6 leading-tight">
                            {{ $profile->nama_sekolah ?? 'SMP Harapan Bangsa' }}
                        </h2>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Berdiri sejak tahun {{ $profile->tahun_berdiri ?? '1985' }}, kami telah menjadi pionir dalam
                            dunia pendidikan di Surabaya.
                            Dengan pengalaman lebih dari {{ date('Y') - ($profile->tahun_berdiri ?? 1985) }} tahun,
                            kami terus berinovasi untuk memberikan pendidikan terbaik.
                        </p>

                        <!-- Contact info cards -->
                        <div class="space-y-4">
                            <div
                                class="flex items-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-primary/10 hover:border-primary/20">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary via-blue-500 to-secondary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Alamat</h4>
                                    <p class="text-gray-600">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="flex items-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-accent/10 hover:border-accent/20">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-accent via-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Telepon</h4>
                                        <p class="text-gray-600">{{ $profile->telp ?? '(031) 1234567' }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-green-200 hover:border-green-300">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Email</h4>
                                        <p class="text-gray-600">{{ $profile->email ?? 'info@smpharapanbangsa.sch.id' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="animate-slide-up animation-delay-200">
                    <div class="grid grid-cols-2 gap-6">
                        <div
                            class="bg-gradient-to-br from-primary via-blue-500 to-secondary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-2xl">
                            <div class="text-4xl font-bold mb-2">{{ date('Y') - ($profile->tahun_berdiri ?? 1985) }}</div>
                            <div class="text-sm opacity-90">Tahun Pengalaman</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-accent via-yellow-500 to-orange-500 text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-2xl">
                            <div class="text-4xl font-bold mb-2">500+</div>
                            <div class="text-sm opacity-90">Siswa Aktif</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-2xl">
                            <div class="text-4xl font-bold mb-2">{{ $guruCount }}</div>
                            <div class="text-sm opacity-90">Tenaga Pengajar</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-chalkboard-teacher text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-purple-500 via-pink-500 to-rose-500 text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-2xl">
                            <div class="text-4xl font-bold mb-2">A</div>
                            <div class="text-sm opacity-90">Akreditasi</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-medal text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="py-20 bg-gradient-to-br from-white via-gray-50 to-blue-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-bullseye text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Visi & Misi</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Komitmen kami untuk memberikan pendidikan terbaik dengan landasan nilai-nilai yang kuat
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="animate-slide-up">
                    <div
                        class="bg-gradient-to-br from-primary/10 via-blue-50 to-secondary/10 rounded-2xl shadow-xl p-8 h-full border-2 border-primary/20 hover:shadow-2xl hover:border-primary/30 transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-primary via-blue-500 to-secondary rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-eye text-white text-2xl"></i>
                            </div>
                            <h3
                                class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                                Visi</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $profile->visi ?? 'Menjadi sekolah unggulan yang menghasilkan generasi berakhlak mulia, berprestasi, dan siap menghadapi tantangan global dengan berlandaskan nilai-nilai Pancasila dan kemajuan teknologi.' }}
                        </p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="animate-slide-up animation-delay-200">
                    <div
                        class="bg-gradient-to-br from-secondary/10 via-purple-50 to-accent/10 rounded-2xl shadow-xl p-8 h-full border-2 border-secondary/20 hover:shadow-2xl hover:border-secondary/30 transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-secondary via-purple-500 to-accent rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                            <h3
                                class="text-3xl font-bold bg-gradient-to-r from-secondary to-accent bg-clip-text text-transparent">
                                Misi</h3>
                        </div>
                        <ul class="space-y-4">
                            @if (isset($profile) && !empty($profile->misi) && is_array($profile->misi))
                                @forelse ($profile->misi as $item)
                                    <li class="flex items-start">
                                        <div
                                            class="w-6 h-6 bg-success rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span class="text-gray-600 leading-relaxed">{{ $item }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 italic">Belum ada misi yang ditambahkan.</li>
                                @endforelse
                            @else
                                <li class="text-gray-400 italic">Data misi tidak tersedia.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kepala Sekolah -->
    <section class="py-20 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-user-tie text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Kepala Sekolah</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pemimpin yang berdedikasi untuk kemajuan dan inovasi dalam dunia pendidikan
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div
                    class="bg-white rounded-2xl shadow-2xl p-8 lg:p-12 border-2 border-primary/10 hover:border-primary/20 transition-all duration-300">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div class="text-center lg:text-left">
                            <div class="relative inline-block">
                                <div
                                    class="w-64 h-64 bg-gradient-to-br from-primary via-blue-500 via-secondary to-accent rounded-2xl mx-auto lg:mx-0 mb-6 flex items-center justify-center shadow-2xl">
                                    <i class="fas fa-user-tie text-white text-8xl"></i>
                                </div>
                                <div
                                    class="absolute -bottom-4 -right-4 w-16 h-16 bg-gradient-to-r from-accent to-orange-500 rounded-full flex items-center justify-center shadow-xl">
                                    <i class="fas fa-star text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-4xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                                {{ $profile->nama_kepsek ?? 'Drs. Ahmad Sugiarto, M.Pd' }}
                            </h3>
                            <p class="text-primary font-semibold text-xl mb-6">Kepala Sekolah</p>
                            <div
                                class="bg-gradient-to-r from-primary/10 to-secondary/10 p-6 rounded-xl border-l-4 border-primary mb-8">
                                <i class="fas fa-quote-left text-primary text-2xl mb-4"></i>
                                <p class="text-gray-600 leading-relaxed text-lg italic">
                                    "Pendidikan adalah investasi terbaik untuk masa depan. Kami berkomitmen untuk memberikan
                                    pendidikan yang berkualitas dan membentuk karakter siswa yang berakhlak mulia, siap
                                    menghadapi tantangan zaman."
                                </p>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div
                                    class="text-center p-4 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-xl border border-primary/20">
                                    <div class="text-3xl font-bold text-primary mb-1">15+</div>
                                    <div class="text-sm text-gray-600">Tahun Pengalaman</div>
                                </div>
                                <div
                                    class="text-center p-4 bg-gradient-to-br from-secondary/20 to-accent/20 rounded-xl border border-secondary/20">
                                    <div class="text-3xl font-bold text-secondary mb-1">S2</div>
                                    <div class="text-sm text-gray-600">Pendidikan</div>
                                </div>
                                <div
                                    class="text-center p-4 bg-gradient-to-br from-accent/20 to-orange-300 rounded-xl border border-accent/20">
                                    <div class="text-3xl font-bold text-accent mb-1">100+</div>
                                    <div class="text-sm text-gray-600">Prestasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="py-20 bg-gradient-to-br from-white via-blue-50 to-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-building text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Fasilitas</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Fasilitas modern dan lengkap untuk mendukung proses pembelajaran yang optimal
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $facilities = [
                        [
                            'icon' => 'fas fa-chalkboard-teacher',
                            'title' => 'Ruang Kelas',
                            'desc' => 'Ruang kelas yang nyaman dengan AC dan proyektor untuk pembelajaran interaktif',
                            'color' => 'from-primary via-blue-500 to-secondary',
                            'border' => 'border-primary/20',
                        ],
                        [
                            'icon' => 'fas fa-microscope',
                            'title' => 'Laboratorium',
                            'desc' => 'Lab IPA dan komputer dengan peralatan modern untuk praktikum',
                            'color' => 'from-secondary via-purple-500 to-accent',
                            'border' => 'border-secondary/20',
                        ],
                        [
                            'icon' => 'fas fa-book',
                            'title' => 'Perpustakaan',
                            'desc' => 'Perpustakaan dengan koleksi buku lengkap dan area baca yang nyaman',
                            'color' => 'from-accent via-yellow-500 to-orange-500',
                            'border' => 'border-accent/20',
                        ],
                        [
                            'icon' => 'fas fa-running',
                            'title' => 'Lapangan Olahraga',
                            'desc' => 'Lapangan basket, voli, dan area olahraga lainnya',
                            'color' => 'from-green-500 via-emerald-500 to-teal-500',
                            'border' => 'border-green-300',
                        ],
                        [
                            'icon' => 'fas fa-utensils',
                            'title' => 'Kantin',
                            'desc' => 'Kantin sehat dengan menu bergizi untuk siswa',
                            'color' => 'from-pink-500 via-rose-500 to-red-500',
                            'border' => 'border-pink-300',
                        ],
                        [
                            'icon' => 'fas fa-mosque',
                            'title' => 'Mushola',
                            'desc' => 'Mushola yang nyaman untuk kegiatan ibadah siswa',
                            'color' => 'from-indigo-500 via-purple-500 to-pink-500',
                            'border' => 'border-indigo-300',
                        ],
                    ];
                @endphp

                @foreach ($facilities as $facility)
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg p-8 h-full hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 {{ $facility['border'] }} hover:border-opacity-50">
                            <div
                                class="w-16 h-16 bg-gradient-to-br {{ $facility['color'] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="{{ $facility['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $facility['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $facility['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lokasi & Peta -->
    <section class="py-20 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-map-marked-alt text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Lokasi Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan lokasi sekolah kami yang strategis dan mudah diakses
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-slide-up">
                    <div
                        class="bg-white rounded-2xl shadow-xl p-8 border-2 border-primary/10 hover:border-primary/20 transition-all duration-300">
                        <h3
                            class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                            Informasi Lokasi</h3>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary via-blue-500 to-secondary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Alamat Lengkap</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-accent via-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-route text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Akses Transportasi</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                        Mudah diakses dengan transportasi umum, dekat dengan halte bus dan stasiun
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-parking text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Fasilitas Parkir</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                        Area parkir yang luas dan aman untuk kendaraan siswa dan orang tua
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-8 p-4 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl border-l-4 border-primary">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle text-primary mr-2"></i>
                                Untuk petunjuk arah lebih detail, silakan klik tombol "Lihat di Google Maps" di bawah peta
                            </p>
                        </div>
                    </div>
                </div>

                <div class="animate-slide-up animation-delay-200">
                    <div
                        class="bg-white rounded-2xl shadow-xl p-4 border-2 border-primary/10 hover:border-primary/20 transition-all duration-300">
                        <div class="aspect-video rounded-xl overflow-hidden">
                            @if (!empty($profile->map))
                                <iframe src="{{ $profile->map }}" width="100%" height="100%" style="border:0;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    class="rounded-xl">
                                </iframe>
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-primary/20 via-secondary/20 to-accent/20 flex items-center justify-center rounded-xl">
                                    <div class="text-center">
                                        <i class="fas fa-map-marked-alt text-primary text-4xl mb-4"></i>
                                        <p class="text-gray-600 font-semibold">Peta akan ditampilkan di sini</p>
                                        <p class="text-gray-500 text-sm mt-2">Silakan hubungi admin untuk mengatur peta</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if (!empty($profile->map))
                            <div class="mt-4 text-center">
                                <a href="{{ $profile->map }}" target="_blank"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Lihat di Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Prestasi -->
    <section class="py-20 bg-gradient-to-br from-white via-purple-50 to-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-trophy text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Prestasi</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Berbagai prestasi yang telah diraih siswa-siswi kami di tingkat lokal, nasional, dan internasional
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $achievements = [
                        [
                            'icon' => 'fas fa-medal',
                            'title' => 'Juara 1 Olimpiade Matematika',
                            'desc' => 'Tingkat Provinsi Jawa Timur',
                            'year' => '2024',
                            'color' => 'from-yellow-500 via-yellow-400 to-yellow-300',
                            'border' => 'border-yellow-300',
                        ],
                        [
                            'icon' => 'fas fa-trophy',
                            'title' => 'Juara 2 Lomba Karya Ilmiah',
                            'desc' => 'Tingkat Nasional',
                            'year' => '2024',
                            'color' => 'from-gray-400 via-gray-300 to-gray-200',
                            'border' => 'border-gray-300',
                        ],
                        [
                            'icon' => 'fas fa-star',
                            'title' => 'Juara 3 Kompetisi Robotika',
                            'desc' => 'Tingkat Regional',
                            'year' => '2023',
                            'color' => 'from-orange-600 via-orange-500 to-orange-400',
                            'border' => 'border-orange-300',
                        ],
                        [
                            'icon' => 'fas fa-award',
                            'title' => 'Sekolah Adiwiyata',
                            'desc' => 'Tingkat Provinsi',
                            'year' => '2023',
                            'color' => 'from-green-500 via-green-400 to-green-300',
                            'border' => 'border-green-300',
                        ],
                        [
                            'icon' => 'fas fa-crown',
                            'title' => 'Juara 1 Debat Bahasa Inggris',
                            'desc' => 'Tingkat Kota Surabaya',
                            'year' => '2023',
                            'color' => 'from-purple-500 via-purple-400 to-purple-300',
                            'border' => 'border-purple-300',
                        ],
                        [
                            'icon' => 'fas fa-graduation-cap',
                            'title' => 'Sekolah Berprestasi',
                            'desc' => 'Dinas Pendidikan Jawa Timur',
                            'year' => '2022',
                            'color' => 'from-blue-500 via-blue-400 to-blue-300',
                            'border' => 'border-blue-300',
                        ],
                    ];
                @endphp

                @foreach ($achievements as $achievement)
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg p-8 h-full hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 {{ $achievement['border'] }} hover:border-opacity-50 relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $achievement['color'] }} rounded-bl-3xl flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ $achievement['year'] }}</span>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br {{ $achievement['color'] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="{{ $achievement['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $achievement['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $achievement['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-20 bg-gradient-to-br from-primary/10 via-secondary/10 to-accent/10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl mb-4">
                    <i class="fas fa-envelope text-primary text-2xl"></i>
                </div>
                <h2
                    class="text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-6">
                    Hubungi Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Jangan ragu untuk menghubungi kami untuk informasi lebih lanjut tentang pendaftaran dan program sekolah
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <div class="animate-slide-up">
                    <div
                        class="bg-white rounded-2xl shadow-xl p-8 border-2 border-primary/10 hover:border-primary/20 transition-all duration-300">
                        <h3
                            class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-8">
                            Informasi Kontak</h3>

                        <div class="space-y-6">
                            <div class="flex items-center p-4 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary via-blue-500 to-secondary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Telepon</h4>
                                    <p class="text-gray-600">{{ $profile->telp ?? '(031) 1234567' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gradient-to-r from-secondary/10 to-accent/10 rounded-xl">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-secondary via-purple-500 to-accent rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Email</h4>
                                    <p class="text-gray-600">{{ $profile->email ?? 'info@smpharapanbangsa.sch.id' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start p-4 bg-gradient-to-r from-accent/10 to-orange-200 rounded-xl">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-accent via-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Alamat</h4>
                                    <p class="text-gray-600">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Jam Operasional</h4>
                                    <p class="text-gray-600">Senin - Jumat: 07.00 - 15.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="animate-slide-up animation-delay-200">
                    <div
                        class="bg-white rounded-2xl shadow-xl p-8 border-2 border-primary/10 hover:border-primary/20 transition-all duration-300">
                        <h3
                            class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-8">
                            Kirim Pesan</h3>

                        <form class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                                <input type="text" id="subject" name="subject"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                                <textarea id="message" name="message" rows="5"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300 resize-none"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 px-8 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary via-secondary to-accent text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse animation-delay-1000">
            </div>
        </div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-5xl font-bold mb-6 animate-fade-in">
                    Bergabunglah dengan Keluarga Besar Kami
                </h2>
                <p class="text-xl mb-8 opacity-90 leading-relaxed animate-slide-up">
                    Wujudkan impian pendidikan terbaik untuk anak Anda bersama
                    {{ $profile->nama_sekolah ?? 'SMP Harapan Bangsa' }}.
                    Daftar sekarang dan dapatkan informasi lengkap tentang program pendidikan kami.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-slide-up animation-delay-200">
                    <a href="{{ route('pendaftaran') }}"
                        class="bg-white text-primary px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="#"
                        class="bg-gradient-to-r from-white/20 to-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-full text-lg font-semibold hover:from-white/30 hover:to-white/40 transition-all duration-300 transform hover:scale-105 border border-white/20">
                        <i class="fas fa-download mr-2"></i>
                        Download Brosur
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 200% 200%;
            animation: gradientShift 6s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-1000 {
            animation-delay: 1000ms;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #3b82f6, #1e40af);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #1e40af, #3b82f6);
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.animate-slide-up, .animate-fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });

        // Form submission handler
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            // Simple validation
            if (!data.name || !data.email || !data.subject || !data.message) {
                alert('Mohon lengkapi semua field yang diperlukan');
                return;
            }

            // Simulate form submission
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitButton.disabled = true;

            setTimeout(() => {
                alert('Pesan berhasil dikirim! Terima kasih atas pertanyaan Anda.');
                this.reset();
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 2000);
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-bg');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>
@endsection
