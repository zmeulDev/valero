<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowArticleController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ShowArticleController::class, 'show'])->name('articles.show');
Route::get('/category/{slug}', [ShowArticleController::class, 'category'])->name('category.articles');

Route::get('/search', [SearchController::class, 'index'])->name('search');

// Protected Routes (for logged-in users)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

// Admin Routes (accessible only to admins)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', CategoryController::class);
    Route::delete('/admin/articles/{article}/images/{image}', [AdminArticleController::class, 'destroyImage'])->name('admin.articles.destroyImage');
});