---
title: 'How to create a virtual host with Apache in Ubuntu'
excerpt: 'Learn how to create a virtual host with the Apache2 web server in Ubuntu, and organize your application development projects. '
publishedAt: '2020-06-15'
updatedAt: null
locale: 'en'
image: 'images/articles/virtual-hosts.jpeg'
tags:
- ubuntu
- apache
---

Virtual hosts help us organize the development of applications by local domain names, these names will not be available on the internet, that is, they only exist on our machine, because the browser first consults the hosts file of the operating system, and later, solves the domain and IP in the large network; Thus, it is possible to host different sites with their respective domain name and pointing to the same IP, in this case, localhost (127.0.0.1). Examples of common names in development:

* myapp.local
* myapp.test
* myapp.localhost

Once the style is chosen, you can create your virtual hosts:

* calculator.localhost
* portfolio.localhost
* landing.localhost

This article focuses on Debian and its derived distributions, such as Ubuntu, Mint, and more. Apache version 2 is required to be installed on the system and the rewrite module is enabled. If the rewrite module is not enabled, you can use the following command:

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

## Step by Step

For the creation of virtual hosts, it is necessary to do it with root user permissions:

```bash
sudo su
cd /etc/apache2/sites-available/
ls -l
```

The contents of the folder will be something like this:

```
-rw-r--r-- 1 root root 1234 jul 16 2018 000-default.conf
```

Now, copy the default file and assign the name that the virtual host will have:

```bash
cp 000-default.conf app.con
```

With the preferred text editor, modify the content:

```bash
# Gedit editor
gedit app.conf
# Sublime editor
subl app.conf
# VS Code editor
code app.conf
# Nano editor
nano app.conf
```

<article-ad></article-ad>

At the end of editing, the content should look very similar to this:

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

The project is hosted in the app folder, and public is the public directory. After saving, enable the site on the server:

```bash
a2ensite app.conf
service apache2 restart
```

Finally, register the virtual host in the hosts file:

```bash
gedit /etc/hosts
```

Add the following lines and save:

```
120.0.0.1    app.localhost
120.0.0.1    www.app.localhost
```

## Use cases

In the Laravel case, it is very good to have a virtual host, since you can make the browser reload when you make changes to the project; To do this, you must add the local domain name in the Laravel Mix configuration:

```js
# webpack.mix.js
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .browserSync('app.localhost');
```

Save and run the server with NPM:

```bash
npm run watch
```

Thanks for reading this article, and don't forget that sharing makes us grow.