@extends('errors.layout')

@section('title', 'No verificado | Repositorio - UPC')

@section('content')
    <div class="error-code">VERIFICACION EN CURSO</div>
    <div class="error-message">Aun no se ha verificado su cuenta, por favor espere o comuniquese con registro y control</div>
    <div class="button-place">
        <a href="{{ url('/') }}" class="btn btn-default btn-lg waves-effect">Volver a Inicio</a>
    </div>
@endsection