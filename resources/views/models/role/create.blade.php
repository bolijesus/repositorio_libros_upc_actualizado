@extends('templates.index')

@section('title','Titulo DEMO')

@section('css')
    {{-- <link rel="stylesheet" href="style.css"> --}}
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
<li><a href="{{ url('/') }}">Inicio</a></li>
<li><a href="{{ route('backoffice.role.index') }}">Roles</a></li>
<li class="active">Crear</li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-xs-6 col-sm-offset-3">
        <div class="card">
            <div class="header">
                <h2>
                    Crear Rol <small>Los campos con * son <b>OBLIGATORIOS</b></small>
                </h2>
            </div>
            <div class="body">
                <form id="wizard_with_validation" action="{{ route('backoffice.role.store') }}" method="POST">
                    @csrf
                    <h3>Informacion del Rol</h3>
                    <fieldset>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nombre" required>
                                <label class="form-label">Nombre del rol*</label>
                            </div>
                            <label id="user_name-error" class="error">{{ $errors->first('nombre') }}</label>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea name="descripcion" cols="30" rows="3" class="form-control no-resize" required>
                                </textarea>
                                <label class="form-label">Descripcion*</label>
                            </div>
                            <label id="user_name-error" class="error" for="user_name">{{ $errors->first('descripcion') }}</label>
                    
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
