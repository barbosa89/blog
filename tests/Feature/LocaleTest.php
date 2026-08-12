<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    #[Test]
    public function it_stores_the_language_and_redirects_back(): void
    {
        $response = $this->from(route('posts.index'))->get(route('locale', ['locale' => 'en']));

        $response
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('locale', 'en');
    }
}
