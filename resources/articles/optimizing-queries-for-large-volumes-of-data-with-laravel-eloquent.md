---
title: 'Optimizing queries for large volumes of data with Laravel Eloquent'
excerpt: 'Run big data queries with maximum performance and low memory usage using the Laravel Eloquent ORM and the Query Builder.'
publishedAt: '2022-02-21'
updatedAt: null
locale: 'en'
image: 'images/articles/optimize-eloquent-queries.webp'
tags:
- php
- laravel
- orm
- eloquent
---

In high traffic applications, performance is a fundamental aspect, it is required to apply the best practices at the database level, on the server side (backend) and on the client side (frontend), the images must be optimized, the CSS and JavaScript must be minified, database queries must be the minimum required to consume the least amount of resources and execute in the shortest possible time; performance is an essential aspect of SEO and user experience.

This article compiles recommendations for optimizing database queries using Eloquent ORM and the Laravel query builder for large data volume scenarios.

### Query all table records without hydrating models using generators

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

$posts = DB::table('posts')
    ->select(['id', 'title', 'content'])
    ->cursor();
```

In the previous example, the toBase() method returns the query builder, the columns to select are set, and the result is obtained using generators with the cursor() method. This case is very useful when the use of any of Eloquent's features such as mutators, accessors, type conversion and others is not required, since object instances of the standard PHP class (StdClass) are returned in the query.

### Query the entire table by record sets

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

Ordering by the primary key in order for the query to be very efficient, in case another column is used, the recommendation is to add that column as an index.

<article-ad></article-ad>

### Query table by recordsets using primary key

```php
<?php

use App\Models\Post;
use Illumin\Support\Collection;
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

This technique is much more optimal compared to the use of **chunk()**, since the primary key is used to select a certain number of records.

### Query entire table by recordsets with generators

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
        $post->title . PHP_EOL;
     }
} while ($count === $perPage);
```

In this example, each page is queried manually until the last page returns fewer records than expected per page; thus it is possible to use generators for each set of records. If you want to use Eloquent models, then you should remove the toBase() method.

### Generators usage in Laravel 8+

**Lazy method**: This method will return a LazyCollection, which internally uses generators.

```php
lazy(int $chunkSize = 1000): LazyCollection
```

Example:

```php
<?php

use App\Models\Post;

$posts = Post::latest('id')->lazy();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
});
```

**LazyById method**: Variations LazyByIdDesc, orderedLazyById.

```php
<?php

use App\Models\Post;

$posts = Post::whereNotNull('published_at')->lazyById();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
});
```

For more information about lazy methods, click [here](https://laravel.com/api/8.x/Illuminate/Database/Concerns/BuildsQueries.html#method_lazy).

### Specific query for when only two columns are required

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

$posts = DB::table('posts')->pluck(['title', 'id']);
```

The pluck() method returns a collection of key and value pair, where the key is the second position in the array and the value is the first position.

### Subqueries and relationships

Subqueries allow us to reduce the number of queries to the database, as well as the models to hydrate, this is better performance and memory optimization:

#### Query last record in one-to-many relationship

```php
<?php

use App\Models\Post;
use App\Models\Comment;

$posts = Post::addSelect([
        'last_comment' =\> Comment::select('content')
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

Optimizing controller indexes with subqueries to parent tables

```php
<?php

use App\Models\Post;
use App\Models\Author;

$posts = Post::addSelect([
            'author_name' =\> Author::select('name')
                ->whereColumn('posts.author_id', 'authors.id')
                ->take(1),
		])
		->paginate();

$posts->each(function (Post $post): void {
    echo $post->title . PHP_EOL;
    echo $post->author_name . PHP_EOL;
});
```

#### Querying relationships using joins

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

<article-ad></article-ad>

### SQL views for complex queries

A view is the result set of a query stored in the database. An SQL view behaves like a table, so queries can be executed on it. When you have a long complex queries, SQL views are the righ way. A classic example of use is the generation of reports.

An example of a complex query could be the following, where several tables are consulted, there is also a where condition and data counters. This series of queries would be an ideal candidate for creating a view:

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

A good practice in Laravel is to create the SQL views inside the database folder, views subfolder, with a .sql file extension, and use a migration to bring them to the database; after migration execution, can be used by the query constructor or creating a model where the assigned table will be the view.

### Use SQL view with Laravel Eloquent models

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
    protected $table = 'contents';
}
```

Query example:

```php
Content::where('total_comments', '>', 0)
    ->first(['id', 'title', 'author_name']);
```

**Use SQL view with Laravel Query Builder**

```php
use Illuminate\Support\Facades\DB;

DB::table('contents')
    ->where('total_comments', '>', 0)
    ->first(['id', 'title', 'author_name']);
```

Add indexes to frequently queried columns

If you frequently query a column in a table, you can improve query performance by adding an index to the column using a migration:

```php
Schema::table('posts', function (Blueprint $table) {
    $table->index('status');
});
```

Optimization tips and operations on database tables

* Add indexes to the columns that will be used for searching and sorting.
* If a column is heavily used in queries, you should add it as a table index.
* When a table in your application is storing large amounts of data in a field, for example, of type JSON or TEXT, you should migrate this field data to a separate table and create a relationship with the parent table. This solution minimizes the database query time.
* If an application functionality requires generating information from existing data, in such a way that it constantly queries and inserts into the database, consider using triggers.
* If you need to update medium and large volumes of data, such as populating a table, filling a column from existing data, replacing tables, consider using the database engine directly, this kind of operations would be slow if data is queried and then inserted. Instead, stored procedures or simply direct statements could be executed, in this way, the database engine that will carry out all the operations.

This is a companion article to: [Optimize Eloquent queries to reduce memory usage in Laravel](https://omarbarbosa.com/posts/optimization-of-eloquent-queries-to-reduce-memory-usage).

If you liked the content, share it, because sharing makes us grow. Thanks to [freepik.com](https://www.freepik.com/vectors/background) for the image.