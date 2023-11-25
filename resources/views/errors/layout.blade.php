<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('tittle','ERROR PAGE')</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('css/node-waves/waves.min.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('css/adminBSB/style.css') }}" rel="stylesheet">
</head>

<body class="four-zero-four">
    <div class="four-zero-four-container">
        @yield('content')
    </div>

    <!-- Jquery Core Js -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('js/node-waves/waves.min.js') }}"></script>
</body>

</html>