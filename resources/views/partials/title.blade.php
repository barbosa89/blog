@if ($main ?? true)
    <h1 class="card-title mt-0">{{ $post->title }}</h1>
@else
    <h2 class="card-title mt-0">{{ $post->title }}</h2>
@endif