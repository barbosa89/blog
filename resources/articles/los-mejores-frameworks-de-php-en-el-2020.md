---
title: 'Los mejores frameworks de PHP en el 2020'
excerpt: 'Los mejores frameworks de PHP en el 2020, según la demanda laboral, popularidad, comunidad de desarrollo y ecosistema.'
publishedAt: '2020-02-11'
updatedAt: null
locale: 'es'
image: 'images/articles/best-frameworks-2020.png'
tags:
- php
- laravel
- swoole
---

El 2019 fue un gran año para PHP, pero no será mejor que el 2020 y 2021. En noviembre de 2019 fue liberada la versión 7.4 que incluye importantes cambios como funciones flecha, precarga, tipado, operador de asignación nula, FFI, el operador Spread y más. Durante el presente año PHP 7.4 será implementado en muchas soluciones de Internet con sus nuevos súper poderes, lo que traerá diversas y revolucionarias formas de hacer las cosas. A finales de 2020 será liberada la versión 8 de PHP y esta desbordará el uso clásico del lenguaje para llevarlo fuera de la web a otras áreas como la inteligencia artificial y ciencias de datos, debido a que se está incorporando un motor JIT en el núcleo de PHP, así pues, el 2021 presagia ser un año muy bueno para este lenguaje.

Dada esta reseña, hoy les comparto el listado de los mejores marcos de trabajo (frameworks) en PHP, teniendo en cuenta su demanda laboral, popularidad y comunidad. Sin más dilaciones a continuación el listado:

1. [Laravel](https://laravel.com/): Es sin lugar a duda el mejor framework de PHP, su sintaxis expresiva, el orden de su estructura, la separación de las capas, su poderoso ecosistema y la cantidad de demanda laboral, lo convierten en la mejor opción, la versión actual es la 6.X en semver, puedes encontrar paquetes de Composer para casi todo, la comunidad de desarrollo ofrece soluciones en diferentes ámbitos que van desde CMS hasta convertir números en letras. También cuenta con paquetes oficiales como Passport, Airlock, Socialite y demás, los cuales podrás encontrar en la documentación oficial. Si tu proyecto requiere escalamiento, Laravel cuenta con Vapor, una solución en la nube para el despliegue usando ServerLess.

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/laravel-ecosystem-2020.png" alt="Ecosistema de Laravel">

2. [Symfony](https://symfony.com/): Es el poderoso framework clásico de PHP, posee un potente ecosistema de componentes reutilizables, de los cuales se suple Laravel, porque la idea no es reinventar la rueda sino mejorarla capa a capa. Symfony posee una gran demanda debido a que es realmente robusto, Twig el motor de plantillas está integrado en él, aspecto que agrada a muchos desarrolladores.

3. [CakePHP](https://cakephp.org/): Es otro clásico en frameworks, fue inspirado en Ruby on Rails, salió al mercado en 2005, por lo cual imaginarás tiene bastante recorrido.

4. [Phalcon](https://phalcon.io/): Este es un framework muy diferente a los demás, es literalmente una extensión de PHP escrita en el lenguage C, como sabrás es posible extender las funcionalidades de PHP mediante extensiones o usando FFI en PHP 7.4. Los responsables de Phalcon crearon un lenguaje llamado Zephir para facilitar la creación de extensiones y así crearon a Phalcon, al estar compilado en memoria este framework es muy rápido, comparado con los frameworks síncronos. Evidentemente se requiere acceso a la terminal con permisos de usuario Root en el servidor en el que desplegarás Phalcon, debido a la naturaleza de su tecnología.

5. [Zend](https://framwork.zend.com/): Es el framework oficial de PHP, está desarrollado por la empresa responsable del desarrollo del núcleo de PHP llamada Zend Technologies.

Todos los frameworks anteriores son síncronos pero PHP ha evolucionado hasta tener frameworks asíncronos al estilo de NodeJs y Tornado de Python, sus nombres a continuación:

6. [Swoole](https://www.swoole.co.uk/): Es el más poderoso framework asíncrono de PHP, es incluso más rápido que NodeJs, sólo funciona en servidores de Linux y está compilado en el lenguaje C, por lo que necesitarás servidores con acceso Root. Swoole es impresionante, si tienes una distro de Linux tienes que probar este monstruo. Casi todos los frameworks mencionados anteriormente tienen integraciones con Swoole.

<img class="img-fluid d-block mb-0 m-auto" src="/images/articles/swoole-performance.png" alt="Rendimiento de Swoole PHP">

_Imagen tomada de_ [_ITDO_](https://www.itdo.com/blog/swoole-el-framework-php-asincrono-con-el-mejor-rendimiento-http/)_._

7. [ReactPHP](https://reactphp.org/): Es un increíble framework escrito en PHP puro, funciona como un bucle infinito que atiende todos los eventos necesarios y los despacha conforme va terminando. Sus números son impresionantes, tiene importantes soluciones basadas en él como Ratchet, Thruway y Predis\Async.

8. [Amp](https://amphp.org/): Es otro potente framework parecido a ReactPHP pero con sintaxis muy diferente, Amp puede interoperar con ReactPHP, está escrito en PHP puro así podrás instalarlo con Composer.

No olvides compartir, nos leemos la próxima. Algunas imágenes fueron tomadas de [Freepik](https://www.freepik.com/free-photos-vectors/technology).