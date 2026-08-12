@extends('layouts.app')

@section('content')
    <section class="error-page flex min-h-screen items-center border-b border-rule-dark pb-16 pt-32 text-light">
        <div class="site-container grid gap-10 md:grid-cols-[minmax(0,0.75fr)_minmax(18rem,1.25fr)] md:items-center">
            <p class="font-display text-[clamp(9rem,28vw,22rem)] font-bold leading-[0.7] text-signal-coral" aria-hidden="true">404</p>
            <div>
                <p class="font-data text-xs uppercase tracking-[0.2em] text-track-yellow">{{ trans('page.technical.not_found') }}</p>
                <h1 class="mt-4 text-5xl text-light sm:text-7xl">{{ trans('page.404') }}</h1>
                <a class="catalog-action catalog-action--primary mt-8" href="{{ route('welcome') }}">{{ trans('page.back_home') }}</a>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
