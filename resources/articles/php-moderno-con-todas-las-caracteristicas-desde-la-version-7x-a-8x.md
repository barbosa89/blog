---
title: 'PHP moderno con todas las características desde la versión 7x a 8x'
excerpt: 'PHP es un lenguaje moderno, rápido y poderoso, conoce sus nuevas características y escribe aplicaciones escalables en potentes frameworks como Laravel y Symfony.'
publishedAt: '2023-06-19'
updatedAt: null
locale: 'es'
image: 'images/articles/php-new-features.webp'
tags:
- php
---
PHP es el lenguaje más usado para desarrollo de páginas, aplicaciones y servicios web, aunque también puedes usarlo para aplicaciones de escritorio, IoT, inteligencia artificial y más, durante un largo tiempo este lenguaje fue muy popular, pero entre los años 2009 y 2012, pasó de ser muy popular a ser muy criticado; en el año 2011, Taylor Otwell lanzó la primera versión del framework Laravel, evento que representó un nuevo nacimiento para PHP, resucitó de las cenizas como el Fénix, la impresionante comunidad que surgió alrededor de Laravel y Symfony, le devolvió mucha fortaleza al lenguaje, actualmente PHP es un lenguaje moderno, muy potente y versátil, con curva de aprendizaje que permite rápida evolución, aspecto que también se proyecta en Laravel.

Entre las características más sobresalientes se encuentran el tipado de propiedades y métodos o funciones y valores de retorno con varianza y contra varianza, clases anónimas, criptografía de última generación, funciones flecha, desestructuración y fusión de matrices, operadores para el manejo de valores nulos, precarga, FFI, compilador JIT, atributos, argumentos con nombres, mejoras en constructores de clases, unión e intersección de tipos, la expresión match, enumeraciones, propiedades y clases de sólo lectura y mucho más.

Es este artículo se recopilan todas las características de PHP moderno con ejemplos de código para afianzar los conocimientos, desde la versión 7.0 hasta 8.3:

## Declaraciones de tipo

Al ser un lenguaje de tipado dinámico, PHP permite pasar cualquier tipo de parámetro en propiedades, métodos o funciones, a partir de la versión 7.0 se agregaron las declaraciones de tipo, las cuales se han mejorado tras cada lanzamiento.

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

