@extends('layouts.app')

@section('title', ($post->exists ? 'Editar' : 'Nueva').' publicación | Panel SDS26')

@section('content')
<main class="admin-page form-page">
    <a class="back-link" href="{{ route('admin.posts.index') }}">← Volver a publicaciones</a>
    <div class="form-shell post-form-shell">
        <div class="form-aside">
            <p class="admin-overline">CONTENIDO / PUBLICACIONES</p>
            <h1>{{ $post->exists ? 'Edita la' : 'Comparte una' }}<br><em>historia real.</em></h1>
            <p>Documenta las actividades, aprendizajes y experiencias de nuestra carrera.</p>
            <div class="form-aside-art" aria-hidden="true">
                <svg viewBox="0 0 520 300" role="presentation">
                    <defs><linearGradient id="fieldFill" x1="0" x2="1" y1="0" y2="1"><stop offset="0" stop-color="#78c802"/><stop offset="1" stop-color="#6bb14d"/></linearGradient></defs>
                    <ellipse cx="260" cy="157" rx="210" ry="96" fill="none" stroke="#a8d77a" stroke-opacity=".42" transform="rotate(-15 260 157)"/>
                    <ellipse cx="260" cy="157" rx="160" ry="74" fill="none" stroke="#78c802" stroke-opacity=".48" transform="rotate(18 260 157)"/>
                    <path d="M60 198 238 110 454 181 270 268Z" fill="url(#fieldFill)" opacity=".92"/>
                    <path d="m105 201 165 55m-119-77 163 55m-117-80 164 54" stroke="#e9f6d6" stroke-opacity=".5"/>
                    <rect x="211" y="66" width="98" height="145" rx="12" fill="#f5f7ef" stroke="#d7e9c6" stroke-width="4"/>
                    <rect x="222" y="81" width="76" height="105" rx="3" fill="#203c2a"/>
                    <path d="M259 162c-17-14-9-34 6-46 2 16 17 24 7 43m-13-8c-7-10-4-20 2-29m-1 42c5-14 17-18 24-18" fill="none" stroke="#a9d77d" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="260" cy="198" r="5" fill="#6bb14d"/>
                    <circle cx="111" cy="100" r="13" fill="#f5f7ef" stroke="#78c802" stroke-width="4"/><circle cx="406" cy="98" r="13" fill="#f5f7ef" stroke="#78c802" stroke-width="4"/><circle cx="360" cy="42" r="13" fill="#f5f7ef" stroke="#78c802" stroke-width="4"/>
                    <path d="m124 108 71 42m196-40-81 34m48-90-53 26" stroke="#d6edbd" stroke-dasharray="4 7" stroke-width="2"/>
                </svg>
                <span>SDS26 <b>·</b> GREEN IoT</span>
            </div>
        </div>
        <section class="category-form-panel post-form-panel">
            <p class="eyebrow eyebrow-dark">{{ $post->exists ? 'ACTUALIZA LA ENTRADA' : 'NUEVA ENTRADA' }} <span class="eyebrow-line"></span></p>
            <h2>{{ $post->exists ? 'Editar publicación' : 'Crear publicación' }}</h2>
            @if($errors->any())<div class="form-error-summary" role="alert"><strong>Revisa estos datos:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="auth-form post-form">
                @csrf @if($post->exists) @method('PUT') @endif
                <label for="title">T&iacute;tulo de la publicaci&oacute;n</label><input id="title" name="title" value="{{ old('title', $post->title) }}" maxlength="180" required placeholder="Ej. Aprendizajes de la Feria de Proyectos">
                <div class="form-two-columns"><div><label for="activity_date">Fecha de la actividad</label><input id="activity_date" name="activity_date" type="date" value="{{ old('activity_date', $post->activity_date?->format('Y-m-d')) }}" required></div><div><label for="category_id">Categoría</label><select id="category_id" name="category_id" required><option value="">Selecciona una categoría</option>@foreach($categories as $category)<option value="{{ $category->id }}" data-slug="{{ $category->slug }}" data-guidance="{{ $category->slug === 'ponencias' ? 'El t&iacute;tulo de la publicaci&oacute;n funciona como tema; indique la persona expositora y desarrolle ideas y aprendizajes en resumen y contenido.' : ($category->slug === 'talleres' ? 'Indique quién impartió el taller y describa las herramientas, el procedimiento, la práctica y los resultados.' : $category->description) }}" @selected((string) old('category_id', $post->category_id) === (string) $category->id)>{{ $category->name }}</option>@endforeach</select></div></div>
                <p id="category-guidance" class="category-guidance" aria-live="polite"></p>
                @php($currentSlug = $categories->firstWhere('id', (int) old('category_id', $post->category_id))?->slug)
                @php($currentState = (string) old('is_published', $post->exists ? (!$post->is_published ? '0' : ($post->published_at?->isFuture() ? '2' : '1')) : '1'))
                @foreach($activityFieldSets as $slug => $fields)
                    @if($categories->contains('slug', $slug))
                        <fieldset class="activity-fields" data-category-fields="{{ $slug }}" @if($currentSlug !== $slug) hidden @endif>
                            <legend>Contenido requerido: {{ $categories->firstWhere('slug', $slug)->name }}</legend>
                            @foreach($fields as $key => $field)
                                <label for="activity_{{ $key }}">{{ $field['label'] }}</label>
                                @if(($field['type'] ?? 'textarea') === 'text')
                                    <input id="activity_{{ $key }}" name="activity_details[{{ $key }}]" type="text" value="{{ old('activity_details.'.$key, $post->activity_details[$key] ?? '') }}" maxlength="180" placeholder="{{ $field['placeholder'] }}" @if($currentSlug === $slug) required @else disabled @endif>
                                @else
                                    <textarea id="activity_{{ $key }}" name="activity_details[{{ $key }}]" rows="3" maxlength="3000" placeholder="{{ $field['placeholder'] }}" @if($currentSlug === $slug) required @else disabled @endif>{{ old('activity_details.'.$key, $post->activity_details[$key] ?? '') }}</textarea>
                                @endif
                            @endforeach
                        </fieldset>
                    @endif
                @endforeach
                @if($categories->isEmpty())<p class="inline-hint">Antes de publicar, <a href="{{ route('admin.categories.create') }}">crea una categoría</a>.</p>@endif
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

                <div class="form-two-columns publish-controls">
                    <div><label for="is_published">Estado de la publicaci&oacute;n</label><select id="is_published" name="is_published" required><option value="1" @selected($currentState === '1')>Publicada</option><option value="0" @selected($currentState === '0')>Borrador</option><option value="2" @selected($currentState === '2')>Programada</option></select></div>
                    <div id="schedule-field" @if($currentState !== '2') hidden @endif><label for="published_at">Publicar el</label><input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\\TH:i')) }}" @if($currentState !== '2') disabled @endif></div>
                </div>
                <p id="schedule-hint" class="field-hint" @if($currentState !== '2') hidden @endif>La fecha programada debe ser futura. Los borradores no aparecen en el sitio p&uacute;blico.</p>
                <div class="form-actions"><a class="button button-quiet" href="{{ route('admin.posts.index') }}">Cancelar</a><button class="button button-primary" type="submit">{{ $post->exists ? 'Guardar cambios' : 'Guardar publicaci&oacute;n' }} <span>↗</span></button></div>
            </form>
        </section>
    </div>
