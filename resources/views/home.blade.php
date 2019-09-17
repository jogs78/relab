@extends('layouts.layout_home')

@section('links')

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/ventana_emergente.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}
.carousel{
    background: #2f4357;
    margin-top: 20px;
}
.carousel-item{
    text-align: center;
    min-height: 280px; /* Prevent carousel from being distorted if for some reason image doesn't load */
}
.bs-example{
    margin: 20px;
}
.bs-example1{
    margin: 20px;
}
</style>

@endsection

@section('nav')
                
<header>

    <nav id="nav" class="nav1">
        <div class="contenedor-nav">
            <div class="logo">
                <img src="images/logo_ittg.png" alt="">
            </div>

            <div class="enlaces" id="enlaces">
                <a title="Usuarios" href="{{ url('/users') }}" class="btn-header"><i class="fas fa-users"></i></a>
                <a title="Lugares" href="{{ route('lugares.index') }}" class="btn-header"><i class="fas fa-map-marker-alt"></i></a>
                <!--<a title="Mobiliarios" href="#" id="enlace-salas" class="btn-header"><i class="fas fa-laptop"></i></a>-->
                {{--@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Revisor')
                        
                    <a title="Revisiones" href="#" id="enlace-mobi" class="btn-header"><i class="fas fa-mobile-alt"></i></a>
                        
                @endif--}}

                <a class="btn-header" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Salir') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                </form>
                                
                    
            </div>

            <div class="icono" id="open">
                <!-- este codigo es para poner un icono de hamburguesa -->
                <span>&#9776;</span>
            </div>

        </div>
                   
    </nav>

{{-- Notifications Section --}}
    <div class="textos">
        <h1>Hola {{ Auth::user()->nombre }} !!</h1>
        <h2>Bienvenido al sistema de control y rastreo de mobiliario y equipo como {{Auth::user()->tipo_usuario}} </h2>
        <div class="container">
            <div class="row">
                <div class="col">
                    <!-- Example single danger button -->
                    <div class="btn-group float-center">
                    <button type="button" class="btn btn-primary dropdown-toggle" id="drop_uc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuarios Conectados
                    </button>
                    <div class="dropdown-menu scrollable-menu" id="drop_conectados"></div>
                    </div>
                </div>
                
                <div class="col">
                    @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Revisor')
                    <h2>
                        <div class="dropdown">
                            <a title="Notificaciones" href="#" class="dropdown-toggle" id="drop-mundo" data-toggle="dropdown">
                            <i class="fas fa-globe-americas"></i><span class="badge count" style="background:red;position:relative;top:-15px;left:-10px;"></span>
                            </a>
                            <div class="dropdown-menu scrollable-menu" id="drop_notificaciones">
                            </div>
                        </div>
                    </h2>
                    @endif
                </div>
            </div>
        </div>

    </div>

</header>

@endsection

@section('content')

<main>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

<div class="container">

       
    
</div>

{{-- Here I verify what kind of user I started session and I assign what options you can see
 --}}
<section class="team contenedor" id="sala">

    <h3>Mobiliario y Equipo</h3>
    <p class="after">Los lugares más populares</p>

    <div class="galeria-work">
        @foreach($lugares as $lugar)
        @if(substr_compare($lugar->nombre, "Bodega", 0, 6) !== 0)
            <div class="cont-work programacion">
                <div class="img-work">
                    <a title="Ver Mobiliario y Equipo" href="{{ route('mobis.show', $lugar->id) }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}"></a>
                </div>
                <div class="texto-work">
                    <h4>{{ $lugar->nombre }}</h4>
                </div>
            </div>
        @endif
        @endforeach
    </div>
    
