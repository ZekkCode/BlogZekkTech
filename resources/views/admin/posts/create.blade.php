@extends('layouts.admin')

@section('title', 'Create New Post')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card rounded-lg p-6 mb-8">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Create New Post</h1>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block mb-2" style="color: var(--text-primary);">Title</label>
                <input type="text" name="title" id="title" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="categories" class="block mb-2" style="color: var(--text-primary);">Categories</label>
                <select name="categories[]" id="categories" class="w-full rounded-lg px-4 py-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" multiple size="5">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm mt-1" style="color: var(--text-secondary);">Tahan tombol CTRL/Command untuk memilih beberapa kategori</p>
            </div>

            <div class="mb-4">
                <label for="excerpt" class="block mb-2" style="color: var(--text-primary);">Excerpt (Summary)</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-lg px-4 py-2 transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" required></textarea>
            </div>

            <div class="mb-4">
                <label for="body" class="block mb-2" style="color: var(--text-primary);">Body (Markdown)</label>
                <textarea name="body" id="body" rows="15" class="w-full rounded-lg px-4 py-2 font-mono transition-colors focus:outline-none focus:ring-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);" required></textarea>
                <p class="text-sm mt-2" style="color: var(--text-secondary);">You can use Markdown to format your post.</p>
            </div>

            <div class="mb-4">
                <label for="image" class="block mb-2" style="color: var(--text-primary);">Featured Image</label>
                <input type="file" name="image" id="image" class="w-full rounded-lg px-4 py-2"
                    style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);">
            </div>

            <div class="mb-4">
                <label class="block mb-2" style="color: var(--text-primary);">Publication Status</label>
                <div class="flex items-center">
                    <input type="checkbox" name="publish_now" id="publish_now" class="mr-2" checked>
                    <label for="publish_now" style="color: var(--text-primary);">Publish immediately</label>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.posts.index') }}" class="btn-secondary font-bold py-2 px-4 rounded-lg mr-2">Cancel</a>
                <button type="submit" class="btn-primary font-bold py-2 px-4 rounded-lg">Create Post</button>
            </div>
        </form>
    </div>

    <!-- Markdown Guide -->
    <div class="card rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4" style="color: var(--text-primary);">Markdown Guide</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-bold mb-2" style="color: var(--text-primary);">Headings</h3>
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
# Heading 1
## Heading 2
### Heading 3</pre>
            </div>

            <div>
                <h3 class="font-bold mb-2" style="color: var(--text-primary);">Emphasis</h3>
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
**bold text**
*italic text*
~~strikethrough~~</pre>
            </div>

            <div>
                <h3 class="font-bold mb-2" style="color: var(--text-primary);">Lists</h3>
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
- Item 1
- Item 2
  - Nested item
  
1. First item
2. Second item</pre>
            </div>

            <div>
                <h3 class="font-bold mb-2" style="color: var(--text-primary);">Links & Images</h3>
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
[Link text](https://example.com)

![Alt text](/path/to/image.jpg)</pre>
            </div>

            <div>
                <h3 class="font-bold mb-2" style="color: var(--text-primary);">Code</h3>
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
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
                <pre class="p-2 rounded-lg text-sm" style="background-color: var(--bg-primary); color: var(--text-primary);">
> This is a blockquote
> It can span multiple lines</pre>
            </div>
        </div>
    </div>
</div>
@endsection