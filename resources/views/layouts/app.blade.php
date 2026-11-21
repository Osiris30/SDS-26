<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#060342">
    <title>@yield('title', 'Semana de Sistemas 2026 | Green IoT')</title>
    <meta name="description" content="Noticias, ideas y actividades de la Semana de Sistemas 2026: Green IoT, tecnología y sostenibilidad en la FMO-UES.">
    @vite(['resources/css/app.css', 'resources/css/editorial.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    @if(session('status'))<div class="flash" role="status">{{ session('status') }}</div>@endif
    @yield('content')

    @include('partials.footer')
</body>
</html>
