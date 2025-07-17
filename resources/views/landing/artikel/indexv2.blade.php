@extends('landing.guest')

@section('title', 'Berita & Artikel')

@section('content')
    <!-- Hero Section with Animated Background -->
    {{-- <section class="hero-bg py-24 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/90 to-secondary/90"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-white/10 rounded-full animate-bounce"></div>
            <div class="absolute bottom-20 left-20 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute bottom-40 right-10 w-16 h-16 bg-white/10 rounded-full animate-float animation-delay-200">
            </div>
        </div>

        <!-- Particle Animation -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle-container">
                @for ($i = 0; $i < 20; $i++)
                    <div class="particle animate-float"
                        style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white">
                <div class="inline-block p-3 bg-white/20 rounded-full mb-6 animate-bounce">
                    <i class="fas fa-newspaper text-4xl"></i>
                </div>

                <h1 class="text-6xl md:text-7xl font-bold mb-6 animate-fade-in-up">
                    <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        Berita & Artikel
                    </span>
                </h1>

                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-fade-in-up animation-delay-200 text-white/90">
                    Temukan informasi terbaru, wawasan mendalam, dan cerita inspiratif dari dunia pendidikan
                </p>

                <!-- Enhanced Search Bar -->
                <div class="max-w-2xl mx-auto animate-fade-in-up animation-delay-400">
                    <form action="{{ route('artikel.index') }}" method="GET" class="relative group">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari artikel, berita, atau topik..."
                                class="w-full px-8 py-6 pl-16 rounded-2xl text-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300/50 shadow-2xl bg-white/95 backdrop-blur-sm border-2 border-white/20 transition-all duration-300 group-hover:shadow-3xl">

                            <div class="absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search text-xl"></i>
                            </div>

                            <button type="submit"
                                class="absolute right-3 top-3 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white p-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <!-- Search Suggestions (if you want to add autocomplete) -->
                        <div
                            class="absolute top-full left-0 right-0 bg-white rounded-b-2xl shadow-xl mt-1 opacity-0 invisible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-300">
                            <div class="p-4 text-gray-600 text-sm">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-clock text-gray-400"></i>
                                    <span>Pencarian populer:</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 bg-gray-100 rounded-full text-xs hover:bg-primary hover:text-white cursor-pointer transition-colors">Pendidikan</span>
                                    <span
                                        class="px-3 py-1 bg-gray-100 rounded-full text-xs hover:bg-primary hover:text-white cursor-pointer transition-colors">Prestasi</span>
                                    <span
                                        class="px-3 py-1 bg-gray-100 rounded-full text-xs hover:bg-primary hover:text-white cursor-pointer transition-colors">Kegiatan</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="relative py-32 bg-gradient-to-br from-indigo-900 to-purple-900 overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAwIDEwMDAiPjxkZWZzPjxyYWRpYWxHcmFkaWVudCBpZD0iYSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNTAlIj48c3RvcCBvZmZzZXQ9IjAlIiBzdHlsZT0ic3RvcC1jb2xvcjpyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiLz48c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOnJnYmEoMjU1LDI1NSwyNTUsMCkiLz48L3JhZGlhbEdyYWRpZW50PjwvZGVmcz48Y2lyY2xlIGN4PSIyMDAiIGN5PSIyMDAiIHI9IjEwMCIgZmlsbD0idXJsKCNhKSIvPjxjaXJjbGUgY3g9IjgwMCIgY3k9IjMwMCIgcj0iMTUwIiBmaWxsPSJ1cmwoI2EpIi8+PGNpcmNsZSBjeD0iNDAwIiBjeT0iNzAwIiByPSI4MCIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')]">
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-white/10 rounded-full animate-float animation-delay-200"></div>
            <div class="absolute bottom-20 left-20 w-20 h-20 bg-white/10 rounded-full animate-float animation-delay-400">
            </div>
            <div class="absolute bottom-40 right-10 w-16 h-16 bg-white/10 rounded-full animate-float animation-delay-600">
            </div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white max-w-4xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-6 animate-bounce">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        Berita & Artikel
                    </span>
                </h1>

                <p class="text-xl md:text-2xl mb-8 opacity-90 leading-relaxed">
                    Temukan informasi terbaru, wawasan mendalam, dan cerita inspiratif dari dunia pendidikan
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('artikel.index') }}" method="GET" class="relative group">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari artikel, berita, atau topik..."
                                class="w-full px-6 py-4 pl-14 rounded-xl text-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300/50 shadow-lg bg-white/95 backdrop-blur-sm border border-white/20 transition-all duration-300 group-hover:shadow-xl">

                            <div class="absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search text-lg"></i>
                            </div>

                            <button type="submit"
                                class="absolute right-2 top-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white p-2 rounded-lg transition-all duration-300 shadow hover:shadow-md">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Filter & Categories -->
    {{-- <section class="py-8 bg-white/80 backdrop-blur-sm shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Categories Filter with Pills -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('artikel.index') }}"
                        class="px-6 py-3 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                          {{ !request('category') ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <i class="fas fa-home mr-2"></i>Semua
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('artikel.index', ['category' => $category->slug]) }}"
                            class="px-6 py-3 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                              {{ request('category') === $category->slug ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Enhanced Sort Options -->
                <div class="flex items-center gap-4 bg-white rounded-xl p-2 shadow-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-sort text-gray-400"></i>
                        <span class="text-sm text-gray-600 font-medium">Urutkan:</span>
                    </div>
                    <select onchange="location = this.value"
                        class="px-4 py-2 rounded-lg border-0 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer">
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'latest'])) }}"
                            {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                            🕒 Terbaru
                        </option>
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'popular'])) }}"
                            {{ request('sort') === 'popular' ? 'selected' : '' }}>
                            🔥 Terpopuler
                        </option>
                        <option value="{{ route('artikel.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}"
                            {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                            📚 Terlama
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="py-6 bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('artikel.index') }}"
                        class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300
                    {{ !request('category') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <i class="fas fa-home mr-2"></i>Semua
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('artikel.index', ['category' => $category->slug]) }}"
                            class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300
                        {{ request('category') === $category->slug ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Sort Options -->
                <div class="flex items-center gap-3 bg-white rounded-lg p-2 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 text-gray-500">
                        <i class="fas fa-sort"></i>
                        <span class="text-sm font-medium">Urutkan:</span>
                    </div>
                    <select onchange="location = this.value"
                        class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 cursor-pointer appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iY3VycmVudENvbG9yIiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTUuMjMgNy43M2EuNzUuNzUgMCAwMTEuMDYgMEwxMCAxMS40NGwzLjcxLTMuNzFhLjc1Ljc1IDAgMTExLjA2IDEuMDZsLTQuMjUgNC4yNWEuNzUuNzUgMCAwMS0xLjA2IDBMNS4yMyA4Ljc5YS43NS43NSAwIDAxMC0xLjA2eiIgY2xpcC1ydWxlPSJldmVub2RkIi8+PC9zdmc+')] bg-no-repeat bg-[right_0.5rem_center]">
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

    <!-- Breaking News Ticker -->
    @if ($featuredArticles->where('is_breaking', true)->count() > 0)
        <section class="bg-red-600 text-white py-3 overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="flex items-center">
                    <div class="bg-white text-red-600 px-4 py-1 rounded-full font-bold text-sm mr-4 flex items-center">
                        <i class="fas fa-bolt mr-1 animate-pulse"></i>
                        BREAKING
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div class="animate-marquee whitespace-nowrap">
                            @foreach ($featuredArticles->where('is_breaking', true) as $breaking)
                                <span class="mr-8">{{ $breaking->title }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Articles with Enhanced Design -->
    @if ($featuredArticles->count() > 0 && !request('search') && !request('category'))
        <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <div class="inline-block p-3 bg-primary/10 rounded-full mb-4">
                        <i class="fas fa-star text-primary text-2xl"></i>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Artikel Unggulan</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Temukan artikel pilihan terbaik yang telah dikurasi khusus untuk Anda
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach ($featuredArticles as $article)
                        <article
                            class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}"
                                        class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div
                                        class="w-full h-64 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-6xl opacity-50"></i>
                                    </div>
                                @endif

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>

                                <!-- Badges -->
                                <div class="absolute top-4 left-4 flex flex-col gap-2">
                                    @if ($article->is_breaking)
                                        <div
                                            class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                            <i class="fas fa-bolt mr-1"></i>Breaking
                                        </div>
                                    @endif
                                    @if ($article->is_featured)
                                        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </div>
                                    @endif
                                </div>

                                <div
                                    class="absolute top-4 right-4 bg-primary/90 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $article->category->name }}
                                </div>

                                <!-- Reading Time -->
                                <div
                                    class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <i class="fas fa-clock mr-1"></i>{{ $article->reading_time }} min
                                </div>
                            </div>

                            <div class="p-8">
                                <h3
                                    class="text-xl font-bold mb-4 text-gray-800 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                                    <a href="{{ route('artikel.read', $article->slug) }}" class="hover:underline">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white text-xs"></i>
                                            </div>
                                            <span class="font-medium">{{ $article->author->name }}</span>
                                        </div>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-calendar"></i>
                                            {{ $article->time_ago }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-heart"></i>
                                            {{ number_format($article->likes_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-comment"></i>
                                            {{ number_format($article->comments_count) }}
                                        </span>
                                    </div>

                                    <a href="{{ route('artikel.read', $article->slug) }}"
                                        class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white px-4 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105">
                                        Baca
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Articles List with Enhanced Cards -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-2">
                        @if (request('search'))
                            Hasil Pencarian
                        @elseif(request('category'))
                            Kategori:
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Tidak ditemukan' }}
                        @else
                            Semua Artikel
                        @endif
                    </h2>
                    @if (request('search'))
                        <p class="text-gray-600">Menampilkan hasil untuk: "<span
                                class="font-medium text-primary">{{ request('search') }}</span>"</p>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                    <i class="fas fa-info-circle text-primary"></i>
                    <span class="text-gray-600 text-sm">
                        {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} dari
                        {{ number_format($articles->total()) }} artikel
                    </span>
                </div>
            </div>

            @if ($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($articles as $article)
                        {{-- <article
                            class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 border border-gray-100">
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                                    </div>
                                @endif

                                <!-- Quick Actions Overlay -->
                                <div
                                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="flex gap-3">
                                        <button
                                            class="bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button
                                            class="bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
                                            <i class="fas fa-bookmark"></i>
                                        </button>
                                        <button
                                            class="bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-colors">
                                            <i class="fas fa-share"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Badges -->
                                @if ($article->is_breaking)
                                    <div
                                        class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-bolt mr-1"></i>Breaking
                                    </div>
                                @endif

                                <div
                                    class="absolute top-3 right-3 bg-primary/90 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs">
                                    {{ $article->category->name }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3
                                    class="text-lg font-bold mb-3 text-gray-800 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                                    <a href="{{ route('artikel.read', $article->slug) }}" class="hover:underline">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>

                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-1">
                                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white text-xs"></i>
                                            </div>
                                            <span>{{ $article->author->name }}</span>
                                        </div>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $article->time_ago }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-comment"></i>
                                            {{ number_format($article->comments_count) }}
                                        </span>
                                    </div>

                                    <a href="{{ route('artikel.read', $article->slug) }}"
                                        class="inline-flex items-center gap-2 text-primary hover:text-secondary font-medium text-sm transition-colors duration-300">
                                        Baca
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article> --}}
                        <!-- Article Card -->
                        <article
                            class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-transparent">
                            <!-- Image -->
                            <div class="relative overflow-hidden aspect-[4/3]">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-4xl opacity-30"></i>
                                    </div>
                                @endif

                                <!-- Overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                    @if ($article->is_breaking)
                                        <div
                                            class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-bold flex items-center">
                                            <i class="fas fa-bolt mr-1 text-xs"></i>Breaking
                                        </div>
                                    @endif
                                    @if ($article->is_featured)
                                        <div
                                            class="bg-amber-500 text-white px-2.5 py-1 rounded-full text-xs font-bold flex items-center">
                                            <i class="fas fa-star mr-1 text-xs"></i>Featured
                                        </div>
                                    @endif
                                </div>

                                <!-- Category -->
                                <div
                                    class="absolute top-3 right-3 bg-indigo-600/90 backdrop-blur text-white px-2.5 py-1 rounded-full text-xs font-medium">
                                    {{ $article->category->name }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-user-circle"></i>
                                        {{ $article->author->name }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $article->time_ago }}
                                    </span>
                                </div>

                                <h3
                                    class="text-lg font-bold mb-3 text-gray-800 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('artikel.read', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 text-sm line-clamp-3 leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>

                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-comment"></i>
                                            {{ number_format($article->comments_count) }}
                                        </span>
                                    </div>

                                    <a href="{{ route('artikel.read', $article->slug) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-purple-600 transition-colors flex items-center gap-1">
                                        Baca <i class="fas fa-arrow-right text-xs mt-0.5"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Enhanced Pagination -->
                @if ($articles->hasPages())
                    <div class="mt-16 flex justify-center">
                        <nav class="flex items-center gap-2 bg-white rounded-2xl shadow-lg p-2">
                            {{-- Previous Page Link --}}
                            @if ($articles->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}"
                                    class="px-4 py-2 text-primary bg-primary/10 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($articles->getUrlRange(1, min($articles->lastPage(), 5)) as $page => $url)
                                @if ($page == $articles->currentPage())
                                    <span class="px-4 py-2 bg-primary text-white rounded-xl font-medium shadow-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-105">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}"
                                    class="px-4 py-2 text-primary bg-primary/10 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            @else
                <!-- Enhanced No Articles Found -->
                <div class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl">
                            <i class="fas fa-newspaper text-white text-4xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Tidak Ada Artikel</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            @if (request('search'))
                                Maaf, tidak ditemukan artikel yang sesuai dengan pencarian "<span
                                    class="font-medium text-primary">{{ request('search') }}</span>"
                            @elseif(request('category'))
                                Belum ada artikel dalam kategori ini. Silakan coba kategori lain.
                            @else
                                Belum ada artikel yang dipublikasikan. Silakan kembali lagi nanti.
                            @endif
                        </p>

                        @if (request('search') || request('category'))
                            <a href="{{ route('artikel.index') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-8 py-4 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-arrow-left"></i>
                                Lihat Semua Artikel
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Enhanced Newsletter Section -->
    {{-- <section class="py-20 bg-gradient-to-r from-primary via-secondary to-primary relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-20 right-20 w-16 h-16 bg-white/10 rounded-full animate-float animation-delay-200">
            </div>
            <div class="absolute bottom-20 left-20 w-24 h-24 bg-white/10 rounded-full animate-float animation-delay-400">
            </div>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-8">
                    <i class="fas fa-envelope text-white text-3xl"></i>
                </div>

                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Jangan Lewatkan Update Terbaru!
                </h2>
                <p class="text-white/90 mb-10 text-lg md:text-xl">
                    Dapatkan artikel pilihan, berita eksklusif, dan informasi penting langsung di kotak masuk Anda
                </p>

                <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <div class="flex-1 relative">
                        <input type="email" placeholder="Masukkan email Anda..."
                            class="w-full px-8 py-4 rounded-full text-gray-800 focus:outline-none focus:ring-4 focus:ring-white/30 bg-white/95 backdrop-blur-sm border-2 border-white/20">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Berlangganan
                    </button>
                </form>

                <p class="text-white/70 text-sm mt-6">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Kami menghormati privasi Anda. Tidak ada spam, bisa berhenti berlangganan kapan saja.
                </p>
            </div>
        </div>
    </section> --}}
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-700 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-20 right-20 w-16 h-16 bg-white/10 rounded-full animate-float animation-delay-200">
            </div>
            <div class="absolute bottom-20 left-20 w-24 h-24 bg-white/10 rounded-full animate-float animation-delay-400">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-8">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Jangan Lewatkan Update Terbaru!
                </h2>
                <p class="text-white/90 mb-8 text-lg leading-relaxed">
                    Dapatkan artikel pilihan, berita eksklusif, dan informasi penting langsung di kotak masuk Anda
                </p>

                <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                    <div class="flex-1 relative">
                        <input type="email" placeholder="Masukkan email Anda..."
                            class="w-full px-5 py-3.5 pl-12 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white/30 bg-white/95 backdrop-blur-sm border border-white/20">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3.5 rounded-lg font-medium transition-all duration-300 shadow hover:shadow-md whitespace-nowrap">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Berlangganan
                    </button>
                </form>

                <p class="text-white/70 text-sm mt-6">
                    <i class="fas fa-shield-alt mr-1.5"></i>
                    Kami menghormati privasi Anda. Tidak ada spam, bisa berhenti berlangganan kapan saja.
                </p>
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

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-400 {
            animation-delay: 400ms;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
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

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }

        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="80" fill="url(%23a)"/></svg>') center/cover;
            opacity: 0.3;
        }

        .particle-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .particle:nth-child(odd) {
            background: rgba(255, 255, 255, 0.4);
            animation-duration: 10s;
        }

        .particle:nth-child(even) {
            background: rgba(255, 255, 255, 0.3);
            animation-duration: 12s;
        }

        /* Enhanced hover effects */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }

        .group:hover .group-hover\:text-primary {
            color: var(--primary-color, #3b82f6);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        /* Enhanced card shadows */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }

        .card-shadow:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced button styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive breakpoints */
        @media (max-width: 768px) {
            .hero-bg {
                padding: 60px 0;
            }

            .hero-bg h1 {
                font-size: 3rem;
            }

            .hero-bg p {
                font-size: 1.125rem;
            }

            .particle {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .hero-bg h1 {
                font-size: 2.5rem;
            }

            .hero-bg p {
                font-size: 1rem;
            }

            .animate-marquee {
                animation-duration: 20s;
            }
        }

        /* Enhanced focus states */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            ring: 3px;
            ring-color: rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        /* Custom checkbox and radio buttons */
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-checkbox:checked {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        /* Toast notifications */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 16px 20px;
            max-width: 300px;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            border-left: 4px solid #10b981;
        }

        .toast.error {
            border-left: 4px solid #ef4444;
        }

        .toast.warning {
            border-left: 4px solid #f59e0b;
        }

        .toast.info {
            border-left: 4px solid #3b82f6;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .dark-mode {
                background-color: #1f2937;
                color: #f9fafb;
            }

            .dark-mode .bg-white {
                background-color: #374151;
            }

            .dark-mode .text-gray-800 {
                color: #f9fafb;
            }

            .dark-mode .text-gray-600 {
                color: #d1d5db;
            }

            .dark-mode .border-gray-200 {
                border-color: #4b5563;
            }
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                font-size: 12pt;
                line-height: 1.4;
            }

            .hero-bg {
                background: none !important;
                color: black !important;
            }
        }

        /* Performance optimizations */
        .will-change-transform {
            will-change: transform;
        }

        .will-change-opacity {
            will-change: opacity;
        }

        .gpu-accelerated {
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* Additional utility classes */
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .text-shadow-lg {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .backdrop-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .backdrop-blur-lg {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Enhanced animations */
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }

        .animate-wiggle {
            animation: wiggle 1s ease-in-out infinite;
        }

        @keyframes wiggle {

            0%,
            7% {
                transform: rotateZ(0);
            }

            15% {
                transform: rotateZ(-15deg);
            }

            20% {
                transform: rotateZ(10deg);
            }

            25% {
                transform: rotateZ(-10deg);
            }

            30% {
                transform: rotateZ(6deg);
            }

            35% {
                transform: rotateZ(-4deg);
            }

            40%,
            100% {
                transform: rotateZ(0);
            }
        }

        /* Interactive elements */
        .interactive-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .interactive-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .interactive-card:active {
            transform: translateY(-4px) scale(1.01);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom selection */
        ::selection {
            background: rgba(102, 126, 234, 0.2);
            color: #1f2937;
        }

        ::-moz-selection {
            background: rgba(102, 126, 234, 0.2);
            color: #1f2937;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Line clamping */
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

        /* Smooth transitions */
        .transition-slow {
            transition: all 0.5s ease;
        }

        .transition-medium {
            transition: all 0.3s ease;
        }

        .transition-fast {
            transition: all 0.15s ease;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }
    </style>
@endpush
@push('scripts')
    <script>
        // Enhanced Article Page JavaScript
        document.addEventListener('DOMContentLoaded', function() {

            // ====================
            // SEARCH FUNCTIONALITY
            // ====================

            // Search form enhancement
            const searchForm = document.querySelector('form[action*="artikel.index"]');
            const searchInput = searchForm?.querySelector('input[name="search"]');
            const searchButton = searchForm?.querySelector('button[type="submit"]');

            if (searchForm && searchInput) {
                // Add loading state to search
                searchForm.addEventListener('submit', function(e) {
                    if (searchButton) {
                        searchButton.innerHTML = '<div class="loading"></div>';
                        searchButton.disabled = true;
                    }
                });

                // Auto-search on input (debounced)
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 3) {
                            // Auto-suggest functionality could go here
                            showSearchSuggestions(this.value);
                        }
                    }, 300);
                });
            }

            // Search suggestions handler
            function showSearchSuggestions(query) {
                const suggestionsContainer = document.querySelector('.group-focus-within\\:opacity-100');
                if (suggestionsContainer) {
                    // You can implement AJAX search suggestions here
                    console.log('Searching for:', query);
                }
            }

            // Popular search tags functionality
            const popularTags = document.querySelectorAll('.px-3.py-1.bg-gray-100');
            popularTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    const tagText = this.textContent.trim();
                    if (searchInput) {
                        searchInput.value = tagText;
                        searchForm.submit();
                    }
                });
            });

            // ====================
            // ARTICLE INTERACTIONS
            // ====================

            // Article card hover effects
            const articleCards = document.querySelectorAll('article.group');
            articleCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });

            // Quick action buttons (like, bookmark, share)
            const quickActionBtns = document.querySelectorAll('.bg-white\\/20.backdrop-blur-sm');
            quickActionBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const icon = this.querySelector('i');
                    const action = icon.classList.contains('fa-heart') ? 'like' :
                        icon.classList.contains('fa-bookmark') ? 'bookmark' : 'share';

                    handleQuickAction(action, this);
                });
            });

            function handleQuickAction(action, button) {
                const article = button.closest('article');
                const articleId = article?.dataset.id || 'demo';

                // Add loading state
                button.style.opacity = '0.7';
                button.style.pointerEvents = 'none';

                switch (action) {
                    case 'like':
                        toggleLike(articleId, button);
                        break;
                    case 'bookmark':
                        toggleBookmark(articleId, button);
                        break;
                    case 'share':
                        shareArticle(articleId, button);
                        break;
                }

                // Remove loading state
                setTimeout(() => {
                    button.style.opacity = '1';
                    button.style.pointerEvents = 'auto';
                }, 500);
            }

            function toggleLike(articleId, button) {
                const icon = button.querySelector('i');
                const isLiked = icon.classList.contains('fa-heart') && button.classList.contains('liked');

                if (isLiked) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    button.classList.remove('liked');
                    showToast('Removed from favorites', 'info');
                } else {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    button.classList.add('liked');
                    showToast('Added to favorites', 'success');
                }

                // Add heart animation
                button.classList.add('animate-pulse');
                setTimeout(() => button.classList.remove('animate-pulse'), 600);
            }

            function toggleBookmark(articleId, button) {
                const icon = button.querySelector('i');
                const isBookmarked = button.classList.contains('bookmarked');

                if (isBookmarked) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    button.classList.remove('bookmarked');
                    showToast('Bookmark removed', 'info');
                } else {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    button.classList.add('bookmarked');
                    showToast('Article bookmarked', 'success');
                }

                // Add bookmark animation
                button.classList.add('animate-bounce');
                setTimeout(() => button.classList.remove('animate-bounce'), 600);
            }

            function shareArticle(articleId, button) {
                const article = button.closest('article');
                const title = article.querySelector('h3 a')?.textContent || 'Article';
                const url = article.querySelector('h3 a')?.href || window.location.href;

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).then(() => {
                        showToast('Article shared successfully', 'success');
                    }).catch(console.error);
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        showToast('Link copied to clipboard', 'success');
                    }).catch(() => {
                        showToast('Failed to copy link', 'error');
                    });
                }

                // Add share animation
                button.classList.add('animate-wiggle');
                setTimeout(() => button.classList.remove('animate-wiggle'), 1000);
            }

            // ====================
            // NEWSLETTER SUBSCRIPTION
            // ====================

            const newsletterForm = document.querySelector('form[action*="newsletter"], form:last-of-type');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const email = this.querySelector('input[type="email"]').value;
                    const button = this.querySelector('button[type="submit"]');

                    if (!isValidEmail(email)) {
                        showToast('Please enter a valid email address', 'error');
                        return;
                    }

                    // Add loading state
                    const originalText = button.innerHTML;
                    button.innerHTML = '<div class="loading"></div> Subscribing...';
                    button.disabled = true;

                    // Simulate subscription (replace with actual API call)
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-check mr-2"></i> Subscribed!';
                        button.style.background = '#10b981';
                        showToast('Successfully subscribed to newsletter!', 'success');

                        // Reset form
                        setTimeout(() => {
                            this.reset();
                            button.innerHTML = originalText;
                            button.disabled = false;
                            button.style.background = '';
                        }, 2000);
                    }, 1500);
                });
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // ====================
            // BREAKING NEWS TICKER
            // ====================

            const breakingNewsTicker = document.querySelector('.animate-marquee');
            if (breakingNewsTicker) {
                // Pause animation on hover
                breakingNewsTicker.addEventListener('mouseenter', function() {
                    this.style.animationPlayState = 'paused';
                });

                breakingNewsTicker.addEventListener('mouseleave', function() {
                    this.style.animationPlayState = 'running';
                });

                // Make breaking news clickable
                breakingNewsTicker.addEventListener('click', function() {
                    showToast('Breaking news clicked!', 'info');
                });
            }

            // ====================
            // CATEGORY FILTER EFFECTS
            // ====================

            const categoryFilters = document.querySelectorAll('a[href*="category"]');
            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function(e) {
                    // Add loading effect
                    const originalText = this.innerHTML;
                    this.innerHTML = '<div class="loading"></div> Loading...';

                    // Let the navigation happen normally
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 100);
                });
            });

            // ====================
            // SORT FUNCTIONALITY
            // ====================

            const sortSelect = document.querySelector('select[onchange*="location"]');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    showToast('Sorting articles...', 'info');
                    // Add loading indicator
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'fixed top-4 right-4 bg-white p-4 rounded-lg shadow-lg z-50';
                    loadingDiv.innerHTML = '<div class="loading"></div> Sorting...';
                    document.body.appendChild(loadingDiv);

                    setTimeout(() => {
                        document.body.removeChild(loadingDiv);
                    }, 1000);
                });
            }

            // ====================
            // PAGINATION ENHANCEMENTS
            // ====================

            const paginationLinks = document.querySelectorAll('nav a[href*="page"]');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading effect
                    this.style.opacity = '0.7';
                    this.innerHTML = '<div class="loading"></div>';

                    // Smooth scroll to top
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });

            // ====================
            // SCROLL EFFECTS
            // ====================

            // Parallax effect for hero section
            const heroSection = document.querySelector('.hero-bg');
            if (heroSection) {
                window.addEventListener('scroll', function() {
                    const scrolled = window.pageYOffset;
                    const parallax = heroSection.querySelector('.absolute.inset-0');
                    if (parallax) {
                        parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
                    }
                });
            }

            // Fade in animation for cards on scroll
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

            // Observe all article cards
            articleCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // ====================
            // TOAST NOTIFICATIONS
            // ====================

            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                toast.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-${getToastIcon(type)} mr-3"></i>
                    <span>${message}</span>
                </div>
                <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

                document.body.appendChild(toast);

                // Show toast
                setTimeout(() => toast.classList.add('show'), 100);

                // Auto remove after 4 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }

            function getToastIcon(type) {
                switch (type) {
                    case 'success':
                        return 'check-circle';
                    case 'error':
                        return 'exclamation-circle';
                    case 'warning':
                        return 'exclamation-triangle';
                    default:
                        return 'info-circle';
                }
            }

            // ====================
            // KEYBOARD SHORTCUTS
            // ====================

            document.addEventListener('keydown', function(e) {
                // Search shortcut (Ctrl/Cmd + K)
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                // Escape to clear search
                if (e.key === 'Escape') {
                    if (searchInput && searchInput === document.activeElement) {
                        searchInput.blur();
                    }
                }
            });

            // ====================
            // RESPONSIVE MENU TOGGLE
            // ====================

            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.querySelector('.mobile-menu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    this.classList.toggle('open');
                });
            }

            // ====================
            // PERFORMANCE OPTIMIZATIONS
            // ====================

            // Lazy load images
            const images = document.querySelectorAll('img[src]');
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            // img.style.opacity = '0';
                            img.style.transition = 'opacity 0.3s ease';

                            img.onload = () => {
                                img.style.opacity = '1';
                            };

                            imageObserver.unobserve(img);
                        }
                    });
                });

                images.forEach(img => imageObserver.observe(img));
            }

            // Debounce scroll events
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    // Scroll-dependent code here
                    updateScrollProgress();
                }, 16); // ~60fps
            });

            function updateScrollProgress() {
                const scrollProgress = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
                // You can use this for progress bars, etc.
            }

            // ====================
            // DARK MODE TOGGLE
            // ====================

            const darkModeToggle = document.querySelector('.dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
                });

                // Load saved dark mode preference
                if (localStorage.getItem('darkMode') === 'true') {
                    document.body.classList.add('dark-mode');
                }
            }

            // ====================
            // ACCESSIBILITY IMPROVEMENTS
            // ====================

            // Skip to content link
            const skipLink = document.querySelector('.skip-link');
            if (skipLink) {
                skipLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.focus();
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            }

            // Focus management for modal/popups
            function trapFocus(element) {
                const focusableElements = element.querySelectorAll(
                    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                element.addEventListener('keydown', function(e) {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstElement) {
                                lastElement.focus();
                                e.preventDefault();
                            }
                        } else {
                            if (document.activeElement === lastElement) {
                                firstElement.focus();
                                e.preventDefault();
                            }
                        }
                    }
                });
            }

            // ====================
            // ANALYTICS & TRACKING
            // ====================

            // Track article views
            function trackArticleView(articleId) {
                // Send analytics event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'article_view', {
                        article_id: articleId,
                        event_category: 'engagement'
                    });
                }
            }

            // Track search queries
            function trackSearch(query) {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'search', {
                        search_term: query,
                        event_category: 'engagement'
                    });
                }
            }

            // ====================
            // INITIALIZATION
            // ====================

            // Initialize all components
            function init() {
                console.log('Article page JavaScript initialized');

                // Set up any additional event listeners
                setupCustomEvents();

                // Initialize third-party plugins if needed
                initializePlugins();

                // Show welcome message
                setTimeout(() => {
                    showToast('Welcome to our article page!', 'success');
                }, 1000);
            }

            function setupCustomEvents() {
                // Custom event for article interactions
                document.addEventListener('articleInteraction', function(e) {
                    console.log('Article interaction:', e.detail);
                });
            }

            function initializePlugins() {
                // Initialize any third-party plugins here
                // Example: syntax highlighting, social sharing, etc.
            }

            // Run initialization
            init();

            // ====================
            // ERROR HANDLING
            // ====================

            window.addEventListener('error', function(e) {
                console.error('JavaScript error:', e.error);
                showToast('Something went wrong. Please refresh the page.', 'error');
            });

            // Handle unhandled promise rejections
            window.addEventListener('unhandledrejection', function(e) {
                console.error('Unhandled promise rejection:', e.reason);
                showToast('An unexpected error occurred.', 'error');
            });

        });

        // ====================
        // UTILITY FUNCTIONS
        // ====================

        // Debounce function
        // function debounce(func, wait) {
        //     let timeout;
        //     return function executedFunction(...args) {
        //         const later = () => {
        //             clearTimeout(timeout);
        //             func(...args);
        //         };
        //         clearTimeout(timeout);
        //         timeout = setTimeout(later, wait);
        //     };
        // }

        // // Throttle function
        // function throttle(func, limit) {
        //     let inThrottle;
        //     return function() {
        //         const args = arguments;
        //         const context = this;
        //         if (!inThrottle) {
        //             func.apply(context, args);
        //             inThrottle = true;
        //             setTimeout(() => inThrottle = false, limit);
        //         }
        //     }
        // }

        // // Format number function
        // function formatNumber(num) {
        //     if (num >= 1000000) {
        //         return (num / 1000000).toFixed(1) + 'M';
        //     } else if (num >= 1000) {
        //         return (num / 1000).toFixed(1) + 'K';
        //     }
        //     return num.toString();
        // }

        // // Smooth scroll to element
        // function scrollToElement(element, offset = 0) {
        //     const elementPosition = element.offsetTop - offset;
        //     window.scrollTo({
        //         top: elementPosition,
        //         behavior: 'smooth'
        //     });
        // }

        // // Create ripple effect
        // function createRipple(event) {
        //     const button = event.currentTarget;
        //     const circle = document.createElement('span');
        //     const diameter = Math.max(button.clientWidth, button.clientHeight);
        //     const radius = diameter / 2;

        //     circle.style.width = circle.style.height = `${diameter}px`;
        //     circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
        //     circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
        //     circle.classList.add('ripple');

        //     const ripple = button.getElementsByClassName('ripple')[0];
        //     if (ripple) {
        //         ripple.remove();
        //     }

        //     button.appendChild(circle);
        // }
    </script>
@endpush
