<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminImageController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSitemapController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminPartnersController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ShowArticleController;
use App\Http\Controllers\Frontend\ShowCategoryController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ShowArticleController::class, 'index'])->name('articles.index');
Route::post('/articles/{article}/like', [ShowArticleController::class, 'like'])->name('articles.like');
Route::get('/category/{slug}', [ShowCategoryController::class, 'index'])->name('category.index');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/categories', [SearchController::class, 'categories'])->name('categories');
Route::get('sitemap.xml', function() {return response()->file(public_path('sitemap.xml'));});
Route::view('/cookie-policy', 'frontend.cookies.policy')->name('cookies.policy');

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
    
    // Image handling - all handled by AdminArticleController
    Route::controller(AdminArticleController::class)->group(function () {
        Route::post('articles/{article}/images', 'storeImages')
            ->name('articles.images.store');
        Route::delete('articles/{article}/images/{media}', 'deleteArticleImages')
            ->name('articles.images.destroy');
        Route::post('articles/{article}/images/{media}/set-cover', 'setCover')
            ->name('articles.images.set-cover');
    });

    // Settings
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Partners Routes
    Route::resource('partners', AdminPartnersController::class);
    Route::post('partners/{partner}/archive', [AdminPartnersController::class, 'archive'])->name('partners.archive');
    Route::post('partners/{partner}/restore', [AdminPartnersController::class, 'restore'])->name('partners.restore');
    Route::delete('partners/{partner}/force-delete', [AdminPartnersController::class, 'forceDelete'])
        ->name('partners.force-delete');

    // Teams
    Route::delete('teams/{user}', [AdminTeamController::class, 'destroy'])->name('teams.destroy');
    Route::resource('teams', AdminTeamController::class)->except(['destroy'])->parameters([
        'teams' => 'user'
    ]);

    // Cache and optimization
    Route::post('clear-cache', [AdminDashboardController::class, 'clearCache'])
        ->name('clear-cache');
    Route::get('generate-sitemap', [AdminSitemapController::class, 'generate'])
        ->name('sitemap.generate');
    Route::get('/optimize-clear', function() {
        if (app()->environment('local', 'development')) {
            Artisan::call('optimize:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            return redirect()->back()->with('success', 'System cache cleared successfully!');
        }
        return redirect()->back()->with('error', 'This action is not allowed in production.');
    })->name('optimize-clear')->middleware(['auth', 'admin']);
});

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home')->with('status', 'Email verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');