---
title: 'Optimiza las consultas de Eloquent para reducir el uso de memoria en Laravel'
excerpt: 'Optimiza las consultas de Eloquent, el poderoso ORM de Laravel para reducir el uso de memoria en las consultas a la base de datos.'
publishedAt: '2019-06-27'
updatedAt: null
locale: 'es'
image: 'images/articles/laravel-logo.png'
tags:
- laravel
- eloquent
---

Laravel es el framework más poderoso de toda la comunidad PHP, entre sus principales ventajas se encuentran código limpio y ordenado, y una pequeña curva de aprendizaje. En Laravel es posible desarrollar aplicaciones profesionales en muy poco tiempo. Composer agrega versatilidad con la administración de paquetes back-end junto con NPM en el front-end y Laravel Mix. También tiene un ORM potente que le permite consultar la base de datos de manera fluida y eficiente. En este artículo, Eloquent ORM será el tema principal y explicará cómo optimizar las consultas a la base de datos para reducir el consumo de memoria. El código utilizado para las pruebas se encuentra en el siguiente enlace: [Optimización.](https://github.com/barbosa89/optimization)

## Ambiente de pruebas

Las pruebas fueron ejecutadas en el siguiente software:

* Ubuntu 18.04 LTS
* PHP 7.2
* MySQL 5.7
* Apache 2.4
* Laravel 5.6
* Laravel DebugBar

## Descripción del problema

Sin lugar a dudas, Eloquent ORM es muy poderoso, pero para poder aprovecharlo al máximo, es necesario realizar algunas buenas prácticas al consultar la base de datos. Por ejemplo:

```php
<?php  

use App\Models\Post;  

$posts = Post::all();
```

Internamente, Laravel espera una serie de parámetros en forma de matriz, ya que no recibe lo esperado, ejecuta el comodín de asterisco (*) para seleccionar todas las columnas.

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-1.png" alt="Ejemplo de consulta de todos los posts">

La práctica del uso de comodín asterisco está desaconsejada y se debe evitar siempre.

## ¿Por qué no utilizar el comodín asterisco(*) en MySQL?

Las razones son básicamente rendimiento y seguridad:

* El comodín de asterisco es sólo para desarrollo y prueba.
* El motor MySQL realiza consultas adicionales cuando se utiliza este comodín.
* Son seleccionadas columnas que pueden no ser requeridas o utilizadas.
* Se realiza tráfico innecesario entre MySQL y la aplicación.
* El rendimiento de la aplicación se ve comprometido a medida que aumenta la cantidad de usuarios.
* Puede provocar una posible vulnerabilidad a la aplicación al exponer datos que no deberían exponerse.

Si su aplicación está hecha con este comodín para las consultas, creo que tenemos problemas, Houston.

<article-ad></article-ad>

## Ejemplos

A continuación, las consultas muy típicas ejecutadas en aplicaciones web que utilizan Laravel:

### Consultar todos los registros de la tabla usuarios

```php
<?php 

use App\Models\User;

# Incorrecto
$users = User::all();

# Correcto
$users = User::all(['id', 'name', 'email']);
```

### Consultar todos los registros de la tabla de usuarios con los artículos de cada usuario usando Eager Loading

```php
<?php 

use App\Models\User;

# Incorrecto
$users = User::with('posts')->get();

# Correcto
$users = User::with([
        'posts' => function($query) {
            $query->select('id', 'title', 'content', 'user_id');
        }
    ])
    ->get(['id', 'name', 'email']);
```

### Consultar todos los post con modelos relacionados

```php
<?php 

use App\Models\Post;

# Incorrecto
$posts = Post::with(['images', 'tags', 'user'])->get();

# Correcto
$posts = Post::with([
        'tags' => function($query) {
            $query->select('id', 'name'); # Muchos a muchos
        }, 
        'images' => function($query) {
            $query->select('id', 'url', 'post_id'); # Uno a muchos
        }, 
        'user' => function($query) {
            $query->select('id', 'name'); # Uno a muchos
        }
    ])
    ->get(['id', 'title', 'content', 'user_id']);
```

### Consultar todos los post con paginación

```php
<?php 

use App\Models\Post;

# Incorrecto
$posts = Post::paginate(30);

# Correcto
$posts = Post::paginate(30, ['id', 'title', 'content', 'user_id']);
```

Puede invocar el método `with()` antes del método `paginate()` para cargar modelos relacionados.

### Buscando un post

```php
<?php 

use App\Models\Post;

# Incorrecto
$post = Post::find($id);

# Correcto
$post = Post::find($id, ['id', 'title', 'content']);
```

### Buscando un post usando Where()

```php
<?php 

use App\Models\Post;

# Incorrecto
$post = Post::where('id', $id)->first();

# Correcto
$post = Post::where('id', $id)->first(['id', 'title', 'content']);
```

Con el método `where()` puede buscar muchas publicaciones junto con el método `get()`, que devuelve una colección de objetos, mientras que los métodos `first()` y `find()` devuelven un objeto.

### Búsqueda de post de un usuario autenticado con modelos relacionados

```php
<?php 

use App\Models\User;
use App\Models\Post;

# Incorrecto
$posts = User::find(auth()->user()->id)
    ->posts()
    ->with(['images', 'tags', 'user'])
    ->get();

# Correcto
$posts = User::find(auth()->user()->id)
    ->posts()
    ->with([
        'tags' => function($query) {
            $query->select('id', 'name'); # Muchos a muchos
        }, 
        'images' => function($query) {
            $query->select('id', 'url', 'post_id'); # Uno a muchos
        }, 
        'user' => function($query) {
            $query->select('id', 'name'); # Uno a muchos
        }
    ])
    ->get(['id', 'title', 'content', 'user_id']);
```

Esta misma técnica puede ser usada para buscar algún registro relacionado con el usuario autenticado.

### Consultas avanzadas

```php
<?php 

use App\Invoice;

# Incorrecto
$invoice = Invoice::where('id', $id)
    ->with([
        'products',
        'products.subcategory',
        'products.subcategory.category',
        'customer',
    ])->first();

# Correcto
$invoice = Invoice::where('id', $id)
    ->with([
        'products' => function($query) {
            $query->select('id', 'price', 'description', 'subcategory_id')
                ->withPivot('quantity', 'subvalue', 'taxes', 'value');
        },
        'products.subcategory' => function($query) {
            $query->select('id', 'name', 'category_id');
        },
        'products.subcategory.category' => function($query) {
            $query->select('id', 'name');
        },
        'customer' => function($query) {
            $query->select('id', 'name', 'lastname', 'dni', 'addrress', 'phone');
        },
    ])
    ->first(['id', 'subvalue', 'taxes', 'value', 'customer_id']);
```

<article-ad></article-ad>

## Pruebas ejecutadas

Los datos que fueron usados:

* 50 usuarios
* 1000 posts
* 2000 tags
* 1000 imágenes

### Consultar todos los usuarios con posts

### Incorrecto

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-2.png" alt="Ejemplo de consulta incorrecta en Eloquent">

### Correcto

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-3.png" alt="Ejemplo de consulta correcta en Eloquent">

### Diferencias

* Memoria: 0.36 Mb
* Tiempo: 158,47 ms

### Consultar todos los usuarios con posts y modelos relacionados

### Incorrecto

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-4.png" alt="Ejemplo de consulta incorrecta en Eloquent">


**Correcto**

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-5.png" alt="Ejemplo de consulta correcta en Eloquent">

### Diferencias

* Memoria: 0.38 Mb
* Tiempo: 177,45 ms

## Conclusión

Dado que este es un entorno de prueba en local, la diferencia no es muy alta, sin embargo, en las aplicaciones en producción estos consumos de memoria son mucho mayores y podría observarse una disminución en el rendimiento del servidor. Si estos resultados son multiplicados por un número considerable de usuarios que podrían visitar la aplicación, el problema se hará más notorio. En todo caso, no es aconsejable utilizar el comodín asterisco para entornos en producción, es muy probable que si la aplicación web crece el servidor será saturado.

## Trucos de rendimiento

### Comandos que puede ejecutar en Laravel

Sólo para Laravel <= 5.5

```bash
php artisan optimize
```

Para Laravel > 5.0

```bash
php artisan config:cache
php artisan route:cache
```

### Otros

* Usar un CDN para archivos estáticos
* Podrías usar [Swoole](https://www.swoole.co.uk/) junto a Laravel

El código utilizado para las pruebas se encuentra en el siguiente enlace: [Optimización](https://github.com/barbosa89/optimization)