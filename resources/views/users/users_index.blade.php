@extends('layouts.layout_home')

@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="{{ asset('css/user.css') }}">
  
  <link rel="stylesheet" href="{{ asset('css/tablauser.css') }}">

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
                    <img src="images/logo_ittg.png" alt="">
                </div>
                <div class="enlaces" id="enlaces">
                    <a href="{{ url('/home') }}" id="enlace-inicio" class="btn-header">Inicio</a>

                    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
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

<div class="container">
    <div class="right">
      <button type="button" name="agregar_user" id="agregar_user" class="btn btn-success btn-sm">Agregar Nuevo Usuario <i class="fas fa-plus"></i></button>
    </div>
    <div class="table-responsive">
        <table id="users_table" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>Foto</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>Tipo de Usuario</th>
              <th>Email</th>
              <th>Num. de Control</th>
              <th>Actualizado</th>
              <th>Opciones</th>
              <th><button type="button" class="btn btn-danger btn-xs" name="bulk_delete" id="bulk_delete_user"><i class="fas fa-user-times"></i></button></th>
            </tr>
          </thead>
        </table>
    </div>   
      
    </div>


{{-- Form CReate User --}}
<div class="modal fade" id="userModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitleUser">Agregar un Lugar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
      </div>
      <div class="modal-body">
        <span id="form_output"></span>
        <form method="post" role="form" id="user_form" class="form-horizontal">
          {{ csrf_field() }}

          <div class="form-group row add">
            <label for="title" class="control-label col-sm-2">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre..." required>
            </div>
          </div>
          
          <div class="form-group row add">
              <label for="apellido" class="control-label col-sm-2">Apellido</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escribe tu apellido..." required>
              </div>
          </div>

          <div class="form-group row add">
              <label for="telefono" class="control-label col-sm-2">Telefono</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe tu teléfono..." required>
              </div>
          </div>

          <div class="form-group row add">
              <label for="tipo_usuario" class="control-label col-sm-2">Tipo</label>
              <div class="col-sm-10">
                <select name="tipo_usuario" id="tipo_usuario">
                  @foreach($enum as $en)
                  <option value="{{$en}}">{{$en}}</option>
                  @endforeach
                </select>
              </div>
          </div>

          <div class="form-group row add">
              <label for="email" class="control-label col-sm-2">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" name="email" placeholder="Escribe tu email..." required>
              </div>
          </div>

          <div class="form-group row add">
              <label for="password" class="control-label col-sm-2">Contraseña</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Escribe tu contraseña..." required>
              </div>
          </div>

          <div class="form-group row">
              <label for="password-confirm" class="control-label col-sm-2">{{ __('Confirmar Contraseña') }}</label>
                  <div class="col-md-10">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar Contraseña...">
                  </div>
            </div>

          <div class="form-group row add">
              <label for="foto" class="control-label col-sm-2">Foto</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="foto" name="foto" required>
              </div>
          </div>

          <div class="form-group row add">
              <label for="numcontrol" class="control-label col-sm-2">Num# de Control</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="numcontrol" name="numcontrol" placeholder="Escribe tu número de control...">
              </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <input type="hidden" name="user_id" id="user_id" value="insert_user">
          <input type="hidden" name="button_action" id="button_action" value="insert_user">
        <button type="submit" id="action_user" class="btn btn-warning">
          <span class="fa fa-plus"></span>Guardar Usuario
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="fa fa-times-circle"></span>Cerrar
        </button>
      </div>
      </form>

    </div>
  </div>
</div>


{{-- Form Show User --}}
<div class="modal fade" id="show-user" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <img id="path_user" src="imguser/" alt="" style="width: 100px; height: 100px;"/>
        <p>Path: <span id="path_u"></span></p>
        <p>Id: <span id="id_user"></span></p>
        <p>Nombre: <span id="nombre_user"></span></p>
        <p>Apellido: <span id="apellido_user"></span></p>
        <p>Teléfono: <span id="telefono_user"></span></p>
        <p>Tipo de Usuario: <span id="tipo_user"></span></p>
        <p>Email: <span id="email_user"></span></p>
        <p>Pass: <span id="pass_user"></span></p>
        <p>Num# de Control: <span id="numcontrol_user"></span></p>
        <p>Creado: <span id="created_user"></span></p>
        <p>Actualizado: <span id="updated_user"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-earing" data-dismiss="modal">
          <span class="fa fa-remove"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>


