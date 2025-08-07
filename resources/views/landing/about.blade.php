@extends('landing.guest')

@section('title', 'Tentang Kami')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen hero-bg flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-secondary/80 to-accent/90"></div>

        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent/10 rounded-full blur-3xl animate-pulse animation-delay-1000">
            </div>
        </div>

        <div class="relative z-10 text-center px-4">
            <div class="animate-fade-in">
                <h1
                    class="text-6xl md:text-8xl font-bold mb-6 bg-gradient-to-r from-white to-accent bg-clip-text text-transparent">
                    Tentang <span class="text-accent drop-shadow-lg">Kami</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90 leading-relaxed">
                    Mengenal lebih dekat {{ $profile->nama_sekolah ?? 'SMP Harapan Bangsa' }} -
                    Institusi pendidikan yang berkomitmen membentuk generasi masa depan
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#profil"
                        class="bg-accent hover:bg-accent/90 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <i class="fas fa-rocket mr-2"></i>
                        Jelajahi Profil
                    </a>
                    <a href="#kontak"
                        class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 border border-white/20">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <a href="#profil" class="flex flex-col items-center text-white/80 hover:text-white transition-colors">
                <span class="text-sm mb-2">Scroll Down</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                </div>
            </a>
        </div>
    </section>

    <!-- Profile Overview -->
    <section id="profil" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <div class="mb-8">
                        <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                            <i class="fas fa-school text-primary text-2xl"></i>
                        </div>
                        <h2 class="text-5xl font-bold text-dark mb-6 leading-tight">
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
                                class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark">Alamat</h4>
                                    <p class="text-gray-600">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-accent to-primary rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-dark">Telepon</h4>
                                        <p class="text-gray-600">{{ $profile->telp ?? '(031) 1234567' }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-success to-accent rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-dark">Email</h4>
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
                            class="bg-gradient-to-br from-primary to-secondary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">{{ date('Y') - ($profile->tahun_berdiri ?? 1985) }}</div>
                            <div class="text-sm opacity-90">Tahun Pengalaman</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-accent to-primary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">500+</div>
                            <div class="text-sm opacity-90">Siswa Aktif</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-success from-primary to-accent text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">30+</div>
                            <div class="text-sm opacity-90">Tenaga Pengajar</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-chalkboard-teacher text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-secondary to-primary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
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
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-bullseye text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Visi & Misi</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Komitmen kami untuk memberikan pendidikan terbaik dengan landasan nilai-nilai yang kuat
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="animate-slide-up">
                    <div
                        class="bg-gradient-to-br from-primary/5 to-secondary/5 rounded-2xl shadow-xl p-8 h-full border border-primary/10 hover:shadow-2xl transition-shadow">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-eye text-white text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-dark">Visi</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $profile->visi ?? 'Menjadi sekolah unggulan yang menghasilkan generasi berakhlak mulia, berprestasi, dan siap menghadapi tantangan global dengan berlandaskan nilai-nilai Pancasila dan kemajuan teknologi.' }}
                        </p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="animate-slide-up animation-delay-200">
                    <div
                        class="bg-gradient-to-br from-secondary/5 to-accent/5 rounded-2xl shadow-xl p-8 h-full border border-secondary/10 hover:shadow-2xl transition-shadow">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-secondary to-accent rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-dark">Misi</h3>
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
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-user-tie text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Kepala Sekolah</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pemimpin yang berdedikasi untuk kemajuan dan inovasi dalam dunia pendidikan
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-12 border border-gray-100">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div class="text-center lg:text-left">
                            <div class="relative inline-block">
                                <div
                                    class="w-64 h-64 bg-gradient-to-br from-primary via-secondary to-accent rounded-2xl mx-auto lg:mx-0 mb-6 flex items-center justify-center shadow-2xl">
                                    <i class="fas fa-user-tie text-white text-8xl"></i>
                                </div>
                                <div
                                    class="absolute -bottom-4 -right-4 w-16 h-16 bg-accent rounded-full flex items-center justify-center shadow-xl">
                                    <i class="fas fa-star text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-4xl font-bold text-dark mb-2">
                                {{ $profile->nama_kepsek ?? 'Drs. Ahmad Sugiarto, M.Pd' }}
                            </h3>
                            <p class="text-primary font-semibold text-xl mb-6">Kepala Sekolah</p>
                            <div
                                class="bg-gradient-to-r from-primary/5 to-secondary/5 p-6 rounded-xl border-l-4 border-primary mb-8">
                                <i class="fas fa-quote-left text-primary text-2xl mb-4"></i>
                                <p class="text-gray-600 leading-relaxed text-lg italic">
                                    "Pendidikan adalah investasi terbaik untuk masa depan. Kami berkomitmen untuk memberikan
                                    pendidikan yang berkualitas dan membentuk karakter siswa yang berakhlak mulia, siap
                                    menghadapi tantangan zaman."
                                </p>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="text-center p-4 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-xl">
                                    <div class="text-3xl font-bold text-primary mb-1">15+</div>
                                    <div class="text-sm text-gray-600">Tahun Pengalaman</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-secondary/10 to-accent/10 rounded-xl">
                                    <div class="text-3xl font-bold text-secondary mb-1">S2</div>
                                    <div class="text-sm text-gray-600">Pendidikan</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-accent/10 to-success/10 rounded-xl">
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
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-building text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Fasilitas</h2>
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
                            'color' => 'from-primary to-secondary',
                        ],
                        [
                            'icon' => 'fas fa-microscope',
                            'title' => 'Laboratorium',
                            'desc' => 'Lab IPA dan komputer dengan peralatan modern untuk praktikum',
                            'color' => 'from-secondary to-accent',
                        ],
                        [
                            'icon' => 'fas fa-book',
                            'title' => 'Perpustakaan',
                            'desc' => 'Perpustakaan dengan koleksi buku lengkap dan area baca yang nyaman',
                            'color' => 'from-accent to-success',
                        ],
                        [
                            'icon' => 'fas fa-running',
                            'title' => 'Lapangan Olahraga',
                            'desc' => 'Lapangan basket, voli, dan area olahraga lainnya',
                            'color' => 'from-success to-primary',
                        ],
                        [
                            'icon' => 'fas fa-utensils',
                            'title' => 'Kantin',
                            'desc' => 'Kantin sehat dengan menu bergizi untuk siswa',
                            'color' => 'from-primary to-accent',
                        ],
                        [
                            'icon' => 'fas fa-mosque',
                            'title' => 'Mushola',
                            'desc' => 'Mushola yang nyaman untuk kegiatan ibadah siswa',
                            'color' => 'from-secondary to-success',
                        ],
                    ];
                @endphp

                @foreach ($facilities as $facility)
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg p-8 h-full hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            <div
                                class="w-16 h-16 bg-gradient-to-br {{ $facility['color'] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $facility['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-dark mb-3">{{ $facility['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $facility['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lokasi & Peta -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-map-marked-alt text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Lokasi Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan lokasi sekolah kami yang strategis dan mudah diakses
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-slide-up">
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <h3 class="text-2xl font-bold text-dark mb-6">Informasi Lokasi</h3>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark mb-2">Alamat Lengkap</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-accent to-success rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-route text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark mb-2">Akses Transportasi</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                        Mudah diakses dengan transportasi umum, dekat dengan halte bus dan stasiun
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-success to-primary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-parking text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark mb-2">Fasilitas Parkir</h4>
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
                    <div class="bg-white rounded-2xl shadow-xl p-4 border border-gray-100">
                        <div class="aspect-video rounded-xl overflow-hidden">
                            @if (!empty($profile->map))
                                <iframe src="{{ $profile->map }}" width="100%" height="100%" style="border:0;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    class="rounded-xl">
                                </iframe>
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-xl">
                                    <div class="text-center">
                                        <i class="fas fa-map-marked-alt text-gray-400 text-4xl mb-4"></i>
                                        <p class="text-gray-500">Peta akan ditampilkan di sini</p>
                                        <p class="text-gray-400 text-sm mt-2">Silakan hubungi admin untuk mengatur peta</p>
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

    <!-- Kontak -->
    <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-phone text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Hubungi Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda dengan informasi yang dibutuhkan
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <!-- Contact Info -->
                    <div class="space-y-6">
                        <div
                            class="bg-gradient-to-r from-primary/5 to-secondary/5 p-6 rounded-2xl border border-primary/10 hover:shadow-lg transition-shadow">
                            <div class="flex items-center">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Alamat</h4>
                                    <p class="text-gray-600">
                                        {{ $profile->alamat ?? 'Jl. Pendidikan No. 123, Surabaya, Jawa Timur' }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-r from-secondary/5 to-accent/5 p-6 rounded-2xl border border-secondary/10 hover:shadow-lg transition-shadow">
                            <div class="flex items-center">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Telepon</h4>
                                    <p class="text-gray-600">{{ $profile->telp ?? '(031) 1234567' }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-r from-accent/5 to-success/5 p-6 rounded-2xl border border-accent/10 hover:shadow-lg transition-shadow">
                            <div class="flex items-center">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-accent to-success rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Email</h4>
                                    <p class="text-gray-600">{{ $profile->email ?? 'info@smpharapanbangsa.sch.id' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <h4 class="font-semibold text-dark text-lg mb-6">Media Sosial</h4>
                        <div class="flex space-x-4">
                            @if (!empty($profile->sosmed))
                                @foreach ($profile->sosmed as $platform => $url)
                                    <a href="{{ $url }}" target="_blank"
                                        class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:scale-110">
                                        @if ($platform === 'facebook')
                                            <i class="fab fa-facebook text-white"></i>
                                        @elseif ($platform === 'instagram')
                                            <i class="fab fa-instagram text-white"></i>
                                        @elseif ($platform === 'twitter')
                                            <i class="fab fa-twitter text-white"></i>
                                        @elseif ($platform === 'youtube')
                                            <i class="fab fa-youtube text-white"></i>
                                        @elseif ($platform === 'whatsapp')
                                            <i class="fab fa-whatsapp text-white"></i>
                                        @else
                                            <i class="fas fa-link text-white"></i>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                <div class="text-gray-500 text-sm">Media sosial akan ditampilkan di sini</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-dark mb-6">Kirim Pesan</h3>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white font-semibold py-4 px-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>

                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl border-l-4 border-primary">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Pesan Anda akan direspon dalam 1x24 jam pada hari kerja
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary via-secondary to-accent relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse animation-delay-1000">
            </div>
        </div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-5xl font-bold text-white mb-6">Bergabunglah dengan Kami</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Jadilah bagian dari komunitas pendidikan yang berkualitas dan raih masa depan yang gemilang bersama kami
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pendaftaran') }}"
                    class="bg-white text-primary px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Daftar Sekarang
                </a>
                <a href=""
                    class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white/30 transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <i class="fas fa-images mr-2"></i>
                    Lihat Galeri
                </a>
            </div>
        </div>
    </section>

    <!-- Custom CSS for animations -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading state for images */
        img {
            transition: opacity 0.3s ease;
        }

        img:not([src]) {
            opacity: 0;
        }

        /* Hover effects */
        .hover\:shadow-2xl:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
    </style>

    <!-- Optional JavaScript for enhanced interactions -->
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

        // Intersection Observer for scroll animations
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

        // Observe all elements with slide-up animation
        document.querySelectorAll('.animate-slide-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(50px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });

        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            button.disabled = true;

            // Simulate form submission (replace with actual form handling)
            setTimeout(() => {
                alert('Pesan Anda telah terkirim! Kami akan segera merespon.');
                button.innerHTML = originalText;
                button.disabled = false;
                this.reset();
            }, 2000);
        });
    </script>
@endsection
