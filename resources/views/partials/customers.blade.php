<section class="surface-light border-b border-rule-light py-12 sm:py-16" id="customers">
    <div class="site-container">
        <div class="flex flex-wrap items-end justify-between gap-4 border-b border-rule-light pb-5">
            <h2 class="font-display text-3xl leading-none text-ink sm:text-4xl">{{ trans('page.landing.customers_title') }}</h2>
            <p class="max-w-[58ch] text-sm leading-relaxed text-ink-muted sm:text-base">{{ trans('page.landing.customers_intro') }}</p>
        </div>

        <ul class="customer-register grid grid-cols-2 border-l border-t border-rule-light lg:grid-cols-5">
            @foreach ($customers as $customer)
                <li class="min-w-0 border-b border-r border-rule-light">
                    <a
                        class="customer-mark group"
                        href="{{ $customer['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="{{ trans('page.landing.customer_site', ['customer' => $customer['title']]) }}"
                    >
                        <span class="customer-mark__logo">
                            <img src="{{ asset($customer['image']) }}" alt="" width="220" height="128" loading="lazy" decoding="async">
                        </span>
                        <span class="customer-mark__name">{{ $customer['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
