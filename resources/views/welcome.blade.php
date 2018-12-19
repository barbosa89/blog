@extends('layouts.app')

@section('content')
    @include('templates.header')

    @include('templates.portfolio')    
      
    @include('templates.about')  
      
    @include('templates.contact')  
      
    @include('templates.footer')  
      
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    @include('templates.portfolio-modals')  
@endsection