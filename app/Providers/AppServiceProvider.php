<?php

namespace App\Providers;

use App\Services\Localization\LanguageStrategy;
use App\Services\Localization\SessionLanguageStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the LanguageStrategy to the SessionLanguageStrategy
        $this->app->bind(LanguageStrategy::class, SessionLanguageStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
