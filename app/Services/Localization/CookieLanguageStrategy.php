<?php

namespace App\Services\Localization;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;

/**
 * Handles setting the locale using cookie storage.
 */
class CookieLanguageStrategy implements LanguageStrategy
{
    /**
     * Set and store the locale in a cookie.
     *
     * @param string $locale The language code (e.g., 'en', 'lv', 'ru').
     * @return void
     */
    public function setLocale(string $locale): void
    {
        // Store the locale in a cookie with a long duration (1 year)
        Cookie::queue('lang', $locale, 60 * 24 * 365); // 1 year in minutes

        // Set the locale for the application
        App::setLocale($locale);
    }
}
