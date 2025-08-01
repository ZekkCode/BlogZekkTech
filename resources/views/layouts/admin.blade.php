@extends('layouts.app')

@section('admin_nav')
<div style="background-color: var(--bg-secondary); border-bottom: 1px solid var(--border-color);" class="mb-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex space-x-4 overflow-x-auto">
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-3 inline-block whitespace-nowrap {{ request()->routeIs('admin.posts.*') ? 'font-medium' : '' }}"
                style="color: {{ request()->routeIs('admin.posts.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}; {{ request()->routeIs('admin.posts.*') ? 'border-bottom: 2px solid var(--accent-color);' : '' }}"
                onmouseover="this.style.color='var(--accent-color)'"
                onmouseout="this.style.color='{{ request()->routeIs('admin.posts.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}'">
                Posts
            </a>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-3 inline-block whitespace-nowrap {{ request()->routeIs('admin.categories.*') ? 'font-medium' : '' }}"
                style="color: {{ request()->routeIs('admin.categories.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}; {{ request()->routeIs('admin.categories.*') ? 'border-bottom: 2px solid var(--accent-color);' : '' }}"
                onmouseover="this.style.color='var(--accent-color)'"
                onmouseout="this.style.color='{{ request()->routeIs('admin.categories.*') ? 'var(--accent-color)' : 'var(--text-secondary)' }}'">
                Categories
            </a>
            <div class="flex-grow"></div>
            <div class="py-3 px-4 text-xs" style="color: var(--text-secondary);">Powered by ZekkTech</div>
        </div>
    </div>
</div>
@endsection