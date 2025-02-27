---
title: 'Modern PHP from version 7.x to 8.x'
excerpt: 'PHP is a modern, fast and powerful language, learn its new features and write scalable applications in powerful frameworks such as Laravel and Symfony. '
publishedAt: '2023-10-12'
updatedAt: null
locale: 'en'
image: 'images/articles/php-new-features.webp'
tags:
- php
---

PHP is the most used language for developing web pages, applications and web services, although you can also use it for desktop applications, IoT, artificial intelligence and more, for a long time this language was very popular, but between the years 2009 and 2012, it went from being very popular to being very criticized; In 2011, Taylor Otwell launched the first version of the Laravel framework, an event that represented a new birth for PHP, it rose from the ashes like the Phoenix, the impressive community that emerged around Laravel and Symfony, returned much strength to the language, PHP is currently a modern language, very powerful and versatile, with a learning curve that allows rapid evolution, an aspect that is also projected in Laravel.

The most outstanding features are the typing of properties and methods or functions and return values with variance and contra variance, anonymous classes, modern cryptography, arrow functions, array destructuring and merging, operators for handling null values, preloading, FFI, JIT compiler, attributes, named arguments, improvements in class constructors, union and intersection of types, the match expression, enumerations, read-only properties and classes, and much more.

This article compiles all the features of modern PHP with code examples to strengthen your knowledge, from version 7.0 to 8.3:

## Type declarations

Being a dynamically typed language, PHP allows passing any type of parameter in properties, methods or functions, from version 7.0 onwards, type declarations were added and have been improved with each release.

```php
<?php

namespace App\Models\User;

use Core\ORM\Model;

class User extends Model
{
    private string $table = 'users';

    protected array $columns = [
        'id',
        'name',
        'email',
        'password',
        'verified_at',
    ];

    public function getVerifiedAt(): string|null
    {
        return $this->attributes['verified_at'];
    }

    public function isVerified(): bool
    {
        return !empty($this->getVerifiedAt())
    }
}  
```

