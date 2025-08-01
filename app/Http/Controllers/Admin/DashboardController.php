<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'users' => User::count(),
        ];

        $latestPosts = Post::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestPosts'));
    }
}
