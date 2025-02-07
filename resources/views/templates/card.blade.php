<div class="card mb-3 border-light">
    <div class="row no-gutters">
        <div class="col-md-4">
            <a href="{{ $link }}">
                <img class="w-100 h-100 img-shadow"
                style="object-fit:cover;"
                src="{{ empty($post->image) ? asset('images/article.png') : url($post->image) }}"
                alt="{{ $post->title }}">
            </a>
        </div>
        <div class="col-md-8">
            <div class="card-body p-0 p-lg-4 pt-lg-0 ps-lg-0">
                <a href="{{ $link }}" class="text-gray">
                    @if ($main ?? true)
                        <h1 class="card-title mt-0">{{ $post->title }}</h1>
                    @else
                        <h3 class="card-title mt-0">{{ $post->title }}</h3>
                    @endif
                </a>
                <p class="card-text">
                    {{ Str::finish($post->excerpt, '.') }} <br>
                    <small class="text-muted">@lang('page.date.published'): {{ $post->publishedAt }}</small>
                </p>

                @if ($main ?? false)
                    <div class="row align-items-end text-center">
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://twitter.com/home?status={{ $link }}">
                                <em class="fab fa-twitter fa-2x"></em>
                            </a>
                        </div>
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}">
                                <em class="fab fa-facebook fa-2x"></em>
                            </a>
                        </div>
                        <div class="col-4">
                            <a target="_blank" class="share-link"
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ $link }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source=">
                                <em class="fab fa-linkedin fa-2x"></em>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
