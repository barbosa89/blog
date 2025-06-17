<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function array_walk_recursive;
use function in_array;
use function htmlentities;
use function strip_tags;
use function strtolower;

class InputSanitize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function(&$input) {
            $input = htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
        });

        $request->merge($input);

        return $next($request);
    }
}
