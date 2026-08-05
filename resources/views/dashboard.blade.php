<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Portal institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950 sm:text-3xl">
                    Panel administrativo
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    IE José Joaquín Inclán
                </p>
            </div>

            <div
                class="flex w-fit items-center gap-3 rounded-2xl
                       border border-emerald-100 bg-emerald-50
                       px-4 py-3"
            >
                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-emerald-950 text-lg
                           font-extrabold text-white"
                >
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div>
                    <p class="font-extrabold text-emerald-950">
                        {{ auth()->user()->name }}
                        {{ auth()->user()->apellidos ?? '' }}
                    </p>

                    <p class="text-sm font-semibold text-emerald-700">
                        {{ $rol ?? 'Administrador' }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- BIENVENIDA --}}
            <section
                class="relative overflow-hidden rounded-[30px]
                       bg-emerald-950 p-7 text-white
                       shadow-[0_22px_55px_rgba(6,78,59,0.20)]
                       sm:p-9"
            >
                <div
                    class="absolute -right-16 -top-20 h-60 w-60
                           rounded-full bg-amber-400/10"
                ></div>

                <div
                    class="absolute -bottom-20 right-28 h-44 w-44
                           rounded-full bg-emerald-400/10"
                ></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="max-w-2xl">

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-300"
                        >
                            Administración institucional
                        </p>

                        <h3 class="mt-3 text-3xl font-extrabold sm:text-4xl">
                            Bienvenido,
                            {{ auth()->user()->name }}
                        </h3>

                        <p class="mt-3 max-w-xl leading-7 text-emerald-50">
                            Gestiona las consultas, solicitudes, publicaciones
                            y servicios digitales del portal institucional.
                        </p>
                    </div>

                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        class="inline-flex w-fit items-center justify-center gap-2
                               rounded-xl bg-white px-5 py-3
                               font-extrabold text-emerald-950
                               transition hover:bg-amber-50"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M14 3h7v7"/>
                            <path d="M10 14 21 3"/>
                            <path d="M21 14v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6"/>
                        </svg>

                        Ver portal público
                    </a>
                </div>
            </section>

            {{-- RESUMEN --}}
            <section class="mt-8">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Resumen general
                        </p>

                        <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Indicadores del sistema
                        </h3>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

                    {{-- USUARIOS --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Usuarios
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['usuarios'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-emerald-50 text-emerald-800"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Usuarios registrados
                        </p>
                    </article>

                    {{-- PUBLICACIONES --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Publicaciones
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['publicaciones'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-blue-50 text-blue-700"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 5h16v14H4z"/>
                                    <path d="M8 9h8M8 13h5"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Noticias y comunicados
                        </p>
                    </article>

                    {{-- CONSULTAS --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Consultas
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['consultas'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-amber-50 text-amber-700"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 4h16v12H6l-2 3z"/>
                                    <path d="M8 8h8M8 12h5"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Consultas recibidas
                        </p>
                    </article>

                    {{-- SOLICITUDES --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Solicitudes
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['solicitudes'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-violet-50 text-violet-700"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M6 3h9l3 3v15H6z"/>
                                    <path d="M14 3v4h4"/>
                                    <path d="M9 12h6M9 16h4"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Trámites registrados
                        </p>
                    </article>

                    {{-- CONVOCATORIAS --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Convocatorias
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['convocatorias'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-rose-50 text-rose-700"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M3 11v2"/>
                                    <path d="M6 8v8"/>
                                    <path d="M9 6v12"/>
                                    <path d="M12 4v16"/>
                                    <path d="M15 7v10"/>
                                    <path d="M18 9v6"/>
                                    <path d="M21 11v2"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Convocatorias creadas
                        </p>
                    </article>

                    {{-- POSTULACIONES --}}
                    <article
                        class="group rounded-[24px] border border-gray-200
                               bg-white p-6 shadow-sm transition
                               hover:-translate-y-1 hover:border-emerald-200
                               hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-500">
                                    Postulaciones
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                    {{ $estadisticas['postulaciones'] }}
                                </p>
                            </div>

                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-cyan-50 text-cyan-700"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 21a8 8 0 0 1 16 0"/>
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">
                            Postulaciones recibidas
                        </p>
                    </article>
                </div>
            </section>

            {{-- ACCESOS RÁPIDOS --}}
            <section class="mt-10">

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Accesos rápidos
                    </p>

                    <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                        Gestión administrativa
                    </h3>
                </div>

                <div class="mt-5 grid gap-6 lg:grid-cols-2">

                    {{-- CONTENIDO --}}
                    <article
                        class="rounded-[26px] border border-gray-200
                               bg-white p-6 shadow-sm sm:p-7"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-emerald-950 text-white"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 5h16v14H4z"/>
                                    <path d="M8 9h8M8 13h5"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="text-lg font-extrabold text-emerald-950">
                                    Gestión de contenido
                                </h4>

                                <p class="text-sm text-gray-500">
                                    Información visible en el portal público
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">

                            <a
                                href="#"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Publicaciones
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="{{ route('documentos.index') }}"
                                target="_blank"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Documentos
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="{{ route('calendario.index') }}"
                                target="_blank"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Calendario
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="{{ url('/') }}"
                                target="_blank"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Portal institucional
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </article>

                    {{-- ATENCIÓN --}}
                    <article
                        class="rounded-[26px] border border-gray-200
                               bg-white p-6 shadow-sm sm:p-7"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center
                                       rounded-2xl bg-amber-500 text-white"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 4h16v12H6l-2 3z"/>
                                    <path d="M8 8h8M8 12h5"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="text-lg font-extrabold text-emerald-950">
                                    Atención institucional
                                </h4>

                                <p class="text-sm text-gray-500">
                                    Solicitudes y atención al ciudadano
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">

                            <a
                                href="{{ route('admin.consultas.index') }}"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-emerald-200
                                       bg-emerald-50 p-4
                                       font-extrabold text-emerald-900
                                       transition hover:bg-emerald-100"
                            >
                                Consultas
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="#"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Solicitudes
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="{{ route('admin.convocatorias.index') }}"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Convocatorias
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>

                            <a
                                href="#"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       p-4 font-bold text-gray-700 transition
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-900"
                            >
                                Postulaciones
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </div>

</x-app-layout>