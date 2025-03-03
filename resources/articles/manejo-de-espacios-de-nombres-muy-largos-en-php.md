---
title: 'Manejo de espacios de nombres muy largos en PHP'
excerpt: 'Aprende como importar multiples clases del mismo espacio de nombres o namespace, y a manejar espacios de nombres muy largos en PHP.'
publishedAt: '2021-06-22'
updatedAt: null
locale: 'es'
image: 'images/articles/long-php-namespaces.webp'
tags:
- php
- namespace
---
Los espacios de nombres (namespace) abrieron diversas posibilidades en PHP, entre muchas cosas, solucionaron las colisiones de nombre, es decir, clases y funciones con el mismo nombre; según la [documentación oficial](https://www.php.net/manual/es/language.namespaces.php) se definen como:

> La manera de encapsular elementos. Se pueden ver como un concepto abstracto en muchos aspectos. Por ejemplo, en cualquier sistema operativo, los directorios sirven para agrupar ficheros relacionados, actuando así como espacios de nombres para los ficheros que contienen. 

Así los espacios de nombre nos permiten agregar una excelente organización en los archivos de nuestras aplicaciones y facilita la importación de los mismos, pero como todas las cosas en la vida, hay situaciones que a veces nos complican un poco la labor.

Así que en función del objectivo del artículo, imaginemos que tenemos un espacio de nombre demasiado extenso, pero en realidad extenso, en el que tienes una parte del nombre de espacio común pero luego es variado por versión, tipo y categoría, y finalmente, se haya la clase, cuyo nombre es el mismo en todos los casos; el problema está en que al tratar de importar o usar las clases, éstas exceden la cantidad de caracteres permitidos en una sóla línea, claro está, dentro de las buenas prácticas que normalmente está entre 80 y 120 caracteres. Ejemplo:

```php
<?php

use Long\Very\Long\Application\Common\Namespaces\MyVersion\MyType\MyCategory\ClassName;
```

Supongamos que tenemos la siguiente distribución:

1.  Versiones: Estándar (Standard), empresarial (Enterprise).
2.  Tipos: Imágen (Image), documento (Document).
3.  Categorías: Baja calidad (LowQuality), alta calidad (HighQuality).

Esto nos puede generar múltiples combinaciones del espacio de nombres.

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
Ahora tenemos otro problema, al tratar de importar se produce una colisión debido a que las clases tienen el mismo nombre. Así que vamos a conocer la primera solución:

## Importar usando un alias

PHP nos permite importar varias clases del mismo espacio de nombres:

```php
<?php

use Long\Very\Long\Application\Common\Namespaces\{
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

El inconveniente es que si hubiese más combinaciones los alias de las clases serían un caos y es que al final no es muy elegante a nivel de estética. Veamos una solución más eficiente.

<article-ad></article-ad>

## Asignar un alias a parte del espacio de nombres

PHP nos permite asignar un alias a una parte del espacio de nombres y usar esa parte para importar la cantidad de clases que deseemos:

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

De esta manera se evita el uso de un alias por cada clase y las posibles colisiones, pues podemos usar un espacio de nombres completo a partir un nombre de espacios base. Si deseas ampliar tus conocimientos sobre los espacios de nombres, PHP dedica una completa sección al respecto, accede [aquí](https://www.php.net/manual/es/language.namespaces.php). Otra opción muy similar es simplemente usar el nombre de espacio común y a partir de su última sección, hacer el llamado correspondiente:

```php
<?php

use Long\Very\Long\Application\Common\Namespaces;

return [
    Namespaces\Standard\Image\LowQuality\ClassName::class,
    Namespaces\Standard\Image\HighQuality\ClassName::class,
    Namespaces\Enterprise\Image\LowQuality\ClassName::class,
    Namespaces\Enterprise\Image\HighQuality\ClassName::class,
    Namespaces\Standard\Document\LowQuality\ClassName::class,
    ﻿Namespaces\Standard\Document\HighQuality\ClassName::class,
    Namespaces\Enterprise\Document\LowQuality\ClassName::class,
    Namespaces\Enterprise\Document\HighQuality\ClassName::class
];
```

Podemos ver que se extiende un poco el largo del de espacio de nombres pero es totalmente aceptable. Recuerda que compartir nos hace crecer, razón por la cual escribo estos artículos. Muchas gracias.

La imagen de este artículo fue tomada de [freepik.com](https://www.freepik.com/free-photos-vectors/folder).