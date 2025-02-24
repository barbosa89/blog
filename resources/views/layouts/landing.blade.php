<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Omar Barbosa - @lang('page.degree')</title>
    <link href="{{ asset('images/icon.png') }}" rel="shortcut icon" type="image/x-icon">
    <link rel="canonical" href="{{ config('app.url') }}">

    <meta name="description" content="{{ trans('page.description') }}">
    <meta name="keywords" content="{{ trans('page.keywords') }}">
    <meta name="author" content="Omar Barbosa">

    <meta property="og:title" content="Blog de Omar Barbosa">
    <meta property="og:description" content="{{ trans('page.description') }}">
    <meta property="og:image" content="{{ asset('images/site.png') }}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://omarbarbosa.com/">
    <meta name="twitter:card" content="summary_large_image">

    <meta property="og:site_name" content="Omar Barbosa">
    <meta name="twitter:image:alt" content="Blog Omar Barbosa">

    <meta property="fb:app_id" content="2203860376602756" />
    <meta name="twitter:site" content="@Omar_Andres_Bar">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    @vite([
        'resources/sass/app.scss',
        'resources/css/freelancer.css',
        'resources/js/app.js',
        'resources/js/freelancer.js',
    ], 'build')

    @production
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103614513-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-103614513-1');
        </script>
    @endproduction
    <!-- PWA assets -->
    {{-- @laravelPWA --}}
</head>
<body  id="page-top">
    <div id="app">
        @include('templates.navbar')
        @include('flash::message')

        <main>
            @yield('content')
        </main>
    </div>

    <script type="application/ld+json" async>
        {
            "@context": "http://schema.org/",
            "@type": "WebSite",
            "name": "Omar Barbosa",
            "alternateName": "Blog de Omar Barbosa",
            "url": "https://omarbarbosa.com",
            "image": "{{ asset('images/site.png') }}",
            "description": "{{ trans('page.description') }}"
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('flash-overlay-modal');
            if (modal) {
                modal.style.display = 'block';
            }

            var alerts = document.querySelectorAll('div.alert:not(.alert-important)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.35s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 350);
                }, 3000);
            });
        });
    </script>
</body>
</html>
