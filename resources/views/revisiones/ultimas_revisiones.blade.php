@extends('layouts.layout_home')

@section('links')

  	 <link rel="stylesheet" href="{{ asset('css/mobi.css') }}">
  
    
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
                    
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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


@endsection

@section('scripts')
<script src="{{ asset('js/nav_mobi.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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

      $(document).on('click', '#load_more_button', function(){
        var id = $(this).data('id');
        $("#load_more_button").html('<b>Cargando...</b>');
        load_data(id, _token);
      });

    });
</script>
@endsection