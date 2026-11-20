<header class="site-header">
    <a class="brand" href="{{ route('home') }}" aria-label="Semana de Sistemas, inicio">
        <span class="brand-mark"><span>SDS</span><b>26</b><i>⌁</i></span>
        <span class="brand-copy">GREEN <b>IoT</b><small>UES · FMO</small></span>
    </a>
    <nav class="main-nav" aria-label="Navegación principal">
        <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Actualidad</a>
        <a href="{{ route('home') }}#categorias">Categorías</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Panel admin</a>
                <form action="{{ route('logout') }}" method="POST" class="nav-form">@csrf<button class="nav-login" type="submit">Salir</button></form>
            @endif
        @else
            <a class="nav-login" href="{{ route('login') }}">Acceso admin <span aria-hidden="true">↗</span></a>
        @endauth
    </nav>
</header>
