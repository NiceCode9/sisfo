@extends('landing.guest')

@section('title', 'Guru Kami')

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
                    Tim <span class="text-accent drop-shadow-lg">Pendidik</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90 leading-relaxed">
                    Tenaga pendidik profesional dan berpengalaman yang berkomitmen membimbing siswa menuju masa depan yang
                    gemilang
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#guru-list"
                        class="bg-accent hover:bg-accent/90 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <i class="fas fa-users mr-2"></i>
                        Lihat Guru Kami
                    </a>
                    <a href="#tentang-guru"
                        class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 border border-white/20">
                        <i class="fas fa-info-circle mr-2"></i>
                        Tentang Tim Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <a href="#tentang-guru" class="flex flex-col items-center text-white/80 hover:text-white transition-colors">
                <span class="text-sm mb-2">Scroll Down</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                </div>
            </a>
        </div>
    </section>

    <!-- Tentang Tim Pendidik -->
    <section id="tentang-guru" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-chalkboard-teacher text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Tim Pendidik Berkualitas</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Kami bangga memiliki tim pendidik yang profesional, berpengalaman, dan berkomitmen tinggi dalam
                    membentuk karakter dan prestasi siswa
                </p>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto mt-8 rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <div class="grid grid-cols-2 gap-6">
                        <div
                            class="bg-gradient-to-br from-primary to-secondary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">{{ $gurus->count() }}</div>
                            <div class="text-sm opacity-90">Total Guru</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-accent to-primary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">15+</div>
                            <div class="text-sm opacity-90">Tahun Pengalaman</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-award text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-primary to-accent text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">S1/S2</div>
                            <div class="text-sm opacity-90">Kualifikasi</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-graduation-cap text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-br from-secondary to-primary text-white p-8 rounded-2xl hover:scale-105 transition-transform duration-300 shadow-xl">
                            <div class="text-4xl font-bold mb-2">100+</div>
                            <div class="text-sm opacity-90">Prestasi</div>
                            <div class="mt-4 opacity-60">
                                <i class="fas fa-trophy text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="animate-slide-up animation-delay-200">
                    <div class="mb-8">
                        <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                            <i class="fas fa-star text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-4xl font-bold text-dark mb-6 leading-tight">
                            Dedikasi & Profesionalisme
                        </h3>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Setiap guru di SMP Harapan Bangsa memiliki kualifikasi akademik yang tinggi dan pengalaman
                            mengajar yang mumpuni. Mereka tidak hanya mengajar, tetapi juga menjadi mentor dan inspirator
                            bagi setiap siswa.
                        </p>

                        <div class="space-y-4">
                            <div
                                class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark">Kualifikasi Tersertifikasi</h4>
                                    <p class="text-gray-600 text-sm">Semua guru memiliki sertifikat pendidik profesional</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-accent to-primary rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-lightbulb text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark">Metode Pembelajaran Inovatif</h4>
                                    <p class="text-gray-600 text-sm">Menggunakan teknologi dan metode modern dalam mengajar
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark">Pendekatan Personal</h4>
                                    <p class="text-gray-600 text-sm">Memahami keunikan dan potensi setiap siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="relative">
                    <input type="text" id="searchGuru" placeholder="Cari guru berdasarkan nama atau bidang keahlian..."
                        class="w-full px-8 py-5 text-lg border-2 border-gray-200 rounded-2xl focus:border-primary focus:outline-none transition duration-300 pl-16 shadow-lg">
                    <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
                </div>
                <p class="text-gray-500 mt-4">Temukan guru berdasarkan nama atau bidang keahlian yang Anda cari</p>
            </div>
        </div>
    </section>

    <!-- Guru Grid -->
    <section id="guru-list" class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block p-3 bg-primary/10 rounded-xl mb-4">
                    <i class="fas fa-users text-primary text-2xl"></i>
                </div>
                <h2 class="text-5xl font-bold text-dark mb-6">Profil Guru Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Kenali lebih dekat para pendidik yang berdedikasi untuk kesuksesan Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="guruGrid">
                @foreach ($gurus as $guru)
                    <div class="guru-card group cursor-pointer animate-slide-up animation-delay-{{ ($loop->index % 4) * 100 }}"
                        data-guru-id="{{ $guru->id }}" data-guru-name="{{ $guru->user->name ?? 'Nama tidak tersedia' }}"
                        data-guru-nip="{{ $guru->nip }}" data-guru-biografi="{{ $guru->biografi }}"
                        data-guru-bidang="{{ $guru->bidang_keahlian }}" data-guru-alamat="{{ $guru->alamat }}"
                        data-guru-gelar="{{ $guru->gelar }}" data-guru-telp="{{ $guru->telp }}"
                        data-guru-foto="{{ $guru->foto_path ? asset('storage/' . $guru->foto_path) : asset('images/default-avatar.png') }}"
                        onclick="openGuruModal(this)">

                        <div
                            class="bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-500 transform group-hover:-translate-y-3 group-hover:shadow-2xl border border-gray-100">
                            <div class="relative overflow-hidden">
                                <div
                                    class="aspect-square bg-gradient-to-br from-primary/10 to-secondary/20 flex items-center justify-center">
                                    @if ($guru->foto_path)
                                        <img src="{{ asset('storage/' . $guru->foto_path) }}"
                                            alt="{{ $guru->user->name ?? 'Guru' }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div
                                            class="w-24 h-24 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-3xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Overlay with gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <!-- Floating badge -->
                                <div
                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg transform translate-x-8 group-hover:translate-x-0 transition-transform duration-300">
                                    <span class="text-xs font-semibold text-primary">Lihat Detail</span>
                                </div>

                                <!-- Bottom overlay info -->
                                <div
                                    class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                                    <p class="text-sm font-medium">Klik untuk melihat profil lengkap</p>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="text-center">
                                    <h3
                                        class="text-xl font-bold text-gray-800 mb-2 group-hover:text-primary transition-colors">
                                        {{ $guru->user->name ?? 'Nama tidak tersedia' }}
                                    </h3>

                                    @if ($guru->gelar)
                                        <p class="text-sm text-gray-500 mb-3">{{ $guru->gelar }}</p>
                                    @endif

                                    @if ($guru->bidang_keahlian)
                                        <div
                                            class="inline-block px-4 py-2 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-full mb-4">
                                            <span
                                                class="text-sm font-medium text-primary">{{ $guru->bidang_keahlian }}</span>
                                        </div>
                                    @endif

                                    @if ($guru->nip)
                                        <p class="text-xs text-gray-500 mb-4">NIP: {{ $guru->nip }}</p>
                                    @endif

                                    @if ($guru->biografi)
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-6 leading-relaxed">
                                            {{ Str::limit($guru->biografi, 80) }}
                                        </p>
                                    @endif

                                    <div
                                        class="flex items-center justify-center text-primary font-semibold text-sm group-hover:text-secondary transition-colors">
                                        <span class="mr-2">Selengkapnya</span>
                                        <i
                                            class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-20 hidden">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                    <i class="fas fa-search text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-400 mb-4">Guru tidak ditemukan</h3>
                <p class="text-gray-500">Coba ubah kata kunci pencarian Anda atau hapus filter</p>
                <button onclick="document.getElementById('searchGuru').value = ''; filterGuru();"
                    class="mt-4 px-6 py-2 bg-primary text-white rounded-full hover:bg-secondary transition-colors">
                    Reset Pencarian
                </button>
            </div>
        </div>
    </section>

    <!-- Modal Guru Detail -->
    <div id="guruModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-5xl w-full max-h-[95vh] overflow-y-auto animate-scale-up shadow-2xl">
            <!-- Modal Header -->
            <div class="relative">
                <div class="hero-bg rounded-t-3xl p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/95 via-secondary/90 to-accent/95"></div>

                    <!-- Background decoration -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-accent/20 rounded-full blur-3xl"></div>
                    </div>

                    <div class="relative z-10">
                        <button onclick="closeGuruModal()"
                            class="absolute top-4 right-4 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 backdrop-blur-sm">
                            <i class="fas fa-times text-white text-lg"></i>
                        </button>

                        <div class="flex flex-col lg:flex-row items-center gap-8">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <img id="modalGuruFoto" src="" alt="Foto Guru"
                                        class="w-48 h-48 object-cover rounded-3xl border-4 border-white/30 shadow-2xl">
                                    <div
                                        class="absolute -bottom-4 -right-4 w-16 h-16 bg-accent rounded-full flex items-center justify-center shadow-xl border-4 border-white/30">
                                        <i class="fas fa-star text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center lg:text-left flex-1">
                                <h2 id="modalGuruNama" class="text-4xl lg:text-5xl font-bold mb-3"></h2>
                                <p id="modalGuruGelar" class="text-xl opacity-90 mb-6"></p>
                                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                                    <span id="modalGuruBidang"
                                        class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium border border-white/30"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-8 lg:p-12">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
                    <!-- Informasi Pribadi -->
                    <div class="xl:col-span-1 space-y-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                Informasi Pribadi
                            </h3>

                            <div class="space-y-6">
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                            <i class="fas fa-id-card text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 font-medium mb-1">Nomor Induk Pegawai</p>
                                            <p id="modalGuruNip" class="text-gray-800 font-semibold text-lg"></p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-accent to-success rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                            <i class="fas fa-phone text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 font-medium mb-1">Nomor Telepon</p>
                                            <p id="modalGuruTelp" class="text-gray-800 font-semibold text-lg"></p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-secondary to-primary rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                            <i class="fas fa-map-marker-alt text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 font-medium mb-1">Alamat</p>
                                            <p id="modalGuruAlamat" class="text-gray-800 leading-relaxed"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biografi dan Info Lainnya -->
                    <div class="xl:col-span-2 space-y-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-primary"></i>
                                </div>
                                Profil & Biografi
                            </h3>

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-8 border border-blue-100 shadow-sm">
                                <div class="prose prose-gray max-w-none">
                                    <p id="modalGuruBiografi" class="text-gray-700 leading-relaxed text-lg"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-chalkboard-teacher text-primary"></i>
                                </div>
                                Mata Pelajaran
                            </h3>

                            <div id="modalMataPelajaran" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Mata pelajaran akan diisi via JavaScript -->
                            </div>
                        </div>

                        <!-- Prestasi/Achievement (optional) -->
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-100">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-trophy text-white text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800">Prestasi & Penghargaan</h4>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Guru berprestasi dengan dedikasi tinggi dalam pendidikan dan pengembangan karakter siswa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 pb-8">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-primary mr-3 text-xl"></i>
                            <span class="text-gray-600">Ingin bertanya atau konsultasi?</span>
                        </div>
                        <button
                            class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 font-semibold">
                            <i class="fas fa-comments mr-2"></i>
                            Hubungi Guru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .animate-scale-up {
            animation: scaleUp 0.4s ease-out;
        }

        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-open {
            overflow: hidden;
        }

        /* Enhanced animations */
        .animate-fade-in {
            animation: fadeIn 1.2s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(60px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animation-delay-100 {
            animation-delay: 0.1s;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        /* Hero background */
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Loading states */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Glass morphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Enhanced search functionality
        function filterGuru() {
            const searchTerm = document.getElementById('searchGuru').value.toLowerCase();
            const guruCards = document.querySelectorAll('.guru-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCards = 0;

            guruCards.forEach((card, index) => {
                const name = card.dataset.guruName.toLowerCase();
                const bidang = card.dataset.guruBidang ? card.dataset.guruBidang.toLowerCase() : '';
                const gelar = card.dataset.guruGelar ? card.dataset.guruGelar.toLowerCase() : '';

                if (name.includes(searchTerm) || bidang.includes(searchTerm) || gelar.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.animationDelay = `${(visibleCards % 4) * 100}ms`;
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCards === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Search with debounce
        let searchTimeout;
        document.getElementById('searchGuru').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterGuru, 300);
        });

        // Enhanced modal functions
        function openGuruModal(element) {
            const modal = document.getElementById('guruModal');

            // Add loading state
            modal.classList.add('loading');

            // Populate modal with data
            document.getElementById('modalGuruFoto').src = element.dataset.guruFoto;
            document.getElementById('modalGuruNama').textContent = element.dataset.guruName;
            document.getElementById('modalGuruGelar').textContent = element.dataset.guruGelar || 'Guru Professional';
            document.getElementById('modalGuruBidang').textContent = element.dataset.guruBidang ||
                'Bidang keahlian tidak tersedia';
            document.getElementById('modalGuruNip').textContent = element.dataset.guruNip || 'Tidak tersedia';
            document.getElementById('modalGuruTelp').textContent = element.dataset.guruTelp || 'Tidak tersedia';
            document.getElementById('modalGuruAlamat').textContent = element.dataset.guruAlamat || 'Tidak tersedia';

            // Enhanced biografi with formatting
            const biografi = element.dataset.guruBiografi ||
                'Biografi belum tersedia. Guru yang berpengalaman dan berkomitmen dalam memberikan pendidikan terbaik untuk siswa.';
            document.getElementById('modalGuruBiografi').innerHTML = formatBiografi(biografi);

            // Simulate mata pelajaran data (you can fetch this via AJAX)
            populateMataPelajaran();

            // Show modal with animation
            setTimeout(() => {
                modal.classList.remove('hidden', 'loading');
                modal.classList.add('flex');
                document.body.classList.add('modal-open');
            }, 100);
        }

        function closeGuruModal() {
            const modal = document.getElementById('guruModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('modal-open');
        }

        function formatBiografi(text) {
            // Simple formatting for biografi
            const paragraphs = text.split('\n').filter(p => p.trim());
            if (paragraphs.length <= 1) {
                return `<p class="mb-4">${text}</p>`;
            }
            return paragraphs.map(p => `<p class="mb-4">${p.trim()}</p>`).join('');
        }

        function populateMataPelajaran() {
            const container = document.getElementById('modalMataPelajaran');

            // Sample data - replace with actual data from your backend
            const mataPelajaran = [{
                    nama: 'Matematika',
                    icon: 'fas fa-calculator'
                },
                {
                    nama: 'Bahasa Indonesia',
                    icon: 'fas fa-book'
                },
                {
                    nama: 'IPA',
                    icon: 'fas fa-flask'
                }
            ];

            if (mataPelajaran.length > 0) {
                container.innerHTML = mataPelajaran.map(mp => `
                <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center mr-3">
                            <i class="${mp.icon} text-white"></i>
                        </div>
                        <span class="font-medium text-gray-800">${mp.nama}</span>
                    </div>
                </div>
            `).join('');
            } else {
                container.innerHTML = `
                <div class="col-span-2 text-center py-8 text-gray-500">
                    <i class="fas fa-book-open text-3xl mb-3 opacity-50"></i>
                    <p>Informasi mata pelajaran akan segera tersedia</p>
                </div>
            `;
            }
        }

        // Close modal with outside click
        document.getElementById('guruModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGuruModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGuruModal();
            }
        });

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

        // Enhanced scroll animations with Intersection Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';

                    // Add stagger effect for grid items
                    if (entry.target.classList.contains('guru-card')) {
                        const cards = document.querySelectorAll('.guru-card');
                        const index = Array.from(cards).indexOf(entry.target);
                        entry.target.style.transitionDelay = `${(index % 4) * 100}ms`;
                    }
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.animate-slide-up, .guru-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(60px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });

        // Navbar scroll effect (if applicable)
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (navbar) {
                if (window.scrollY > 100) {
                    navbar.classList.add('shadow-2xl', 'bg-white/95', 'backdrop-blur-md');
                    navbar.classList.remove('shadow-lg');
                } else {
                    navbar.classList.remove('shadow-2xl', 'bg-white/95', 'backdrop-blur-md');
                    navbar.classList.add('shadow-lg');
                }
            }
        });

        // Image lazy loading with fade effect
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });

            if (img.complete) {
                img.style.opacity = '1';
            } else {
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';
            }
        });

        // Add loading states for better UX
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');

            // Remove any loading states
            document.querySelectorAll('.loading').forEach(el => {
                el.classList.remove('loading');
            });
        });

        // Performance optimization: Throttle scroll events
        let ticking = false;

        function updateScrollEffects() {
            // Add any scroll-based animations here
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        });

        // Add touch support for mobile devices
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }
    </script>
@endpush
