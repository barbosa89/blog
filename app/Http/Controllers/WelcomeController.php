<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ArticleManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use stdClass;

class WelcomeController extends Controller
{
    public function __construct(
        protected ArticleManager $articleManager,
    ) {}

    public function __invoke(): View
    {
        $latestPosts = $this->articleManager->list()
            ->filter(fn(stdClass $article): bool => $article->locale === App::getLocale())
            ->sortByDesc('publishedAt')
            ->take(3)
            ->values();

        return view('welcome', [
            'latestPosts' => $latestPosts,
            'products' => config('blog.products', []),
            'customers' => config('blog.customers', []),
        ]);
    }
}
