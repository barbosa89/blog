<?php

namespace App\Http\Controllers;

use Wink\WinkTag;
use Wink\Http\Resources\TagsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
