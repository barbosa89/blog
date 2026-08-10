<section class="surface-light py-20 sm:py-28" id="writing">
    <div class="site-container">
        <div class="grid gap-6 border-b border-rule-light pb-10 md:grid-cols-[minmax(0,0.75fr)_minmax(18rem,1fr)] md:items-end">
            <div>
                <h2 class="section-heading text-ink">@lang('page.landing.writing_title')</h2>
            </div>
            <p class="section-intro md:justify-self-end">@lang('page.landing.writing_intro')</p>
        </div>

        <div class="mt-7">
            @foreach ($latestPosts as $post)
                @php
                    $imageUrl = empty($post->image) ? asset('images/article.png') : asset($post->image);
                @endphp
                <article class="article-row">
                    <img class="article-row__image" src="{{ $imageUrl }}" alt="" loading="lazy">
                    <div class="min-w-0">
                        <p class="font-data text-xs text-ink-muted">{{ $post->publishedAt }} / {{ strtoupper($post->locale) }}</p>
                        <h3 class="mt-2 text-3xl leading-none text-ink sm:text-4xl">
                            <a class="whitespace-normal underline-offset-4 hover:underline" href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="mt-3 max-w-3xl whitespace-normal leading-relaxed text-ink-muted">{{ $post->excerpt }}</p>
                    </div>
                    <a class="signal-link signal-link--quiet self-center" href="{{ route('posts.show', ['slug' => $post->slug]) }}">@lang('page.landing.read_article')</a>
                </article>
            @endforeach
        </div>

        <a class="signal-link signal-link--quiet mt-8" href="{{ route('posts.index') }}">
            @lang('page.landing.all_articles')
            <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
        </a>
    </div>
</section>
