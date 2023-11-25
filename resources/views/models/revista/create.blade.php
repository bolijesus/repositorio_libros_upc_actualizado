@extends('templates.index')

@section('title','Crear Revista')

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ route('backoffice.revista.index') }}">Revistas</a></li>
        <li class="active">Subir</li>
@endsection

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Subir Revista
                        <small>Los campos * son <b>OBLIGATORIOS</b></small>
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('backoffice.revista.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('models.revista.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="{{ asset('js/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2/run.js') }}"></script>

@endsection
