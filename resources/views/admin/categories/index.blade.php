@extends('layouts.app')

@section('title', 'Categorías | Panel SDS26')

@section('content')
<main class="admin-page">
    <div class="admin-topline"><p class="eyebrow eyebrow-dark">PANEL DE ORGANIZACIÓN <span class="eyebrow-line"></span> SDS26</p><span class="admin-user"><i></i>{{ auth()->user()->name }}</span></div>
    <section class="admin-heading"><div><p class="admin-overline">CONTENIDO / TAXONOMÍA</p><h1>Ordena las<br><em>conversaciones.</em></h1><p class="admin-intro">Las categorías ayudan a que cada historia encuentre su lugar.</p></div><a class="button button-primary" href="{{ route('admin.categories.create') }}">Nueva categoría <span>＋</span></a></section>
    <nav class="admin-tabs" aria-label="Administrar contenido"><a href="{{ route('admin.dashboard') }}">Resumen</a><a href="{{ route('admin.posts.index') }}">Publicaciones</a><a class="active" href="{{ route('admin.categories.index') }}">Categorías</a></nav>
    @if($categories->isEmpty())
        <div class="empty-state admin-empty"><span class="empty-icon">✳</span><h3>Aún no hay categorías.</h3><p>Crea la primera para empezar a organizar las publicaciones.</p><a class="button button-primary" href="{{ route('admin.categories.create') }}">Crear categoría <span>＋</span></a></div>
    @else
        <div class="category-table-wrap"><table class="category-table"><thead><tr><th>Nombre</th><th>Identificador</th><th>Publicaciones</th><th class="actions-head">Acciones</th></tr></thead><tbody>
            @foreach($categories as $category)
                <tr><td><div class="table-name"><span class="table-icon">✳</span><span><b>{{ $category->name }}</b><small>{{ $category->description ?: 'Sin descripción' }}</small></span></div></td><td><code>/{{ $category->slug }}</code></td><td><span class="count-pill">{{ $category->posts_count }} {{ \Illuminate\Support\Str::plural('artículo', $category->posts_count) }}</span></td><td><div class="table-actions"><a href="{{ route('admin.categories.edit', $category) }}">Editar <span>↗</span></a><form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría? Las publicaciones seguirán disponibles sin categoría.')">@csrf @method('DELETE')<button type="submit">Eliminar</button></form></div></td></tr>
            @endforeach
        </tbody></table></div>
        <div class="pagination-wrap">{{ $categories->links() }}</div>
    @endif
</main>
@endsection
