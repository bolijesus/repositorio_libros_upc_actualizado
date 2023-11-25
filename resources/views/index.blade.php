@extends('templates.index')

@section('title','Dashboard')

@section('css')
   {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}"> --}}
   <style>
       .check-upc{
           width: 26px;
       }       
       .mb-0{
           margin-bottom: 0 !important;
       }
       .mt-13{
           margin-top: 13px;
       }
   </style>
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="/">Inicio</a></li>
    <li class="active">Dashboard</li>
@endsection

@section('content')
<div class="card">
    <div class="header">
        <h2>
            Dashboard <small>Reporte completo de sus bibliografias</small>
        </h2>
    </div>
    <div class="body">
        <div class="row clearfix"> 
            {{-- ESTADOS DE LAS BIBLIOGRAFIAS --}}
            <div class="col-xs-12">
                <div class="row clearfix">
                    <div class="col-sm-6 col-xs-12">
                        <div class="mb-0 info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">library_books</i>
                            </div>
                            <div class="content">
                                <div class="text">LIBROS</div>
                                <div class="number count-to" data-from="0" data-to="{{ $libros['cantidad'] }}" data-speed="1000" data-fresh-interval="20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-success btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">checked</i>
                            <span class="badge">{{ $libros['aceptado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-danger btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">clear</i>
                            <span class="badge">{{ $libros['rechazado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-warning btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">autorenew</i>
                            <span class="badge">{{ $libros['revision'] }}</span>
                        </button>                       
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-xs-12">
                        <div class="mb-0 info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">layers</i>
                            </div>
                            <div class="content">
                                <div class="text">REVISTAS</div>
                                <div class="number count-to" data-from="0" data-to="{{ $revistas['cantidad'] }}" data-speed="1000" data-fresh-interval="20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-success btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">checked</i>
                            <span class="badge">{{ $revistas['aceptado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-danger btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">clear</i>
                            <span class="badge">{{ $revistas['rechazado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-warning btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">autorenew</i>
                            <span class="badge">{{ $revistas['revision'] }}</span>
                        </button>                       
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-xs-12">
                        <div class="mb-0 info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="content">
                                <div class="text">TESIS</div>
                                <div class="number count-to" data-from="0" data-to="{{ $tesis['cantidad'] }}" data-speed="1000" data-fresh-interval="20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-success btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">checked</i>
                            <span class="badge">{{ $tesis['aceptado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-danger btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">clear</i>
                            <span class="badge">{{ $tesis['rechazado'] }}</span>
                        </button>                       
                     </div>
                    <div class="mt-13 col-sm-2 col-xs-12">
                        <button class="btn btn-warning btn-lg btn-block waves-effect" type="button">
                            <i class="material-icons check-upc">autorenew</i>
                            <span class="badge">{{ $tesis['revision'] }}</span>
                        </button>                       
                    </div>
                </div>
                
            </div>
            
     
    {{-- REPORTE DESCARGAS --}}
        <div class="col-sm-6 col-xs-12">
            <div class="info-box bg-deep-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">file_download</i>
                </div>
                <div class="content">
                    <div class="text">DESCARGAS TOTALES</div>
                    <div class="number count-to" data-from="0" data-to="{{ $descargas }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    
        <div class="col-sm-6 col-xs-12">
            <div class="row clearfix">
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-deep-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">library_books</i>
                        </div>
                        <div class="content">
                            <div class="text">LIBROS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $libros['descargas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-deep-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">layers</i>
                        </div>
                        <div class="content">
                            <div class="text">REVISTAS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $revistas['descargas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-deep-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="content">
                            <div class="text">TESIS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $tesis['descargas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- REPORTE VISTAS --}}
        <div class="col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">remove_red_eye</i>
                </div>
                <div class="content">
                    <div class="text">VISTAS TOTALES</div>
                    <div class="number count-to" data-from="0" data-to="{{ $vistas }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    
        <div class="col-sm-6 col-xs-12">
            <div class="row clearfix">
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">library_books</i>
                        </div>
                        <div class="content">
                            <div class="text">LIBROS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $libros['vistas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">layers</i>
                        </div>
                        <div class="content">
                            <div class="text">REVISTAS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $revistas['vistas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="content">
                            <div class="text">TESIS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $tesis['vistas'] }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    
    </div>
    </div>
</div>



@endsection



@section('scripts')
<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('js/jquery-countto/jquery.countTo.js') }}"></script>
<script src="{{ asset('js/pages/index.js') }}"></script>

@endsection
