<?php

namespace App\Helpers;

use Wink\WinkPost;
use Carbon\Carbon;
use App\Helpers\Fields;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap as Map;

class Sitemap
{
    /**
     * Build a fresh sitemap.
     *
     * @return void
     */
	public static function generate()
	{
        $sitemap = Map::create(config('app.url'));
        $date = \DateTime::createFromFormat('Y-m-d', Carbon::yesterday()->toDateString());

        $sitemap->add(Url::create(url('/blog'))
            ->setLastModificationDate($date)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(1)
        );

        $postsRoutes = self::getPostsRoutes();

        foreach ($postsRoutes as $route) {
            $sitemap->add(Url::create($route));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Return a route collection from posts.
     *
     * @return array
     */
    public static function getPostsRoutes()
    {
        $routes = [];
        $posts = WinkPost::live()
            ->get(Fields::get('posts'));

        foreach ($posts as $post) {
            $routes[] = route('posts.article', ['slug' => $post->slug]);
        }

        return $routes;
    }
}
