@extends('layouts.layout_home')

@section('links')

  <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tablamobi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mobiliarioyequipo/ventana_emergente_mobi.css') }}">
  <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >
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
                    <a href="#" id="agregar_mobi" class="btn-header">Agregar Mobiliario o Equipo</a>

                    
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
             Estas en el {{ $lugar->nombre }}
            </h2>
            
        </div>

    </header>

@endsection


@section('content')


<div class="table-container">

      <table id="mobis_table" class="table-rwd">
        <thead>
          <tr>
            {{--<th>Foto</th>--}}
            <th>Clasificación</th>
            <th>Descripción</th>
            <th>Modelo</th>
            <th>Estado</th>
            <th>Marca</th>
            <th>Número Inventario</th>
            <th>Número de Serie</th>
            <th>Actualizado</th>
            <th>
              <a class="btn btn-success btn-sm" id="agregar_mobi_2">
                <i class="fas fa-plus"></i> Agregar Nuevo
              </a>
            </th>
            <!--<th><button type="button" class="btn btn-danger btn-xs" name="bulk_delete" id="bulk_delete_mobi"><i class="fas fa-user-times"></i></button></th>
            <th></th>-->
          </tr>
        </thead>
        
      </table>

    </div>


{{-- Add form --}}
<div class="modal fade" id="mobiAddModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" id="mobi_store_form">
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitleMobi">Editar Mobiliario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @csrf
          <span id="form-output-store"></span>
          <div class="form-group">
            <label for="path">Foto</label>
            <input type="file" name="foto" id="path">
          </div>

          <div class="form-group">
            <label for="first_name">Clasificación</label>
            <select class="form-control" name="clasificacion" id="select_clasificacion">
              <option value="">Seleccionar</option>
              @foreach($clasificaciones as $clasi)
                <option value="{{ $clasi }}">{{ $clasi }}</option>
              @endforeach
            </select>
          </div>
           <div class="form-group">
            <label for="first_name">Descripción</label>
            <input type="text" class="form-control" name="descripcion" id="descripcion">
          </div>
           <div class="form-group">
            <label for="first_name">Modelo</label>
            <input type="text" class="form-control" name="modelo" id="modelo">
          </div>
           <div class="form-group">
            <label for="first_name">Estado</label>
            <input type="text" class="form-control" name="estado" id="estado">
          </div>
           <div class="form-group">
            <label for="first_name">Marca</label>
            <input type="text" class="form-control" name="marca" id="marca">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Inventario</label>
            <input type="text" class="form-control" name="numero_inventario" id="numero_inventario">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Serie</label>
            <input type="text" class="form-control" name="numero_serie" id="numero_serie">
          </div>
          <div class="form-group" id="pc_data">
          </div>
         
        </div>
        <div class="modal-footer">
          <input type="hidden" name="lugar_id" id="lugar_id" value="{{ $lugar->id }}">
          <input type="submit" class="btn btn-info" name="submit" id="action">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>


{{-- Edit form --}}
<div class="modal fade" id="mobiEditModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" id="mobi_edit_form">
        <div class="modal-header">
          <h4 class="modal-title">Editar Mobiliario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @csrf
          <span id="form-output"></span>
          <div class="form-group">
            <label for="path">Foto</label>
            <input type="hidden" class="form-control" name="path_edit" id="path_edit">
            <input type="file" name="path_file_edit" id="path_edit_file">
            <span id="store_image_edit"></span>
          </div>

          <div class="form-group">
            <label for="first_name">Clasificación</label>
            <input type="text" class="form-control" id="clasificacion_disabled" disabled>
            <input type="hidden" name="clasificacion_edit" id="clasificacion_hidden">
          </div>
           <div class="form-group">
            <label for="first_name">Descripción</label>
            <input type="text" class="form-control" name="descripcion_edit" id="descripcion_edit">
          </div>
           <div class="form-group">
            <label for="first_name">Modelo</label>
            <input type="text" class="form-control" name="modelo_edit" id="modelo_edit">
          </div>
           <div class="form-group">
            <label for="first_name">Estado</label>
            <input type="text" class="form-control" name="estado_edit" id="estado_edit">
          </div>
           <div class="form-group">
            <label for="first_name">Marca</label>
            <input type="text" class="form-control" name="marca_edit" id="marca_edit">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Inventario</label>
            <input type="text" class="form-control" name="numero_inventario_edit" id="numero_inventario_edit">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Serie</label>
            <input type="text" class="form-control" name="numero_serie_edit" id="numero_serie_edit">
          </div>
          <div class="form-group" id="pc_data_edit">
          </div>
         
        </div>
        <div class="modal-footer">
          <input type="hidden" name="mobi_id_edit" id="mobi_id_edit">
          <input type="hidden" name="pc_id_edit" id="pc_id_edit">
          
          <input type="submit" class="btn btn-info" name="submit" id="action" value="Editar">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>


