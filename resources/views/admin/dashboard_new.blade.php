@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('admin_nav')
    <nav style="background-color: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center">
                    <span class="font-semibold" style="color: var(--text-primary);">Panel Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        style="color: var(--text-secondary);" onmouseover="this.style.color='var(--accent-color)'"
                        onmouseout="this.style.color='var(--text-secondary)'">Kategori</a>
                    <a href="{{ route('admin.posts.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        style="color: var(--text-secondary);" onmouseover="this.style.color='var(--accent-color)'"
                        onmouseout="this.style.color='var(--text-secondary)'">Posts</a>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="card rounded-xl p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4" style="color: var(--text-primary);">Selamart Datang di Dashboard</h2>
            <p class="mb-4" style="color: var(--text-secondary);">dirimu Bisa Manajemen Website punyamu disini..</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                <div class="card rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Posts</h3>
                    <p class="mb-4" style="color: var(--text-secondary);">Manage your blog posts</p>
                    <a href="{{ route('admin.posts.index') }}" class="btn-primary inline-flex items-center">
                        Lihat Postingan
                    </a>
                </div>

                <div class="card rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Kategori</h3>
                    <p class="mb-4" style="color: var(--text-secondary);">Manajemen Kategori</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn-primary inline-flex items-center">
                        Lihat Kategori
                    </a>
                </div>

                <div class="card rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Website</h3>
                    <p class="mb-4" style="color: var(--text-secondary);">Lihat Website Saya</p>
                    <a href="{{ route('home') }}" class="btn-primary inline-flex items-center">
                        Lihat Website
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        @if(isset($stats))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold mb-2" style="color: var(--accent-color);">{{ $stats['posts'] }}</div>
                    <div style="color: var(--text-secondary);">Total Postingan</div>
                </div>
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold mb-2" style="color: var(--accent-color);">{{ $stats['categories'] }}</div>
                    <div style="color: var(--text-secondary);">Kategori</div>
                </div>
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold mb-2" style="color: var(--accent-color);">{{ $stats['users'] }}</div>
                    <div style="color: var(--text-secondary);">User</div>
                </div>
            </div>
        @endif

        <!-- Recent Posts -->
        @if(isset($latestPosts) && $latestPosts->count() > 0)
            <div class="card rounded-xl p-6">
                <h3 class="text-xl font-bold mb-4" style="color: var(--text-primary);">Postingan Terbaru</h3>
                <div class="space-y-4">
                    @foreach($latestPosts as $post)
                        <div class="flex items-center gap-4 p-4 rounded-lg" style="background-color: var(--bg-secondary);">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold" style="color: var(--text-primary);">{{ $post->title }}</h4>
                                <p class="text-sm" style="color: var(--text-secondary);">
                                    by {{ $post->user->name }} • {{ $post->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn-primary text-sm">
                                Edit
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Logo Preview -->
        <div class="card rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4" style="color: var(--text-primary);">Lihat Logo</h3>
            <div class="flex justify-center">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name', 'BlogZekkTech') }} Logo" class="h-24">
            </div>
        </div>
    </div>
@endsection