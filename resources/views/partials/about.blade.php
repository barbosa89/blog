<section class="logbook-note border-y border-rule-dark py-18 sm:py-24" id="about">
    <div class="site-container grid gap-10 lg:grid-cols-[minmax(18rem,0.75fr)_minmax(0,1.25fr)] lg:gap-20">
        <div>
            <h2 class="section-heading text-light">@lang('page.landing.about_title')</h2>
            <p class="mt-6 max-w-lg text-lg leading-relaxed text-light-muted">@lang('page.landing.about_intro')</p>
        </div>

        <div class="border-t border-rule-dark pt-7">
            <p class="max-w-3xl text-lg leading-relaxed text-light">@lang('page.landing.about_body')</p>
            <p class="mt-5 max-w-3xl leading-relaxed text-light-muted">@lang('page.landing.about_detail')</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="catalog-action catalog-action--quiet-dark" href="{{ config('blog.links.github') }}" target="_blank" rel="noopener noreferrer">
                    @lang('page.navigation.code')
                    <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
                </a>
                <a class="catalog-action catalog-action--quiet-dark" href="mailto:{{ config('blog.mail') }}">
                    @lang('page.email')
                    <i data-lucide="mail" class="h-4 w-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>
