@extends('landing.guest')

@section('title', 'Berita & Artikel')

@section('content')
    <!-- Hero Section -->
    <section class="hero-bg py-20 relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-6 animate-fade-in">
                    Berita & Artikel
                </h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto animate-fade-in animation-delay-200">
                    Dapatkan informasi terbaru seputar pendidikan, kegiatan sekolah, dan berita penting lainnya
                </p>

                <!-- Search Bar -->
                <div class="max-w-md mx-auto animate-fade-in animation-delay-200">
                    <form action="{{ route('artikel.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                            class="w-full px-6 py-4 rounded-full text-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg">
                        <button type="submit"
                            class="absolute right-2 top-2 bg-primary hover:bg-secondary text-white p-2 rounded-full transition duration-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-10 w-16 h-16 bg-white/10 rounded-full animate-float animation-delay-200"></div>
    </section>

    <!-- Filter & Categories -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Categories Filter -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('artikel.index') }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition duration-300
                          {{ !request('category') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('artikel.index', ['category' => $category->slug]) }}"
                            class="px-4 py-2 rounded-full text-sm font-medium transition duration-300
                              {{ request('category') === $category->slug ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Sort Options -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Urutkan:</span>
                    <select onchange="location = this.value"
                        class="px-3 py-1 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'latest'])) }}"
                            {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'popular'])) }}"
                            {{ request('sort') === 'popular' ? 'selected' : '' }}>
                            Terpopuler
                        </option>
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}"
                            {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                            Terlama
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Articles -->
    @if ($featuredArticles->count() > 0 && !request('search') && !request('category'))
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Artikel Unggulan</h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @foreach ($featuredArticles as $article)
                        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover-scale group">
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}"
                                        class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div
                                        class="w-full h-64 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-6xl opacity-50"></i>
                                    </div>
                                @endif

                                @if ($article->is_breaking)
                                    <div
                                        class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        <i class="fas fa-bolt mr-1"></i>Breaking
                                    </div>
                                @endif

                                <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-sm">
                                    {{ $article->category->name }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold mb-3 text-gray-800 line-clamp-2 group-hover:text-primary transition duration-300">
                                    <a href="{{ route('artikel.read', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $article->excerpt }}
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center gap-4">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-user"></i>
                                            {{ $article->author->name }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $article->time_ago }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-comment"></i>
                                            {{ number_format($article->comments_count) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Articles List -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">
                    @if (request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @elseif(request('category'))
                        Kategori: {{ $categories->where('slug', request('category'))->first()->name ?? 'Tidak ditemukan' }}
                    @else
                        Semua Artikel
                    @endif
                </h2>

                <span class="text-gray-600">
                    Menampilkan {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} dari
                    {{ $articles->total() }} artikel
                </span>
            </div>

            @if ($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($articles as $article)
                        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover-scale group">
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                                    </div>
                                @endif

                                @if ($article->is_breaking)
                                    <div
                                        class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-bolt mr-1"></i>Breaking
                                    </div>
                                @endif

                                <div class="absolute top-3 right-3 bg-primary text-white px-2 py-1 rounded-full text-xs">
                                    {{ $article->category->name }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3
                                    class="text-lg font-bold mb-3 text-gray-800 line-clamp-2 group-hover:text-primary transition duration-300">
                                    <a href="{{ route('artikel.read', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 line-clamp-3 text-sm">
                                    {{ $article->excerpt }}
                                </p>

                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-user"></i>
                                            {{ $article->author->name }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $article->time_ago }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-comment"></i>
                                            {{ number_format($article->comments_count) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <a href="{{ route('artikel.read', $article->slug) }}"
                                        class="inline-flex items-center gap-2 text-primary hover:text-secondary font-medium text-sm transition duration-300">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($articles->hasPages())
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center gap-2">
                            {{-- Previous Page Link --}}
                            @if ($articles->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}"
                                    class="px-4 py-2 text-primary bg-white border border-gray-300 rounded-lg hover:bg-primary hover:text-white transition duration-300">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                                @if ($page == $articles->currentPage())
                                    <span class="px-4 py-2 bg-primary text-white rounded-lg font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-primary hover:text-white transition duration-300">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}"
                                    class="px-4 py-2 text-primary bg-white border border-gray-300 rounded-lg hover:bg-primary hover:text-white transition duration-300">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            @else
                <!-- No Articles Found -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Tidak Ada Artikel</h3>
                    <p class="text-gray-600 mb-6">
                        @if (request('search'))
                            Tidak ditemukan artikel yang sesuai dengan pencarian "{{ request('search') }}"
                        @elseif(request('category'))
                            Belum ada artikel dalam kategori ini
                        @else
                            Belum ada artikel yang dipublikasikan
                        @endif
                    </p>

                    @if (request('search') || request('category'))
                        <a href="{{ route('artikel.index') }}"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white px-6 py-3 rounded-full font-medium transition duration-300">
                            <i class="fas fa-arrow-left"></i>
                            Lihat Semua Artikel
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-secondary">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold text-white mb-4">Dapatkan Update Terbaru</h2>
                <p class="text-white/90 mb-8">
                    Berlangganan newsletter kami untuk mendapatkan berita dan informasi terbaru dari SMP Harapan Bangsa
                </p>

                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Masukkan email Anda..."
                        class="flex-1 px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-4 focus:ring-white/30">
                    <button type="submit"
                        class="bg-white text-primary hover:bg-gray-100 px-8 py-3 rounded-full font-medium transition duration-300">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
