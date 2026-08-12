<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Institucional') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased"
    x-data="{ sidebarOpen: false }">

    @php

        $usuarioActual = auth()->user();

        $esAdministrador =
            $usuarioActual?->esAdministrador() ?? false;


        $permisosUsuario = $esAdministrador
            ? collect()
            : (
                $usuarioActual?->rol?->permisos
                    ?->where('estado', true)
                    ->pluck('codigo')
                ?? collect()
            );


        $puede = fn (string $codigo): bool =>
            $esAdministrador
            || $permisosUsuario->contains($codigo);


        $rutaInicioPanel = match (true) {

            $puede('dashboard.ver') =>
                route('dashboard'),

            $puede('consultas.ver') =>
                route('admin.consultas.index'),

            $puede('solicitudes.ver') =>
                route('admin.tramites.index'),

            $puede('documentos.gestionar') =>
                route('admin.documentos.index'),

            $puede('publicaciones.gestionar') =>
                route('admin.publicaciones.index'),

            $puede('convocatorias.gestionar') =>
                route('admin.convocatorias.index'),

            $puede('postulaciones.revisar') =>
                route('admin.postulaciones.index'),

            $puede('galerias.gestionar') =>
                route('admin.galerias.index'),

            $puede('promociones.gestionar') =>
                route('admin.promociones.index'),

            $puede('usuarios.ver') =>
                route('admin.usuarios.index'),

            $puede('seguridad.administrar') =>
                route('admin.roles.index'),

            $puede('auditoria.ver') =>
                route('admin.auditorias.index'),

            default =>
                route('inicio'),
        };


        $contenidoInstitucionalActivo =
            request()->routeIs(
                'admin.contenido-institucional.*'
            );

    @endphp


    <div class="min-h-screen bg-slate-50">


        {{-- ========================================================= --}}
        {{-- FONDO OSCURO PARA CELULAR --}}
        {{-- ========================================================= --}}

        <div
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-40 bg-slate-950/60 lg:hidden"
            @click="sidebarOpen = false">
        </div>


        {{-- ========================================================= --}}
        {{-- BARRA LATERAL --}}
        {{-- ========================================================= --}}

        <aside
            class="fixed inset-y-0 left-0 z-50
                   flex w-72 -translate-x-full flex-col
                   bg-emerald-950 text-white shadow-2xl
                   transition-transform duration-300
                   lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }">


            {{-- ===================================================== --}}
            {{-- LOGOTIPO --}}
            {{-- ===================================================== --}}

            <div
                class="flex h-24 items-center justify-between
                       border-b border-white/10 px-6">

                <a
                    href="{{ $rutaInicioPanel }}"
                    class="flex items-center gap-3">

                    <div
                        class="flex h-12 w-12 items-center
                               justify-center rounded-2xl
                               bg-white text-emerald-950">

                        <x-application-logo
                            class="h-8 w-8 fill-current"
                        />

                    </div>


                    <div>

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em]
                                   text-amber-300">
                            IE J.J. Inclán
                        </p>

                        <p class="mt-1 font-extrabold text-white">
                            Portal institucional
                        </p>

                    </div>

                </a>


                <button
                    type="button"
                    class="rounded-xl p-2
                           text-emerald-100
                           hover:bg-white/10
                           lg:hidden"
                    @click="sidebarOpen = false">

                    <span class="sr-only">
                        Cerrar menú
                    </span>

                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path d="M18 6 6 18M6 6l12 12" />

                    </svg>

                </button>

            </div>


            {{-- ===================================================== --}}
            {{-- MENÚ --}}
            {{-- ===================================================== --}}

            <nav class="flex-1 overflow-y-auto px-4 py-6">


                {{-- ================================================= --}}
                {{-- PRINCIPAL --}}
                {{-- ================================================= --}}

                <p
                    class="px-3 text-[11px]
                           font-extrabold uppercase
                           tracking-[0.18em]
                           text-emerald-300">
                    Principal
                </p>


                <div class="mt-3 space-y-2">


                    {{-- DASHBOARD --}}
                    @if ($puede('dashboard.ver'))

                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs('dashboard')
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <rect
                                    x="3"
                                    y="3"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />

                                <rect
                                    x="14"
                                    y="3"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />

                                <rect
                                    x="3"
                                    y="14"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />

                                <rect
                                    x="14"
                                    y="14"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />

                            </svg>

                            <span>
                                Dashboard
                            </span>

                        </a>

                    @endif


                    {{-- CONSULTAS --}}
                    @if ($puede('consultas.ver'))

                        <a
                            href="{{ route('admin.consultas.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.consultas.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M4 4h16v12H6l-2 3z" />

                                <path d="M8 8h8M8 12h5" />

                            </svg>

                            <span>
                                Consultas
                            </span>

                        </a>

                    @endif


                    {{-- SOLICITUDES / TRÁMITES --}}
                    @if (
                        Route::has('admin.tramites.index')
                        && $puede('solicitudes.ver')
                    )

                        <a
                            href="{{ route('admin.tramites.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.tramites.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M6 3h9l3 3v15H6z" />

                                <path d="M14 3v4h4" />

                                <path d="M9 12h6M9 16h4" />

                            </svg>

                            <span>
                                Mesa de partes
                            </span>

                        </a>

                    @endif


                    {{-- DOCUMENTOS --}}
                    @if ($puede('documentos.gestionar'))

                        <a
                            href="{{ route('admin.documentos.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.documentos.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M6 3h9l3 3v15H6z" />

                                <path d="M14 3v4h4" />

                                <path d="M9 12h6M9 16h4" />

                            </svg>

                            <span>
                                Documentos
                            </span>

                        </a>

                    @endif


                    {{-- CALENDARIO --}}
                    @if ($puede('publicaciones.gestionar'))

                        <a
                            href="{{ route('admin.eventos.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.eventos.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="16"
                                    rx="2"
                                />

                                <path d="M16 3v4M8 3v4M3 10h18" />

                            </svg>

                            <span>
                                Calendario
                            </span>

                        </a>

                    @endif


                    {{-- PUBLICACIONES --}}
                    @if ($puede('publicaciones.gestionar'))

                        <a
                            href="{{ route('admin.publicaciones.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.publicaciones.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M6 3h9l3 3v15H6z" />

                                <path d="M14 3v4h4" />

                                <path d="M9 11h6M9 15h6" />

                            </svg>

                            <span>
                                Publicaciones
                            </span>

                        </a>

                    @endif


                    {{-- CATEGORÍAS DE PUBLICACIONES --}}
                    @if ($puede('publicaciones.gestionar'))

                        <a
                            href="{{ route(
                                'admin.categorias-publicacion.index'
                            ) }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.categorias-publicacion.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M4 6h16" />

                                <path d="M4 12h16" />

                                <path d="M4 18h10" />

                                <circle
                                    cx="18"
                                    cy="18"
                                    r="2"
                                />

                            </svg>

                            <span>
                                Categorías de publicaciones
                            </span>

                        </a>

                    @endif


                    {{-- CONVOCATORIAS --}}
                    @if ($puede('convocatorias.gestionar'))

                        <a
                            href="{{ route(
                                'admin.convocatorias.index'
                            ) }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.convocatorias.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M4 5h16v14H4z" />

                                <path d="M8 9h8M8 13h5" />

                                <path d="M17 3v4M7 3v4" />

                            </svg>

                            <span>
                                Convocatorias
                            </span>

                        </a>

                    @endif


                    {{-- POSTULACIONES --}}
                    @if ($puede('postulaciones.revisar'))

                        <a
                            href="{{ route(
                                'admin.postulaciones.index'
                            ) }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.postulaciones.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M8 4h8" />

                                <path
                                    d="M9 2h6a1 1 0 0 1 1 1v3H8V3a1 1 0 0 1 1-1Z"
                                />

                                <path
                                    d="M6 5H5a2 2 0 0 0-2 2v14h18V7a2 2 0 0 0-2-2h-1"
                                />

                                <path d="M7 11h10M7 15h7" />

                            </svg>

                            <span>
                                Postulaciones
                            </span>

                        </a>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- CONTENIDO INSTITUCIONAL --}}
                {{-- ================================================= --}}

                @if ($puede('publicaciones.gestionar'))

                    <p
                        class="mt-8 px-3
                               text-[11px] font-extrabold uppercase
                               tracking-[0.18em]
                               text-emerald-300">
                        Contenido
                    </p>


                    <div
                        class="mt-3"
                        x-data="{
                            abierto:
                                {{ $contenidoInstitucionalActivo
                                    ? 'true'
                                    : 'false'
                                }}
                        }">


                        {{-- BOTÓN PRINCIPAL --}}
                        <button
                            type="button"
                            @click="abierto = ! abierto"
                            class="flex w-full items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-left text-sm font-bold
                                   transition
                                   {{ $contenidoInstitucionalActivo
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <path d="M3 21h18" />

                                <path d="M5 21V9l7-4 7 4v12" />

                                <path d="M9 13h2v3H9zM13 13h2v3h-2z" />

                            </svg>


                            <span class="flex-1">
                                Contenido institucional
                            </span>


                            <svg
                                class="h-4 w-4 shrink-0
                                       transition-transform duration-200"
                                :class="{
                                    'rotate-180': abierto
                                }"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m6 9 6 6 6-6"
                                />

                            </svg>

                        </button>


                        {{-- SUBMENÚ --}}
                        <div
                            x-show="abierto"
                            x-cloak
                            x-transition
                            class="mt-2 space-y-1 pl-4">


                            {{-- PÁGINA DE INICIO --}}
                            <a
                                href="{{ route(
                                    'admin.contenido-institucional.inicio'
                                ) }}"
                                class="flex items-center gap-3
                                       rounded-xl px-4 py-2.5
                                       text-sm font-semibold transition
                                       {{ request()->routeIs(
                                            'admin.contenido-institucional.inicio'
                                       )
                                            ? 'bg-emerald-900 text-amber-300'
                                            : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                       }}">

                                <span
                                    class="h-2 w-2 shrink-0 rounded-full
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.inicio'
                                           )
                                                ? 'bg-amber-300'
                                                : 'bg-emerald-400'
                                           }}">
                                </span>

                                <span>
                                    Página de inicio
                                </span>

                            </a>


                            {{-- RESEÑA HISTÓRICA --}}
                            <a
                                href="{{ route(
                                    'admin.contenido-institucional.institucion.resena'
                                ) }}"
                                class="flex items-center gap-3
                                       rounded-xl px-4 py-2.5
                                       text-sm font-semibold transition
                                       {{ request()->routeIs(
                                            'admin.contenido-institucional.institucion.resena'
                                       )
                                            ? 'bg-emerald-900 text-amber-300'
                                            : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                       }}">

                                <span
                                    class="h-2 w-2 shrink-0 rounded-full
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.resena'
                                           )
                                                ? 'bg-amber-300'
                                                : 'bg-emerald-400'
                                           }}">
                                </span>

                                <span>
                                    Reseña histórica
                                </span>

                            </a>


                            {{-- MISIÓN, VISIÓN Y VALORES --}}
                            <a
                                href="{{ route(
                                    'admin.contenido-institucional.institucion.mision-vision-valores'
                                ) }}"
                                class="flex items-center gap-3
                                       rounded-xl px-4 py-2.5
                                       text-sm font-semibold transition
                                       {{ request()->routeIs(
                                            'admin.contenido-institucional.institucion.mision-vision-valores'
                                       )
                                            ? 'bg-emerald-900 text-amber-300'
                                            : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                       }}">

                                <span
                                    class="h-2 w-2 shrink-0 rounded-full
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.mision-vision-valores'
                                           )
                                                ? 'bg-amber-300'
                                                : 'bg-emerald-400'
                                           }}">
                                </span>

                                <span>
                                    Misión, visión y valores
                                </span>

                            </a>


                            {{-- INFRAESTRUCTURA --}}
                            <a
                                href="{{ route(
                                    'admin.contenido-institucional.institucion.infraestructura'
                                ) }}"
                                class="flex items-center gap-3
                                       rounded-xl px-4 py-2.5
                                       text-sm font-semibold transition
                                       {{ request()->routeIs(
                                            'admin.contenido-institucional.institucion.infraestructura*'
                                       )
                                            ? 'bg-emerald-900 text-amber-300'
                                            : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                       }}">

                                <span
                                    class="h-2 w-2 shrink-0 rounded-full
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.infraestructura*'
                                           )
                                                ? 'bg-amber-300'
                                                : 'bg-emerald-400'
                                           }}">
                                </span>

                                <span>
                                    Infraestructura
                                </span>

                            </a>


                            {{-- CONVENIOS --}}
                            @if (
                                Route::has(
                                    'admin.contenido-institucional.institucion.convenios'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.contenido-institucional.institucion.convenios'
                                    ) }}"
                                    class="flex items-center gap-3
                                           rounded-xl px-4 py-2.5
                                           text-sm font-semibold transition
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.convenios*'
                                           )
                                                ? 'bg-emerald-900 text-amber-300'
                                                : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                           }}">

                                    <span
                                        class="h-2 w-2 shrink-0 rounded-full
                                               {{ request()->routeIs(
                                                    'admin.contenido-institucional.institucion.convenios*'
                                               )
                                                    ? 'bg-amber-300'
                                                    : 'bg-emerald-400'
                                               }}">
                                    </span>

                                    <span>
                                        Convenios
                                    </span>

                                </a>

                            @endif


                            {{-- COMUNIDAD EDUCATIVA --}}
                            @if (
                                Route::has(
                                    'admin.contenido-institucional.institucion.comunidad-educativa'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.contenido-institucional.institucion.comunidad-educativa'
                                    ) }}"
                                    class="flex items-center gap-3
                                           rounded-xl px-4 py-2.5
                                           text-sm font-semibold transition
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.comunidad-educativa*'
                                           )
                                                ? 'bg-emerald-900 text-amber-300'
                                                : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                           }}">

                                    <span
                                        class="h-2 w-2 shrink-0 rounded-full
                                               {{ request()->routeIs(
                                                    'admin.contenido-institucional.institucion.comunidad-educativa*'
                                               )
                                                    ? 'bg-amber-300'
                                                    : 'bg-emerald-400'
                                               }}">
                                    </span>

                                    <span>
                                        Comunidad educativa
                                    </span>

                                </a>

                            @endif


                            {{-- NUESTRA FORMA DE ENSEÑAR --}}
                            @if (
                                Route::has(
                                    'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
                                    ) }}"
                                    class="flex items-center gap-3
                                           rounded-xl px-4 py-2.5
                                           text-sm font-semibold transition
                                           {{ request()->routeIs(
                                                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar*'
                                           )
                                                ? 'bg-emerald-900 text-amber-300'
                                                : 'text-emerald-100 hover:bg-white/10 hover:text-white'
                                           }}">

                                    <span
                                        class="h-2 w-2 shrink-0 rounded-full
                                               {{ request()->routeIs(
                                                    'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar*'
                                               )
                                                    ? 'bg-amber-300'
                                                    : 'bg-emerald-400'
                                               }}">
                                    </span>

                                    <span>
                                        Nuestra forma de enseñar
                                    </span>

                                </a>

                            @endif

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- MULTIMEDIA --}}
                {{-- ================================================= --}}

                <p
                    class="mt-8 px-3
                           text-[11px] font-extrabold uppercase
                           tracking-[0.18em]
                           text-emerald-300">
                    Multimedia
                </p>


                <div class="mt-3 space-y-2">


                    {{-- GALERÍAS --}}
                    @if ($puede('galerias.gestionar'))

                        <a
                            href="{{ route('admin.galerias.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.galerias.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <circle
                                    cx="8"
                                    cy="10"
                                    r="1.5"
                                />

                                <path d="m4 16 5-4 4 3 3-3 4 4" />

                            </svg>

                            <span>
                                Galerías
                            </span>

                        </a>

                    @endif


                    {{-- VIDEOS --}}
                    @if ($puede('galerias.gestionar'))

                        <a
                            href="{{ route('admin.videos.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.videos.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <path d="m10 9 5 3-5 3z" />

                            </svg>

                            <span>
                                Videos
                            </span>

                        </a>

                    @endif


                    {{-- PROMOCIONES --}}
                    @if ($puede('promociones.gestionar'))

                        <a
                            href="{{ route('admin.promociones.index') }}"
                            class="flex items-center gap-3
                                   rounded-2xl px-4 py-3
                                   text-sm font-bold transition
                                   {{ request()->routeIs(
                                        'admin.promociones.*'
                                   )
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                   }}">

                            <svg
                                class="h-5 w-5 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9">

                                <circle
                                    cx="12"
                                    cy="7"
                                    r="3"
                                />

                                <path d="M5 20a7 7 0 0 1 14 0" />

                                <path d="M4 5h4M16 5h4" />

                            </svg>

                            <span>
                                Promociones
                            </span>

                        </a>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- PORTAL PÚBLICO --}}
                {{-- ================================================= --}}

                <p
                    class="mt-8 px-3
                           text-[11px] font-extrabold uppercase
                           tracking-[0.18em]
                           text-emerald-300">
                    Portal público
                </p>


                <div class="mt-3 space-y-2">


                    {{-- DOCUMENTOS PÚBLICOS --}}
                    <a
                        href="{{ route('documentos.index') }}"
                        target="_blank"
                        class="flex items-center gap-3
                               rounded-2xl px-4 py-3
                               text-sm font-bold
                               text-emerald-50 transition
                               hover:bg-white/10 hover:text-white">

                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">

                            <path d="M6 3h9l3 3v15H6z" />

                            <path d="M14 3v4h4" />

                            <path d="M9 12h6M9 16h4" />

                        </svg>

                        <span>
                            Documentos
                        </span>


                        <svg
                            class="ml-auto h-4 w-4 opacity-60"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M14 3h7v7" />

                            <path d="M10 14 21 3" />

                            <path d="M21 14v6H4V3h6" />

                        </svg>

                    </a>


                    {{-- CALENDARIO PÚBLICO --}}
                    <a
                        href="{{ route('calendario.index') }}"
                        target="_blank"
                        class="flex items-center gap-3
                               rounded-2xl px-4 py-3
                               text-sm font-bold
                               text-emerald-50 transition
                               hover:bg-white/10 hover:text-white">

                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">

                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="16"
                                rx="2"
                            />

                            <path d="M16 3v4M8 3v4M3 10h18" />

                        </svg>

                        <span>
                            Calendario
                        </span>


                        <svg
                            class="ml-auto h-4 w-4 opacity-60"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M14 3h7v7" />

                            <path d="M10 14 21 3" />

                            <path d="M21 14v6H4V3h6" />

                        </svg>

                    </a>


                    {{-- VER PORTAL PÚBLICO --}}
                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        class="flex items-center gap-3
                               rounded-2xl px-4 py-3
                               text-sm font-bold
                               text-emerald-50 transition
                               hover:bg-white/10 hover:text-white">

                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">

                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />

                            <path d="M3 12h18" />

                            <path d="M12 3a15 15 0 0 1 0 18" />

                            <path d="M12 3a15 15 0 0 0 0 18" />

                        </svg>

                        <span>
                            Ver portal público
                        </span>


                        <svg
                            class="ml-auto h-4 w-4 opacity-60"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M14 3h7v7" />

                            <path d="M10 14 21 3" />

                            <path d="M21 14v6H4V3h6" />

                        </svg>

                    </a>

                </div>


                {{-- ================================================= --}}
                {{-- SEGURIDAD --}}
                {{-- ================================================= --}}

                @if (
                    $puede('usuarios.ver')
                    || $puede('seguridad.administrar')
                    || $puede('auditoria.ver')
                )

                    <p
                        class="mt-8 px-3
                               text-[11px] font-extrabold uppercase
                               tracking-[0.18em]
                               text-emerald-300">
                        Seguridad
                    </p>


                    <div class="mt-3 space-y-2">


                        {{-- USUARIOS --}}
                        @if ($puede('usuarios.ver'))

                            <a
                                href="{{ route('admin.usuarios.index') }}"
                                class="flex items-center gap-3
                                       rounded-2xl px-4 py-3
                                       text-sm font-bold transition
                                       {{ request()->routeIs(
                                            'admin.usuarios.*'
                                       )
                                            ? 'bg-white text-emerald-950 shadow-lg'
                                            : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                       }}">

                                <svg
                                    class="h-5 w-5 shrink-0"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9">

                                    <path
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                    />

                                    <circle
                                        cx="9"
                                        cy="7"
                                        r="4"
                                    />

                                    <path
                                        d="M22 21v-2a4 4 0 00-3-3.87"
                                    />

                                    <path
                                        d="M16 3.13a4 4 0 010 7.75"
                                    />

                                </svg>

                                <span>
                                    Usuarios
                                </span>

                            </a>

                        @endif


                        {{-- ROLES Y PERMISOS --}}
                        @if ($puede('seguridad.administrar'))

                            <a
                                href="{{ route('admin.roles.index') }}"
                                class="flex items-center gap-3
                                       rounded-2xl px-4 py-3
                                       text-sm font-bold transition
                                       {{ request()->routeIs(
                                            'admin.roles.*'
                                       )
                                            ? 'bg-white text-emerald-950 shadow-lg'
                                            : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                       }}">

                                <svg
                                    class="h-5 w-5 shrink-0"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9">

                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="4"
                                    />

                                    <path
                                        d="M4 21v-2a6 6 0 016-6h4a6 6 0 016 6v2"
                                    />

                                    <path d="M18 8h4M20 6v4" />

                                </svg>

                                <span>
                                    Roles y permisos
                                </span>

                            </a>

                        @endif


                        {{-- AUDITORÍA --}}
                        @if ($puede('auditoria.ver'))

                            <a
                                href="{{ route(
                                    'admin.auditorias.index'
                                ) }}"
                                class="flex items-center gap-3
                                       rounded-2xl px-4 py-3
                                       text-sm font-bold transition
                                       {{ request()->routeIs(
                                            'admin.auditorias.*'
                                       )
                                            ? 'bg-white text-emerald-950 shadow-lg'
                                            : 'text-emerald-50 hover:bg-white/10 hover:text-white'
                                       }}">

                                <svg
                                    class="h-5 w-5 shrink-0"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9">

                                    <path
                                        d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"
                                    />

                                    <path d="M9 12h6" />

                                    <path d="M12 9v6" />

                                </svg>

                                <span>
                                    Auditoría
                                </span>

                            </a>

                        @endif

                    </div>

                @endif

            </nav>


            {{-- ===================================================== --}}
            {{-- USUARIO --}}
            {{-- ===================================================== --}}

            <div class="border-t border-white/10 p-4">

                <div class="rounded-2xl bg-white/10 p-4">


                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-xl bg-amber-400
                                   font-extrabold text-emerald-950">

                            {{ strtoupper(
                                substr(
                                    auth()->user()->name,
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div class="min-w-0 flex-1">

                            <p
                                class="truncate text-sm
                                       font-extrabold text-white">

                                {{ auth()->user()->name }}

                            </p>


                            <p
                                class="truncate text-xs
                                       text-emerald-200">

                                {{ auth()->user()->email }}

                            </p>

                        </div>

                    </div>


                    <div class="mt-4 grid grid-cols-2 gap-2">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="rounded-xl
                                   border border-white/10
                                   px-3 py-2 text-center
                                   text-xs font-bold
                                   text-white transition
                                   hover:bg-white/10">

                            Perfil

                        </a>


                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf


                            <button
                                type="submit"
                                class="w-full rounded-xl
                                       bg-white px-3 py-2
                                       text-xs font-extrabold
                                       text-emerald-950
                                       transition
                                       hover:bg-amber-50">

                                Salir

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </aside>


        {{-- ========================================================= --}}
        {{-- CONTENIDO PRINCIPAL --}}
        {{-- ========================================================= --}}

        <div class="min-h-screen lg:pl-72">


            {{-- ===================================================== --}}
            {{-- BARRA SUPERIOR --}}
            {{-- ===================================================== --}}

            <header
                class="sticky top-0 z-30
                       border-b border-gray-200
                       bg-white/95 backdrop-blur">

                <div
                    class="flex h-20 items-center
                           justify-between
                           px-4 sm:px-6 lg:px-8">


                    <div class="flex items-center gap-4">


                        <button
                            type="button"
                            class="inline-flex h-11 w-11
                                   items-center justify-center
                                   rounded-xl
                                   border border-gray-200
                                   bg-white text-emerald-950
                                   shadow-sm lg:hidden"
                            @click="sidebarOpen = true">

                            <span class="sr-only">
                                Abrir menú
                            </span>


                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    d="M4 6h16M4 12h16M4 18h16"
                                />

                            </svg>

                        </button>


                        <div>

                            <p class="text-xs font-bold text-gray-400">
                                Panel administrativo
                            </p>

                            <p class="font-extrabold text-emerald-950">
                                IE José Joaquín Inclán
                            </p>

                        </div>

                    </div>


                    <div class="flex items-center gap-3">


                        <div class="hidden text-right sm:block">

                            <p
                                class="text-sm font-extrabold
                                       text-emerald-950">

                                {{ auth()->user()->name }}

                            </p>


                            <p
                                class="text-xs font-semibold
                                       text-gray-500">

                                {{
                                    auth()->user()->rol?->nombre
                                    ?? 'Usuario'
                                }}

                            </p>

                        </div>


                        <div
                            class="flex h-11 w-11
                                   items-center justify-center
                                   rounded-xl bg-emerald-950
                                   font-extrabold text-white">

                            {{ strtoupper(
                                substr(
                                    auth()->user()->name,
                                    0,
                                    1
                                )
                            ) }}

                        </div>

                    </div>

                </div>

            </header>


            {{-- ===================================================== --}}
            {{-- CABECERA DE CADA PÁGINA --}}
            {{-- ===================================================== --}}

            @isset($header)

                <div class="border-b border-gray-200 bg-white">

                    <div class="px-4 py-7 sm:px-6 lg:px-8">

                        {{ $header }}

                    </div>

                </div>

            @endisset


            {{-- ===================================================== --}}
            {{-- CONTENIDO --}}
            {{-- ===================================================== --}}

            <main>

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>