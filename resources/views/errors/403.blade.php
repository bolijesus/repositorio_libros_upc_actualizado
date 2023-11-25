@extends('errors.layout')

@section('title', '404 | Repositorio - UPC')

@section('content')
    <div class="error-code">403</div>
    <div class="error-message">No tienes permisos para realizar esta accion</div>
    <div class="button-place">
        <a href="{{ url('/') }}" class="btn btn-default btn-lg waves-effect">Volver a Inicio</a>
    </div>
@endsection