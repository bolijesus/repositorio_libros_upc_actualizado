
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ Storage::url(\Auth::user()->foto_perfil) }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ \Auth::user()->nombre }}</div>
            <div class="email">{{ \Auth::user()->usuario }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ route('backoffice.user.show',\Auth::user()) }}"><i class="material-icons">person</i>Perfil</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Cerrar Sesion</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        
        <ul class="list">
            <li class="{{ active('backoffice.index') }}">
                <a href="{{ route('backoffice.index') }}" class="menu-toggle">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if (\Auth::user()->isAdmin())
                <li class="{{ active('backoffice.role.*') }}">
                    <a href="#" class="menu-toggle">
                        <i class="material-icons">star</i>
                        <span>Roles</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="{{ active('backoffice.role.index') }}">
                            <a href="{{ route('backoffice.role.index') }}">
                                <span>Listar</span>
                            </a>
                        </li>
                        <li class="{{ active('backoffice.role.create') }}">
                            <a href="{{ route('backoffice.role.create') }}">
                                <span>Crear</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ active('backoffice.role.*') }}">
                    <a href="#" class="menu-toggle">
                        <i class="material-icons">collections_bookmark</i>
                        <span>Generos</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="{{ active('backoffice.genero.index') }}">
                            <a href="{{ route('backoffice.genero.index') }}">
                                <span>Listar</span>
                            </a>
                        </li>
                        <li class="{{ active('backoffice.genero.create') }}">
                            <a href="{{ route('backoffice.genero.create') }}">
                                <span>Crear</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ active('backoffice.user.*') }}">
                    <a href="#" class="menu-toggle">
                        <i class="material-icons">people</i>
                        <span>Usuarios</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="{{ active('backoffice.user.index') }}">
                            <a href="{{ route('backoffice.user.index') }}">
                                <span>Listar</span>
                            </a>
                        </li>
                        <li class="{{ active('backoffice.user.create') }}">
                            <a href="{{ route('backoffice.user.create') }}">
                                <span>Crear</span>
                            </a>
                        </li>
                    </ul>
                </li>                
            @endif
            <li class="{{ active('backoffice.autor.*') }}">
                <a href="#" class="menu-toggle">
                    <i class="material-icons">sentiment_very_satisfied</i>
                    <span>Autores</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ active('backoffice.autor.index') }}">
                        <a href="{{ route('backoffice.autor.index') }}">
                            <span>Listar</span>
                        </a>
                    </li>
                    <li class="{{ active('backoffice.autor.create') }}">
                        <a href="{{ route('backoffice.autor.create') }}">
                            <span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ active('backoffice.libro.*') }}">
                <a href="#" class="menu-toggle">
                    <i class="material-icons">library_books</i>
                    <span>Libros</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ active('backoffice.libro.index') }}">
                        <a href="{{ route('backoffice.libro.index') }}">
                            <span>Listar</span>
                        </a>
                    </li>
                    <li class="{{ active('backoffice.libro.create') }}">
                        <a href="{{ route('backoffice.libro.create') }}">
                            <span>Subir</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ active('backoffice.revista.*') }}">
                <a href="#" class="menu-toggle">
                    <i class="material-icons">layers</i>
                    <span>Revistas</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ active('backoffice.revista.index') }}">
                        <a href="{{ route('backoffice.revista.index') }}">
                            <span>Listar</span>
                        </a>
                    </li>
                    <li class="{{ active('backoffice.revista.create') }}">
                        <a href="{{ route('backoffice.revista.create') }}">
                            <span>Subir</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ active('backoffice.tesis.*') }}">
                <a href="#" class="menu-toggle">
                    <i class="material-icons">assignment</i>
                    <span>Tesis</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ active('backoffice.tesis.index') }}">
                        <a href="{{ route('backoffice.tesis.index') }}">
                            <span>Listar</span>
                        </a>
                    </li>
                    <li class="{{ active('backoffice.tesis.create') }}">
                        <a href="{{ route('backoffice.tesis.create') }}">
                            <span>Subir</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; <script type="text/javascript">document.write(new Date().getFullYear())</script> <a href="#">Universidad Popular del Cesar</a>.
        </div>
    </div>
    <!-- #Footer -->
</aside>
