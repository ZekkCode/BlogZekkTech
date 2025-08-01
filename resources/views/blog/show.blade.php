@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6">
    <!-- Post Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-center text-sm mb-3" style="color: var(--text-secondary);">
            <span>{{ $post->published_at->format('Y-m-d') }}</span>
            <span class="mx-2">•</span>
            <span>{{ $post->user->name }}</span>
            <span class="mx-2">•</span>
            <span>{{ Str::readingTime($post->body) }} min read</span>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 leading-tight" style="color: var(--text-primary);">{{ $post->title }}</h1>
        <div class="flex flex-wrap items-center gap-2">
            @foreach($post->categories as $category)
            <a href="{{ route('blog.category', $category->slug) }}"
                class="inline-block px-3 py-1 text-sm rounded-full min-h-8 transition-colors hover:shadow-md"
                style="background-color: var(--accent-color); color: white;"
                onmouseover="this.style.opacity='0.8'"
                onmouseout="this.style.opacity='1'">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Image -->
    @if($post->image)
    <div class="mb-6 sm:mb-8">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
            class="w-full rounded-lg shadow-lg object-cover"
            style="max-height: 300px; aspect-ratio: 1.91/1;">
    </div>
    @endif

    <!-- Post Content -->
    <div class="prose prose-invert prose-lg max-w-none post-content" style="color: var(--text-primary);">
        {!! \App\Helpers\Str::markdownToHtml($post->body) !!}
    </div>

    <!-- Author Info -->
    <div class="mt-8 sm:mt-12 pt-6 sm:pt-8" style="border-top: 1px solid var(--border-color);">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/avatar.png') }}" alt="{{ $post->user->name }}"
                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full flex-shrink-0">
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold" style="color: var(--text-primary);">{{ $post->user->name }}</h3>
                    <p class="text-sm" style="color: var(--text-secondary);">Author</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="mt-12 pt-8 border-t border-gray-800">
        <div class="flex justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection