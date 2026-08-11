<section class="surface-light py-18 sm:py-24" id="writing">
    <div class="site-container">
        <div class="grid gap-6 border-b border-rule-light pb-8 md:grid-cols-[minmax(0,0.9fr)_minmax(18rem,1.1fr)] md:items-end">
            <h2 class="section-heading text-ink">@lang('page.landing.writing_title')</h2>
            <div class="md:justify-self-end">
                <p class="section-intro">@lang('page.landing.writing_intro')</p>
                <a class="mt-4 inline-flex items-center gap-2 font-data text-xs uppercase tracking-[0.14em] text-ink underline-offset-4 hover:text-signal-cyan hover:underline" href="{{ route('posts.index') }}">
                    @lang('page.landing.all_articles')
                    <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="journal-list">
            @foreach ($latestPosts as $post)
                <article>
                    <a class="journal-entry group" href="{{ route('posts.show', ['slug' => $post->slug]) }}">
                        <span class="font-data text-xs uppercase leading-relaxed tracking-[0.1em] text-ink-muted">
                            {{ $post->publishedAt }}<br>{{ strtoupper($post->locale) }}
                        </span>
                        <span class="min-w-0">
                            <span class="block font-display text-3xl font-bold leading-none text-ink group-hover:underline sm:text-4xl">{{ $post->title }}</span>
                            <span class="mt-3 block max-w-3xl leading-relaxed text-ink-muted">{{ $post->excerpt }}</span>
                        </span>
                        <i data-lucide="arrow-right" class="h-5 w-5 text-ink transition-colors group-hover:text-signal-cyan" aria-hidden="true"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
