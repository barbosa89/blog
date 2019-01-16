<div class="row blog-list align-items-center mb-2">
    <div class="col-lg-2 col-xl-2 d-none d-lg-block d-xl-block">
        <a href="#"><img class="img-fluid mb-5" src="{{ url($post->featured_image) }}" alt="{{ $post->excerpt }}"></a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 align-items-center">
        <a href="#"><h1 class="text-uppercase blog-list-title">{{ $post->title }}</h1></a>
            <p class="text-muted"><i class="fas fa-calendar"></i> {{ $latest->created_at->toDateString() }} </p>
        <a href="#">
            <h2 class="font-weight-light mb-4 blog-description">
                {{ $post->excerpt }}
            </h2>
        </a>
    </div>
</div>