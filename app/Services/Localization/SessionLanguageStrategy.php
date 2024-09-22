<?php

namespace App\Services\Localization;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

/**
 * Handles setting the locale using session storage.
 */
class SessionLanguageStrategy implements LanguageStrategy
{
    /**
     * Set and store the locale in the session.
     *
     * @param string $locale The language code (e.g., 'en', 'lv', 'ru').
     * @return void
     */
    public function setLocale(string $locale): void
    {
        // Store the locale in the session
        Session::put('localization', $locale);

        // Set the locale for the application
        App::setLocale($locale);
    }
}
