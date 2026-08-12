@php
    $isPostShow = request()->routeIs('posts.show');
    $imageUrl = empty($post->image) ? asset('images/article.png') : url($post->image);
@endphp

<article class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-xl">
    <div class="grid gap-0 md:grid-cols-12">
        <div class="md:col-span-4">
            @if ($isPostShow)
                <img
                    class="h-full min-h-[220px] w-full object-cover img-shadow"
                    src="{{ $imageUrl }}"
                    alt="{{ $post->title }}"
                >
            @else
                <a href="{{ $link }}" class="block focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400">
                    <img
                        class="h-full min-h-[220px] w-full object-cover img-shadow"
                        src="{{ $imageUrl }}"
                        alt="{{ $post->title }}"
                    >
                </a>
            @endif
        </div>

        <div class="md:col-span-8">
            <div class="flex h-full flex-col gap-4 p-5 sm:p-6">
                @if ($isPostShow)
                    @include('partials.title')
                @else
                    <a href="{{ $link }}" class="text-gray transition hover:text-emerald-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400">
                        @include('partials.title')
                    </a>
                @endif

                <p class="text-base leading-relaxed text-slate-700 sm:text-lg">
                    {{ Str::of($post->excerpt)->trim()->finish('.') }}
                    <span class="mt-2 block text-sm text-slate-500">{{ trans('page.date.published') }}: {{ $post->publishedAt }}</span>
                </p>

                @if ($main ?? false)
                    <div class="mt-auto border-t border-slate-200 pt-4">
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <a
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ trans('page.accessibility.share_x') }}"
                                class="inline-flex items-center justify-center rounded-xl p-3 text-emerald-700 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                                href="https://twitter.com/intent/tweet?url={{ $link }}"
                            >
                                <i data-lucide="send" class="h-6 w-6"></i>
                            </a>
                            <a
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ trans('page.accessibility.share_facebook') }}"
                                class="inline-flex items-center justify-center rounded-xl p-3 text-emerald-700 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}"
                            >
                                <i data-lucide="share-2" class="h-6 w-6"></i>
                            </a>
                            <a
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ trans('page.accessibility.share_linkedin') }}"
                                class="inline-flex items-center justify-center rounded-xl p-3 text-emerald-700 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ $link }}&title={{ $post->title }}&summary={{ $post->excerpt }}&source="
                            >
                                <i data-lucide="briefcase-business" class="h-6 w-6"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</article>
