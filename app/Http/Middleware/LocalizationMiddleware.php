<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->header("Accept-Language");
        $locale = $request->session()->get("locale");

        if ($locale) {
            App::setLocale($locale);
        } else {
            $acceptLanguage = $request->header("Accept-Language");
            $firstLang = explode(";", $acceptLanguage)[0];
            $lang = explode(",", $firstLang)[1];

            App::setLocale($lang);
        }

        return $next($request);
    }
}
