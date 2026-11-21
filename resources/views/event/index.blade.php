@extends('layouts.app')

@section('title', 'Semana de Sistemas 2026 | Green IoT')

@section('content')
<main class="event-page">
    <section class="event-hero">
        <div class="event-hero-grid" aria-hidden="true"></div>
        <div class="event-hero-copy">
            <p class="eyebrow eyebrow-dark"><span class="live-dot"></span> UNIVERSIDAD DE EL SALVADOR <span class="eyebrow-line"></span> FMO</p>
            <h1>Una semana para<br><em>imaginar lo posible.</em></h1>
            <p>Cuatro días de tecnología, proyectos y comunidad. Conoce las actividades de la Semana de Sistemas 2026.</p>
            <a class="button button-primary" href="#programa">Conocer el programa</a>
            <div class="event-hero-meta"><span>16—20 NOVIEMBRE 2026</span><span>GREEN IoT · FMO UES</span></div>
        </div>
        <div class="event-hero-art" aria-hidden="true"><span class="event-art-ring"></span><span class="event-art-mark">SDS<em>26</em></span><span class="event-art-caption">TECNOLOGÍA<br>CON PROPÓSITO</span></div>
    </section>

    <nav class="event-jump-nav" aria-label="En esta página">
        <a href="#programa">Programa</a><a href="#patrocinadores">Patrocinadores</a><a href="#equipo">Equipo creador</a><a href="#evidencias">Evidencias</a>
    </nav>

    <section class="event-section event-program" id="programa">
        <div class="event-section-heading"><div><p class="eyebrow eyebrow-dark">ITINERARIO OFICIAL <span class="eyebrow-line"></span> 2026</p><h2>Cinco días para<br><em>crear y compartir.</em></h2></div><p>Ponencias, tecnología, proyectos y convivencia en la Facultad Multidisciplinaria Oriental.</p></div>
        <div class="event-schedule">
            <section class="event-day"><h3><span>16</span><div>Lunes <small>16 de noviembre</small></div></h3><div class="event-day-items">
                <article><time>8:00 <small>A. M.</small></time><div><h4>Inauguración</h4><p>¡Comienza el evento!</p></div><span>Auditorio 1</span></article>
                <article><time>10:00 <small>A. M.</small></time><div><h4>Ponencia 1</h4><p>Investigación aplicada en IoT para la agricultura en El Salvador.</p></div><span>Auditorio 1</span></article>
                <article><time>1:00 <small>P. M.</small></time><div><h4>Ponencia 2</h4><p>Energías alternativas y eficiencia energética.</p></div><span>Auditorio 1</span></article>
            </div></section>
            <section class="event-day"><h3><span>17</span><div>Martes <small>17 de noviembre</small></div></h3><div class="event-day-items">
                <article><time>8:00 <small>A. M.</small></time><div><h4>Ponencia 3</h4><p>Eficiencia energética, optimización de recursos y sostenibilidad aplicada a soluciones tecnológicas.</p></div><span>Auditorio 1</span></article>
                <article><time>1:00 <small>P. M.</small></time><div><h4>Taller</h4><p>Sostenibilidad digital y análisis energético mediante Electricity Map.</p></div><span>Auditorio 1</span></article>
            </div></section>
            <section class="event-day"><h3><span>18</span><div>Miércoles <small>18 de noviembre</small></div></h3><div class="event-day-items">
                <article><time>Desde las 8:00 <small>A. M.</small></time><div><h4>Bingo</h4><p>Dinámica, experiencia y participación para toda la comunidad.</p></div><span>Auditorio 1</span></article>
            </div></section>
            <section class="event-day"><h3><span>19</span><div>Jueves <small>19 de noviembre</small></div></h3><div class="event-day-items">
                <article><time>8:00 <small>A. M.</small></time><div><h4>Expo Systems</h4><p>Los proyectos más innovadores e increíbles realizados por estudiantes de Ingeniería de Sistemas Informáticos.</p></div><span>Plaza Minerva</span></article>
                <article><time>12:00 <small>P. M.</small></time><div><h4>Comelona de pizza</h4><p>¿Eres tan veloz para ganar? ¡Inscríbete y demuéstralo!</p></div><span>Plaza Minerva</span></article>
            </div></section>
            <section class="event-day"><h3><span>20</span><div>Viernes <small>20 de noviembre</small></div></h3><div class="event-day-items">
                <article><time>8:00 <small>A. M.</small></time><div><h4>Torneo futsal</h4><p>Partidos frenéticos. 5 jugadores por equipo: ¡inscribe a tu equipo y sé parte!</p></div><span>Cancha futsal</span></article>
                <article><time>12:00 <small>P. M.</small></time><div><h4>Parrillada</h4><p>Un momento para disfrutar todos y convivir mientras comemos.</p></div><span>Alrededores de la cancha</span></article>
            </div></section>
        </div>
    </section>

    <section class="event-sponsors" id="patrocinadores">
        <div class="event-sponsor-copy"><p class="eyebrow">GRACIAS POR HACERLO POSIBLE <span class="eyebrow-line"></span></p><h2>La innovación<br>se construye <em>en equipo.</em></h2><p>Conoce a las organizaciones y personas que apoyan la Semana de Sistemas.</p></div>
        <div class="event-sponsor-board"><img class="event-sponsors-poster" src="{{ asset('images/patrocinadores.png') }}" alt="Patrocinadores de la Semana de Sistemas 2026: José N. Batres, Bela Coqué, Las Perlitas, Onective, Cooperativa Acogualupana y Ferretería El Roble." loading="lazy"></div>
    </section>

    <section class="event-section event-team" id="equipo">
        <div class="event-section-heading"><div><p class="eyebrow eyebrow-dark">QUIÉNES ESTÁN DETRÁS <span class="eyebrow-line"></span></p><h2>Hecho con ideas<br><em>y trabajo en equipo.</em></h2></div><p>El equipo que diseñó y desarrolló este espacio para compartir las actividades de nuestra carrera.</p></div>
        <div class="event-team-gallery" aria-label="Fotografías del equipo creador">
            @foreach(['team-03.jpeg', 'team-01.jpeg'] as $photo)
                <figure class="event-team-photo">
                    <img src="{{ asset('images/team/'.$photo) }}" alt="Osiris Ivania Andrade Campos y Bryan Arturo Hernandez Gutierrez en la Semana de Sistemas 2026" loading="lazy">
                    <figcaption>
                        <strong>Osiris Ivania Andrade Campos<br>Bryan Arturo Hernandez Gutierrez</strong>
                        <span>(Evidencia de asistencia a todas las actividades de SDS 2026)</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    <section class="event-section event-evidence" id="evidencias">
        <div class="event-section-heading"><div><p class="eyebrow eyebrow-dark">MEMORIA DE LA SEMANA <span class="eyebrow-line"></span> SDS26</p><h2>Evidencias<br><em>por integrante.</em></h2></div><p>Fotograf&iacute;as organizadas por actividad y por la persona del equipo que las comparti&oacute;.</p></div>
        <div class="event-evidence-links">
            @foreach(['bryan' => 'Bryan Arturo Hernandez Gutierrez', 'osiris' => 'Osiris Ivania Andrade Campos'] as $slug => $name)
                <a class="event-evidence-card" href="{{ route('evidence.profile', $slug) }}"><span class="event-evidence-number">SDS26 / EVIDENCIAS</span><strong>{{ $name }}</strong><span>Ver fotograf&iacute;as por actividad <b aria-hidden="true">&#8594;</b></span></a>
            @endforeach
        </div>
    </section>

    <section class="event-bottom-cta"><p>¿Quieres descubrir las historias de esta semana?</p><a href="{{ route('home') }}#publicaciones" class="button button-primary">Ver publicaciones</a></section>
</main>
@endsection
