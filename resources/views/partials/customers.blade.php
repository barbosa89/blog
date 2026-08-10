<section class="signal-surface border-y border-rule-dark py-20 sm:py-28" id="customers">
    <div class="site-container">
        <div class="grid gap-6 border-b border-rule-dark pb-10 md:grid-cols-[minmax(0,0.85fr)_minmax(18rem,1fr)] md:items-end">
            <h2 class="section-heading text-light">@lang('page.landing.customers_title')</h2>
            <p class="max-w-[52ch] text-lg leading-relaxed text-light-muted md:justify-self-end">@lang('page.landing.customers_intro')</p>
        </div>

        <ul class="client-ledger mt-12 grid border-l border-t border-rule-dark sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($customers as $customer)
                <li class="min-w-0 border-b border-r border-rule-dark">
                    @if ($customer['url'])
                        <a
                            class="client-mark group"
                            href="{{ $customer['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ trans('page.landing.customer_site', ['customer' => $customer['title']]) }}"
                        >
                            <span class="client-mark__logo">
                                <img src="{{ asset($customer['image']) }}" alt="{{ trans('page.landing.logo_alt', ['name' => $customer['title']]) }}" loading="lazy">
                            </span>
                            <span class="client-mark__caption group-hover:text-light">
                                <span class="client-mark__title">{{ $customer['title'] }}</span>
                                <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0 text-signal-cyan" aria-hidden="true"></i>
                            </span>
                        </a>
                    @else
                        <div class="client-mark">
                            <span class="client-mark__logo">
                                <img src="{{ asset($customer['image']) }}" alt="{{ trans('page.landing.logo_alt', ['name' => $customer['title']]) }}" loading="lazy">
                            </span>
                            <span class="client-mark__caption client-mark__caption--static">
                                <span class="client-mark__title">{{ $customer['title'] }}</span>
                            </span>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</section>
