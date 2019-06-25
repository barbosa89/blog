@extends('layouts.post')

@section('content')

    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray text-center text-lg-left text-xl-left">
                <div class="col-12 text-md-center text-lg-left align-items-center">
                    <h3 class="text-uppercase">@lang('page.tag_search'): <small>{{ $tag }}</small></h3>
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
                @include('templates.tags')
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
