<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['user', 'categories'])
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        $categories = Category::withCount('posts')->get();

        // Get latest posts for sidebar
        $latestPosts = Post::with(['user'])
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'latestPosts'));
    }

    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->with([
                'user', 
                'categories',
                'comments' => function($query) {
                    $query->with(['user', 'replies.user'])
                          ->whereNull('parent_id')
                          ->orderBy('created_at', 'desc');
                }
            ])
            ->withCount('comments')
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['user', 'categories'])
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        $categories = Category::withCount('posts')->get();

        // Get latest posts for sidebar
        $latestPosts = Post::with(['user'])
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'category', 'latestPosts'));
    }
}
