<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        name="description"
        content="Portal institucional de la IE Crl. José Joaquín Inclán">

    <title>{{ $title }} | IE Crl. José Joaquín Inclán</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-slate-800 antialiased">

    @php
    $siewebUrl = $sieweb->url ?? 'https://inclanpiura.sieweb.com.pe/sistema/login';
    @endphp

    <header
        x-data="{
            menuMovil: false,
            menuAbierto: null,

            alternar(menu) {
                this.menuAbierto = this.menuAbierto === menu ? null : menu;
            },

            cerrarMenus() {
                this.menuAbierto = null;
            }
        }"
        @keydown.escape.window="cerrarMenus(); menuMovil = false"
        class="sticky top-0 z-50">

        <div class="h-1.5 bg-gradient-to-r from-emerald-950 via-amber-400 to-emerald-950"></div>

        <div class="border-b border-amber-300/70 bg-white/95 shadow-[0_10px_35px_rgba(3,52,39,0.10)] backdrop-blur-xl">

            <div class="mx-auto max-w-[1800px] px-5 sm:px-7 xl:px-10">

                <div class="grid min-h-[104px] grid-cols-[minmax(250px,320px)_minmax(0,1fr)_auto] items-center gap-5">

                    {{-- Identidad institucional --}}
                    <a
                        href="{{ route('inicio') }}"
                        class="group flex min-w-0 items-center gap-4">

                        <div class="relative shrink-0">
                            <div class="absolute inset-0 rounded-[22px] bg-amber-300/25 blur-lg transition duration-300 group-hover:bg-amber-300/45"></div>

                            <div class="relative flex h-[78px] w-[78px] items-center justify-center rounded-[22px] border border-amber-300 bg-white p-1.5 shadow-lg shadow-emerald-950/10">
                                <img
                                    src="{{ asset('images/escudo.png') }}"
                                    alt="Escudo de la IE Crl. José Joaquín Inclán"
                                    class="h-full w-full object-contain">
                            </div>
                        </div>

                        <div class="hidden min-w-0 sm:block">
                            <p class="text-[17px] font-extrabold leading-5 tracking-tight text-emerald-950 xl:text-lg">
                                <span class="block">IE Crl. José Joaquín</span>
                                <span class="block">Inclán</span>
                            </p>

                            <div class="mt-2 flex items-center gap-2">
                                <span class="h-px w-9 bg-amber-400"></span>

                                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-amber-700">
                                    Portal institucional
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Menú escritorio: solo en pantallas realmente amplias --}}
                    <nav class="hidden min-w-0 items-center justify-center gap-1 2xl:flex">

                        <a
                            href="{{ route('inicio') }}"
                            class="group relative inline-flex min-h-12 items-center gap-2 rounded-2xl px-3.5 text-[13px] font-extrabold transition
                                {{ request()->routeIs('inicio')
                                    ? 'bg-emerald-50 text-emerald-950'
                                    : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-950' }}">

                            <svg class="h-5 w-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 11.5 12 4l9 7.5" />
                                <path d="M5.5 10.5V20h13v-9.5" />
                                <path d="M9.5 20v-6h5v6" />
                            </svg>

                            Inicio

                            <span
                                class="absolute bottom-0 left-1/2 h-0.5 -translate-x-1/2 rounded-full bg-amber-400 transition-all
                                    {{ request()->routeIs('inicio') ? 'w-8' : 'w-0 group-hover:w-8' }}">
                            </span>
                        </a>
                        {{-- Institución --}}
                        <div
                            class="relative"
                            @click.outside="menuAbierto === 'institucion' && cerrarMenus()">
                            <button
                                type="button"
                                @click="alternar('institucion')"
                                class="inline-flex min-h-12 items-center gap-2 rounded-2xl
                                       px-3.5 text-[13px] font-extrabold text-slate-700
                                       transition hover:bg-emerald-50 hover:text-emerald-950">
                                <svg
                                    class="h-5 w-5 text-emerald-700"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M3 21h18" />
                                    <path d="M5 21V9l7-4 7 4v12" />
                                    <path d="M9 13h2v3H9zM13 13h2v3h-2z" />
                                </svg>

                                Institución

                                <svg
                                    class="h-4 w-4 transition-transform"
                                    :class="menuAbierto === 'institucion' ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="menuAbierto === 'institucion'"
                                x-transition
                                class="absolute left-0 top-full mt-3 w-[360px]
                                       overflow-hidden rounded-3xl border border-amber-200
                                       bg-white p-2 shadow-2xl shadow-emerald-950/15">
                                <div class="rounded-2xl bg-emerald-950 px-4 py-3 text-white">
                                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                        Nuestra institución
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-emerald-100">
                                        Conoce nuestra historia, identidad y propuesta educativa.
                                    </p>
                                </div>

                                <div class="mt-2 grid gap-1">

                                    <a
                                        href="{{ url('/institucion/resena-historica') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Reseña histórica
                                            </strong>
                                            <small class="text-gray-500">
                                                Nuestra trayectoria institucional.
                                            </small>
                                        </span>
                                    </a>

                                    <a
                                        href="{{ url('/institucion/mision-vision-valores') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="m8 12 2.5 2.5L16 9" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Misión, visión y valores
                                            </strong>
                                            <small class="text-gray-500">
                                                Principios que orientan nuestra labor.
                                            </small>
                                        </span>
                                    </a>

                                    <a
                                        href="{{ url('/institucion/infraestructura') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M3 21h18" />
                                                <path d="M5 21V8l7-4 7 4v13" />
                                                <path d="M9 12h2v3H9zM13 12h2v3h-2z" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Infraestructura
                                            </strong>
                                            <small class="text-gray-500">
                                                Ambientes y espacios educativos.
                                            </small>
                                        </span>
                                    </a>

                                    <a
                                        href="{{ url('/institucion/convenios') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M8 12 11 15 16 10" />
                                                <path d="M3 7h4l3 3M21 7h-4l-3 3" />
                                                <path d="M5 17h4l3-3 3 3h4" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Convenios
                                            </strong>
                                            <small class="text-gray-500">
                                                Alianzas y cooperación institucional.
                                            </small>
                                        </span>
                                    </a>

                                    <a
                                        href="{{ url('/institucion/comunidad-educativa') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="8" cy="8" r="3" />
                                                <circle cx="17" cy="8" r="3" />
                                                <path d="M3 20v-2a5 5 0 0 1 5-5" />
                                                <path d="M21 20v-2a5 5 0 0 0-5-5" />
                                                <path d="M10 20v-2a4 4 0 0 1 8 0v2" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Comunidad educativa
                                            </strong>
                                            <small class="text-gray-500">
                                                Directivos, docentes y personal.
                                            </small>
                                        </span>
                                    </a>

                                    <a
                                        href="{{ url('/institucion/nuestra-forma-de-ensenar') }}"
                                        class="group flex items-start gap-3 rounded-2xl px-4 py-3
                                               transition hover:bg-emerald-50">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                   rounded-xl border border-amber-200 bg-emerald-950
                                                   text-white transition group-hover:bg-emerald-900">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5z" />
                                                <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5z" />
                                            </svg>
                                        </span>

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Nuestra forma de enseñar
                                            </strong>
                                            <small class="text-gray-500">
                                                Enfoque y metodología educativa.
                                            </small>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>


                        {{-- Servicios --}}
                        <div class="relative" @click.outside="menuAbierto === 'servicios' && cerrarMenus()">
                            <button
                                type="button"
                                @click="alternar('servicios')"
                                class="inline-flex min-h-12 items-center gap-2 rounded-2xl px-3.5 text-[13px] font-extrabold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-950">

                                <svg class="h-5 w-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="7" width="18" height="13" rx="2" />
                                    <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" />
                                    <path d="M8 12h8" />
                                </svg>

                                Servicios

                                <svg
                                    class="h-4 w-4 transition-transform"
                                    :class="menuAbierto === 'servicios' ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="menuAbierto === 'servicios'"
                                x-transition
                                class="absolute left-0 top-full mt-3 w-80 overflow-hidden rounded-3xl border border-amber-200 bg-white p-2 shadow-2xl shadow-emerald-950/15">

                                <div class="rounded-2xl bg-emerald-950 px-4 py-3 text-white">
                                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                        Servicios en línea
                                    </p>
                                </div>

                                <div class="mt-2 space-y-1">
                                    <a href="{{ route('consultas.crear') }}" class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Consultas</strong>
                                        <small class="text-gray-500">Envía una consulta institucional.</small>
                                    </a>

                                    <a href="{{ route('consultas.seguimiento') }}" class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Seguimiento de consulta</strong>
                                        <small class="text-gray-500">Consulta el estado mediante tu código.</small>
                                    </a>

                                    <a href="{{ route('mesa-partes.crear') }}" class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Mesa de partes virtual</strong>
                                        <small class="text-gray-500">Presenta solicitudes y documentos.</small>
                                    </a>

                                    <a href="{{ route('documentos.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Documentos y descargas</strong>
                                        <small class="text-gray-500">Reglamentos, planes y formatos.</small>
                                    </a>

                                    <a href="{{ route('calendario.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Calendario institucional</strong>
                                        <small class="text-gray-500">Actividades y fechas importantes.</small>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Noticias --}}
                        <div class="relative" @click.outside="menuAbierto === 'noticias' && cerrarMenus()">
                            <button
                                type="button"
                                @click="alternar('noticias')"
                                class="inline-flex min-h-12 items-center gap-2 rounded-2xl px-3.5 text-[13px] font-extrabold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-950">

                                <svg class="h-5 w-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 5h16v14H4z" />
                                    <path d="M8 9h8M8 13h5M8 16h7" />
                                </svg>

                                Noticias

                                <svg
                                    class="h-4 w-4 transition-transform"
                                    :class="menuAbierto === 'noticias' ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="menuAbierto === 'noticias'"
                                x-transition
                                class="absolute left-0 top-full mt-3 w-72 overflow-hidden rounded-3xl border border-amber-200 bg-white p-2 shadow-2xl shadow-emerald-950/15">

                                <div class="rounded-2xl bg-emerald-950 px-4 py-3 text-white">
                                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                        Actualidad institucional
                                    </p>
                                </div>

                                <div class="mt-2 space-y-1">
                                    <a href="{{ route('publicaciones.index') }}"
                                        class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Noticias</strong>
                                        <small class="text-gray-500">Actividades y novedades.</small>
                                    </a>

                                    <a href="{{ route('publicaciones.index', ['categoria' => 'anuncios']) }}"
                                        class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Anuncios</strong>
                                        <small class="text-gray-500">Información de interés general.</small>
                                    </a>

                                    <a href="{{ route('publicaciones.index', ['categoria' => 'comunicados']) }}"
                                        class="block rounded-2xl px-4 py-3 hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">Comunicados</strong>
                                        <small class="text-gray-500">Información oficial institucional.</small>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Multimedia --}}
                        <div class="relative" @click.outside="menuAbierto === 'multimedia' && cerrarMenus()">
                            <button
                                type="button"
                                @click="alternar('multimedia')"
                                class="inline-flex min-h-12 items-center gap-2 rounded-2xl px-3.5 text-[13px] font-extrabold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-950">

                                <svg class="h-5 w-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m8 15 3-3 2 2 3-4 3 5" />
                                    <circle cx="8" cy="9" r="1" />
                                </svg>

                                Multimedia

                                <svg
                                    class="h-4 w-4 transition-transform"
                                    :class="menuAbierto === 'multimedia' ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="menuAbierto === 'multimedia'"
                                x-transition
                                class="absolute left-0 top-full mt-3 w-72 rounded-3xl border border-amber-200 bg-white p-2 shadow-2xl shadow-emerald-950/15">

                                <a href="{{ url('/galeria') }}" class="block rounded-2xl px-4 py-3 text-sm font-bold text-gray-700 hover:bg-emerald-50">
                                    Galería institucional
                                </a>

                                <a href="{{ url('/videos') }}" class="block rounded-2xl px-4 py-3 text-sm font-bold text-gray-700 hover:bg-emerald-50">
                                    Videos institucionales
                                </a>

                                <a href="{{ url('/promociones') }}" class="block rounded-2xl px-4 py-3 text-sm font-bold text-gray-700 hover:bg-emerald-50">
                                    Promociones escolares
                                </a>
                            </div>
                        </div>

                        {{-- Convocatorias --}}
                        <div class="relative" @click.outside="menuAbierto === 'convocatorias' && cerrarMenus()">
                            <button
                                type="button"
                                @click="alternar('convocatorias')"
                                class="inline-flex min-h-12 items-center gap-2 rounded-2xl px-3.5 text-[13px] font-extrabold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-950">

                                <svg class="h-5 w-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16v16H4z" />
                                    <path d="M8 8h8M8 12h8M8 16h5" />
                                </svg>

                                Convocatorias

                                <svg
                                    class="h-4 w-4 transition-transform"
                                    :class="menuAbierto === 'convocatorias' ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="menuAbierto === 'convocatorias'"
                                x-transition
                                class="absolute right-0 top-full mt-3 w-72 rounded-3xl border border-amber-200 bg-white p-2 shadow-2xl shadow-emerald-950/15">

                                <div class="rounded-2xl bg-emerald-950 px-4 py-3 text-white">
                                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                        Convocatorias
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-emerald-100">
                                        Consulta procesos, postula y revisa resultados.
                                    </p>
                                </div>

                                <div class="mt-2 space-y-1">
                                    <a
                                        href="{{ route('convocatorias.index') }}"
                                        class="block rounded-2xl px-4 py-3 transition hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">
                                            Convocatorias vigentes
                                        </strong>

                                        <small class="text-gray-500">
                                            Revisa los procesos disponibles y postula.
                                        </small>
                                    </a>

                                    <a
                                        href="{{ route('postulaciones.seguimiento') }}"
                                        class="block rounded-2xl px-4 py-3 transition hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">
                                            Consultar postulación
                                        </strong>

                                        <small class="text-gray-500">
                                            Consulta tu estado con código y DNI o correo.
                                        </small>
                                    </a>

                                    <a
                                        href="{{ route('postulaciones.resultados') }}"
                                        class="block rounded-2xl px-4 py-3 transition hover:bg-emerald-50">
                                        <strong class="block text-sm text-emerald-950">
                                            Resultados
                                        </strong>

                                        <small class="text-gray-500">
                                            Revisa postulantes aptos y seleccionados.
                                        </small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>

                    {{-- Acciones escritorio --}}
                    <div class="hidden shrink-0 items-center gap-3 2xl:flex">

                        <a
                            href="{{ $siewebUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group inline-flex min-h-13 items-center gap-3 rounded-2xl border-2 border-amber-400 bg-emerald-950 px-4 font-extrabold text-white shadow-lg shadow-emerald-950/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-900 hover:shadow-xl">

                            <span class="flex h-9 w-9 items-center justify-center rounded-xl border border-amber-300/70 bg-emerald-900 text-amber-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 10.5 12 4l9 6.5" />
                                    <path d="M5 9.5V20h14V9.5" />
                                    <path d="M8 14h8" />
                                    <path d="M9 17h6" />
                                </svg>
                            </span>

                            <span>SieWeb</span>

                            <svg class="h-4 w-4 text-amber-300 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 3h7v7" />
                                <path d="M10 14 21 3" />
                            </svg>
                        </a>

                        <a
                            href="{{ route('login') }}"
                            class="group inline-flex min-h-13 items-center gap-3 rounded-2xl border-2 border-amber-400 bg-emerald-950 px-5 font-extrabold text-white shadow-lg shadow-emerald-950/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-900 hover:shadow-xl">

                            <svg class="h-5 w-5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 17l5-5-5-5" />
                                <path d="M15 12H3" />
                                <path d="M14 4h5a2 2 0 012 2v12a2 2 0 01-2 2h-5" />
                            </svg>

                            Iniciar sesión
                        </a>
                    </div>

                    {{-- Botón menú móvil/tablet/laptop --}}
                    <button
                        type="button"
                        @click="menuMovil = !menuMovil"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-amber-400 bg-emerald-950 text-white shadow-md 2xl:hidden"
                        aria-label="Abrir menú principal">

                        <svg x-show="!menuMovil" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <svg x-cloak x-show="menuMovil" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </div>

                {{-- Menú móvil --}}
                <div
                    x-cloak
                    x-show="menuMovil"
                    x-transition
                    class="border-t border-gray-100 pb-5 pt-4 2xl:hidden">

                    <div class="space-y-2">
                        <a href="{{ route('inicio') }}"
                            class="block rounded-2xl bg-emerald-50 px-4 py-3 font-bold text-emerald-950">
                            Inicio
                        </a>

                        <details class="rounded-2xl border border-gray-100 bg-white">
                            <summary class="cursor-pointer px-4 py-3 font-bold text-gray-800">
                                Institución
                            </summary>

                            <div class="border-t border-gray-100 p-2">
                                <a
                                    href="{{ url('/institucion/resena-historica') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Reseña histórica
                                </a>

                                <a
                                    href="{{ url('/institucion/mision-vision-valores') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Misión, visión y valores
                                </a>

                                <a
                                    href="{{ url('/institucion/infraestructura') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Infraestructura
                                </a>

                                <a
                                    href="{{ url('/institucion/convenios') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Convenios
                                </a>

                                <a
                                    href="{{ url('/institucion/comunidad-educativa') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Comunidad educativa
                                </a>

                                <a
                                    href="{{ url('/institucion/nuestra-forma-de-ensenar') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Nuestra forma de enseñar
                                </a>
                            </div>
                        </details>

                        <details class="rounded-2xl border border-gray-100 bg-white">
                            <summary class="cursor-pointer px-4 py-3 font-bold text-gray-800">Servicios</summary>
                            <div class="border-t border-gray-100 p-2">
                                <a href="{{ route('consultas.crear') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Consultas</a>
                                <a href="{{ route('consultas.seguimiento') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Seguimiento de consulta</a>
                                <a href="{{ route('mesa-partes.crear') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Mesa de partes</a>
                                <a href="{{ route('documentos.index') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Documentos</a>
                                <a href="{{ route('calendario.index') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Calendario</a>
                            </div>
                        </details>

                        <details class="rounded-2xl border border-gray-100 bg-white">
                            <summary class="cursor-pointer px-4 py-3 font-bold text-gray-800">Noticias</summary>
                            <div class="border-t border-gray-100 p-2">
                                <a href="{{ route('publicaciones.index') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Noticias</a>
                                <a href="{{ route('publicaciones.index', ['categoria' => 'anuncios']) }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Anuncios</a>
                                <a href="{{ route('publicaciones.index', ['categoria' => 'comunicados']) }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Comunicados</a>
                            </div>
                        </details>

                        <details class="rounded-2xl border border-gray-100 bg-white">
                            <summary class="cursor-pointer px-4 py-3 font-bold text-gray-800">Multimedia</summary>
                            <div class="border-t border-gray-100 p-2">
                                <a href="{{ url('/galeria') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Galería</a>
                                <a href="{{ url('/videos') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Videos</a>
                                <a href="{{ url('/promociones') }}" class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">Promociones escolares</a>
                            </div>
                        </details>

                        <details class="rounded-2xl border border-gray-100 bg-white">
                            <summary class="cursor-pointer px-4 py-3 font-bold text-gray-800">
                                Convocatorias
                            </summary>

                            <div class="border-t border-gray-100 p-2">
                                <a
                                    href="{{ route('convocatorias.index') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Convocatorias vigentes
                                </a>

                                <a
                                    href="{{ route('postulaciones.seguimiento') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Consultar postulación
                                </a>

                                <a
                                    href="{{ route('postulaciones.resultados') }}"
                                    class="block rounded-xl px-3 py-2.5 text-sm hover:bg-emerald-50">
                                    Resultados
                                </a>
                            </div>
                        </details>

                        <div class="grid gap-2 pt-2 sm:grid-cols-2">
                            <a
                                href="{{ $siewebUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="rounded-2xl border-2 border-amber-400 bg-emerald-950 px-4 py-3 text-center font-extrabold text-white">
                                SieWeb ↗
                            </a>

                            <a
                                href="{{ route('login') }}"
                                class="rounded-2xl border-2 border-amber-400 bg-emerald-950 px-4 py-3 text-center font-extrabold text-white">
                                Iniciar sesión
                            </a>
                        </div>
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
                    <p class="text-sm text-emerald-100">¿Tienes consultas?</p>
                    <p class="mt-1 font-bold">Estamos para ayudarte</p>
                </div>

                <div>
                    <p class="text-sm text-emerald-100">Teléfono</p>
                    <p class="mt-1 font-bold">Próximamente</p>
                </div>

                <div>
                    <p class="text-sm text-emerald-100">Correo institucional</p>
                    <p class="mt-1 font-bold">Próximamente</p>
                </div>
            </div>
        </div>

        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">

            <div>
                <div class="flex items-center gap-4">
                    <img
                        src="{{ asset('images/escudo.png') }}"
                        alt="Escudo institucional"
                        class="h-24 w-24 object-contain">

                    <div>
                        <p class="font-extrabold">IE Crl. José Joaquín Inclán</p>
                        <p class="mt-1 text-sm font-semibold text-amber-300">Dios · Patria · Cultura</p>
                    </div>
                </div>

                <p class="mt-5 text-sm leading-6 text-emerald-100">
                    Portal institucional de información, comunicación y servicios
                    para nuestra comunidad educativa.
                </p>
            </div>

            <div>
                <h3 class="font-bold text-amber-300">Enlaces rápidos</h3>

                <div class="mt-4 flex flex-col gap-2 text-sm text-emerald-100">
                    <a href="{{ route('inicio') }}" class="hover:text-white">Inicio</a>
                    <a href="{{ route('inicio') }}#resena-historica" class="hover:text-white">Institución</a>
                    <a href="{{ route('consultas.crear') }}" class="hover:text-white">Servicios</a>
                    <a href="{{ route('publicaciones.index') }}" class="hover:text-white">Noticias</a>
                    <a
    href="{{ route('convocatorias.index') }}"
    class="hover:text-white"
>
    Convocatorias
</a>

<a
    href="{{ route('postulaciones.seguimiento') }}"
    class="hover:text-white"
>
    Consultar postulación
</a>

<a
    href="{{ route('postulaciones.resultados') }}"
    class="hover:text-white"
>
    Resultados de convocatorias
</a>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-amber-300">Plataforma externa</h3>

                <div class="mt-4">
                    <a
                        href="{{ $siewebUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-800">
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