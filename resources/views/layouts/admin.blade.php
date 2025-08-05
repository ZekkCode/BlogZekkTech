@extends('layouts.app')

@section('admin_nav')
    <div style="background-color: var(--bg-secondary); border-bottom: 1px solid var(--border-color);" class="mb-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex space-x-2 sm:space-x-4 overflow-x-auto">
                <a href="{{ route('admin.posts.index') }}"
                    class="px-3 sm:px-4 py-3 inline-block whitespace-nowrap text-sm sm:text-base {{ request()->routeIs('admin.posts.*') ? 'font-medium' : '' }}"
                    style="color: {{ request()->routeIs('admin.posts.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}; {{ request()->routeIs('admin.posts.*') ? 'border-bottom: 2px solid var(--accent-color);' : '' }}"
                    onmouseover="this.style.color='var(--accent-color)'"
                    onmouseout="this.style.color='{{ request()->routeIs('admin.posts.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}'">
                    Posts
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="px-3 sm:px-4 py-3 inline-block whitespace-nowrap text-sm sm:text-base {{ request()->routeIs('admin.categories.*') ? 'font-medium' : '' }}"
                    style="color: {{ request()->routeIs('admin.categories.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}; {{ request()->routeIs('admin.categories.*') ? 'border-bottom: 2px solid var(--accent-color);' : '' }}"
                    onmouseover="this.style.color='var(--accent-color)'"
                    onmouseout="this.style.color='{{ request()->routeIs('admin.categories.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}'">
                    Kategori
                </a>
                <div class="flex-grow"></div>
                <div class="py-3 px-2 sm:px-4 text-xs hidden sm:block" style="color: var(--text-secondary);">Dibuat oleh
                    ZekkTech</div>
            </div>
        </div>
    </div>
@endsection