<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocalizationController;
use App\Http\Middleware\Localization;

// Apply Localization middleware to handle session-based locale
Route::middleware([Localization::class])->group(function () {
    // Route for language switching
    Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

    // Route to display categories
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');

    // Authenticated routes
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});
