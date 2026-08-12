<?php

declare(strict_types=1);

namespace App\Services;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use LogicException;
use stdClass;
use Symfony\Component\Finder\SplFileInfo;

use function array_key_exists;
use function in_array;
use function is_array;

class ArticleManager
{
    public const string DIRECTORY = 'articles';

    public const array LOCALES = ['en', 'es'];

    private const string MANIFEST_FILE = 'articles.manifest.json';

    protected string $cachePath;

    protected string $articlesPath;

    protected string $databasePath;

    public function __construct(
        ?string $articlesPath = null,
        ?string $databasePath = null,
        ?string $cachePath = null,
    ) {
        $this->articlesPath = $articlesPath ?? resource_path(self::DIRECTORY);
        $this->databasePath = $databasePath ?? database_path();
        $this->cachePath = $cachePath ?? storage_path('framework/cache/articles');

        if (!File::isDirectory($this->cachePath)) {
            File::makeDirectory($this->cachePath, 0755, true);
        }
    }

    public function path(?string $path = null): string
    {
        return $path
            ? $this->articlesPath . DIRECTORY_SEPARATOR . $path
            : $this->articlesPath;
    }

    public function publish(): void
    {
        $articles = $this->articleFiles();

        $publicArticles = collect();
        $tagMapping = collect();
        $slugs = [];

        foreach ($articles as $article) {
            $markdown = Markdown::convert(File::get($article->getPathname()));

            $frontMatter = $markdown->getFrontMatter();
            $relativePath = $this->relativePath($article);
            $locale = $this->localeFor($relativePath);
            $slug = pathinfo($relativePath, PATHINFO_FILENAME);

            if (array_key_exists($slug, $slugs)) {
                throw new LogicException("Article slugs must be unique. Duplicate slug [{$slug}] found in [{$relativePath}] and [{$slugs[$slug]}].");
            }

            $slugs[$slug] = $relativePath;

            $frontMatter['file'] = $relativePath;
            $frontMatter['slug'] = $slug;
            $frontMatter['locale'] = $locale;
            $frontMatter['keywords'] = (string) ($frontMatter['keywords'] ?? '');
            $frontMatter['author'] = [
                'name' => config('blog.author'),
            ];

            $publicArticles->push($frontMatter);

            if (isset($frontMatter['tags']) && is_array($frontMatter['tags'])) {
                foreach (array_filter($frontMatter['tags']) as $tag) {
                    if (!$tagMapping->has($tag)) {
                        $tagMapping[$tag] = collect();
                    }

                    $tagMapping[$tag]->push($frontMatter['slug']);
                }
            }
        }

        $publicArticles = $publicArticles->sortByDesc('publishedAt')->values();

        $this->clearCache();
        File::ensureDirectoryExists($this->databasePath);

        File::put($this->articlesIndexPath(), $publicArticles->toJson());
        File::put($this->tagsIndexPath(), $tagMapping->toJson());
        File::put($this->manifestPath(), json_encode([
            'fingerprint' => $this->sourceFingerprint($articles),
        ], JSON_THROW_ON_ERROR));
    }

    public function hasSourceChanges(): bool
    {
        if (!File::exists($this->articlesIndexPath())
            || !File::exists($this->tagsIndexPath())
            || !File::exists($this->manifestPath())) {
            return true;
        }

        $manifest = json_decode(File::get($this->manifestPath()), true);

        return !is_array($manifest)
            || !isset($manifest['fingerprint'])
            || $manifest['fingerprint'] !== $this->sourceFingerprint($this->articleFiles());
    }

    public function list(): Collection
    {
        return Cache::rememberForever(self::DIRECTORY, function (): Collection {
            $articles = File::get($this->articlesIndexPath());

            return collect(json_decode($articles));
        });
    }

    public function find(string $slug): ?stdClass
    {
        $lists = $this->list();

        $post = $lists->firstWhere('slug', $slug);

        if ($post) {
            $post->content = $this->cachedContent($post);

            return $post;
        }

        return null;
    }

    public function related(stdClass $post): Collection
    {
        return $this->list()
            ->where('locale', $post->locale)
            ->where('slug', '!=', $post->slug)
            ->filter(function (stdClass $p) use ($post): bool {
                $tags = collect($p->tags)->filter(fn(string $tag): bool => in_array($tag, $post->tags));

                return $tags->isNotEmpty();
            })
            ->sortByDesc('publishedAt')
            ->take(2)
            ->values();
    }

    public function topTags(): Collection
    {
        return Cache::rememberForever('top_tags', function (): Collection {
            $tags = File::get($this->tagsIndexPath());

            return collect(json_decode($tags, true))
                ->sortByDesc(fn(array $articles, string $tagName): int => count($articles))
                ->take(15)
                ->keys();
        });
    }

    public function tag(string $tag): ?Collection
    {
        $tags = File::get($this->tagsIndexPath());

        /** @var Collection<string, array<string>> */
        $tags = collect(json_decode($tags, true));

        $slugs = $tags->get($tag);

        if (!$slugs) {
            return null;
        }

        $articles = $this->list()
            ->filter(fn($article) => $article->locale === App::getLocale())
            ->filter(fn(stdClass $article): bool => in_array($article->slug, $slugs));

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

    /**
     * @return Collection<int, SplFileInfo>
     */
    private function articleFiles(): Collection
    {
        return collect(File::allFiles($this->path()))
            ->filter(fn(SplFileInfo $article): bool => 'md' === $article->getExtension())
            ->sortBy(fn(SplFileInfo $article): string => $this->relativePath($article))
            ->values();
    }

    private function articlesIndexPath(): string
    {
        return $this->databasePath . DIRECTORY_SEPARATOR . 'articles.json';
    }

    private function tagsIndexPath(): string
    {
        return $this->databasePath . DIRECTORY_SEPARATOR . 'tags.json';
    }

    private function manifestPath(): string
    {
        return $this->databasePath . DIRECTORY_SEPARATOR . self::MANIFEST_FILE;
    }

    private function relativePath(SplFileInfo $article): string
    {
        return str_replace('\\', '/', $article->getRelativePathname());
    }

    private function localeFor(string $relativePath): string
    {
        $locale = explode('/', $relativePath)[0];

        if (!in_array($locale, self::LOCALES, true)
            || $relativePath !== "{$locale}/" . basename($relativePath)) {
            throw new LogicException("Article [{$relativePath}] must be inside an en or es directory.");
        }

        return $locale;
    }

    /**
     * @param Collection<int, SplFileInfo> $articles
     */
    private function sourceFingerprint(Collection $articles): string
    {
        $fingerprint = hash_init('sha256');

        foreach ($articles as $article) {
            hash_update($fingerprint, $this->relativePath($article));
            hash_update($fingerprint, "\0");
            hash_update_file($fingerprint, $article->getPathname());
            hash_update($fingerprint, "\0");
        }

        return hash_final($fingerprint);
    }

    private function cachedContent(stdClass $post): string
    {
        $documentPath = $this->cachePath . DIRECTORY_SEPARATOR . "{$post->slug}.html";
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
