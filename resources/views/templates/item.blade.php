<div class="row blog-divider"></div>
<div class="row blog-list align-items-center mb-2">
    <div class="col-lg-2 col-xl-2 d-none d-lg-block d-xl-block">
        <a href="{{ route('posts.article', ['slug' => $post->slug]) }}">
            <img class="img-fluid mb-5" src="{{ empty($post->featured_image) ? asset('images/article.png') : url($post->featured_image) }}" alt="{{ $post->excerpt }}">
        </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 align-items-center">
        <a href="{{ route('posts.article', ['slug' => $post->slug]) }}">
            <h2 class="text-uppercase blog-list-title">{{ $post->title }}</h2>
        </a>
        <p class="text-muted">
            <i class="fas fa-calendar"></i> {{ $post->created_at->toDateString() }}
        </p>
        <a href="{{ route('posts.article', ['slug' => $post->slug]) }}">
            <h3 class="font-weight-light mb-4 blog-description">
                {{ empty($post->excerpt) ? trans('page.no_excerpt') : $post->excerpt }}
            </h3>
        </a>
    </div>
</div>
