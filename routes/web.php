<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;

Route::group([
    'prefix' => LaravelLocalization::setLocale(), // Automatically sets the locale prefix
    'middleware' => [
        LocaleSessionRedirect::class,
        LaravelLocalizationRedirectFilter::class,
    ]
], function () {
    // Define your routes here
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
    Route::get('/localization/{locale}', [\App\Http\Controllers\LocalizationController::class, '__invoke'])->name('localization');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});
