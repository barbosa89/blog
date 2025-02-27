---
title: 'Tareas programadas de Laravel en hosting compartido'
excerpt: 'Configura las tareas programadas o task scheduling de Laravel en hosting compartido usando cPanel, cronJobs con el poder de PHP.'
publishedAt: '2020-10-26'
updatedAt: null
locale: 'es'
image: 'images/articles/task-scheduling.webp'
tags:
- php
- laravel
- cronjob
---

Las tareas programadas (Task scheduling) son una importante característica de toda aplicación web, Laravel provee de un poderoso entorno para programar tareas, muy flexible e intuitivo. Cuando desplegamos aplicaciones en servidores VPS o EC2 de AWS, el **Crontab** y **Supervisor** facilitan demasiado el proceso, el problema es cuando desplegamos Laravel en un hosting compartido o shared hosting. Este artículo representa un pequeño truco para correr las tareas programas en un entorno tan restringido.

## Antes de empezar

1.  La ruta **/usr/bin/php** representa la ubicación del binario de PHP y puede ser diferente en tu hosting. En algunos casos la ruta es **/usr/local/bin/php** .
2.  La ruta **/home/my_user/domains/my_app/artisan** es la ubicación de la aplicación de consola que nos provee Laravel y debes evidentemente cambiarla de acuerdo a tu configuración.
3.  Prepara un comando en el que puedas fácilmente verificar si funcionan las tareas programadas.


**La directiva register_argc_argv de PHP**
--------------------------------------------

La primera vez que intenté hacer funcionar las tareas programas en un hosting compartido fue decepcionante, no hallé la forma adecuada, pero en estos días que me enfrenté al mismo problema, tuve que navegar profundamente y encontré la configuración necesaria para que funcione perfectamente.

Inicialmente intenté de la siguiente forma:

```bash
* * * * * /usr/bin/php /home/my_user/my_app/artisan schedule:run >> /dev/null 2>&1
```

Pero algunos hosting restringen caracteres (>, &) y no aceptan esta configuración. El paso siguiente fue intentar con:

```bash
* * * * * /usr/bin/php /home/my_user/my_app/artisan schedule:run
```

Lo que ocurrió es que no sucedía nada, para el experimento programé un comando que escribía en el log un texto, debía aparecer cada minuto pero no.

Buscando en la red encontré que la directiva **register_argc_argv** le permite a PHP CLI recibir y leer parámetros. la documentación oficial dice:

> Establecer esta directiva a `TRUE` significa que los scripts ejecutados mediante la SAPICLI siempre tienen acceso a _argc_ (número de argumentos que se le pasan a la aplicación) y _argv_ (array con los argumentos en sí).

El truco consiste en activar dicha directiva al vuelo, para que **artisan** pueda tener acceso a los parámetros:

```bash
* * * * * /usr/bin/php -d register_argc_argv=On /home/my_user/my_app/artisan schedule:run
```

También podrías probar con la configuración completa por si es permitido:

```bash
* * * * * /usr/bin/php -d register_argc_argv=On /home/my_user/my_app/artisan schedule:run >> /dev/null 2>&1
```

De esta forma, tendremos todo solucionado y funcionando.

Artículo complementario: [https://laravelarticle.com/laravel-scheduler-on-cpanel-shared-hosting](https://laravelarticle.com/laravel-scheduler-on-cpanel-shared-hosting)

No olvides que compartir nos hace crecer, gracias.