@extends('layouts.layout_home')

@section('links')

  <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  
    
  <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

  <style type="text/css" media="screen">
    .scrollable-menu {
    height: auto;
    max-height: 350px;
    overflow-x: hidden;
    position: absolute;
    
}

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

                </div>

            
                <div class="icono" id="open">
                    <!-- este codigo es para poner un icono de hamburguesa -->
                    <span>&#9776;</span>

                </div>

            </div>
                
        </nav>


        
        <div class="textos">
            <div class="container position-absolute">
            <div class="row">
                <div class="col-md-4">

                    <div class="container">
                      <div class="form-group">
                        <select class="custom-select form-control" id="drop_revisiones">
                          <option selected>Revisiones Rápidas</option>
                          <option value="1">Revisiones Detalladas</option>
                        </select>
                      </div>                            
                    </div>  

                </div>

                <div class="col-md-4">
                  <h1>Últimas Revisiones</h1>
                </div>
                
                <div class="col-md-4">

                    <div class="container">
                      <div class="form-group">
                        <select class="custom-select form-control" id="drop_lugares">
                          
                        </select>
                      </div>                            
                    </div>                          
                    
                    
                </div>
            </div>
        </div>       
        </div>



    </header>

@endsection


@section('content')


  <div class="container">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body">
        @csrf
        <div id="post_data"></div>
      </div>
    </div>

  </div>


  {{-- See Details form --}}
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
          
          <div class="form-group" id="rev_detallada_form">
            
          </div>
          <div class="form-group" id="rev_rapida_form">
            
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

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
        <p id="msj_information_modal1"></p>
        <p id="msj_information_modal2"></p>
        <p id="msj_information_modal3"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/revisiones/notificacion_rev.js')}}"></script>
<script src="{{ asset('js/nav_mobi.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
{{--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('js/revisiones/revisiones.js') }}"></script>

<script>
  $(function(){

    function infoColoresBotones(){
      $("#modalTitleInfo").text("Información sobre el color de los botones");
      $("#msj_information_modal").text("Datos que se obtuvieron según la revisión por medio de colores.");
      $("#msj_information_modal1").text("Verde: Todos los datos de la revisión concuerdan con las existencias reales del lugar.");
      $("#msj_information_modal1").css("color","green");
      $("#msj_information_modal2").text("Amarillo: Algunos datos de la revisión no concuerdan con la existencia real del lugar.");
      $("#msj_information_modal2").css("color","yellow");
      $("#msj_information_modal3").text("Rojo: Ningún dato de la revisión concuerda con las existencias reales del lugar.");
      $("#msj_information_modal3").css("color","red");
      $("#informationModal").modal("show");
    }

    infoColoresBotones();

      var _token = $('input[name="_token"]').val();

      load_data('', _token);

//Mandamos a traer todos los lugares

 function allLugares(){
  var html = ``;
  $.ajax({
    url: "{{ route('rev.allLugares') }}",
    method: "get",
    //data: {id:id, _token:_token},
    success:function(data){
      
      for(var i = 0; i <= data.length; i++){
        html += '<option value="'+data[i].id+'" id="btnLugarId'+data[i].id+'">'+data[i].nombre+'</option>';
        
        $("#drop_lugares").html(html);
        $("#drop_lugares").on('change', function(){
        console.log($("#btnLugarId"+data[i].id+"").val());
      });
      }

    }
  });
 }



 allLugares();

      function load_data(id = "", _token){
        
        $.ajax({
          url: "{{ route('rev.ultimasloadmore') }}",
          method: 'post',
          data: {id:id, _token:_token},
          success:function(data){
            $('#load_more_button').remove();
            $('#post_data').append(data);
          }
        });
      }

      $(document).on('click', '#load_more_button', function(){
        var id = $(this).data('id');
        $("#load_more_button").html('<b>Cargando...</b>');
        load_data(id, _token);
      });

      function load_unseen_revisions(view = ''){
                
                $.ajax({
                    url: "/notify_revs",
                    method: "POST",
                    data: {view:view,_token:_token},
                    dataType: "json",
                    success:function(data){
                        $(".dropdown-menu").html(data.notification);
                        if (data.unseen_notification > 0) {
                            $(".count").html(data.unseen_notification);
                        }
                    }
                });
                
            }

      
    });
</script>
@endsection