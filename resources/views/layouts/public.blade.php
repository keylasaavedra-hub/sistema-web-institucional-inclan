<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Portal institucional de la IE Crl. José Joaquín Inclán"
    >

    <title>
        {{ $title }} | IE Crl. José Joaquín Inclán
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-gray-800">

<header
    x-data="{
        menuAbierto: false,
        institucionAbierta: false
    }"
    class="sticky top-0 z-50 border-b border-amber-300 bg-white/95 shadow-sm backdrop-blur"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex min-h-24 items-center justify-between gap-5">

            {{-- Logo e identidad --}}
            <a
                href="{{ url('/') }}"
                class="flex min-w-0 items-center gap-3"
            >
                <img
                    src="{{ asset('images/escudo.png') }}"
                    alt="Escudo de la IE Crl. José Joaquín Inclán"
                    class="h-20 w-20 shrink-0 object-contain"
                >

                <div class="min-w-0">
                    <p class="truncate text-lg font-extrabold text-emerald-800">
                        IE Crl. José Joaquín Inclán
                    </p>

                    <p class="text-xs font-medium text-gray-500">
                        Portal institucional
                    </p>
                </div>
            </a>

            {{-- Menú escritorio --}}
            <nav class="hidden items-center gap-1 lg:flex">

                <a
                    href="{{ url('/') }}"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                >
                    Inicio
                </a>

                {{-- Menú Institución --}}
                <div class="relative">
                    <button
                        type="button"
                        @click="institucionAbierta = !institucionAbierta"
                        @click.outside="institucionAbierta = false"
                        class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                    >
                        Institución

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="institucionAbierta"
                        x-transition
                        class="absolute left-0 mt-2 w-72 overflow-hidden rounded-2xl border border-amber-100 bg-white py-2 shadow-2xl"
                    >
                        <a
                            href="#quienes-somos"
                            class="block px-5 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800"
                        >
                            Quiénes somos
                        </a>

                        <a
                            href="#mision-vision"
                            class="block px-5 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800"
                        >
                            Misión, visión y valores
                        </a>

                        <a
                            href="#comunidad"
                            class="block px-5 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800"
                        >
                            Autoridades y personal
                        </a>

                        <a
                            href="#infraestructura"
                            class="block px-5 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800"
                        >
                            Infraestructura
                        </a>

                        <a
                            href="#reconocimientos"
                            class="block px-5 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800"
                        >
                            Logros y convenios
                        </a>
                    </div>
                </div>

                <a
                    href="#servicios"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                >
                    Servicios
                </a>

                <a
                    href="#noticias"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                >
                    Noticias
                </a>

                <a
                    href="#convocatorias"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                >
                    Convocatorias
                </a>

                <a
                    href="#contacto"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-emerald-50 hover:text-emerald-800"
                >
                    Contacto
                </a>
            </nav>

            {{-- Acciones --}}
            <div class="hidden items-center gap-2 lg:flex">

                {{-- SieWeb: plataforma externa --}}
                <a
                    href="{{ $sieweb->url ?? 'https://inclanpiura.sieweb.com.pe/sistema/login' }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-400 bg-white px-4 py-2.5 text-sm font-bold text-emerald-800 transition hover:bg-amber-50"
                >
                    SieWeb

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M14 3h7v7"/>
                        <path d="M10 14L21 3"/>
                        <path d="M21 14v5a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h5"/>
                    </svg>
                </a>

                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center rounded-xl bg-emerald-800 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-700"
                >
                    Iniciar sesión
                </a>
            </div>

            {{-- Botón móvil --}}
            <button
                type="button"
                @click="menuAbierto = !menuAbierto"
                class="rounded-xl border border-gray-200 p-2.5 text-gray-700 lg:hidden"
                aria-label="Abrir menú"
            >
                <svg
                    x-show="!menuAbierto"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

                <svg
                    x-cloak
                    x-show="menuAbierto"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        {{-- Menú móvil --}}
        <div
            x-cloak
            x-show="menuAbierto"
            x-transition
            class="border-t border-gray-100 py-4 lg:hidden"
        >
            <div class="flex flex-col gap-1">

                <a
                    href="{{ url('/') }}"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Inicio
                </a>

                <a
                    href="#quienes-somos"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Institución
                </a>

                <a
                    href="#servicios"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Servicios
                </a>

                <a
                    href="#noticias"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Noticias
                </a>

                <a
                    href="#convocatorias"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Convocatorias
                </a>

                <a
                    href="#contacto"
                    class="rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-emerald-50"
                >
                    Contacto
                </a>

                <div class="mt-3 grid grid-cols-2 gap-2">

                    <a
                        href="https://inclanpiura.sieweb.com.pe/sistema/login"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-xl border-2 border-amber-400 px-3 py-2.5 text-center text-sm font-bold text-emerald-800"
                    >
                        SieWeb ↗
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="rounded-xl bg-emerald-800 px-3 py-2.5 text-center text-sm font-bold text-white"
                    >
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer id="contacto" class="bg-emerald-950 text-white">

    <div class="border-b border-emerald-700 bg-emerald-800">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-7 sm:px-6 md:grid-cols-3 lg:px-8">

            <div>
                <p class="text-sm text-emerald-100">
                    ¿Tienes consultas?
                </p>

                <p class="mt-1 font-bold">
                    Estamos para ayudarte
                </p>
            </div>

            <div>
                <p class="text-sm text-emerald-100">
                    Teléfono
                </p>

                <p class="mt-1 font-bold">
                    Próximamente
                </p>
            </div>

            <div>
                <p class="text-sm text-emerald-100">
                    Correo institucional
                </p>

                <p class="mt-1 font-bold">
                    Próximamente
                </p>
            </div>
        </div>
    </div>

    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">

        <div>
            <div class="flex items-center gap-4">
                <img
                    src="{{ asset('images/escudo.png') }}"
                    alt="Escudo institucional"
                    class="h-24 w-24 object-contain"
                >

                <div>
                    <p class="font-extrabold">
                        IE Crl. José Joaquín Inclán
                    </p>

                    <p class="mt-1 text-sm font-semibold text-amber-300">
                        Dios · Patria · Cultura
                    </p>
                </div>
            </div>

            <p class="mt-5 text-sm leading-6 text-emerald-100">
                Portal institucional de información, comunicación y servicios
                para nuestra comunidad educativa.
            </p>
        </div>

        <div>
            <h3 class="font-bold text-amber-300">
                Enlaces rápidos
            </h3>

            <div class="mt-4 flex flex-col gap-2 text-sm text-emerald-100">
                <a href="{{ url('/') }}" class="hover:text-white">Inicio</a>
                <a href="#quienes-somos" class="hover:text-white">Institución</a>
                <a href="#servicios" class="hover:text-white">Servicios</a>
                <a href="#noticias" class="hover:text-white">Noticias</a>
                <a href="#convocatorias" class="hover:text-white">Convocatorias</a>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-amber-300">
                Plataforma externa
            </h3>

            <div class="mt-4">
                <a
                    href="https://inclanpiura.sieweb.com.pe/sistema/login"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-400 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-900"
                >
                    Acceder a SieWeb ↗
                </a>
            </div>

            <p class="mt-4 text-xs leading-5 text-emerald-200">
                SieWeb es una plataforma externa e independiente de este portal.
            </p>
        </div>
    </div>

    <div class="border-t border-emerald-800 px-4 py-4 text-center text-sm text-emerald-200">
        © {{ date('Y') }} IE Crl. José Joaquín Inclán. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>