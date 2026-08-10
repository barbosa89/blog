@if ($main ?? true)
    <h1 class="mt-0 text-2xl font-black leading-tight text-slate-900 sm:text-3xl lg:text-4xl">{{ $post->title }}</h1>
@else
    <h2 class="mt-0 text-xl font-bold leading-tight text-slate-900 sm:text-2xl">{{ $post->title }}</h2>
@endif
