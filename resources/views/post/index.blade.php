
@extends('layouts.app')

@section('title', 'Publicaciones | Semana de Sistemas 2026')

@section('content')

<!-- ENCABEZADO -->
<section class="bg-azul-oscuro px-6 py-16 text-white">
    <div class="mx-auto max-w-7xl text-center">

        <span class="font-semibold tracking-widest text-verde-claro">
            SDS 2026
        </span>

        <h1 class="mt-4 text-4xl font-bold md:text-5xl">
            Nuestras publicaciones
        </h1>

        <p class="mx-auto mt-5 max-w-2xl text-gray-200">
            Conoce las noticias, actividades y eventos
            de la Semana de Sistemas 2026.
        </p>

    </div>
</section>

<!-- LISTADO DE PUBLICACIONES -->
<section class="bg-gray-50 px-6 py-16">
    <div class="mx-auto max-w-7xl">

        <!-- BUSCADOR VISUAL -->
        <div class="mb-10 rounded-xl bg-white p-6 shadow-sm">

            <form action="{{ url('/publicaciones') }}"
                  method="GET"
                  class="flex flex-col gap-4 md:flex-row">

                <input
                    type="search"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar publicaciones..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-verde"
                >

                <button
                    type="submit"
                    class="rounded-lg bg-verde-claro px-8 py-3 font-semibold text-azul-oscuro transition hover:bg-verde">
                    Buscar
                </button>

            </form>

        </div>

        <!-- TARJETAS -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            <x-card
                titulo="Inauguración de la Semana de Sistemas 2026"
                categoria="Noticia"
                descripcion="Conoce los detalles de nuestra inauguración y las actividades programadas."
                fecha="Semana de Sistemas 2026"
            />

            <x-card
                titulo="Feria de Logros"
                categoria="Actividad"
                descripcion="Descubre los proyectos tecnológicos desarrollados por nuestros estudiantes."
                fecha="Semana de Sistemas 2026"
            />

            <x-card
                titulo="Innovación y tecnología"
                categoria="Evento"
                descripcion="Un espacio para compartir conocimientos y experiencias tecnológicas."
                fecha="Semana de Sistemas 2026"
            />

        </div>

        <!-- MENSAJE INFORMATIVO -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500">
                Próximamente encontrarás más publicaciones.
            </p>
        </div>

    </div>
</section>

@endsection
