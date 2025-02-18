<!-- Navigation -->
<nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}#page-top">{{ config('blog.author') }}</a>
        <button class="navbar-toggler navbar-toggler-end text-uppercase bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <em class="fas fa-bars"></em>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ url('/') }}#portfolio">@lang('page.portfolio')</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ url('/') }}#about">@lang('page.about')</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ url('/') }}#contact">@lang('page.contact')</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('posts.index') }}">Blog</a>
                </li>

                {{-- @auth
                    <li class="nav-item mx-0 mx-lg-1 cursor-pointer">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded border text-sm-center" href="{{ route('home') }}">Home</a>
                    </li>
                @else
                    <li class="nav-item mx-0 mx-lg-1 cursor-pointer">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded border text-sm-center" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth --}}
            </ul>
        </div>
    </div>
</nav>
