<?php

namespace App\Http\Controllers;

use Wink\WinkTag;
use Wink\WinkPost;
use Wink\WinkAuthor;
use App\Helpers\Fields;
use Illuminate\Http\Request;
use App\Helpers\Input;

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

        return view('templates.post', compact('post'));
    }
}
