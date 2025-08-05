@extends('layouts.admin')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
    <style>
        /* Mobile responsive styling for edit post */
        @media (max-width: 768px) {
            .card {
                margin: 0 -1rem;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .max-w-4xl {
                padding: 0 1rem;
            }

            h1 {
                font-size: 1.5rem;
                line-height: 1.3;
            }

            input,
            textarea,
            select {
                font-size: 1rem;
                padding: 0.75rem !important;
            }

            textarea {
                min-height: 120px;
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

            img {
                height: 6rem;
                width: auto;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.25rem;
            }

            input,
            textarea,
            select {
                font-size: 0.875rem;
                padding: 0.625rem !important;
            }

            label {
                font-size: 0.875rem;
            }

            .text-sm {
                font-size: 0.75rem;
            }

            img {
                height: 4rem;
            }
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <div class="card rounded-lg p-4 sm:p-6 mb-8">
            <h1 class="text-xl sm:text-2xl font-bold mb-6" style="color: var(--text-primary);">Edit Post: {{ $post->title }}
            </h1>

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block mb-2" style="color: var(--text-primary);">Judul</label>
                    <input type="text" name="title" id="title"
                        class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        value="{{ $post->title }}" required>
                </div>

                <div class="mb-4">
                    <label for="categories" class="block mb-2" style="color: var(--text-primary);">Kategori</label>
                    <select name="categories[]" id="categories" class="w-full rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        multiple size="5">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm mt-1" style="color: var(--text-secondary);">Tahan tombol CTRL/Command untuk memilih
                        beberapa kategori</p>
                </div>

                <div class="mb-4">
                    <label for="excerpt" class="block mb-2" style="color: var(--text-primary);">Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                        class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        required>{{ $post->excerpt }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="body" class="block mb-2" style="color: var(--text-primary);">Konten (Markdown)</label>
                    <textarea name="body" id="body" rows="15"
                        class="w-full rounded-lg px-4 py-2 font-mono transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        required>{{ $post->body }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block mb-2" style="color: var(--text-primary);">Gambar Unggulan</label>
                    @if($post->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="h-24 sm:h-32 rounded-lg">
                            <div class="mt-1 text-sm" style="color: var(--text-secondary);">Gambar saat ini</div>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="w-full rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
                </div>

                <div class="mb-4">
                    <label class="block mb-2" style="color: var(--text-primary);">Status Publikasi</label>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" class="mr-2" {{ $post->published_at ? 'checked' : '' }}>
                        <label for="is_published"
                            style="color: var(--text-primary);">{{ $post->published_at ? 'Published' : 'Publish now' }}</label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end mt-6 gap-2 sm:gap-0">
                    <a href="{{ route('admin.posts.index') }}"
                        class="btn-secondary font-bold py-2 px-4 rounded-xl sm:mr-2 w-full sm:w-auto text-center order-2 sm:order-1">Batal</a>
                    <button type="submit"
                        class="btn-primary font-bold py-2 px-4 rounded-xl w-full sm:w-auto order-1 sm:order-2">Perbarui
                        Post</button>
                </div>
            </form>
        </div>
    </div>
@endsection