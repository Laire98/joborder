<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('js/fontawesome.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{asset('js/jquery-3.6.4.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/chart.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/html2pdf.bundle.min.js') }}" crossorigin="anonymous"></script>

    </head>

    <body>

        @yield('maincontent')

    </body>
</html>
