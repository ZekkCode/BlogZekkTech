@extends('layouts.app')

@section('title', 'Search Results' . ($query ? ' for "' . $query . '"' : ''))

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-4" style="color: var(--text-primary);">
                @if($query)
                    Hasil Pencarian untuk "{{ $query }}"
                @else
                    Cari Artikel
                @endif
            </h1>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="mb-6">
                <div class="relative max-w-md">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Search articles..."
                        class="w-full px-4 py-3 pl-10 rounded-lg border transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color); color: var(--text-primary);"
                        onfocus="this.style.ringColor='var(--accent-color)'" onblur="this.style.ringColor=''">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5" style="color: var(--text-secondary);" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>

            @if($query && $posts->count() > 0)
                <p class="text-sm" style="color: var(--text-secondary);">
                    Mendapatkan {{ $posts->total() }} {{ $posts->total() === 1 ? 'result' : 'results' }}
                </p>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                @if($query)
                    @if($posts->count() > 0)
                        <div class="space-y-8">
                            @foreach($posts as $post)
                                <article class="card rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex flex-col">
                                        <div class="flex flex-wrap items-center text-sm mb-3" style="color: var(--text-secondary);">
                                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $post->user->name }}</span>
                                            @if($post->categories->count() > 0)
                                                <span class="mx-2">•</span>
                                                @foreach($post->categories as $category)
                                                    <span class="inline-block px-2 py-1 text-xs rounded-full mr-1"
                                                        style="background-color: var(--accent-color); color: white;">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>

                                        <h2 class="text-xl font-bold mb-3 hover:opacity-80 transition-opacity">
                                            <a href="{{ route('blog.show', $post->slug) }}" style="color: var(--text-primary);">
                                                {{ $post->title }}
                                            </a>
                                        </h2>

                                        <div class="text-base leading-relaxed mb-4" style="color: var(--text-secondary);">
                                            {{ $post->excerpt ?: Str::limit(strip_tags($post->body), 150) }}
                                        </div>

                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="inline-flex items-center font-medium hover:opacity-80 transition-opacity"
                                            style="color: var(--accent-color);">
                                            Baca selengkapnya..
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($posts->hasPages())
                            <div class="mt-12">
                                {{ $posts->withQueryString()->links('vendor.pagination.tailwind') }}
                            </div>
                        @endif
                    @else
                        <div class="card rounded-xl p-12 text-center">
                            <div class="mb-4">
                                <svg class="mx-auto h-16 w-16" style="color: var(--text-secondary);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Tidak Ada Postingan</h3>
                            <p class="mb-4" style="color: var(--text-secondary);">
                                We couldn't find any articles matching "{{ $query }}". Coba Lagi istilah pencarian Anda.
                            </p>
                            <a href="{{ route('home') }}" class="btn-primary">
                                Kembali ke Beranda
                            </a>
                        </div>
                    @endif
                @else
                    <div class="card rounded-xl p-12 text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16" style="color: var(--text-secondary);" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Cari Artikel</h3>
                        <p style="color: var(--text-secondary);">
                            Masukkan istilah pencarian untuk menemukan artikel.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="space-y-8">
                    <!-- Categories -->
                    @if($categories->count() > 0)
                        <div class="card rounded-xl p-6">
                            <h3 class="text-lg font-bold mb-4" style="color: var(--text-primary);">Kategori</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog.category', $category->slug) }}"
                                        class="flex items-center justify-between py-2 px-3 rounded transition-colors"
                                        style="color: var(--text-secondary);"
                                        onmouseover="this.style.backgroundColor='var(--bg-primary)'; this.style.color='var(--accent-color)'"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-secondary)'">
                                        <span>{{ $category->name }}</span>
                                        <span
                                            class="text-sm bg-gray-500 text-white px-2 py-1 rounded-full">{{ $category->posts_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Latest Posts -->
                    @if($latestPosts->count() > 0)
                        <div class="card rounded-xl p-6">
                            <h3 class="text-lg font-bold mb-4" style="color: var(--text-primary);">Post Terbaru
                            </h3>
                            <div class="space-y-4">
                                @foreach($latestPosts as $latestPost)
                                    <div class="border-b pb-4 last:border-b-0 last:pb-0" style="border-color: var(--border-color);">
                                        <h4 class="font-medium mb-1 hover:opacity-80">
                                            <a href="{{ route('blog.show', $latestPost->slug) }}"
                                                style="color: var(--text-primary);" class="hover:underline">
                                                {{ $latestPost->title }}
                                            </a>
                                        </h4>
                                        <p class="text-sm" style="color: var(--text-secondary);">
                                            {{ $latestPost->published_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection