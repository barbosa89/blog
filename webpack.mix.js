const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'public/landing/magnific-popup.css',
        'public/landing/freelancer.css',
    ], 'public/css/landing.css')
    .scripts([
        'public/landing/bootstrap.bundle.min.js',
        'public/landing/jquery.easing.min.js',
        'public/landing/jquery.magnific-popup.min.js',
        'public/landing/freelancer.min.js',
    ], 'public/js/landing.js')
    .sourceMaps()
    .browserSync('blog.app');
