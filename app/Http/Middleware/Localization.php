<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to handle applying the locale from the session.
 */
class Localization
{
    /**
     * Handle an incoming request and set the locale.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware in the pipeline.
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale code from the `lang` cookie or use the default app locale
        $locale = $request->cookie('lang', config('app.locale'));

        // Set the application locale using the locale code
        App::setLocale($locale);

        return $next($request);
    }

    /**
     * Handle an incoming request and set the locale.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware in the pipeline.
     * @return Response
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Get the locale code from the session or use the default app locale
    //     $locale = session('localization', config('app.locale'));

    //     // Set the application locale using the locale code
    //     App::setLocale($locale);

    //     return $next($request);
    // }
}
