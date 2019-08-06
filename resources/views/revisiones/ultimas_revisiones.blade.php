@extends('layouts.layout_home')

@section('links')

  	 <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  
    
    <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
                  <a href="{{ url('/') }}" class="btn-header"><i class="fas fa-home"></i></a>

                </div>

            
                <div class="icono" id="open">
                    <!-- este codigo es para poner un icono de hamburguesa -->
                    <span>&#9776;</span>

                </div>

            </div>
                
        </nav>


        
        <div class="textos">
            <h1>Últimas Revisiones</h1>            
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


@endsection

@section('scripts')
<script src="{{ asset('js/revisiones/notificacion_rev.js')}}"></script>
<script src="{{ asset('js/nav_mobi.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('js/revisiones/revisiones.js') }}"></script>
<script>
  $(function(){

      var _token = $('input[name="_token"]').val();

      load_data('', _token);

      function load_data(id = "", _token){
        $.ajax({
          url: "{{ route('rev.ultimasloadmore') }}",
          method: "post",
          data: {id:id, _token:_token},
          success:function(data){
            $('#load_more_button').remove();
            $('#post_data').append(data);
          }
        });
      }

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
      

      $(document).on('click', '#load_more_button', function(){
        var id = $(this).data('id');
        $("#load_more_button").html('<b>Cargando...</b>');
        load_data(id, _token);
      });

      
    });
</script>
@endsection