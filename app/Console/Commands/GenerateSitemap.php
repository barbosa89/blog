<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ArticleManager;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * @var string
     */
    protected $description = 'Build a fresh sitemap';

    public function handle(ArticleManager $articleManager): int
    {
        SitemapGenerator::create((string) config('app.url'))
            ->getSitemap()
            ->add($articleManager->list()->map(
                fn (object $article): Url => Url::create(route('posts.show', ['slug' => $article->slug])),
            ))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info(trans('page.sitemap.messages.generated'));

        return self::SUCCESS;
    }
}
