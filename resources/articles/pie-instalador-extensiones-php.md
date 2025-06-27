---
title: 'Pie, el instalador de extensiones de PHP'
excerpt: 'Aprende Pie, el nuevo instalador de extensiones de PHP, interoperable con Composer y Packagist, podrás instalar extensiones desde los requerimientos de tu proyecto con un comando fácilmente.'
publishedAt: '2025-06-26'
updatedAt: null
locale: 'es'
image: 'images/articles/pie-instalador-extensiones.webp'
tags:
- php
- composer
- pie
---

La pregunta que surge de forma inmediata es qué es `Pie`. Para responder a ello, la documentación oficial cita:

> PIE es un nuevo instalador de extensiones PHP, diseñado para reemplazar a PECL. Se distribuye como un PHAR, al igual que Composer, y funciona de forma similar a Composer, pero instala extensiones PHP (módulos PHP o extensiones Zend) en su instalación PHP, en lugar de extraer paquetes PHP a su proyecto o biblioteca.

`Pie` será la forma oficial para instalar extensiones en el futuro cercano. A continuación, un tutorial y una guía para que disfrutes de las ventajas de esta nueva herramienta.

<lite-youtube videoid="xCPp-VgmcR8" disablenoscript></lite-youtube>

## Entorno de pruebas

Para las pruebas con `Pie` usé una imagen muy sencilla de Docker con Ubuntu en su versión más reciente.

```shell
FROM ubuntu:latest

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    && apt-get clean

CMD ["/bin/bash"]
```

Puedes hacer esto mismo directamente en tu máquina, es decir, sin Docker. Los comandos para construir y ejecutar la imagen son:

```shell
docker build -t ubuntu-latest .

docker run -it ubuntu-latest
```

## Requerimientos

Si eres usuario de `Debian/Ubuntu`, ejecuta el siguiente comando para instalar todo lo necesario para construir e instalar extensiones:

```shell
sudo apt install php php-dev php-mbstring make gcc unzip git wget curl autoconf automake libtool m4
```

Para `macOS`:

```shell
brew install git autoconf automake libtool m4 make gcc
```

Algunas extensiones pueden requerir `cmake`. Adicionalmente, si deseas verificar si todo está preparado, entonces ejecuta los siguientes comandos:

```shell
which phpize
which php-config
```

Para ver la ruta hacia el archivo de configuración de PHP:

```shell
php -i | grep php.ini
```

Nota que en el tutorial los comandos se ejecutan como superusuario, razón por la cual no hago uso de `sudo`, pero en otro contexto sí será necesario.

## Instalar Pie

El procedimiento consiste en descargar el archivo `PHAR` de `Pie`, darle permisos de ejecución y moverlo al directorio de binarios:

```shell
wget https://github.com/php/pie/releases/latest/download/pie.phar
chmod +x pie.phar
mv pie.phar /usr/local/bin/pie
```

## Comandos básicos de Pie

- **pie install**: Para instalar extensiones.
- **pie uninstall**: Para eliminar extensiones previamente instaladas con `Pie`.
- **pie info vendor/extension**: Muestra la información relevante de una extensión, como la versión más reciente, el recurso desde donde será descargada y las opciones de configuración.
- **pie show**: Muestra el listado de extensiones de PHP instaladas con `Pie`.

A continuación te muestro la sencilla forma de instalar extensiones:

```shell
pie install xdebug/xdebug
pie install swoole/swoole
```

El listado de extensiones de PHP instaladas y activas lo puedes ver con:

```shell
php -m
```

## Pie con Composer

Cuando ejecutas `pie install` en un proyecto de `Composer`, `Pie` verificará los archivos `composer.json` y `composer.lock` para analizar los requerimientos del proyecto en `require`, e instalará las extensiones que no estén disponibles en el sistema operativo. `Composer` puede instalarse con el siguiente comando:

```shell
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

Usaré [Phenix](https://phenix.omarbarbosa.com/), un framework que estoy construyendo y que está basado en [Amphp](https://amphp.org/), para probar la interoperabilidad de `Pie` con `Composer`:

```shell
composer create-project phenixphp/phenix
cd phenix
composer install
```

Modifica el archivo `composer.json` y agrega la extensión a instalar:

```json
{
    "require": {
        ...
        "ext-brotli": "0.18.0",
        ...
    }
}
```

Ahora solo restará ejecutar `pie install` en la raíz del proyecto para instalar `brotli`. Y eso es todo.

## Recursos

Si te ha gustado `Pie`, te dejo los enlaces para explorarlo a profundidad:

- [Pie](https://github.com/php/pie)
- [Documentación sobre el uso](https://github.com/php/pie/blob/main/docs/usage.md)
- [Extensiones disponibles en Packagist](https://packagist.org/extensions)

No olvides compartir.
