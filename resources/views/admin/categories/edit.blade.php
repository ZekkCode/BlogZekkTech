@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Edit Category: {{ $category->name }}</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block mb-2" style="color: var(--text-primary);">Category Name</label>
                <input type="text" name="name" id="name" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                    value="{{ old('name', $category->name) }}" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2" style="color: var(--text-primary);">Category Slug</label>
                <div class="rounded-lg px-4 py-2" style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-secondary);">
                    {{ $category->slug }}
                    <p class="text-sm mt-1">Slug is automatically generated from the name.</p>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2" style="color: var(--text-primary);">Posts in Category</label>
                <div class="rounded-lg px-4 py-2" style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
                    {{ $category->posts()->count() }}
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary font-bold py-2 px-4 rounded-lg mr-2">Cancel</a>
                <button type="submit" class="btn-primary font-bold py-2 px-4 rounded-lg">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection