<?php

namespace App\Http\Controllers;

use App\Services\ArticleManager;
use Illuminate\Http\Request;
use DonatelloZa\RakePlus\RakePlus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

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

        $keywords = $this->getKeyWords($post->excerpt);

        return view('templates.post', [
            'post' => $post,
            'keywords' => $keywords,
            'relateds' => collect(),
        ]);
    }

    /**
     * Extract keywords from the post excerpt.
     *
     * @param  string  $text
     * @return string
     */
    public function getKeyWords(string $text = null)
    {
        $keywords = RakePlus::create($text, $this->getLocale())->keywords();

        return implode(", ", $keywords);
    }

    /**
     * Get locale in RakePlus format.
     *
     * @return string
     */
    public function getLocale()
    {
        $locale = App::getLocale();

        if ($locale == 'en') {
            return 'en_US';
        }

        return 'es_AR';
    }

    /**
     * Display articles by tags.
     *
     * @param  string  $tag
     * @return \Illuminate\Http\Response
     */
    public function tags(string $tag = null)
    {
        $tag = Input::clean($tag);

        $posts = WinkPost::live()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            })->whereHas('tags', function ($query) {
                $query->where('name', App::getLocale());
            })->paginate(20, Fields::get('posts'));

        if ($posts->isEmpty()) {
            flash()->overlay(trans('page.without_content'), trans('page.sorry'));

            return back();
        }

        $tags = $this->getTags();

        return view('templates.tag-search', compact('posts', 'tags', 'tag'));
    }

    /**
     * Search a post in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request)
    {
        $query = Input::clean($request->get('query'));

        if (empty($query)) {
            return redirect()->route('blog');
        }

        $posts = WinkPost::live()
            ->whereHas('tags', function ($query) {
                $query->where('name', App::getLocale());
            })->whereLike(['title', 'slug', 'excerpt', 'tags.name'], $query)
            ->with([
                'tags' => function ($query) {
                    $query->select(Fields::get('tags'))
                        ->whereNotIn('name', LangTags::excludes());
                },
                'author' => function ($query) {
                    $query->select(Fields::get('authors'));
                },
            ])->paginate(20, Fields::get('posts'));

        $tags = $this->getTags();

        return view('templates.search', compact('posts', 'query', 'tags'));
    }
}
