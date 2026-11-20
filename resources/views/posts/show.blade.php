@extends('layouts.app')

@section('title', $post->title.' | Semana de Sistemas 2026')

@section('content')
<main class="article-page">
    <a class="back-link" href="{{ route('home') }}#publicaciones">← Volver a publicaciones</a>
    <article class="article-shell">
        <div class="article-cover">@if($post->image_path)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->image_path) }}" alt="Imagen principal: {{ $post->title }}">@else<span class="article-cover-symbol">✳</span>@endif<span class="visual-kicker">SEMANA DE SISTEMAS <b>2026</b></span><span class="article-cover-caption">IDEAS<br>EN COMUNIDAD</span></div>
        <div class="article-content"><div class="article-meta"><span>{{ $post->category?->name ?? 'Comunidad' }}</span><time datetime="{{ $post->activity_date?->toDateString() }}">Actividad: {{ $post->activity_date?->translatedFormat('d \d\e F, Y') }}</time></div><h1>{{ $post->title }}</h1>
            @if($post->excerpt)<p class="article-lede">{{ $post->excerpt }}</p>@endif
            <p class="article-author">Autoría: <strong>{{ $post->authors ?: ($post->author?->name ?? 'Equipo SDS26') }}</strong><span> · Publicada {{ $post->published_at?->translatedFormat('d/m/Y') }}</span></p>
            @if($post->images->isNotEmpty())<div class="article-gallery" aria-label="Imágenes de la actividad">@foreach($post->images as $image)<figure><img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}" alt="{{ $image->caption ?: 'Imagen de '.$post->title }}">@if($image->caption)<figcaption>{{ $image->caption }}</figcaption>@endif</figure>@endforeach</div>@endif
            <div class="article-body">{{ $post->body }}</div>
            <a class="article-back-button" href="{{ route('home') }}#publicaciones">← Explorar más historias</a>
        </div>
    </article>
</main>
@endsection
