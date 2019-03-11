@extends('layouts.layout_home')

@section('links')

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/ventana_emergente.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="js/ventana_emergente.js"></script>
    <script src="js/filtro.js"></script>

@endsection

@section('nav')
                

        <header>

        <nav id="nav" class="nav1">
            <div class="contenedor-nav">
                <div class="logo">
                    <img src="images/logo_ittg.png" alt="">
                </div>
                <div class="enlaces" id="enlaces">
                    <a href="{{ url('/users') }}" id="enlace-inicio" class="btn-header">Usuarios</a>
                    <a href="#" id="enlace-salas" class="btn-header">Salas o Laboratorios</a>
                    <a href="#" id="enlace-mobi" class="btn-header">Revisiones</a>
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
            <h2>Bienvenido al sistema de control y rastreo de revisiones así como de mobiliario y equipo. </h2>
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

        <section class="team contenedor" id="sala">

            <h3>Salas</h3>
            <p class="after">Los lugares más populares</p>

            <div class="card">
                <div class="content-card">
                    <div class="people">
                        <a href="{{ url('/mobi') }}"><img src="images/lab_computo.jpg" alt=""></a>
                    </div>
                    <div class="texto-team">
                        <h4>Lcom1</h4>
                        <p></p>
                    </div>
                </div>

                <div class="content-card">
                    <div class="people">
                        <a href="#"><img src="images/lab_computo.jpg" alt=""></a>
                    </div>
                    <div class="texto-team">
                        <h4>Lcom2</h4>
                        <p></p>
                    </div>
                </div>

                <div class="content-card">
                    <div class="people">
                        <a href="#"><img src="images/lab_computo.jpg" alt=""></a>
                    </div>
                    <div class="texto-team">
                        <h4>Lcom3</h4>
                        <p></p>
                    </div>
                </div>


            <button class="btn-choosesala" id="btnChoose">Elegir otra</button>

            <div class="oscurecer" id="oscurecer">
            
    </div>
    <div class="registrar" id="registrar">
        <div class="cerrarRegistro" id="cerrarRegistro">
            x
        </div>
        <h1>Registro</h1>
        <form action="" method="get" accept-charset="utf-8">
            <input type="text" name="nombre" placeholder="Nombre...">
            <input type="text" name="apellido_pat" placeholder="Apellido Paterno...">
            <input type="text" name="apellido_mat" placeholder="Apellido Materno...">
            <input type="date" name="fecha_nac">
            <input type="text" name="email" placeholder="Correo...">
            <input type="text" name="pass" placeholder="Contraseña...">
            <input type="button" value="Registrar" name="crear">
        </form>
    </div>

            @yield('ventana_emergente')

        </section>

        <!--<section class="about" id="sala">

            <div class="contenedor">
                <h3>Mobiliario y Equipo</h3>
                <p class="after">Todo acerca del mobiliario y equipo</p>

                <div class="servicios">

                    <div class="caja-servicios">
                        <img src="icons/like.png" alt="">
                        <h4>Creativos y Asombrosos</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    </div>

                    <div class="caja-servicios">
                        <img src="icons/placeholder.png" alt="">
                        <h4>Creativos y Asombrosos</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    </div>

                    <div class="caja-servicios">
                        <img src="icons/wifi.png" alt="">
                        <h4>Creativos y Asombrosos</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    </div>

                </div>

            </div>
            
        </section>-->

        <section class="work contenedor" id="trabajo">

            <h3>Revisiones</h3>
            <p class="after">Revisiones de todas las salas y/o laboratorios del edificio de sistemas del ITTG.</p>

            <div class="botones-work">
                <ul>
                    <li class="filter" data-nombre="todos">Todos</li>
                    <li class="filter" data-nombre="diseño">Últimas</li>
                    <li class="filter" data-nombre="programacion">Faltantes</li>
                    <li class="filter" data-nombre="marketing">Más vistas</li>
                </ul>
            </div>

            <div class="galeria-work">

                <div class="cont-work programacion">
                    <div class="img-work">
                        <img src="images/security.jpeg" alt="">
                    </div>
                    <div class="textos-work">
                        <h4>Programación</h4>
                    </div>
                </div>

                <div class="cont-work diseño">
                    <div class="img-work">
                        <img src="images/network.jpg" alt="">
                    </div>
                    <div class="textos-work">
                        <h4>Diseño</h4>
                    </div>
                </div>

                <div class="cont-work marketing">
                    <div class="img-work">
                        <img src="images/lineas.png" alt="">
                    </div>
                    <div class="textos-work">
                        <h4>Marketing</h4>
                    </div>
                </div>

            </div>
            
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
            <p>Copyright by Cristian Ruiz</p>
        </div>
    </footer>


@endsection

@section('scripts')

    <script src="js/nav_home.js"></script>
    <script src="js/filtro.js"></script>
    <script src="js/bubble.js"></script>

@endsection
