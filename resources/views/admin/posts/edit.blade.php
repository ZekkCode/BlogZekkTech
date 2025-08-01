@extends('layouts.admin')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card rounded-lg p-6 mb-8">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Edit Post: {{ $post->title }}</h1>

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block mb-2" style="color: var(--text-primary);">Title</label>
                <input type="text" name="title" id="title" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                    value="{{ $post->title }}" required>
            </div>

            <div class="mb-4">
                <label for="categories" class="block mb-2" style="color: var(--text-primary);">Categories</label>
                <select name="categories[]" id="categories" class="w-full rounded-lg px-4 py-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" multiple size="5">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <p class="text-sm mt-1" style="color: var(--text-secondary);">Tahan tombol CTRL/Command untuk memilih beberapa kategori</p>
            </div>

            <div class="mb-4">
                <label for="excerpt" class="block mb-2" style="color: var(--text-primary);">Excerpt (Summary)</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" required>{{ $post->excerpt }}</textarea>
            </div>

            <div class="mb-4">
                <label for="body" class="block mb-2" style="color: var(--text-primary);">Body (Markdown)</label>
                <textarea name="body" id="body" rows="15" class="w-full rounded-lg px-4 py-2 font-mono transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" required>{{ $post->body }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block mb-2" style="color: var(--text-primary);">Featured Image</label>
                @if($post->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-32 rounded-lg">
                    <div class="mt-1 text-sm" style="color: var(--text-secondary);">Current image</div>
                </div>
                @endif
                <input type="file" name="image" id="image" class="w-full rounded-lg px-4 py-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
            </div>

            <div class="mb-4">
                <label class="block mb-2" style="color: var(--text-primary);">Publication Status</label>
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" class="mr-2" {{ $post->published_at ? 'checked' : '' }}>
                    <label for="is_published" style="color: var(--text-primary);">{{ $post->published_at ? 'Published' : 'Publish now' }}</label>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.posts.index') }}" class="btn-secondary font-bold py-2 px-4 rounded-lg mr-2">Cancel</a>
                <button type="submit" class="btn-primary font-bold py-2 px-4 rounded-lg">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection