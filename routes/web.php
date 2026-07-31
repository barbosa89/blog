<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

Route::get('locale/{locale}', function (string $locale): RedirectResponse {
    app()->setLocale($locale);

    session()->put('locale', $locale);

    return redirect()->back();
})
    ->name('locale')
    ->whereIn('locale', ['es', 'en']);
