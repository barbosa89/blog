@extends('layouts.post')

@section('title', trans('page.navigation.writing').' · '.config('blog.author'))

@section('content')
    <header class="surface-light border-b border-rule-light pb-12 pt-32 sm:pb-16 sm:pt-40">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,0.8fr)_minmax(22rem,1.2fr)] lg:items-end">
                <div>
                    <h1 class="text-[clamp(4rem,9vw,6rem)] leading-[0.9] text-ink">@lang('page.navigation.writing')</h1>
                    <p class="mt-4 font-data text-xs uppercase tracking-[0.2em] text-ink-muted">@lang('page.technical.archive')</p>
                    <p class="mt-4 max-w-lg text-lg leading-relaxed text-ink-muted">@lang('page.blog_intro')</p>
                </div>

                <form action="{{ route('posts.index') }}" method="GET" role="search" class="border border-rule-light bg-paper-raised p-3 sm:p-4">
                    <label class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted" for="query">@lang('page.search')</label>
                    <div class="mt-3 flex items-stretch border border-rule-light bg-paper">
                        <input
                            class="min-h-14 min-w-0 flex-1 bg-transparent px-4 text-lg text-ink outline-none placeholder:text-ink-muted"
                            id="query"
                            name="query"
                            type="search"
                            placeholder="{{ trans('page.search_help') }}"
                            value="{{ request()->query('query') }}"
                        >
                        <button type="submit" aria-label="{{ trans('page.search') }}" class="catalog-button min-w-14 border-0 border-l border-rule-light bg-vacuum px-0 text-light">
                            <i data-lucide="search" class="h-5 w-5" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm text-ink-muted">@lang('page.search_help')</p>
                        <div class="flex items-center gap-2">
                            @if (request()->filled('query'))
                                <a class="text-sm font-semibold text-ink underline underline-offset-4" href="{{ route('posts.index') }}">@lang('page.clear_search')</a>
                            @endif
                            @php
                                $localeItems = [
                                    ['label' => trans('page.spanish'), 'url' => route('locale', 'es')],
                                    ['label' => trans('page.english'), 'url' => route('locale', 'en')],
                                ];
                            @endphp
                            <locale-switcher :label='@json(trans("page.locale"))' :items='@json($localeItems)'></locale-switcher>
                        </div>
                    </div>
                </form>
            </div>

            @isset($tag)
                <div class="mt-10 border border-rule-light bg-paper-raised px-5 py-4">
                    <p class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted">@lang('page.tag')</p>
                    <p class="mt-1 text-3xl font-semibold text-ink">{{ $tag }}</p>
                </div>
            @endisset

            @if (request()->filled('query'))
                <p class="mt-10 font-data text-sm uppercase tracking-[0.14em] text-ink-muted">{{ trans('page.results_for', ['query' => request()->query('query')]) }}</p>
            @endif
        </div>
    </header>

    <div class="surface-light pb-20 sm:pb-28">
        <div class="site-container grid gap-12 pt-10 lg:grid-cols-[minmax(0,1fr)_17rem] lg:gap-16">
            <div class="min-w-0">
                @isset($latest)
                    @php
                        $latestImage = empty($latest->image) ? asset('images/article.png') : asset($latest->image);
                    @endphp
                    <article class="grid gap-6 border-b border-rule-light pb-10 md:grid-cols-[minmax(16rem,0.8fr)_minmax(0,1.2fr)] md:items-center">
                        <a class="block min-w-0 border border-rule-light" href="{{ route('posts.show', ['slug' => $latest->slug]) }}">
                            <img class="aspect-[4/3] h-full w-full object-cover" src="{{ $latestImage }}" alt="" fetchpriority="high">
                        </a>
                        <div class="min-w-0">
                            <p class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted">@lang('page.latest_article') / {{ $latest->publishedAt }}</p>
                            <h2 class="mt-3 text-4xl leading-none text-ink sm:text-5xl">
                                <a class="whitespace-normal underline-offset-4 hover:underline" href="{{ route('posts.show', ['slug' => $latest->slug]) }}">{{ $latest->title }}</a>
                            </h2>
                            <p class="mt-5 whitespace-normal text-lg leading-relaxed text-ink-muted">{{ $latest->excerpt }}</p>
                            <a class="catalog-action catalog-action--quiet-light mt-6" href="{{ route('posts.show', ['slug' => $latest->slug]) }}">@lang('page.landing.read_article')</a>
                        </div>
                    </article>
                @endisset

                @forelse ($posts as $post)
                    @production
                        @if ($loop->iteration % 5 === 0)
                            <feed-ad></feed-ad>
                        @endif
                    @endproduction

                    @php
                        $imageUrl = empty($post->image) ? asset('images/article.png') : asset($post->image);
                    @endphp
                    <article class="article-row">
                        <img class="article-row__image" src="{{ $imageUrl }}" alt="" loading="lazy">
                        <div class="min-w-0">
                            <p class="font-data text-xs text-ink-muted">{{ $post->publishedAt }} / {{ strtoupper($post->locale) }}</p>
                            <h2 class="mt-2 text-3xl leading-none text-ink sm:text-4xl">
                                <a class="whitespace-normal underline-offset-4 hover:underline" href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                            </h2>
                            <p class="mt-3 whitespace-normal leading-relaxed text-ink-muted">{{ $post->excerpt }}</p>
                        </div>
                        <a class="catalog-action catalog-action--quiet-light self-center" href="{{ route('posts.show', ['slug' => $post->slug]) }}">@lang('page.landing.read_article')</a>
                    </article>
                @empty
                    @unless(isset($latest))
                        @include('partials.empty')
                    @endunless
                @endforelse
            </div>

            <div>
                @include('partials.tags', ['border' => true])
            </div>
        </div>
    </div>

    @include('partials.footer')
    @include('partials.top-button')
@endsection
