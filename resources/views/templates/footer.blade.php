    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">@lang('page.location')</h4>
                    <p class="lead mb-0">Santander - Colombia</p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">@lang('page.social')</h4>
                    <ul class="list-inline mb-0 ms-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle pt-2"
                                href="{{ config('blog.links.twitter.url') }}" target="_blank">
                                <em class="fab fa-fw fa-twitter"></em>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle pt-2"
                                href="{{ config('blog.links.linkedin') }}" target="_blank">
                                <em class="fab fa-fw fa-linkedin-in"></em>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle pt-2"
                                href="{{ config('blog.links.github') }}" target="_blank">
                                <em class="fab fa-fw fa-github"></em>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 class="text-uppercase mb-4">@lang('page.about')</h4>
                    <p class="lead mb-0">@lang('page.me_short')
                        .</p>
                </div>
            </div>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>@lang('page.copyright') &copy; {{ config('blog.author') }} {{ date('Y') }} - @lang('page.design') <a
                    href="http://startbootstrap.com">Start Bootstrap</a></small>
        </div>
    </div>
