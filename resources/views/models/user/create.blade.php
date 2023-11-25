@extends('templates.index')

@section('title','Crear Usuerio')

@section('css')
    <link rel="stylesheet" href="{{ asset('css\bootstrap-select\bootstrap-select.min.css') }}">

@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ route('backoffice.user.index') }}">Usuarios</a></li>
        <li class="active">Crear</li>

@endsection

@section('content')
    
    <div class="col-sm-6 col-sm-offset-3">
        <div class="card">
            <div class="header">
                <h2>
                    Crear Usuario <small>Los campos con * son <b>OBLIGATORIOS</b></small>
                </h2>
            </div>
            <div class="body">
                <form id="wizard_with_validation" action="{{ route('backoffice.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('models.user.form',['btnSubmit' => 'GUARDAR'])
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @if (session()->has('alert'))

     {!! session('alert') !!}  
    @endif
@endsection
