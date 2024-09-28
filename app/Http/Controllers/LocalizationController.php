<?php

namespace App\Http\Controllers;

use App\Services\Localization\LanguageStrategy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

/**
 * Handles switching the application language.
 */
class LocalizationController extends Controller
{
    private LanguageStrategy $languageStrategy;

    /**
     * LocalizationController constructor.
     *
     * @param LanguageStrategy $languageStrategy The strategy to handle locale switching.
     */
    public function __construct(LanguageStrategy $languageStrategy)
    {
        $this->languageStrategy = $languageStrategy;
    }

    /**
     * Switch the application language based on the locale provided.
     *
     * @param string $locale The language code (e.g., 'en', 'lv', 'ru').
     * @return RedirectResponse Redirects back to the previous page after changing the language.
     */
    public function __invoke(string $locale): RedirectResponse
    {
        // Validate if the requested locale code exists in the configuration
        if (!array_key_exists($locale, config('localization.locales'))) {
            abort(400); // Invalid locale code
        }

        // Set the locale using the strategy
        $this->languageStrategy->setLocale($locale);

        // Redirect back to the previous page
        return redirect()->back()->withCookie(cookie('lang', $locale, 60 * 24 * 365));
    }
}
