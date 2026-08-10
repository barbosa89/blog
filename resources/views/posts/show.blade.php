@extends('layouts.post')

@section('title', $post->title)

@section('head')
    @php
        $socialImage = empty($post->image) ? asset('images/article.png') : asset($post->image);
    @endphp
    <link rel="canonical" href="{{ route('posts.show', ['slug' => $post->slug]) }}">
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords" content="{{ $post->keywords }}">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('posts.show', ['slug' => $post->slug]) }}">
    <meta property="og:site_name" content="{{ config('blog.author') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:src" content="{{ $socialImage }}">
    <meta name="twitter:site" content="{{ config('blog.links.twitter.nickname') }}">
    <meta name="twitter:url" content="{{ route('posts.show', ['slug' => $post->slug]) }}">
@endsection

@section('content')
    @php
        $articleUrl = route('posts.show', ['slug' => $post->slug]);
        $imageUrl = empty($post->image) ? asset('images/article.png') : asset($post->image);
    @endphp

    <header class="surface-light border-b border-rule-light pb-10 pt-32 sm:pb-14 sm:pt-40">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-end">
                <div class="min-w-0">
                    <a class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted underline-offset-4 hover:text-ink hover:underline" href="{{ route('posts.index') }}">@lang('page.technical.archive')</a>
                    <h1 class="mt-5 max-w-[18ch] whitespace-normal text-[clamp(2.75rem,7vw,6rem)] leading-[0.94] text-ink">{{ $post->title }}</h1>
                    <p class="mt-6 max-w-3xl whitespace-normal text-lg leading-relaxed text-ink-muted sm:text-xl">{{ $post->excerpt }}</p>
                </div>
                <dl class="border-l border-t border-rule-light font-data text-xs uppercase tracking-[0.12em] text-ink-muted">
                    <div class="border-b border-r border-rule-light p-4">
                        <dt>@lang('page.date.published')</dt>
                        <dd class="mt-1 text-ink">{{ $post->publishedAt }}</dd>
                    </div>
                    <div class="border-b border-r border-rule-light p-4">
                        <dt>@lang('page.author')</dt>
                        <dd class="mt-1 text-ink">{{ $post->author->name }}</dd>
                    </div>
                    <div class="border-b border-r border-rule-light p-4">
                        <dt>@lang('page.locale')</dt>
                        <dd class="mt-1 text-ink">{{ strtoupper($post->locale) }}</dd>
                    </div>
                </dl>
            </div>

            <img class="mt-10 aspect-[16/7] w-full border border-rule-light object-cover" src="{{ $imageUrl }}" alt="" fetchpriority="high">
        </div>
    </header>

    <div class="surface-light pb-20 sm:pb-28">
        <div class="site-container grid gap-12 pt-12 lg:grid-cols-[minmax(0,1fr)_17rem] lg:gap-16">
            <main class="min-w-0">
                <article class="post-content">
                    {!! $post->content !!}
                </article>

                @production
                    <div class="my-10 border-y border-rule-light py-4">
                        <article-ad></article-ad>
                    </div>
                @endproduction

                <section class="mt-14 grid gap-7 border-y border-rule-light py-8 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center" aria-labelledby="author-title">
                    <div class="flex items-start gap-5">
                        <img class="h-20 w-20 border border-rule-light object-cover" src="{{ asset('images/me.webp') }}" alt="{{ $post->author->name }}" loading="lazy">
                        <div>
                            <p class="font-data text-xs uppercase tracking-[0.16em] text-ink-muted">@lang('page.author')</p>
                            <h2 id="author-title" class="mt-1 text-3xl text-ink">{{ $post->author->name }}</h2>
                            <p class="mt-2 max-w-xl whitespace-normal text-ink-muted">@lang('page.me_short')</p>
                        </div>
                    </div>
                    <a class="signal-link signal-link--quiet" href="mailto:{{ config('blog.mail') }}">@lang('page.contact_me')</a>
                </section>

                @if ($related->isNotEmpty())
                    <section class="mt-14" aria-labelledby="related-title">
                        <h2 id="related-title" class="text-4xl text-ink">@lang('page.related')</h2>
                        <div class="mt-5 border-t border-rule-light">
                            @foreach ($related as $relatedPost)
                                <a class="grid gap-3 border-b border-rule-light py-5 text-ink sm:grid-cols-[7rem_minmax(0,1fr)]" href="{{ route('posts.show', ['slug' => $relatedPost->slug]) }}">
                                    <span class="font-data text-xs text-ink-muted">{{ $relatedPost->publishedAt }}</span>
                                    <span class="whitespace-normal font-display text-2xl font-bold leading-tight underline-offset-4 hover:underline">{{ $relatedPost->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="space-y-8 lg:sticky lg:top-28 lg:self-start">
                <section class="border-t border-rule-light pt-4" aria-labelledby="share-title">
                    <h2 id="share-title" class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted">@lang('page.share')</h2>
                    <p class="mt-3 whitespace-normal text-sm text-ink-muted">@lang('page.share_text')</p>
                    <div class="mt-4 grid grid-cols-3 border-l border-t border-rule-light">
                        <a class="flex min-h-12 items-center justify-center border-b border-r border-rule-light text-ink hover:bg-paper-raised" aria-label="{{ trans('page.accessibility.share_x') }}" href="https://twitter.com/intent/tweet?url={{ urlencode($articleUrl) }}" target="_blank" rel="noopener noreferrer"><i data-lucide="send" class="h-4 w-4" aria-hidden="true"></i></a>
                        <a class="flex min-h-12 items-center justify-center border-b border-r border-rule-light text-ink hover:bg-paper-raised" aria-label="{{ trans('page.accessibility.share_facebook') }}" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($articleUrl) }}" target="_blank" rel="noopener noreferrer"><i data-lucide="share-2" class="h-4 w-4" aria-hidden="true"></i></a>
                        <a class="flex min-h-12 items-center justify-center border-b border-r border-rule-light text-ink hover:bg-paper-raised" aria-label="{{ trans('page.accessibility.share_linkedin') }}" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($articleUrl) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer"><i data-lucide="briefcase-business" class="h-4 w-4" aria-hidden="true"></i></a>
                    </div>
                </section>

                @include('partials.tags', ['tags' => collect($post->tags), 'border' => false])
            </aside>
        </div>
    </div>

    @include('partials.footer')
    @include('partials.top-button')
@endsection

@section('scripts')
    <script type="application/ld+json" async>
        {
            "@@context": "https://schema.org",
            "@type": "Article",
            "headline": @json($post->title),
            "url": @json($articleUrl),
            "image": @json($imageUrl),
            "description": @json($post->excerpt),
            "datePublished": @json($post->publishedAt),
            "author": { "@type": "Person", "name": @json($post->author->name) }
        }
    </script>
@endsection
