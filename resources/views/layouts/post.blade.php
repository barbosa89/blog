<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('blog.author'))</title>
    <link href="{{ asset('images/icon.png') }}" rel="shortcut icon" type="image/x-icon">

    @yield('head')

    <meta property="fb:app_id" content="2203860376602756" />

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
        <script data-ad-client="ca-pub-2847498886705900" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endproduction
</head>
<body  id="page-top">
    <div id="app">
        @include('templates.navbar')
        @include('flash::message')

        <main>
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/highlight.js'], 'build')

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
    @yield('scripts')
</body>
</html>
