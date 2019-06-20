<?php

namespace App\Http\Controllers;

use App;
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
            ->orderBy('publish_date', 'DESC')
            ->paginate(20);

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
        return WinkTag::all();
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
            ->with(['tags', 'author'])
            ->first();
        $keywords = $this->getKeyWords($post->excerpt);

        return view('templates.post', compact('post', 'keywords'));
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
}
