
@include('templates.head')

<!-- Loader -->
    @include('templates.layout.loader')
<!-- #Loader -->

@include('templates.layout.search_bar')

<!-- Top Bar -->
@include('templates.layout.top_bar')         
<!-- #Top Bar -->
<section class="_content">
    <div class="row clearfix">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="card">
                <div class="header">
                    <h2>RESULTADOS DE LA BUSQUEDA PARA: {{ request()->get('buscar') }}</h2>
                    <h2>TOTAL RESULTADOS: {{ $bibliografias->count() }}</h2>
                </div>
                <div class="body">
                    <div class="row">
                        @foreach ($bibliografias as $bibliografia)
                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="thumbnail">
                                        <img src="{{ Storage::url($bibliografia->portada) }}" style="max-width:128px;max-height: 128px; min-width:128px;min-height: 128px; ">
                                        <div class="caption">
                                            <h3>{{ $bibliografia->titulo }}</h3>
                                            <small>por: <span>{{ $bibliografia->usuario->usuario }}</span></small>
                                            <p>
                                                {{ Str::limit($bibliografia->descripcion,151,'(...)') }}
                                            </p>
                                            <p>
                                                <a href="{{ route('backoffice.'.Str::lower(Str::substr($bibliografia->bibliografiable_type,4)).'.show',$bibliografia->bibliografiable) }}" class="btn btn-lg bg-grey waves-effect waves-green" role="button">
                                                    VER
                                                </a>
                                                <a href="{{ route('backoffice.'.Str::lower(Str::substr($bibliografia->bibliografiable_type,4)).'.download',$bibliografia) }}"  class="descargar-ajax btn btn-lg bg-primary waves-effect pull-right btn-upc" role="button">
                                                    DESCARGAR
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>            
</section>


@include('templates.scripts')