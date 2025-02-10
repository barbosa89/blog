<?php

namespace App\Http\Controllers;

use App\Services\ArticleManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    public function __construct(
        protected ArticleManager $articleManager
    ) {}

    public function index(): View
    {
        $posts = $this->articleManager->list();

        $latest = $posts->shift();

        return view('templates.blog', [
            'posts' => $posts,
            'latest' => $latest,
            'tags' => $this->articleManager->topTags(),
        ]);
    }

    public function article(string $slug): View
    {
        $post = $this->articleManager->find($slug);

        abort_if(!$post, Response::HTTP_NO_CONTENT);

        return view('templates.post', [
            'post' => $post,
            'relateds' => collect(),
        ]);
    }
}
