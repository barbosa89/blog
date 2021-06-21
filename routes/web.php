<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriptionController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/wink/api/tags', [TagController::class, 'index'])->name('wink.tags.index');
Route::get('/tags/{tag}', [BlogController::class, 'tags'])->name('posts.tag');
Route::get('/posts/{slug}', [BlogController::class, 'article'])->name('posts.article');
Route::get('/search', [BlogController::class, 'search'])->name('posts.search');

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])
    ->name('subscribe')
    ->middleware(['sanitize', 'honeypot']);

Route::get('/unsubscribe/{email}', [SubscriptionController::class, 'unsubscribe'])
    ->name('unsubscribe')
    ->middleware(['sanitize', 'honeypot']);

Route::post('/message', [ContactController::class, 'message'])
    ->name('message')
    ->middleware(['sanitize', 'honeypot']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
    ->middleware('auth');


