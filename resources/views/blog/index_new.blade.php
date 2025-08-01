@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Home')

@section('content')
<!-- Hero Section with Featured Image -->
<div class="hero-section relative w-full h-64 md:h-80 overflow-hidden rounded-xl mb-8 sm:mb-12 card">
    <img src="{{ asset('storage/banner.jpg') }}" alt="Hero Image" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex flex-col justify-center items-start text-left p-4 sm:p-8">
        <h1 class="hero-title text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-2 sm:mb-4 drop-shadow-lg">
            {{ isset($category) ? $category->name : 'Welcome to ZekkTech' }}
        </h1>
        <p class="hero-description text-base sm:text-lg text-gray-200 max-w-1.5 drop-shadow-md">
            {{ isset($category) ? 'Artikel dalam kategori ' . $category->name : 'Temukan artikel terbaru tentang Teknologi, Tutorial, Tips&Trik, dan Wawasan Pengembangan teknologi.' }}
        </p>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6 sm:gap-8 lg:gap-12">
    <!-- Main Content -->
    <div class="w-full lg:w-2/3">
        @if($posts->count() > 0)
        <div class="space-y-6 sm:space-y-8">
            @foreach($posts as $post)
            <article class="card rounded-xl p-4 sm:p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
                    @if($post->image)
                    <div class="md:w-48 md:flex-shrink-0">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="w-full h-48 md:h-32 object-cover rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                    </div>
                    @endif
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3">
                            @foreach($post->categories as $cat)
                            <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full"
                                style="background-color: var(--accent-color); color: white;">
                                {{ $cat->name }}
                            </span>
                            @endforeach
                            <span class="text-xs sm:text-sm" style="color: var(--text-secondary);">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">
                            <a href="{{ route('blog.show', $post->slug) }}"
                                class="transition-colors"
                                style="color: var(--text-primary);"
                                onmouseover="this.style.color='var(--accent-color)'"
                                onmouseout="this.style.color='var(--text-primary)'">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="mb-3 sm:mb-4 leading-relaxed text-sm sm:text-base" style="color: var(--text-secondary);">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold text-white"
                                    style="background-color: var(--accent-color);">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <span class="text-xs sm:text-sm font-medium" style="color: var(--text-secondary);">
                                    {{ $post->user->name }}
                                </span>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}"
                                class="btn-primary text-xs sm:text-sm font-medium inline-flex items-center justify-center gap-2 w-full sm:w-auto min-h-10 py-2 px-4">
                                Read More
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="card rounded-xl p-6 sm:p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-16 h-16 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 rounded-full flex items-center justify-center"
                    style="background-color: var(--bg-secondary);">
                    <svg class="w-8 h-8 sm:w-12 sm:h-12" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold mb-2" style="color: var(--text-primary);">No Posts Found</h3>
                <p class="text-sm sm:text-base" style="color: var(--text-secondary);">
                    {{ isset($category) ? 'No posts found in this category.' : 'No posts have been published yet.' }}
                </p>
            </div>
        </div>
        @endif

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-8 sm:mt-12">
            {{ $posts->links() }}
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="w-full lg:w-1/3">
        <div class="space-y-6 sm:space-y-8">
            <!-- Categories -->
            <div class="card rounded-xl p-4 sm:p-6 sidebar-card">
                <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Categories</h3>
                <div class="space-y-2">
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}"
                        class="flex items-center justify-between p-2 sm:p-3 rounded-lg transition-all duration-200 hover:shadow-md min-h-10"
                        style="color: var(--text-secondary); background-color: var(--bg-secondary);"
                        onmouseover="this.style.backgroundColor='var(--border-color)'; this.style.color='var(--accent-color)'"
                        onmouseout="this.style.backgroundColor='var(--bg-secondary)'; this.style.color='var(--text-secondary)'">
                        <span class="font-medium text-sm sm:text-base">{{ $cat->name }}</span>
                        <span class="text-xs px-2 py-1 rounded-full" style="background-color: var(--border-color);">
                            {{ $cat->posts_count }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Recent Posts -->
            @if($latestPosts && $latestPosts->count() > 0)
            <div class="card rounded-xl p-4 sm:p-6 sidebar-card">
                <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Recent Posts</h3>
                <div class="space-y-3 sm:space-y-4">
                    @foreach($latestPosts as $recent)
                    <a href="{{ route('blog.show', $recent->slug) }}"
                        class="block group min-h-10">
                        <div class="flex gap-3">
                            @if($recent->image)
                            <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}"
                                class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg flex-shrink-0">
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm leading-tight mb-1 group-hover:text-opacity-80 transition-colors"
                                    style="color: var(--text-primary);">
                                    {{ Str::limit($recent->title, 45) }}
                                </h4>
                                <p class="text-xs" style="color: var(--text-secondary);">
                                    {{ $recent->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection