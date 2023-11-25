
<div class="row clear-fix">
    <div class="col-xs-12 col-md-6">
        <label for="titulo">Titulo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('titulo', optional($libro->bibliografia)->titulo) }}" id="titulo" name="titulo" class="form-control" 
                    placeholder="Titulo del libro">
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
                        
                        <option value="{{ $autor->id }}" {{ optional($libro->bibliografia)->hasAutor($autor) ? 'selected' : '' }}>{{ $autor->nombre }}</option>
                            
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
                            
                            <option value="{{ $genero->id }}" {{ optional($libro->bibliografia)->hasGenero($genero) ? 'selected' : '' }}>{{ $genero->nombre }}</option>
                                
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
                        <optgroup label="Elije un idioma para tu libro">
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
        <label for="editorial">Editorial*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('editorial', $libro->editorial) }}" id="editorial" name="editorial" class="form-control"
                    placeholder="Editorial del libro">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('editorial') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="isbn">ISBN*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="number" value="{{ old('isbn', $libro->isbn) }}" id="isbn" name="isbn" class="form-control"
                    placeholder="ISBN del libro">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('isbn') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="archivo">Archivo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="file" id="archivo" name="_archivo" class="form-control">
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
                            placeholder="Descripcion..." name="descripcion">{{ old('descripcion',optional($libro->bibliografia)->descripcion) }}</textarea>
                    </div>
                    <label id="user_name-error" class="error">{{ $errors->first('descripcion') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4" style="margin-top: 57px;">
        <label for="archivo">Imgen de portada*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="file" id="archivo" name="_portada" class="form-control">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('archivo') }}</label>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger pull-right waves-effect">
        <span>SUBIR</span>
        <i class="material-icons">file_upload</i>
    </button>
</div>
