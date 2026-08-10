<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecureHeaders
{
    private const CSP_SELF = "'self'";
    private const GOOGLE = 'https://www.google.com';
    private const GOOGLE_ADS = 'https://googleads.g.doubleclick.net';
    private const GOOGLE_ADS_PAGE = 'https://pagead2.googlesyndication.com';

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
        $scriptSources = [
            self::CSP_SELF,
            "'unsafe-inline'",
            "'unsafe-eval'",
            self::GOOGLE,
            'https://www.gstatic.com',
            'https://www.googletagmanager.com',
            self::GOOGLE_ADS,
            self::GOOGLE_ADS_PAGE,
            'https://static.doubleclick.net',
        ];

        $styleSources = [
            self::CSP_SELF,
            "'unsafe-inline'",
            'https://fonts.googleapis.com',
        ];

        $frameSources = [
            self::CSP_SELF,
            self::GOOGLE,
            self::GOOGLE_ADS,
            'https://tpc.googlesyndication.com',
            self::GOOGLE_ADS_PAGE,
        ];

        $connectSources = [
            self::CSP_SELF,
            self::GOOGLE,
            'https://www.google-analytics.com',
            'https://www.googletagmanager.com',
            self::GOOGLE_ADS,
            self::GOOGLE_ADS_PAGE,
        ];

        if (false === app()->isProduction()) {
            $scriptSources[] = 'http:';
            $scriptSources[] = 'https:';

            $styleSources[] = 'http:';
            $styleSources[] = 'https:';

            $connectSources[] = 'http:';
            $connectSources[] = 'https:';
            $connectSources[] = 'ws:';
            $connectSources[] = 'wss:';
        }

        return "default-src 'self'; "
            . 'script-src ' . implode(' ', array_unique($scriptSources)) . '; '
            . 'style-src ' . implode(' ', array_unique($styleSources)) . '; '
            . "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com; "
            . "img-src 'self' data: https: http: blob:; "
            . 'frame-src ' . implode(' ', $frameSources) . '; '
            . 'connect-src ' . implode(' ', array_unique($connectSources)) . '; '
            . "worker-src 'self' blob:;";
    }

}
