---
title: 'Cómo crear tu primer paquete de Composer PHP'
excerpt: 'Aprende a crear y publicar tu primer paquete de Composer PHP con todo incluido PHPUnit, PHP CS Fixer, Github Actions y más'
publishedAt: '2025-06-16'
updatedAt: null
locale: 'es'
image: 'images/articles/create-composer-php-package.webp'
tags:
- php
- composer
---

Composer es el administrador de paquetes de PHP. Su función principal es facilitar la instalación y actualización de librerías que un proyecto necesita, manteniendo el control de versiones y dependencias en un solo archivo: `composer.json`. En lugar de descargar manualmente librerías desde distintas fuentes, Composer automatiza ese proceso, sólo basta con indicar el nombre del paquete y su versión para que la herramienta haga el resto.

<lite-youtube videoid="PT9z9bYk6eA" disablenoscript></lite-youtube>

Composer introdujo el concepto de dependencia, básicamente librería o paquete, que simplemente es una carpeta de código PHP estructurada de acuerdo a ciertos estándares (como PSR-4 para `autoloading`) y acompañada de un archivo `composer.json`. Este archivo describe el paquete: su nombre, versión, dependencias, autores, licencias, entre otros datos relevantes.

Los paquetes pueden ofrecer clases reutilizables, servicios, integraciones, middlewares, helpers, o cualquier otro fragmento de código PHP que se desee compartir o centralizar. Cuando quieres compartir el código que has desarrollado construir un paquete es la respuesta, ya que permite encapsular una funcionalidad que puede ser aprovechada en distintos proyectos.

Para publicar un paquete Composer dispone de [Packagist](https://packagist.org/), el repositorio oficial de paquetes, es el lugar donde se publican y descubren paquetes PHP. Cuando ejecutas `composer require`, Composer busca el paquete en Packagist por defecto.

Si no tienes Composer instalado, puedes ejecutar el siguiente comando:

```shell
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

Si eres usuario de Windows, puedes [descargar el instalador](https://getcomposer.org/doc/00-intro.md#installation-windows) desde la página oficial.
