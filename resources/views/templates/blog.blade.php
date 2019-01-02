@extends('layouts.landing')

@section('content')
    <!-- Header -->
    <header class="blog-masthead bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="#"><img class="img-fluid mb-5 d-block" src="images/profile.png" alt=""></a>
                </div>
                <div class="col-9 align-items-center">
                    <a href="#"><h1 class="text-uppercase">Optimización de consultas con Eloquent en Laravel</h1></a>
                    <p><i class="fas fa-calendar"></i> 28 de diciembre de 2018</p>
                    <a href="#">
                        <h2 class="font-weight-light mb-4">
                            Blog by Omar Barbosa, web developer, I share tutorials and courses on Python, PHP, Javascript, linux, security and application deployment 
                        </h2>
                    </a>
                    <div class="row align-items-end">
                        <div class="col-2"><i class="fab fa-twitter fa-2x"></i></div>
                        <div class="col-2"><i class="fab fa-facebook fa-2x"></i></div>
                        <div class="col-2"><i class="fab fa-linkedin fa-2x"></i></div>
                    </div>
                </div>
            </div>    
        </div>
    </header> 

    <div class="container blog">
        <div class="row mt-5">
            <div class="col-10">
                <div class="row blog-list align-items-center mb-2">
                    <div class="col-2">
                        <a href="#"><img class="img-fluid mb-5 d-block" src="images/profile.png" alt=""></a>
                    </div>
                    <div class="col-9 align-items-center">
                        <a href="#"><h1 class="text-uppercase blog-list-title">Optimización de consultas con Eloquent en Laravel</h1></a>
                        <p class="text-muted"><i class="fas fa-calendar"></i> 28 de diciembre de 2018</p>
                        <a href="#">
                            <h2 class="font-weight-light mb-4 blog-description">
                                Blog by Omar Barbosa, web developer, I share tutorials and courses on Python, PHP, Javascript, linux, security and application deployment 
                            </h2>
                        </a>
                    </div>
                </div>
                <div class="row blog-divider"></div>
                <div class="row blog-list align-items-center mb-2 mt-4">
                    <div class="col-2">
                        <a href="#"><img class="img-fluid mb-5 d-block" src="images/profile.png" alt=""></a>
                    </div>
                    <div class="col-9 align-items-center">
                        <a href="#"><h1 class="text-uppercase blog-list-title">Optimización de consultas con Eloquent en Laravel</h1></a>
                        <p class="text-muted"><i class="fas fa-calendar"></i> 28 de diciembre de 2018</p>
                        <a href="#">
                            <h2 class="font-weight-light mb-4 blog-description">
                                Blog by Omar Barbosa, web developer, I share tutorials and courses on Python, PHP, Javascript, linux, security and application deployment 
                            </h2>
                        </a>
                    </div>
                </div>
                <div class="row blog-divider"></div>
                <div class="row blog-list align-items-center mb-2 mt-4">
                    <div class="col-2">
                        <a href="#"><img class="img-fluid mb-5 d-block" src="images/profile.png" alt=""></a>
                    </div>
                    <div class="col-9 align-items-center">
                        <a href="#"><h1 class="text-uppercase blog-list-title">Optimización de consultas con Eloquent en Laravel</h1></a>
                        <p class="text-muted"><i class="fas fa-calendar"></i> 28 de diciembre de 2018</p>
                        <a href="#">
                            <h2 class="font-weight-light mb-4 blog-description">
                                Blog by Omar Barbosa, web developer, I share tutorials and courses on Python, PHP, Javascript, linux, security and application deployment 
                            </h2>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2 tags">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Tags</h5>
                      <ul class="tag-list">
                            <li><a href="#" class="card-link">Card link</a></li>
                            <li><a href="#" class="card-link">Card link</a></li>
                            <li><a href="#" class="card-link">Card link</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    @include('templates.footer')  
      
    @include('templates.top-button') 
@endsection