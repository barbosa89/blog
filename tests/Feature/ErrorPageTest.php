<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    #[Test]
    public function it_renders_the_not_found_page_for_unknown_public_paths(): void
    {
        $this->get('/missing-page')
            ->assertNotFound()
            ->assertSee(trans('page.404'));
    }

    #[Test]
    public function it_renders_the_forbidden_error_view(): void
    {
        $html = view('errors.403')->render();

        $this->assertStringContainsString(trans('page.403'), $html);
        $this->assertStringContainsString(trans('page.technical.blocked'), $html);
    }
}
