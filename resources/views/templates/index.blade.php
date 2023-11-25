

@include('templates.head')


<!-- Loader -->
{{-- @include('templates.layout.loader') --}}
<!-- #Loader -->

@include('templates.layout.search_bar')
@if (!request()->routeIs('login') && Auth::check())
        
        <!-- Top Bar -->
        @include('templates.layout.top_bar')         
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            @include('templates.layout.left_sidebar')
            <!-- #END# Left Sidebar -->
        </section>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                {{-- Bread Crumbs --}}
                @if (!request()->routeIs(['login','register']))
                    @include('templates.layout.breadcrumbs')
                @endif
                {{-- #Bread Crumbs --}}
                @yield('content')
            </div>
        </div>
    </section>

@include('templates.scripts')


