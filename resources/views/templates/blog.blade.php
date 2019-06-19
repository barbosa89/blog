@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('templates.blog-header', [
        'post' => $latest,
        'links' => true,
    ])

    @if($posts->count() > 0)
        <div class="container blog">
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    @foreach($posts as $post)
                        @if($loop->first)
                            @include('templates.item')
                        @else
                            <div class="row blog-divider"></div>
                            @include('templates.item')
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-3 col-xl-3 tags d-none d-lg-block d-xl-block">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tags</h5>
                            <ul class="tag-list">
                                @foreach($tags as $tag)
                                    <li><a href="#" class="card-link">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('templates.empty')  
    @endif

    <div class="container mt-4 mb-4">
        <div class="row">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="container mt-4 mb-4"></div>

    @include('templates.footer')  
      
    @include('templates.top-button') 
@endsection