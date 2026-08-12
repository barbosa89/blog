<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

use function in_array;
use function mb_substr;
use function str_replace;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict();

        View::composer('*', function (ViewInstance $view): void {
            $normalizedLocale = str_replace('_', '-', app()->getLocale());
            $locale = mb_substr($normalizedLocale, 0, 2);

            $view->with('locale', in_array($locale, ['en', 'es'], true) ? $locale : config('app.locale'));
        });
    }
}
