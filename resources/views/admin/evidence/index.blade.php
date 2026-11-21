@extends('layouts.app')

@section('title', 'Mis evidencias | Panel SDS26')

@section('content')
<main class="admin-page evidence-admin-page">
    <div class="admin-topline"><p class="eyebrow eyebrow-dark">PANEL DE CONTENIDO <span class="eyebrow-line"></span> SDS26</p><span class="admin-user"><i></i>{{ $profile['name'] }}</span></div>
    <section class="admin-heading"><div><p class="admin-overline">EQUIPO / EVIDENCIAS</p><h1>Mis fotos de<br><em>la semana.</em></h1><p class="admin-intro">Sube una evidencia y asígnala a una actividad publicada. Solo tú podrás administrar las fotos de este perfil.</p></div></section>
    @if(session('status'))<p class="flash admin-flash" role="status">{{ session('status') }}</p>@endif
    @if($errors->any())<div class="form-error-summary" role="alert"><strong>Revisa estos datos:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <section class="evidence-upload-panel" aria-labelledby="evidence-upload-title">
        <div><p class="eyebrow eyebrow-dark">NUEVO REGISTRO <span class="eyebrow-line"></span></p><h2 id="evidence-upload-title">Agregar evidencia</h2><p>La foto se guardará en el proyecto y quedará asociada a tu usuario y a la actividad seleccionada.</p></div>
        @if($posts->isEmpty())
            <p class="inline-hint">Todavía no hay publicaciones públicas disponibles para asociar evidencias.</p>
        @else
            <form class="evidence-upload-form" action="{{ route('admin.evidence.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="post_id">Actividad</label>
                <select id="post_id" name="post_id" required>
                    <option value="">Selecciona una actividad</option>
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}" @selected((string) old('post_id') === (string) $post->id)>{{ $post->title }} · {{ $post->activity_date?->translatedFormat('d M Y') }}</option>
                    @endforeach
                </select>
                <label for="evidence_image">Fotografía</label>
                <input id="evidence_image" name="image" type="file" accept="image/jpeg,image/png,image/webp" required>
                <p class="field-hint">JPG, PNG o WebP; máximo 5 MB por foto. Puedes repetir el proceso para agregar más.</p>
                <label for="caption">Descripción <span class="optional">OPCIONAL</span></label>
                <input id="caption" name="caption" type="text" maxlength="180" value="{{ old('caption') }}" placeholder="Ej. Presentación del prototipo en la feria">
                <button class="button button-primary" type="submit">Guardar evidencia</button>
            </form>
        @endif
    </section>

    <section class="evidence-admin-list" aria-labelledby="my-evidences-title">
        <div class="evidence-list-heading"><div><p class="eyebrow eyebrow-dark">TU ARCHIVO <span class="eyebrow-line"></span></p><h2 id="my-evidences-title">Evidencias que has subido</h2></div><a href="{{ route('evidence.profile', $profileSlug) }}">Ver página pública</a></div>
        @if($evidences->isEmpty())
            <div class="empty-state admin-empty"><h3>Aún no has agregado evidencias.</h3><p>Cuando subas una foto, aparecerá aquí y en tu página pública.</p></div>
        @else
            <div class="evidence-admin-grid">
                @foreach($evidences as $evidence)
                    <article class="evidence-admin-card">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($evidence->image_path) }}" alt="{{ $evidence->caption ?: 'Evidencia de '.$evidence->post->title }}" loading="lazy">
                        <div class="evidence-admin-card-copy"><span>{{ $evidence->post->category?->name ?? 'Actividad' }} · {{ $evidence->post->activity_date?->translatedFormat('d M Y') }}</span><h3>{{ $evidence->post->title }}</h3>@if($evidence->caption)<p>{{ $evidence->caption }}</p>@endif
                            <form action="{{ route('admin.evidence.destroy', $evidence) }}" method="POST" onsubmit="return confirm('¿Eliminar esta evidencia?')">@csrf @method('DELETE')<button type="submit">Eliminar foto</button></form>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $evidences->links() }}</div>
        @endif
    </section>
</main>
@endsection
