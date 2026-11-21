@extends('layouts.app')

@section('title', 'Evidencias de '.$profile['name'].' | Semana de Sistemas 2026')

@section('content')
<main class="public-evidence-page">
    <section class="public-evidence-hero">
        <a class="back-link" href="{{ route('event') }}#evidencias">Volver a Semana 2026</a>
        <p class="eyebrow eyebrow-dark">EVIDENCIAS SDS26 <span class="eyebrow-line"></span> GREEN IoT</p>
        <h1>Una semana vista<br><em>por {{ str_starts_with($profile['name'], 'Osiris') ? 'Osiris' : 'Bryan' }}.</em></h1>
        <p class="public-evidence-name">{{ $profile['name'] }}<span>{{ $profile['role'] }}</span></p>
    </section>

    <section class="public-evidence-content" aria-label="Evidencias por actividad">
        @if($evidenceGroups->isEmpty())
            <div class="empty-state"><span class="empty-icon">&#10038;</span><h2>Las evidencias estarán aquí pronto.</h2><p>Cuando se agreguen fotografías a las actividades publicadas, aparecerán en esta página.</p></div>
        @else
            @foreach($evidenceGroups as $group)
                <article class="public-evidence-activity">
                    <header><div><p class="eyebrow eyebrow-dark">{{ $group['post']->category?->name ?? 'Actividad' }} <span class="eyebrow-line"></span> {{ $group['post']->activity_date?->translatedFormat('d M Y') }}</p><h2>{{ $group['post']->title }}</h2></div><a href="{{ route('posts.show', $group['post']->slug) }}">Ver publicación</a></header>
                    @if($group['post']->excerpt)<p class="public-evidence-excerpt">{{ $group['post']->excerpt }}</p>@endif
                    <div class="public-evidence-grid">
                        @foreach($group['images'] as $evidence)
                            <figure><img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($evidence->image_path) }}" alt="{{ $evidence->caption ?: 'Evidencia de '.$group['post']->title }}" loading="lazy">@if($evidence->caption)<figcaption>{{ $evidence->caption }}</figcaption>@endif</figure>
                        @endforeach
                    </div>
                </article>
            @endforeach
        @endif
    </section>
</main>
@endsection
