@extends('layouts.app')

@section('title', 'Actualidad | Semana de Sistemas 2026')

@section('content')
<main>
    @unless(auth()->user()?->isAdmin())
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-content">
            <p class="eyebrow"><span class="live-dot"></span> UNIVERSIDAD DE EL SALVADOR <span class="eyebrow-line"></span> FMO</p>
            <h1>La tecnología<br>también puede<br><em>hacer crecer.</em></h1>
            <p class="hero-lede">Ideas, proyectos y conversaciones que conectan sistemas, sostenibilidad y el futuro de nuestra comunidad.</p>
            <a class="button button-primary" href="#publicaciones">Explorar publicaciones <span>↓</span></a>
        </div>
        <div class="hero-art" aria-hidden="true">
            <img class="hero-illustration" src="{{ asset('images/green-iot-field.svg') }}" alt="">
        </div>
        <div class="hero-bottom"><span>SEMANA DE SISTEMAS 2026</span><span>DESLIZA PARA DESCUBRIR <b>↓</b></span></div>
    </section>
    @endunless

    <section class="event-strip" aria-label="Información de la Semana de Sistemas">
        <div><span class="event-index">01</span><p><b>16—20 NOV</b><small>SEMANA DE SISTEMAS 2026</small></p></div>
        <div><span class="event-index">02</span><p><b>FMO · UES</b><small>FACULTAD MULTIDISCIPLINARIA ORIENTAL</small></p></div>
        <div><span class="event-index">03</span><p><b>GREEN IoT</b><small>TECNOLOGÍA CON PROPÓSITO</small></p></div>
    </section>

    <section class="content-section" id="publicaciones">
        <div class="section-heading">
            <div><p class="eyebrow eyebrow-dark">EL PULSO DE LA SEMANA <span class="eyebrow-line"></span> 2026</p><h2>Historias que<br><em>mueven ideas.</em></h2></div>
            <p class="section-intro">Conoce lo que está pasando: ponencias, proyectos y voces que imaginan un futuro más conectado y sostenible.</p>
        </div>

        <form action="{{ route('home') }}" method="GET" class="search-toolbar" role="search">
            <label class="sr-only" for="post-search">Buscar publicaciones</label>
            <span class="search-icon" aria-hidden="true">⌕</span>
            <input id="post-search" name="q" type="search" value="{{ $search }}" placeholder="Busca una idea, ponencia o proyecto…" maxlength="100">
            @if($selectedCategory)<input type="hidden" name="categoria" value="{{ $selectedCategory }}">@endif
            @if($search)<a class="search-clear" href="{{ route('home', array_filter(['categoria' => $selectedCategory ?: null])) }}">Limpiar</a>@endif
            <button type="submit" aria-label="Buscar">Buscar <span>↗</span></button>
        </form>

        <div class="category-bar" id="categorias">
            <span class="category-label">Explorar por tema</span>
            <div class="category-links">
                <a @class(['category-chip', 'selected' => !$selectedCategory]) href="{{ route('home', array_filter(['q' => $search ?: null])) }}">Todo <small>{{ $posts->total() }}</small></a>
                @foreach($categories as $category)
                    <a @class(['category-chip', 'selected' => $selectedCategory === $category->slug]) href="{{ route('home', array_filter(['categoria' => $category->slug, 'q' => $search ?: null])) }}">{{ $category->name }} <small>{{ $category->posts_count }}</small></a>
                @endforeach
            </div>
        </div>

        @if($posts->isEmpty())
            <div class="empty-state"><span class="empty-icon">✳</span><h3>{{ $search ? 'No encontramos publicaciones con esa búsqueda.' : ($selectedCategory ? 'Todavía no hay publicaciones en este tema.' : 'Las historias están por comenzar.') }}</h3><p>{{ $search ? 'Prueba con otras palabras o limpia el filtro para ver todas las publicaciones.' : 'Vuelve pronto para descubrir las novedades de la Semana de Sistemas.' }}</p></div>
        @else
            <div class="post-grid">
                @foreach($posts as $index => $post)
                    <article class="post-card">
                        <div class="post-visual visual-{{ $index % 3 }}" aria-hidden="true">
                            @if($post->image_path)<img class="post-cover-image" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->image_path) }}" alt="">@endif
                            <span class="visual-kicker">SDS<span>26</span> · {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="visual-symbol">{{ ['⌁', '✳', '◉'][$index % 3] }}</span>
                            <span class="visual-caption">GREEN<br>IoT</span>
                            <span class="visual-arrow">↗</span>
                        </div>
                        <div class="post-meta"><span>{{ $post->category?->name ?? 'Comunidad' }}</span><time>{{ optional($post->activity_date)->translatedFormat('d M, Y') }}</time></div>
                        <h3><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <p class="post-excerpt">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 145) }}</p>
                        <div class="post-byline"><span class="byline-dot"></span><span>{{ $post->authors ?: ($post->author?->name ?? 'Equipo SDS26') }}</span><a class="read-more" href="{{ route('posts.show', $post->slug) }}">LEER MÁS <b>↗</b></a></div>
                    </article>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $posts->links() }}</div>
        @endif
    </section>

    <section class="closing-banner"><span class="closing-icon">✳</span><p>El futuro se construye<br><em>en comunidad.</em></p><span class="closing-tag">SDS26 · GREEN IoT</span></section>
</main>
@endsection
