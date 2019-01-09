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
    return view('emails.message')->with([
        'name' => 'Luis',
        'email' => 'a@b.com',
        'phone' => '123',
        'message' => 'Hi'
    ]);
});

Route::get('/blog', function () {
    return view('templates.blog');
})->name('blog');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/subscribe', 'SubscriptionController@subscribe')
    ->name('subscribe');

Route::get('/unsubscribe/{email}', 'SubscriptionController@unsubscribe')
    ->name('unsubscribe');

Route::post('/message', 'ContactController@message')
    ->name('message')
    ->middleware('sanitize');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
    ->middleware('auth');


