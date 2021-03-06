@extends('layouts.layout_home')

@section('links')
<link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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

                </div>

            
                <div class="icono" id="open">
                    <!-- este codigo es para poner un icono de hamburguesa -->
                    <span>&#9776;</span>

                </div>

                

            </div>
                   
        </nav>

        <div class="textos">
            <h1>Lugares</h1>
            
        </div>

    </header>

@endsection


@section('content')
	
	<div class="container">
		@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Auxiliar')
		<div class="right">
			<button type="button" name="agregar_lugar" id="agregar_lugar" class="btn btn-success btn-sm">Agregar Nuevo Lugar</button>
		</div>
		@endif
		<br>
	<table class="table table-bordered" id="lugares_table" style="width: 100%;">
		<thead>
			<tr>
				<th>Foto</th>
				<th>Nombre</th>
				<th>Agregó</th>
				<th>Actualizó</th>
				<th>Actualizado</th>
				@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Auxiliar')
				<th>Opciones</th>
				@endif
				@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Auxiliar')
				<th>Eliminar multiples <button type="button" class="btn btn-danger btn-xs" name="bulk_delete" id="bulk_delete_lugar"><i class="fas fa-trash-alt"></i></button></th>
				@endif
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<br>
	</div>

	{{-- Here create tha add modal--}}
	<div class="modal" id="lugarModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" id="lugar-form">
				<div class="modal-header">
					<h5 class="modal-title"></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
				</div>
				<div class="modal-body">
					@csrf
					<span id="form-output"></span>
					<div class="form-group">
						<label for="nombre">Ingresa el nombre del lugar</label>
						<input type="text" class="form-control" name="nombre" id="nombre">
					</div>
					<div class="form-group">
						<label for="foto">Selecciona la foto del lugar</label>
						<input type="file" class="form-control" name="foto_lugar" id="foto">
						<span id="store_image_edit"></span>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="lugar_id" id="lugar_id" value="insert_lugar">
					<input type="hidden" name="button_action" id="button_action" value="insert_lugar">
					<input type="hidden" name="user_add" id="user_add" value="{{ Auth::id() }}">
					<input type="hidden" name="user_edit" id="user_edit" value="{{ Auth::id() }}">
					<input type="submit" class="btn btn-info" name="submit" id="action" value="Agregar">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- Confirmation Modal --}}
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
    <script
			  src="https://code.jquery.com/jquery-3.3.1.js"
			  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
			  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
{{--<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>--}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<script>

	$(document).ready(function(){

		$("#lugares_table").DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "{{ route('lugares.getdata') }}",
			"columns": [
				{ data: 'foto',
                  name: 'foto',
					render: function(data, type, full, meta){
						if (data != null) {
							return '<img src="{{ URL::to('/') }}/imguser/'+data+'" width="70" class="img-tumbnail">'
						}else{
							return '<img src="/images/mobi1.jpg" width="70" class="img-tumbnail">'
						}
                      },
                orderable:false},
				{"data": "nombre"},
				{"data": "user_add",
				 "name": "user_add"},
				{"data": "user_edit"},
				{ "data" : "updated_at"},
				@if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Auxiliar')
				{ "data" : "action",
                      render: function(data, type, full, meta){
                        return data;
                      },
                   orderable:false, searchable:false},
                @endif
                @if(Auth::user()->tipo_usuario == 'Jefe' || Auth::user()->tipo_usuario == 'Auxiliar')
				{ "data" : "checkbox", orderable:false, searchable:false}
				@endif
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
		$("#agregar_lugar").on('click', function(){
			$("#lugarModal").modal('show');
			$("#lugar-form")[0].reset();
			$("#form-output").html('');
			$(".modal-title").text('Agregar nuevo lugar')
			$("#button_action").val('insert_lugar');
			$("#store_image_edit").html('');
			$("#action").val('Agregar');
		});

//Function to add a new place in the lugars table
		$("#lugar-form").on('submit', function(event){
			event.preventDefault();
			//var form_data = $(this).serialize();
			$.ajax({
				url: '{{ route("lugares.postdata") }}',
				method: "POST",
				data: new FormData(this),
				contentType: false,
		        cache: false,
		        processData: false,
				dataType: "json",
				success: function(data){
					if (data.error.length > 0) {
						var error_html = '';

						for(var count = 0; count < data.error.length; count++){
							error_html += '<div class="alert alert-danger">'
								+data.error[count]+
							'</div>';
						}

						$("#form-output").html(error_html);
					}else{
						//$("#form-output").html(data.success);
						$("#lugar-form")[0].reset();
						$("#action").val('Agregar');
						$(".modal-title").html('Agregar Lugar');
						$("#button_action").val('insert');
						$("#lugarModal").modal('hide');
						$("#lugares_table").DataTable().ajax.reload();
						alert(data.success);
					}
				},
			});
		});

//Function to edit the lugar data
		$(document).on('click', '.edit-lugar', function(){
			event.preventDefault();
			$("#form-output").html('');
			var id = $(this).attr('id');
			$.ajax({
				url: "{{ route('lugares.fetchdata') }}",
				method: "GET",
				data: {id: id},
				dataType: 'json',
				success:function(data){
					$("#nombre").val(data.nombre);
					$("#store_image_edit").html('<img src="/imguser/'+data.foto+'" width="70" class="img-thumbnail">');
					$("#lugar_id").val(id);
					$("#lugarModal").modal('show');
					$("#action").val('Editar');
					$(".modal-title").text('Editar Lugar');
					$("#button_action").val('update_lugar');
				}
			});
		});

//Function to delete a lugar
		$(document).on('click', '.delete-lugar', function(){
			event.preventDefault();
			var id = $(this).attr('id');
			$("#confirmation_modal").modal('show');
			$("#modalTitleDelete").text('Eliminar Lugar');
			$("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar este lugar?');
			$("#msj_confirmation_modal2").text('Toma en cuenta que si el lugar tiene mobiliario o equipo el sistema no te dejará eliminarlo');
			$("#confirm_yes").on('click', function(){
				$.ajax({
					url: "{{ route('lugares.removedata') }}",
					method: "get",
					data: {id: id},
					success: function(data){
						if (data != 1) {
							$("#confirmation_modal").modal('hide');
							$("#lugares_table").DataTable().ajax.reload();
							$("#informationModal").modal('show');
							$("#msj_information_modal").text(data);
						}else{
							$("#confirmation_modal").modal('show');
							$("#modalTitleDelete").text('Eliminar Lugar');
							$("#msj_confirmation_modal").text('Desea Continuar?');
							$("#msj_confirmation_modal2").text('Se ELIMINARAN todas las revisiones de este lugar');
							$("#confirm_yes").on('click', function(){
								deleteRevNLugar(id);
							});
						}
					}
				});
			});
		});

		function deleteRevNLugar(id_lugar){
			var id = id_lugar;
			$.ajax({
					url: "{{ route('lugares.destroyrev') }}",
					method: "get",
					data: {id: id},
					success: function(data){
							$("#confirmation_modal").modal('hide');
							$("#lugares_table").DataTable().ajax.reload();
							$("#informationModal").modal('show');
							$("#msj_information_modal").text(data);
					}
				});
		}

//Function to delete multiples lugares to the same time
		$(document).on('click','#bulk_delete_lugar', function(){
			event.preventDefault();
			var id = [];
			
				$('.lugar_checkbox:checked').each(function(){
					id.push($(this).val());
				});

				if (id.length > 0) {
					$("#confirmation_modal").modal('show');
					$("#modalTitleDelete").text('Eliminar Lugares');
					$("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar estos lugares?');
					$("#confirm_yes").on('click', function(){
						$.ajax({
							url: "{{ route('lugares.massRemove') }}",
							method: "get",
							data: {id: id},
							success: function(data){
								if (data != 1) {
									$("#confirmation_modal").modal('hide');
									$("#lugares_table").DataTable().ajax.reload();
									$("#informationModal").modal('show');
									$("#msj_information_modal").text(data);
								}else{
									$("#confirmation_modal").modal('show');
									$("#modalTitleDelete").text('Eliminar Lugar');
									$("#msj_confirmation_modal").text('Desea Continuar?');
									$("#msj_confirmation_modal2").text('Se ELIMINARAN todas las revisiones de este lugar');
									$("#confirm_yes").on('click', function(){
										deleteRevNLugar(id);
									});
						}
							}
						});
					});
				}else{
					$("#informationModal").modal('show');
					$("#msj_information_modal").text("Por favor, seleccione al menos una casilla de verificación");
				}

		});

	});
</script>
@endsection

	