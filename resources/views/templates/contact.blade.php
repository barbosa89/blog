<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <h2 class="text-center text-uppercase text-secondary mb-0">@lang('page.contact_me')</h2>
        <hr class="star-dark mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                <form name="sentMessage" id="contactForm" method="POST" action="{{ route('message') }}">
                    @csrf
                    @honeypot

                    {!! RecaptchaV3::field('contact') !!}

                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>@lang('page.name')</label>
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" type="text" placeholder="{{ trans('page.name') }}" required="required" data-validation-required-message="{{ trans('page.required_name') }}" value="{{ old('name') }}">

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
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" placeholder="{{ trans('page.email') }}" required="required" data-validation-required-message="{{ trans('page.required_email') }}." value="{{ old('email') }}">

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
                            <input class="form-control" id="phone" name="phone" type="tel" placeholder="{{ trans('page.phone') }}" value="{{ old('phone') }}">

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
                            <textarea class="form-control" id="message{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" rows="5" placeholder="{{ trans('page.message') }}" required="required" data-validation-required-message="{{ trans('page.required_email') }}.">{{ old('message') }}</textarea>

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
