<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TicTacToe</title>

        <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}">
    </head>
    <body>
        <div id="wrapper">
            @include('layouts.top-bar')
            @yield('content')
        </div>
        @include('layouts.modal');
        <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
