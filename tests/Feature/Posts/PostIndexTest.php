<?php

declare(strict_types=1);

namespace Tests\Feature\Posts;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    #[Test]
    public function it_renders_article_index_search_and_empty_state(): void
    {
        $this->withSession(['locale' => 'en'])
            ->get(route('posts.index'))
            ->assertOk()
            ->assertSee(trans('page.blog_intro'))
            ->assertViewHas('latest');

        $this->withSession(['locale' => 'en'])
            ->get(route('posts.index', ['query' => 'Composer']))
            ->assertOk()
            ->assertSee('The best Composer packages for Laravel');

        $this->withSession(['locale' => 'en'])
            ->get(route('posts.index', ['query' => 'term-without-a-match']))
            ->assertOk()
            ->assertSee(trans('page.no_results'))
            ->assertSee(trans('page.no_results_help'));
    }

    #[Test]
    public function it_uses_the_public_fallback_for_missing_article_images_in_the_archive(): void
    {
        $post = (object) [
            'title' => 'Fallback image article',
            'excerpt' => 'A factual test article.',
            'publishedAt' => '2026-07-31',
            'locale' => 'en',
            'slug' => 'fallback-image-article',
            'image' => null,
        ];

        $html = view('posts.index', [
            'latest' => $post,
            'posts' => collect(),
            'tags' => collect(),
        ])->render();

        $this->assertStringContainsString(asset('images/article.png'), $html);
    }

    #[Test]
    public function it_includes_the_production_feed_ad_component(): void
    {
        $this->app->detectEnvironment(fn(): string => 'production');

        $this->withSession(['locale' => 'en'])
            ->get(route('posts.index'))
            ->assertOk()
            ->assertSee('<feed-ad', false);
    }
}
