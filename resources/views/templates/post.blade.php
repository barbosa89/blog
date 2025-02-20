@extends('layouts.post')

@section('title', $post->title)

@section('head')

    <link rel="canonical" href="{{ route('posts.show', ['slug' => $post->slug]) }}">
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords" content="{{ $post->keywords }}">
    <meta name="author" content="{{ config('blog.author') }}">

    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image"
        content="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('posts.show', ['slug' => $post->slug]) }}">
    <meta property="og:site_name" content="{{ config('blog.author') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:src"
        content="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}">
    <meta name="twitter:site" content="{{ config('blog.links.twitter.nickname') }}">
    <meta name="twitter:url" content="{{ route('posts.show', ['slug' => $post->slug]) }}">

@endsection

@section('content')
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('templates.card', [
                        'link' => route('posts.show', ['slug' => $post->slug]),
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
                                            href="https://twitter.com/intent/tweet?url={{ route('posts.show', ['slug' => $post->slug]) }}">
                                            <em class="bi bi-twitter-x fs-lg"></em>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a target="_blank" class="card-link"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.show', ['slug' => $post->slug]) }}">
                                            <em class="bi bi-facebook fs-lg"></em>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a target="_blank" class="card-link"
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.show', ['slug' => $post->slug]) }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                            <em class="bi bi-linkedin fs-lg"></em>
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

                @if ($related->isNotEmpty())
                    <div class="mb-4">
                        <p class="mb-4 font-weight-bold">
                            {{ trans('page.related') }}
                        </p>
                        <div class="row blog">
                            @foreach ($related as $relatedPost)
                                <div @class([
                                    'col-12 col-sm-12 col-md-6 blog-list mb-4',
                                    'text-md-end' => !$loop->first
                                ])>
                                <a href="{{ route('posts.show', ['slug' => $relatedPost->slug]) }}">
                                    <h4 class="text-uppercase blog-list-title">
                                        <small>{{ $relatedPost->title }}</small>
                                    </h4>
                                </a>
                                <p>
                                    <em class="bi bi-calendar"></em>
                                    <small> {{ $relatedPost->publishedAt }}</small>
                                </p>
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
                s.src = "{{ config('blog.disqus.url') }}";
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
            "url": "{{ route('posts.show', ['slug' => $post->slug]) }}",
            "image": "{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}",
            "description": "{{ $post->excerpt }}"
        }
    </script>
@endsection