{{-- Edit form --}}
<div class="modal fade" id="userEditModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <span id="form_result1"></span>
      <form method="POST" id="user_form_edit">
        <div class="modal-header">
          <h4 class="modal-title">Editar Usuario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @csrf
          <span id="form-output"></span>
          <div class="form-group">
            <label for="first_name">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="nombre_edit" required>
          </div>
           <div class="form-group">
            <label for="first_name">Apellido</label>
            <input type="text" class="form-control" name="apellido" id="apellido_edit" required>
          </div>
           <div class="form-group">
            <label for="first_name">Teléfono</label>
            <input type="text" class="form-control" name="telefono" id="telefono_edit" required>
          </div>
           <div class="form-group">
            <label for="first_name">Tipo de Usuario</label>
            <input type="text" class="form-control" name="tipo_usuario" id="tipo_usuario_edit" disabled>
            
                {{--<select name="tipo_usuario_select" id="tipo_usuario">
                  @foreach($enum as $en)
                  <option value="{{$en}}">{{$en}}</option>
                  @endforeach
                </select>--}}
              
          </div>
           <div class="form-group">
            <label for="first_name">Email</label>
            <input type="text" class="form-control" name="email" id="email_edit" required>
          </div>
          <div class="form-group">
            <label for="last_name">Foto</label>
            <input type="text" class="form-control" name="path" id="path_edit" disabled>
            <input type="file" name="path_file" id="path_edit_file">
            <span id="store_image_edit"></span>
          </div>
          <div class="form-group">
            <label for="last_name">Número de Control</label>
            <input type="text" class="form-control" name="numcontrol" id="numcontrol_edit">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_id" id="user_id_edit">
          <input type="hidden" name="button_action" id="button_action">
          <input type="submit" class="btn btn-info" name="submit" id="action" value="Editar">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

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
        <button type="button" id="confirm_yes" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
    

@endsection

@section('scripts')

