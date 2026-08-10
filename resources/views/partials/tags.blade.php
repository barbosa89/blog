<aside @class(['lg:sticky lg:top-28', 'border-t border-rule-light pt-4' => $border ?? false]) aria-labelledby="tags-title">
    <h2 id="tags-title" class="font-data text-xs uppercase tracking-[0.18em] text-ink-muted">@lang('page.technical.tags')</h2>
    <ul class="mt-4 border-l border-t border-rule-light [&>li]:mb-0">
        @foreach($tags as $tag)
            <li class="border-b border-r border-rule-light">
                <a class="flex min-h-11 items-center justify-between gap-3 px-3 text-sm text-ink transition-colors hover:bg-paper-raised hover:text-ink focus-visible:bg-paper-raised" href="{{ route('tags.show', ['tag' => $tag]) }}">
                    <span class="min-w-0 whitespace-normal">{{ $tag }}</span>
                    <span aria-hidden="true" class="font-data text-signal-cyan">+</span>
                </a>
            </li>
        @endforeach
    </ul>
</aside>
