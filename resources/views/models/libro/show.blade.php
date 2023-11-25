@extends('templates.index')

@section('title','Titulo DEMO')

@section('css')
<link rel="stylesheet" href="{{ asset('css\bootstrap-select\bootstrap-select.min.css') }}">
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
<li><a href="{{ url('/') }}">Inicio</a></li>
<li><a href="{{ route('backoffice.libro.index') }}">Libros</a></li>
    <li class="active">{{ $libro->bibliografia->titulo }}</li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $libro->bibliografia->titulo }}
                    <small>{{ $libro->bibliografia->created_at->diffForHumans()}}</small>
                </h2>
            </div>
            <div class="body">
                <form action="{{ route('backoffice.libro.revision',$libro) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">

                        <div class="col-xs-12 col-md-3">
                            <label for="titulo">Imagen</label>
                            <div class="thumbnail">
                                <img src="{{ Storage::url($libro->bibliografia->portada) }}" style="width: 128px;height: 128px;">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="titulo">Titulo*</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input disabled type="text" id="titulo" class="form-control" value="{{ $libro->bibliografia->titulo }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="idioma">Idioma</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input disabled type="text" id="idioma" class="form-control" value="{{ $libro->bibliografia->idioma }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="genero">genero</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input disabled type="text" id="genero" class="form-control" value="{{ $libro->bibliografia->genero }}">
                                </div>
                            </div>
                        </div>                        
                        <div class="col-xs-12 col-md-3">
                            <label for="autor">autores</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input disabled type="text" id="autor" class="form-control" value="@foreach ($libro->bibliografia->autores as $autor){{ $autor->nombre }} - @endforeach">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-3">
                                <label for="editorial">editorial</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input disabled type="text" id="editorial" class="form-control" value="{{ $libro->editorial }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2 ">
                                <div class="form-group">
                                    <a href="{{ route('backoffice.libro.download',$libro->bibliografia) }}" class="descargar-ajax btn btn-lg bg-primary waves-effect pull-right btn-upc" role="button">
                                        DESCARGAR
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 ">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="titulo">Descripcion</label>
                                        <small></small>
                                        <div class="form-line">
                                            <textarea disabled rows="4" class="form-control no-resize" placeholder="Descripcion...">{{ $libro->bibliografia->descripcion }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        @if (Auth::user()->isAdmin() || $libro->bibliografia->revisado == 2)
                        <div class="col-xs-12 ">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="titulo">Mensaje de revision</label>
                                        <small></small>
                                        <div class="form-line">
                                            <textarea name="contenido" {{ ! Auth::user()->isAdmin()?'disabled':'' }} rows="4" class="form-control no-resize" placeholder="Descripcion...">{{ optional($libro->bibliografia->mensaje)->contenido }}</textarea>
                                        </div>
                                        <label id="user_name-error" class="error">{{ $errors->first('contenido') }}</label>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (\Auth::user()->isAdmin())
                   <div class="row clearfix pull-right">
                            <div class="col-xs-12 ">
                                <input name="revisado" type="radio" id="radio_1" value="3"
                                    {{ $libro->bibliografia->revisado == 3 ? 'checked':'' }} />
                                <label for="radio_1">ACEPTAR</label>
                                <input name="revisado" type="radio" id="radio_2" value="2"
                                    {{ $libro->bibliografia->revisado==2 ? 'checked':'' }} />
                                <label for="radio_2">RECHAZAR</label>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger pull-right waves-effect">
                                        <span>REVISAR</span>
                                        <i class="material-icons">file_upload</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection


@section('scripts')
    {{-- <script>alert()</script> --}}

@endsection
