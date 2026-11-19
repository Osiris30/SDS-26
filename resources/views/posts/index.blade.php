@extends('layouts.app')

@section('title', 'Actualidad | Semana de Sistemas 2026')

@section('content')
<main>
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-content">
            <p class="eyebrow"><span class="live-dot"></span> UNIVERSIDAD DE EL SALVADOR <span class="eyebrow-line"></span> FMO</p>
            <h1>La tecnología<br>también puede<br><em>hacer crecer.</em></h1>
            <p class="hero-lede">Ideas, proyectos y conversaciones que conectan sistemas, sostenibilidad y el futuro de nuestra comunidad.</p>
            <a class="button button-primary" href="#publicaciones">Explorar publicaciones <span>↓</span></a>
        </div>
        <div class="hero-art" aria-hidden="true">
            <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
            <div class="sun-disc"></div>
            <div class="field field-back"></div><div class="field field-front"></div>
            <div class="sensor"><span class="sensor-waves">⌁</span><span class="sensor-leaf">✳</span></div>
            <div class="art-caption"><span>01 / 26</span><b>GREEN<br>FUTURE</b></div>
            <div class="art-stamp">IoT<br>UES</div>
        </div>
        <div class="hero-bottom"><span>SEMANA DE SISTEMAS 2026</span><span>DESLIZA PARA DESCUBRIR <b>↓</b></span></div>
    </section>

    <section class="content-section" id="publicaciones">
        <div class="section-heading">
            <div><p class="eyebrow eyebrow-dark">EL PULSO DE LA SEMANA <span class="eyebrow-line"></span> 2026</p><h2>Historias que<br><em>mueven ideas.</em></h2></div>
            <p class="section-intro">Conoce lo que está pasando: ponencias, proyectos y voces que imaginan un futuro más conectado y sostenible.</p>
        </div>

        <div class="category-bar" id="categorias">
            <span class="category-label">Explorar por tema</span>
            <div class="category-links">
                <a @class(['category-chip', 'selected' => !$selectedCategory]) href="{{ route('home') }}">Todo <small>{{ $posts->total() }}</small></a>
                @foreach($categories as $category)
                    <a @class(['category-chip', 'selected' => $selectedCategory === $category->slug]) href="{{ route('home', ['categoria' => $category->slug]) }}">{{ $category->name }} <small>{{ $category->posts_count }}</small></a>
                @endforeach
            </div>
        </div>

        @if($posts->isEmpty())
            <div class="empty-state"><span class="empty-icon">✳</span><h3>{{ $selectedCategory ? 'Todavía no hay publicaciones en este tema.' : 'Las historias están por comenzar.' }}</h3><p>Vuelve pronto para descubrir las novedades de la Semana de Sistemas.</p></div>
        @else
            <div class="post-grid">
                @foreach($posts as $index => $post)
                    <article class="post-card">
                        <div class="post-visual visual-{{ $index % 3 }}" aria-hidden="true">
                            <span class="visual-kicker">SDS<span>26</span> · {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="visual-symbol">{{ ['⌁', '✳', '◉'][$index % 3] }}</span>
                            <span class="visual-caption">GREEN<br>IoT</span>
                            <span class="visual-arrow">↗</span>
                        </div>
                        <div class="post-meta"><span>{{ $post->category?->name ?? 'Comunidad' }}</span><time>{{ optional($post->published_at)->translatedFormat('d M, Y') }}</time></div>
                        <h3>{{ $post->title }}</h3>
                        <p class="post-excerpt">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 145) }}</p>
                        <div class="post-byline"><span class="byline-dot"></span>{{ $post->author?->name ?? 'Equipo SDS26' }}<span class="read-more">LEER MÁS <b>↗</b></span></div>
                    </article>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $posts->links() }}</div>
        @endif
    </section>

    <section class="closing-banner"><span class="closing-icon">✳</span><p>El futuro se construye<br><em>en comunidad.</em></p><span class="closing-tag">SDS26 · GREEN IoT</span></section>
</main>
@endsection
