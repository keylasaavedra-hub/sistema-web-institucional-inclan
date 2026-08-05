<x-public-layout title="Resultados de búsqueda">

    <section class="relative overflow-hidden bg-emerald-950 py-20 text-white">

        <div class="pointer-events-none absolute -left-32 top-0 h-96 w-96 rounded-full bg-amber-300/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-emerald-400/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">
                Buscador institucional
            </p>

            <h1 class="mt-3 text-4xl font-extrabold sm:text-5xl">
                Resultados de búsqueda
            </h1>

            <form
                action="{{ route('buscar') }}"
                method="GET"
                class="mt-8 flex max-w-3xl flex-col gap-3 rounded-2xl bg-white p-3 shadow-2xl sm:flex-row"
            >
                <label for="q" class="sr-only">
                    Buscar en el portal
                </label>

                <input
                    id="q"
                    name="q"
                    type="search"
                    value="{{ $termino }}"
                    minlength="2"
                    required
                    placeholder="Buscar noticias, documentos o convocatorias..."
                    class="min-w-0 flex-1 rounded-xl border-0 px-4 py-3 text-gray-900 outline-none ring-0 focus:ring-2 focus:ring-amber-400"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-amber-400 px-7 py-3 font-extrabold text-emerald-950 transition hover:bg-amber-300"
                >
                    Buscar
                </button>
            </form>

        </div>
    </section>

    <main class="bg-gray-50 py-16">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (mb_strlen($termino) < 2)

                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-8 text-center">
                    <h2 class="text-xl font-extrabold text-emerald-950">
                        Escribe al menos dos caracteres
                    </h2>

                    <p class="mt-2 text-gray-600">
                        Puedes buscar palabras como matrícula, reglamento, convocatoria o ciencia.
                    </p>
                </div>

            @elseif ($totalResultados === 0)

                <div class="rounded-3xl border border-dashed border-emerald-200 bg-white p-12 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800">
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m20 20-4-4"/>
                        </svg>
                    </div>

                    <h2 class="mt-5 text-2xl font-extrabold text-emerald-950">
                        No encontramos resultados
                    </h2>

                    <p class="mt-3 text-gray-600">
                        No existen coincidencias para
                        <strong>“{{ $termino }}”</strong>.
                    </p>

                </div>

            @else

                <div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                            Búsqueda realizada
                        </p>

                        <h2 class="mt-1 text-3xl font-extrabold text-emerald-950">
                            {{ $totalResultados }}
                            {{ $totalResultados === 1 ? 'resultado' : 'resultados' }}
                            para “{{ $termino }}”
                        </h2>
                    </div>

                    <a
                        href="{{ route('inicio') }}"
                        class="font-bold text-emerald-700 hover:text-emerald-900"
                    >
                        ← Volver al inicio
                    </a>

                </div>

                <div class="space-y-14">

                    @if ($publicaciones->isNotEmpty())

                        <section>
                            <div class="mb-6 flex items-center gap-3">
                                <div class="h-10 w-2 rounded-full bg-amber-400"></div>

                                <div>
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                                        Contenido informativo
                                    </p>

                                    <h3 class="text-2xl font-extrabold text-emerald-950">
                                        Noticias y publicaciones
                                    </h3>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                @foreach ($publicaciones as $publicacion)

                                    <article class="rounded-3xl border border-gray-100 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                            {{ $publicacion->categoria ?? 'Publicación' }}
                                        </span>

                                        <h4 class="mt-4 text-xl font-extrabold text-emerald-950">
                                            {{ $publicacion->titulo }}
                                        </h4>

                                        <p class="mt-3 text-sm leading-6 text-gray-600">
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($publicacion->contenido),
                                                180
                                            ) }}
                                        </p>

                                        <p class="mt-5 text-xs font-semibold text-gray-500">
                                            {{ $publicacion->fecha_publicacion
                                                ? \Illuminate\Support\Carbon::parse(
                                                    $publicacion->fecha_publicacion
                                                )->format('d/m/Y')
                                                : 'Sin fecha' }}
                                        </p>

                                    </article>

                                @endforeach

                            </div>
                        </section>

                    @endif

                    @if ($documentos->isNotEmpty())

                        <section>
                            <div class="mb-6 flex items-center gap-3">
                                <div class="h-10 w-2 rounded-full bg-emerald-700"></div>

                                <div>
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                                        Centro de descargas
                                    </p>

                                    <h3 class="text-2xl font-extrabold text-emerald-950">
                                        Documentos
                                    </h3>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                @foreach ($documentos as $documento)

                                    @php
                                        $archivoDisponible = $documento->archivo
                                            && file_exists(public_path($documento->archivo));
                                    @endphp

                                    <article class="rounded-3xl border border-gray-100 bg-white p-7 shadow-sm transition hover:shadow-lg">

                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                                            {{ $documento->categoria }}
                                        </span>

                                        <h4 class="mt-4 text-xl font-extrabold text-emerald-950">
                                            {{ $documento->titulo }}
                                        </h4>

                                        <p class="mt-3 text-sm leading-6 text-gray-600">
                                            {{ \Illuminate\Support\Str::limit(
                                                $documento->descripcion ?? '',
                                                160
                                            ) }}
                                        </p>

                                        @if ($archivoDisponible)
                                            <a
                                                href="{{ asset($documento->archivo) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-5 inline-flex items-center gap-2 font-bold text-emerald-700 hover:text-emerald-900"
                                            >
                                                Abrir documento →
                                            </a>
                                        @endif

                                    </article>

                                @endforeach

                            </div>
                        </section>

                    @endif

                    @if ($convocatorias->isNotEmpty())

                        <section>
                            <div class="mb-6 flex items-center gap-3">
                                <div class="h-10 w-2 rounded-full bg-amber-400"></div>

                                <div>
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                                        Oportunidades
                                    </p>

                                    <h3 class="text-2xl font-extrabold text-emerald-950">
                                        Convocatorias
                                    </h3>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                @foreach ($convocatorias as $convocatoria)

                                    <article class="rounded-3xl border border-gray-100 bg-white p-7 shadow-sm transition hover:shadow-lg">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold capitalize text-emerald-800">
                                                {{ $convocatoria->tipo }}
                                            </span>

                                            @if ($convocatoria->codigo)
                                                <span class="text-xs font-bold text-gray-500">
                                                    {{ $convocatoria->codigo }}
                                                </span>
                                            @endif

                                        </div>

                                        <h4 class="mt-4 text-xl font-extrabold text-emerald-950">
                                            {{ $convocatoria->titulo }}
                                        </h4>

                                        <p class="mt-3 text-sm leading-6 text-gray-600">
                                            {{ \Illuminate\Support\Str::limit(
                                                $convocatoria->descripcion ?? '',
                                                160
                                            ) }}
                                        </p>

                                        @if ($convocatoria->area)
                                            <p class="mt-4 text-sm font-bold text-amber-700">
                                                Área: {{ $convocatoria->area }}
                                            </p>
                                        @endif

                                    </article>

                                @endforeach

                            </div>
                        </section>

                    @endif

                    @if ($informacionInstitucional->isNotEmpty())

                        <section>
                            <div class="mb-6 flex items-center gap-3">
                                <div class="h-10 w-2 rounded-full bg-emerald-700"></div>

                                <div>
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                                        Nuestra institución
                                    </p>

                                    <h3 class="text-2xl font-extrabold text-emerald-950">
                                        Información institucional
                                    </h3>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                @foreach ($informacionInstitucional as $informacion)

                                    <article class="rounded-3xl border border-gray-100 bg-white p-7 shadow-sm transition hover:shadow-lg">

                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold capitalize text-amber-800">
                                            {{ str_replace('_', ' ', $informacion->tipo) }}
                                        </span>

                                        <h4 class="mt-4 text-xl font-extrabold text-emerald-950">
                                            {{ $informacion->titulo }}
                                        </h4>

                                        <p class="mt-3 text-sm leading-6 text-gray-600">
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($informacion->contenido),
                                                180
                                            ) }}
                                        </p>

                                    </article>

                                @endforeach

                            </div>
                        </section>

                    @endif

                </div>

            @endif

        </div>
    </main>

</x-public-layout>