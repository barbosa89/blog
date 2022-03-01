<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use Symfony\Component\Console\Command\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenerateSitemapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_sitemap_rigthly(): void
    {
        $path = public_path('sitemap.xml');

        /** @var \App\Models\Post $post */
        $post = Post::factory()->create([
            'updated_at' => now()->subDay(),
        ]);

        $this->artisan('sitemap:generate')
            ->expectsOutput('Sitemap was generated')
            ->assertExitCode(Command::SUCCESS);

        $this->assertFileExists($path);

        $sitemap = file_get_contents($path);

        $this->assertStringContainsString($post->slug, $sitemap);
        $this->assertStringContainsString($post->updated_at->toIso8601String(), $sitemap);
    }
}
