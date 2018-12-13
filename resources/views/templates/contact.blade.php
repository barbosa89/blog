    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
          <h2 class="text-center text-uppercase text-secondary mb-0">@lang('page.contact_me')</h2>
          <hr class="star-dark mb-5">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
              <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
              <form name="sentMessage" id="contactForm" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <div class="form-group floating-label-form-group controls mb-0 pb-2">
                    <label>@lang('page.name')</label>
                    <input class="form-control" id="name" type="text" placeholder="{{ trans('page.name') }}" required="required" data-validation-required-message="Please enter your name.">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="form-group floating-label-form-group controls mb-0 pb-2">
                    <label>@lang('page.email')</label>
                    <input class="form-control" id="email" type="email" placeholder="{{ trans('page.email') }}" required="required" data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="form-group floating-label-form-group controls mb-0 pb-2">
                    <label>@lang('page.phone')</label>
                    <input class="form-control" id="phone" type="tel" placeholder="{{ trans('page.phone') }}" required="required" data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="form-group floating-label-form-group controls mb-0 pb-2">
                    <label>@lang('page.message')</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="{{ trans('page.message') }}" required="required" data-validation-required-message="Please enter a message."></textarea>
                    <p class="help-block text-danger"></p>
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