{{-- Place Change form --}}
<div class="modal fade" id="mobiChangeModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Cambiar de Lugar</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <span id="form-output"></span>
          <div class="form-group">
              <label for="lugar_actual">Lugar Actual</label>
              <input type="text" class="form-control" id="lugar_actual" disabled>
          </div>
          <div class="form-group">
            <label for="lugar_actual">Elegir Nuevo Lugar</label>
              <select class="form-control" name="select_change_lugar" id="select_change_lugar">
                @foreach($lugares as $sala)
                  <option value="{{ $sala->id }}">{{ $sala->nombre }}</option>
                @endforeach
              </select>
          </div>
         
        </div>
        <div class="modal-footer">
          <input type="hidden" name="mobi_id_change" id="mobi_id_change">
          <button type="button" class="btn btn-info" id="action_change_lugar">Cambiar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div>


{{-- Confirmation Modal before Delete --}}
<div class="modal" id="confirmation_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleDelete">Confirmar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="msj_confirmation_modal"></p>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm_yes" class="btn btn-danger">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

{{-- Information Modal --}}
<div class="modal" id="informationModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleInfo">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="msj_information_modal"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('js/nav_mobi.js') }}"></script>
{{--<script src="{{ asset('js/ventana_emergente_mobi.js') }}"></script>
<script src="{{ asset('js/mobiliarioyequipo/agregar_compus.js') }}"></script>--}}
 
{{--<script src="{{ asset('js/filtro.js')}}"></script>--}}
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {

            $('#mobis_table').DataTable({
                "serverSide": true,
                "ajax": "{{ route('mobis.lugarmobi', $lugar->id) }}",{{--{
                          "url": "{{ route('mobis.lugarmobi') }}",
                          //"data": {"id": 14}
                          dataSrc: ''
                        },--}}
                "columns":[
                    {{--{
                      data: 'path',
                      name: 'path',
                      render: function(data, type, full, meta){
                        return '<img src="{{ URL::to('/') }}/imgmobi/'+data+'" width="70" class="img-tumbnail">'
                      },
                      orderable: false
                    },--}}
                    {data: 'clasificacion'},
                    {data: 'descripcion'},
                    {data: 'modelo'},
                    {data: 'estado'},
                    {data: 'marca'},
                    {data: 'numero_inventario'},
                    {data: 'numero_serie'},
                    {data: 'updated_at'},
                    {data: 'action', orderable:false, searchable:false},
                    //{data: 'checkbox', orderable:false, searchable:false}
                ],
                "language": {
                    "info": "_TOTAL_ registros en total",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "lengthMenu": 'Mostrar <select>'+
                                '<option value="10">10</option>'+
                                '<option value="30">30</option>'+
                                '<option value="-1">Todos</option>'+
                                '</select> registros',
                    "loadingRecords": "Cargando...",
                    "proccesing": "Procesando...",
                    "emptyTable": "No hay datos",
                    "zeroRecords": "No hay coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                }
            });

  });
</script>

<script type="text/javascript" src="{{ URL::asset('js/mobiliarioyequipo/mobi.js') }}"></script>

@endsection