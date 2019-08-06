@extends('layouts.layout_home')

@section('links')

  <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tablamobi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mobiliarioyequipo/ventana_emergente_mobi.css') }}">
  <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

<style>
  .dos {
    background: #000CFF;
    color: #fff; }
</style>
@endsection


@section('nav')
               
<header>

<nav id="nav" class="nav1">
  <div class="contenedor-nav">
      <div class="logo">
        <img src="{{ asset('images/logo_ittg.png') }}" alt="">
      </div>
      <div class="enlaces" id="enlaces">
        <a href="{{ url('/') }}" class="btn-header"><i class="fas fa-home"></i></a>
        @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Prestador' || Auth::user()->tipo_usuario == 'Responsable')
          <a href="#" id="agregar_mobi" class="btn-header">Agregar Mobiliario o Equipo</a>
        @endif
                    
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
<br>
<div class="container">
  <div class="row">
    <div class="col">
      <button type="button" class="btn btn-success float-right" onClick="itemsQuantity({{ $lugar->id }})">Ver Cantidades por Ítems</button>
    </div>
  </div>
</div>

<!-- Cantidades de Items -->
<div class="modal fade bd-example-modal-lg" id="itemsCantModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel">Cantidades de Items Existentes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row justify-content-center" id="cant_mobi_all">
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<br>
<div class="table-container">
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
            <th>Foto</th>
            <th>Actualizado</th>
            @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Responsable')
            <th>Cambiar Lugar</th>
            @endif
            @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Responsable')
            <th><button type="button" class="btn btn-danger float-right" id="move_all">Mover Varios</button></th>
            @endif
            @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Prestador' || Auth::user()->tipo_usuario == 'Responsable')
            <th>
              <a class="btn btn-success btn-sm" id="agregar_mobi_2">
                <i class="fas fa-plus"></i> Agregar Nuevo
              </a>
            </th>
            @endif
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

      <form method="post" id="mobi_store_form">
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitleMobi"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @csrf
          <span id="form-output-store"></span>
          <div class="form-group">
            <label for="path" class="text-primary">Foto: </label>
            <input type="file" name="foto" id="path" class="form-control">
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
            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Escribe una descripción del Item" >
          </div>
           <div class="form-group">
            <label for="first_name">Modelo</label>
            <input type="text" class="form-control" name="modelo" id="modelo" placeholder="Escribe el modelo del Item">
          </div>
           <div class="form-group">
            <label for="first_name">Estado</label>
            <select class="form-control" name="estado" id="estado">
              <option value="Regular">Regular</option>
              <option value="Bueno">Bueno</option>
              <option value="Malo">Malo</option>
            </select>
          </div>
           <div class="form-group">
            <label for="first_name">Marca</label>
            <input type="text" class="form-control" name="marca" id="marca" placeholder="Escribe la marca del Item">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Inventario</label>
            <input type="text" class="form-control" name="numero_inventario" id="numero_inventario" placeholder="Escribe el número de inventario del Item">
          </div>
          <div class="form-group">
            <label for="last_name">Número de Serie</label>
            <input type="text" class="form-control" name="numero_serie" id="numero_serie" placeholder="Escribe el número de serie del Item" >
          </div>
          <div class="form-group" id="pc_data">
          </div>
         
        </div>
        <div class="modal-footer">
          <input type="hidden" name="lugar_id" id="lugar_id" value="{{ $lugar->id }}">
          <input type="hidden" name="user_id_mobi" id="user_id" value="{{ Auth::id() }}">
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
          <input type="hidden" name="user_edit" id="user_edit" value="{{ Auth::id() }}">
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
        <p class="text-danger" id="msj_confirmation_modal2"></p>
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
  <div class="modal-dialog"  id="colorInfModal" role="document">
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

{{-- See Details form --}}
<div class="modal fade bd-example-modal-xl" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="mobiInfoModal" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
            <div class="col-md-4" id="path_show">
  
            </div>
            <div class="col-md-4">
              <label for="user_id_edit">Usuario que agregó</label>
              <input type="text" class="form-control" id="user_id_show" disabled>
              <label for="first_name">Último que actualizó</label>
              <input type="text" class="form-control" id="user_edit_show" disabled>
              <label for="tipo_edit">Clasificación</label>
              <input type="text" class="form-control" id="clasificacion_show" disabled>
            </div>
            <div class="col-md-4">
              <label for="tipo_edit">Marca</label>
              <input type="text" class="form-control" id="marca_show" disabled>
              <label for="momento_edit">Modelo</label>
              <input type="text" class="form-control" id="modelo_show" disabled>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4">
              <label for="tipo_edit">Descripción</label>
              <input type="text" class="form-control" id="descripcion_show" disabled>
              <label for="momento_edit">Estado</label>
              <input type="text" class="form-control" id="estado_show" disabled>
            </div>
            <div class="col-md-4">
              <label for="momento_edit">Número de Inventario</label>
              <input type="text" class="form-control" id="numero_inv_show" disabled>
              <label for="momento_edit">Número de Serie</label>
              <input type="text" class="form-control" id="numero_serie_show" disabled>
            </div>
            <div class="col-md-4">
              <label for="momento_edit">Creado</label>
              <input type="text" class="form-control" id="created_at_show" disabled>
              <label for="momento_edit">Última actialización</label>
              <input type="text" class="form-control" id="updated_at_show" disabled>
            </div>
          </div>
          <hr>
           <div class="form-group" id="pc_detail_show">
            
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div> 

@endsection

@section('scripts')

<script src="{{ asset('js/nav_mobi.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {

    let num_column = '';

    alertaDePcs();

    function alertaDePcs(){
      $("#modalTitleInfo").text("Indicaciones!");
      $("#modalTitleInfo").addClass("text-danger");
      $("#msj_information_modal").text("Si encuentras un recuadro rojo en el número de serie de las Pcs, significa que faltan datos, basta con actualizalos (botón editar) para corregirlos y así tener un mejor control del mismo, Gracias!");
      $("#msj_information_modal").addClass("text-danger");
      $("#informationModal").modal('show');
    }

            var table = $('#mobis_table').DataTable({
                "serverSide": true,
                "ajax": "{{ route('mobis.lugarmobi', $lugar->id) }}",
                "columns":[
                    {data: 'clasificacion'},
                    {data: 'descripcion'},
                    {data: 'modelo'},
                    {data: 'estado'},
                    {data: 'marca'},
                    {data: 'numero_inventario'},
                    {data: 'numero_serie',
                     name: 'numero_serie',
                     render: function(data, type, full, meta){
                      var todo = [full]
                      for(var i = 0; i < todo.length; i++){
                        if (todo[i].numero_serie == 'undefined' || todo[i].numero_serie == '') {
                          return `<button class="btn btn-danger" style="width:100%;" disabled>Sin Pc</button>`
                        }else{
                          return todo[i].numero_serie;
                        }
                      }
                      },
                      orderable: false
                    },
                    {
                      data: 'path',
                      name: 'path',
                      render: function(data, type, full, meta){
                        return '<img src="{{ URL::to('/') }}/imguser/'+data+'" width="70" class="img-tumbnail">'
                      },
                      orderable: false
                    },
                    {data: 'updated_at'},
                    @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Responsable')
                    {data: "change",
                      render: function(data, type, full, meta){
                        return data;
                      },
                    orderable:false, searchable:false},
                    @endif
                    @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Responsable')
                    {data: "checkbox",
                      render: function(data, type, full, meta){
                        return data;
                      },
                    orderable:false, searchable:false},
                    @endif
                    @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Prestador' || Auth::user()->tipo_usuario == 'Responsable')
                    {data: 'action',
                      render: function(data, type, full, meta){
                        return data;
                      },
                      orderable:false, searchable:false},
                      @endif
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


            $('#mobis_table').on('click','td', function () {
                var col = $(this).parent().children().index($(this));
                num_column = col;
              })

            $('#mobis_table').on('click', 'tr', function () {
              if (num_column <= 8) {
                var data = table.row( this ).data();
                var id = data.id

                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
                $.ajax({
                  url: "{{ route('mobi.detail') }}",
                  method: "post",
                  data: {id: id},
                  dataType: "json",
                  success: function(res){
                    let html_pc = ''
                    if (res.mobi.clasificacion != "Pc") {
                      if (res.user_add != null) {
                        $("#user_id_show").val(res.user_add.nombre+' '+res.user_add.apellido)
                      }else{
                        $("#user_id_show").val('Cristian R.')
                      }
                      if (res.user_edit != null) {
                        $("#user_edit_show").val(res.user_edit.nombre)
                      }else{
                        $("#user_edit_show").val('Nadie')
                      }
                      if (res.mobi.path != null) {
                        $("#path_show").html('<img src="{{ URL::to('/') }}/imguser/'+res.mobi.path+'" style="width:100%;" class="img-thumbnail" alt="">')
                      }else{
                        $("#path_show").html('<img src="/images/mobi1.jpg" class="img-thumbnail" style="width:100%;" alt="">')
                      }
                      $("#clasificacion_show").val(res.mobi.clasificacion)
                      $("#modelo_show").val(res.mobi.modelo)
                      $("#marca_show").val(res.mobi.marca)
                      $('#numero_inv_show').val(res.mobi.numero_inventario)
                      $("#numero_serie_show").val(res.mobi.numero_serie)
                      $("#estado_show").val(res.mobi.estado)
                      $("#descripcion_show").val(res.mobi.descripcion)
                      $("#created_at_show").val(res.mobi.created_at)
                      $("#updated_at_show").val(res.mobi.updated_at)

                      $(".modal-title").text('Detalle de '+res.mobi.clasificacion)
                      $("#mobiInfoModal").modal('show')
                    }else{
                      
                      if (res.pc == null || res.pc.num_serie_cpu == 'undefined' || res.pc.num_serie_cpu == '') {
                        $("#colorInfModal").addClass("p-3 mb-2 bg-danger text-white");
                        $("#modalTitleInfo").text("¡Error!");
                        $("#msj_information_modal").text("Ups hubo un error al consultar la Pc, solo da click en el botón editar para completar los campos que faltan. Gracias!");
                        $("#informationModal").modal('show');

                      }else{

                        if (res.user_add != null) {
                          $("#user_id_show").val(res.user_add.nombre+' '+res.user_add.apellido)
                        }else{
                          $("#user_id_show").val('Cristian R.')
                        }
                        if (res.user_edit != null) {
                          $("#user_edit_show").val(res.user_edit.nombre)
                        }else{
                          $("#user_edit_show").val('Nadie')
                        }
                        if (res.mobi.path != null) {
                          $("#path_show").html('<img src="{{ URL::to('/') }}/imguser/'+res.mobi.path+'" style="width:100%;" class="img-thumbnail" alt="">')
                        }else{
                          $("#path_show").html('<img src="/images/mobi1.jpg" class="img-thumbnail" style="width:100%;" alt="">')
                        }
                        $("#clasificacion_show").val(res.mobi.clasificacion)
                        $("#modelo_show").val(res.mobi.modelo)
                        $("#marca_show").val(res.mobi.marca)
                        $('#numero_inv_show').val(res.mobi.numero_inventario)
                        $("#numero_serie_show").val(res.pc.num_serie_cpu)
                        $("#estado_show").val(res.mobi.estado)
                        $("#descripcion_show").val(res.mobi.descripcion)
                        $("#created_at_show").val(res.mobi.created_at)
                        $("#updated_at_show").val(res.mobi.updated_at)

                        html_pc += `
                          <div class="row">
                            <div class="col-md-4">
                              <label for="user_id_edit">Número de maquina</label>
                              <input type="text" class="form-control" value="`+res.pc.num_maquina+`" disabled>
                              <label for="first_name">Tiene Cámara?</label>`
                              if (res.pc.tiene_camara == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += '<label for="first_name">Tiene Bocinas?</label>'
                              if (res.pc.tiene_bocinas == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += `<label for="tipo_edit">Cantidad de RAM</label>
                              <input type="text" class="form-control" value="`+res.pc.ram+`" disabled>
                              <label for="user_id_edit">Paquetería Office</label>
                              <input type="text" class="form-control" value="`+res.pc.paq_office_version+`" disabled>
                            </div>
                            <div class="col-md-4">
                              <label for="user_id_edit">Cantidad de Disco Duro</label>
                              <input type="text" class="form-control" value="`+res.pc.disco_duro+`" disabled>
                              <label for="user_id_edit">Sistema Operativo</label>
                              <input type="text" class="form-control" value="`+res.pc.sistema_operativo+`" disabled>`;
                              html_pc += '<label for="first_name">Sistema Opertivo Activado?</label>'
                              if (res.pc.sistema_operativo_activado == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += '<label for="first_name">Tiene Cable VGA?</label>'
                              if (res.pc.cable_vga == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += '<label for="first_name">Paquetería Office Activado?</label>'
                              if (res.pc.paq_office_activado == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                            html_pc += `</div>
                            <div class="col-md-4">`;
                              html_pc += '<label for="first_name">Tiene Monitor?</label>'
                              if (res.pc.tiene_monitor == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                            html_pc += `<label for="user_id_edit">Número de Serie del Monitor</label>
                              <input type="text" class="form-control" value="`+res.pc.num_serie_monitor+`" disabled>`
                              html_pc += '<label for="first_name">Tiene Teclado?</label>'
                              if (res.pc.tiene_teclado == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += '<label for="first_name">Tiene Ratón?</label>'
                              if (res.pc.tiene_raton == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += '<label for="first_name">Tiene Controlador de Red?</label>'
                              if (res.pc.controlador_red == 1) {
                                html_pc += '<input type="text" class="form-control" value="Si" disabled>'
                              }else{
                                html_pc += '<input type="text" class="form-control" value="No" disabled>'
                              }
                              html_pc += `</div>
                          </div>
                          <div class="row">
                            <label for="user_id_edit">Observaciones</label>
                              <input type="text" class="form-control" value="`+res.pc.observaciones+`" disabled>
                          </div>`

                          $("#pc_detail_show").html(html_pc)

                          $(".modal-title").text('Detalle de '+res.mobi.clasificacion)
                          $("#mobiInfoModal").modal('show')
                      }
                    }
                  }
                })

              }
                
            } );

  });
</script>

<script type="text/javascript" src="{{ URL::asset('js/mobiliarioyequipo/mobi.js') }}"></script>

@endsection