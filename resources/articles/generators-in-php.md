---
title: 'Generators in PHP'
excerpt: 'Learn about generators in PHP and Laravel, an easy way to implement iterators with optimized memory usage, high performance and native asynchronous code. '
publishedAt: '2021-08-02'
updatedAt: null
locale: 'en'
image: 'images/articles/php-generators.webp'
tags:
- php
- generators
- async
---

When I got to know the generators and saw some code examples, my head exploded into a thousand pieces, I didn't understand anything, it was something totally new, so I immediately asked myself: the **foreach**, how will it be used? And the return value? , What does the **yield** keyword do?

After carefully analyzing and reading the documentation calmly, I understood how powerful generators are. Let's go in parts, said Jack, and the first thing to do is define what a generator is.

## Definitions

**Generator**: According to the official PHP documentation:

> Generators provide an easy way to implement simple iterators without the overhead or complexity of implementing the Iterator interface.

**Iterator**: PHP allows [class properties to be traversed](https://www.php.net/manual/en/language.oop5.iterations.php) as if it were a dictionary, unordered data array with text string index and its respective value, public properties can be accessed outside the object, and private and protected properties inside the object; more information in the object iteration section. Additionally, it provides an interface called [Iterator](https://www.php.net/manual/es/class.iterator.php) that extends from another interface called [Traversable](https://www.php.net/manual/es/class.traversable.php), which allow giving an array behavior to a class; Therefore, any class that implements the **Iterator** interface can be traversed with the **foreach** constructor and with the methods that the contract requires to implement. To conclude, any class that implements the **Iterator** interface or the predefined classes in the PHP Standard Library ([SPL](https://www.php.net/manual/es/book.spl.php)), are known as [Iterators](https://www.php.net/manual/es/spl.iterators.php). Example of an list iterator:

```php
<?php

namespace App\Iterators;

use Iterator;

class IteratorClass implements Iterator
{
    private int $index = 0;
    private array $data = [];

    public function __construct(array $array)
    {
        $this->data = $array;
    }
  
   public function rewind(): void
   {
       $this->index = 0;
   }
    
   public function current(): mixed
   {
       return $this->data[$this->index];
   }

   public function key(): int
   {
       return $this->index;
   }

    public function next(): void
    {
        $this->index++;
    }

    public function valid(): bool
    {
        return $this->index < count($this->data);
    }
}
```

In summary, we can say that an **Iterator** is a mechanism to iterate a list of data contained in an object.

We can execute an iterator using the **while** loop and the **foreach** constructor:

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

Code output:

```
while
index 0 value 1
index 1 value 2
index 2 value 3
foreach
index 0 value 1
index 1 value 2
index 2 value 3
```

So a Generator is basically an Iterator but with super powers, as it provides additional mechanisms that we will see below.

## Features

**Generators suspend code execution**: In a common function, the **return** keyword is used to return a value or **echo** to display a text string, while a generator, which is created from a generator function, uses the word reserved **yield**. With the use of **return**, the program control is returned to the scope that invoked it; **echo** only shows the text string, while **yield** suspends the flow of execution inside the generator function, since it has returned a generator object that internally acts as an iterator, and waits for the corresponding methods to be invoked or that is traversed using the **foreach** constructor. Let's see examples:

**A function that uses return**

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

The function **generateNumbers**() is invoked inside **showNumbers**(), so **showNumbers**() is the parent scope of **generateNumbers**(), so when invoking **showNumbers**(), the greeting will be shown first, then the number 1 as it returns the control of execution in the first iteration and finally the goodbye message is shown, the numbers from 2 to 9 will never be shown.

```
Hi, PHP devs
1
Goodbye, binary people
```

**Function using echo**

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

Basically, it is the same code with the difference that in this opportunity the 10 generated numbers will be observed.

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

**Generator function using yield**

In the example below, we can see the syntax of a generator, in this case, it is obtained from the **generateNumbers**() function, a generator function, which inside it uses the reserved word **yield**, PHP detects the use of **yield** and returns a generator, which, as we mentioned earlier, is an iterator.

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

Code output:

```
Hi, PHP devs
1
Goodbye, binary people
```

This result is apparently the same as the function that uses **return**, however, if you try to print the **$generator** variable you will see that it is an object of type Generator:

```php
object(Generator)#1 (0) {
}
```

Even though we only see the greeting, the number 1, and the goodbye, the returned generator now has control of the internal flow of execution of the function, so it can suspend and handle access to the data using the iterator; finally the goodbye message is displayed. If we request the following element from the generator, then we will see number 2:

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

Invoking the **next**() method resumes iterator execution, resulting in the following output:

```
Hi, PHP devs
1
Goodbye, binary people
2
```

With the previous behavior we can check how it is possible to suspend and resume the execution of the generator given the nature of the iterator. To see all the numbers we can use the while loop:

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

We can also use **yield** multiple times within a function:

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

Code output:

```
Hi, PHP devs
Goodbye, binary people
```

That same output can be obtained using the **foreach** constructor:

```php
<?php 

foreach (greetings() as $message) {
    echo $message . PHP_EOL;
}
```

**The generator allows us to send values**: In addition to the methods of the Iterator interface, the generators have the **send**() and **throw**() methods. Example:

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

Code output:

```
Hello world
PHP
Generators
Powerful
```

To throw an exception we can use the **throw**() method.

```php
<?php

use Throwable;

function printer() {
    try {
        while (true) {
            echo yield . PHP_EOL;
        }
    } catch (Throwable $th) {
        echo "Error: " . $th->getMessage() . PHP_EOL;
    }
}

$printer = printer();
$printer->throw(new InvalidArgumentException('Wrong argument'));
```

## Yield usage

As we saw earlier, **yield** is not only used to build the generator, its syntax also allows:

* Assignment of values as an expression.
* Generate null values.
* Build generators from existing lists using **yield from**.

If you have data stored in cache we could use yield from to iterate the data without overloading the memory, or simply use the result of a query to the database that returns a list of data, example:

```php
<?php

function generateNumbers() {
    yield from range(1, 10);
}

foreach (generateNumbers() as $number) {
    echo $number . PHP_EOL;
} 
```

The extended use of the **yield** keyword can be found at the following [link](https://www.php.net/manual/es/language.generators.syntax.php).

## Advantages of generators

* Cooperative multitasking using coroutines, asynchronous code in native PHP.
* Optimized memory usage.
* High performance for handling large volumes of data.
* Facilitates the implementation of iterators.

## Theoretical case of the use of generators

Nikita Popov, member of the PHP development team, presented a [complete article about generators usage](https://www.npopov.com/2012/12/22/Cooperative-multitasking-using-coroutines-in-PHP.html), in the code examples we can see their advanced use in multitasking processing and to create web servers written entirely in PHP. Following the theory outlined in said article, projects such as [ReactPHP](https://reactphp.org/) and [Amp](https://amphp.org/) emerged. Let's look at an example of multitasking:

```php
<?php

class Task
{
    private bool $running = false;
    protected Generator $generator;
 
    public function __construct(Closure $closure)
    {
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

    public function finished(): bool
    {
        return !$this->generator->valid();
    }
}

class Scheduler
{
    protected SplQueue $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function enqueue(Task $task): void
    {
        $this->queue->enqueue($task);
    }

    public function run(): void
    { 
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

When executing the previous code, we can observe how each task pauses its execution and waits for the next call, while its positions alternate in the queue; that means that task number 1 will show an output, it returns to the queue behind task 2, now task 2 is in the first position and shows its output, it also returns to the queue, in the next iteration it returns to show the output of task 1 and continue with task 2, the dynamics continues successively until the loop iteration is finished inside each generator function.

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

## Generator use case study

Imagine that you need to load the information contained in a huge CSV file into the your application database, but the process takes too long and the server throws timeout errors due to the slowness of the task, additionally there is a high memory usage; the issue is caused by trying to read the entire file and trying to iterate through each row to perform the processing, fortunately generators solve this simply.

```php
<?php

class CsvReader {
    protected $file;
 
    public function __construct($filePath)
    {
        $this->file = fopen($filePath, 'r');
    }
 
    public function rows(): Generator
    {
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

Code output:

```
Language PHP created at 1995 by Rasmus Lerdorf
Language JavaScript created at 1995 by NetScape and Mozilla
Language Python created at 1991 by Guido van Rossum
```

Laravel also includes support for generators in collections named [Lazy Collections](https://laravel.com/docs/8.x/collections#lazy-collections), which we can use in database queries:

```php
use App\Models\User;

$users = User::whereNotNull('email_verified_at')->cursor();

foreach ($users as $user) {
   echo $user->email;
}
```

File reading example:

```php
use Illuminate\Support\LazyCollection;

LazyCollection::make(function () {
    $handle = fopen('log.txt', 'r');

    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
});
```

## Final note

PHP 8 has incorporated into the core a very powerful feature that increases the ability to write native asynchronous code, this is known as [fibers](https://wiki.php.net/rfc/fibers), all these improvements aim to increase performance and change the traditional way of executing PHP applications; now it is possible to think about data science and CPU intensive processes with the JIT engine. I make this mention because we really need to know all the features that PHP has, this time the generators, which unfortunately we have not fully exploited. I invite you to experiment, to challenge the traditional and create magical things. Remember that sharing makes us grow, I hope you have learned something and share it too. Thanks.

Article image taken from [freepik.com](https://www.freepik.com/vectors/human).