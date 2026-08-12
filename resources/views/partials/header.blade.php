<header class="logbook-hero border-b border-rule-dark pt-18" id="home">
    <div class="site-container grid items-center gap-8 py-8 sm:py-10 lg:min-h-104 lg:grid-cols-[minmax(0,1.2fr)_minmax(20rem,0.8fr)] lg:gap-12">
        <div class="relative z-10 min-w-0">
            {{-- <p class="font-display text-[clamp(3.4rem,6vw,4.75rem)] font-bold uppercase leading-[0.86] tracking-tight text-light">
                {{ trans('page.degree') }}
            </p> --}}
            <span class="mt-5 block h-1 w-24 bg-signal-cyan" aria-hidden="true"></span>
            <h1 class="mt-5 max-w-[17ch] font-display text-[clamp(2.75rem,4.5vw,4rem)] leading-[0.92] tracking-[-0.03em] text-light">
                {{ trans('page.landing.hero_title') }}
            </h1>
            <nav class="mt-5" aria-label="{{ trans('page.landing.hero_paths') }}">
                <ul class="flex flex-wrap gap-x-7 gap-y-3 font-data text-xs uppercase tracking-[0.2em] [&>li]:mb-0">
                    <li><a class="text-signal-cyan underline-offset-4 hover:underline" href="http://php.net" target="_blank" rel="noopener noreferrer">PHP</a></li>
                    <li><a class="text-light-muted underline-offset-4 hover:text-light hover:underline" href="https://go.dev" target="_blank" rel="noopener noreferrer">Go</a></li>
                    <li><a class="text-track-yellow underline-offset-4 hover:underline" href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank" rel="noopener noreferrer">JavaScript</a></li>
                </ul>
            </nav>
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-light-muted sm:text-lg">
                {{ trans('page.landing.hero_body') }}
            </p>
        </div>

        <figure class="mx-auto w-full max-w-56 self-center lg:max-w-100 lg:justify-self-end">
            <img
                class="h-auto w-full mask-[linear-gradient(var(--palette-vacuum)_80%,transparent)] [-webkit-mask-image:linear-gradient(var(--palette-vacuum)_80%,transparent)]"
                src="{{ asset('images/captain.webp') }}"
                alt=""
                fetchpriority="high"
                decoding="async"
            >
        </figure>
    </div>
</header>
