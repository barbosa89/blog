<?php

declare(strict_types=1);

namespace App\Services;

use stdClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Support\Arrayable;
use GrahamCampbell\Markdown\Facades\Markdown;

use function is_array;

class ArticleManager implements Arrayable
{
    public const DIRECTORY = 'articles';

    protected string $path;
    protected array $content;

    public static function path(string|null $path = null): string
    {
        return resource_path(self::DIRECTORY . DIRECTORY_SEPARATOR . $path);
    }

    public function publish(): void
    {
        Cache::forget(self::DIRECTORY);

        $articles = File::allFiles(self::path());

        $publicArticles = collect();
        $tagMapping = collect();

        foreach ($articles as $article) {
            $markdown = Markdown::convert(File::get($article->getPathname()));

            $frontMatter = $markdown->getFrontMatter();

            $frontMatter['file'] = $article->getFilename();
            $frontMatter['slug'] = str_replace(".{$article->getExtension()}", '', $article->getFilename());
            $frontMatter['author'] = [
                'name' => 'Omar Barbosa',
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
            $path = self::path($post->file);

            $markdown = Markdown::convert(File::get($path));

            $post->content = $markdown->getContent();

            return $post;
        }

        return null;
    }

    public function topTags(): Collection
    {
        return Cache::rememberForever('top_tags', function (): Collection {
            $tags = File::get(database_path('tags.json'));

            return collect(json_decode($tags, true))
                ->sortBy(function (array $articles, string $tagName): int {
                    return count($articles);
                })
                ->take(15)
                ->keys();
        });
    }

    public function toArray(): array
    {
        return $this->content;
    }
}
