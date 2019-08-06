@extends('layouts.layout_home')

@section('links')

  	 <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  
    <link rel="stylesheet" href="{{ asset('css/tablamobi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobiliarioyequipo/ventana_emergente_mobi.css') }}">
    <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">



@endsection


@section('nav')
               
        <header>

        <nav id="nav" class="nav1">
            <div class="contenedor-nav">
                <div class="logo">
                    <img src="{{ asset('images/logo_ittg.png') }}" alt="">
                </div>
                <div class="enlaces" id="enlaces">
                  <a href="{{ url('/home') }}" class="btn-header">Inicio</a>
                    
                    <!--<a href="#" id="enlace-revision" class="btn-header">Contacto</a>-->

                    
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
            <h1>Mobiliario y Equipo</h1>
            
            <h2>
              {{--Estas en {{ $lugares->nombre }}--}}
            </h2>
            
        </div>

    </header>

@endsection


@section('content')

<div class="table-container">
  @if(!$item)
          {{ 'No hay mobiliario que mostrar'}}
        @else

      <table id="mobis_table" class="table-rwd">
        <thead>
          <tr>
            <th>Clasificación</th>
            <th>Descripción</th>
            <th>Modelo</th>
            <th>Estado</th>
            <th>Marca</th>
            <th>Número Inventario</th>
            <th>Número de Serie</th>
            <th>
              <a class="addmobi-modal btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
              </a>
            </th>
          </tr>
        </thead>

        
       {{--@foreach($items as $item)--}}

        <tr>
          
          {{--<td>{{ $item->clasificacion }}</td>--}}
          <td>{{ $item->descripcion }}</td>
          <td>{{ $item->modelo }}</td>
          <td>{{ $item->estado }}</td>
          <td>{{ $item->marca }}</td>
          <td><img src="{{ asset('storage/app/public/'.$item->path) }}" alt=""></td>
          <td>imagen</td>
          <td>{{ $item->numero_inventario }}</td>
          <td>{{ $item->numero_serie }}</td>
          
          <td>{{ $item->created_at }}</td>
          
          <td>{{ $item->updated_at }}</td>
        </tr>

        

        {{--@endforeach--}}
        
      </table>

      @endif

      <br>

<div class="table-container">
  @if(!$mobis)
          {{ 'No hay computadoras que mostrar'}}
        @else

      <table class="table-rwd">
        <tr>
          
          <th>Número de Maquina</th>
          <th>Cámara</th>
          <th>Bocinas</th>
          <th>N# de Serie CPU</th>
          <th>Cantidad de RAM</th>
          <th>Contidad Disco Duro</th>
          <th>Sistema Operativo</th>
          <th>SO Activado</th>
          <th>Cable VGA</th>
          <th>Monitor</th>
          <th>N3 de Serie Monitor</th>
          <th>Teclado</th>
          <th>Raton</th>
          <th>Controlador de Red</th>
          <th>Versión de Office</th>
          <th>Office Activado</th>
          <th>Observaciones</th>
          <th>Ultima Actualización</th>
        </tr>

        
        {{--@foreach($mobis as $pc)--}}

        <tr>
          
          <td>{{ $mobi->num_maquina }}</td>
          @if($mobi->tiene_camara == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          @if($mobi->tiene_bocinas == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          <td>{{ $mobi->num_serie_cpu }}</td>
          <td>{{ $mobi->ram }}</td>
          <td>{{ $mobi->disco_duro }}</td>
          <td>{{ $mobi->sistema_operativo }}</td>
          @if($mobi->sistema_operativo_activado == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          @if($mobi->cable_vga == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          @if($mobi->tiene_monitor == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          <td>{{ $mobi->num_serie_monitor }}</td>
          @if($mobi->tiene_teclado == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          @if($mobi->tiene_raton == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          @if($mobi->controlador_red == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          <td>{{ $mobi->paq_office_version }}</td>
          @if($mobi->paq_office_activado == 0)
            <td>No</td>
          @else
          <td>Si</td>
          @endif
          <td>{{ $mobi->observaciones }}</td>
          <td>{{ $mobi->updated_at }}</td>
        </tr>


        {{--@endforeach--}}
        
      </table>

      @endif

    </div>


@endsection

@section('scripts')

<script src="{{ asset('js/nav_mobi.js') }}"></script>
{{--<script src="{{ asset('js/ventana_emergente_mobi.js') }}"></script>
<script src="{{ asset('js/mobiliarioyequipo/agregar_compus.js') }}"></script>--}}
 
<script src="{{ asset('js/filtro.js')}}"></script>

<script src="{{ asset('js/bubble.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


@endsection