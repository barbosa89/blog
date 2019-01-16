@extends('layouts.app')

@section('content')
    <!-- Header -->
    <header class="blog-masthead text-gray">
        <div class="container">
            <div class="row text-gray text-center text-lg-left text-xl-left">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <a href="#" class="text-gray"><img class="img-fluid mb-5" src="{{ url('images/profile.png') }}" alt=""></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-md-center text-lg-left align-items-center">
                    <a href="#" class="text-gray"><h1 class="text-uppercase">Optimización de consultas con Eloquent en Laravel</h1></a>
                    <p><i class="fas fa-calendar"></i> 28 de diciembre de 2018</p>
                    <a href="#" class="text-gray">
                        <h2 class="font-weight-light mb-4 text-justify">
                            Blog by Omar Barbosa, web developer, I share tutorials and courses on Python, PHP, Javascript, linux, security and application deployment 
                        </h2>
                    </a>
                    <div class="row align-items-end">
                        <div class="col-4"><i class="fab fa-twitter fa-2x"></i></div>
                        <div class="col-4"><i class="fab fa-facebook fa-2x"></i></div>
                        <div class="col-4"><i class="fab fa-linkedin fa-2x"></i></div>
                    </div>
                </div>
            </div>   
            <div class="row blog-divider"></div>
        </div>
    </header> 

    <div class="container post text-justify">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-10 offset-lg-1 col-xl-10 offset-xl-1">
                <div class="row">
                    <div class="col-12">
                        <article>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nisl est, varius in venenatis porttitor, dapibus sed lacus. Fusce vitae eros posuere, luctus tellus in, dignissim nulla. Integer ac elementum tortor. Morbi pharetra congue egestas. Proin viverra dictum pharetra. Donec et nisi metus. Nunc ac sapien elementum, mattis diam eu, condimentum felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a mi et leo fringilla varius. In blandit sollicitudin massa, vel dignissim enim vulputate at. Nulla vitae tristique elit.</p>
        
                            <p>Nulla imperdiet, augue sit amet euismod vestibulum, sem nibh imperdiet dui, vitae interdum tellus ante ac dui. Etiam fringilla ac augue facilisis aliquam. Pellentesque laoreet velit pretium, maximus justo ac, consequat turpis. Mauris odio ipsum, tincidunt nec enim eu, elementum laoreet enim. Aliquam at maximus lacus. Pellentesque et porttitor sapien. Mauris rhoncus orci vel arcu aliquam, eget auctor enim mattis. Cras tincidunt, arcu vitae iaculis commodo, enim arcu faucibus turpis, non lobortis enim mauris in ipsum. Morbi et sapien eu mauris tempus aliquam. Morbi gravida et neque non mollis.</p>
        
                            <p>Suspendisse ultrices vehicula augue quis fermentum. Maecenas in risus elit. Aliquam suscipit ipsum nec nisl imperdiet, quis ornare justo fermentum. Cras placerat turpis vel risus tristique, non blandit erat cursus. Integer ut massa at purus interdum venenatis. Curabitur et scelerisque massa. Integer id quam sagittis diam mollis interdum. Nulla et nisi venenatis, elementum lacus a, dictum metus. Duis luctus purus quis ex tristique, sed porta diam semper. Mauris posuere gravida ipsum, in lacinia justo dictum nec. Etiam vehicula tristique nibh, ut ornare ante tristique et.</p>
                        </article>
                    </div>
                </div>
        
                <div class="row mb-4 mt-4"> 
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-center mb-4">
                        <img class="img-fluid" src="{{ url('images/profile.png') }}" alt="">
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6 mb-4">
                        <h5>Omar Barbosa</h5>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nisl est, varius in venenatis porttitor.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card" style="width:100%">
                            <div class="card-body">
                                <h5 class="card-title text-muted">@lang('page.share')</h5>
                                <p class="card-text">@lang('page.share_text')</p>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <a class="card-link" href="#"><i class="fab fa-twitter fa-2x"></i></a>
                                    </div>
                                    <div class="col-4">
                                        <a class="card-link" href="#"><i class="fab fa-facebook fa-2x"></i></a>
                                    </div>
                                    <div class="col-4">
                                        <a class="card-link" href="#"><i class="fab fa-linkedin fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('templates.subscription')

                <div class="mosthead mb-4">
                    <div class="col-12 mt-4 blog-divider">
                        <h4 class="mb-4"><small>@lang('page.related')</small></h4>
                    </div>
        
                    <div class="row blog">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row blog-list mb-2">
                                <div class="col-3">
                                    <a href="#"><img class="img-fluid mb-5" src="{{ url('images/profile.png') }}" alt=""></a>
                                </div>
                                <div class="col-9">
                                    <a href="#"><h3 class="text-uppercase blog-list-title"><small>Optimización de consultas con Eloquent en Laravel</small></h3></a>
                                    <p><i class="fas fa-calendar"></i> <small> 28 de diciembre de 2018</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row blog-list mb-2">
                                <div class="col-3">
                                    <a href="#"><img class="img-fluid mb-5" src="{{ url('images/profile.png') }}" alt=""></a>
                                </div>
                                <div class="col-9">
                                    <a href="#"><h3 class="text-uppercase blog-list-title"><small>Optimización de consultas con Eloquent en Laravel</small></h3></a>
                                    <p><i class="fas fa-calendar"></i> <small> 28 de diciembre de 2018</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="row mb-4">
                    <div class="col-12">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    @include('templates.footer')  
      
    @include('templates.top-button') 
@endsection

@section('scripts')

    <script async>
    (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://omarbarbosa.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>    
    <script async>
        setTimeout(function(){
            $('#subscription').modal('show')
        }, 20000);
    </script>
@endsection