<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ArticleManager;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap as Map;
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
        $sitemap = Map::create(config('app.url'));
        $date = DateTime::createFromFormat('Y-m-d', Carbon::yesterday()->toDateString());

        $sitemap->add(
            Url::create(url('/blog'))
                ->setLastModificationDate($date)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1),
        );

        $postsRoutes = $articleManager->list()
            ->map(fn($article): string => route('posts.article', ['slug' => $article->slug]));

        foreach ($postsRoutes as $route) {
            $sitemap->add(Url::create($route));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap was generated');

        return self::SUCCESS;
    }
}
