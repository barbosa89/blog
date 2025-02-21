---
title: 'Creación de host virtual con Apache2 en Ubuntu'
excerpt: 'Aprende cómo crear un host virtual con el servidor web Apache2 en Ubuntu, y organiza tus proyectos de desarrollo de aplicaciones.'
publishedAt: '2020-06-08'
updatedAt: null
locale: 'es'
image: 'images/articles/virtual-hosts.jpeg'
tags:
- ubuntu
- apache
---

Los hosts virtuales nos ayudan a organizar el desarrollo de aplicaciones por nombres de dominios locales, dichos nombres no estarán disponibles en internet, es decir, sólo existen en nuestra maquina, esto debido a que el navegador primero consulta el archivo **hosts** del sistema operativo, y posteriormente, resuelve el dominio e IP en la gran red; así, es posible alojar diferentes sitios con su respectivo nombre de dominio y apuntando a una misma IP, en este caso, a localhost (127.0.0.1). Ejemplos de nombres comunes en desarrollo:

* myapp.local
* myapp.test
* myapp.localhost

Una vez elegido el estilo, puedes crear tus host virtuales y quedarían más o menos así:

* calculator.localhost
* portfolio.localhost
* landing.localhost

Este artículo se orienta a Debian y sus distribuciones derivadas, como Ubuntu, Mint, y demás. Se requiere que Apache en su versión 2, esté instalado en el sistema y el módulo rewrite esté habilitado. Si el módulo rewrite no está habilitado, pueden usar el siguiente comando:

```bash
sudo a2enmod rewrite
```
Luego, es requerido reiniciar el servidor web:

```bash
sudo service apache2 restart
```

## Paso a paso

Para la creación de host virtuales, se necesario hacerlo con permisos de usuario **root**, para ello, usaremos la consola:

```bash
sudo su
```

Posterior, cambiamos de directorio hacia la carpeta de hosts virtuales de apache:

```bash
cd /etc/apache2/sites-available/
ls -l
```

El contenido de la carpeta será algo como esto:

```
-rw-r--r-- 1 root root 1234 jul 16 2018 000-default.conf
```

Ahora, copiaremos el archivo por defecto y asignaremos el nombre que tendrá el host virtual:

```bash
cp 000-default.conf app.conf
```

Con el editor de texto de preferencia, modificaremos el contenido:

```bash
# Gedit editor
gedit app.conf
# Sublime editor
subl app.conf
# VS Code editor
code app.conf
# Nano editor
nano app.conf﻿﻿
```

Al finalizar la edición, el contenido debería ser muy similar a esto:

```
<VirtualHost *:80>
    ServerName app.localhost
    ServerAlias www.app.localhost

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/app/public

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory /var/www/app/public/>
        Require all granted
        AllowOverride All
        Options -Indexes +FollowSymLinks +MultiViews
    </Directory>
</VirtualHost>
```

En la carpeta **app** se aloja el proyecto, y **public** es el directorio público. Luego de guardar, habilitamos el sitio en el servidor:

```bash
a2ensite app.conf
```

Finalmente, registramos el virtual host en el archivo **hosts**:

```bash
gedit /etc/hosts
```

Agregamos las siguientes líneas y guardamos:

```
120.0.0.1    app.localhost
120.0.0.1    [www.app.localhost](http://www.app.localhost)
```

Por último, se debe reiniciar el servidor otra vez.

```bash
service apache2 restart
```

Esto sería todo para crear nuestros hosts virtuales.

## Usos

Para el caso de Laravel es muy bueno tener un host virtual, ya que podemos hacer que el navegador se recargue cuando hagamos cambios en el proyecto; para ello, debemos agregar el nombre del dominio local en la configuración de Laravel Mix:

```js
# webpack.mix.js
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .browserSync('app.localhost');
```

Después de guardar, levantamos el servidor usando NPM:

```bash
npm run watch
```

Gracias por leer este artículo, y no olvides que compartir nos hace crecer.