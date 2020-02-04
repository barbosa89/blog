@extends('layouts.landing')

@section('content')

<div class="blog-masthead">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img class="img-fluid" src="{{ asset('images/offline.jpg') }}" alt="Offline">
                <div class="alert alert-light alert-important">
                    <h1 class="text-center">@lang('page.offline')</h1>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
