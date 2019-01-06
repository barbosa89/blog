<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Sanitize
{
    /**
     * The following method loops through all request input and strips out all tags from
     * the request. This to ensure that users are unable to set ANY HTML within the form
     * submissions, but also cleans up input.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function(&$input) {
            $input = htmlentities(strip_tags($input), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        });

        $request->merge($input);

        return $next($request);
    }
}