<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tags</h5>
        <ul class="tag-list">
            @foreach($tags as $tag)
                <li><a href="{{ route('posts.tag', ['tag' => $tag->name]) }}" class="card-link">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
