<?php

declare(strict_types=1);

namespace App\Services;

use DonatelloZa\RakePlus\RakePlus;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

use function is_array;

use stdClass;

class ArticleManager
{
    public const DIRECTORY = 'articles';

    protected string $cachePath;


    public function __construct()
    {
        $this->cachePath = storage_path('framework/cache/articles');

        if (!File::isDirectory($this->cachePath)) {
            File::makeDirectory($this->cachePath, 0755, true);
        }
    }

    public function path(string|null $path = null): string
    {
        return resource_path(self::DIRECTORY . DIRECTORY_SEPARATOR . $path);
    }

    public function publish(): void
    {
        $this->clearCache();

        $articles = File::allFiles($this->path());

        $publicArticles = collect();
        $tagMapping = collect();

        foreach ($articles as $article) {
            $markdown = Markdown::convert(File::get($article->getPathname()));

            $frontMatter = $markdown->getFrontMatter();

            $frontMatter['file'] = $article->getFilename();
            $frontMatter['slug'] = str_replace(".{$article->getExtension()}", '', $article->getFilename());
            $frontMatter['keywords'] = $this->getKeyWords($frontMatter['excerpt'] ?? '');
            $frontMatter['author'] = [
                'name' => config('blog.author'),
            ];

            $publicArticles->push($frontMatter);

            if (isset($frontMatter['tags']) && is_array($frontMatter['tags'])) {
                foreach ($frontMatter['tags'] as $tag) {
                    if (!$tagMapping->has($tag)) {
                        $tagMapping[$tag] = collect();
                    }

                    $tagMapping[$tag]->push($frontMatter['slug']);
                }
            }
        }

        $publicArticles->sortByDesc('publishedAt');

        File::put(database_path('articles.json'), $publicArticles->toJson());

        File::put(database_path('tags.json'), $tagMapping->toJson());
    }

    public function list(): Collection
    {
        return Cache::rememberForever(self::DIRECTORY, static function (): Collection {
            $articles = File::get(database_path('articles.json'));

            return collect(json_decode($articles));
        });
    }

    public function find(string $slug): stdClass|null
    {
        $lists = $this->list();

        $post = $lists->firstWhere('slug', $slug);

        if ($post) {
            $post->content = $this->cachedContent($post);

            return $post;
        }

        return null;
    }

    public function topTags(): Collection
    {
        return Cache::rememberForever('top_tags', function (): Collection {
            $tags = File::get(database_path('tags.json'));

            return collect(json_decode($tags, true))
                ->sortByDesc(fn(array $articles, string $tagName): int => count($articles))
                ->take(15)
                ->keys();
        });
    }

    public function tag(string $tag): Collection|null
    {
        $tags = File::get(database_path('tags.json'));

        /** @var Collection<string, array<string>> */
        $tags = collect(json_decode($tags, true));

        $slugs = $tags->get($tag);

        if (!$slugs) {
            return null;
        }

        $articles = $this->list()->filter(fn(stdClass $article): bool => in_array($article->slug, $slugs));

        return $articles->values();
    }

    public function clearCache(): void
    {
        Cache::forget(self::DIRECTORY);
        Cache::forget('top_tags');

        foreach (File::files($this->cachePath) as $file) {
            File::delete($file);
        }
    }

    private function getKeyWords(string $text): string
    {
        $keywords = RakePlus::create($text, $this->getLocale())->keywords();

        return implode(", ", $keywords);
    }

    private function getLocale(): string
    {
        return 'en' === App::getLocale()
            ? 'en_US'
            : 'es_AR';
    }

    private function cachedContent(stdClass $post): string
    {
        $documentPath = storage_path("framework/cache/articles/{$post->slug}.html");
        $markdownPath = $this->path($post->file);

        if (!File::isDirectory($this->cachePath)) {
            File::makeDirectory($this->cachePath, 0755, true);
        }

        if (File::exists($documentPath) && filemtime($documentPath) > filemtime($markdownPath)) {
            return File::get($documentPath);
        }

        $markdown = Markdown::convert(File::get($markdownPath));
        $content = $markdown->getContent();

        File::put($documentPath, $content);

        return $content;
    }
}
