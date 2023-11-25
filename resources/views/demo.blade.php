@extends('templates.index')

@section('title','Titulo DEMO')

@section('css')
   {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    {{-- <li><a href="javascript:void(0);">Home</a></li>
        <li><a href="javascript:void(0);">Library</a></li>
        <li class="active">Data</li> --}}
@endsection

@section('content')



@section('scripts')
{{-- <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script> --}}
<script src="{{ asset('js/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2/run.js') }}"></script>

@endsection