<div class="bs-example">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <?php $contador = 0; ?>
            @foreach($lugares as $lugar)
            @if($contador == 0)
                 <li data-target="#myCarousel" data-slide-to="<?php $contador ?>" class="active"></li>
            @else
                <li data-target="#myCarousel" data-slide-to="<?php $contador ?>"> </li>
            @endif
            <?php $contador++; ?>
             @endforeach
            
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <?php $contador1 = 0; ?>
            @foreach($lugares as $lugar)
            @if($contador1 == 0)
            <div class="carousel-item active">
                <a href="{{ route('mobis.show', $lugar->id) }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}" style="width: 250px; height: 230px;"></a>
                <div class="texto-team carousel-caption d-none d-md-block">
                        <h4>{{ $lugar->nombre }}</h4>
                </div>
            </div>
             @else
                <div class="carousel-item">
                <a href="{{ route('mobis.show', $lugar->id) }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}" style="width: 250px; height: 230px;"></a>
                <div class="texto-team carousel-caption d-none d-md-block">
                        <h4>{{$lugar->nombre}}</h4>
                </div>
            </div>
             @endif
             <?php $contador1++;
             ?>
            @endforeach
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>


</section>

@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Revisor')
<section class="work contenedor" id="trabajo">
    <h3>Revisiones</h3>
    <p class="after">Revisiones de todas las salas y/o laboratorios del edificio de sistemas del ITTG.</p>

<div class="galeria-work">
    @foreach($lugares as $lugar)
        @if(substr_compare($lugar->nombre, "Bodega", 0, 6) !== 0)
            <div class="cont-work programacion">
                <div class="img-work">
                    <a title="Ver Revisiones" href="/revisiones/{{ $lugar->id }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}" class="d-block w-100" style="width: 240px; height: 240px;"></a>
                </div>
                <div class="textos-work">
                    <h4>{{ $lugar->nombre }}</h4>
                </div>
            </div>
        @endif
    @endforeach
</div>


{{-- Here I go through all the registered reviews and fill the view dynamically --}}
<div class="bs-example1">
    <div id="myCarousel1" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <?php $contador2 = 0; ?>
            @foreach($lugares as $lugar)
            @if($contador2 == 0)
                <li data-target="#myCarousel1" data-slide-to="<?php $contador2 ?>" class="active"></li>
            @else
                <li data-target="#myCarousel1" data-slide-to="<?php $contador2 ?>"> </li>
            @endif
            <?php $contador2++; ?>
            @endforeach
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <?php $contador3 = 0; ?>
            @foreach($lugares as $lugar)
            @if($contador3 == 0)
            <div class="carousel-item active">
                <div class="container">
                    <a href="/revisiones/{{ $lugar->id }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}" class="d-block w-100" style="width: 250px; height: 230px;"></a>
                </div> 
                <div class="carousel-caption d-none d-md-block">
                    <h4>{{ $lugar->nombre }}</h4>
                </div>
                
                </div>
            @else
            <div class="carousel-item">
                <div class="container">
                    <a href="/revisiones/{{ $lugar->id }}"><img src="{{ URL::to('/') }}/imguser/{{ $lugar->foto }}" class="d-block w-100" style="width: 250px; height: 230px;"></a>
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h4>{{ $lugar->nombre }}</h4>
                </div>
            </div>
            @endif
            <?php $contador3++; ?>
            @endforeach
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel1" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#myCarousel1" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>

<form action="{{ route('rev.ultimas') }}">
    <input type="submit" class="btn-ultimasrevs" value="Ver las últimas revisiones" />
</form>
            
</section>

@endif
        
</main>
    
<footer id="contacto">
    <div class="footer contenedor">
        <div class="marca-logo">
            <img src="images/logo_ittg.png" alt="">
        </div>
        {{--<div class="iconos">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <i class="fab fa-github"></i>
            <i class="fab fa-android"></i>  
        </div>--}}
        <p class="text-white">ITTG ISC ©2018~2019 – Todos los derechos reservados. Desarrollado por: <a href="https://www.facebook.com/eliezer.ruiz.12914">Ing. Cristian Ruiz</a></p>
    </div>
</footer>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="{{ asset('js/nav_home.js') }}"></script>
    <script src="{{ asset('js/revisiones/notificacion_rev.js')}}"></script>
    <script src="{{ asset('js/obtener_salas.js') }}"></script>
    <script src="{{ asset('js/filtro.js') }}"></script>
    <script src="{{ asset('js/conected_users.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/tablamobi.css') }}">
     



@endsection
