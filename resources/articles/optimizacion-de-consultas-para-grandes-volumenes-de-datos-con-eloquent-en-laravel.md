---
title: 'Optimización de consultas para grandes volúmenes de datos con Eloquent en Laravel'
excerpt: 'Ejecuta consultas de grandes volúmenes de datos con el máximo rendimiento y bajo consumo de memoria usando Laravel Eloquent ORM y el Query Builder.'
publishedAt: '2021-12-15'
updatedAt: null
locale: 'es'
image: 'images/articles/optimize-eloquent-queries.webp'
tags:
- php
- laravel
- orm
- eloquent
---

En aplicaciones de alto tráfico el rendimiento es un aspecto fundamental, se requiere aplicar las mejores prácticas a nivel de base de datos, del lado del servidor (backend) y del lado del cliente (frontend), las imágenes deben estar optimizadas, los archivos de CSS y JavaScript deben estar minificados, las consultas a la base de datos deben ser las mínimas requeridas para consumir la menor cantidad de recursos y ejecutarse en el menor tiempo posible; el rendimiento es un aspecto esencial en el SEO y en la experiencia de usuario.

En este artículo se recopilan recomendaciones de optimización de consultas a la base de datos usando Eloquent ORM y el constructor de consultas de Laravel para casos de grandes volúmenes de datos.

### Consultar todos los registros de la tabla sin hidratar modelos usando generadores

```php
<?php

use App\Models\Post;
use Illuminate\Support\Facades\DB;

$posts = Post::toBase()
    ->select(['id', 'title', 'content'])
    ->cursor();

foreach($posts as $post) {
    echo $post->title . PHP_EOL;
}

# Equivalencia con Query builder
$posts = DB::table('posts')
    ->select(['id', 'title', 'content'])
    ->cursor();
```

En el ejemplo anterior, el método **toBase()** retorna el constructor de consultas (Query builder), se establecen las columnas a seleccionar y se obtiene el resultado usando generadores con el método **cursor()**. Este caso es muy útil cuando no se require el uso de ninguna de las catacterísticas de Eloquent como mutadores, accesores, conversión de tipos y demás, ya que en la consulta se devuelven instancias de objectos de la clase estándar de PHP (StdClass).

### Consultar toda la tabla por conjuntos de registros

```php
<?php

use App\Models\Post;
use Illumin\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection as ECollection;

$posts = Post::select(['id', 'title', 'content'])
    ->oldest('id')
    ->chunk(250, function (ECollection $posts): void {
        $posts->each(function (Post $post): void {
            echo $post->title . PHP_EOL;
        });
    });

$posts = DB::table('posts')
    ->select(['id', 'title', 'content'])
    ->oldest('id')
    ->chunk(250, function (Collection $posts): void {
        $posts->each(function (stdClass $post): void {
            echo $post->title . PHP_EOL;
        });
    });
```

Es importante **ordenar por la clave primaria** con el propósito de que la consulta sea muy eficiente, en caso de usarse otra columna, se recomienda agregar esa columna como un índice.

### Consultar la tabla por conjuntos de registros usando la clave primaria

```php
<?php

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection as ECollection;

$posts = Post::select(['id', 'title', 'content'])
    ->chunkById(250, function (ECollection $posts): void {
        $posts->each(function (Post $post): void {
            echo $post->title . PHP_EOL;
        });
    });

$posts = DB::table('posts')
    ->select(['id', 'title', 'content'])
    ->chunkById(250, function (Collection $posts): void {
        $posts->each(function (stdClass $post): void {
            echo $post->title . PHP_EOL;
        });
    });

$posts = Post::toBase()
    ->select(['id', 'title', 'content'])
    ->chunkById(250, function (Collection $posts): void {
        $posts->each(function (stdClass $post): void {
            echo $post->title . PHP_EOL;
        });
    });
```

Esta técnica es mucho más optima en comparación del uso de **chunk()**, ya que se hace uso de la clave primaria para seleccionar una determinada cantidad de registros.

### Consultar toda la tabla por conjuntos de registros con generadores

```php
<?php

use App\Models\Post;

$page = 1;
$perPage = 20;

do {
    $posts = Post::toBase()
        ->select(['id', 'title', 'content'])
        ->forPage($page, $perPage)
        ->cursor();

    $count = $posts->count();
    $page++;

    foreach($posts as $post) {
        // $post es una instancia de stdClass
        $post->title . PHP_EOL;
     }
} while ($count === $perPage);
```

En este ejemplo, se consulta cada página manualmente hasta que la última página devuelva menos registros de los esperados por página; así es posible usar generadores para cada conjunto de registros consultados. Si se desea usar modelos de Eloquent, entonces se debe quitar el método **toBase()**.

**Laravel 8** introdujo una sintaxis muy amigable para el uso de generadores:

**Método Lazy:** Este método devolverá una **LazyCollection**, las cuales usan internamente generadores.

```php
// Firma del método
lazy(int $chunkSize = 1000): LazyCollection
```

Ejemplo:

```php
<?php

use App\Models\Post;

$posts = Post::latest('id')->lazy();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
});
```

**Método LazyById**

```php
// Firma del método
lazyById(int $chunkSize = 1000, string|null $column = null, string|null $alias = null): LazyCollection
```

Variaciones: **LazyByIdDesc**, **orderedLazyById**.

```php
<?php

use App\Models\Post;

$posts = Post::whereNotNull('published_at')->lazyById();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
});
```

