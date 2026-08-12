<?php

declare(strict_types=1);

use App\Services\ArticleManager;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Exception\RuntimeException;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:publish-articles')
    ->hourly()
    ->when(fn(ArticleManager $articleManager): bool => $articleManager->hasSourceChanges())
    ->withoutOverlapping()
    ->onSuccess(function (): void {
        if (Command::SUCCESS !== Artisan::call('app:generate-sitemap')) {
            throw new RuntimeException('Sitemap generation failed after publishing articles.');
        }
    });
