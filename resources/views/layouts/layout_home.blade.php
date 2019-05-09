<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Relab') }}</title>

    @yield('styles')

    @yield('links')
    

</head>
<body class="hidden">
    <div class="centrado" id="onload">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>  
    </div>
        @yield('nav')

        
        @yield('content')


    @yield('scripts')
</body>


</html>
