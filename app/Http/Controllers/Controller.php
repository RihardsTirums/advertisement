<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    /**
     * Set the canonical URL for the current request.
     *
     * @param Request $request
     * @return void
     */
    protected function setCanonicalUrl(Request $request): void
    {
        // Construct the canonical URL from the current request
        $canonicalUrl = $request->url();

        // Share the canonical URL with all views
        View::share('canonicalUrl', $canonicalUrl);
    }
}
