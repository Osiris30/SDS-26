@extends('layouts.app')

@section('title', ($post->exists ? 'Editar' : 'Nueva').' publicación | Panel SDS26')

@section('content')
<main class="admin-page form-page">
    <a class="back-link" href="{{ route('admin.posts.index') }}">← Volver a publicaciones</a>
    <div class="form-shell post-form-shell">
        <div class="form-aside"><p class="admin-overline">CONTENIDO / PUBLICACIONES</p><h1>{{ $post->exists ? 'Edita la' : 'Comparte una' }}<br><em>historia real.</em></h1><p>Documenta las actividades, aprendizajes y experiencias que dan vida a nuestra carrera.</p><span class="aside-symbol">✳</span></div>
        <section class="category-form-panel post-form-panel">
            <p class="eyebrow eyebrow-dark">{{ $post->exists ? 'ACTUALIZA LA ENTRADA' : 'NUEVA ENTRADA' }} <span class="eyebrow-line"></span></p>
            <h2>{{ $post->exists ? 'Editar publicación' : 'Crear publicación' }}</h2>
            @if($errors->any())<div class="form-error-summary" role="alert"><strong>Revisa estos datos:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="auth-form post-form">
                @csrf @if($post->exists) @method('PUT') @endif
                <label for="title">Título de la entrada</label><input id="title" name="title" value="{{ old('title', $post->title) }}" maxlength="180" required placeholder="Ej. Aprendizajes de la Feria de Proyectos">
                <div class="form-two-columns"><div><label for="activity_date">Fecha de la actividad</label><input id="activity_date" name="activity_date" type="date" value="{{ old('activity_date', $post->activity_date?->format('Y-m-d')) }}" required></div><div><label for="category_id">Categoría</label><select id="category_id" name="category_id" required><option value="">Selecciona una categoría</option>@foreach($categories as $category)<option value="{{ $category->id }}" data-guidance="{{ $category->description }}" @selected((string) old('category_id', $post->category_id) === (string) $category->id)>{{ $category->name }}</option>@endforeach</select></div></div>
                <p id="category-guidance" class="category-guidance" aria-live="polite"></p>
                @if($categories->isEmpty())<p class="inline-hint">Antes de publicar, <a href="{{ route('admin.categories.create') }}">crea una categoría</a>.</p>@endif
                <label for="authors">Autor o autores</label><input id="authors" name="authors" value="{{ old('authors', $post->authors ?: auth()->user()->name) }}" maxlength="255" required placeholder="Nombres de quienes elaboraron la entrada"><p class="field-hint">Si son varios, sepáralos con coma.</p>
                <label for="excerpt">Resumen <span class="optional">OPCIONAL · 300 CARACTERES</span></label><textarea id="excerpt" name="excerpt" rows="3" maxlength="300" placeholder="Una breve introducción para el listado público">{{ old('excerpt', $post->excerpt) }}</textarea>
                <label for="body">Contenido de la actividad</label><textarea id="body" name="body" rows="12" maxlength="50000" required placeholder="Cuenta qué ocurrió, qué aprendieron y por qué fue importante para la comunidad...">{{ old('body', $post->body) }}</textarea><p class="field-hint">Incluye hechos reales, reflexión propia y aprendizajes de la actividad.</p>

                <div class="image-section"><div class="image-section-heading"><div><label for="image">Imagen principal</label><p>Sube una evidencia real de la actividad. JPG, PNG o WebP, máximo 5 MB.</p></div><span class="image-required">OBLIGATORIA</span></div>
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" @required(!$post->exists)>
                    @if($post->image_path)<div class="saved-cover"><img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->image_path) }}" alt="Portada actual de {{ $post->title }}"><span>La nueva imagen reemplazará esta portada.</span></div>@endif
                    <div id="cover-preview" class="upload-preview" aria-live="polite"></div>
                </div>

                <div class="image-section"><div class="image-section-heading"><div><label for="images">Galería de la actividad</label><p>Agrega hasta 8 evidencias adicionales, JPG, PNG o WebP, máximo 5 MB cada una.</p></div><span class="image-count">{{ $post->exists ? $post->images->count() : 0 }}/8</span></div>
                    @if($post->exists && $post->images->isNotEmpty())<div class="saved-gallery">@foreach($post->images as $image)<label class="saved-gallery-item"><img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}" alt="{{ $image->caption ?: 'Imagen de la entrada' }}"><span><input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Quitar</span></label>@endforeach</div>@endif
                    <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
                    <div id="gallery-preview" class="upload-preview upload-preview-grid" aria-live="polite"></div>
                </div>

                <div class="form-two-columns publish-controls"><div><label for="is_published">Estado de la entrada</label><select id="is_published" name="is_published"><option value="0" @selected(old('is_published', $post->exists ? (int) $post->is_published : 0) == 0)>Borrador</option><option value="1" @selected(old('is_published', (int) $post->is_published) == 1)>Publicada</option></select></div><div><label for="published_at">Publicar el <span class="optional">OPCIONAL</span></label><input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\\TH:i')) }}"></div></div>
                <p class="field-hint">Si se publica y dejas la fecha vacía, aparecerá inmediatamente. Una fecha futura la programa. Los borradores nunca aparecen en el sitio público.</p>
                <div class="form-actions"><a class="button button-quiet" href="{{ route('admin.posts.index') }}">Cancelar</a><button class="button button-primary" type="submit">{{ $post->exists ? 'Guardar cambios' : 'Guardar entrada' }} <span>↗</span></button></div>
            </form>
        </section>
    </div>
</main>
<script>
(() => {
    const category = document.getElementById('category_id');
    const guidance = document.getElementById('category-guidance');
    const updateGuidance = () => {
        const description = category?.selectedOptions[0]?.dataset.guidance || '';
        guidance.textContent = description ? `Contenido mínimo sugerido: ${description}` : '';
        guidance.hidden = !description;
    };
    category?.addEventListener('change', updateGuidance);
    updateGuidance();
    const bindPreview = (inputId, previewId) => {
        const input = document.getElementById(inputId);
        const container = document.getElementById(previewId);
        if (!input || !container) return;
        let urls = [];
        input.addEventListener('change', () => {
            urls.forEach(URL.revokeObjectURL);
            urls = [];
            container.replaceChildren();
            Array.from(input.files || []).forEach((file) => {
                if (!file.type.startsWith('image/')) return;
                const url = URL.createObjectURL(file);
                urls.push(url);
                const image = document.createElement('img');
                image.src = url;
                image.alt = `Vista previa: ${file.name}`;
                container.append(image);
            });
        });
        window.addEventListener('pagehide', () => urls.forEach(URL.revokeObjectURL));
    };
    bindPreview('image', 'cover-preview');
    bindPreview('images', 'gallery-preview');
})();
</script>
@endsection
