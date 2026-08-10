<section class="signal-surface border-y border-rule-dark py-20 sm:py-28" id="about">
    <div class="site-container grid gap-12 lg:grid-cols-[minmax(18rem,0.75fr)_minmax(0,1.25fr)] lg:gap-20">
        <div>
            <h2 class="section-heading text-light">@lang('page.landing.experience_title')</h2>
            <p class="mt-6 max-w-lg text-lg leading-relaxed text-light-muted">@lang('page.landing.experience_intro')</p>
            <a class="signal-link signal-link--quiet mt-7" href="{{ config('blog.links.github') }}" target="_blank" rel="noopener noreferrer">
                @lang('page.code')
                <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
            </a>
        </div>

        <ol class="border-l border-t border-rule-dark">
            @foreach (['backend', 'frontend', 'data', 'open_source'] as $capability)
                <li class="grid gap-4 border-b border-r border-rule-dark p-5 sm:grid-cols-[4rem_minmax(0,1fr)] sm:p-7">
                    <span class="font-data text-xs text-track-yellow">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <p class="whitespace-normal text-lg leading-relaxed text-light">{{ trans('page.landing.capability_'.$capability) }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
