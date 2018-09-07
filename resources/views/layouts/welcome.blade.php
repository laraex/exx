<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Config::get('settings.sitetitle') }}</title>

    <script>
   window.Laravel = {!!json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
   </script>

    <!-- Styles -->
    <link rel="icon" href="{{Config::get('settings.favicon')}}"  sizes="16x16">

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 @stack('headscripts')
</head>
<body>
    <div id="app">
    
        <div id="wrapper" class="wrapper">
            <div class="top-navigation">
                    @include('layouts.partials.menu')
            </div>
            <div class="member-navigation">
                @if ( Auth::check() && (Auth::id()!=1))
                    @include('layouts.partials.membermenu')
                @endif
            </div>
            <div id="banner" class="banner-scripn">
                    @yield('banner')
            </div>
            <div id="main" class="main">
                    @yield('content')
            </div>
            <div id="footer" class="footer">
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

        <!-- Flat Surface Shader effect -->
<script src="{{ asset('js/app.js') }}"></script>  
<style>
    {!!  Config::get('settings.footercss') !!}
</style>
@stack('bottomscripts')
</body>
</html>
