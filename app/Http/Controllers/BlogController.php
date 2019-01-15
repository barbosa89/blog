<?php

namespace App\Http\Controllers;

use Wink\WinkTag;
use Wink\WinkPost;
use Wink\WinkAuthor;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = WinkPost::with(['tags', 'author'])
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->get();

        return view('templates.blog', compact('posts'));
    }
}
