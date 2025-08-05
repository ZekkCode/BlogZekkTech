@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
    <style>
        /* Mobile responsive styling for edit category */
        @media (max-width: 768px) {
            .max-w-4xl {
                padding: 0 1rem;
            }

            .card {
                margin: 0 -1rem;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            h1 {
                font-size: 1.5rem;
                line-height: 1.3;
            }

            input {
                font-size: 1rem;
                padding: 0.75rem !important;
            }

            .flex.items-center.justify-end {
                flex-direction: column;
                gap: 0.5rem;
            }

            .flex.items-center.justify-end a,
            .flex.items-center.justify-end button {
                width: 100%;
                text-align: center;
                margin: 0;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.25rem;
            }

            input {
                font-size: 0.875rem;
                padding: 0.625rem !important;
            }

            label {
                font-size: 0.875rem;
            }

            .text-sm {
                font-size: 0.75rem;
            }
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <div class="card rounded-lg p-4 sm:p-6">
            <h1 class="text-xl sm:text-2xl font-bold mb-6" style="color: var(--text-primary);">Edit Category:
                {{ $category->name }}</h1>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block mb-2" style="color: var(--text-primary);">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2" style="color: var(--text-primary);">Category Slug</label>
                    <div class="rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-secondary);">
                        {{ $category->slug }}
                        <p class="text-sm mt-1">Slug is automatically generated from the name.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2" style="color: var(--text-primary);">Posts in Category</label>
                    <div class="rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
                        {{ $category->posts()->count() }}
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end mt-6 gap-2 sm:gap-0">
                    <a href="{{ route('admin.categories.index') }}"
                        class="btn-secondary font-bold py-2 px-4 rounded-xl sm:mr-2 w-full sm:w-auto text-center order-2 sm:order-1">Cancel</a>
                    <button type="submit"
                        class="btn-primary font-bold py-2 px-4 rounded-xl w-full sm:w-auto order-1 sm:order-2">Update
                        Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection