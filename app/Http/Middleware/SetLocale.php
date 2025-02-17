<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = mb_substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        if (session()->has('locale')) {
            $locale = session()->get('locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
