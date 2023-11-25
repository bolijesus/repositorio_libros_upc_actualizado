<h3>Informacion de la Cuenta</h3>
<fieldset>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="usuario" value="{{ old('usuario',$user->usuario) }}">
            <label class="form-label">Nombre de usuario*</label>
        </div>
        <label id="user_name-error" class="error">{{ $errors->first('usuario') }}</label>
    </div>
    @if (request()->routeIs('backoffice.user.create'))
    <div class="form-group form-float">
        <div class="form-line">
            <input type="password" class="form-control" name="password" id="password">
            <label class="form-label">Contraseña*</label>
        </div>
        <label id="user_name-error" class="error">{{ $errors->first('password') }}</label>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="password" class="form-control" name="password_confirmation">
            <label class="form-label">Confirmacion de la contraseña*</label>
        </div>
        <label id="user_name-error" class="error">{{ $errors->first('password_confirm') }}</label>

    </div>
    @endif
        <div class="form-group form-float">
            <div class="form-line">
                <label>Foto de perfil</label>
                <input type="file" class="form-control" name="_foto_perfil">
            </div> 
            <label id="user_name-error" class="error">{{ $errors->first('foto_perfil') }}</label>   
        </div>

</fieldset>

<h3>Informacion del Usuario</h3>
<fieldset>
    <div class="form-group form-float ">
        <div class="form-line ">
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre',$user->nombre) }}">
            <label class="form-label">Nombres*</label>
        </div>
    </div>
    <label id="user_name-error" class="error">{{ $errors->first('nombre') }}</label>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido',$user->apellido) }}">
            <label class="form-label">Apellidos</label>
        </div>
        <label id="user_name-error" class="error">{{ $errors->first('apellido') }}</label>

    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}">
            <label class="form-label">Email*</label>
        </div>
        <label id="user_name-error" class="error" for="user_name">{{ $errors->first('email') }}</label>

    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <textarea name="direccion" cols="30" rows="3"
                class="form-control no-resize">{{ old('direccion',$user->direccion) }}</textarea>
            <label class="form-label">Direccion*</label>
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

    @can('viewAny', \Auth::user())
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="demo-checkbox">
                @foreach ($roles as $role)
                <input type="checkbox" id="{{ $role->id }}" class="filled-in" value="{{ $role->id }}" name="roles[]"
                    {{ $user->hasRole($role->id) ? 'checked' : '' }} />
                <label for="{{ $role->id }}">{{ $role->nombre }}</label>
                @endforeach
            </div>

        </div>
        <label id="user_name-error" class="error" for="user_name">{{ $errors->first('roles') }}</label>
    </div>
    @endcan

</fieldset>
<div class="form-group mb-3">
    <button type="submit" class="btn btn-upc pull-right waves-effect">
        <span>{{ $btnSubmit }}</span>
        <i class="material-icons">send</i>
    </button>
</div>