@extends('layouts.admin')

@section('title', 'Manage Posts')

@section('content')
<style>
    /* Admin table responsive styling */
    .admin-table {
        min-width: 100%;
    }

    .admin-table td {
        vertical-align: top;
    }

    /* Category scroll container */
    .category-scroll {
        max-height: 4rem;
        overflow-y: auto;
    }

    .category-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .category-scroll::-webkit-scrollbar-track {
        background: var(--bg-primary);
        border-radius: 2px;
    }

    .category-scroll::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 2px;
    }

    .category-scroll::-webkit-scrollbar-thumb:hover {
        background: var(--text-secondary);
    }

    /* Published status styling */
    .status-published {
        background-color: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 0.5rem;
        padding: 0.75rem;
    }

    .status-draft {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.75rem;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .admin-table {
            font-size: 0.875rem;
        }

        .admin-table td,
        .admin-table th {
            padding: 0.75rem 0.5rem;
        }

        .category-scroll {
            max-height: 3rem;
        }
    }
</style>

<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold" style="color: var(--text-primary);">Manage Posts</h1>
            <a href="{{ asset('admin_guide.html') }}" target="_blank" class="text-sm transition-colors"
                style="color: var(--accent-color);"
                onmouseover="this.style.textDecoration='underline'"
                onmouseout="this.style.textDecoration='none'">View Admin Guide</a>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn-primary font-bold py-2 px-4 rounded-lg">
            Create New Post
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="card rounded-lg overflow-hidden">
        <table class="admin-table w-full text-left">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <th class="px-6 py-3" style="color: var(--text-primary);">Title & Categories</th>
                    <th class="px-6 py-3" style="color: var(--text-primary);">Published</th>
                    <th class="px-6 py-3" style="color: var(--text-primary);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr style="border-bottom: 1px solid var(--border-color);"
                    onmouseover="this.style.backgroundColor='var(--bg-primary)'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td class="px-6 py-4">
                        <div class="font-medium mb-2" style="color: var(--text-primary);">{{ $post->title }}</div>
                        @if($post->excerpt)
                        <div class="text-sm mb-2" style="color: var(--text-secondary);">{{ Str::limit($post->excerpt, 80) }}</div>
                        @endif
                        <!-- Categories with max height and scroll if needed -->
                        <div class="category-scroll flex flex-wrap gap-1">
                            @foreach($post->categories as $category)
                            <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap" style="background-color: var(--accent-color); color: white;">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($post->published_at)
                        <div class="status-published">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-green-600">Published</div>
                                    <div class="text-xs" style="color: var(--text-secondary);">{{ $post->published_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="status-draft">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <div class="text-sm font-medium" style="color: var(--text-secondary);">Draft</div>
                                    <div class="text-xs" style="color: var(--text-secondary);">Not published</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="transition-colors" target="_blank"
                                style="color: var(--accent-color);"
                                onmouseover="this.style.opacity='0.8'"
                                onmouseout="this.style.opacity='1'">
                                <span class="sr-only">View</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-amber-400 hover:text-amber-300">
                                <span class="sr-only">Edit</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this post?')">
                                    <span class="sr-only">Delete</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if($posts->count() == 0)
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center" style="color: var(--text-secondary);">
                        No posts found. <a href="{{ route('admin.posts.create') }}" style="color: var(--accent-color);">Create your first post</a>.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection