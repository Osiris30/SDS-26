
@extends('layouts.app')

@section('title', 'Inicio | Semana de Sistemas 2026')

@section('content')


<section class="bg-azul-oscuro px-6 py-24 text-white">
    <div class="mx-auto max-w-7xl text-center">

        <span class="font-semibold tracking-widest text-verde-claro">
            UNIVERSIDAD DE EL SALVADOR
        </span>

        <h1 class="mt-6 text-4xl font-bold md:text-6xl">
            Semana de
            <span class="text-verde-claro">Sistemas 2026</span>
        </h1>

        <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-200">
            Un espacio para compartir experiencias,
            innovación, tecnología y los mejores momentos
            de nuestra Semana de Sistemas.
        </p>

        <a href="#publicaciones"
           class="mt-8 inline-block rounded-lg bg-verde-claro px-8 py-3
                  font-semibold text-azul-oscuro transition hover:bg-verde">
            Explorar publicaciones
        </a>

    </div>
</section>



<section id="publicaciones" class="bg-white px-6 py-20">

    <div class="mx-auto max-w-7xl">

      
        <div class="mb-12 text-center">

            <h2 class="text-3xl font-bold text-azul-oscuro">
                Últimas publicaciones
            </h2>

            <p class="mt-3 text-gray-600">
                Descubre las noticias y actividades de nuestra semana.
            </p>

        </div>

       
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            <x-card
                titulo="Inauguración de la Semana de Sistemas 2026"
                categoria="Noticia"
                descripcion="Conoce los detalles de la inauguración y las actividades que forman parte de nuestra Semana de Sistemas."
                fecha="Semana de Sistemas 2026"
            />

            <x-card
                titulo="Feria de Logros"
                categoria="Actividad"
                descripcion="Descubre los proyectos tecnológicos y las propuestas innovadoras presentadas por nuestros estudiantes."
                fecha="Semana de Sistemas 2026"
            />

            <x-card
                titulo="Innovación y tecnología"
                categoria="Evento"
                descripcion="Un espacio para compartir conocimientos, experiencias e ideas relacionadas con el desarrollo tecnológico."
                fecha="Semana de Sistemas 2026"
            />

        </div>

    </div>

</section>


<section id="nosotros" class="bg-celeste/10 px-6 py-20">

    <div class="mx-auto max-w-4xl text-center">

        <h2 class="text-3xl font-bold text-azul-oscuro">
            Sobre la Semana de Sistemas
        </h2>

        <p class="mt-6 leading-relaxed text-gray-700">
            La Semana de Sistemas 2026 es un espacio académico
            para compartir conocimientos, proyectos y experiencias
            relacionadas con la tecnología y la innovación.
        </p>

    </div>

</section>

@endsection
