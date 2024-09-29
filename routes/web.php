<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowArticleController;
use App\Http\Controllers\ShowCategoryController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ShowArticleController::class, 'index'])->name('articles.index');
Route::get('/category/{slug}', [ShowCategoryController::class, 'index'])->name('category.index');
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
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Articles
    Route::resource('articles', AdminArticleController::class);
    
    // Image handling
    Route::post('articles/{article}/images', [ImageController::class, 'store'])->name('articles.images.store');
    Route::delete('articles/{article}/images/{image}', [ImageController::class, 'destroy'])->name('articles.images.destroy');
    Route::post('articles/{article}/featured-image', [ImageController::class, 'updateFeatured'])->name('articles.featured-image.update');
});