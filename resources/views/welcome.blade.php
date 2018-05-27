<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->

        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}"/>
        <link rel="stylesheet" href="/css/docs.934b36a.css"/>
    </head>
    <body>
        <div id="app">

        </div>

        <script src="https://unpkg.com/chart.js@2.7.2/dist/Chart.bundle.js"></script>
        <script src="https://unpkg.com/vue-chartkick@0.3.1"></script>
        <script type="text/javascript" src="{{mix('/js/app.js')}}"></script>

    </body>
</html>
