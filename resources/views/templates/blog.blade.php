@extends('layouts.post')

@section('content')

    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray text-center text-lg-left text-xl-left">
                <div class="col-12 search text-left d-lg-none">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('posts.search') }}" method="GET">
                                <div class="control-group">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control form-control-fix{{ $errors->has('name') ? ' is-invalid' : '' }}" id="query" name="query" type="text" placeholder="Laravel..." required="required" value="{{ old('query') }}">
                                            <div class="input-group-append">
                                                <input type="submit" class="btn btn-primary" value="{{ trans('page.search') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @include('templates.card', [
                'link' => route('posts.article', ['slug' => $latest->slug]),
                'post' => $latest
            ])
        </div>
    </header>

    @if($posts->isNotEmpty())
        <div class="container blog">
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    @foreach($posts as $post)
                        @if (in_array($loop->iteration, [3, 10, 15]))
                            @production
                                <feed-ad></feed-ad>
                            @endproduction
                        @endif

                        <div class="row blog-divider"></div>

                        @include('templates.card', [
                            'link' => route('posts.article', ['slug' => $post->slug]),
                            'post' => $post,
                            'main' => false
                        ])
                    @endforeach
                </div>
                <div class="col-lg-3 col-xl-3 tags d-none d-lg-block d-xl-block">
                    <div class="card sidebar-search">
                        <div class="card-body">
                            <form action="{{ route('posts.search') }}" method="GET">
                                <div class="control-group">
                                    <div class="form-group">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="query" name="query" type="text" placeholder="{{ trans('page.search') }}" required="required" value="{{ old('query') }}">
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="{{ trans('page.search') }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    @include('templates.tags')
                </div>
            </div>
        </div>
    @else
        @include('templates.empty')
    @endif

    <div class="container mt-4 mb-4">
        <div class="row">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="container mt-4 mb-4"></div>

    @include('templates.footer')

    @include('templates.top-button')
@endsection
