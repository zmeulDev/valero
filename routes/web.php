<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminImageController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ShowArticleController;
use App\Http\Controllers\Frontend\ShowCategoryController;


// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ShowArticleController::class, 'index'])->name('articles.index');
Route::get('/category/{slug}', [ShowCategoryController::class, 'index'])->name('category.index');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/categories', [SearchController::class, 'categories'])->name('categories');

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
    Route::resource('categories', AdminCategoryController::class);
    
    // Articles
    Route::resource('articles', AdminArticleController::class);
    
    // Image handling
    Route::post('articles/{article}/images', [AdminImageController::class, 'store'])->name('articles.images.store');
    Route::delete('articles/{article}/images/{image}', [AdminImageController::class, 'destroy'])->name('articles.images.destroy');
    Route::post('articles/{article}/featured-image', [AdminImageController::class, 'updateFeatured'])->name('articles.featured-image.update');

    // Settings
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
