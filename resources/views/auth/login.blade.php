@extends('layouts.app')

@section('links')

<link rel="stylesheet" href="css/login.css">

@endsection

@section('content')

<div class="container-all">

        <div class="container-form">

            <img src="images/logo_ittg.png" alt="" class="logo">
            <h1 class="title">Iniciar Sesión</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <label for="">Email</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <label for="">Contraseña</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordarme') }}
                                    </label>
                                </div>
                            </div>
                        </div>


                <button type="submit">
                    {{ __('Iniciar Sesión') }}
                </button>

            </form>

            <!--<span class="text-footer">No tienes cuenta? <a href="#">Click aquí</a></span>-->
            @if (Route::has('password.request'))
            <span class="text-footer">Olvidaste tu contraseña?<a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Click aquí') }}</a></span>
            @endif
            
        </div>

        <div class="container-text">
            <div class="capa"></div>
            <h1 class="title-description">Relab</h1>
            <p class="text-description">Sistema para el control de inventario del departamento de sistemas del Tecnológico Nacional de México Campus Tuxtla Gutiérrez, el uso de este software es de manera limitada a diferentes tipos usuarios, para más información contacte con el departamento de sistemas o con el desarrollador.</p>
            <p class="text-description"><a href="/SistemaRevisiones.apk">Sistema</a></p>

        </div>
        
    </div>
    
@endsection
