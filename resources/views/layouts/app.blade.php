<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Omar Barbosa') }}</title>
    <link href="{{ asset('images/icon.png') }}" rel="shortcut icon" type="image/x-icon">

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
    <meta name="twitter:site" content="@Barbosa">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    
    <!-- Style -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103614513-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-103614513-1');
    </script>
</head>
<body  id="page-top">
    <div id="app">
        @include('templates.navbar')
        @include('flash::message')

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/landing.js') }}" async defer></script>
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
    <script async>
        $('#flash-overlay-modal').modal();

        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    @yield('scripts')
</body>
</html>
