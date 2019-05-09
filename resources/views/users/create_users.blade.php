@extends('layouts.layout_home')

@section('links')

	<link rel="stylesheet" href="{{ asset('css/user.css') }}">
  
  <link rel="stylesheet" href="{{ asset('css/tablauser.css') }}">

  <link href="{{ URL::asset('css/nav_mobi.css') }}" rel="stylesheet" type="text/css" >

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">    

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
                    
                    <!--<a href="#" id="enlace-mobi" class="btn-header">Revisiones</a>
                    <a href="#" id="enlace-revision" class="btn-header">Contacto</a>-->

                    
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
      <button onclick="cargarFormualrioUser(1);">agregar</button>
    </header>

@endsection


@section('content')

{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">--}}

            	<div id="notificacion_result_fanu"></div>

<div class="contenido-principal" id="contenido-principal">

                <div class="card-header">{{ __('Registrar Usuarios') }}</div>

                <div class="card-body">

                    <form id="f_nuevo_usuario" method="POST" action="{{ route('agregaruser') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombres') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apellido" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>

                            <div class="col-md-6">
                                <input id="apellido" type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ old('apellido') }}" required autofocus>

                                @if ($errors->has('apellido'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ old('telefono') }}" required autofocus>

                                @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_usuario" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Usuario') }}</label>

                            <div class="col-md-6">
                            	<select name="tipo_usuario" id="tipo_usuario" class="form-control{{ $errors->has('tipo_usuario') ? ' is-invalid' : '' }}" value="{{ old('tipo_usuario') }}" required autofocus>
                            		<option selected="true" disabled="disabled">Seleccionar</option>
                            		<option value="Administrador">Administrador</option>
                            		<option value="Responsable">Responsable</option>
                            		<option value="Prestador">Prestador</option>
                            		<option value="Revisor">Revisor</option>
                            	</select>
                                

                                @if ($errors->has('tipo_usuario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipo_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="path" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <input id="path" type="file" class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}" name="path" value="{{ old('path') }}" required>

                                @if ($errors->has('path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numcontrol" class="col-md-4 col-form-label text-md-right">{{ __('N# de Control') }}</label>

                            <div class="col-md-6">
                                <input id="numcontrol" type="text" class="form-control{{ $errors->has('numcontrol') ? ' is-invalid' : '' }}" name="numcontrol" value="{{ old('numcontrol') }}" autofocus>

                                @if ($errors->has('numcontrol'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numcontrol') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            {{--</div>
        </div>
    </div>
</div>--}}

@endsection

@section('scripts')

<script src="{{ asset('js/nav_mobi.js') }}"></script>
<script src="{{ asset('js/users/create_users.js') }}"></script>
<script src="{{ asset('js/bubble.js') }}"></script>

@endsection
