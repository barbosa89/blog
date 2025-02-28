---
title: 'Optimization of the Eloquent queries to reduce memory usage in Laravel'
excerpt: 'Optimize Eloquent queries to reduce memory usage in Laravel and maintain application performance.'
publishedAt: '2019-06-27'
updatedAt: null
locale: 'en'
image: 'images/articles/optimize-eloquent-queries.webp'
tags:
- php
- laravel
- orm
- eloquent
---

Laravel is the most powerful framework of the PHP community, among its main advantages are its clean and orderly code and slight learning curve. In Laravel, is possible to develop professional applications in a very short time. Composer adds versatility with the management of back-end packages together with NPM in the front-end and Laravel Mix. Laravel also has a powerful ORM that allows you to query the database smoothly and efficiently. In this article, Eloquent ORM will be the main topic and will explain how to optimize queries to the database to reduce memory usage. The code used for the tests is in the following link: [Optimization](https://github.com/barbosa89/optimization)

Testing environment

The tests were executed in the following software:

* Ubuntu 18.04 LTS
* PHP 7.2
* MySQL 5.7
* Apache 2.4
* Laravel 5.6
* Laravel DebugBar

The description of the problem

Undoubtedly, the Eloquent ORM is very powerful but to be able to make the most of it, it is necessary to perform some good practices to query the database. For example:

```php
<?php

use App\Models\Post;

# Query all posts
$posts = Post::all();
```

Internally, Eloquent waits for an array of parameters, the fields of the table to query, otherwise, Eloquent executes the asterisk wildcard (*) to select all the columns by default.

```php
static Collection|Model[] all(array|mixed $columns = ['*'])
```

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-1.png" alt="Example query all posts using asterisk wildcard">

This is bad practice you must avoid.

## Why not use asterisk wildcard (*) in MySQL

The reasons are basically performance and safety:

* The asterisk wildcard is only for development and testing.
* The MySQL engine performs extra queries when this wildcard is used.
* Columns are selected that may not be required or used.
* Unnecessary traffic is done between MySQL server and the application.
* The performance of the application is compromised as the number of users increases.
* It can result in a possible vulnerability to the application, by exposing data that should not be exposed.

If your application is made using asterisk wildcard, I think: "**we have problems, Houston**"

## Examples

Next, very typical queries are exposed in web applications using Laravel:

### Query all records in the user table

```php
<?php 

use App\Models\User;

# Wrong
$users = User::all();

# Right
$users = User::all(['id', 'name', 'email']);
```

### Query all the records of the user table with the articles of each user using Eager Loading

```php
<?php 

use App\Models\User;

# Wrong
$users = User::with('posts')->get();

# Right
$users = User::with([
        'posts' => function($query) {
            $query->select('id', 'title', 'content', 'user_id');
        }
    ])
    ->get(['id', 'name', 'email']);
```

### Query all posts with related models

```php
<?php 

use App\Models\Post;

# Wrong
$posts = Post::with(['images', 'tags', 'user'])->get();

# Right
$posts = Post::with([
        'tags' => function($query) {
            $query->select('id', 'name'); # Many to many
        }, 
        'images' => function($query) {
            $query->select('id', 'url', 'post_id'); # One to many
        }, 
        'user' => function($query) {
            $query->select('id', 'name'); # One to many
        }
    ])
    ->get(['id', 'title', 'content', 'user_id']);
```

### Query all posts with pagination

```php
<?php 

use App\Models\Post;

# Wrong
$posts = Post::paginate(30);

# Right
$posts = Post::paginate(30, ['id', 'title', 'content', 'user_id']);
```

You can invoke the with method before the paginate method to load related models.

### Looking for a post

```php
<?php 

use App\Models\Post;

# Wrong
$post = Post::find($id);

# Right
$post = Post::find($id, ['id', 'title', 'content']);
```

### Looking for a post using Where clausule

```php
<?php 

use App\Models\Post;

# Wrong
$post = Post::where('id', $id)->first();

# Right
$post = Post::where('id', $id)->first(['id', 'title', 'content']);
```

Using the Where clause you can search many posts in conjunction with the Get method, which returns a collection of objects, while the First and Find methods become an object.

### Searching posts of an authenticated user with related models

```php
<?php 

use App\Models\User;
use App\Models\Post;

# Wrong
$posts = User::find(auth()->user()->id)
    ->posts()
    ->with(['images', 'tags', 'user'])
    ->get();

# Right
$posts = User::find(auth()->user()->id)
    ->posts()
    ->with([
        'tags' => function($query) {
            $query->select('id', 'name'); # Many to many
        }, 
        'images' => function($query) {
            $query->select('id', 'url', 'post_id'); # One to many
        }, 
        'user' => function($query) {
            $query->select('id', 'name'); # One to many
        }
    ])
    ->get(['id', 'title', 'content', 'user_id']);
```

This same technique can be applied to search any registry related to the authenticated user.

### Advanced queries

```php
<?php 

use App\Models\Invoice;

# Wrong
$invoice = Invoice::where('id', $id)
    ->with([
        'products',
        'products.subcategory',
        'products.subcategory.category',
        'customer',
    ])->first();

# Right
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

## Tests executed

The data that was used are:

* 50 users
* 1000 posts
* 2000 tags
* 1000 images

## Query all users with posts

**Wrong**

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-2.png" alt="Example wrong Eloquent query">

**Right**

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-3.png" alt="Example right Eloquent query">

**Differences**

* Memory: 0.36 Mb
* Time: 158,47 ms

## Query all posts with related models

### Wrong

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-4.png" alt="Example wrong Eloquent query">

### Right

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/eloquent-queries-5.png" alt="Example right Eloquent query">

### Differences

* Memory: 0.38 Mb
* Time: 177,45 ms

### Conclusions of the tests

Since this is a test environment in local, the difference is not very high, however, in applications in production, these memory usage are much higher and a decrease in server performance could be observed. If these results are multiplied by a considerable number of users who could visit the application, the problem will become more noticeable. In any case, it is not advisable to use the asterisk wildcard for production environments, it is very likely that if the web application grows, the server will be saturated.

## Final performance tips

This only on Laravel <= 5.5

```bash
php artisan optimize
```

This on Laravel > 5.0

```bash
php artisan config:cache
php artisan route:cache
```

### Others

* Use a CDN for static files
* Consider using Laravel with [Swoole](https://www.swoole.co.uk/)

The code used for the tests is in the following link: [Optimization](https://github.com/barbosa89/optimization)