<x-public-layout title="Inicio">

    {{-- Portada --}}
    <section class="relative overflow-hidden bg-white">

        <div class="pointer-events-none absolute -left-32 top-10 h-80 w-80 rounded-full bg-amber-300/20 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 right-1/3 h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>

        <div class="mx-auto grid min-h-[620px] max-w-7xl lg:grid-cols-[1.05fr_0.95fr]">

            <div class="relative z-10 flex items-center px-5 py-16 sm:px-8 lg:px-12">

                <div class="w-full max-w-2xl">

                    <div class="inline-flex items-center gap-3 rounded-full border border-amber-300 bg-amber-50 px-4 py-2">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-700">
                            Portal institucional
                        </p>
                    </div>

                    <h1 class="mt-6 text-4xl font-extrabold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">
                        Institución Educativa
                        <span class="mt-2 block text-emerald-800">
                            Crl. José Joaquín Inclán
                        </span>
                    </h1>

                    <div class="mt-6 flex items-center gap-3">
                        <span class="h-1 w-20 rounded-full bg-amber-400"></span>
                        <span class="h-1 w-8 rounded-full bg-emerald-700"></span>
                    </div>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-gray-600">
                        Información, comunicación, trámites y servicios digitales
                        para estudiantes, padres de familia, docentes y toda nuestra
                        comunidad educativa.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">

                        <a
                            href="#noticias"
                            class="rounded-xl bg-emerald-800 px-6 py-3.5 font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-emerald-700">
                            Ver noticias
                        </a>

                        <a
                            href="#servicios"
                            class="rounded-xl border-2 border-amber-400 bg-white px-6 py-3 font-bold text-emerald-900 transition hover:bg-amber-50">
                            Servicios digitales
                        </a>
                    </div>

                    {{-- Buscador interno --}}
                    <div class="mt-10 rounded-2xl border border-gray-100 bg-white p-3 shadow-xl">

                        <form
                            action="#"
                            method="GET"
                            class="flex flex-col gap-3 sm:flex-row">
                            <div class="relative flex-1">

                                <svg
                                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="11" cy="11" r="7" />
                                    <path d="m20 20-3.5-3.5" />
                                </svg>

                                <input
                                    type="search"
                                    name="q"
                                    placeholder="Buscar noticias, documentos o convocatorias..."
                                    class="h-12 w-full rounded-xl border-gray-200 pl-12 pr-4 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                            </div>

                            <button
                                type="submit"
                                class="h-12 rounded-xl bg-emerald-800 px-7 font-bold text-white hover:bg-emerald-700">
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Fotografía principal --}}
            <div class="relative min-h-[440px] overflow-hidden lg:min-h-full">

                <img
                    src="{{ asset('images/portada-institucion.jpg') }}"
                    alt="Instalaciones de la IE Crl. José Joaquín Inclán"
                    class="absolute inset-0 h-full w-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/70 via-transparent to-transparent"></div>

                <div class="absolute inset-y-0 left-0 hidden w-32 bg-gradient-to-r from-white to-transparent lg:block"></div>

                <div class="absolute bottom-7 left-6 right-6 rounded-2xl border border-white/30 bg-emerald-950/80 p-5 text-white backdrop-blur sm:left-auto sm:max-w-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">
                        Nuestra identidad
                    </p>

                    <p class="mt-1 text-lg font-bold">
                        Dios · Patria · Cultura
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Accesos destacados --}}
    <section class="relative z-20 -mt-7 px-4 sm:px-6">

        <div class="mx-auto grid max-w-6xl overflow-hidden rounded-3xl border border-amber-200 bg-white shadow-2xl sm:grid-cols-2 lg:grid-cols-5">

            @php
            $accesos = [
            ['Nuestra forma de enseñar', '#quienes-somos', '♥'],
            ['Infraestructura', '#infraestructura', '◆'],
            ['Logros y reconocimientos', '#reconocimientos', '★'],
            ['Formación en valores', '#mision-vision', '✦'],
            ['Convocatorias', '#convocatorias', '▣'],
            ];
            @endphp

            @foreach ($accesos as $acceso)
            <a
                href="{{ $acceso[1] }}"
                class="group border-b border-gray-100 p-6 text-center transition hover:bg-emerald-50 lg:border-b-0 lg:border-r last:border-r-0">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-2xl text-emerald-800 transition group-hover:-translate-y-1 group-hover:bg-emerald-800 group-hover:text-white">
                    {{ $acceso[2] }}
                </div>

                <p class="mt-4 font-bold text-gray-800">
                    {{ $acceso[0] }}
                </p>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Servicios digitales --}}
    <section id="servicios" class="py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">
                    Atención en línea
                </p>

                <h2 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Servicios digitales
                </h2>

                <div class="mx-auto mt-4 flex w-fit gap-2">
                    <span class="h-1 w-14 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-8 rounded-full bg-amber-400"></span>
                </div>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ([
                ['Consultas', 'Envía consultas y realiza seguimiento mediante un código.'],
                ['Mesa de partes', 'Presenta documentos, solicitudes y archivos sustentatorios.'],
                ['Documentos', 'Consulta y descarga documentos institucionales públicos.'],
                ['Convocatorias', 'Revisa oportunidades laborales y prácticas vigentes.'],
                ] as $servicio)

                <a
                    href="#"
                    class="group rounded-3xl border border-gray-100 bg-white p-7 shadow-lg transition hover:-translate-y-2 hover:border-amber-300 hover:shadow-xl">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-2xl font-bold text-emerald-800 transition group-hover:bg-emerald-800 group-hover:text-white">
                        ✓
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-emerald-950">
                        {{ $servicio[0] }}
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        {{ $servicio[1] }}
                    </p>

                    <p class="mt-5 text-sm font-bold text-emerald-700">
                        Acceder →
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Infraestructura --}}
    <section id="infraestructura" class="bg-gray-50 py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">
                    Espacios educativos
                </p>

                <h2 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Nuestra infraestructura
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ([
                ['infraestructura-biblioteca.jpg', 'Biblioteca'],
                ['infraestructura-campo.jpg', 'Campos deportivos'],
                ['infraestructura-ciencia.jpg', 'Laboratorio de ciencia'],
                ['infraestructura-computo.jpg', 'Laboratorio de cómputo'],
                ] as $espacio)

                <article class="group overflow-hidden rounded-3xl bg-white shadow-lg">

                    <div class="h-64 overflow-hidden">
                        <img
                            src="{{ asset('images/'.$espacio[0]) }}"
                            alt="{{ $espacio[1] }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>

                    <div class="border-t-4 border-amber-400 bg-emerald-800 p-5 text-white">
                        <h3 class="font-bold">
                            {{ $espacio[1] }}
                        </h3>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Servicios complementarios --}}
    <section class="py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">
                    Bienestar estudiantil
                </p>

                <h2 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Servicios complementarios
                </h2>
            </div>

            <div class="mt-12 grid gap-7 md:grid-cols-3">

                @foreach ([
                ['servicio-topico.jpg', 'Tópico', 'Atención y cuidado de la salud para nuestra comunidad educativa.'],
                ['servicio-toece.jpg', 'TOECE', 'Orientación educativa y acompañamiento a estudiantes.'],
                ['servicio-psicologia.jpg', 'Psicología', 'Acompañamiento emocional, familiar y personal.'],
                ] as $servicio)

                <article class="group overflow-hidden rounded-3xl border border-amber-200 bg-white shadow-lg">

                    <div class="h-72 overflow-hidden">
                        <img
                            src="{{ asset('images/'.$servicio[0]) }}"
                            alt="{{ $servicio[1] }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>

                    <div class="bg-emerald-800 p-6 text-white">
                        <h3 class="text-xl font-bold">
                            {{ $servicio[1] }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-emerald-100">
                            {{ $servicio[2] }}
                        </p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Noticias --}}
    <section id="noticias" class="bg-gray-50 py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">
                        Actualidad institucional
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold text-emerald-950">
                        Noticias y comunicados
                    </h2>
                </div>

                <a
                    href="#"
                    class="font-bold text-emerald-700 hover:text-emerald-900">
                    Ver todas las noticias →
                </a>
            </div>

            <div class="mt-12 grid gap-7 md:grid-cols-3">

                @forelse ($publicaciones as $publicacion)

                <article
                    class="group overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg shadow-gray-200/60 transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-56 overflow-hidden bg-gray-100">

                        <img
                            @php
                            $imagenPublicacion=$publicacion->imagen_portada
                        && file_exists(public_path($publicacion->imagen_portada))
                        ? asset($publicacion->imagen_portada)
                        : asset('images/noticia-default.jpg');
                        @endphp

                        <img
                            src="{{ $imagenPublicacion }}"
                            alt="{{ $publicacion->titulo }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        alt="{{ $publicacion->titulo }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                        @if ($publicacion->destacada)
                        <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1 text-xs font-bold text-emerald-950">
                            Destacada
                        </span>
                        @endif

                    </div>

                    <div class="p-6">

                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                            {{ $publicacion->categoria ?? 'Publicación' }}
                        </span>

                        <h3 class="mt-4 text-xl font-bold text-gray-900">
                            {{ $publicacion->titulo }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            {{ \Illuminate\Support\Str::limit(
                        strip_tags($publicacion->contenido),
                        125
                    ) }}
                        </p>

                        <div class="mt-5 flex items-center justify-between gap-4">

                            <span class="text-xs text-gray-500">
                                {{ $publicacion->fecha_publicacion
                            ? \Illuminate\Support\Carbon::parse(
                                $publicacion->fecha_publicacion
                            )->format('d/m/Y')
                            : 'Publicación institucional' }}
                            </span>

                            <a
                                href="#"
                                class="text-sm font-bold text-emerald-700 hover:text-emerald-900">
                                Leer más →
                            </a>

                        </div>
                    </div>
                </article>

                @empty

                <div class="md:col-span-3 rounded-3xl border border-dashed border-emerald-200 bg-emerald-50/50 px-6 py-14 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-emerald-800 shadow-sm">
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 5h16v14H4z" />
                            <path d="M8 9h8M8 13h5" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-emerald-950">
                        Próximamente publicaremos novedades
                    </h3>

                    <p class="mx-auto mt-2 max-w-xl text-gray-600">
                        En esta sección aparecerán las noticias, comunicados y anuncios
                        registrados desde el panel administrativo.
                    </p>

                </div>

                @endforelse

            </div>
        </div>
    </section>

    {{-- Convocatorias --}}
    <section id="convocatorias" class="bg-emerald-950 py-24 text-white">

        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">

            <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">
                Oportunidades
            </p>

            <h2 class="mt-3 text-4xl font-extrabold">
                Convocatorias vigentes
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-lg text-emerald-100">
                Consulta convocatorias laborales, administrativas y de prácticas.
            </p>

            <a
                href="#"
                class="mt-8 inline-flex rounded-xl bg-amber-400 px-7 py-3.5 font-bold text-emerald-950 transition hover:bg-amber-300">
                Ver convocatorias
            </a>
        </div>
    </section>

</x-public-layout>