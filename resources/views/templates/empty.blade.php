<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                @if (request()->has('query'))
                    <h1 class="text-muted">{{ trans('page.no_results') }}</h1>
                @else
                    <h1 class="text-muted">{{ trans('page.without_content') }}</h1>
                @endif
                <programmers-icon class="w-100 h-100" />
            </div>
        </div>
    </div>
</div>
