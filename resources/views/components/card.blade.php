@props([
    'titulo' => 'Título de la publicación',
    'categoria' => 'Noticia',
    'descripcion' => 'Descripción de la publicación.',
    'fecha' => null,
    'imagen' => null,
    'enlace' => '#',
])

<article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

    
    <div class="flex h-48 items-center justify-center bg-celeste/15">
        @if($imagen)
            <img
                src="{{ $imagen }}"
                alt="{{ $titulo }}"
                class="h-full w-full object-cover"
            >
        @else
            <span class="text-lg font-bold text-azul-oscuro">
                SDS 2026
            </span>
        @endif
    </div>

    
    <div class="p-6">

        <span class="rounded-full bg-verde/15 px-3 py-1 text-xs font-semibold text-verde">
            {{ $categoria }}
        </span>

        <h3 class="mt-4 text-xl font-bold text-azul-oscuro">
            {{ $titulo }}
        </h3>

        <p class="mt-3 text-sm leading-relaxed text-gray-600">
            {{ $descripcion }}
        </p>

        @if($fecha)
            <p class="mt-4 text-xs text-gray-500">
                {{ $fecha }}
            </p>
        @endif

        <a href="{{ $enlace }}"
           class="mt-5 inline-block font-semibold text-azul-oscuro hover:text-verde">
            Leer más →
        </a>

    </div>
</article>
