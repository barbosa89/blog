@php
    $navigationItems = [
        ['label' => trans('page.products'), 'url' => url('/').'#products'],
        ['label' => trans('page.customers'), 'url' => url('/').'#customers'],
        ['label' => trans('page.about'), 'url' => url('/').'#about'],
        ['label' => trans('page.navigation.writing'), 'url' => route('posts.index')],
        ['label' => trans('page.contact'), 'url' => url('/').'#contact'],
    ];
    $localeItems = [
        ['label' => 'ES', 'url' => route('locale', 'es')],
        ['label' => 'EN', 'url' => route('locale', 'en')],
    ];
@endphp

<site-navbar
    :author='@json(config("blog.author"))'
    :home-url='@json(url("/"))'
    :menu-label='@json(trans("page.navigation.open"))'
    :close-label='@json(trans("page.navigation.close"))'
    :primary-label='@json(trans("page.navigation.primary"))'
    :locale-label='@json(trans("page.locale"))'
    :items='@json($navigationItems)'
    :locales='@json($localeItems)'
></site-navbar>
