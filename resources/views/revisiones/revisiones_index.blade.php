@extends('layouts.layout_home')

@section('links')

  	 <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  
    
    <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
{{-- This link provide of a bootstrap datepicker --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">

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
            <h1>Revisiones</h1>
            
            <h2>
              Estas en {{ $lugares->nombre }}
            </h2>
            
        </div>

    </header>

@endsection


@section('content')
  <br>
  <div class="container">
  <div class="row">
    <div class="col">
      <button type="button" class="btn btn-success float-right" onClick="itemsQuantity({{ $lugares->id }})">Ver Cantidades por Ítems</button>
    </div>
  </div>
</div>

<!-- Cantidades de Items -->
<div class="modal fade bd-example-modal-lg" id="itemsCantModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel">Cantidades de Ítems Existentes</h5>
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

  <div class="row align-items-center justify-content-center">
            <div class="col-md-5">
              <div class="input-group input-daterange">
                De <input type="text" name="from_date" id="from_date" readonly class="form-control">
                <div class="input-group-addon"> a </div>
                <input type="text" name="to_date" id="to_date" readonly class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              
                <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Filtrar Fechas</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Restaurar</button>
              
            </div>
  </div>


<div class="table-responsive">

{{-- Here I created the table and assigned an id with which I will load the DataTable --}}
      <table class="table table-striped table-bordered" id="revs_table">
        <thead>
          <tr>
            <th>Nombre del Revisor</th>
            <th>Lugar</th>
            <th>Tipo de Revisión</th>
            <th>Momento</th>
            <th>Observaciones</th>
            <th>Actualizado</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>


{{-- Edit form --}}
<div class="modal fade" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="revisionEditModal" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <form method="POST" id="rev_edit_form">
        <div class="modal-header">
          <h4 class="modal-title">Detalles de Revisión</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @csrf
          <span id="form-output"></span>
          <div class="row">
            <label for="user_id_edit" id="label_user_edit">Usuario</label>
            <input type="text" class="form-control" name="user_id_edit" id="user_id_edit" disabled>
            <label for="first_name" id="label_lugar_edit">Lugar</label>
            <input type="text" class="form-control" name="lugar_id_edit" id="lugar_id_edit" disabled>
          </div>

          <div class="form-group">
            
          </div>
           <div class="row">
            <label for="tipo_edit" id="label_tipo_edit">Tipo</label>
            <input type="text" class="form-control" id="tipo_edit" disabled>
            <label for="momento_edit" id="label_momento_edit">Momento</label>
            <input type="text" class="form-control" name="momento_edit" id="momento_edit" disabled>
          </div>
           <div class="form-group">
            
          </div>
           <div class="form-group">
            <label for="first_name">Observaciones</label>
            <input type="text" class="form-control" name="observaciones_edit" id="observaciones_edit" disabled>
          </div>
           
          {{--<div class="form-group">
            <label for="last_name">Actualizado</label>
            <input type="text" class="form-control" name="updated_at_edit" id="updated_at_edit" disabled>
          </div>--}}
          
          <div class="form-group" id="rev_detallada_form">
            
          </div>
          <div class="form-group" id="rev_rapida_form">
            
          </div>

        </div>
        <div class="modal-footer">
          {{--<input type="hidden" name="rev_id_edit" id="rev_id_edit">
          <input type="hidden" name="revdet_id_edit" id="revdet_id_edit">--}}
          
          {{--<input type="submit" class="btn btn-info" name="submit" id="action" value="Editar">--}}
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>    



{{-- Information Modal --}}
<div class="modal" id="informationModal" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleInfo"></h5>
        <span id="total_records"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive" id="content_modal_body">
        
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Nombre del Revisor</th>
                  <th>Lugar</th>
                  <th>Tipo de Revisión</th>
                  <th>Momento</th>
                  <th>Observaciones</th>
                  <th>Actualizado</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody id="table_body_range">
                
              </tbody>
            </table>
        </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_aceptar_info" data-dismiss="modal">Nueva Búsqueda</button>
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
{{-- Date Picker From Bootstrap --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
  $(document).ready(function() {

            $('#revs_table').DataTable({
                "serverSide": true,
                "ajax": "{{ route('revisiones.lugarrev', $lugares->id) }}",
                "columns":[
                    {data: 'user_id'},
                    {data: 'lugar_id'},
                    {data: 'tipo'},
                    {data: 'momento'},
                    {data: 'observaciones'},
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


      var date = new Date();
      $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        autoclose: true
      });
      var _token = $('input[name="_token"]').val();


      function fetch_data(from_date = '', to_date = ''){
        $.ajax({
          url: "{{ route('revdaterange.fetch_data', $lugares->id) }}",
          method: "get",
          data: {from_date:from_date, to_date:to_date, _token:_token},
          dataType: "json",
          success:function(data){
            var output = '';
            //$('#total_records').text('Total de registros encontrados: '+data.length);

            for (var i = 0; i < data.revs.length; i++) {
              output += '<tr>';
              //if (data.user.id == data.revs[i].user_id) {
                for (var j = 0; j < data.user.length; j++) {
                  if (data.user[j].id == data.revs[i].user_id) {
                    output += '<td>' + data.user[j].nombre +'</td>'; 
                  }
                }
              //}
              output += '<td>' + data.lugar + '</td>';
              output += '<td>' + data.revs[i].tipo + '</td>';
              output += '<td>' + data.revs[i].momento + '</td>';
              output += '<td>' + data.revs[i].observaciones + '</td>';
              output += '<td>' + data.act[i] + '</td>';
              output += '<td><a href="javascript:void(0)" class="btn btn-xs btn-info edit-rev" id="'+data.revs[i].id+'"><i class="fas fa-eye"></i></a>';//<a href="#" class="btn btn-xs btn-danger delete-rev" id="'+data.revs[i].id+'"><i class="fas fa-trash-alt"></i></a></td>';
              output += '</tr>';
            }
            $("#modalTitleInfo").text('Total de registros encontrados: '+data.revs.length);
            $("#table_body_range").html(output);
            $("#informationModal").modal('show');

            //$('tbody').html(output);
            //console.log(data.user + ' - '+data.lugar+' - '+data.revs);
            
          }
        });

  

      }

      $('#filter').on('click', function(){
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

        if (from_date != '' && to_date != '') {
          fetch_data(from_date, to_date);
          
        }else{
          alert('Se requieren ambas fechas');
        }

      });

      $('#refresh,#btn_aceptar_info').on('click', function(){
        $('#from_date').val('');
        $("#to_date").val('');
        $("#revs_table").DataTable().ajax.reload();
      });


  });
</script>
<script type="text/javascript" src="{{ URL::asset('js/revisiones/revisiones.js') }}"></script>
@endsection