Other types: void, parent, callable, self, iterable, object, null, true, false, never, enumerations, classes and interfaces. This is what a class written in modern PHP looks like. More information about types [here](https://www.php.net/manual/es/language.types.declarations.php).

In the example above we can see type binding, but it is possible to take advantage of this feature with objects as well:

```php
<?php

use App\Models\User;

class CreateUserAction
{
    public function execute(): User|false
    {
        // Code
    } 
}
```

## Type intersection

It consists of the ability in which an argument must satisfy multiple constraints, for example, multiple contracts:

```php
<?php

interface Arrayable
{
    public function toArray(): array; 
}

interface Formattable
{
    public function format(): string; 
}

class Invoice implements Formattable, Arrayable
{
    ...
}

class Quote implements Formattable, Arrayable
{
    ...
}

class Printer
{
    public function __construct(
        private readonly Formattable&Arrayable $document
    ) {
        // ..
    }
}
```

Can we combine union and intersection of types? Of course, this is called **Disjunctive Normal Form**.

```php
<?php

class Printer
{
    public function __construct(
        private readonly (Formattable&Arrayable)|null $document
    ) {
        // ..
    }
}
```

We now have the ability to add constraints and combine with PHP's native types.

## Null handling

A common problem in all languages is null handling, PHP has one of the best mechanisms for this purpose.

### Null fusion operator

```php
<?php

$data = ['key' => 'value'];

echo $data['unknown'] ?? 'default' . PHP_EOL; 
```

Even though the key of the array does not exist, the default value will be displayed.

### Passing and returning nulls

Allows a property, method or function to receive or return a null value.

```php
<?php

function greeting (?string $name): ?string {
    if (!$name) {
        return null;
    }

    return "Hola, {$name}";
} 
```

This code can be written using type union:

```php
<?php

function greeting (string|null $name): string|null {
    if (!$name) {
        return null;
    }

    return "Hola, {$name}";
}
```

### Null coalescing assignment operator

This powerful operator saves us when we try to access unassigned or null values.

```php
<?php

class Cache
{
    private array $data;

    public function remember (string $key, Closure $closure): mixed
    {
        return $this->data[$key] ??= $closure();
    }
}
```

In the example, the value is returned if it exists, or it is assigned and returned; in either case, a value will be returned.

### Null safe Operator

If you have tried to use a method that returns an object or null, then you will understand the importance of this powerful operator, in Laravel we have the Auth facade, with which we can access the authenticated user:

```php
<?php

use Illuminate\Support\Facades\Auth;

$userName = Auth::user()?->name;
```

If there is no authenticated user, the variable will be assigned a null value.

## Anonymous classes

This feature allows you to change the behavior of a class, a mock, for example; or just define an entire class. Laravel takes advantage of anonymous classes to prevent name collisions in migrations.

```php
<?php

$date = date('Y-m-d');

$dateFormatter = new class($date) extends DateFormatter {
    public function __construct(string $date)
    {
        $this->date = date_create($date);
    }    

    public function format(string $format = 'd/m/Y'): string
    {
        return date_format($this->date, $format);
    }
};

echo $dateFormatter->format() . PHP_EOL;
```

In PHP 8.3, anonymous classes can be read-only:

```php
<?php

$dateFormatter = new readonly class($date) {
    ...
};

echo $dateFormatter->format() . PHP_EOL;
```

## Very exceptional exceptions

PHP allows you to add multiple catch blocks to a try block, or simply catch multiple exceptions in the same catch block.

```php
<?php

try {
    // Code
} catch (ErrorException $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
}

// The above code can be written like this

try {
    // Code
} catch (ErrorException | RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
}
```

If the catch block variable will not be used, you can simply omit its declaration.

```php
<?php

try {
    // Code
} catch (ErrorException | RuntimeException) {
    // ..
}
```

## Arrays

### Destructuring

It is the mechanism to break the structure of an array and access its contents:

```php
<?php

$user = [
    'John Doe',
    'email@domain.com',
];

[$name, $email] = $user;

echo $name . PHP_EOL;
echo $email . PHP_EOL;

// Associative array

$user = [
    'name' => 'John Doe',
    'email' => 'email@domain.com',
];

['name' => $name, 'email' => $email] = $user;

echo $name . PHP_EOL;
echo $email . PHP_EOL;

// Collections

$users = [
    ['John Doe', 'email@domain.com'],
    ...
];

foreach ($users as [$name, $email]) {
    echo $name . PHP_EOL;
    echo $email . PHP_EOL;
}
```

### Unpacking

PHP has the `array_merge()` and `array_merge_recursive()` functions for merging arrays, but now it is much simpler and more elegant:

```php
<?php

$web = ['php', 'javascript'];
$desktop = ['java', 'c#'];

$languages = [...$web, ...$desktop];
```

## Class constants

Constants are essential to structure the code professionally, in PHP we can add visibility, and since version 8.3 we have the following types: string, array, int, float, bool.

```php
<?php

class File
{
    public const string DEFAULT_DISK = 'public';
    public const int BYTE_RATE = 1024;
}
```

Dynamic access is allowed in the same way it works for properties and methods:

```php
<?php

// Property access
echo $object->{$propertyName} . PHP_EOL;

// Method access
echo $object->{$methodName}() . PHP_EOL;

$name = 'DEFAULT_DISK';

// Constant access
echo FILE::{$name} . PHP_EOL;
```

## Arrow functions

Very famous in JavaScript, an improvement to callables and Closure, PHP allows one-line arrow functions:

```php
<?php

$names = ['php', 'laravel'];

$data = array_map(fn ($name) => strtoupper($name), $names);
```

## Numeric literal separator

Trying to read a large number is no longer a problem in PHP:

```php
<?php

echo 1_000_000 . PHP_EOL;
echo 6.674_083e-11 . PHP_EOL;
echo 0xCAFE_F00D . PHP_EOL;
```

## Named arguments

Some of the best additions, especially when we have null or optional parameters:

```php
<?php

function setcookie( string $name,
    string $value = "",
    int $expires = 0,
    string $path = "",
    string $domain = "",
    bool $secure = false,
    bool $httponly = false ): bool {
    ....
}

setcookie(name: 'cool', value: 'PHP', secure: true);
```

In the example, the native function setcookie in which we can skip many optional parameters and pass an argument directly to the parameter we need to assign.

## Constructor property promotion

Personally I can say that I like this new feature making mixed use of its syntax.

```php
<?php

class File
{
    private string $disk;

    public function __construct(
        private string $path,
    ) {
        $this->disk = config('storage.default');
    }
}
```

The **$path** variable is defined and assigned in the constructor, while **$disk** is only assigned.

## The Match expression

The evolution of the **switch/case** is indeed **match**, in conjunction with enums, this feature is simply powerful:

```php
<?php

$age = 18;

$message = match (true) {
    $age < 18 => 'Teenager',
    $age >= 18 && $age < 35 => 'Young',
    default => 'Adult',
};

echo $message . PHP_EOL;
```

## Enumerations

Enums can have methods, types, implement contracts, use traits, constants, and more.

```php
<?php

enum Status
{
    case APPROVED;
    case PENDING;
    case REJECTED;
    case FAILED;
}

class Payment
{
    public function isApproved(Status $status): bool
    {
        return $status === Status::APPROVED;
    }
}

$status = Status::APPROVED;

echo $status->name . PHP_EOL; // APPROVED
```

If we use class constants, the **isApproved** function would receive a string and technically could receive any value as a string, with enumerations we achieve a greater degree of control in the definition of parameters. Another type of enumerations are those that have cases with values, and are called **backed enumerations**, these support the **int** and string **types**:

```php
<?php

enum Status: string
{
    case APPROVED = 'A';
    case PENDING = 'P';
    case REJECTED = 'R';
    case FAILED = 'F';

    public function trans(): string
    {
        return match($this) {
            self::APPROVED => trans('payments.status.approved'),
            self::PENDING => trans('payments.status.pending'),
            self::REJECTED => trans('payments.status.rejected'),
            self::FAILED => trans('payments.status.failed'),
        };
    }    

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}

$status = Status::APPROVED;

echo $status->name . PHP_EOL; // APPROVED
echo $status->value . PHP_EOL; // A
```

A couple of methods have been added to demonstrate the power of enums. It is also possible to initialize them from values:

```php
<?php

// Will throw an error if it is NOT a valid value
$status = Status::from('A');

// A null value will be assigned if it is NOT a valid value
$status = Status::tryFrom('X') ?? Status::APPROVED;
```

## Read-only classes and properties

When we want to initialize properties only the first time, we could declare them read-only, they can be specific properties or set all properties to be read-only, this is known as a read-only class.

```php
<?php 

class QueryBuilder
{
    protected array $clauses;

    public function __construct(
        protected readonly string $table
    ) {
        $this->clasuses = [];  
    }
}
```

A **DTO** is an excellent example for a read-only class:

```php
<?php 

readonly class UserData
{
    public function __construct(
        protected string $name,
        protected string $email
    ) {
        // ..
    }
}
```

I invite you to write high-performance and scalable applications with modern PHP, and don't forget that sharing makes us grow.