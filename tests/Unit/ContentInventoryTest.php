<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Tests\TestCase;

class ContentInventoryTest extends TestCase
{
    #[Test]
    public function it_keeps_editorial_indexes_aligned_with_article_sources(): void
    {
        $articles = collect(json_decode(File::get(database_path('articles.json'))));

        $tags = json_decode(File::get(database_path('tags.json')), true);

        $sourceArticles = collect(File::allFiles(resource_path('articles')))
            ->filter(fn($article): bool => 'md' === $article->getExtension());

        $articleTags = $articles
            ->flatMap(fn(stdClass $article): array => $article->tags)
            ->unique()
            ->sort()
            ->values();

        $indexedTags = collect(array_keys($tags))
            ->sort()
            ->values();

        $this->assertCount($sourceArticles->count(), $articles);
        $this->assertSame($articleTags->all(), $indexedTags->all());
        $this->assertTrue($articles->every(
            fn(stdClass $article): bool => filled($article->title) && filled($article->excerpt),
        ));
        $this->assertTrue(collect($tags)->every(fn(array $articleSlugs): bool => [] !== $articleSlugs));
    }
}
