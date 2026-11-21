
<header class="bg-azul-oscuro text-white shadow-md">
    <nav class="mx-auto max-w-7xl px-6">

        <div class="flex h-20 items-center justify-between">

            <!-- LOGO -->
            <a href="{{ route('home') }}"
               class="text-2xl font-bold tracking-wide">

                <span class="text-verde-claro">SDS</span>
                <span class="text-white">2026</span>

            </a>

            <!-- MENÚ PARA COMPUTADORAS -->
            <div class="hidden items-center gap-8 md:flex">

                <a href="{{ route('home') }}"
                   class="font-medium transition hover:text-verde-claro">
                    Inicio
                </a>

                <a href="{{ route('home') }}#publicaciones"
                   class="font-medium transition hover:text-verde-claro">
                    Publicaciones
                </a>

                <a href="{{ route('home') }}#nosotros"
                   class="font-medium transition hover:text-verde-claro">
                    Nosotros
                </a>

            </div>

            <!-- BOTÓN PARA CELULARES -->
            <button
                type="button"
                id="menu-toggle"
                class="rounded-lg border border-white/20 p-2 md:hidden"
                aria-label="Abrir menú"
                aria-expanded="false"
                aria-controls="mobile-menu">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>

        <!-- MENÚ DESPLEGABLE PARA CELULARES -->
        <div id="mobile-menu"
             class="hidden border-t border-white/20 pb-5 md:hidden">

            <div class="flex flex-col gap-4 pt-5">

                <a href="{{ route('home') }}"
                   class="transition hover:text-verde-claro">
                    Inicio
                </a>

                <a href="{{ route('home') }}#publicaciones"
                   class="transition hover:text-verde-claro">
                    Publicaciones
                </a>

                <a href="{{ route('home') }}#nosotros"
                   class="transition hover:text-verde-claro">
                    Nosotros
                </a>

            </div>

        </div>

    </nav>
</header>
