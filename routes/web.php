<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

// Front-end routes
Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/post/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search', [SearchController::class, 'api'])->name('search.api');

// Theme routes
Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::post('/theme/set', [ThemeController::class, 'setTheme'])->name('theme.set');

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Posts management
    Route::resource('posts', AdminPostController::class);

    // Categories management
    Route::resource('categories', CategoryController::class);
});
