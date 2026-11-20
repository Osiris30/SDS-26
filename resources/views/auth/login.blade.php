@extends('layouts.app')

@section('title', 'Acceso administrativo | SDS26')

@section('content')
<main class="login-page">
    <div class="login-art"><p class="eyebrow"><span class="live-dot"></span> ESPACIO ADMINISTRATIVO</p><div class="login-emblem">SDS<b>26</b><small>GREEN IoT</small></div><div class="login-art-bottom">CUIDAMOS CADA IDEA<br>QUE CRECE AQUÍ.</div></div>
    <section class="login-panel">
        <a class="back-link" href="{{ route('home') }}">← Volver al sitio</a>
        <p class="eyebrow eyebrow-dark">ACCESO SEGURO <span class="eyebrow-line"></span> ADMIN</p>
        <h1>Qué bueno<br><em>tenerte aquí.</em></h1>
        <p class="login-intro">Ingresa con tu cuenta de administrador para redactar publicaciones, gestionar imágenes y organizar las categorías del blog.</p>
        <form action="{{ route('login.store') }}" method="POST" class="auth-form">
            @csrf
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus placeholder="admin@ejemplo.com">
            @error('email')<p class="field-error">{{ $message }}</p>@enderror
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Tu contraseña">
            @error('password')<p class="field-error">{{ $message }}</p>@enderror
            <label class="remember-row"><input type="checkbox" name="remember" value="1"> <span>Mantener mi sesión</span></label>
            <button class="button button-primary button-full" type="submit">Entrar al panel <span>↗</span></button>
        </form>
        <p class="security-note"><span>⌑</span> Acceso reservado al equipo organizador.</p>
    </section>
</main>
@endsection
