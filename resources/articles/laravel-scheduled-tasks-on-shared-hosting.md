---
title: 'Laravel scheduled tasks on shared hosting'
excerpt: 'Configure Laravel scheduled tasks on shared hosting using cPanel, cronJobs with the power of PHP. '
publishedAt: '2020-10-26'
updatedAt: null
locale: 'en'
image: 'images/articles/task-scheduling.webp'
tags:
- php
- laravel
- cronjob
---

Scheduled tasks are an important feature of any web application, Laravel provides a powerful environment to schedule tasks, very flexible and intuitive. When we deploy applications on AWS VPS or EC2 servers, the Crontab and Supervisor make the process too easy, the problem is when we deploy Laravel on a shared hosting. This article represents a little trick to run program tasks in such a restricted environment.

## Before starting

1.  The **/usr/bin/php** path represents the location of the PHP binary and may be different on your hosting.
2.  The path **/home/my_user/domains/my_app/artisan** is the location of the console application provided by Laravel and you must obviously change it according to your configuration.
3.  You should prepare a command in which you can easily verify if the scheduled tasks work.

## PHP's register_argc_argv directive

The first time I tried to run the tasks schedules on a shared hosting it was disappointing, I did not find the right way, but these days I faced the same problem, I had to navigate deeply and found the necessary configuration to make it work perfectly.

I initially tried as follows:

```bash
* * * * * /usr/bin/php /home/my_user/my_app/artisan schedule:run >> /dev/null 2>&1
```

But some hosting restrict characters (>, &) and does not accept this setting. The next step was to try:

```bash
* * * * * /usr/bin/php /home/my_user/my_app/artisan schedule:run
```

What happened is that nothing happened, for the test I programmed a command that wrote a text in the log, it should appear every minute but not.

Searching the internet I found that the register_argc_argv directive allows PHP CLI to receive and read parameters. the official documentation says:

> Setting this to `TRUE` means that scripts executed via the CLI SAPI always have access to _argc_ (number of arguments passed to the application) and _argv_ (array of the actual arguments).

> The PHP variables [$argc](https://www.php.net/manual/en/reserved.variables.argc.php) and [$argv](https://www.php.net/manual/en/reserved.variables.argv.php) are automatically set to the appropriate values when using the CLI SAPI. These values can also be found in the [$_SERVER](https://www.php.net/manual/en/reserved.variables.server.php) array, for example: [$_SERVER['argv']](https://www.php.net/manual/en/reserved.variables.server.php).      

The trick is to activate this directive on the fly, so that **CLI artisan** can have access to the parameters:

```bash
* * * * * /usr/bin/php -d register_argc_argv=On /home/my_user/my_app/artisan schedule:run
```

You could also try the full configuration in case it's allowed:

```bash
* * * * * /usr/bin/php -d register_argc_argv=On /home/my_user/my_app/artisan schedule:run >> /dev/null 2>&1
```

In this way, we will have everything fixed and working.

Supplementary article: [https://laravelarticle.com/laravel-scheduler-on-cpanel-shared-hosting](https://laravelarticle.com/laravel-scheduler-on-cpanel-shared-hosting)

Don't forget that sharing makes us grow, thank you.