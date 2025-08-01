<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['categories', 'user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'excerpt' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = Str::slug($validated['title']);
        $post->user_id = Auth::id() ?? 1; // Default to user 1 if not logged in
        $post->excerpt = $validated['excerpt'];
        $post->body = $validated['body'];
        $post->published_at = $request->has('publish_now') ? now() : null;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        // Attach categories
        $post->categories()->attach($request->categories);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'excerpt' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->title = $validated['title'];

        // Only update the slug if the title has changed
        if ($post->title !== $validated['title']) {
            $post->slug = Str::slug($validated['title']);
        }

        $post->excerpt = $validated['excerpt'];
        $post->body = $validated['body'];

        // Handle publishing status
        if ($request->has('is_published') && !$post->published_at) {
            $post->published_at = now();
        } elseif (!$request->has('is_published') && $post->published_at) {
            $post->published_at = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        // Sync categories
        $post->categories()->sync($request->categories);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // Delete the post image if it exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
