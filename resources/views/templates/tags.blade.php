<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tags</h5>
        <ul class="post-tags list-inline">
            @foreach($tags as $tag)
                <li class="tag-item"><a href="{{ route('posts.tag', ['tag' => $tag->name]) }}" class="card-link">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
