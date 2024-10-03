<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    /**
     * Mount the component with the current locale.
     */
    public function mount()
    {
        $this->currentLocale = LaravelLocalization::getCurrentLocale();
    }

    /**
     * Switch the application language.
     *
     * @param string $locale
     * @return void
     */
    public function switchLanguage(string $locale)
    {
        // Validate if the requested locale code exists in the configuration
        if (!in_array($locale, array_keys(LaravelLocalization::getSupportedLocales()))) {
            return; // Invalid locale code, exit the function
        }

        // Set the locale and update the session/cookies
        LaravelLocalization::setLocale($locale);
        Cookie::queue('lang', $locale, 60 * 24 * 365); // Store in a cookie for 1 year
        $this->currentLocale = $locale;

        // Redirect to the localized URL
        return Redirect::to(LaravelLocalization::getLocalizedURL($locale));
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $locales = LaravelLocalization::getSupportedLocales();

        return view('livewire.language-switcher', compact('locales'));
    }
}
