@extends('layouts.layout_home')

@section('links')

	<link rel="stylesheet" href="css/mobi.css">
    <link rel="stylesheet" href="css/tablamobi.css">
    <link rel="stylesheet" href="css/nav_mobi.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@endsection


@section('nav')
               
        <header>

        <nav id="nav" class="nav1">
            <div class="contenedor-nav">
                <div class="logo">
                    <img src="images/logo_ittg.png" alt="">
                </div>
                <div class="enlaces" id="enlaces">
                    <a href="#" id="enlace-inicio" class="btn-header">Usuarios</a>
                    <a href="#" id="enlace-usuario" class="btn-header">Salas o Laboratorios</a>
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
            <h1>Usuarios</h1>
            <h2>Todos los usuarios registrados</h2>
        </div>

    </header>

@endsection


@section('content')

<div class="table-container">
      <table class="table-rwd">
        <tr>
          <th></th>
          <th>Usuario 1</th>
          <th>Usuario 2</th>
          <th>Usuario 3</th>
          <th>Usuario 4</th>
          <th>Usuario 5</th>
          <th>Usuario 6</th>
          <th>Usuario 7</th>
          <th>Usuario 8</th>
        </tr>
        <tr>
          <td>Producto 1</td>
          <td>100</td>
          <td>200</td>
          <td>300</td>
          <td>400</td>
          <td>500</td>
          <td>600</td>
          <td>700</td>
          <td>800</td>
        </tr>
        <tr>
          <td>Producto 2</td>
          <td>200</td>
          <td>400</td>
          <td>600</td>
          <td>800</td>
          <td>1000</td>
          <td>1200</td>
          <td>1400</td>
          <td>1600</td>
        </tr>
        <tr>
          <td>Producto 3</td>
          <td>300</td>
          <td>600</td>
          <td>900</td>
          <td>1200</td>
          <td>1500</td>
          <td>1800</td>
          <td>2100</td>
          <td>2400</td>
        </tr>
        <tr>
          <td>Producto 4</td>
          <td>400</td>
          <td>800</td>
          <td>1200</td>
          <td>1600</td>
          <td>2000</td>
          <td>2400</td>
          <td>2800</td>
          <td>3200</td>
        </tr>
        <tr>
          <td>Producto 5</td>
          <td>500</td>
          <td>1000</td>
          <td>1500</td>
          <td>2000</td>
          <td>2500</td>
          <td>3000</td>
          <td>3500</td>
          <td>4000</td>
        </tr>
        <tr>
          <td>Producto 6</td>
          <td>600</td>
          <td>1200</td>
          <td>1800</td>
          <td>2400</td>
          <td>3000</td>
          <td>3600</td>
          <td>4200</td>
          <td>4800</td>
        </tr>
        <tr>
          <td>Producto 7</td>
          <td>700</td>
          <td>1400</td>
          <td>2100</td>
          <td>2800</td>
          <td>3500</td>
          <td>4200</td>
          <td>4900</td>
          <td>5600</td>
        </tr>
        <tr>
          <td>Producto 8</td>
          <td>800</td>
          <td>1600</td>
          <td>2400</td>
          <td>3200</td>
          <td>4000</td>
          <td>4800</td>
          <td>5600</td>
          <td>6400</td>
        </tr>
      </table>
    </div>

@endsection

@section('scripts')

<script src="js/nav_mobi.js"></script>
<script src="js/bubble.js"></script>

@endsection