Para mayor información sobre estos métodos, clic [aquí](https://laravel.com/api/8.x/Illuminate/Database/Concerns/BuildsQueries.html#method_lazy).

### Consulta específica para cuando se requieren sólo dos columnas

```php
<?php

use App\Models\Post;
use Illuminate\Support\Facades\DB;

$posts = Post::pluck(['title', 'id']);

$posts->each(function (string $title, int $id): void {
    echo $id . PHP_EOL;
    echo $title . PHP_EOL;
});

foreach($posts as $id => $title) {
    echo $id . PHP_EOL;
    echo $title . PHP_EOL;
}

// Usando el contructor de consultas
$posts = DB::table('posts')->pluck(['title', 'id']);
```

El método **pluck()** devuelve una colección de clave y valor, bajo una consulta única, en donde la clave es la segunda posición de la matríz y el valor es la primera posición.

## Subconsultas y relaciones

Las subconsultas nos permiten disminuir la cantidad consultas a la base de datos, así como también los modelos a hidratar, esto se traduce en mayor rendimiento y optimización de la memoria:

### Consultar último registro en relación de uno a muchos

```php
<?php

use App\Models\Post;
use App\Models\Comment;

$posts = Post::addSelect([
        'last_comment' => Comment::select('content')
            ->whereColumn('post_id', 'posts.id')
            ->latest()
            ->take(1),
    ])
    ->paginate();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
    echo $post->last_comment . PHP_EOL;
});
```

### Optimización de índices de controladores con subconsultas a tablas padre

```php
<?php

use App\Models\Post;
use App\Models\Author;

$posts = Post::addSelect([
            'author_name' => Author::select('name')
                ->whereColumn('posts.author_id', 'authors.id')
                ->take(1),
		])
		->paginate();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
    echo $post->author_name . PHP_EOL;
});
```

### Consulta de relaciones usando uniones

```php
<?php

use App\Models\Post;
use App\Models\Author;

$posts = Post::join('authors', 'authors.id', 'posts.author_id')
    ->select([
        'posts.title',
        'authors.name as author_name'
    ])
    ->paginate();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
    echo $post->author_name . PHP_EOL;
});
```

### Vistas SQL para consultas complejas

Una vista es el conjunto de resultados de una consulta almacenada en la base de datos. Una vista SQL se comporta como una tabla, por lo que sobre ella se pueden ejecutar consultas. Cuando nos encontramos frente a una o serie de consultas largas y complejas, es adecuado optar por la utilización de vistas SQL, las cuales nos va a permitir obtener datos de forma concisa. Un ejemplo clásico de uso es la generación de informes.

Un ejemplo de una consulta compleja podría ser la siguiente, donde se consultan varias tablas, también existe condición **where** y contadores de datos. Esta serie de consultas serían un candidato ideal para crear una vista:

```sql
CREATE VIEW contents AS
SELECT
    posts.id as id,
    posts.title as title,
    authors.name as author_name,
    authors.email as author_email,
    categories.description as category_description,
    (SELECT count(*)
        FROM comments
        WHERE posts.id = comments.post_id) AS total_comments
    FROM posts
    JOIN authors ON authors.id = posts.author_id
    JOIN categories ON categories.id = posts.category_id;
    WHERE posts.published_at IS NOT NULL;
```

Una buena práctica en Laravel es crear las vistas SQL dentro de la carpeta database, subcarpeta views, con extensión de archivo .sql, y usar una migración para llevarlas a la base de datos; su uso puede ser usando el constructor de consultas o crear un modelo en donde la tabla asignada será la vista.

**Usando un modelo:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
    protected $table = 'contents';
}
```

**Consulta con modelo:**

```php
use App\Models\Content;

Content::where('total_comments', '>', 0)
    ->first(['id', 'title', 'author_name']);
```

**Consulta con el constructor y nombre de la vista:**

```php
use Illuminate\Support\Facades\DB;

DB::table('contents')
    ->where('total_comments', '>', 0)
    ->first(['id', 'title', 'author_name']);
```

### Agregar índices a las columnas consultadas frecuentemente

Si consulta con frecuencia una columna de una tabla, puede mejorar el rendimiento de la consulta agregando un índice a la columna usando una migración:

```php
Schema::table('posts', function (Blueprint $table) {
    $table->index('status');
});
```

### Consejos de optimización y operaciones en tablas de bases de datos

* Agregar índices a las columnas que se usarán para búsquedas y para ordenamiento.
* Si una columna es muy usada en las consultas, entonces es señal que debe ser indexada también.
* Cuando en su aplicación una tabla está almacenando grandes cantidades de datos en un campo, por ejemplo, de tipo JSON o TEXT, es recomendable que migre estos datos y el campo a una tabla individual y crear una relación con la tabla padre. Esta solución minimiza el tiempo de consulta a la base de datos.
* Si una funcionalidad de la aplicación requiere generar información a partir de los datos existentes, de tal forma que constantemente consulta e inserta en la base de datos, considere usar disparadores (triggers).
* Si requiere actualizar medianos y grandes volúmenes de datos, como poblar una tabla, llenar una columna a partir de datos existentes, sustituir tablas, considere usar directamente el motor de base de datos, esta clase de operaciones sería lenta si se consultan datos para luego insertar, en su lugar se podrían ejecutar procedimientos almacenados o simplemente sentencias directas, de esta forma, es el motor de base de datos quién realizará todas las operaciones.

Este es un artículo complementario de: [Optimiza las consultas de Eloquent para reducir el uso de memoria en Laravel](https://omarbarbosa.com/posts/optimiza-consultas-eloquent-reducir-uso-memoria-laravel).

Si te ha gustado el contenido, compártelo, pues compartir nos hace crecer. Agradecimientos a [freepik.com](https://www.freepik.com/vectors/background) por la imágen.