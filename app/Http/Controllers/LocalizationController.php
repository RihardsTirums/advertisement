<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Handles switching the application language.
 */
class LocalizationController extends Controller
{
    /**
     * Switch the application language based on the locale provided.
     *
     * @param string $locale The language code (e.g., 'en', 'lv', 'ru').
     * @return RedirectResponse Redirects to the localized homepage.
     */
    public function __invoke(string $locale): RedirectResponse
    {
        // Validate if the requested locale code exists in the configuration
        if (!in_array($locale, array_keys(LaravelLocalization::getSupportedLocales()))) {
            abort(400); // Invalid locale code
        }

        // Set the locale using the localization package
        LaravelLocalization::setLocale($locale);

        // Redirect to the localized URL
        return redirect(LaravelLocalization::getLocalizedURL($locale));
    }
}
