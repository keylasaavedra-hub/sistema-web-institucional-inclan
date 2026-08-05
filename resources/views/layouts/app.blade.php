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
    <div class="min-h-screen bg-slate-50">

        {{-- FONDO OSCURO PARA CELULAR --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-40 bg-slate-950/60 lg:hidden"
            @click="sidebarOpen = false"></div>

        {{-- BARRA LATERAL --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72
                   -translate-x-full flex-col bg-emerald-950
                   text-white shadow-2xl transition-transform
                   duration-300 lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }">
            {{-- LOGOTIPO --}}
            <div
                class="flex h-24 items-center justify-between
                       border-b border-white/10 px-6">
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 items-center justify-center
                               rounded-2xl bg-white text-emerald-950">
                        <x-application-logo class="h-8 w-8 fill-current" />
                    </div>

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-300">
                            IE J.J. Inclán
                        </p>

                        <p class="mt-1 font-extrabold text-white">
                            Portal institucional
                        </p>
                    </div>
                </a>

                <button
                    type="button"
                    class="rounded-xl p-2 text-emerald-100
                           hover:bg-white/10 lg:hidden"
                    @click="sidebarOpen = false">
                    <span class="sr-only">Cerrar menú</span>

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

            {{-- MENÚ --}}
            <nav class="flex-1 overflow-y-auto px-4 py-6">

                <p
                    class="px-3 text-[11px] font-extrabold uppercase
                           tracking-[0.18em] text-emerald-300">
                    Principal
                </p>

                <div class="mt-3 space-y-2">

                    {{-- DASHBOARD --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs('dashboard')
                                    ? 'bg-white text-emerald-950 shadow-lg'
                                    : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>

                        <span>Dashboard</span>
                    </a>

                    {{-- CONSULTAS --}}
                    <a
                        href="{{ route('admin.consultas.index') }}"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs('admin.consultas.*')
                                    ? 'bg-white text-emerald-950 shadow-lg'
                                    : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <path d="M4 4h16v12H6l-2 3z" />
                            <path d="M8 8h8M8 12h5" />
                        </svg>

                        <span>Consultas</span>
                    </a>

                    {{-- SOLICITUDES / TRÁMITES --}}
                    @if (Route::has('admin.tramites.index'))
                    <a
                        href="{{ route('admin.tramites.index') }}"
                        class="flex items-center gap-3 rounded-2xl
                                   px-4 py-3 text-sm font-bold transition
                                   {{ request()->routeIs('admin.tramites.*')
                                        ? 'bg-white text-emerald-950 shadow-lg'
                                        : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
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

                        <span>Mesa de partes</span>
                    </a>

                    {{-- DOCUMENTOS --}}
                    <a
                        href="{{ route('admin.documentos.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.documentos.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
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

                        <span>Documentos</span>
                    </a>

                    <a
                        href="{{ route('admin.eventos.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.eventos.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                        </svg>

                        <span>Calendario</span>
                    </a>

                    {{-- PUBLICACIONES --}}
                    <a
                        href="{{ route('admin.publicaciones.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.publicaciones.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
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

                        <span>Publicaciones</span>
                    </a>

                    <a
                        href="{{ route('admin.categorias-publicacion.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.categorias-publicacion.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <path d="M4 6h16" />
                            <path d="M4 12h16" />
                            <path d="M4 18h10" />
                            <circle cx="18" cy="18" r="2" />
                        </svg>

                        <span>Categorías de publicaciones</span>
                    </a>

                    <a
                        href="{{ route('admin.convocatorias.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.convocatorias.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
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

                        <span>Convocatorias</span>
                    </a>

                    {{-- POSTULACIONES --}}
                    <a
                        href="{{ route('admin.postulaciones.index') }}"
                        class="flex items-center gap-3 rounded-2xl
           px-4 py-3 text-sm font-bold transition
           {{ request()->routeIs('admin.postulaciones.*')
                ? 'bg-white text-emerald-950 shadow-lg'
                : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <path d="M8 4h8" />
                            <path d="M9 2h6a1 1 0 0 1 1 1v3H8V3a1 1 0 0 1 1-1Z" />
                            <path d="M6 5H5a2 2 0 0 0-2 2v14h18V7a2 2 0 0 0-2-2h-1" />
                            <path d="M7 11h10M7 15h7" />
                        </svg>

                        <span>Postulaciones</span>
                    </a>

                    @else
                    <div
                        class="flex cursor-not-allowed items-center
                                   gap-3 rounded-2xl px-4 py-3
                                   text-sm font-bold text-emerald-100/50"
                        title="Módulo pendiente">
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

                        <span>Mesa de partes</span>

                        <span
                            class="ml-auto rounded-full bg-white/10
                                       px-2 py-1 text-[10px] uppercase">
                            Próximo
                        </span>
                    </div>
                    @endif
                </div>

                {{-- MULTIMEDIA --}}
                <p
                    class="mt-8 px-3 text-[11px] font-extrabold uppercase
                           tracking-[0.18em] text-emerald-300">
                    Multimedia
                </p>

                <div class="mt-3 space-y-2">

                    {{-- GALERÍAS --}}
                    <a
                        href="{{ route('admin.galerias.index') }}"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs('admin.galerias.*')
                                    ? 'bg-white text-emerald-950 shadow-lg'
                                    : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <circle cx="8" cy="10" r="1.5" />
                            <path d="m4 16 5-4 4 3 3-3 4 4" />
                        </svg>

                        <span>Galerías</span>
                    </a>

                    {{-- VIDEOS --}}
                    <a
                        href="{{ route('admin.videos.index') }}"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs('admin.videos.*')
                                    ? 'bg-white text-emerald-950 shadow-lg'
                                    : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="m10 9 5 3-5 3z" />
                        </svg>

                        <span>Videos</span>
                    </a>

                    {{-- PROMOCIONES --}}
                    <a
                        href="{{ route('admin.promociones.index') }}"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs('admin.promociones.*')
                                    ? 'bg-white text-emerald-950 shadow-lg'
                                    : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <circle cx="12" cy="7" r="3" />
                            <path d="M5 20a7 7 0 0 1 14 0" />
                            <path d="M4 5h4M16 5h4" />
                        </svg>

                        <span>Promociones</span>
                    </a>
                </div>

                <p
                    class="mt-8 px-3 text-[11px] font-extrabold uppercase
                           tracking-[0.18em] text-emerald-300">
                    Portal público
                </p>

                <div class="mt-3 space-y-2">

                    <a
                        href="{{ route('documentos.index') }}"
                        target="_blank"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold
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

                        <span>Documentos</span>

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

                    <a
                        href="{{ route('calendario.index') }}"
                        target="_blank"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold
                               text-emerald-50 transition
                               hover:bg-white/10 hover:text-white">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                        </svg>

                        <span>Calendario</span>

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

                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        class="flex items-center gap-3 rounded-2xl
                               px-4 py-3 text-sm font-bold
                               text-emerald-50 transition
                               hover:bg-white/10 hover:text-white">
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M3 12h18" />
                            <path d="M12 3a15 15 0 0 1 0 18" />
                            <path d="M12 3a15 15 0 0 0 0 18" />
                        </svg>

                        <span>Ver portal público</span>

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
            </nav>

            {{-- USUARIO --}}
            <div class="border-t border-white/10 p-4">
                <div class="rounded-2xl bg-white/10 p-4">

                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center
                                   justify-center rounded-xl bg-amber-400
                                   font-extrabold text-emerald-950">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-extrabold text-white">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="truncate text-xs text-emerald-200">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a
                            href="{{ route('profile.edit') }}"
                            class="rounded-xl border border-white/10
                                   px-3 py-2 text-center text-xs
                                   font-bold text-white transition
                                   hover:bg-white/10">
                            Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-white
                                       px-3 py-2 text-xs font-extrabold
                                       text-emerald-950 transition
                                       hover:bg-amber-50">
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="min-h-screen lg:pl-72">

            {{-- BARRA SUPERIOR --}}
            <header
                class="sticky top-0 z-30 border-b border-gray-200
                       bg-white/95 backdrop-blur">
                <div
                    class="flex h-20 items-center justify-between
                           px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">

                        <button
                            type="button"
                            class="inline-flex h-11 w-11 items-center
                                   justify-center rounded-xl
                                   border border-gray-200 bg-white
                                   text-emerald-950 shadow-sm
                                   lg:hidden"
                            @click="sidebarOpen = true">
                            <span class="sr-only">Abrir menú</span>

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 6h16M4 12h16M4 18h16" />
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
                            <p class="text-sm font-extrabold text-emerald-950">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs font-semibold text-gray-500">
                                Administrador
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center
                                   rounded-xl bg-emerald-950
                                   font-extrabold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- CABECERA DE CADA PÁGINA --}}
            @isset($header)
            <div class="border-b border-gray-200 bg-white">
                <div class="px-4 py-7 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
            @endisset

            {{-- CONTENIDO --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>