<div @class([
        'card',
        'shadow border' => $border,
        'border-0' => !$border,
    ])>
    <div class="card-body">
        <h5 class="card-title">Tags</h5>
        <div>
            @foreach($tags as $tag)
                <span class="badge text-white text-bg-dark p-2 fs-md m-1">
                    <a class="text-white" href="{{ route('posts.tag', ['tag' => $tag]) }}">{{ $tag }}</a>
                </span>
            @endforeach
        </div>
    </div>
</div>
