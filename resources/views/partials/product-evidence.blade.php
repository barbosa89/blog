@php
    $translation = $product['translation'];
@endphp

<article
    id="product-{{ $product['id'] }}"
    class="project-evidence group min-w-0 border-t border-rule-light pt-4"
>
    <div @class([
        'project-evidence__media product-mark border border-rule-dark',
        'aspect-[16/9]' => $isFeatured,
        'aspect-[4/3]' => !$isFeatured,
    ])>
        <img
            src="{{ asset($product['image']) }}"
            alt="{{ trans('page.landing.logo_alt', ['name' => $product['title']]) }}"
            loading="{{ $isFeatured ? 'eager' : 'lazy' }}"
        >
    </div>

    <div class="mt-4 grid gap-3 sm:grid-cols-[auto_minmax(0,1fr)] sm:gap-5">
        <span class="font-data text-xs text-ink-muted">SIG-{{ str_pad((string) $signalNumber, 2, '0', STR_PAD_LEFT) }}</span>
        <div class="min-w-0">
            <h3 @class(['text-ink', 'text-4xl sm:text-5xl' => $isFeatured, 'text-3xl' => !$isFeatured])>
                {{ $product['title'] }}
            </h3>
            <p class="mt-2 font-data text-xs uppercase tracking-[0.16em] text-ink-muted">@lang('page.landing.product_record')</p>
            @if ($isFeatured)
                <p class="mt-3 text-base font-semibold text-ink">{{ trans($translation.'.subtitle') }}</p>
            @endif
            <p class="mt-4 whitespace-normal text-base leading-relaxed text-ink-muted">{{ trans($translation.'.description') }}</p>
            @if ($isFeatured)
                <p class="mt-3 whitespace-normal text-base leading-relaxed text-ink-muted">{{ trans($translation.'.use_cases') }}</p>
            @endif
            <a
                class="signal-link signal-link--quiet mt-5"
                href="{{ $product['url'] }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                {{ trans($translation.'.button_action') }}
                <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</article>
