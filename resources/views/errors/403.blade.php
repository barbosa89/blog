@extends('layouts.app')

@section('content')
    <section class="error-signal flex min-h-screen items-center border-b border-rule-dark pb-16 pt-32 text-light">
        <div class="site-container grid gap-10 md:grid-cols-[minmax(0,0.75fr)_minmax(18rem,1.25fr)] md:items-center">
            <p class="font-display text-[clamp(9rem,28vw,22rem)] font-bold leading-[0.7] text-signal-coral" aria-hidden="true">403</p>
            <div>
                <p class="font-data text-xs uppercase tracking-[0.2em] text-track-yellow">@lang('page.technical.blocked')</p>
                <h1 class="mt-4 text-5xl text-light sm:text-7xl">@lang('page.403')</h1>
                <a class="signal-link signal-link--primary mt-8" href="{{ url()->previous() }}">@lang('page.back')</a>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
