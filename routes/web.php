<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    abort(403);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/offline', function () {
    return view('modules/laravelpwa/offline');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/blog', 'BlogController@index')->name('blog');

Route::get('/tags/{tag}', 'BlogController@tags')->name('posts.tag');
Route::get('/posts/{slug}', 'BlogController@article')->name('posts.article');
Route::get('/search', 'BlogController@search')->name('posts.search');

Route::post('/subscribe', 'SubscriptionController@subscribe')
    ->name('subscribe')
    ->middleware(['sanitize', 'honeypot']);

Route::get('/unsubscribe/{email}', 'SubscriptionController@unsubscribe')
    ->name('unsubscribe')
    ->middleware(['sanitize', 'honeypot']);

Route::post('/message', 'ContactController@message')
    ->name('message')
    ->middleware(['sanitize', 'honeypot']);

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
    ->middleware('auth');


