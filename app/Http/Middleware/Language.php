<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App;
use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = mb_substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        $lang = 'es';

        if ('en' === $locale) {
            $lang = 'en';
        }

        App::setLocale($lang);

        return $next($request);
    }
}
