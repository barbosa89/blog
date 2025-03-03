---
title: 'Generadores en PHP'
excerpt: 'Aprende sobre generadores en PHP, una forma fácil de implementar iteradores con manejo optimizado de memoria, alto rendimiento y código asíncrono nativo.'
publishedAt: '2021-07-13'
updatedAt: null
locale: 'es'
image: 'images/articles/php-generators.webp'
tags:
- php
- generators
- async
---
Cuando conocí los generadores y tuve un acercamiento inicial, mi cabeza estalló en mil pedazos al ver los ejemplos de código, no entendí nada, era algo totalmente novedoso, así que inmediantamente me pregunté: ¿y con el **foreach** cómo se usará?, ¿y el valor de retorno?, ¿la palabra reservada **yield** que hace?

Luego de analizar con detenimiento y leer la documentación con plena calma, comprendí lo poderosos que son los generadores. Vamos por partes, dijo Jack, y lo primero por hacer es definir qué es un generador.

## Definiciones

**Generador**: Según la documentación oficial de PHP:

> Los generadores proporcionan un modo fácil de implementar [iteradores](https://www.php.net/manual/es/language.oop5.iterations.php) simples sin la sobrecarga o complejidad de implementar la interfaz [Iterator](https://www.php.net/manual/es/class.iterator.php).

**Iterador**: PHP permite que las propiedades de una clase puedan ser [recorridas](https://www.php.net/manual/es/language.oop5.iterations.php) como si se tratara de un diccionario, matriz de datos desordenada con índice de cadena de texto y su respectivo valor, las propiedades públicas se pueden acceder fuera del objeto, y las privadas y protegidas al interior del objeto; más información en el apartado de [iteración de objetos](https://www.php.net/manual/es/language.oop5.iterations.php). Adicionalmente, proporciona una interfaz llamada [Iterator](https://www.php.net/manual/es/class.iterator.php) que extiende de otra interfaz llamada [Traversable](https://www.php.net/manual/es/class.traversable.php), las cuales permiten dar un comportamiento de matriz a una clase; por lo cual, cualquier clase que implemente la interfaz **Iterator**, puede ser recorrida con el constructor **foreach** y con los métodos que cuyo contrato obliga a implementar. Para concluir, cualquier clase que implemente la interfaz **Iterator** o las clases predefinidas en la Librería Estándar de PHP ([SPL](https://www.php.net/manual/es/book.spl.php)), son conocidos como [Iteradores](https://www.php.net/manual/es/spl.iterators.php). Ejemplo de un iterador de una lista:

```php
<?php

namespace App\Iterators;

use Iterator;

class IteratorClass implements Iterator {
    private int $index = 0;
    private array $data = [];

    public function __construct(array $array)
    {
        $this->data = $array;
    }

   public function rewind(): void {
       $this->index = 0;
   }

   public function current() {
       return $this->data[$this->index];
   }

   public function key(): int {
       return $this->index;
   }

    public function next(): void {
        $this->index++;
    }

    public function valid(): bool {
        return $this->index < count($this->data);
    }
}
```

En síntesis, podemos afirmar que un **Iterador** es un mecanismo para recorrer una lista de datos contenidos en un objeto.

Podemos ejecutar un iterador usando el bucle **while** y el constructor **foreach**:

```php
<?php

$iterator = new IteratorClass([1, 2, 3]);

echo 'while' . PHP_EOL;

while ($iterator->valid()) {
    echo 'index ' . $iterator->key() . ' value ' . $iterator->current() . PHP_EOL;

    $iterator->next();
}

echo 'foreach' . PHP_EOL;

foreach ($iterator as $key => $value) {
    echo 'index ' . $key . ' value ' . $value . PHP_EOL;
}
```
La salida sería algo como esto:

```
while
index 0 value 1
index 1 value 2
index 2 value 3
foreach﻿
index 0 value 1
index 1 value 2
index 2 value 3
```

Así que un Generador es básicamente un Iterador pero con súper poderes, pues provee de mecanismos adicionales que veremos a continuación.

<article-ad></article-ad>

## Caraterísticas

**Los generadores suspenden la ejecución del código**: En una función común se usa la palabra reservada **return** para devolver un valor o **echo** para mostrar una cadena de texto, mientras que un generador, el cual se crea a partir de una función generadora, utiliza la palabra reservada **yield**. Con el uso de **return**, el control del programa es devuelto al ámbito que lo invocó; **echo** por su parte sólo muestra la cadena de texto, mientras que **yield** suspende el flujo de ejecución al interior de la función generadora, pues esta ha devuelto un objeto generador que internamente actúa como un iterador, y espera a que se invoquen los métodos correspondientes o que se recorra usando el constructor **foreach**. Veamos ejemplos:

### Una función que usa **return**

```php
<?php

function generateNumbers() {
    foreach (range(1, 10) as $value) {
        return $value;
    }
}

function showNumbers() {
    echo "Hi, PHP devs" . PHP_EOL;

    echo generateNumbers() . PHP_EOL;

    echo "Goodbye, binary people" . PHP_EOL;
}

showNumbers();
```

La función **generateNumbers**() es invocada dentro **showNumbers**(), así que **showNumbers**() es el ámbito padre de **generateNumbers**(), así que al invocar a **showNumbers**(), primero se mostrará el saludo, luego el número 1 pues devuelve el control de ejecución en la primera iteración y finalmente se muestra el mensaje de despedida, los números del 2 al 9 jamás serán mostrados.

```
Hi, PHP devs
1
Goodbye, binary people
```

### Función que usa **echo**

```php
<?php

function generateNumbers() {
    foreach (range(1, 10) as $value) {
        echo $value . PHP_EOL;
    }
}

function showNumbers() {
    echo "Hi, PHP devs" . PHP_EOL;

    generateNumbers();

    echo "Goodbye, binary people" . PHP_EOL;
}

showNumbers();
```

Básicamente, es el mismo código con la diferencia que en esta oportunida sí se observarán los 10 números generados.

```
Hi, PHP devs
1
2
3
4
5
6
7
8
9
10
Goodbye, binary people
```

### Función generadora que usa yield

En el ejemplo a continuación, podremos ver la sintaxis de un generador, en este caso, este se obtiene a partir de la función **generateNumbers**(), función generadora, que en su interior usa la palabra reservada **yield**, PHP detecta el uso de **yield** y retorna un generador, el que como lo mencionábamos anteriormente, es un iterador.

```php
<?php

function generateNumbers() {
    foreach (range(1, 10) as $value) {
        yield $value;
    }
}

function showNumbers() {
    echo "Hi, PHP devs" . PHP_EOL;

    $generator = generateNumbers();

    echo $generator->current() . PHP_EOL;

    echo "Goodbye, binary people" . PHP_EOL;
}

showNumbers();
```

Veamos la salida:

```
Hi, PHP devs
1
Goodbye, binary people
```

Este resultado aparentemente es igual a la función que usa **return,** sin embargo, si intentas imprimir la variable **$generator** evidenciarás que es un objeto de tipo Generator:

```php
object(Generator)#1 (0) {
}
```

Aunque sólo veamos el saludo, el número 1 y la despedida, el generador devuelto tiene ahora el control del flujo de ejecución interno de la función, por lo que puede suspender y manejar el acceso a los datos usando el iterador; finalmente se muestra el mensaje de despedida. Si solicitamos el siguiente elemento del generador, entonces veremos el número 2:

<article-ad></article-ad>

```php
<?php

function showNumbers() {
    echo "Hi, PHP devs" . PHP_EOL;

    $generator = generateNumbers();

    echo $generator->current() . PHP_EOL;

    $generator->next();

    echo "Goodbye, binary people" . PHP_EOL;

    $generator->current() . PHP_EOL;
}
```

Al invocar al método **next**() se reanuda la ejecución del iterador, dando como resultado la siguiente salida:

```
Hi, PHP devs
1
Goodbye, binary people
2
```

Con el comportamiento anterior podemos comprobar cómo es posible suspender y reanudar la ejecución del generador dada la naturaleza del iterador. Para ver todos los números podemos usar el bucle while:

```php
<?php

function showNumbers() {
    echo "Hi, PHP devs" . PHP_EOL;

    $generator = generateNumbers();

    while ($generator->valid()) {
        echo $generator->current() . PHP_EOL;

        $generator->next();
    }

    echo "Goodbye, binary people" . PHP_EOL;
}
```

También podemos usar **yield** múltiples veces dentro de una función:

```php
<?php

function greetings(){
    yield "Hi, PHP devs";
    yield "Goodbye, binary people";
}

$greetings = greetings();

echo $greetings->current() . PHP_EOL;

$greetings->next();

echo $greetings->current() . PHP_EOL;
```

La salida sería:

```
Hi, PHP devs
Goodbye, binary people
```

Esa misma salida se puede obtener usando el constructor **foreach**:

```php
<?php

foreach (greetings() as $message) {
    echo $message . PHP_EOL;
}
```

**Es posible enviar valores al generador**: Adicional a los métodos de la interfaz **Iterator**, los generadores poseen los métodos **send**() y **throw**(). Ejemplo:

```php
<?php

function printer() {
    while (true) {
        echo yield . PHP_EOL;
    }
}

$printer = printer();

$printer->send('Hello world');
$printer->send('PHP');
$printer->send('Generators');
$printer->send('Powerful');
```

Al ejecutar, la salida es:

```
Hello world
PHP
Generators
Powerful
```

Para lanzar una excepción podemos hacer uso del método **throw**().

```php
<?php

function printer() {
    try {
        while (true) {
            echo yield . PHP_EOL;
        }
    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage() . PHP_EOL;
    }
}

$printer = printer();
$printer->throw(new InvalidArgumentException('Wrong argument'));
```

## Uso de yield

Como vimos anteriormente, **yield** no sólo es usada para construir el generador, su sintáxis también permite:

* Asignación de valores como una expresión.
* Generar valores nulos.
* Construir generadores desde listas existentes usando **yield from**.

Si tienes datos guardados en caché podríamos usar **yield from** para recorrer los datos sin cargar la memoría y con excelente rendimiento, o simplemente usar el resultado de una consulta a la base de datos que devuelva una lista de datos, ejemplo:

```php
<?php

function generateNumbers() {
    yield from range(1, 10);
}

foreach (generateNumbers() as $number) {
    echo $number . PHP_EOL;
}
```

El uso extendido de la palabra reservada **yield** se encuentra en el siguiente [enlace](https://www.php.net/manual/es/language.generators.syntax.php).

<article-ad></article-ad>

## Beneficios de los generadores

* Multitarea cooperativa usando corrutinas, esto se traduce en código asíncrono en PHP nativo.
* Uso optimizado de memoria.
* Alto rendimiento para manejo de grandes volúmenes de datos.
* Facilita la implementación de iteradores.

## Caso teórico del uso de generadores

Nikita Popov, miembro del equipo de desarrollo de PHP, expuso un [completo artículo sobre el uso de generadores](https://www.npopov.com/2012/12/22/Cooperative-multitasking-using-coroutines-in-PHP.html), en los ejemplos de código podemos apreciar su uso avanzado en procesamiento multitarea y para crear servidores web escritos completamente en PHP. Siguiendo la teoría expuesta en dicho artículo, surgieron proyectos como [ReactPHP](https://reactphp.org/) y [Amp](https://amphp.org/). Veamos un ejemplo de multitarea:

```php
<?php

class Task {
    private bool $running = false;
    protected Generator $generator;

    public function __construct(Closure $closure) {
        $this->generator = $closure();
    }

    public function run(): void
    {
        if ($this->running) {
            $this->generator->next();
        } else {
            $this->running = true;

            $this->generator->current();
        }
    }

    public function finished(): bool {
        return !$this->generator->valid();
    }
}

class Scheduler {
    protected SplQueue $queue;

    public function __construct() {
        $this->queue = new SplQueue();
    }

    public function enqueue(Task $task): void {
        $this->queue->enqueue($task);
    }

    public function run() {
        while (!$this->queue->isEmpty()) {
            $task = $this->queue->dequeue();
            $task->run();

            if (!$task->finished()) {
                $this->enqueue($task);
            }
        }
    }
}

$firstTask = new Task(function () {
    for ($i = 1; $i <= 10; ++$i) {
        echo "Task 1 iteration {$i}" . PHP_EOL;
        yield;
    }
});

$secondTask = new Task(function () {
    for ($i = 1; $i <= 5; ++$i) {
        echo "Task 2 iteration {$i}" . PHP_EOL;
        yield;
    }
});

$scheduler = new Scheduler;
$scheduler->enqueue($firstTask);
$scheduler->enqueue($secondTask);
$scheduler->run();
```

Al ejecutar el código anterior, se puede observar cómo cada tarea pausa su ejecución y espera al siguiente llamado, mientras se intercalan sus pocisiones en la cola; eso quiere decir que, la tarea 1 mostrará una salida, esta vuelve a la cola detrás de la tarea 2, ahora la tarea 2 está en la primera posición y muestra su salida, también vuelve a la cola, en la siguiente iteración se vuelve a mostrar la salida de la tarea 1 y continua la 2, y sucesivamente hasta terminar la iteración de bucle **for** al interior de cada función generadora.

```
Task 1 iteration 1
Task 2 iteration 1
Task 1 iteration 2
Task 2 iteration 2
Task 1 iteration 3
Task 2 iteration 3
Task 1 iteration 4
Task 2 iteration 4
Task 1 iteration 5
Task 2 iteration 5
Task 1 iteration 6
Task 1 iteration 7
Task 1 iteration 8
Task 1 iteration 9
Task 1 iteration 10
```

## Caso práctico del uso de generadores

Imagina que requieres cargar en la base de datos de tu aplicación la información contenida en un enorme archivo CSV, pero el proceso tarda demasiado y el servidor arroja errores de **timeout** por lo lento de la tarea, adicional existe un alto consumo de memoria; el problema se debe al intentar leer el archivo completo y tratar de recorrer cada fila para realizar el procesamiento, así que el rendimiento y el consumo de memoria serán el talón de aquiles, por fortuna, los generadores solucionan esto de forma simple.

```php
<?php

class CsvReader {
    protected $file;

    public function __construct($filePath) {
        $this->file = fopen($filePath, 'r');
    }

    public function rows(): Generator {
        while (!feof($this->file)) {
            yield fgetcsv($this->file, 4096);
        }
    }
}

// File content
// PHP,1995,Rasmus Lerdorf
// JavaScript,1995,NetScape and Mozilla
// Python,1991,Guido van Rossum
$csv = new CsvReader('/path/to/file.csv');

foreach ($csv->rows() as $row) {
    echo "Language {$row[0]} created at {$row[1]} by {$row[2]}" . PHP_EOL;
}
```

La salida hipotética es:

```
Language PHP created at 1995 by Rasmus Lerdorf
Language JavaScript created at 1995 by NetScape and Mozilla
Language Python created at 1991 by Guido van Rossum
```

Laravel también incluyó soporte para generadores en sus colecciones con el nombre de [Lazy Collections](https://laravel.com/docs/8.x/collections#lazy-collections), las cuales podemos usar en consultas de base de datos:

```php
use App\Models\User;

$users = User::whereNotNull('email_verified_at')->cursor();

foreach ($users as $user) {
   echo $user->email;
}
```

La lectura de archivos naturalmente hace parte de las características:

```php
use Illuminate\Support\LazyCollection;

LazyCollection::make(function () {
    $handle = fopen('log.txt', 'r');

    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
});
```

## Nota final

PHP 8 ha incorporado en su núcleo una característica muy poderosa que incrementa la posibilidad de escribir código asíncrono nativo, esta se conoce como [fibras](https://wiki.php.net/rfc/fibers), todas estas mejoras apuntan a incrementar el rendimiento y a cambiar la forma tradicional de ejecución de las aplicaciones de PHP; ahora es posible pensar en ciencia de datos y procesos de uso intensivo de CPU con el motor JIT. Hago esta mención porque en verdad necesitamos conocer las bondades de las características que PHP posee, en esta oportunidad, los generadores, que infortunadamente no hemos aprovechado en su totalidad. Te invito a experimentar, a desafiar lo tradicional y crear cosas mágicas. Recuerda que compartir nos hace crecer, espero hayas aprendido algo y también lo compartas. Gracias.

Imagen del artículo tomada de [freepik.com](https://www.freepik.com/vectors/human).