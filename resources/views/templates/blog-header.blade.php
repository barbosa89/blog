<header class="blog-masthead text-gray">
    <div class="container">
        <div class="row text-gray text-center text-lg-left text-xl-left">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <a href="{{ route('posts.article', ['slug' => $post->slug]) }}" class="text-gray"><img class="img-fluid mb-5" src="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}" alt="{{ $post->title }}"></a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-md-center text-lg-left align-items-center">
                <a href="{{ route('posts.article', ['slug' => $post->slug]) }}" class="text-gray"><h1 class="text-uppercase">{{ $post->title }}</h1></a>
                <p><i class="fas fa-calendar"></i> {{ $post->created_at->toDateString() }}</p>
                <a href="{{ route('posts.article', ['slug' => $post->slug]) }}" class="text-gray">
                    <h2 class="font-weight-light mb-4 text-justify">
                        {{ $post->excerpt }}    
                    </h2>
                </a>
                <div class="row align-items-end">
                    <div class="col-4">
                        <a target="_blank" class="share-link" href="https://twitter.com/home?status={{ route('posts.article', ['slug' => $post->slug]) }}">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                    </div>
                    <div class="col-4">
                        <a target="_blank" class="share-link" href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.article', ['slug' => $post->slug]) }}">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                    </div>
                    <div class="col-4">
                        <a target="_blank" class="share-link" href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('posts.article', ['slug' => $post->slug]) }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>   
        
        @if (isset($divider) and $divider == true)
            <div class="row blog-divider"></div>
        @endif
    </div>
</header> 