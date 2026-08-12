<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\ArticleManager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArticleManagerTest extends TestCase
{
    private string $testPath;

    private ArticleManager $articleManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testPath = storage_path('framework/testing/articles-' . uniqid());
        $this->articleManager = new ArticleManager(
            "{$this->testPath}/sources",
            "{$this->testPath}/database",
            "{$this->testPath}/cache",
        );

        Cache::flush();
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->testPath);

        parent::tearDown();
    }

    #[Test]
    public function it_publishes_articles_from_locale_directories_and_tracks_source_changes(): void
    {
        $this->writeArticle('en/current.md', 'Current article', '2025-01-01', 'php, laravel', ['php']);
        $this->writeArticle('es/newest.md', 'Newest article', '2026-01-01', 'php, testing', ['php', 'testing']);
        $this->writeArticle('en/older.md', 'Older article', '2024-01-01', 'php', ['php']);

        $this->assertTrue($this->articleManager->hasSourceChanges());

        $this->articleManager->publish();

        $articles = json_decode(File::get("{$this->testPath}/database/articles.json"));
        $tags = json_decode(File::get("{$this->testPath}/database/tags.json"), true);

        $this->assertCount(3, $articles);
        $this->assertSame(['newest', 'current', 'older'], array_column($articles, 'slug'));
        $this->assertSame('es', $articles[0]->locale);
        $this->assertSame('es/newest.md', $articles[0]->file);
        $this->assertSame('php, testing', $articles[0]->keywords);
        $this->assertSame(['current', 'older', 'newest'], $tags['php']);
        $this->assertFileExists("{$this->testPath}/database/articles.manifest.json");
        $this->assertFalse($this->articleManager->hasSourceChanges());

        File::append($this->articleManager->path('en/current.md'), "\nUpdated content.\n");
        $this->assertTrue($this->articleManager->hasSourceChanges());

        $this->articleManager->publish();
        File::move(
            $this->articleManager->path('en/older.md'),
            $this->articleManager->path('es/older.md'),
        );
        $this->assertTrue($this->articleManager->hasSourceChanges());

        $this->articleManager->publish();
        $movedArticle = $this->articleManager->list()->firstWhere('slug', 'older');

        $this->assertSame('es', $movedArticle->locale);

        File::delete($this->articleManager->path('es/older.md'));
        $this->assertTrue($this->articleManager->hasSourceChanges());
    }

    #[Test]
    public function it_matches_related_articles_in_the_same_locale_and_orders_them_by_descending_dates(): void
    {
        $this->writeArticle('en/current.md', 'Current article', '2025-01-01', 'php', ['php']);
        $this->writeArticle('en/recent.md', 'Recent article', '2024-12-01', 'php', ['php']);
        $this->writeArticle('en/older.md', 'Older article', '2024-01-01', 'php', ['php']);
        $this->writeArticle('es/newest.md', 'Newest article', '2026-01-01', 'php', ['php']);

        $this->articleManager->publish();

        $related = $this->articleManager->related($this->articleManager->find('current'));

        $this->assertSame(['recent', 'older'], $related->pluck('slug')->all());
        $this->assertTrue($related->every(fn(object $article): bool => 'en' === $article->locale));
    }

    #[Test]
    public function it_creates_the_source_in_the_selected_locale_directory_when_making_an_article(): void
    {
        $this->app->instance(ArticleManager::class, $this->articleManager);

        $this->artisan('app:make-article')
            ->expectsQuestion(trans('articles.actions.questions.title'), 'A fresh English article')
            ->expectsChoice(trans('articles.actions.questions.locale'), 'en', ['es', 'en'])
            ->assertExitCode(0);

        $article = File::get($this->articleManager->path('en/a-fresh-english-article.md'));

        $this->assertStringContainsString("title: 'A fresh English article'", $article);
        $this->assertStringContainsString('keywords:', $article);
        $this->assertStringNotContainsString('locale:', $article);
    }

    #[Test]
    public function it_schedules_article_publication_hourly_and_skips_unchanged_sources(): void
    {
        $event = collect(app(Schedule::class)->events())
            ->first(fn(object $event): bool => str_contains($event->command, 'app:publish-articles'));

        $this->assertNotNull($event);
        $this->assertSame('0 * * * *', $event->expression);
        $this->assertTrue($event->withoutOverlapping);
        $this->assertFalse($event->filtersPass($this->app));
    }

    private function writeArticle(string $path, string $title, string $publishedAt, string $keywords, array $tags): void
    {
        $content = <<<MARKDOWN
---
title: '{$title}'
excerpt: '{$title} excerpt'
keywords: '{$keywords}'
publishedAt: '{$publishedAt}'
updatedAt: null
image: null
tags:
MARKDOWN;

        $content .= "\n";

        foreach ($tags as $tag) {
            $content .= "- {$tag}\n";
        }

        $content .= "---\n\n{$title} content.\n";

        $filename = $this->articleManager->path($path);

        File::ensureDirectoryExists(dirname($filename));
        File::put($filename, $content);
    }
}
