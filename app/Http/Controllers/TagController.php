<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Wink\Http\Resources\TagsResource;
use Wink\WinkTag;

class TagController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $entries = WinkTag::when(request()->has('search'), function ($q) {
            $q->where('name', 'LIKE', '%'.request('search').'%');
        })
            ->orderBy('created_at', 'DESC')
            ->withCount('posts')
            ->get(['id', 'slug', 'name', 'created_at', 'updated_at', 'meta']);

        return TagsResource::collection($entries);
    }
}
