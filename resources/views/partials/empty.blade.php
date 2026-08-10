<section class="border border-rule-light bg-paper-raised p-7 sm:p-10" aria-labelledby="empty-title">
    <p class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted">NULL / 00</p>
    <h2 id="empty-title" class="mt-3 text-4xl text-ink">
        {{ request()->has('query') ? trans('page.no_results') : trans('page.without_content') }}
    </h2>
    @if (request()->has('query'))
        <p class="mt-4 max-w-xl text-lg text-ink-muted">@lang('page.no_results_help')</p>
    @endif
</section>
