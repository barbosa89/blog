<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Wink\WinkTag;
use Wink\WinkPost;
use Wink\WinkAuthor;
use App\Helpers\Input;
use App\Helpers\Fields;
use Illuminate\Http\Request;
use DonatelloZa\RakePlus\RakePlus;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = WinkPost::live()
            ->when(Auth::guest(), function ($query)
            {
                $query->whereHas('tags', function ($query) {
                    $query->where('name', App::getLocale());
                });
            })->orderBy('publish_date', 'DESC')
            ->paginate(20, Fields::get('posts'));

        if ($posts->isEmpty()) {
            flash()->overlay(trans('page.without_content'), trans('page.sorry'));

            return back();
        }

        $latest = $posts->shift();

        $tags = $this->getTags();

        return view('templates.blog', compact('posts', 'latest', 'tags'));
    }


    /**
     * Return the Tags collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTags()
    {
        return WinkTag::query()
            ->where('name', '!=', 'es')
            ->where('name', '!=', 'en')
            ->get(Fields::get('tags'));
    }

    /**
     * Display a article with relateds.
     *
     * @param  \App\Http\Requests\ContactEmail  $request
     * @return \Illuminate\Http\Response
     */
    public function article($slug)
    {
        $post = WinkPost::where('slug', Input::clean($slug))
            ->with([
                'tags' => function ($query)
                {
                    $query->select(Fields::get('tags'))
                        ->where('name', '!=', 'es')
                        ->where('name', '!=', 'en');
                },
                'author' => function ($query)
                {
                    $query->select(Fields::get('authors'));
                }
            ])->first(Fields::get('posts'));

        $relateds = $this->getRelateds($post);

        $keywords = $this->getKeyWords($post->excerpt);

        return view('templates.post', compact('post', 'keywords', 'relateds'));
    }

    /**
     * Return related articles.
     *
     * @param  \Wink\WinkPost  $post
     * @return \Illuminate\Support\Collection  $relateds
     */
    public function getRelateds(WinkPost $post)
    {
        $relateds = collect();
        $post->tags->each(function ($tag) use (&$relateds, $post)
        {
            $posts = WinkPost::live()
                ->where('id', '!=', $post->id)
                ->whereHas('tags', function ($query) use ($tag, $post) {
                    $query->where('name', $tag->name);
                })->whereHas('tags', function ($query) {
                    $query->where('name', App::getLocale());
                })->inRandomOrder()
                ->limit(2)
                ->get(Fields::get('posts'));

            if ($posts->isNotEmpty()) {
                foreach ($posts as $post) {
                    $relateds->push($post);
                }
            }

        });

        if ($relateds->count() >= 2) {
            $relateds = $relateds->take(2);
        }

        return $relateds;
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
                'tags' => function ($query)
                {
                    $query->select(Fields::get('tags'))
                        ->where('name', '!=', 'es')
                        ->where('name', '!=', 'en');
                },
                'author' => function ($query)
                {
                    $query->select(Fields::get('authors'));
                }
            ])->paginate(20, Fields::get('posts'));

        $tags = $this->getTags();

        return view('templates.search', compact('posts', 'query', 'tags'));
    }
}
