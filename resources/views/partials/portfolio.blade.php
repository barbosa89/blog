<section class="bg-vacuum text-light" id="products" aria-labelledby="products-title">
    <div class="site-container">
        <div class="flex flex-wrap items-end justify-between gap-4 border-b border-rule-dark py-5">
            <div>
                <h2 id="products-title" class="font-display text-3xl leading-none text-light sm:text-4xl">{{ trans('page.landing.products_title') }}</h2>
                <p class="mt-2 max-w-2xl text-sm text-light-muted sm:text-base">{{ trans('page.landing.products_intro') }}</p>
            </div>
            <span class="font-data text-xs uppercase tracking-[0.16em] text-track-yellow">{{ trans('page.landing.web_technologies') }}</span>
        </div>

        <div class="product-ledger">
            @foreach ($products as $product)
                @php
                    $translation = trans($product['translation']);
                @endphp
                <article class="product-register {{ $product['featured'] ? 'product-register--featured' : '' }}">
                    <a
                        class="product-register__link group"
                        href="{{ $product['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="{{ trans('page.landing.product_site', ['product' => $product['title']]) }}"
                    >
                        <span class="product-register__index font-data">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="product-register__mark">
                            <img src="{{ asset($product['image']) }}" alt="" width="160" height="160" loading="lazy" decoding="async">
                        </span>
                        <span class="min-w-0">
                            <span class="block font-display text-3xl font-bold leading-none text-light sm:text-4xl">{{ $product['title'] }}</span>
                            <span class="mt-3 block max-w-[34rem] text-sm leading-relaxed text-light-muted sm:text-base">{{ $translation['summary'] }}</span>
                        </span>
                        <i data-lucide="arrow-up-right" class="product-register__arrow h-5 w-5" aria-hidden="true"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
