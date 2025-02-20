<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ArticleManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use stdClass;

class PostController extends Controller
{
    public function __construct(
        protected ArticleManager $articleManager,
    ) {}

    public function index(): View
    {
        $posts = $this->articleManager->list()
            ->filter(fn($article) => $article->locale === App::getLocale())
            ->when(request()->has('query'), function (Collection $collection): Collection {
                return $collection->filter(function (stdClass $article): bool {
                    $title = mb_strtolower($article->title);
                    $excerpt = mb_strtolower($article->excerpt);
                    $query = explode(' ', mb_strtolower(request()->query('query')));

                    return Str::of($title)->lower()->contains($query)
                        || Str::of($excerpt)->lower()->contains($query);
                })->values();
            })
            ->sortByDesc('publishedAt');

        $latest = request()->has('query') ? null : $posts->shift();

        return view('templates.blog', [
            'posts' => $posts,
            'latest' => $latest,
            'tags' => $this->articleManager->topTags(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->articleManager->find($slug);

        abort_if(!$post, Response::HTTP_NO_CONTENT);

        $related = $this->articleManager->related($post)
            ->filter(fn(stdClass $article): bool => $article->locale === App::getLocale());

        return view('templates.post', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
