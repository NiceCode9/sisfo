@extends('landing.guest')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-bg text-white py-32 md:py-40 animate-fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:w-2/3 lg:w-1/2">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-slide-up">Membangun Generasi <span
                        class="text-accent">Unggul</span> dan <span class="text-accent">Berakhlak</span></h1>
                <p class="text-lg md:text-xl mb-8 animate-slide-up animation-delay-100">SMP Harapan Bangsa memberikan
                    pendidikan terbaik untuk mempersiapkan siswa menghadapi tantangan masa depan.</p>
                <div class="flex flex-col sm:flex-row gap-4 animate-slide-up animation-delay-200">
                    <a href="#pendaftaran"
                        class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-md font-medium text-center transition duration-300 transform hover:scale-105">Daftar
                        Sekarang</a>
                    <a href="#about"
                        class="bg-white hover:bg-gray-100 text-primary px-6 py-3 rounded-md font-medium text-center transition duration-300 transform hover:scale-105">Tentang
                        Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Keunggulan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami memberikan yang terbaik untuk perkembangan
                    akademik dan karakter siswa</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-graduation-cap text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Guru Berkualitas</h3>
                    <p class="text-gray-600 text-center">Guru-guru profesional dan berpengalaman di bidangnya
                        masing-masing.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-laptop-code text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Fasilitas Modern</h3>
                    <p class="text-gray-600 text-center">Laboratorium, perpustakaan, dan fasilitas pendukung
                        pembelajaran yang lengkap.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-heart text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Pendidikan Karakter</h3>
                    <p class="text-gray-600 text-center">Pembentukan karakter dan akhlak mulia sebagai fondasi masa
                        depan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Berita Terkini</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Informasi terbaru seputar kegiatan dan prestasi SMP
                    Harapan Bangsa</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                        alt="Berita 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">15 Juni 2023</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Siswa SMP Harapan Bangsa Juara Olimpiade
                            Matematika Nasional</h3>
                        <p class="text-gray-600 mb-4">Tim matematika SMP Harapan Bangsa berhasil meraih medali emas
                            dalam Olimpiade Matematika Tingkat Nasional.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary">Baca Selengkapnya →</a>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                        alt="Berita 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">5 Juni 2023</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Kegiatan Study Tour ke Museum Nasional</h3>
                        <p class="text-gray-600 mb-4">Siswa kelas 7 melakukan study tour edukatif ke Museum Nasional
                            untuk memperluas wawasan sejarah.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary">Baca Selengkapnya →</a>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Berita 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">28 Mei 2023</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Workshop Literasi Digital untuk Siswa</h3>
                        <p class="text-gray-600 mb-4">SMP Harapan Bangsa menyelenggarakan workshop literasi digital
                            untuk meningkatkan kesadaran siswa tentang penggunaan internet yang sehat.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-block bg-primary hover:bg-secondary text-white px-6 py-3 rounded-md font-medium transition duration-300 transform hover:scale-105">Lihat
                    Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Galeri Kegiatan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Momen-momen berharga dalam kegiatan belajar mengajar
                    di SMP Harapan Bangsa</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Gallery 1" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Gallery 2" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                        alt="Gallery 3" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                        alt="Gallery 4" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Gallery 5" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Gallery 6" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                        alt="Gallery 7" class="w-full h-48 object-cover">
                </div>
                <div
                    class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                        alt="Gallery 8" class="w-full h-48 object-cover">
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-block bg-primary hover:bg-secondary text-white px-6 py-3 rounded-md font-medium transition duration-300 transform hover:scale-105">Lihat
                    Galeri Lengkap</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-12 md:mb-0 md:pr-12 animate-float">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Tentang Kami" class="rounded-lg shadow-xl w-full">
                </div>

                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Tentang SMP Harapan Bangsa</h2>
                    <p class="text-lg text-gray-600 mb-6">SMP Harapan Bangsa didirikan pada tahun 1995 dengan visi
                        menjadi lembaga pendidikan unggulan yang menghasilkan generasi berkarakter, berprestasi, dan
                        berwawasan global.</p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-bullseye text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Visi</h3>
                                <p class="text-gray-600">"Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter
                                    mulia, berprestasi akademik, dan siap menghadapi tantangan global."</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-tasks text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Misi</h3>
                                <ul class="list-disc list-inside text-gray-600 space-y-2">
                                    <li>Menyelenggarakan pendidikan berkualitas dengan pendekatan holistik</li>
                                    <li>Mengembangkan karakter dan akhlak mulia siswa</li>
                                    <li>Mendorong kreativitas dan inovasi dalam pembelajaran</li>
                                    <li>Mempersiapkan siswa untuk kompetisi global</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
