<section class="border-y border-rule-dark bg-steel py-20 text-light sm:py-28" id="contact">
    <div class="site-container grid gap-10 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
        <div>
            <h2 class="max-w-[11ch] text-[clamp(3.5rem,8vw,6rem)] leading-[0.92] text-light">{{ trans('page.landing.contact_title') }}</h2>
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-light-muted">{{ trans('page.landing.contact_intro') }}</p>
        </div>
        <div class="flex flex-col items-start gap-3 lg:items-stretch">
            <a class="catalog-action catalog-action--primary" href="mailto:{{ config('blog.mail') }}">
                {{ trans('page.landing.email_action') }}
                <i data-lucide="mail" class="h-4 w-4" aria-hidden="true"></i>
            </a>
            <a class="catalog-action catalog-action--quiet-dark" href="{{ config('blog.links.linkedin') }}" target="_blank" rel="noopener noreferrer">
                {{ trans('page.landing.linkedin_action') }}
                <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>
