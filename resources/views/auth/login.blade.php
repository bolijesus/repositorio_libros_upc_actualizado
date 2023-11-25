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
            <form id="sign_in" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="msg">Iniciar sesion</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="email" placeholder="Email | Correo Electornico" required autofocus>
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ __($errors->first('email')) }}</label>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password| Contraseña" required>
                    </div>
                    <label id="user_name-error" class="error" for="user_name">{{ $errors->first('password') }}</label>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="basic_checkbox_2" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-green">
                        <label for="basic_checkbox_2">Recordardarme</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block btn-upc col-white waves-effect" type="submit">Ingresar</button>
                    </div>
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