<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="js/nav_mobi.js"></script>
<script src="{{ asset('js/users/create_users.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {

            $('#users_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('users.getdata') }}",
                "columns":[
                    {
                      data: 'path',
                      name: 'path',
                      render: function(data, type, full, meta){
                        return '<img src="{{ URL::to('/') }}/imguser/'+data+'" width="70" class="img-tumbnail">'
                      },
                      orderable: false
                    },
                    {data: 'nombre'},
                    {data: 'apellido'},
                    {data: 'telefono'},
                    {data: 'tipo_usuario'},
                    {data: 'email'},
                    {data: 'numcontrol'},
                    {data: 'updated_at'},
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "checkbox", orderable:false, searchable:false}
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


    //Function to create a new place
    $("#agregar_user").on('click', function(){
      $("#userModal").modal('show');
      $("#user_form")[0].reset();
      $("#form_output").html('');
      $("#button_action").val('insert_user');
      $("#modalTitleUser").text('Agregar Nuevo Usuario');
      $("#action").val('Agregar');
    });

    $("#user_form").on('submit', function(event){
      event.preventDefault();

      $.ajax({
        url: "{{ route('users.agregaruser') }}",
        method: "post",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success:function(data){
          var html = '';
          if (data.errors) {
            html = '<div class="alert alert-dager">';
            for (var i = 0; i < data.errors.length; i++) {
              html += '<p>'+data.errors[i]+'</p>';
            }
            html += '</div';
          }
          if (data.success) {
            html = '<div class="alert alert-success">'+data.success+'</div>'
            $("#user_form")[0].reset();
            $("#users_table").DataTable().ajax.reload();
          }
          $("#form_output").html(html);
        }
      });

    });

    //Function for obtain the data to edit
    $(document).on('click', '.edit-user', function(event){
      event.preventDefault();
      //$("#form-output").html('');
      var id = $(this).attr('id');
      $.ajax({
        url: "{{ route('users.fetchdata') }}",
        method: "GET",
        data: {id: id},
        dataType: 'json',
        success:function(html){
          $("#nombre_edit").val(html.data.nombre);
          $("#apellido_edit").val(html.data.apellido);
          $("#telefono_edit").val(html.data.telefono);
          $("#tipo_usuario_edit").val(html.data.tipo_usuario);
          $("#email_edit").val(html.data.email);
          $("#path_edit").val(html.data.path);
          $("#store_image_edit").html('<img src="{{ URL::to('/') }}/imguser/'+html.data.path+'" width="70" class="img-thumbnail">');
          //$("#store_image").append('<input type="hidden" name="hidden_image" value="'+html.data.path+'" />');
          $("#numcontrol_edit").val(html.data.numcontrol);
          $("#user_id_edit").val(html.data.id);
          $("#userEditModal").modal('show');
          $("#action").val('Editar');
          $(".modal-title").text('Editar Usuario');
          $("#button_action").val('update_user');
        }
      });
      
    });

    $('#user_form_edit').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url: "/users/update",{{--"{{ route('ajax-crud.update') }}",--}}
            method: "post",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
              var html = '';
              if (data.errors) {
                html = '<div class="alert alert-danger">';
                for (var i = 0; i < data.errors.length; i++) {
                  html += '<p>'+ data.errors[i] +'</p>'
                }
                html += '</div>';
              }
              if (data.success) {
                html = '<div class="alert alert-success">'+ data.success +'</div>';
                $("#user_form_edit")[0].reset();
                $("#store_image").html('');
                $("#form_result1").html(html); 
                $("#userEditModal").modal('hide');
              }
              $("#users_table").DataTable().ajax.reload();
              alert('Usuario Actulizado Correctamente');
            }
          });

      });


    //Function to delete a User
    $(document).on('click', '.delete-user', function(){
      event.preventDefault();
      var id = $(this).attr('id');
      $("#confirmation_modal").modal('show');
      $("#modalTitleDelete").text('Eliminar Usuario');
      $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar este Usuario?');
      $("#confirm_yes").on('click', function(){
        $.ajax({
          url: "{{ url('users/destroy') }}",
          method: "get",
          data: {id: id},
          success: function(data){
            $("#confirmation_modal").modal('hide');
            $("#users_table").DataTable().ajax.reload();
            alert(data);
          }
        });
      });
    });

//Function to delete multiples Users to the same time
    $(document).on('click','#bulk_delete_user', function(){
      event.preventDefault();
      var id = [];
      
        $('.user_checkbox:checked').each(function(){
          id.push($(this).val());
        });

        if (id.length > 0) {
          $("#confirmation_modal").modal('show');
          $("#modalTitleDelete").text('Eliminar Usuarios');
          $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar estos Usuarios permanentemente?');
          $("#confirm_yes").on('click', function(){
            
              $.ajax({
                url: "{{ route('users.multiplesDestroy') }}",
                method: "get",
                data: {id: id},
                success: function(data){
                  $("#confirmation_modal").modal('hide');
                  $("#users_table").DataTable().ajax.reload();
                  alert(data);
                }
              });
            
          });
        }else{
          alert("Por favor, seleccione al menos una casilla de verificación");
        }

    });


});


  //Show User function
    $(document).on('click','.showuser-modal', function(){
      $("#show-user").modal('show');
      $(".modal-title").text('Ver Usuario');
      $("#path_user").attr("src", $(this).data('path'));
      $("#path_u").text($(this).data('path'));
      $("#id_user").text($(this).data('id'));
      $("#nombre_user").text($(this).data('nombre'));
      $("#apellido_user").text($(this).data('apellido'));
      $("#telefono_user").text($(this).data('telefono'));
      $("#tipo_user").text($(this).data('tipo'));
      $("#email_user").text($(this).data('email'));
      $("#pass_user").text($(this).data('password'));
      $("#numcontrol_user").text($(this).data('numcontrol'));
      $("#created_user").text($(this).data('created_at'));
      $("#updated_user").text($(this).data('updated_at'));
    });
</script>

@endsection