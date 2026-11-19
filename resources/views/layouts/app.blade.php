<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#060342">
    <title>@yield('title', 'Semana de Sistemas 2026 | Green IoT')</title>
    <meta name="description" content="Noticias, ideas y actividades de la Semana de Sistemas 2026: Green IoT, tecnología y sostenibilidad en la FMO-UES.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
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
                    <a href="{{ route('admin.categories.index') }}">Administración</a>
                    <form action="{{ route('logout') }}" method="POST" class="nav-form">@csrf<button class="nav-login" type="submit">Salir</button></form>
                @endif
            @else
                <a class="nav-login" href="{{ route('login') }}">Acceso admin <span aria-hidden="true">↗</span></a>
            @endauth
        </nav>
    </header>

    @if(session('status'))<div class="flash" role="status">{{ session('status') }}</div>@endif
    @yield('content')

    <footer class="site-footer">
        <a class="brand brand-footer" href="{{ route('home') }}"><span class="brand-mark"><span>SDS</span><b>26</b></span><span class="brand-copy">GREEN <b>IoT</b></span></a>
        <p>Ingeniería de Sistemas Informáticos <span>·</span> FMO–UES</p>
        <span class="footer-note">Ideas que conectan. Tecnología que transforma.</span>
    </footer>
</body>
</html>
