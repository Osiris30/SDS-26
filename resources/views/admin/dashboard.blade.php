@extends('layouts.app')

@section('title', 'Panel de control | Semana de Sistemas 2026')

@section('content')
<main class="admin-page dashboard-page">
    <div class="admin-topline"><p class="eyebrow eyebrow-dark">CENTRO DE CONTROL <span class="eyebrow-line"></span> SDS26</p><span class="admin-user"><i></i>{{ auth()->user()->name }}</span></div>
    <section class="admin-heading"><div><p class="admin-overline">PANEL ADMINISTRATIVO</p><h1>Hola,<br><em>{{ auth()->user()->name }}.</em></h1><p class="admin-intro">Desde aquí puedes mantener al día las historias de la Semana de Sistemas.</p></div><a class="button button-primary" href="{{ route('admin.posts.create') }}">Crear publicación <span>＋</span></a></section>
    <nav class="admin-tabs" aria-label="Administrar contenido"><a class="active" href="{{ route('admin.dashboard') }}">Resumen</a><a href="{{ route('admin.posts.index') }}">Publicaciones</a><a href="{{ route('admin.categories.index') }}">Categorías</a></nav>
    <section class="dashboard-stats" aria-label="Resumen de contenido">
        <article><span class="stat-label">PUBLICADAS</span><strong>{{ $publishedPosts }}</strong><span class="stat-note">Visibles en el blog</span></article>
        <article><span class="stat-label">BORRADORES</span><strong>{{ $draftPosts }}</strong><span class="stat-note">Pendientes de publicar</span></article>
        <article><span class="stat-label">PROGRAMADAS</span><strong>{{ $scheduledPosts }}</strong><span class="stat-note">Con fecha futura</span></article>
        <article><span class="stat-label">CATEGORÍAS</span><strong>{{ $categoryCount }}</strong><span class="stat-note">Temas organizados</span></article>
    </section>
    <section class="dashboard-recent"><div class="dashboard-section-heading"><div><p class="admin-overline">LO MÁS RECIENTE</p><h2>Actividad editorial</h2></div><a href="{{ route('admin.posts.index') }}">Ver todas <span>↗</span></a></div>
        @forelse($latestPosts as $post)
            <article class="dashboard-post-row"><div><span>{{ $post->category?->name ?? 'Sin categoría' }}</span><h3>{{ $post->title }}</h3><small>Actualizada {{ $post->updated_at->translatedFormat('d M Y') }}</small></div><a href="{{ route('admin.posts.edit', $post) }}">Editar <span>↗</span></a></article>
        @empty
            <div class="empty-state admin-empty"><h3>Comienza con tu primera historia.</h3><p>Las entradas que escribas aparecerán aquí.</p><a class="button button-primary" href="{{ route('admin.posts.create') }}">Crear publicación <span>＋</span></a></div>
        @endforelse
    </section>
    <p class="dashboard-total">{{ $totalPosts }} entradas en total · Semana de Sistemas 2026</p>
</main>
@endsection
