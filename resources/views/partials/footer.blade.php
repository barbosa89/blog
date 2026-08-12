<footer class="bg-vacuum text-light">
    <div class="site-container grid gap-10 border-b border-rule-dark py-12 md:grid-cols-[minmax(0,1.2fr)_minmax(14rem,0.8fr)] md:items-center">
        <div class="flex items-center gap-5">
            <img class="h-20 w-14 object-contain" src="{{ asset('images/captain-logo.webp') }}" alt="" width="500" height="800" loading="lazy" decoding="async">
            <div>
                <p class="font-display text-4xl font-bold uppercase leading-none sm:text-5xl">{{ config('blog.author') }}</p>
            </div>
        </div>
        <nav class="md:justify-self-end" aria-label="{{ trans('page.accessibility.footer') }}">
            <ul class="flex flex-wrap gap-x-6 gap-y-3 text-sm [&>li]:mb-0">
                <li><a class="text-light-muted underline-offset-4 hover:text-signal-cyan hover:underline" href="{{ url('/') }}#products">{{ trans('page.products') }}</a></li>
                <li><a class="text-light-muted underline-offset-4 hover:text-signal-cyan hover:underline" href="{{ route('posts.index') }}">{{ trans('page.navigation.writing') }}</a></li>
                <li><a class="text-light-muted underline-offset-4 hover:text-signal-cyan hover:underline" href="{{ config('blog.links.github') }}" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                <li><a class="text-light-muted underline-offset-4 hover:text-signal-cyan hover:underline" href="{{ config('blog.links.linkedin') }}" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                <li><a class="text-light-muted underline-offset-4 hover:text-signal-cyan hover:underline" href="mailto:{{ config('blog.mail') }}">{{ trans('page.email') }}</a></li>
            </ul>
        </nav>
    </div>
    <div class="site-container flex flex-wrap justify-between gap-3 py-5 font-data text-xs uppercase tracking-[0.14em] text-light-muted">
        <span>Santander · Colombia</span>
        <span>{{ trans('page.copyright') }} &copy; {{ config('blog.author') }} {{ date('Y') }}</span>
    </div>
</footer>
