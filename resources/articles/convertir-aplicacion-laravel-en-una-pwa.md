---
title: 'Convertir aplicación Laravel en una PWA'
excerpt: 'Convierte tu aplicación de Laravel en una aplicación web progresiva (PWA) en minutos, para que pueda ser instalada en dispositivos móviles y de escritorio.'
publishedAt: '2020-02-05'
updatedAt: null
locale: 'es'
image: 'images/articles/laravel-pwa.png'
tags:
- laravel
- pwa
---

Las aplicaciones web progresivas (progressive web app / PWA) son aplicaciones web que adquieren comportamientos muy similares a las aplicaciones móviles nativas, entre las principales características están: La capacidad que pueden ser instaladas desde el navegador, incluso es posible publicarlas en la Google Play Store, pueden trabajar sin conexión y tienen notificaciones push. Esta tecnología fue creada por Google e incluso Microsoft ha decidido dar soporte en su tienda de aplicaciones para Windows.

El objetivo de este artículo es que podamos convertir una aplicación web con Laravel, común y corriente, en una aplicación web progresiva. Si quieres saber mucho más de las PWA, este enlace te será de mucha ayuda: [Documentación oficial](https://developers.google.com/web/fundamentals/codelabs/your-first-pwapp?hl=es).

<lite-youtube videoid="4af3btW1foc" params="autoplay=0"></lite-youtube>

## Requisitos

En realidad ninguno, puedes convertir una aplicación existente o una nueva.

## Paso a paso

Sigue las instrucciones a continuación y en unos minutos tendrás una aplicación web progresiva.

### Desplegar servidor

Desplieguen el servidor de desarrollo de Laravel, para este procedimiento eviten desplegar el servidor con NPM y BrowserSync.

```bash
php artisan serve
```

### Instalar paquete de Composer

Para alcanzar el objetivo necesitaremos instalar en la aplicación de Laravel, un paquete que hará la mayor parte del trabajo: [Laravel PWA](https://github.com/silviolleite/laravel-pwa).

```bash
composer require silviolleite/laravelpwa
```

Posterior a la instalación, es necesario publicar los assets y el archivo de configuración del paquete:

```bash
php artisan vendor:publish --provider="LaravelPWA\\Providers\\LaravelPWAServiceProvider"
```

En la carpeta **config** encontraremos el archivo **laravelpwa.php** y haremos la modificaciones necesarias como el nombre, corto y largo, que la aplicación tendrá, también los colores que apliquen de acuerdo a la paleta de colores del diseño. En mi caso, el archivo quedó así:

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

### Reemplazo de imágenes

En el archivo de configuración anterior hay dos array que relacionan las imágenes (iconos, splash) que requiere toda aplicación web progresiva para su normal funcionamiento; debes reemplazarlas con tus iconos y personalizar los splash, los cuales se verán de primera mano mientras se carga la aplicación. Estas imágenes fueron publicadas en la carpeta pública, en la ruta **public/images/icons**.

### Incluir directiva de Blade

Para que los assets estén disponibles en el navegador, debemos incluir la directiva **@laravelPWA** de Blade en el layout, el cual es la vista padre. Es importante que sea antes de cerrar el **head**.

```php
<html>
<head>
    <title>Aplicación</title>
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

### Ruta Offline

Finalmente debemos crear la ruta **/offline** que responderá con una vista predeterminada en casos de fallas en la conexión de red, para ello, modifica el archivos de rutas ubicado en **routes/web.php**, y agrega el siguiente contenido:

```php
Route::get('/offline', function () {    
    return view('modules/laravelpwa/offline');
});
```

### Vista de la ruta Offline

Cuando publicamos los assets con el comando vendor:publish, fue publicada una vista de Blade y está ubicada en la carpeta de vistas **/modules/laravelpwa/offline.blade.php**, deberás personalizarla y esta debe renderizar en el layout (vista padre), en la cual pusimos la directiva **@laravelPWA**.

```php
@extends('layouts.app')

@section('content')

    <h1>Personaliza este contenido</h1>

@endsection
```

### Nota final

Si estás desplegando el servidor de desarrollo con NPM y BrowserSync, la PWA no funcionará en desarrollo, debido a que BrowserSync usa un virtual host (ejemplo: `myapp.local`), así el manifiesto registra el virtual host mientras que el service worker registra una URL diferente, en este caso `localhost:3000`, por lo cual no mostrará la opción de instalación en el navegador.

No olviden compartir, gracias.