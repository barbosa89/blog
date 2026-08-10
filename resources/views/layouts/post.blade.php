<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('blog.author'))</title>
    <link href="{{ asset('images/captain-logo.webp') }}" rel="shortcut icon" type="image/x-icon">

    @yield('head')

    <meta property="fb:app_id" content="2203860376602756" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">


    @vite([
        'resources/css/app.css',
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
<body id="page-top" class="antialiased">
    <!--
    IMPECCABLE DIRECTION CONTRACT
    THESIS: Products lead as authored signals, then confirmed clients and articles provide professional context; the page refuses a mixed project wall and interchangeable card grid.
    OWN-WORLD: Vacuum, steel, cyan, yellow and coral; ruled panels; condensed display typography; monospaced evidence labels.
    STORY: Understand the proposition, inspect products first, recognize confirmed clients, read the practice, then make direct contact.
    FIRST VIEWPORT: A stable typographic proposition and primary contact action lead directly into authored product evidence.
    FORM: Ruled editorial instrument, direction seed b14f59c6.
    FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, and DESIGN.md
    -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[9999] focus:bg-track-yellow focus:px-4 focus:py-2 focus:font-semibold focus:text-vacuum">@lang('page.accessibility.skip_content')</a>

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
