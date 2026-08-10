<section class="surface-light py-20 sm:py-28" id="products">
    @php
        $productCollection = collect($products);
        $featuredProduct = $productCollection->firstWhere('featured', true) ?? $productCollection->first();
        $secondaryProducts = $productCollection
            ->reject(fn (array $product): bool => $product['id'] === ($featuredProduct['id'] ?? null))
            ->values();
    @endphp

    <div class="site-container">
        <div class="grid gap-6 border-b border-rule-light pb-10 md:grid-cols-[minmax(0,0.75fr)_minmax(18rem,1fr)] md:items-end">
            <div>
                <h2 class="section-heading text-ink">@lang('page.landing.products_title')</h2>
            </div>
            <p class="section-intro md:justify-self-end">@lang('page.landing.products_intro')</p>
        </div>

        <div class="mt-12 grid gap-16 lg:grid-cols-[minmax(0,1.4fr)_minmax(20rem,0.9fr)] lg:items-start lg:gap-10">
            @if ($featuredProduct)
                @include('partials.product-evidence', [
                    'product' => $featuredProduct,
                    'signalNumber' => 1,
                    'isFeatured' => true,
                ])
            @endif

            <div class="grid min-w-0 gap-12">
                @foreach ($secondaryProducts as $product)
                    @include('partials.product-evidence', [
                        'product' => $product,
                        'signalNumber' => $loop->iteration + 1,
                        'isFeatured' => false,
                    ])
                @endforeach
            </div>
        </div>
    </div>
</section>
