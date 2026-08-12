<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    #[Test]
    public function it_renders_the_owned_product_catalog_before_editorial_and_client_context(): void
    {
        $response = $this->withHeader('Accept-Language', 'en')->get(route('welcome'));

        $response
            ->assertOk()
            ->assertSee(trans('page.landing.hero_title'))
            ->assertSee('product-ledger', false)
            ->assertSee('customer-register', false)
            ->assertDontSee('Hablemos de tu proyecto')
            ->assertDontSee('id="contact"', false)
            ->assertSee('https://cashio.omarbarbosa.com')
            ->assertSeeInOrder([
                trans('page.landing.products_title'),
                trans('page.landing.writing_title'),
                trans('page.landing.about_title'),
                trans('page.landing.customers_title'),
            ])
            ->assertSeeInOrder([
                'PhenixPHP',
                'Hellen Suite',
                'Cash IO',
            ]);

        foreach (config('blog.products') as $product) {
            $response->assertSee($product['title']);
        }

        foreach (config('blog.customers') as $customer) {
            $response
                ->assertSee($customer['title'])
                ->assertSee(asset($customer['image']));
        }

        $this->assertCount(3, config('blog.products'));
        $this->assertCount(5, config('blog.customers'));
    }

    #[Test]
    public function it_uses_the_active_locale_and_shows_three_recent_articles(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get(route('welcome'));

        $response
            ->assertOk()
            ->assertSee(trans('page.landing.hero_title', locale: 'en'))
            ->assertViewHas('latestPosts', fn($posts): bool => 3 === $posts->count()
                && $posts->every(fn(stdClass $post): bool => 'en' === $post->locale));
    }

    #[Test]
    public function it_stores_the_language_and_redirects_back(): void
    {
        $response = $this->from(route('posts.index'))->get(route('locale', ['locale' => 'en']));

        $response
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('locale', 'en');
    }

    #[Test]
    public function it_renders_article_index_search_and_empty_state(): void
    {
        $this->withSession(['locale' => 'es'])
            ->get(route('posts.index'))
            ->assertOk()
            ->assertSee(trans('page.blog_intro'))
            ->assertViewHas('latest');

        $this->withSession(['locale' => 'es'])
            ->get(route('posts.index', ['query' => 'Composer']))
            ->assertOk()
            ->assertSee('Cómo crear tu primer paquete de Composer PHP');

        $this->withSession(['locale' => 'es'])
            ->get(route('posts.index', ['query' => 'term-without-a-match']))
            ->assertOk()
            ->assertSee(trans('page.no_results'))
            ->assertSee(trans('page.no_results_help'));
    }

    #[Test]
    public function it_renders_valid_tag_and_article_and_uses_error_states_for_unknown_public_paths(): void
    {
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $spanishArticle = $articles->firstWhere('locale', 'es');
        $tag = $spanishArticle->tags[0];

        $this->withSession(['locale' => 'es'])
            ->get(route('tags.show', ['tag' => $tag]))
            ->assertOk()
            ->assertSee($tag);

        $this->withSession(['locale' => 'es'])
            ->get(route('posts.show', ['slug' => $spanishArticle->slug]))
            ->assertOk()
            ->assertSee($spanishArticle->title);

        $this->get('/missing-page')->assertNotFound()->assertSee(trans('page.404'));
        $this->get(route('tags.show', ['tag' => 'missing-tag']))->assertNotFound();
    }

    #[Test]
    public function it_covers_current_content_extremes_in_editorial_inventory(): void
    {
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $tags = json_decode(File::get(database_path('tags.json')), true);

        $this->assertCount(30, $articles);
        $this->assertCount(21, $tags);
        $this->assertSame(81, $articles->max(fn(stdClass $article): int => mb_strlen($article->title)));
        $this->assertSame(230, $articles->max(fn(stdClass $article): int => mb_strlen($article->excerpt)));
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
    public function it_uses_the_public_error_system_forbidden_error_view(): void
    {
        $html = view('errors.403')->render();

        $this->assertStringContainsString(trans('page.403'), $html);
        $this->assertStringContainsString(trans('page.technical.blocked'), $html);
    }

    #[Test]
    public function it_remains_in_public_article_surfaces_for_production_ad_components(): void
    {
        $this->app->detectEnvironment(fn(): string => 'production');
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $spanishArticle = $articles->firstWhere('locale', 'es');

        $this->withSession(['locale' => 'es'])
            ->get(route('posts.index'))
            ->assertOk()
            ->assertSee('<feed-ad', false);

        $this->withSession(['locale' => 'es'])
            ->get(route('posts.show', ['slug' => $spanishArticle->slug]))
            ->assertOk()
            ->assertSee('<article-ad', false);
    }
}
