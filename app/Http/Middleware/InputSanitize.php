<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class InputSanitize
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
        if (! in_array(mb_strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$input): void {
            $input = htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
        });

        $request->merge($input);

        return $next($request);
    }
}
