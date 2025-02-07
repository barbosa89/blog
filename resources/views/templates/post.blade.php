@extends('layouts.post')

@section('title', $post->title)

@section('head')

    <link rel="canonical" href="{{ route('posts.article', ['slug' => $post->slug]) }}">
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="Omar Barbosa">

    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image"
        content="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('posts.article', ['slug' => $post->slug]) }}">
    <meta property="og:site_name" content="Omar Barbosa">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:src"
        content="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}">
    <meta name="twitter:site" content="@Omar_Andres_Bar">
    <meta name="twitter:url" content="{{ route('posts.article', ['slug' => $post->slug]) }}">

@endsection

@section('content')

    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('templates.card', [
                        'link' => route('posts.article', ['slug' => $post->slug]),
                        'main' => true
                    ])

                    <hr>
                </div>
            </div>
        </div>
    </header>

    <div class="container post text-justify">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-10 offset-lg-1 col-xl-10 offset-xl-1">
                <div class="row">
                    <div class="col-12">
                        <article>
                            {!! $post->content !!}
                        </article>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-center mb-4">
                        <img class="img-fluid rounded-circle img-shadow" src="{{ url('images/me.webp') }}" alt="">
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6 mb-4">
                        <h5 class="fs-2 mb-0">{{ $post->author->name }}</h5>
                        <div class="text-muted">
                            @lang('page.me_short')
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card w-100 shadow">
                            <div class="card-body">
                                <h5 class="card-title text-muted">@lang('page.share')</h5>
                                <p class="card-text">@lang('page.share_text')</p>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <a target="_blank" class="card-link"
                                            href="https://twitter.com/home?status={{ route('posts.article', ['slug' => $post->slug]) }}">
                                            <em class="fab fa-twitter fa-2x"></em>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a target="_blank" class="card-link"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.article', ['slug' => $post->slug]) }}">
                                            <em class="fab fa-facebook fa-2x"></em>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a target="_blank" class="card-link"
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.article', ['slug' => $post->slug]) }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                            <em class="fab fa-linkedin fa-2x"></em>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-12">
                        @include('templates.tags', ['tags' => $post->tags, 'border' => false])
                    </div>
                </div>

                @include('templates.subscription')

                @if ($relateds->isNotEmpty())
                    <div class="mosthead mb-4">
                        <h3 class="mb-4 font-weight-bold"><small>@lang('page.related')</small></h3>
                        <div class="row blog">
                            @foreach ($relateds as $related)
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="row blog-list mb-2">
                                        <div class="col-10">
                                            <a href="{{ route('posts.article', ['slug' => $related->slug]) }}">
                                                <h4 class="text-uppercase blog-list-title">
                                                    <small>{{ $related->title }}</small>
                                                </h4>
                                            </a>
                                            <p>
                                                <em class="fas fa-calendar"></em>
                                                <small> {{ $related->created_at->toDateString() }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer')

    @include('templates.top-button')

@endsection

@section('scripts')
    @production
        <script async>
            (function() {
                var d = document,
                    s = d.createElement('script');
                s.src = 'https://omarbarbosa.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
    @endproduction
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
            Disqus.</a></noscript>
    <script async>
        setTimeout(function() {
            document.getElementById('subscription').classList.add('show');
        }, 20000);
    </script>
    <script type="application/ld+json" async>
        {
            "@context": "http://schema.org/",
            "@type": "WebSite",
            "name": "{{ $post->title }}",
            "alternateName": "{{ $post->title }}",
            "url": "{{ route('posts.article', ['slug' => $post->slug]) }}",
            "image": "{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}",
            "description": "{{ $post->excerpt }}"
        }
    </script>
@endsection
