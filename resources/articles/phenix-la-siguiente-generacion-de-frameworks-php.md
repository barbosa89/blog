---
title: 'Phenix: la siguiente generación de frameworks PHP'
excerpt: 'Phenix es un framework web construido en PHP puro, sin extensiones externas, basado en el ecosistema Amphp, que proporciona non-blocking IO, asincronismo y ejecución de código paralelo de forma nativa.'
publishedAt: '2023-10-12'
updatedAt: null
locale: 'es'
image: 'images/articles/phenix.webp'
tags:
- framework
- php
- amphp
- phenix
- async
---
Desde la versión 5 de PHP, el lenguaje ha evolucionado para ofrecer nuevas funcionalidades que han permitido a los desarrolladores escribir código más robusto, una de esas capacidades son las *Fibras*, que permiten ejecutar código de forma concurrente, es decir, sin bloquear el hilo principal. Este nuevo súper poder abre posibilidades muy interesantes, y este es precisamente el caso de Phenix, un framework PHP de última generación que combina la potencia de [Amphp](https://amphp.org/), el cual aprovecha todo el poder de las fibras, con la elegante sintaxis de Laravel y todas las características requeridas en el desarrollo web moderno, lo que lo convierte en una opción sólida para construir aplicaciones y servicios web de alto rendimiento.

## El inmortal PHP con Phenix

El nombre Phenix es una combinación de "PHP" y "Phoenix", representando el renacimiento continuo de PHP y su resiliencia, es decir, que es un lenguaje que se reinventa continuamente. [Phenix](https://phenix.omarbarbosa.com/) hereda las características principales de Amphp al tiempo que introduce otras funcionalidades innovadoras. Echemos un vistazo más de cerca:

1.  **Consola de comandos**: Puedes crear controladores, middlewares, proveedores de servicios, migraciones y seeders sin esfuerzo.
2.  **Contenedor de dependencias**: Un contenedor robusto que te ayuda a gestionar las dependencias de manera eficiente, asegurando un código limpio y modular.
3.  **Enrutador con sintaxis elegante**: Simplificando la definición de rutas y haciendo tu código más legible.
4.  **Paginador**: Permite agilizar el manejo de grandes conjuntos de datos y mejorar la experiencia del usuario.
5.  **Constructor de consultas**: Aprovechando un constructor de consultas eficiente, puedes trabajar con bases de datos sin esfuerzo, ejecutando consultas complejas con facilidad.
6.  **Sistema de archivos no bloqueante**.
7.  **Formatos de respuesta**: El servidor puede responder en JSON, texto plano y HTML, muy pronto eventos enviados desde el servidor (SSE).
8.  **Configuraciones**.
9.  **Middlewares**.
10. **Modelos y migraciones**.
11. **Sesiones**.

Es una excelente opción para cualquier desarrollador que quiera construir aplicaciones PHP rápidas, escalables y confiables. Es especialmente adecuado para aplicaciones que requieren alto rendimiento, como APIs, servidores de juegos y sistemas de chat.

## Una vista general

## Enrutamiento

```php
<?php

use App\Http\Controllers\UserController;
use Phenix\Facades\Route;

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');
```

## Controlador

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Phenix\Http\Request;
use Phenix\Http\Response;
use Phenix\Http\Controller;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $users = User::query()->paginate($request->getUri());

        return response()->json($users);
    }
}
```

## Casos de uso

Phenix no es un framework de un solo propósito; está diseñado para destacar en varios casos de uso, incluyendo:

1.  **Servicios API REST**: El robusto soporte para APIs lo hace ideal para construir servicios RESTful.
2.  **Servidores de juegos**: Con sus capacidades no bloqueantes, Phenix es muy adecuado para construir servidores de juegos de alto rendimiento que demandan baja latencia.
3.  **IoT (Internet de las Cosas)**: La eficiencia del framework es perfecta para aplicaciones IoT, donde la capacidad de respuesta y la escalabilidad son cruciales.
4.  **Sistemas de chat**
5.  **Plataformas CMS headless**.
6.  **Microservicios**.
7.  **Servicios Web en tiempo real**.

## Características de Amphp

Características de Amphp que le dan superpoderes al framework:

* **Programación asíncrona:** El modelo de programación asíncrona permite manejar múltiples solicitudes al mismo tiempo sin bloqueos.
* **E/S no bloqueante:** Amphp proporciona E/S no bloqueante, lo que significa que puedes leer y escribir datos desde archivos y sockets de red sin bloquear el hilo principal.
* **WebSockets:** Esta característica te permite crear aplicaciones web en tiempo real.
* **Bucle de eventos:** Amphp utiliza un bucle de eventos para gestionar tareas asíncronas, lo que permite escribir código eficiente y escalable.
* **Futuros y promesas:** Proporciona soporte de primera clase para futuros y promesas, que son herramientas poderosas para la programación asíncrona.
* **Paralelismo:** Además, la capacidad de ejecutar múltiples fibras de forma concurrente.
* **Redes:** Sockets TCP y UDP, clientes y servidores HTTP, y resolución DNS.
* **Bases de datos:** Amphp proporciona varios controladores de bases de datos, como MySQL, PostgreSQL y Redis.
* **Sistema de archivos:** El controlador de sistema de archivos no bloqueante que permite leer y escribir archivos sin bloquear el hilo principal.

## Estado del proyecto

Todas las características básicas construidas constituyen un producto mínimo viable (MVP), con el objetivo de obtener el apoyo de la comunidad PHP y continuar con el desarrollo del framework.

## Finalmente

Te invito a soñar, a crear, Phenix es una iniciativa, una idea para la comunidad PHP. Si te gustó el framework, dale una estrella en GitHub, pruébalo, modifícalo, agrega cambios. La fortaleza de PHP es su incansable comunidad.

### Enlaces

* [https://github.com/phenixphp](https://github.com/phenixphp)
* [https://phenix.omarbarbosa.com/](https://phenix.omarbarbosa.com/)
* [https://amphp.org/](https://amphp.org/)