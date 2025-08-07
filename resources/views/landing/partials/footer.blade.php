<footer class="bg-gradient-to-b from-gray-900 to-gray-800 text-white pt-16 pb-8 relative">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                {{-- <div
                    class="h-12 w-12 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl mb-4 shadow-lg">
                    HB
                </div> --}}
                <div
                    class="h-12 w-12 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl mb-4 shadow-lg">
                    <img src="{{ $profileSekolah && $profileSekolah->logo ? asset('storage/' . $profileSekolah->logo) : $uiavatars }}"
                        alt="{{ $namaSekolah }}" class="h-full w-full object-cover rounded-full">
                </div>
                <h3 class="text-xl font-bold mb-4">
                    {{ isset($profileSekolah) ? strtoupper($profileSekolah->nama_sekolah) : 'SMP Harapan Bangsa' }}</h3>
                <p class="text-gray-300">{{ $profileSekolah->visi ?? 'Visi Sekolah' }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Tautan Cepat</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Home
                        </a></li>
                    <li><a href="{{ route('artikel.index') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Berita
                        </a></li>
                    <li><a href="{{ route('landing.guru.index') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Pendidik
                        </a></li>
                    <li><a href="{{ route('pendaftaran') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Pendaftaran
                        </a></li>
                    <li><a href="{{ url('/ekstrakurikuler-sekolah') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Ekstrakurikuler
                        </a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-gray-300 hover:text-white transition flex items-center group">
                            <span
                                class="w-2 h-2 bg-primary rounded-full mr-2 group-hover:mr-3 transition-all duration-300"></span>
                            Tentang Kami
                        </a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Kontak Kami</h3>
                <ul class="space-y-3 text-gray-300">
                    <li class="flex items-start group">
                        <div class="bg-primary bg-opacity-20 p-2 rounded-lg mr-3 group-hover:bg-opacity-30 transition">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <span>{{ $profileSekolah->alamat ?? 'Alamat Sekolah' }}</span>
                    </li>
                    <li class="flex items-start group">
                        <div class="bg-primary bg-opacity-20 p-2 rounded-lg mr-3 group-hover:bg-opacity-30 transition">
                            <i class="fas fa-phone-alt text-primary"></i>
                        </div>
                        <span>{{ $profileSekolah->telp ?? 'Isi Nomor Telepon sekolah' }}</span>
                    </li>
                    <li class="flex items-start group">
                        <div class="bg-primary bg-opacity-20 p-2 rounded-lg mr-3 group-hover:bg-opacity-30 transition">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <span>{{ $profileSekolah->email ?? 'Email Sekolah' }}</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Media Sosial</h3>
                <div class="flex space-x-4">
                    <a href="{{ $profileSekolah->sosmed['facebook'] ?? '' }}"
                        class="h-10 w-10 rounded-lg bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $profileSekolah->sosmed['twitter'] ?? '' }}"
                        class="h-10 w-10 rounded-lg bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ $profileSekolah->sosmed['instagram'] ?? '' }}"
                        class="h-10 w-10 rounded-lg bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $profileSekolah->sosmed['youtube'] ?? '' }}"
                        class="h-10 w-10 rounded-lg bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-1">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-4 text-white">Newsletter</h3>
                <div class="flex">
                    <input type="email" placeholder="Email Anda"
                        class="px-4 py-2 rounded-l-lg w-full focus:outline-none focus:ring-2 focus:ring-primary text-gray-800">
                    <button
                        class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-r-lg hover:from-secondary hover:to-primary transition-all duration-300">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">© 2025
                {{ $profileSekolah ? strtoupper($profileSekolah->nama_sekolah) : '' }}. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
