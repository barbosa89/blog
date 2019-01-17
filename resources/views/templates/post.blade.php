@extends('layouts.app')

@section('content')
    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray text-center text-lg-left text-xl-left">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <a href="#" class="text-gray"><img class="img-fluid mb-5" src="{{ url($post->featured_image) }}" alt="{{ $post->title }}"></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-md-center text-lg-left align-items-center">
                    <a href="#" class="text-gray"><h1 class="text-uppercase">{{ $post->title }}</h1></a>
                    <p><i class="fas fa-calendar"></i> {{ $post->created_at->toDateString() }}</p>
                    <a href="#" class="text-gray">
                        <h2 class="font-weight-light mb-4 text-justify">
                            {{ $post->excerpt }}    
                        </h2>
                    </a>
                    <div class="row align-items-end text-primary">
                        <div class="col-4">
                            <a href="hhttps://twitter.com/home?status={{ route('posts.article', ['slug' => $post->slug]) }}">
                                <i class="fab fa-twitter fa-2x"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.article', ['slug' => $post->slug]) }}">
                                <i class="fab fa-facebook fa-2x"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.article', ['slug' => $post->slug]) }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                <i class="fab fa-linkedin fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>   
            <div class="row blog-divider"></div>
        </div>
    </header> 

    <div class="container post text-justify">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-10 offset-lg-1 col-xl-10 offset-xl-1">
                <div class="row">
                    <div class="col-12">
                        <article>
                            {!! $post->body !!}
                        </article>
                    </div>
                </div>
        
                <div class="row mb-4 mt-4"> 
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-center mb-4">
                        <img class="img-fluid" src="{{ url('images/profile.png') }}" alt="">
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6 mb-4">
                        <h5>{{ $post->author->name }}</h5>
                        <div class="text-muted">
                            {!! $post->author->bio !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card" style="width:100%">
                            <div class="card-body">
                                <h5 class="card-title text-muted">@lang('page.share')</h5>
                                <p class="card-text">@lang('page.share_text')</p>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <a class="card-link" href="hhttps://twitter.com/home?status={{ route('posts.article', ['slug' => $post->slug]) }}">
                                            <i class="fab fa-twitter fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="card-link" href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.article', ['slug' => $post->slug]) }}">
                                            <i class="fab fa-facebook fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="card-link" href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.article', ['slug' => $post->slug]) }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                            <i class="fab fa-linkedin fa-2x"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('templates.subscription')

                <div class="mosthead mb-4">
                    <div class="col-12 mt-4 blog-divider">
                        <h4 class="mb-4"><small>@lang('page.related')</small></h4>
                    </div>
        
                    <div class="row blog">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row blog-list mb-2">
                                <div class="col-3">
                                    <a href="#"><img class="img-fluid mb-5" src="{{ url('images/profile.png') }}" alt=""></a>
                                </div>
                                <div class="col-9">
                                    <a href="#"><h3 class="text-uppercase blog-list-title"><small>Optimización de consultas con Eloquent en Laravel</small></h3></a>
                                    <p><i class="fas fa-calendar"></i> <small> 28 de diciembre de 2018</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row blog-list mb-2">
                                <div class="col-3">
                                    <a href="#"><img class="img-fluid mb-5" src="{{ url('images/profile.png') }}" alt=""></a>
                                </div>
                                <div class="col-9">
                                    <a href="#"><h3 class="text-uppercase blog-list-title"><small>Optimización de consultas con Eloquent en Laravel</small></h3></a>
                                    <p><i class="fas fa-calendar"></i> <small> 28 de diciembre de 2018</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
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

    <script async>
    (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://omarbarbosa.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>    
    <script async>
        setTimeout(function(){
            $('#subscription').modal('show')
        }, 20000);
    </script>
@endsection