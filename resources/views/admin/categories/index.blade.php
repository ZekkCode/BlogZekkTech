@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <style>
        /* Admin categories table responsive styling */
        .categories-table {
            min-width: 100%;
        }

        .categories-table td {
            vertical-align: top;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .categories-table {
                font-size: 0.75rem;
                display: block;
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
            }

            .categories-table thead,
            .categories-table tbody,
            .categories-table th,
            .categories-table td,
            .categories-table tr {
                display: block;
            }

            .categories-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .categories-table tr {
                border: 1px solid var(--border-color);
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                padding: 1rem;
                background-color: var(--bg-secondary);
            }

            .categories-table td {
                border: none;
                position: relative;
                padding: 0.5rem 0;
                margin-bottom: 0.75rem;
                white-space: normal;
            }

            .categories-table td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--text-primary);
                display: inline-block;
                width: 25%;
                margin-right: 0.5rem;
            }

            .categories-table td .flex {
                justify-content: flex-start;
                gap: 1rem;
                margin-top: 0.5rem;
            }

            .categories-table td .flex a,
            .categories-table td .flex button {
                padding: 0.5rem;
                border-radius: 0.75rem;
                background-color: var(--bg-primary);
                border: 1px solid var(--border-color);
            }
        }

        @media (max-width: 480px) {
            .categories-table {
                font-size: 0.7rem;
            }

            .categories-table tr {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }

            .categories-table td {
                padding: 0.375rem 0;
                margin-bottom: 0.5rem;
            }

            .categories-table td:before {
                width: 30%;
                font-size: 0.75rem;
            }

            .categories-table td .flex {
                gap: 0.75rem;
            }

            .categories-table td .flex a,
            .categories-table td .flex button {
                padding: 0.375rem;
                border-radius: 0.75rem;
            }
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold" style="color: var(--text-primary);">Manage Categories</h1>
                <a href="{{ asset('admin_guide.html') }}" target="_blank" class="text-sm transition-colors"
                    style="color: var(--accent-color);" onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'">View Admin Guide</a>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="btn-primary font-bold py-2 px-3 sm:px-4 rounded-xl text-sm sm:text-base w-full sm:w-auto text-center">
                Create New Category
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="card rounded-lg overflow-hidden">
            <table class="categories-table w-full text-left">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th class="px-6 py-3" style="color: var(--text-primary);">Name</th>
                        <th class="px-6 py-3" style="color: var(--text-primary);">Slug</th>
                        <th class="px-6 py-3" style="color: var(--text-primary);">Posts</th>
                        <th class="px-6 py-3" style="color: var(--text-primary);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr style="border-bottom: 1px solid var(--border-color);"
                            onmouseover="this.style.backgroundColor='var(--bg-primary)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <td class="px-6 py-4" data-label="Name" style="color: var(--text-primary);">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4" data-label="Slug" style="color: var(--text-secondary);">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4" data-label="Posts" style="color: var(--text-secondary);">
                                {{ $category->posts_count }}
                            </td>
                            <td class="px-6 py-4" data-label="Actions">
                                <div class="flex space-x-2">
                                    <a href="{{ route('blog.category', $category->slug) }}" class="transition-colors"
                                        target="_blank" style="color: var(--accent-color);"
                                        onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"
                                        title="View Category">
                                        <span class="sr-only">View</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="text-amber-400 hover:text-amber-300" title="Edit Category">
                                        <span class="sr-only">Edit</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        class="inline-block" id="deleteForm{{ $category->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-400 hover:text-red-300"
                                            onclick="customConfirm('Are you sure you want to delete this category? This will NOT delete associated posts.', function(result) { if(result) document.getElementById('deleteForm{{ $category->id }}').submit(); })"
                                            title="Delete Category">
                                            <span class="sr-only">Delete</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($categories->count() == 0)
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center" style="color: var(--text-secondary);">
                                No categories found. <a href="{{ route('admin.categories.create') }}"
                                    style="color: var(--accent-color);">Create your first category</a>.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection