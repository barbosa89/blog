---
title: 'Turns your Laravel app into a progressive web app'
excerpt: 'Turn your Laravel application into a progressive web application (PWA) in minutes, so it can be installed on mobile and desktop devices.'
publishedAt: '2020-02-25'
updatedAt: null
locale: 'en'
image: 'images/articles/laravel-pwa.png'
tags:
- laravel
- pwa
---

Progressive web applications (PWA) are those that acquire behaviors very similar to native mobile applications, their main features are: Installation capacity, it is even possible to publish them in the Google Play Store, PWA can work offline and can send and receive push notifications. This technology was created by Google and even Microsoft has decided to support its Windows application store.

The objective of this article is that we can convert a web application with Laravel, into a progressive web application. If you want to know much more about the PWA, this link will be very helpful: [Official documentation](https://developers.google.com/web/fundamentals/codelabs/your-first-pwapp?hl=en).

## Requirements

In reality none, you can convert an existing or a new application.

## Step by Step

Follow the instructions below and in a few minutes you will have a progressive web application.

### Deploy server

Start the Laravel development server, for this procedure avoid deploying the server with NPM and BrowserSync.

```bash
php artisan serve
```

### Install Composer Package

To achieve the goal we need to install a package that will do most of the work: Laravel PWA.

```bash
composer require silviolleite/laravelpwa
```

After installation, it is necessary to publish the assets and the package configuration file:

```bash
php artisan vendor:publish --provider="LaravelPWA\\Providers\\LaravelPWAServiceProvider"
```

In the **config** folder we will find the file **laravelpwa.php** and we will make the necessary modifications such as the name, short and long, also the colors that apply according to the design's col

```php
<?php

return [
    'name' => 'Omar Barbosa',
    'manifest' => [
        'name' => env('APP_NAME', 'Omar Barbosa'),
        'short_name' => 'Barbosa',
        'start_url' => '/',
        'background_color' => '#00be9c',
        'theme_color' => '#1c3c50',
        'display' => 'standalone',
        'orientation'=> 'any',
        'icons' => [
            '72x72' => '/images/icons/icon-72x72.png',
            '96x96' => '/images/icons/icon-96x96.png',
            '128x128' => '/images/icons/icon-128x128.png',
            '144x144' => '/images/icons/icon-144x144.png',
            '152x152' => '/images/icons/icon-152x152.png',
            '192x192' => '/images/icons/icon-192x192.png',
            '384x384' => '/images/icons/icon-384x384.png',
            '512x512' => '/images/icons/icon-512x512.png'
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'custom' => [],
    ],
];
```

<article-ad></article-ad>

### Image replacement

In the previous configuration file there are two arrays that relate the images (icons, splash) required by any progressive web application for normal operation; you must replace them with your icons and customize the splash. These images were published in the public folder, in the path **public/images/icons**.

### Include Blade directive

For assets to be available in the browser, we must include the Blade **@laravelPWA** directive in the layout, which is the parent view. It is important that it be before closing the head tag.

```php
<html>
    <head>
        <title>App</title>
        ...
        @laravelPWA
    </head>
    <body>
        ...
        @yield('content')
        ...
    </body>
</html>
```

### Offline Route

Finally, we must create the offline route that will respond with a default view in cases of network connection failures, to do this, modify the route files located in **routes/web.php**, and add the following content:

```php
Route::get('/offline', function () {    
    return view('modules/laravelpwa/offline');
});
```

### Offline view

When we publish the assets with the **vendor: publish** command, a Blade view was published and it is located in the views folder **/modules/laravelpwa/offline.blade.php**, you must customize it and it must render in the layout (parent view ), in which we put the **@laravelPWA** directive.

```php
@extends('layouts.app')

@section('content')

<h1>Customize this content</h1>

@endsection
```

Finally, refresh the browser and enjoy your PWA.

### Final note

If you are starting the development server with NPM and BrowserSync, the PWA will not work in development, because BrowserSync uses a virtual host (example: myapp.local), so the manifest registers the virtual host while the service worker registers a URL different, in this case `localhost:3000`, so it will not show the installation option in the browser.

Do not forget to share, thanks.