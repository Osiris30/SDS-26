<header @class(['site-header', 'site-header-admin' => auth()->check() && auth()->user()->isAdmin()])>
    <a class="brand" href="{{ route('home') }}" aria-label="Semana de Sistemas, inicio">
        <span class="brand-mark"><span>SDS</span><b>26</b><i aria-hidden="true">&#10038;</i></span>
        <span class="brand-copy">GREEN <b>IoT</b><small>UES &middot; FMO</small></span>
    </a>
    <nav class="main-nav" aria-label="Navegaci&oacute;n principal">
        @if(auth()->check() && auth()->user()->isAdmin())
            <span class="nav-context">ESPACIO ADMINISTRATIVO</span>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Resumen</a>
            <a href="{{ route('admin.posts.index') }}" @class(['active' => request()->routeIs('admin.posts.*')])>Publicaciones</a>
            <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>Categor&iacute;as</a>
            <a class="nav-preview" href="{{ route('home') }}">Ver sitio <span aria-hidden="true">&#8599;</span></a>
            <form action="{{ route('logout') }}" method="POST" class="nav-form">@csrf<button class="nav-login" type="submit">Salir</button></form>
        @else
            <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Inicio</a>
            <a href="{{ route('event') }}" @class(['active' => request()->routeIs('event')])>Semana 2026</a>
            <a class="nav-login" href="{{ route('login') }}">Acceso admin <span aria-hidden="true">&#8599;</span></a>
        @endif
    </nav>
</header>
