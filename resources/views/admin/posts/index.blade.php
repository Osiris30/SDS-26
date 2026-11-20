@extends('layouts.app')

@section('title', 'Publicaciones | Panel SDS26')

@section('content')
<main class="admin-page">
    <div class="admin-topline"><p class="eyebrow eyebrow-dark">PANEL DE CONTENIDO <span class="eyebrow-line"></span> SDS26</p><span class="admin-user"><i></i>{{ auth()->user()->name }}</span></div>
    <section class="admin-heading"><div><p class="admin-overline">CONTENIDO / PUBLICACIONES</p><h1>Historias de<br><em>la comunidad.</em></h1><p class="admin-intro">Redacta, organiza y programa las publicaciones del blog.</p></div><a class="button button-primary" href="{{ route('admin.posts.create') }}">Nueva publicación <span>＋</span></a></section>
    <nav class="admin-tabs" aria-label="Administrar contenido"><a href="{{ route('admin.dashboard') }}">Resumen</a><a class="active" href="{{ route('admin.posts.index') }}">Publicaciones</a><a href="{{ route('admin.categories.index') }}">Categorías</a></nav>
    @if(session('status'))<p class="flash admin-flash" role="status">{{ session('status') }}</p>@endif
    @if($posts->isEmpty())
        <div class="empty-state admin-empty"><span class="empty-icon">✳</span><h3>Aún no hay publicaciones.</h3><p>Crea la primera historia de la Semana de Sistemas.</p><a class="button button-primary" href="{{ route('admin.posts.create') }}">Crear publicación <span>＋</span></a></div>
    @else
        <div class="post-admin-list">
            @foreach($posts as $post)
                @php($scheduled = $post->is_published && $post->published_at?->isFuture())
                <article class="post-admin-row">
                    <div class="post-admin-mark">@if($post->image_path)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->image_path) }}" alt="">@else{{ str_pad((string) $post->id, 2, '0', STR_PAD_LEFT) }}@endif</div>
                    <div class="post-admin-copy"><div class="post-admin-meta"><span>{{ $post->category?->name ?? 'Sin categoría' }}</span><span>Actividad · {{ $post->activity_date?->translatedFormat('d M Y') }}</span></div><h2>{{ $post->title }}</h2><p>{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p></div>
                    <span @class(['post-status', 'status-scheduled' => $scheduled, 'status-published' => $post->is_published && !$scheduled, 'status-draft' => !$post->is_published])>{{ $scheduled ? 'Programada' : ($post->is_published ? 'Publicada' : 'Borrador') }}</span>
                    <div class="post-admin-actions">
                        @if($post->is_published && !$scheduled)<a href="{{ route('posts.show', $post->slug) }}">Ver <span>↗</span></a>@endif
                        <a href="{{ route('admin.posts.edit', $post) }}">Editar</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Eliminar esta publicación? Esta acción no se puede deshacer.')">@csrf @method('DELETE')<button type="submit">Eliminar</button></form>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">{{ $posts->links() }}</div>
    @endif
</main>
@endsection
