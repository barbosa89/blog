<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

use function in_array;
use function mb_substr;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE', config('app.locale'));
        $acceptLanguage = blank(trim($acceptLanguage)) ? config('app.locale') : $acceptLanguage;

        $locale = mb_substr($acceptLanguage, 0, 2);

        if (!in_array($locale, ['en', 'es'])) {
            $locale = config('app.locale');
        }

        if (session()->has('locale')) {
            $locale = session()->get('locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
