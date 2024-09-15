<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestPageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [GuestPageController::class, 'showGuestPage'])->name('guest.home');

// Routes that require authentication
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories Routes
    Route::resource('categories', CategoryController::class);

    // Posts Routes
    Route::resource('posts', PostController::class);

});