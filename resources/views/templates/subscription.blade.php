<form class="form-inline" action="{{ route('subscribe') }}" method="POST">
    @csrf
    @honeypot
    
    <div class="modal fade" id="subscription" tabindex="-1" role="dialog" aria-labelledby="subscriptionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="subscriptionLabel">@lang('page.subscribe')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>@lang('page.msg_subscription').</p>
                <div class="input-group mb-2 w-100">
                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ trans('page.email') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('page.close')</button>
                <button type="submit" class="btn btn-primary">@lang('page.send')</button>
            </div>
        </div>
        </div>
    </div>
</form>
