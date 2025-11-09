<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <h2 class="text-center text-uppercase text-secondary mb-0">@lang('page.contact_me')</h2>
        <hr class="star-dark mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form name="sentMessage" id="contactForm" method="POST" action="{{ route('message') }}">
                    @csrf
                    @honeypot

                    {!! RecaptchaV3::field('contact') !!}

                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>@lang('page.name')</label>
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" type="text" placeholder="{{ trans('page.name') }}" required minlength="3" maxlength="80" data-validation-required-message="{{ trans('page.required_name') }}" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>@lang('page.email')</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" placeholder="{{ trans('page.email') }}" required data-validation-required-message="{{ trans('page.required_email') }}." value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>@lang('page.phone')</label>
                            <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" type="tel" pattern="[0-9]{10}" title="El teléfono debe contener exactamente 10 dígitos" placeholder="{{ trans('page.phone') }}" value="{{ old('phone') }}">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>@lang('page.message')</label>
                            <textarea class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" id="message" name="message" rows="5" placeholder="{{ trans('page.message') }}" required minlength="30" maxlength="4096" data-validation-required-message="{{ trans('page.required_message') }}.">{{ old('message') }}</textarea>

                            @if ($errors->has('message'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">@lang('page.send')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
