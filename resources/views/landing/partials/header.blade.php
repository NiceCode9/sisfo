<nav class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex-shrink-0 flex items-center">
                <div
                    class="h-12 w-12 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl shadow-md">
                    HB
                </div>
                <span class="ml-3 text-xl font-bold text-gray-800">SMP Harapan Bangsa</span>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-6">
                    <a href="#home" class="relative px-3 py-2 text-sm font-medium group">
                        <span class="text-gray-700 group-hover:text-primary">Home</span>
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#berita" class="relative px-3 py-2 text-sm font-medium group">
                        <span class="text-gray-700 group-hover:text-primary">Berita</span>
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#gallery" class="relative px-3 py-2 text-sm font-medium group">
                        <span class="text-gray-700 group-hover:text-primary">Gallery</span>
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#pendaftaran" class="relative px-3 py-2 text-sm font-medium group">
                        <span class="text-gray-700 group-hover:text-primary">Pendaftaran</span>
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#about" class="relative px-3 py-2 text-sm font-medium group">
                        <span class="text-gray-700 group-hover:text-primary">Tentang Kami</span>
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#pendaftaran"
                        class="ml-4 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-4 py-2 rounded-md font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

            <div class="md:hidden">
                <button class="text-gray-700 hover:text-primary focus:outline-none" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden bg-white shadow-lg" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#home"
                class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">Home</a>
            <a href="#berita"
                class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">Berita</a>
            <a href="#gallery"
                class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">Gallery</a>
            <a href="#pendaftaran"
                class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">Pendaftaran</a>
            <a href="#about"
                class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">Tentang
                Kami</a>
            <a href="#pendaftaran"
                class="block px-3 py-2 text-base font-medium text-white bg-primary rounded-md hover:bg-secondary">Daftar
                Sekarang</a>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</nav>
