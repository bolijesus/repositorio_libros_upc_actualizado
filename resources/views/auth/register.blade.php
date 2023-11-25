@extends('templates.index')

@section('title','LogIn')

@section('css')
    {{-- <link rel="stylesheet" href="style.css"> --}}
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
@section('type_page','login-page bg-light-green') 

{{-- breadcrumbs --}}


@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">Repositorio | <b>UPC</b></a>
        <small>Repositorio bibliografico | Universidad Popular del Cesar</small>
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_up" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="msg">Registrarse como nuevo usuario</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Nombres" autofocus>
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('nombre') }}</label>

                    <div class="form-line">
                        <input type="text" class="form-control" name="apellido" value="{{ old('apellido') }}" placeholder="Apellidos" autofocus>
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('apellido') }}</label>

                    <div class="form-line">
                        <input type="text" class="form-control" name="usuario" value="{{ old('usuario') }}" placeholder="Usuario del sistema" autofocus>
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('usuario') }}</label>

                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electronico">
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('email') }}</label>

                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('password') }}</label>

                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password_confirmation"  placeholder="confirmacion de la contraseña">
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('password_confirm') }}</label>

                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">pin_drop</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}"  placeholder="Direccion">
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('direccion') }}</label>

                </div>

                <div class="form-group form-float">
                    <div class="row clearfix">
            
                        <select class="form-control show-tick" name="sexo">
                            <option value="">-- Sexo --</option>
                            <option value="0">Masculino</option>
                            <option value="1">Femenino</option>
                        </select>
            
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('sexo') }}</label>

                </div>

                <button class="btn btn-block btn-upc col-white waves-effect" type="submit">REGISTRARSE</button>

                <div class="m-t-25 m-b--5 align-center">
                    <a class="col-green" href="{{ route('login') }}">Ya estoy registrado?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <!-- Validation Plugin Js -->
    <script src="{{ asset('js/jquery-validation/jquery.validate.js') }}"></script>

@endsection
