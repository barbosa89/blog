@extends('layouts.landing')

@section('content')
    <!-- Header -->
    <header class="masthead bg-primary text-white text-center">
      <div class="container">
        <img class="img-fluid mb-5 d-block mx-auto" src="images/profile.png" alt="">
        <h1 class="text-uppercase mb-0">Omar Barbosa</h1>
        <hr class="star-light">
        <h2 class="font-weight-light mb-0">@lang('page.dev') - Backend && Frontend - DevOps</h2>
      </div>
    </header> 
      
    @include('templates.footer')  
      
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div> 
@endsection