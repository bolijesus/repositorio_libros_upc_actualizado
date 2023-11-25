<nav class="navbar _theme-green">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/">UPC - REPOSITORIO</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
                @auth
                <!-- Notifications -->
                @if ($count = Auth::user()->UnreadNotifications->count())
                
                
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count">{{ $count }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">NOTIFICAIONES</li>
                        <li class="body">
                            <ul class="menu">
                                @csrf
                                @foreach (Auth::user()->notifications as $notification)
                                    @if ($notification->unread())
                                        <li data-id_notification="{{ $notification->id }}" class="notificacion-upc">
                                            <a href="{{ $notification->data['route'] }}">
                                                <div class="icon-circle {{ $notification->data['color'] }}">
                                                    <i class="material-icons">{{ $notification->data['icon'] }}</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>{{ $notification->data['mensaje'] }}</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> {{ creadaHace($notification->data['time']) }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                                
                            </ul>
                        </li>
                    </ul>
                </li>                    
                @endif
                <!-- #END# Notifications -->                    
                @endauth
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu" {!! Auth::user() ?'style="height: 160px;"': 'style="height: 150px;"' !!}>
                        <li class="header">OPCIONES</li>
                        <li class="body">
                            <ul class="menu">
                                @if(Auth::user())
                                <li>
                                    <a href="{{ route('backoffice.index')}}">
                                        <div class="menu-info">
                                            <h4>INGRESA AL PERFIL</h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="menu-info">
                                            <h4>
                                                PUNTOS PARA DESCARGAR
                                                <span class="puntos badge">{{ \Auth::user()->isAdmin() ? 'ILIMITED' : \Auth::user()->puntos_descarga }}</span>
                                            </h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <div class="menu-info">
                                            <h4>CERRAR SESION</h4>
                                        </div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    </a>
                                    
                                </li>
                                @else
                                
                                <li>
                                    <a href="{{ route('register') }}">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>CREAR CUENTA</h4>
                                            <p>
                                               Sing Up
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('login') }}">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>INGRESA AQUI</h4>
                                            <p>
                                               LogIn
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>