Otros tipos: void, parent, callable, self, iterable, object, null, true, false, never, enumeraciones, clases e interfaces. Así se ve una clase escrita en PHP moderno. Más información de tipos [aquí](https://www.php.net/manual/es/language.types.declarations.php).

En el ejemplo anterior podemos ver **unión de tipos**, pero es posible aprovechar esta característica con objetos también:

```php
<?php

use App\Models\User;

class CreateUserAction
{
    public function execute(): User|false
    {
        // Código
    }
}
```

### Intersección de tipos

Consiste en la habilidad en la que un argumento debe cumplir con múltiples restricciones, por ejemplo, varios contratos:

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

¿Podemos combinar unión e intersección de tipos?, por supuesto, esto es denominado **Forma Normal Disyuntiva**.

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

Ahora tenemos la posibilidad de agregar restricciones y combinar con los tipos nativos de PHP.

<article-ad></article-ad>

## Manejo de nulos

Un problema común en todos los lenguajes es el manejo de nulos, PHP tiene uno de los mejores mecanismos para tal fin.

### Operador de fusión nulo

```php
<?php

$data = ['key' => 'value'];

echo $data['unknown'] ?? 'default' . PHP_EOL;
```

A pesar de que la clave de la matriz no existe se podrá acceder a un valor por defecto.

### Paso y retorno de nulos

Permite que una propiedad, método o función, pueda recibir o devolver un valor nulo.

```php
<?php

function greeting (?string $name): ?string {
    if (!$name) {
        return null;
    }

    return "Hola, {$name}";
}
```

Este código se puede reescribir usando unión de tipos:

```php
<?php

function greeting (string|null $name): string|null {
    if (!$name) {
        return null;
    }

    return "Hola, {$name}";
}
```

### Operador de asignación de fusión nula

Este potente operador nos salva cuando intentamos acceder a valores no asignados o nulos.

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

En este ejemplo, el valor es devuelto si existe, o se asigna y se devuelve, en todo caso, un valor será devuelto.

### Operador de acceso nulo seguro

Si has intentado usar un método que devuelve un objeto o un nulo, entonces entenderás la importancia de este potente operador, en Laravel tenemos la fachada Auth, con la cual podemos acceder al usuario autenticado:

```php
<?php

use Illuminate\Support\Facades\Auth;

$userName = Auth::user()?->name;
```

En caso de que no exista un usuario autenticado, a la variable se le asignará un valor nulo.

## Clases anónimas

Esta característica permite cambiar un comportamiento de una clase, un mock, por ejemplo; o simplemente definir una clase completa. Laravel aprovecha las clases anónimas para prevenir la colisión de nombres en las migraciones.

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

En PHP 8.3, las clases anónimas pueden ser de sólo lectura:

```php
<?php

$dateFormatter = new readonly class($date) {
    ...
};

echo $dateFormatter->format() . PHP_EOL;
```

## Excepciones muy excepcionales

PHP permite agregar múltiples bloques catch a un bloque try, o simplemente capturar múltiples excepciones en el mismo bloque catch.

```php
try {
    // Código
} catch (ErrorException $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
}

// Lo anterior se puede reescribir así

try {
    // Código
} catch (ErrorException | RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
}
```

Si la variable del bloque catch no será usada, simplemente puedes omitir su declaración.

```php
try {
    // Código
} catch (ErrorException | RuntimeException) {
    // Manejo controlado
}
```

## Matrices (Arrays)

### Desestructuración

Es el mecanismo para romper la estructura de una matriz y acceder a su contenido:

```php

$user = [
    'John Doe',
    'email@domain.com',
];

[$name, $email] = $user;

echo $name . PHP_EOL;
echo $email . PHP_EOL;

// Trabajando con matrices asociativas

$user = [
    'name' => 'John Doe',
    'email' => 'email@domain.com',
];

['name' => $name, 'email' => $email] = $user;

echo $name . PHP_EOL;
echo $email . PHP_EOL;

// Colecciones

$users = [
    ['John Doe', 'email@domain.com'],
    ...
];

foreach ($users as [$name, $email]) {
    echo $name . PHP_EOL;
    echo $email . PHP_EOL;
}
```

### Desempaquetado

PHP cuenta con las funciones **array_merge()** y **array_merge_recursive()** para fusión de matrices, pero ahora es mucho más sencillo y elegante:

```php

$web = ['php', 'javascript'];
$desktop = ['java', 'c#'];

$languages = [...$web, ...$desktop];
```

## Constantes de clases

Las constantes son claves a la hora de escribir código de calidad, en PHP podemos agregar visibilidad, y desde la versión 8.3, los siguientes tipos: string, array, int, float, bool.

```php

class File
{
    public const string DEFAULT_DISK = 'public';
    public const int BYTE_RATE = 1024;
}
```

El acceso dinámico es permitido del mismo modo en que funciona para propiedades y métodos:

```php
// Acceso de propiedad
echo $object->{$propertyName} . PHP_EOL;

// Acceso de método
echo $object->{$methodName}() . PHP_EOL;

$name = 'DEFAULT_DISK';

// Acceso de constante
echo File::{$name} . PHP_EOL;
```

## Funciones flecha

Muy famosas en JavaScript, y como una mejora a callables y Closure, PHP permite funciones flecha de una línea:

```php

$names = ['php', 'laravel'];

$data = array_map(fn ($name) => strtoupper($name), $names);
```

## Separador literal numérico

Intentar leer una cifra grande ya no es problema en PHP:

```php

echo 1_000_000 . PHP_EOL;
echo 6.674_083e-11 . PHP_EOL;
echo 0xCAFE_F00D . PHP_EOL;
```

## Argumentos con nombre

Unas de las mejores adiciones, sobre todo cuando tenemos parámetros nulos u opcionales:

```php

function setcookie(
    string $name,
    string $value = "",
    int $expires = 0,
    string $path = "",
    string $domain = "",
    bool $secure = false,
    bool $httponly = false
): bool {
    // ...
}

setcookie(name: 'cool', value: 'PHP', secure: true);
```

En el ejemplo, la función nativa **setcookie** en la que podemos omitir muchos parámetros opcionales y pasar un argumento directamente al parámetro que necesitamos asignar.

## Constructor de clases moderno

Personalmente puedo decir que me gusta esta nueva característica haciendo uso de mixto de su sintaxis.

```php

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

La variable **$path** es definida y asignada en el constructor, mientras que **$disk** sólo es asignada.

## La expresión Match

La evolución del **switch / case** es en verdad **match**, en conjunto con las enumeraciones, esta característica es sencillamente poderosa:

```php

$age = 18;

$message = match (true) {
    $age < 18 => 'Teenager',
    $age >= 18 && $age < 35 => 'Young',
    default => 'Adult',
};

echo $message . PHP_EOL;
```

## Enumeraciones

Las enumeraciones pueden tener métodos, tipos, implementar contratos, usar traits, constantes y más.

```php

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

Si usamos constantes de clases, la función **isApproved** recibiría un string y técnicamente podría recibir cualquier valor como string, con las enumeraciones alcanzamos un mayor grado de control en la definición de parámetros. Otro tipo de enumeraciones son las que tienen casos con valores, y son llamadas **backed enumerations**, estas soportan los tipos **int** y **string**:

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

Se han agregado un par de métodos para demostrar el poder de las enumeraciones. También es posible inicializarlas desde valores:

```php

// Arrojará un error si NO es un valor válido
$status = Status::from('A');

// Se asignará un valor nulo si NO es un valor válido
$status = Status::tryFrom('X') ?? Status::APPROVED;
```

## Clases y propiedades de sólo lectura

Cuando deseamos inicializar propiedades sólo la primera vez, podríamos declararlas de sólo lectura, pueden ser propiedades específicas o establecer que todas las propiedades son de lectura, es decir, una clase de sólo lectura.

```php
class QueryBuilder
{
    protected array $clauses;

    public function __construct(
        protected readonly string $table
    ) {
        $this->clauses = [];
    }
}
```

Un DTO es un excelente ejemplo para una clase de sólo lectura:

```php

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

No te quedes con las versiones de PHP 5 y anterior, te invito a escribir aplicaciones de alto rendimiento y escalabilidad con PHP moderno, y no olvides que compartir nos hace crecer.