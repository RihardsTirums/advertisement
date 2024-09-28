<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Localization\LanguageStrategy;
use App\Services\Localization\CookieLanguageStrategy;
use App\Services\Localization\SessionLanguageStrategy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the CookieLanguageStrategy to the LanguageStrategy interface
        $this->app->bind(LanguageStrategy::class, CookieLanguageStrategy::class);

        // Bind the LanguageStrategy to the SessionLanguageStrategy
        // $this->app->bind(LanguageStrategy::class, SessionLanguageStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the ClearLanguageCookie Artisan command
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\ClearLanguageCookie::class,
            ]);
        }
    }
}
