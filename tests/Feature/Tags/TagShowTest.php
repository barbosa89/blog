<?php

declare(strict_types=1);

namespace Tests\Feature\Tags;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TagShowTest extends TestCase
{
    #[Test]
    public function it_renders_a_valid_tag(): void
    {
        $articles = collect(json_decode(File::get(database_path('articles.json'))));
        $englishArticle = $articles->firstWhere('locale', 'en');
        $tag = $englishArticle->tags[0];

        $this->withSession(['locale' => 'en'])
            ->get(route('tags.show', ['tag' => $tag]))
            ->assertOk()
            ->assertSee($tag);
    }

    #[Test]
    public function it_returns_not_found_for_an_unknown_tag(): void
    {
        $this->get(route('tags.show', ['tag' => 'missing-tag']))->assertNotFound();
    }
}
