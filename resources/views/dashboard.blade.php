<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Panel administrativo
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Portal Institucional IE José Joaquín Inclán
                </p>
            </div>

            <div class="text-left sm:text-right">
                <p class="font-semibold text-gray-800">
                    {{ $usuario->name }} {{ $usuario->apellidos }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $rol ?? 'Usuario' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <section class="mb-8 rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800">
                    Bienvenido, {{ $usuario->name }}
                </h3>

                <p class="mt-2 text-gray-600">
                    Desde este panel podrás administrar el contenido y los servicios
                    del portal institucional.
                </p>
            </section>

            <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Usuarios
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['usuarios'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Usuarios registrados
                    </p>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Publicaciones
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['publicaciones'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Noticias y comunicados
                    </p>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Consultas
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['consultas'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Consultas recibidas
                    </p>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Solicitudes
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['solicitudes'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Trámites registrados
                    </p>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Convocatorias
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['convocatorias'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Convocatorias creadas
                    </p>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Postulaciones
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $estadisticas['postulaciones'] }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Postulaciones recibidas
                    </p>
                </article>

            </section>

            <section class="mt-8 grid gap-6 lg:grid-cols-2">

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Gestión de contenido
                    </h3>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Publicaciones
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Documentos
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Galerías
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Información institucional
                        </a>
                    </div>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Atención institucional
                    </h3>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Consultas
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Solicitudes
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Convocatorias
                        </a>

                        <a href="#"
                           class="rounded-xl border border-gray-200 p-4 font-medium text-gray-700 transition hover:bg-gray-50">
                            Postulaciones
                        </a>
                    </div>
                </article>

            </section>

        </div>
    </div>
</x-app-layout>