@extends('layouts.app')

@section('title', $heading.' | Panel SDS26')

@section('content')
<main class="admin-page form-page">
    <a class="back-link" href="{{ route('admin.categories.index') }}">← Volver a categorías</a>
    <div class="form-shell"><div class="form-aside"><p class="admin-overline">CONTENIDO / CATEGORÍAS</p><h1>{{ $category->exists ? 'Dale forma a' : 'Abre espacio' }}<br><em>al contenido.</em></h1><p>Un buen nombre hace más fácil encontrar las historias que importan.</p><span class="aside-symbol">✳</span></div>
        <section class="category-form-panel"><p class="eyebrow eyebrow-dark">{{ $category->exists ? 'ACTUALIZA LOS DETALLES' : 'NUEVA ORGANIZACIÓN' }} <span class="eyebrow-line"></span></p><h2>{{ $heading }}</h2>
            <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="auth-form">
                @csrf @if($category->exists) @method('PUT') @endif
                <label for="name">Nombre de la categoría</label><input id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="100" required placeholder="Ej. IoT y tecnología">@error('name')<p class="field-error">{{ $message }}</p>@enderror
                <label for="description">Descripción <span class="optional">OPCIONAL</span></label><textarea id="description" name="description" rows="4" maxlength="500" placeholder="¿Qué tipo de historias van aquí?">{{ old('description', $category->description) }}</textarea>@error('description')<p class="field-error">{{ $message }}</p>@enderror
                <p class="slug-hint">El enlace corto se genera automáticamente a partir del nombre.</p>
                <div class="form-actions"><a class="button button-quiet" href="{{ route('admin.categories.index') }}">Cancelar</a><button class="button button-primary" type="submit">{{ $category->exists ? 'Guardar cambios' : 'Crear categoría' }} <span>↗</span></button></div>
            </form>
        </section>
    </div>
</main>
@endsection
