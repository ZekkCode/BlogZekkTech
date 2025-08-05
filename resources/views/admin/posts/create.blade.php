@extends('layouts.admin')

@section('title', 'Buat Post Baru')

@section('content')
    <style>
        /* Mobile responsive styling for create post */
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
            }

            h2 {
                font-size: 1.25rem;
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

            .grid-cols-1.md\:grid-cols-2 {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            pre {
                font-size: 0.75rem;
                padding: 0.5rem !important;
                overflow-x: auto;
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
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <div class="card rounded-lg p-4 sm:p-6 mb-8">
            <h1 class="text-xl sm:text-2xl font-bold mb-6" style="color: var(--text-primary);">Buat Post Baru</h1>

            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block mb-2" style="color: var(--text-primary);">Judul</label>
                    <input type="text" name="title" id="title"
                        class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        required>
                </div>

                <div class="mb-4">
                    <label for="categories" class="block mb-2" style="color: var(--text-primary);">Kategori</label>
                    <select name="categories[]" id="categories" class="w-full rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        multiple size="5">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label for="body" class="block mb-2" style="color: var(--text-primary);">Konten (Markdown)</label>
                    <textarea name="body" id="body" rows="15"
                        class="w-full rounded-lg px-4 py-2 font-mono transition-colors focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        required></textarea>
                    <p class="text-sm mt-2" style="color: var(--text-secondary);">Anda dapat menggunakan Markdown untuk
                        memformat konten Anda.
                    </p>
                </div>

                <div class="mb-4">
                    <label for="image" class="block mb-2" style="color: var(--text-primary);">Gambar Unggulan</label>
                    <input type="file" name="image" id="image" class="w-full rounded-lg px-4 py-2"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
                </div>

                <div class="mb-4">
                    <label class="block mb-2" style="color: var(--text-primary);">
                        Status Publikasi
                    </label>
                    <div class="flex items-center">
                        <input type="checkbox" name="publish_now" id="publish_now" class="mr-2" checked>
                        <label for="publish_now" style="color: var(--text-primary);">Publikasikan sekarang</label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end mt-6 gap-2 sm:gap-0">
                    <a href="{{ route('admin.posts.index') }}"
                        class="btn-secondary font-bold py-2 px-4 rounded-xl sm:mr-2 w-full sm:w-auto text-center order-2 sm:order-1">Batal</a>
                    <button type="submit"
                        class="btn-primary font-bold py-2 px-4 rounded-xl w-full sm:w-auto order-1 sm:order-2">Buat
                        Post</button>
                </div>
            </form>
        </div>

        <!-- Markdown Guide -->
        <div class="card rounded-lg p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-bold mb-4" style="color: var(--text-primary);">Panduan Markdown</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Headings</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                # Heading 1
                ## Heading 2
                ### Heading 3</pre>
                </div>

                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Emphasis</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                **bold text**
                *italic text*
                ~~strikethrough~~</pre>
                </div>

                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Lists</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                - Item 1
                - Item 2
                  - Nested item

                1. First item
                2. Second item</pre>
                </div>

                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Links & Images</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                [Link text](https://example.com)

                ![Alt text](/path/to/image.jpg)</pre>
                </div>

                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Code</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                `inline code`

                ```javascript
                // code block
                function hello() {
                  console.log('Hello');
                }
                ```</pre>
                </div>

                <div>
                    <h3 class="font-bold mb-2" style="color: var(--text-primary);">Blockquotes</h3>
                    <pre class="p-2 rounded-lg text-sm"
                        style="background-color: var(--bg-primary); color: var(--text-primary);">
                > This is a blockquote
                > It can span multiple lines</pre>
                </div>
            </div>
        </div>
    </div>
@endsection