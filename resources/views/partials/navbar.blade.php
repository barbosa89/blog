@php
    $navigationItems = [
        ['labelKey' => 'page.products', 'url' => url('/').'#products'],
        ['labelKey' => 'page.navigation.writing', 'url' => route('posts.index')],
        ['labelKey' => 'page.navigation.code', 'url' => config('blog.links.github'), 'external' => true],
        ['labelKey' => 'page.navigation.about', 'url' => url('/').'#about'],
    ];
    $localeItems = [
        ['label' => 'ES', 'url' => route('locale', 'es'), 'active' => app()->getLocale() === 'es'],
        ['label' => 'EN', 'url' => route('locale', 'en'), 'active' => app()->getLocale() === 'en'],
    ];
@endphp

<site-navbar
    :author='@json(config("blog.author"))'
    :logo-url='@json(asset("images/captain-logo.webp"))'
    :home-url='@json(url("/"))'
    :items='@json($navigationItems)'
    :locales='@json($localeItems)'
></site-navbar>
