@extends('templates.index')

@section('title','Editar Libro')

@section('css')
<link href="{{ asset('css/multi-select/css/multi-select.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<style>
    .searchable{
        position: absolute; 
        left: -9999px;
    }
</style>

@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ route('backoffice.libro.index') }}">Libros</a></li>
        <li class="active">Editar</li>
@endsection

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Editar Libro
                        <small>Los campos * son <b>OBLIGATORIOS</b></small>
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('backoffice.libro.update',$libro) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('models.libro.form')
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
