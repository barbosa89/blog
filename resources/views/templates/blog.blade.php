@extends('layouts.app')

@section('content')
    <!-- Header -->
    <header class="blog-masthead bg-primary text-white">
        <div class="container">
            <div class="row text-center text-lg-left text-xl-left">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <a href="{{ route('posts.article', ['slug' => $latest->slug]) }}"><img class="img-fluid mb-5" src="{{ url($latest->featured_image) }}" alt="{{ $latest->title }}"></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-md-center text-lg-left align-items-center">
                        <a href="{{ route('posts.article', ['slug' => $latest->slug]) }}" class="text-white"><h1 class="text-uppercase">{{ $latest->title }}</h1></a>
                        <p><i class="fas fa-calendar"></i> {{ $latest->created_at->toDateString() }}</p>
                            <a href="{{ route('posts.article', ['slug' => $latest->slug]) }}" class="text-white">
                        <h2 class="font-weight-light mb-4 text-justify">
                            {{ $latest->excerpt }}
                        </h2>
                    </a>
                    <div class="row align-items-end">
                        <div class="col-4">
                            <a href="hhttps://twitter.com/home?status={{ route('posts.article', ['slug' => $latest->slug]) }}">
                                <i class="fab fa-twitter fa-2x"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.article', ['slug' => $latest->slug]) }}">
                                <i class="fab fa-facebook fa-2x"></i>
                            </a>
                        </div>
                        <div class="col-4">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.article', ['slug' => $latest->slug]) }}&title={{ $latest->title }}&summary={{ $latest->excerpt }}&source=">
                                <i class="fab fa-linkedin fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </header> 

    @if($posts->count() > 0)
        <div class="container blog">
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    @foreach($posts as $post)
                        @if($loop->first)
                            @include('templates.item')
                        @else
                            <div class="row blog-divider"></div>
                            @include('templates.item')
                        @endif
                    @endforeach
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