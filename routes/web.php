<?php

declare(strict_types=1);

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('welcome'));

Route::get('/offline', fn() => view('modules/laravelpwa/offline'));

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

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

Auth::routes(['verify' => true]);
