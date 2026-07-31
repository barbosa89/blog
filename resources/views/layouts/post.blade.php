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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&display=swap" rel="stylesheet" type="text/css">


    @vite([
        'resources/sass/app.scss',
        'resources/css/freelancer.css',
        'resources/js/app.js',
        'resources/js/freelancer.js',
    ], 'build')

    @production
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103614513-1"></script>
        <script>
            window.dataLayer = window.dataLayer || []
            function gtag(){dataLayer.push(arguments)}
            gtag('js', new Date())

            gtag('config', 'UA-103614513-1')
        </script>
        <script async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2847498886705900"
            crossorigin="anonymous">
        </script>
    @endproduction
</head>
<body  id="page-top">
    <div id="app">
        @include('partials.navbar')

        <main>
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/highlight.js'], 'build')

    @yield('scripts')
</body>
</html>
