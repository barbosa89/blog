<!DOCTYPE html>
<html lang="{{ $locale }}" data-csp-nonce="{{ app('csp-nonce') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('blog.author'))</title>
    <link href="{{ asset('images/captain-logo-favicon.webp') }}" rel="shortcut icon" type="image/x-icon">

    @yield('head')

    <meta property="fb:app_id" content="2203860376602756" />

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/freelancer.js',
    ], 'build')

    @production
        <script @cspNonce async src="https://www.googletagmanager.com/gtag/js?id=UA-103614513-1"></script>
        <script @cspNonce>
            window.dataLayer = window.dataLayer || []
            function gtag(){dataLayer.push(arguments)}
            gtag('js', new Date())

            gtag('config', 'UA-103614513-1')
        </script>
        <script @cspNonce async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2847498886705900"
            crossorigin="anonymous">
        </script>
    @endproduction
</head>
<body id="page-top" class="antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[9999] focus:bg-track-yellow focus:px-4 focus:py-2 focus:font-semibold focus:text-vacuum">{{ trans('page.accessibility.skip_content') }}</a>

    <div id="app">
        @include('partials.navbar')

        <main id="main-content" tabindex="-1">
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/highlight.js'], 'build')

    @yield('scripts')
</body>
</html>
