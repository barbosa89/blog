---
title: 'Handle long namespaces in PHP'
excerpt: 'Learn how to import multiple classes from the same namespace, and how to handle very long namespaces in PHP. '
publishedAt: '2021-06-22'
updatedAt: null
locale: 'en'
image: 'images/articles/long-php-namespaces.webp'
tags:
- php
- namespace
---

The namespaces gave PHP new possibilities, among many things, namespaces fixed the name collisions, classes and functions with the same name; according to [official documentation](https://www.php.net/manual/es/language.namespaces.php) they are defined as:

> The way to encapsulate elements. They can be seen as an abstract concept in many respects. For example, in any operating system, directories are used to group related files, thus acting as namespaces for the files they contain.

Thus, namespaces allow us to add an excellent organization to the our application files and facilitate their importation, but like all things in life, there are situations that sometimes complicate our work a bit.

Let's imagine that we have a too long namespace, but really long, in which you have a part of the common namespace but then it is varied by version, type and category, and finally the class, whose name is the same in all cases; the problem is when we trying to import or use the classes, they exceed the amount of characters allowed in a single line, of course, within good practices that is normally between 80 and 120 characters. Example:

```php
<?php

use Long\Very\Long\Application\Common\Namespaces\MyVersion\MyType\MyCategory\ClassName;
```

Suppose we have the following classification:

1.  Versions: Standard, enterprise.
2.  Types: Image, document.
3.  Categories: Low quality (LowQuality), high quality (HighQuality).

From the above, multiple namespace combinations emerge.

```php
<?php

use Long\Very\Long\Application\Common\Namespaces\Standard\Image\LowQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Standard\Image\HighQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Enterprise\Image\LowQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Enterprise\Image\HighQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Standard\Document\LowQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Standard\Document\HighQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Enterprise\Document\LowQuality\ClassName;
use Long\Very\Long\Application\Common\Namespaces\Enterprise\Document\HighQuality\ClassName;
```

The problem is that trying to import a collision occurs because the classes have the same name. So let's get to know the first solution.

## Import using an alias

PHP allows us to import several classes from the same namespace:

```php
<?php
use Long\Very\Long\Application\Common\Namespaces{
    Standard\Image\LowQuality\ClassName as SdtImageLow,
    Standard\Image\HighQuality\ClassName as SdtImageHigh,
    Enterprise\Image\LowQuality\ClassName as EnterpriseImageLow,
    Enterprise\Image\HighQuality\ClassName as EnterpriseImageHigh,
    Standard\Document\LowQuality\ClassName as SdtDocumentLow,
    Standard\Document\HighQuality\ClassName as SdtDocumentHigh,
    Enterprise\Document\LowQuality\ClassName as EnterpriseDocumentLow,
    Enterprise\Document\HighQuality\ClassName as EnterpriseDocumentHigh
};
```

The issue for this case is that if there were more combinations, the class aliases would be chaos and in the end it is not very elegant in terms of aesthetics. Let's look at a more efficient solution.

## Assign an alias to part of the namespace

PHP allows us to assign an alias to a part of the namespace and use that part to import as many classes as we want:

```php
<?php

use Long\Very\Long\Application\Common\Namespaces as Base;

return [
    Base\Standard\Image\LowQuality\ClassName::class,
    Base\Standard\Image\HighQuality\ClassName::class,
    Base\Enterprise\Image\LowQuality\ClassName::class,
    Base\Enterprise\Image\HighQuality\ClassName::class,
    Base\Standard\Document\LowQuality\ClassName::class,
    ﻿Base\Standard\Document\HighQuality\ClassName::class,
    Base\Enterprise\Document\LowQuality\ClassName::class,
    Base\Enterprise\Document\HighQuality\ClassName::class
];
```

In this way, the use of an alias for each class and possible collisions are avoided, since we can use a complete namespace starting from a base namespaces. If you want to expand your knowledge about namespaces, PHP dedicates a complete section to this, access [here](https://www.php.net/manual/es/language.namespaces.php).

Remember that sharing makes us grow, which is why I write these articles. Thank you.

The image for this article was taken from [freepik.com](https://www.freepik.com/free-photos-vectors/folder).