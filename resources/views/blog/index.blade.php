@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Home')

@section('content')
    <style>
        /* Mobile responsive styling for blog posts */
        @media (max-width: 768px) {

            /* Excerpt/summary styling for mobile */
            .post-excerpt {
                font-size: 0.875rem !important;
                /* 14px */
                line-height: 1.4 !important;
                margin-bottom: 0.75rem !important;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                /* Limit to 3 lines */
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Article card padding adjustment */
            .card {
                padding: 1rem !important;
                /* Smaller padding on mobile */
            }

            /* Title sizing for mobile */
            .post-title {
                font-size: 1.25rem !important;
                /* 20px instead of 24px */
                line-height: 1.3 !important;
                margin-bottom: 0.75rem !important;
            }

            /* Button styling for mobile */
            .btn-primary {
                padding: 0.625rem 1rem !important;
                font-size: 0.875rem !important;
                border-radius: 0.75rem !important;
            }

            /* Category tags mobile styling */
            .category-tag {
                font-size: 0.625rem !important;
                /* 10px */
                padding: 0.25rem 0.5rem !important;
            }

            /* Published date mobile styling */
            .published-date {
                font-size: 0.75rem !important;
                /* 12px */
                margin-bottom: 0.5rem !important;
            }

            /* Author info mobile styling */
            .author-info {
                font-size: 0.75rem !important;
                /* 12px */
            }
        }

        @media (max-width: 480px) {

            /* Extra small mobile adjustments */
            .post-excerpt {
                font-size: 0.8125rem !important;
                /* 13px */
                -webkit-line-clamp: 2;
                /* Only 2 lines on very small screens */
            }

            .post-title {
                font-size: 1.125rem !important;
                /* 18px */
            }

            .card {
                padding: 0.75rem !important;
            }

            .btn-primary {
                padding: 0.5rem 0.875rem !important;
                font-size: 0.8125rem !important;
            }
        }
    </style>

    <!-- Hero Section with Featured Image -->
    <div class="hero-section relative w-full h-64 md:h-80 overflow-hidden rounded-lg mb-8 card z-10">
        <img src="{{ asset('storage/banner.png') }}" alt="ZekkTech - AI & Technology Hub"
            class="w-full h-full object-right-bottom object-cover transition-transform duration-500" loading="eager">
        <div
            class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/20 flex flex-col justify-center items-start text-left p-8 shadow-2xl">
            <h1 class="hero-title text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-2xl shadow-black/50">
                {{ isset($category) ? $category->name : 'ZekkTech' }}
            </h1>
            <p class="hero-description text-l text-gray-100 max-w-2xl drop-shadow-lg shadow-black/40">
                {{ isset($category) ? 'Artikel dalam kategori ' . $category->name : 'Temukan artikel terbaru tentang Teknologi, Tutorial, Tips&Trik, dan Wawasan Teknologi.' }}
            </p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            @if($posts->count() > 0)
                <div class="space-y-8">
                    @foreach($posts as $post)
                        <article
                            class="card rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row gap-6">
                                @if($post->image)
                                    <div class="md:w-48 md:flex-shrink-0">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                            class="w-full h-48 md:h-32 object-cover rounded-lg shadow-md transition-transform duration-300 hover:scale-105"
                                            style="aspect-ratio: 1.91/1;" loading="lazy">
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <!-- Published Date - Always on top -->
                                    <div class="published-date">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Dipublikasi {{ ($post->published_at ?? $post->created_at)->format('M d, Y') }}</span>
                                    </div>

                                    <!-- Categories - Separate line with proper wrapping -->
                                    <div class="category-tags">
                                        @foreach($post->categories as $cat)
                                            <span class="category-tag">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                    <h2 class="post-title text-xl md:text-2xl font-bold mb-3">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="transition-colors"
                                            style="color: var(--text-primary);" onmouseover="this.style.color='var(--accent-color)'"
                                            onmouseout="this.style.color='var(--text-primary)'">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    @if($post->excerpt)
                                        <p class="post-excerpt text-base mb-4 leading-relaxed font-medium"
                                            style="color: var(--text-secondary);">
                                            {{ $post->excerpt }}
                                        </p>
                                    @else
                                        <p class="post-excerpt text-base mb-4 leading-relaxed" style="color: var(--text-secondary);">
                                            {{ Str::limit(strip_tags($post->body), 200) }}
                                        </p>
                                    @endif
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                                        <div class="author-info flex items-center gap-2">
                                            @if($post->user->avatar)
                                                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}"
                                                    class="w-8 h-8 rounded-full object-cover border"
                                                    style="border-color: var(--accent-color);">
                                            @else
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                                                    style="background-color: var(--accent-color);">
                                                    {{ substr($post->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="text-sm font-medium" style="color: var(--text-secondary);">
                                                {{ $post->user->name }}
                                            </span>
                                        </div>
                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="btn-primary text-sm font-medium w-full sm:w-auto">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="card rounded-xl p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center"
                            style="background-color: var(--bg-secondary);">
                            <svg class="w-12 h-12" style="color: var(--text-secondary);" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2" style="color: var(--text-primary);">TIDAK ADA POSTINGAN</h3>
                        <p style="color: var(--text-secondary);">
                            {{ isset($category) ? 'Tidak ada post ditemukan dalam kategori ini.' : 'Belum ada post yang dipublikasi.' }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
            <div class="space-y-8">
                <!-- Categories -->
                <div class="card rounded-xl p-4 sm:p-6 sidebar-card">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Kategori</h3>
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
                        <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Postingan Terbaru</h3>
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($latestPosts as $recent)
                                <a href="{{ route('blog.show', $recent->slug) }}" class="block group min-h-10">
                                    <div class="flex gap-3">
                                        @if($recent->image)
                                            <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}"
                                                class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg flex-shrink-0">
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-sm leading-tight mb-1 group-hover:text-opacity-80 transition-colors"
                                                style="color: var(--text-primary);">
                                                {{ Str::limit($recent->title, 50) }}
                                            </h4>
                                            <p class="text-xs" style="color: var(--text-secondary);">
                                                {{ ($recent->published_at ?? $recent->created_at)->format('M d, Y') }}
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