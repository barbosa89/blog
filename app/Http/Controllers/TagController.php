<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ArticleManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function __construct(
        protected ArticleManager $articleManager,
    ) {}

    public function show(string $tag): View
    {
        $posts = $this->articleManager->tag($tag);

        abort_if(!$posts, Response::HTTP_NOT_FOUND);

        return view('templates.blog', [
            'posts' => $posts,
            'tag' => $tag,
            'tags' => $this->articleManager->topTags(),
        ]);
    }
}
