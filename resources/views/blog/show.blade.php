@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Import Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Natural article styling with Poppins */
        .post-content {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-primary);
            max-width: none;
            font-weight: 400;
            min-height: 500px;
            margin-bottom: 2rem;
            /* Normal text flow for natural reading */
            white-space: normal;
            word-wrap: break-word;
        }

        /* Mobile responsive untuk post content */
        @media (max-width: 768px) {
            .post-content {
                font-size: 1rem;
                line-height: 1.6;
                padding: 0 0.5rem;
                min-height: 300px;
            }
        }

        @media (max-width: 480px) {
            .post-content {
                font-size: 0.95rem;
                line-height: 1.5;
                padding: 0 0.25rem;
            }
        }

        /* Container untuk main content dengan max height jika perlu */
        .main-content {
            min-height: calc(100vh - 200px);
            /* Pastikan minimal tinggi untuk konten utama */
        }

        /* Paragraphs - natural spacing */
        .post-content p {
            margin-bottom: 1.25rem;
            text-align: left;
            line-height: 1.7;
        }

        /* Mobile paragraph spacing */
        @media (max-width: 768px) {
            .post-content p {
                margin-bottom: 1rem;
                line-height: 1.6;
            }
        }

        /* Line breaks - natural */
        .post-content br {
            margin-bottom: 0.5rem;
        }

        /* Headings - clean hierarchy with Poppins */
        .post-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.25rem;
            font-weight: 700;
            margin: 2.5rem 0 1.5rem 0;
            line-height: 1.2;
            color: var(--text-primary);
        }

        /* Mobile headings */
        @media (max-width: 768px) {
            .post-content h1 {
                font-size: 1.8rem;
                margin: 2rem 0 1rem 0;
            }
        }

        @media (max-width: 480px) {
            .post-content h1 {
                font-size: 1.6rem;
                margin: 1.5rem 0 0.75rem 0;
            }
        }

        .post-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.875rem;
            font-weight: 600;
            margin: 2rem 0 1rem 0;
            line-height: 1.3;
            color: var(--text-primary);
        }

        /* Mobile h2 */
        @media (max-width: 768px) {
            .post-content h2 {
                font-size: 1.5rem;
                margin: 1.5rem 0 0.75rem 0;
            }
        }

        @media (max-width: 480px) {
            .post-content h2 {
                font-size: 1.3rem;
            }
        }

        .post-content h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 1.75rem 0 0.875rem 0;
            line-height: 1.4;
            color: var(--text-primary);
        }

        /* Mobile h3 */
        @media (max-width: 768px) {
            .post-content h3 {
                font-size: 1.25rem;
                margin: 1.25rem 0 0.625rem 0;
            }
        }

        @media (max-width: 480px) {
            .post-content h3 {
                font-size: 1.125rem;
            }
        }

        .post-content h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 0.75rem 0;
            color: var(--text-primary);
        }

        .post-content h5,
        .post-content h6 {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 1.25rem 0 0.625rem 0;
            color: var(--text-primary);
        }

        /* Lists - better spacing */
        .post-content ul,
        .post-content ol {
            margin: 1.5rem 0;
            padding-left: 2rem;
        }

        .post-content li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .post-content li p {
            margin-bottom: 0.5rem;
        }

        /* Blockquotes - elegant styling */
        .post-content blockquote {
            border-left: 4px solid var(--accent-color);
            margin: 2rem 0;
            padding: 1.5rem 2rem;
            background-color: var(--bg-secondary);
            border-radius: 0.5rem;
            font-style: italic;
            position: relative;
        }

        .post-content blockquote p {
            margin-bottom: 0;
        }

        /* Code blocks - clean and readable */
        .post-content code {
            background-color: var(--bg-secondary);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.9rem;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            border: 1px solid var(--border-color);
        }

        .post-content pre {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 2rem 0;
            font-size: 0.875rem;
        }

        .post-content pre code {
            background: none;
            padding: 0;
            border: none;
            font-size: inherit;
        }

        /* Links - subtle but clear */
        .post-content a {
            color: var(--accent-color);
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
            transition: all 0.2s ease;
        }

        .post-content a:hover {
            text-decoration-thickness: 2px;
            opacity: 0.8;
        }

        /* Images - responsive and centered */
        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 2rem auto;
            display: block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Tables - clean styling */
        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .post-content th,
        .post-content td {
            padding: 0.875rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .post-content th {
            background-color: var(--bg-secondary);
            font-weight: 600;
        }

        /* Horizontal rules */
        .post-content hr {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 3rem 0;
        }

        /* Strong and emphasis */
        .post-content strong {
            font-weight: 600;
            color: var(--text-primary);
        }

        .post-content em {
            font-style: italic;
        }

        /* First paragraph special styling */
        .post-content>p:first-child {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: var(--text-primary);
        }

        /* Sidebar styling */
        .sidebar {
            font-family: 'Poppins', sans-serif;
            position: sticky;
            top: 120px;
            /* Offset dari header sticky */
            max-height: calc(100vh - 140px);
            /* Tinggi viewport minus offset */
            overflow-y: auto;
            padding-right: 8px;
            /* Space untuk scrollbar */
            scroll-behavior: smooth;
        }

        /* Responsive height untuk mobile */
        @media (max-width: 1024px) {
            .sidebar {
                position: static;
                max-height: none;
                overflow-y: visible;
                padding-right: 0;
            }

            .sidebar-widget {
                max-height: 300px;
                /* Lebih pendek di mobile */
            }
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--bg-primary);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
            transition: background 0.2s ease;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* Untuk Firefox */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) var(--bg-primary);
        }

        /* Mobile layout - stack sidebar below content */
        @media (max-width: 1024px) {
            .grid-cols-1.lg\\:grid-cols-3 {
                display: block !important;
            }

            .sidebar {
                margin-top: 2rem;
                max-height: none;
                position: static;
                overflow-y: visible;
            }

            .sidebar-widget {
                max-height: none;
                margin-bottom: 1.5rem;
            }
        }

        /* Extra mobile responsive */
        @media (max-width: 768px) {
            .sidebar-widget {
                padding: 1rem;
                margin-bottom: 1rem;
            }
        }

        .sidebar-widget {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            max-height: 400px;
            /* Batasi tinggi maksimal widget */
            overflow-y: auto;
        }

        /* Custom scrollbar untuk widget */
        .sidebar-widget::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-widget::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-widget::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 2px;
        }

        .sidebar-widget::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        .sidebar-widget h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-item:hover {
            background-color: var(--bg-primary);
            border-radius: 8px;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .category-link {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .category-link:hover {
            color: var(--accent-color);
        }

        .category-count {
            background-color: var(--accent-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 500;
        }

        .related-post-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .related-post-item:last-child {
            border-bottom: none;
        }

        .related-post-item:hover {
            background-color: var(--bg-primary);
            border-radius: 8px;
            padding: 1rem;
        }

        .related-post-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-cover: cover;
            flex-shrink: 0;
            background-color: var(--border-color);
        }

        .related-post-content h4 {
            font-size: 0.95rem;
            font-weight: 500;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .related-post-content a {
            text-decoration: none;
            color: var(--text-primary);
            transition: color 0.2s ease;
        }

        .related-post-content a:hover {
            color: var(--accent-color);
        }

        .related-post-meta {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Desktop - show all categories */
        @media (min-width: 769px) {
            .hidden-mobile {
                display: inline-block !important;
            }

            .categories-overflow {
                display: none !important;
            }
        }

        /* Mobile Layout Improvements - Natural & Clean untuk Handphone */
        @media (max-width: 768px) {

            /* Container mobile - padding natural */
            .max-w-7xl {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                max-width: 100% !important;
            }

            /* Grid mobile - spacing natural */
            .grid {
                gap: 1rem !important;
            }

            /* Main content mobile - hapus card styling, natural flow */
            .main-content {
                min-height: auto;
                padding: 0;
                background: transparent;
                border-radius: 0;
                box-shadow: none;
            }

            /* Post header mobile - spacing yang natural */
            .mb-6 {
                margin-bottom: 1rem !important;
            }

            .sm\\:mb-8 {
                margin-bottom: 1rem !important;
            }

            /* Title mobile - typography natural, lebih kecil */
            h1.mb-4 {
                margin-bottom: 0.75rem !important;
                font-size: 1.5rem !important;
                line-height: 1.3 !important;
                font-weight: 700 !important;
                color: var(--text-primary);
            }

            /* Categories mobile - layout natural, lebih kecil */
            .flex-wrap {
                gap: 0.375rem !important;
                margin-bottom: 0.75rem;
            }

            /* Category tags mobile - compact design */
            .inline-block {
                font-size: 0.75rem !important;
                padding: 0.25rem 0.5rem !important;
                min-height: auto !important;
            }

            /* Hide extra categories on mobile */
            .hidden-mobile {
                display: none !important;
            }

            /* Show categories overflow indicator */
            .categories-overflow {
                display: inline-block !important;
                font-size: 0.75rem !important;
                color: var(--text-secondary) !important;
                background: var(--bg-secondary) !important;
                padding: 0.25rem 0.5rem !important;
                border-radius: 9999px !important;
            }

            /* Author info mobile - natural styling, lebih kecil */
            .text-sm {
                font-size: 0.8rem !important;
                line-height: 1.4;
                color: var(--text-secondary);
            }

            /* Sidebar mobile - natural background, lebih kompak */
            .lg\\:w-1\\/3>div {
                background: var(--bg-secondary);
                border-radius: 0.5rem;
                padding: 0.75rem !important;
            }

            /* Post content mobile - natural reading experience, lebih kecil */
            .post-content {
                padding: 0 !important;
                font-size: 0.95rem !important;
                line-height: 1.6 !important;
                background: transparent;
            }

            /* Fix untuk gambar di konten markdown */
            .post-content img {
                width: 100% !important;
                height: auto !important;
                border-radius: 0.5rem !important;
                margin: 1rem 0 !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
            }

            /* Fix untuk code blocks di mobile */
            .post-content pre {
                overflow-x: auto !important;
                font-size: 0.85rem !important;
                padding: 0.75rem !important;
                border-radius: 0.375rem !important;
            }

            .post-content code {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 480px) {

            /* Extra small mobile - natural compact layout */
            .max-w-7xl {
                padding-left: 0.625rem !important;
                padding-right: 0.625rem !important;
            }

            /* Main content - natural flow */
            .main-content {
                padding: 0 !important;
            }

            /* Header info mobile - natural inline layout, lebih kecil */
            .flex-wrap:first-of-type {
                flex-direction: row;
                align-items: center !important;
                gap: 0.375rem !important;
                flex-wrap: wrap;
                padding: 0;
                background: transparent;
                border-radius: 0;
                margin-bottom: 0.75rem;
            }

            /* Separator untuk mobile */
            .flex-wrap:first-of-type span.mx-2 {
                display: inline !important;
            }

            /* Categories mobile - natural chips, lebih kecil */
            .flex-wrap:last-child {
                flex-direction: row;
                align-items: center !important;
                margin-top: 0.5rem;
                flex-wrap: wrap;
            }

            /* Extra small mobile - category tags super compact */
            .inline-block {
                font-size: 0.7rem !important;
                padding: 0.2rem 0.4rem !important;
                border-radius: 0.375rem !important;
            }

            /* Limit to max 3 categories on small screens */
            .flex-wrap>a:nth-child(n+3) {
                display: none !important;
            }

            /* Categories overflow indicator */
            .categories-container {
                position: relative;
            }

            /* Show indicator for hidden categories */
            .categories-overflow {
                font-size: 0.7rem !important;
                color: var(--text-secondary) !important;
                background: var(--bg-secondary) !important;
                padding: 0.2rem 0.4rem !important;
                border-radius: 0.375rem !important;
                margin-left: 0.25rem;
            }

            /* Title mobile - natural sizing, lebih kecil */
            h1 {
                font-size: 1.25rem !important;
                line-height: 1.3 !important;
                margin-bottom: 0.75rem !important;
                font-weight: 700 !important;
            }

            /* Post content mobile - natural reading, lebih kecil */
            .post-content {
                padding: 0 !important;
                font-size: 0.9rem !important;
                line-height: 1.5 !important;
                margin-top: 1rem !important;
            }

            /* Sidebar mobile - natural cards, lebih kompak */
            .lg\\:w-1\\/3>div {
                padding: 0.625rem !important;
                margin-bottom: 0.75rem;
                border-radius: 0.5rem;
            }

            /* Author info text lebih kecil */
            .text-sm {
                font-size: 0.75rem !important;
            }
        }
    </style>

    <!-- Main Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content (Article) -->
            <div class="lg:col-span-2 main-content">
                <!-- Post Header -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-wrap items-center text-sm mb-3" style="color: var(--text-secondary);">
                        <span>{{ $post->published_at->format('Y-m-d') }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ Str::readingTime($post->body) }} Mnt Telah Dibaca</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 leading-tight"
                        style="color: var(--text-primary);">{{ $post->title }}</h1>
                    <div class="flex flex-wrap items-center gap-2 categories-container">
                        @php
                            $totalCategories = $post->categories->count();
                            $maxCategoriesDisplay = 3; // Max categories to show on mobile
                        @endphp

                        @foreach($post->categories->take($maxCategoriesDisplay) as $category)
                            <a href="{{ route('blog.category', $category->slug) }}"
                                class="inline-block px-3 py-1 text-sm rounded-full min-h-8 transition-colors hover:shadow-md"
                                style="background-color: var(--accent-color); color: white;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                {{ $category->name }}
                            </a>
                        @endforeach

                        @if($totalCategories > $maxCategoriesDisplay)
                            <span class="categories-overflow hidden-mobile">
                                +{{ $totalCategories - $maxCategoriesDisplay }} lagi
                            </span>
                        @endif

                        <!-- Show all categories on desktop -->
                        @foreach($post->categories->skip($maxCategoriesDisplay) as $category)
                            <a href="{{ route('blog.category', $category->slug) }}"
                                class="inline-block px-3 py-1 text-sm rounded-full min-h-8 transition-colors hover:shadow-md hidden-mobile"
                                style="background-color: var(--accent-color); color: white;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Featured Image -->
                @if($post->image)
                    <div class="mb-6 sm:mb-8">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="w-full rounded-lg shadow-lg object-cover" style="max-height: 400px; aspect-ratio: 1.91/1;"
                            loading="lazy">
                    </div>
                @endif

                <!-- Post Content -->
                <article class="post-content" style="color: var(--text-primary);">
                    {!! \App\Helpers\Str::markdownToHtml($post->body) !!}
                </article>

                <!-- Author Info -->
                <div class="mt-8 sm:mt-12 pt-6 sm:pt-8" style="border-top: 1px solid var(--border-color);">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex items-center gap-4">
                            @if($post->user->avatar)
                                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}"
                                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full flex-shrink-0 object-cover border-2"
                                    style="border-color: var(--accent-color);">
                            @else
                                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center text-lg sm:text-xl font-bold text-white flex-shrink-0"
                                    style="background-color: var(--accent-color);">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg sm:text-xl font-semibold" style="color: var(--text-primary);">
                                    {{ $post->user->name }}
                                </h3>
                                <p class="text-sm" style="color: var(--text-secondary);">Penulis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                @include('components.comments-new', ['post' => $post])

                <!-- Navigation -->
                <div class="mt-12 pt-8" style="border-top: 1px solid var(--border-color);">
                    <div class="flex justify-between">
                        <a href="{{ route('home') }}" class="inline-flex items-center transition-colors"
                            style="color: var(--accent-color);" onmouseover="this.style.opacity='0.8'"
                            onmouseout="this.style.opacity='1'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 sidebar">

                <!-- Kategori Widget -->
                <div class="sidebar-widget">
                    <h3>Kategori</h3>
                    <div class="space-y-1">
                        @php
                            $categories = \App\Models\Category::withCount('posts')->orderBy('posts_count', 'desc')->take(8)->get();
                        @endphp
                        @foreach($categories as $category)
                            <div class="category-item">
                                <a href="{{ route('blog.category', $category->slug) }}" class="category-link">
                                    {{ $category->name }}
                                </a>
                                <span class="category-count">{{ $category->posts_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Related Posts Widget -->
                <div class="sidebar-widget">
                    <h3>Postingan Terkait</h3>
                    <div class="space-y-1">
                        @php
                            // Cari post dengan kategori yang sama terlebih dahulu
                            $relatedPosts = \App\Models\Post::where('id', '!=', $post->id)
                                ->whereHas('categories', function ($query) use ($post) {
                                    $query->whereIn('categories.id', $post->categories->pluck('id'));
                                })
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get();

                            // Jika tidak cukup, tambahkan post random lainnya
                            if ($relatedPosts->count() < 5) {
                                $additionalPosts = \App\Models\Post::where('id', '!=', $post->id)
                                    ->whereNotIn('id', $relatedPosts->pluck('id'))
                                    ->inRandomOrder()
                                    ->take(5 - $relatedPosts->count())
                                    ->get();
                                $relatedPosts = $relatedPosts->merge($additionalPosts);
                            }
                        @endphp

                        @if($relatedPosts->count() > 0)
                            @foreach($relatedPosts as $relatedPost)
                                <div class="related-post-item">
                                    <div class="related-post-image">
                                        @if($relatedPost->image)
                                            <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center rounded-lg"
                                                style="background-color: var(--border-color);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                                                    style="color: var(--text-secondary);" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="related-post-content flex-1">
                                        <h4>
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                                {{ Str::limit($relatedPost->title, 60) }}
                                            </a>
                                        </h4>
                                        <div class="related-post-meta">
                                            {{ $relatedPost->published_at->format('M d, Y') }}
                                            @if($relatedPost->categories->intersect($post->categories)->count() > 0)
                                                <span style="color: var(--accent-color); font-size: 0.7rem;">● Same Category</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4" style="color: var(--text-secondary);">
                                <p>Tidak ada postingan terkait ditemukan</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Latest Posts Widget -->
                <!-- Latest Posts Widget -->
                <div class="sidebar-widget">
                    <h3>Latest Posts</h3>
                    <div class="space-y-1">
                        @php
                            $latestPosts = \App\Models\Post::where('id', '!=', $post->id)
                                ->whereNotNull('published_at')
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @if($latestPosts->count() > 0)
                            @foreach($latestPosts as $latestPost)
                                <div class="related-post-item">
                                    <div class="related-post-image">
                                        @if($latestPost->image)
                                            <img src="{{ asset('storage/' . $latestPost->image) }}" alt="{{ $latestPost->title }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center rounded-lg"
                                                style="background-color: var(--border-color);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                                                    style="color: var(--text-secondary);" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="related-post-content flex-1">
                                        <h4>
                                            <a href="{{ route('blog.show', $latestPost->slug) }}">
                                                {{ Str::limit($latestPost->title, 60) }}
                                            </a>
                                        </h4>
                                        <div class="related-post-meta">
                                            {{ $latestPost->published_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4" style="color: var(--text-secondary);">
                                <p>Tidak ada postingan terbaru ditemukan</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Comments Section -->
        @include('components.comments-new', ['post' => $post])
    </div>
@endsection