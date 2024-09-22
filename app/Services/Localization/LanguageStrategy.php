<?php

namespace App\Services\Localization;

/**
 * Interface for language strategy.
 * Defines how the locale should be set and stored.
 */
interface LanguageStrategy
{
    /**
     * Set and store the locale for the application.
     *
     * @param string $locale The language code (e.g., 'en', 'lv', 'ru').
     */
    public function setLocale(string $locale): void;
}
