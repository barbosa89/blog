@extends('layouts.post')

@section('content')

<!-- Header -->
<header class="blog-masthead text-gray">
    <div class="container">
        <div class="row text-gray mt-3 mt-lg-2">
            <div class="col-12 col-lg-4 ms-auto offset-lg-8 search text-start">
                <form action="{{ route('posts.index') }}" method="GET">
                    <div class="control-group">
                        <div class="input-group">
                            <input class="form-control border-dark-subtle" id="query"
                                name="query" type="search" placeholder="{{ trans('page.search') }}" required="required"
                                value="{{ request()->query('query') }}">
                            <button type="submit" class="btn btn-light border-1 border-dark-subtle"><i class="bi bi-search"></i></button>
                            @if (request()->has('query'))
                                <a href="{{ route('posts.index') }}" class="btn btn-light border-1 border-dark-subtle text-dark">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                            <button
                                class="btn btn-primary dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ trans('page.locale') }}</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item text-dark" href="{{ route('locale', 'es') }}">{{ trans('page.spanish') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-dark" href="{{ route('locale', 'en') }}">{{ trans('page.english') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @isset ($latest)
            <div class="row g-0">
                <div class="col">
                    <span class="badge bg-danger fs-md rounded-0 rounded-top">{{ trans('page.latest_article') }}</span>
                </div>
            </div>

            @include('templates.card', [
                'link' => route('posts.show', ['slug' => $latest->slug]),
                'post' => $latest
            ])
        @endisset

        @isset($tag)
            <div class="row g-0">
                <div class="col">
                    <span>{{ trans('page.tag') }}</span>
                    <h1>{{ $tag }}</h1>
                </div>
            </div>
        @endisset
    </div>
</header>

@if($posts->isNotEmpty() || isset($latest))
    <div class="container blog">
        <div class="row mt-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                @foreach($posts as $post)
                    @production
                        @if ($loop->iteration % 5 === 0)
                            <feed-ad></feed-ad>
                        @endif
                    @endproduction

                    <div class="row blog-divider"></div>

                    @include('templates.card', [
                        'link' => route('posts.show', ['slug' => $post->slug]),
                        'post' => $post,
                        'main' => false
                    ])
                @endforeach
            </div>

            @if($posts->isNotEmpty())
                <div class="col-lg-3 col-xl-3 tags d-none d-lg-block d-xl-block">
                    @include('templates.tags', ['border' => true])
                </div>
            @endif
        </div>
    </div>
@else
    @include('templates.empty')
@endif

<div class="container mt-4 mb-4"></div>

@include('templates.footer')

@include('templates.top-button')
@endsection