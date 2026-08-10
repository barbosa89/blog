<header class="signal-surface border-b border-rule-dark pt-20" id="home">
    <div class="site-container flex min-h-[clamp(32rem,68svh,42rem)] items-center py-16 sm:py-20 lg:py-24">
        <div class="relative z-10 min-w-0 max-w-3xl">
            <h1 class="max-w-[10ch] font-display text-[clamp(4rem,8vw,6rem)] leading-[0.86] tracking-[-0.03em] text-light">
                @lang('page.landing.hero_title')
            </h1>
            <p class="mt-6 max-w-[38rem] font-data text-xs uppercase tracking-[0.22em] text-signal-cyan">@lang('page.landing.hero_role')</p>
            <p class="mt-5 max-w-[35rem] text-lg leading-relaxed text-light-muted">
                @lang('page.landing.hero_body')
            </p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a class="signal-link signal-link--primary" href="mailto:{{ config('blog.mail') }}">
                    @lang('page.landing.contact_action')
                    <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
                </a>
                <a class="signal-link signal-link--quiet js-scroll-trigger" href="#products">
                    @lang('page.landing.work_action')
                </a>
            </div>
        </div>
    </div>
</header>
