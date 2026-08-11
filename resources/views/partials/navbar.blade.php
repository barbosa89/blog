@php
    $navigationItems = [
        ['label' => trans('page.products'), 'url' => url('/').'#products'],
        ['label' => trans('page.navigation.writing'), 'url' => route('posts.index')],
        ['label' => trans('page.navigation.code'), 'url' => config('blog.links.github'), 'external' => true],
        ['label' => trans('page.navigation.about'), 'url' => url('/').'#about'],
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
    :menu-label='@json(trans("page.navigation.open"))'
    :close-label='@json(trans("page.navigation.close"))'
    :primary-label='@json(trans("page.navigation.primary"))'
    :locale-label='@json(trans("page.locale"))'
    :items='@json($navigationItems)'
    :locales='@json($localeItems)'
></site-navbar>
