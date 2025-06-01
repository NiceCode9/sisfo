@extends('landing.guest')

@section('title', 'Home')

@section('content')
    <!-- Hero Section dengan Gradient dan Particles -->
    <section id="home"
        class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-purple-800 to-pink-700 text-white py-32 md:py-40">
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute top-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-blob">
            </div>
            <div
                class="absolute top-20 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:w-2/3 lg:w-1/2">
                <div class="mb-4">
                    <span
                        class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium border border-white/20">
                        🎓 Sekolah Unggulan Terakreditasi A
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    Membangun
                    <span
                        class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">Generasi</span>
                    <br>
                    <span class="bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">Unggul</span>
                    dan
                    <span
                        class="bg-gradient-to-r from-purple-400 to-pink-500 bg-clip-text text-transparent">Berakhlak</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed">
                    SMP Harapan Bangsa memberikan pendidikan terbaik dengan teknologi modern untuk mempersiapkan siswa
                    menghadapi tantangan masa depan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#pendaftaran"
                        class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-pink-500 rounded-xl font-semibold text-white shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <span class="relative z-10">Daftar Sekarang</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-orange-600 to-pink-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <a href="#about"
                        class="group inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm rounded-xl font-semibold text-white border border-white/20 transition-all duration-300 hover:bg-white/20 hover:scale-105">
                        Tentang Kami
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/60 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section dengan Glass Morphism -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-block px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium mb-4">
                    ✨ Keunggulan Kami
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-6">
                    Mengapa Memilih Kami?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Kami memberikan yang terbaik untuk perkembangan akademik dan karakter siswa dengan pendekatan modern dan
                    holistik
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="group relative bg-white/70 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 hover:rotate-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative">
                        <div
                            class="bg-gradient-to-br from-blue-500 to-purple-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 mx-auto transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Guru Berkualitas</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Guru-guru profesional dan berpengalaman dengan
                            sertifikasi internasional di bidangnya masing-masing.</p>
                        <div class="mt-6 text-center">
                            <span
                                class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                Rating 4.9/5
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative bg-white/70 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 hover:rotate-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative">
                        <div
                            class="bg-gradient-to-br from-green-500 to-teal-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 mx-auto transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-laptop-code text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Fasilitas Modern</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Laboratorium berteknologi tinggi, perpustakaan
                            digital, dan fasilitas pembelajaran berbasis AI.</p>
                        <div class="mt-6 text-center">
                            <span
                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Terakreditasi A
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative bg-white/70 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 hover:rotate-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-red-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative">
                        <div
                            class="bg-gradient-to-br from-pink-500 to-red-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 mx-auto transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-heart text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Pendidikan Karakter</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Pembentukan karakter dan akhlak mulia dengan
                            program mentoring personal dan aktivitas sosial.</p>
                        <div class="mt-6 text-center">
                            <span
                                class="inline-flex items-center px-3 py-1 bg-pink-100 text-pink-800 text-sm font-medium rounded-full">
                                <i class="fas fa-award text-pink-500 mr-1"></i>
                                100% Lulus
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div class="transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-bold mb-2">28+</div>
                    <div class="text-white/80">Tahun Pengalaman</div>
                </div>
                <div class="transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-bold mb-2">500+</div>
                    <div class="text-white/80">Siswa Aktif</div>
                </div>
                <div class="transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-bold mb-2">98%</div>
                    <div class="text-white/80">Tingkat Kelulusan</div>
                </div>
                <div class="transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-bold mb-2">50+</div>
                    <div class="text-white/80">Penghargaan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section dengan Card Modern -->
    <section id="berita" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-medium mb-4">
                    📰 Berita Terkini
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-6">
                    Kabar Terbaru
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Informasi terbaru seputar kegiatan dan prestasi SMP
                    Harapan Bangsa</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <article
                    class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                            alt="Berita 1"
                            class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">🏆
                                PRESTASI</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            15 Juni 2023
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-indigo-600 transition-colors duration-300">
                            Siswa SMP Harapan Bangsa Juara Olimpiade Matematika Nasional
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">Tim matematika SMP Harapan Bangsa berhasil meraih
                            medali emas dalam Olimpiade Matematika Tingkat Nasional.</p>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-300">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </article>

                <article
                    class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                            alt="Berita 2"
                            class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">📚
                                KEGIATAN</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            5 Juni 2023
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-indigo-600 transition-colors duration-300">
                            Kegiatan Study Tour ke Museum Nasional
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">Siswa kelas 7 melakukan study tour edukatif ke Museum
                            Nasional untuk memperluas wawasan sejarah.</p>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-300">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </article>

                <article
                    class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                            alt="Berita 3"
                            class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">🖥️
                                TEKNOLOGI</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            28 Mei 2023
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-indigo-600 transition-colors duration-300">
                            Workshop Literasi Digital untuk Siswa
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">SMP Harapan Bangsa menyelenggarakan workshop literasi
                            digital untuk meningkatkan kesadaran siswa tentang penggunaan internet yang sehat.</p>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-300">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </article>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    Lihat Semua Berita
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section dengan Masonry Layout -->
    <section id="gallery" class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-medium mb-4">
                    📸 Galeri Kegiatan
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-6">
                    Momen Berharga
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Momen-momen berharga dalam kegiatan belajar mengajar di
                    SMP Harapan Bangsa</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div
                    class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                        alt="Gallery 7"
                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="font-semibold">Olahraga</p>
                    </div>
                </div>

                <div
                    class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                        alt="Gallery 8"
                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="font-semibold">Prestasi</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    Lihat Galeri Lengkap
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section dengan Timeline dan Interactive Elements -->
    <section id="about" class="py-20 bg-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex items-center gap-16">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl opacity-20 blur-xl">
                        </div>
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                            alt="Tentang Kami"
                            class="relative rounded-3xl shadow-2xl w-full transform hover:scale-105 transition-transform duration-500">

                        <!-- Floating Stats Cards -->
                        <div
                            class="absolute -top-6 -right-6 bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-white/20">
                            <div class="text-2xl font-bold text-indigo-600">28+</div>
                            <div class="text-sm text-gray-600">Tahun</div>
                        </div>

                        <div
                            class="absolute -bottom-6 -left-6 bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-white/20">
                            <div class="text-2xl font-bold text-green-600">A</div>
                            <div class="text-sm text-gray-600">Akreditasi</div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2">
                    <div
                        class="inline-block px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium mb-4">
                        🏫 Tentang Kami
                    </div>

                    <h2
                        class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-6">
                        SMP Harapan Bangsa
                    </h2>

                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        SMP Harapan Bangsa didirikan pada tahun 1995 dengan visi menjadi lembaga pendidikan unggulan yang
                        menghasilkan generasi berkarakter, berprestasi, dan berwawasan global.
                    </p>

                    <!-- Vision & Mission dengan Modern Cards -->
                    <div class="space-y-8">
                        <div class="group relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="relative bg-white/50 backdrop-blur-sm border border-gray-100 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-purple-600 p-4 rounded-2xl mr-6 transform group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-bullseye text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Visi</h3>
                                        <p class="text-gray-600 leading-relaxed">"Menjadi sekolah unggulan yang
                                            menghasilkan lulusan berkarakter mulia, berprestasi akademik, dan siap
                                            menghadapi tantangan global."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="relative bg-white/50 backdrop-blur-sm border border-gray-100 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 bg-gradient-to-br from-green-500 to-teal-600 p-4 rounded-2xl mr-6 transform group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-tasks text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Misi</h3>
                                        <div class="space-y-3">
                                            <div class="flex items-start">
                                                <div
                                                    class="w-2 h-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mt-2 mr-3 flex-shrink-0">
                                                </div>
                                                <p class="text-gray-600">Menyelenggarakan pendidikan berkualitas dengan
                                                    pendekatan holistik</p>
                                            </div>
                                            <div class="flex items-start">
                                                <div
                                                    class="w-2 h-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mt-2 mr-3 flex-shrink-0">
                                                </div>
                                                <p class="text-gray-600">Mengembangkan karakter dan akhlak mulia siswa</p>
                                            </div>
                                            <div class="flex items-start">
                                                <div
                                                    class="w-2 h-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mt-2 mr-3 flex-shrink-0">
                                                </div>
                                                <p class="text-gray-600">Mendorong kreativitas dan inovasi dalam
                                                    pembelajaran</p>
                                            </div>
                                            <div class="flex items-start">
                                                <div
                                                    class="w-2 h-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mt-2 mr-3 flex-shrink-0">
                                                </div>
                                                <p class="text-gray-600">Mempersiapkan siswa untuk kompetisi global</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="mt-8">
                        <a href="#pendaftaran"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            Bergabung Dengan Kami
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section dengan Modern Design -->
    <section class="py-20 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-blue-500/20 rounded-full mix-blend-multiply filter blur-3xl animate-pulse">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-multiply filter blur-3xl animate-pulse animation-delay-2000">
            </div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div
                class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6 border border-white/20">
                🚀 Mulai Perjalanan Pendidikan
            </div>

            <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Siap Menjadi Bagian dari
                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">Keluarga
                    Besar</span>
                <br>SMP Harapan Bangsa?
            </h2>

            <p class="text-xl md:text-2xl text-white/90 mb-8 leading-relaxed max-w-3xl mx-auto">
                Bergabunglah dengan ribuan alumni sukses yang telah memulai perjalanan mereka dari SMP Harapan Bangsa. Masa
                depan cerah menanti Anda!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#pendaftaran"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-bold text-lg shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-yellow-500/25">
                    <span class="mr-2">🎓</span>
                    Daftar Sekarang
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>

                <a href="#kontak"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-lg border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                    <span class="mr-2">📞</span>
                    Hubungi Kami
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Custom CSS untuk Animasi -->
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Hover effects */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        .group:hover .group-hover\:rotate-12 {
            transform: rotate(12deg);
        }

        /* Gradient text animation */
        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }
    </style>
@endsection
