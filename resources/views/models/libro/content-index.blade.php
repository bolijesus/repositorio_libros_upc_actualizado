
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Autores</th>                                
                <th>Idioma</th>                                
                @if (\Auth::user()->isAdmin())
                    <th>Usuario</th>   
                @endif                                
                <th>Revisado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Titulo</th>
                <th>Autores</th> 
                <th>Idioma</th> 
                @if (\Auth::user()->isAdmin())
                    <th>Usuario</th>   
                @endif   
                <th>Revisado</th>
                <th>Opciones</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($libros as $libro)
            <tr>
                <td>
                    <a href="{{ route('backoffice.libro.show', $libro) }}">
                        {{ $libro->bibliografia->titulo }}
                    </a>
                </td>
                <td>
                    <ul>
                        @foreach ($libro->bibliografia->autores as $autor)
                        <li>{{ $autor->nombre }}</li>
                        @endforeach
                    </ul>
                        
                </td>
                <td>{{ $libro->bibliografia->idioma }}</td>
                @if (\Auth::user()->isAdmin())
                    <td>{{ $libro->bibliografia->usuario->usuario }}</td>
                @endif
                <td>
                    
                        @if ($libro->bibliografia->revisado==3)
                        <i class="material-icons col-green">check</i>
                        @elseif ($libro->bibliografia->revisado==2)
                        <i class="material-icons col-red">close</i>
                        @else
                        <i class="material-icons col-orange">sync</i>
                        @endif
                <td>
                    <div class="row d-inline small clearfix">
                        <a href="{{ route('backoffice.libro.show',$libro) }}" class="col-xs-offset-1 btn btn-xs bg-cyan waves-effect ">
                            <i class="large material-icons">remove_red_eye</i>
                        </a>
                        @if ($libro->bibliografia->revisado != 3 || \Auth::user()->isAdmin())
                            <a href="{{ route('backoffice.libro.edit',$libro) }}" class="col-xs-offset-1 btn btn-xs bg-orange waves-effect">
                                <i class="material-icons ">mode_edit</i>
                            </a>
                        @endif
                        <a href="{{ route('backoffice.libro.download',$libro->bibliografia) }}" class="col-xs-offset-1 btn btn-xs bg-green waves-effect">
                            <i class="material-icons descargar-ajax">file_download</i>
                        </a>
                        @if (\Auth::user()->isAdmin())
                            <a data-libro="{{ $libro->id }}" class="eliminar col-xs-offset-1 btn btn-xs bg-red waves-effect">
                                <i class="material-icons ">delete_forever</i>
                            </a>                                            
                        @endif
                    </div>
                    
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@csrf