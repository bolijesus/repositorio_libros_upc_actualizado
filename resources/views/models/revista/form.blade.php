
<div class="row clear-fix">
    <div class="col-xs-12 col-md-6">
        <label for="titulo">Titulo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('titulo', optional($revista->bibliografia)->titulo) }}" id="titulo" name="titulo" class="form-control" 
                    placeholder="Titulo del revista">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('titulo') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-xs-6">
        <div class="row clearfix">
            <div class="col-sm-12" style="margin-top: 24px;">
                <label for="">Autores</label>
                <div class="form-group">
                    <select class="selects-form-bibliografia" multiple name="autores[]">
                        <optgroup label="---Selecciona uno o mas autores---">
                        @foreach ($autores as $autor)
                        
                        <option value="{{ $autor->id }}" {{ optional($revista->bibliografia)->hasAutor($autor) ? 'selected' : '' }}>{{ $autor->nombre }}</option>
                            
                        @endforeach
                        </optgroup>
                    </select>
                </div>
                <label id="user_name-error" class="error">{{ $errors->first('autores') }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="row clearfix">
            <div class="col-sm-12" style="margin-top: 24px;">
                <label for="">Generos</label>
                <div class="form-group">
                    <select class="selects-form-bibliografia" multiple name="generos[]">
                        <optgroup label="---Selecciona uno o mas Generos---">
                            @foreach ($generos as $genero)
                            
                            <option value="{{ $genero->id }}" {{ optional($revista->bibliografia)->hasGenero($genero) ? 'selected' : '' }}>{{ $genero->nombre }}</option>
                                
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                
                <label id="user_name-error" class="error">{{ $errors->first('generos') }}</label>
            </div>
        </div>
        
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="row clearfix">
            <div class="col-sm-12" style="margin-top: 24px;">
                <label for="">Idioma</label>
                <div class="form-group">
                    <select class="selects-form-bibliografia" name="idioma">
                        <optgroup label="Elije un idioma para tu revista">
                        <option value="1">ingles</option>
                        <option value="1">español</option>
                        </optgroup>
                    </select>
                </div>
                
                <label id="user_name-error" class="error">{{ $errors->first('genero') }}</label>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-xs-12 col-md-4">
        <label for="publicador">publicador*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('publicador', $revista->publicador) }}" id="publicador" name="publicador" class="form-control"
                    placeholder="publicador de la revista">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('publicador') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="archivo">Archivo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="file" name="_archivo" class="form-control">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('archivo') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="archivo">Imgen de portada*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="file" name="_portada" class="form-control">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('archivo') }}</label>
        </div>
    </div>
    
    
</div>
<div class="row clearfix">
    <div class="col-xs-8 ">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="titulo">Descripcion</label>
                    <small>(max:200 palabras)</small>
                    <div class="form-line">
                        <textarea rows="4" class="form-control no-resize"
                            placeholder="Descripcion..." name="descripcion">{{ old('descripcion',optional($revista->bibliografia)->descripcion) }}</textarea>
                    </div>
                    <label id="user_name-error" class="error">{{ $errors->first('descripcion') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger pull-right waves-effect">
        <span>SUBIR</span>
        <i class="material-icons">file_upload</i>
    </button>
</div>
