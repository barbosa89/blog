@extends('layouts.post')

@section('content')

    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray text-center text-lg-left text-xl-left">
                <div class="col-12 text-md-center text-lg-left align-items-center">
                    <h1 class="text-uppercase">@lang('page.search_results')</h1>
                </div>
                <div class="col-12 search text-left">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('posts.search') }}" method="GET">
                                <div class="control-group">
                                    <div class="form-group">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="query" name="query" type="text" required="required" value="{{ $query }}">
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="{{ trans('page.search') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container blog">
        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                @if ($posts->count() > 0)
                    @foreach($posts as $post)
                        @include('templates.item')
                    @endforeach
                @else
                    <div class="row blog-list align-items-center mb-2">
                        <div class="col-12">
                            <div class="card text-gray">
                                <div class="card-body">
                                    @lang('page.no_results')
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-3 col-xl-3 tags d-none d-lg-block d-xl-block">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tags</h5>
                        <ul class="tag-list">
                            @foreach($tags as $tag)
                                <li><a href="#" class="card-link">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-4">
        <div class="row">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="container mt-4 mb-4"></div>

    @include('templates.footer')

    @include('templates.top-button')
@endsection
