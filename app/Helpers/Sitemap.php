<?php

namespace App\Helpers;

use Carbon\Carbon;
use Wink\WinkPost;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Collection;
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

        $sitemap->add(
            Url::create(url('/blog'))
            ->setLastModificationDate($date)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(1)
        );

        $posts = self::getPosts();

        foreach ($posts as $post) {
            $sitemap->add(
                Url::create($post->route)
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    public static function getPosts(): Collection
    {
        return WinkPost::live()
            ->get(['slug', 'updated_at'])
            ->transform(function (WinkPost $post) {
                return (object) [
                    'route' => route('posts.article', ['slug' => $post->slug]),
                    'updated_at' => $post->updated_at,
                ];
            });
    }
}
