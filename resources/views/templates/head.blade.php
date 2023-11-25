<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title','TEMPLATE')</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('./favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/material-icons/icons.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('css/node-waves/waves.min.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('css/animate-css/animate-css.min.css') }}" rel="stylesheet" />

    @yield('css')

    <!-- Custom Css -->
    <link href="{{ asset('css/adminBSB/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.min.css') }}" rel="stylesheet" />
    
    {{-- CSS personal  --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="{{ asset('css/sweetalert/sweetalert.css') }}" rel="stylesheet" />

</head>
<body class="@yield('type_page','theme-upc')">