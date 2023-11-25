@extends('templates.index')

@section('title','Crear Autores')

@section('css')
    {{-- <link rel="stylesheet" href="style.css"> --}}
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
<li><a href="{{ url('/') }}">Inicio</a></li>
<li><a href="{{ route('backoffice.autor.index') }}">Autores</a></li>
<li class="active">Crear</li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-xs-6 col-sm-offset-3">
        <div class="card">
            <div class="header">
                <h2>
                    Crear Autor <small>Los campos con * son <b>OBLIGATORIOS</b></small>
                </h2>
            </div>
            <div class="body">
                <form id="wizard_with_validation" action="{{ route('backoffice.autor.store') }}" method="POST">
                    @csrf
                    <h3>Informacion del Autor</h3>
                    <fieldset>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nombre" required>
                                <label class="form-label">Nombre del autor*</label>
                            </div>
                            <label id="user_name-error" class="error">{{ $errors->first('nombre') }}</label>
                        </div>                        
                    </fieldset>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-danger pull-right waves-effect">
                            <span>CREAR</span>
                            <i class="material-icons">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
@if (session()->has('alert'))
{!! session('alert') !!}  
@endif

@endsection
