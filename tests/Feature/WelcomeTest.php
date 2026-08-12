<?php

declare(strict_types=1);

namespace Tests\Feature;

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

}
