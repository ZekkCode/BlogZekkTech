<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('q', '');
        $posts = collect();
        $categories = Category::withCount('posts')->get();

        if (!empty($query)) {
            $posts = Post::with(['user', 'categories'])
                ->whereNotNull('published_at')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('title', 'like', '%' . $query . '%')
                        ->orWhere('body', 'like', '%' . $query . '%')
                        ->orWhere('excerpt', 'like', '%' . $query . '%');
                })
                ->orderBy('published_at', 'desc')
                ->paginate(6);
        }

        // Get latest posts for sidebar
        $latestPosts = Post::with(['user'])
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('blog.search', compact('posts', 'categories', 'latestPosts', 'query'));
    }

    public function api(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if (!empty($query) && strlen($query) >= 2) {
            $posts = Post::whereNotNull('published_at')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('title', 'like', '%' . $query . '%')
                        ->orWhere('body', 'like', '%' . $query . '%')
                        ->orWhere('excerpt', 'like', '%' . $query . '%');
                })
                ->limit(5)
                ->get(['id', 'title', 'slug', 'excerpt', 'published_at']);

            $results = $posts->map(function ($post) {
                return [
                    'title' => $post->title,
                    'url' => route('blog.show', $post->slug),
                    'excerpt' => $post->excerpt ? Str::limit($post->excerpt, 100) : Str::limit(strip_tags($post->body), 100),
                    'date' => $post->published_at->format('Y-m-d')
                ];
            });
        }

        return response()->json($results);
    }
}
