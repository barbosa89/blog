<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function array_walk_recursive;
use function htmlspecialchars;
use function in_array;
use function mb_strtolower;
use function strip_tags;

class InputSanitize
{
    /**
     * @var array<int, string>
     */
    protected array $except = [];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(mb_strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        $input = $request->all();
        $except = property_exists($this, 'except') ? $this->except : [];

        array_walk_recursive($input, function (&$value, $key) use ($except): void {
            if (in_array($key, $except, true)) {
                return;
            }

            if (is_string($value)) {
                $value = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
