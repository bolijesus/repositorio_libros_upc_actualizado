@extends('templates.index')

@section('title','Lista Usuarios')

@section('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('css/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
<li><a href="{{ url('/') }}">Inicio</a></li>
<li class="active">Usuarios</li>
@endsection

@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('backoffice.user.create') }}">Crear</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Verificado</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Direccion</th>
                                <th>Sexo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Usuario</th>
                                <th>Verificado</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Direccion</th>
                                <th>Sexo</th>
                                <th>Opciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('backoffice.user.show', $user) }}">
                                        {{ $user->usuario }}
                                    </a>
                                </td>
                                <td>
                                    <i class="large material-icons {{ $user->verificado ?'col-green': 'col-red' }} ">{{ $user->verificado ?'check': 'close' }}</i>
                                </td>
                                <td>{{ $user->nombre }}</td>
                                <td>{{ $user->apellido }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->direccion }}</td>
                                <td>{{ $user->sexo == 0 ? 'MASCULINO': 'FEMENINO' }}</td>
                                <td>
                                    <div class="row d-inline small">
                                        <a href="{{ route('backoffice.user.show',$user) }}" class="col-xs-offset-1 btn btn-xs bg-cyan waves-effect ">
                                            <i class="large material-icons">remove_red_eye</i>
                                        </a>
                                        <a href="{{ route('backoffice.user.edit',$user) }}" class="col-xs-offset-1 btn btn-xs bg-orange waves-effect">
                                            <i class="material-icons ">mode_edit</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->
@endsection


@section('scripts')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('js/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/tables/jquery-datatable.js') }}"></script>
    @if (session()->has('alert'))

    {!! session('alert') !!}  
   @endif
@endsection
