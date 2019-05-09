@extends('layouts.layout_home')

@section('links')

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/ventana_emergente.css">

    <link rel="stylesheet" href="{{ URL::asset('https://use.fontawesome.com/releases/v5.7.2/css/all.css"') }}" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="{{ URL::asset('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
   

@endsection

@section('nav')
                

        <header>

        <nav id="nav" class="nav1">
            <div class="contenedor-nav">
                <div class="logo">
                    <img src="images/logo_ittg.png" alt="">
                </div>
                <div class="enlaces" id="enlaces">
                    @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Administrador')
                        
                        <a href="{{ url('/users') }}" class="btn-header">Usuarios</a>
                        <a href="{{ route('lugares.index') }}" class="btn-header">Lugares</a>
                        <a href="#" id="enlace-salas" class="btn-header">Mobiliario y Equipo</a>
                        <a href="#" id="enlace-mobi" class="btn-header">Revisiones</a>
                        
                    @endif
                    @if(Auth::user()->tipo_usuario == 'Revisor' || Auth::user()->tipo_usuario == 'Encargado')
                        <a href="#" class="btn-header">Lugares</a>
                        <a href="#" id="enlace-salas" class="btn-header">Mobiliario y Equipo</a>
                        <a href="#" id="enlace-mobi" class="btn-header">Revisiones</a>
                        @endif
                        @if(Auth::user()->tipo_usuario == 'Prestador' || Auth::user()->tipo_usuario == 'Responsable' || Auth::user()->tipo_usuario == 'Reporteador')
                        <a href="#" id="enlace-mobi" class="btn-header">Revisiones</a>
                        @endif

                        <a href="#" id="enlace-revision" class="btn-header">Contacto</a>
                    

                    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Salir') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                                

                </div>

            
                <div class="icono" id="open">
                    <!-- este codigo es para poner un icono de hamburguesa -->
                    <span>&#9776;</span>

                </div>

                

            </div>
                   
        </nav>
        
        <div class="textos">
            <h1>Hola {{ Auth::user()->nombre }} !!</h1>
            <h2>Bienvenido al sistema de control y rastreo de revisiones como {{Auth::user()->tipo_usuario}} </h2>
        </div>

    </header>

@endsection

@section('content')

<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Estas logeado!
                </div>
            </div>
        </div>
    </div>
</div>-->

<main>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

{{-- Here I verify what kind of user I started session and I assign what options you can see
 --}}
@if(Auth::user()->tipo_usuario != 'Prestador' )
 @if(Auth::user()->tipo_usuario != 'Responsable')
 @if(Auth::user()->tipo_usuario != 'Reporteador')

        <section class="team contenedor" id="sala">

            <h3>Mobiliario y Equipo</h3>
            <p class="after">Los lugares más populares</p>
            <div class="card">

{{-- Here I go through all the registered places and fill the view dynamically --}}
            @foreach($lugares as $lugar)
            <div class="content-card">
                    <div class="people">
                        <a href="{{ route('mobis.show', $lugar->id) }}"><img src="images/lab_computo.jpg" alt=""></a>
                    </div>
                    <div class="texto-team">
                        <h4>{{ $lugar->nombre }}</h4>
                        <p></p>
                    </div>
                </div>
            @endforeach
            
@endif
@endif
@endif

        <section class="work contenedor" id="trabajo">

            <h3>Revisiones</h3>
            <p class="after">Revisiones de todas las salas y/o laboratorios del edificio de sistemas del ITTG.</p>

{{-- Here I go through all the registered reviews and fill the view dynamically --}}
            <div class="galeria-work">
                @foreach($lugares as $lugar)
                <div class="cont-work programacion">
                    <div class="img-work">
                        <a href="/revisiones/{{ $lugar->id }}"><img src="images/security.jpeg" alt=""></a>
                    </div>
                    <div class="textos-work">
                        <h4>{{ $lugar->nombre }}</h4>
                    </div>
                </div>
                @endforeach
            </div>

            <form action="{{ route('rev.ultimas') }}">
                <input type="submit" class="btn-ultimasrevs" value="Ver las últimas revisiones" />
            </form>
            
        </section>
        
    </main>
    

    <footer id="contacto">
        <div class="footer contenedor">
            <div class="marca-logo">
                <img src="images/logo_ittg.png" alt="">
            </div>
            <div class="iconos">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <i class="fab fa-github"></i>
                <i class="fab fa-android"></i>  
            </div>
            <p>ITTG ISC ©2018~2019 – Todos los derechos reservados. Desarrollador: Ing. Cristian Ruiz</p>
        </div>
    </footer>

@endsection

@section('scripts')

    <script src="{{ asset('js/nav_home.js') }}"></script>
    <script src="{{ asset('js/obtener_salas.js') }}"></script>
    <script src="{{ asset('js/filtro.js') }}"></script>
    <script src="{{ asset('js/bubble.js') }}"></script>
     <script src="{{ asset('js/ventana_emergente.js') }}"></script>
    <script src="{{ asset('js/filtro.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/tablamobi.css') }}">

@endsection