</main>
<script>
(() => {
    const category = document.getElementById('category_id');
    const guidance = document.getElementById('category-guidance');
    const fieldsets = Array.from(document.querySelectorAll('[data-category-fields]'));
    const updateGuidance = () => {
        const description = category?.selectedOptions[0]?.dataset.guidance || '';
        guidance.textContent = description ? `Contenido mínimo sugerido: ${description}` : '';
        guidance.hidden = !description;
        const slug = category?.selectedOptions[0]?.dataset.slug || '';
        fieldsets.forEach((fieldset) => {
            const active = fieldset.dataset.categoryFields === slug;
            fieldset.hidden = !active;
            fieldset.querySelectorAll('input, textarea').forEach((field) => {
                field.disabled = !active;
                field.required = active;
            });
        });
    };
    const publicationStatus = document.getElementById('is_published');
    const scheduleField = document.getElementById('schedule-field');
    const scheduledAt = document.getElementById('published_at');
    const scheduleHint = document.getElementById('schedule-hint');
    const updateSchedule = () => {
        const scheduled = publicationStatus?.value === '2';
        if (scheduleField) scheduleField.hidden = !scheduled;
        if (scheduledAt) { scheduledAt.disabled = !scheduled; scheduledAt.required = scheduled; }
        if (scheduleHint) scheduleHint.hidden = !scheduled;
    };
    publicationStatus?.addEventListener('change', updateSchedule);
    updateSchedule();
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
