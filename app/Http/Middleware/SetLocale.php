<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = ['it', 'en', 'es'];

        if ($request->has('lang') && in_array($request->get('lang'), $supportedLocales)) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
            cookie()->queue(cookie()->forever('locale', $locale));
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        } elseif ($request->cookie('locale') && in_array($request->cookie('locale'), $supportedLocales)) {
            $locale = $request->cookie('locale');
            Session::put('locale', $locale);
        } else {
            $locale = config('app.locale', 'it');
        }

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'it';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
