<?php

declare(strict_types=1);

namespace App\Console\Commands;

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
    protected $signature = 'sitemap:generate';

    /**
     * @var string
     */
    protected $description = 'Build a fresh sitemap';

    public static function getPostsRoutes(): array
    {
        $routes = [];
        $posts = Post::live()->get();

        foreach ($posts as $post) {
            $routes[] = route('posts.article', ['slug' => $post->slug]);
        }

        return $routes;
    }


    public function handle(): int
    {
        $sitemap = Map::create(config('app.url'));
        $date = DateTime::createFromFormat('Y-m-d', Carbon::yesterday()->toDateString());

        $sitemap->add(
            Url::create(url('/blog'))
                ->setLastModificationDate($date)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1),
        );

        $postsRoutes = self::getPostsRoutes();

        foreach ($postsRoutes as $route) {
            $sitemap->add(Url::create($route));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap was generated');

        return self::SUCCESS;
    }
}
