<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecureHeaders
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        $response->headers->set('X-Frame-Options', 'DENY');

        $response->headers->set('X-Content-Type-Options', 'nosniff');

        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        $response->headers->set(
            'Content-Security-Policy',
            $this->buildCsp(),
        );

        $response->headers->set('Permissions-Policy', 'geolocation=(), camera=(), microphone=()');

        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->remove('Cross-Origin-Embedder-Policy');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');

        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }

    private function buildCsp(): string
    {
        $frameSources = [
            "'self'",
            'https://www.google.com',
            'https://googleads.g.doubleclick.net',
            'https://tpc.googlesyndication.com',
            'https://pagead2.googlesyndication.com',
        ];

        $connectSources = [
            "'self'",
            'https://www.google.com',
            'https://www.google-analytics.com',
            'https://www.googletagmanager.com',
            'https://googleads.g.doubleclick.net',
            'https://pagead2.googlesyndication.com',
        ];

        return "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google.com https://www.gstatic.com https://www.googletagmanager.com https://googleads.g.doubleclick.net https://pagead2.googlesyndication.com https://static.doubleclick.net; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com; " .
            "img-src 'self' data: https: http: blob:; " .
            'frame-src ' . implode(' ', $frameSources) . '; ' .
            'connect-src ' . implode(' ', $connectSources) . '; ' .
            "worker-src 'self' blob:; " .
            "manifest-src 'self';";
    }
}
