@extends('layouts.post')

@section('content')

    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray">
                <div class="col-12 col-lg-3 ms-auto offset-lg-6 search text-start">
                    <form action="{{ route('posts.search') }}" method="GET">
                        <div class="control-group">
                            <div class="input-group">
                                <input
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="query"
                                    name="query"
                                    type="search"
                                    placeholder="{{ trans('page.search') }}"
                                    required="required"
                                    value="{{ old('query') }}">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
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
            <div class="row mt-3">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    @foreach($posts as $post)
                        @if (in_array($loop->iteration, [3, 10, 15]))
                            @production
                                <ads-feed></ads-feed>
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
                    @include('templates.tags', ['border' => true])
                </div>
            </div>
        </div>
    @else
        @include('templates.empty')
    @endif

    <div class="container mt-4 mb-4"></div>

    @include('templates.footer')

    @include('templates.top-button')
@endsection
