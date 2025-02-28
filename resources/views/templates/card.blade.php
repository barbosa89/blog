<div class="card mb-3 border-0">
    <div class="row no-gutters">
        <div class="col-md-4">
            @if (request()->routeIs('posts.show'))
                <img class="w-100 h-100 img-shadow"
                    style="object-fit:cover;"
                    src="{{ empty($post->image) ? asset('images/article.png') : url($post->image) }}"
                    alt="{{ $post->title }}">
            @else
                <a href="{{ $link }}">
                    <img class="w-100 h-100 img-shadow"
                        style="object-fit:cover;"
                        src="{{ empty($post->image) ? asset('images/article.png') : url($post->image) }}"
                        alt="{{ $post->title }}">
                </a>
            @endif
        </div>
        <div class="col-md-8">
            <div class="card-body p-0 p-lg-4 pt-lg-0 ps-lg-0">
                @if (request()->routeIs('posts.show'))
                    @include('templates.title')
                @else
                    <a href="{{ $link }}" class="text-gray">
                        @include('templates.title')
                    </a>
                @endif
                <p class="card-text fs-md">
                    {{ Str::of($post->excerpt)->trim()->finish('.') }} <br>
                    <small class="text-muted">@lang('page.date.published'): {{ $post->publishedAt }}</small>
                </p>

                @if ($main ?? false)
                    <div class="row align-items-end text-center">
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://twitter.com/intent/tweet?url={{ $link }}">
                                <em class="bi bi-twitter-x fs-lg"></em>
                            </a>
                        </div>
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}">
                                <em class="bi bi-facebook fs-lg"></em>
                            </a>
                        </div>
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ $link }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                <em class="bi bi-linkedin fs-lg"></em>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
