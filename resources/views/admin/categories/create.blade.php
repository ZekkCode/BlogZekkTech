@extends('layouts.admin')

@section('title', 'Create New Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Create New Category</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block mb-2" style="color: var(--text-primary);">Category Name</label>
                <input type="text" name="name" id="name" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary); focus:ring-color: var(--accent-color);"
                    value="{{ old('name') }}" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary font-bold py-2 px-4 rounded-lg mr-2">Cancel</a>
                <button type="submit" class="btn-primary font-bold py-2 px-4 rounded-lg">Create Category</button>
            </div>
        </form>
    </div>
</div>
@endsection