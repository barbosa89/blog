<?php

declare(strict_types=1);

namespace Tests\Feature\Posts;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostShowTest extends TestCase
{
    #[Test]
    public function it_renders_an_article(): void
    {
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $englishArticle = $articles->firstWhere('locale', 'en');

        $this->withSession(['locale' => 'en'])
            ->get(route('posts.show', ['slug' => $englishArticle->slug]))
            ->assertOk()
            ->assertSee($englishArticle->title);
    }

    #[Test]
    public function it_includes_the_production_article_ad_component(): void
    {
        $this->app->detectEnvironment(fn(): string => 'production');
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $englishArticle = $articles->firstWhere('locale', 'en');

        $this->withSession(['locale' => 'en'])
            ->get(route('posts.show', ['slug' => $englishArticle->slug]))
            ->assertOk()
            ->assertSee('<article-ad', false);
    }
}
