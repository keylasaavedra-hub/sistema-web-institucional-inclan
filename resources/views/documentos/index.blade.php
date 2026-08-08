<x-public-layout title="Documentos y descargas">

    <section class="relative overflow-hidden bg-slate-50 py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-16
                   h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-10
                   h-96 w-96 rounded-full bg-amber-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('inicio') }}"
                class="inline-flex items-center gap-2 text-sm
                       font-extrabold text-emerald-800
                       transition hover:text-emerald-950">
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="M19 12H5" />
                    <path d="m11 18-6-6 6-6" />
                </svg>

                Volver al inicio
            </a>

            <div class="mx-auto mt-10 max-w-3xl text-center">

                <div
                    class="inline-flex items-center gap-2 rounded-full
                           border border-amber-200 bg-amber-50
                           px-4 py-2 text-xs font-extrabold uppercase
                           tracking-[0.18em] text-amber-700">
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 3h9l4 4v14H6z" />
                        <path d="M14 3v5h5" />
                        <path d="M9 13h6M9 17h4" />
                    </svg>

                    Biblioteca institucional
                </div>

                <h1
                    class="mt-6 text-4xl font-extrabold
                           tracking-tight text-emerald-950
                           sm:text-5xl">
                    Documentos y descargas
                </h1>

                <div class="mt-5 flex justify-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-600">
                    Consulta y descarga reglamentos, planes, formatos,
                    directivas y otros documentos institucionales.
                </p>
            </div>

            {{-- FILTROS --}}
            <div
                class="mx-auto mt-12 max-w-5xl rounded-[28px]
                       border border-amber-200 bg-white p-6
                       shadow-[0_20px_60px_rgba(6,78,59,0.08)]
                       sm:p-8">
                <form
                    method="GET"
                    action="{{ route('documentos.index') }}"
                    class="grid gap-5 lg:grid-cols-[1fr_280px_auto]">
                    <div>
                        <label
                            for="buscar"
                            class="text-sm font-extrabold text-emerald-950">
                            Buscar documento
                        </label>

                        <div class="relative mt-2">

                            <span
                                class="pointer-events-none absolute inset-y-0
                                       left-0 flex items-center pl-4
                                       text-gray-400">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <circle cx="11" cy="11" r="7" />
                                    <path d="m20 20-4-4" />
                                </svg>
                            </span>

                            <input
                                id="buscar"
                                name="buscar"
                                type="text"
                                value="{{ request('buscar') }}"
                                placeholder="Título, descripción o archivo..."
                                class="w-full rounded-xl border-gray-300
                                       bg-white py-3 pl-12 pr-4
                                       text-gray-800 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                        </div>
                    </div>

                    <div>
                        <label
                            for="categoria"
                            class="text-sm font-extrabold text-emerald-950">
                            Categoría
                        </label>

                        <select
                            id="categoria"
                            name="categoria"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   bg-white px-4 py-3 text-gray-800 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">
                            <option value="">Todas las categorías</option>

                            @foreach ($categorias as $categoria)
                            <option
                                value="{{ $categoria->id }}"
                                @selected(
                                (string) request('categoria')===(string) $categoria->id
                                )
                                >
                                {{ $categoria->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">

                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-xl
                                   bg-emerald-950 px-5 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900">
                            Buscar
                        </button>

                        @if (request()->filled('buscar') || request()->filled('categoria'))

                        <a
                            href="{{ route('documentos.index') }}"
                            class="inline-flex items-center justify-center
                                       rounded-xl border border-gray-300
                                       bg-white px-4 py-3 font-extrabold
                                       text-gray-600 transition
                                       hover:bg-gray-50">
                            Limpiar
                        </a>

                        @endif
                    </div>
                </form>
            </div>

            {{-- RESULTADOS --}}
            <div class="mt-12">

                <div
                    class="mb-6 flex flex-col gap-3 sm:flex-row
                           sm:items-center sm:justify-between">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600">
                            Resultados
                        </p>

                        <h2
                            class="mt-1 text-2xl font-extrabold
                                   text-emerald-950">
                            Documentos disponibles
                        </h2>
                    </div>

                    <p class="text-sm font-semibold text-gray-500">
                        {{ $documentos->total() }}
                        {{ $documentos->total() === 1 ? 'documento' : 'documentos' }}
                    </p>
                </div>

                @if ($documentos->count())

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

                    @foreach ($documentos as $documento)

                    @php
                    $esPdf = str_contains(
                    strtolower($documento->tipo_archivo ?? ''),
                    'pdf'
                    );

                    $tamano = $documento->tamano_bytes
                    ? number_format(
                    $documento->tamano_bytes / 1048576,
                    2
                    ) . ' MB'
                    : 'Tamaño no disponible';

                    $extension = strtoupper(
                    pathinfo(
                    $documento->nombre_original,
                    PATHINFO_EXTENSION
                    )
                    );
                    @endphp

                    <article
                        class="group flex h-full flex-col
                                       overflow-hidden rounded-[26px]
                                       border border-gray-200 bg-white
                                       shadow-[0_14px_40px_rgba(15,23,42,0.06)]
                                       transition duration-300
                                       hover:-translate-y-1
                                       hover:border-amber-300
                                       hover:shadow-[0_24px_60px_rgba(6,78,59,0.12)]">
                        <div
                            class="flex items-start justify-between
                                           gap-4 border-b border-gray-100
                                           bg-gradient-to-br
                                           from-emerald-950 to-emerald-800
                                           p-6 text-white">
                            <div
                                class="flex h-14 w-14 items-center
                                               justify-center rounded-2xl
                                               border border-amber-300/60
                                               bg-white/10 text-amber-300">
                                @if ($esPdf)

                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M6 2h9l5 5v15H6z" />
                                    <path d="M14 2v6h6" />
                                    <path d="M8 15h8M8 18h5" />
                                </svg>

                                @else

                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M6 3h9l4 4v14H6z" />
                                    <path d="M14 3v5h5" />
                                </svg>

                                @endif
                            </div>

                            <span
                                class="rounded-full border
                                               border-amber-300/60
                                               bg-emerald-900 px-3 py-1
                                               text-xs font-extrabold
                                               text-amber-300">
                                {{ $extension ?: 'ARCHIVO' }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-6">

                            <div class="flex flex-wrap gap-2">

                                <span
                                    class="rounded-full
                                                   bg-emerald-50 px-3 py-1
                                                   text-xs font-extrabold
                                                   text-emerald-800">
                                    {{ $documento->categoria?->nombre ?? 'Sin categoría' }}
                                </span>

                                @if ($documento->area)

                                <span
                                    class="rounded-full
                                                       bg-amber-50 px-3 py-1
                                                       text-xs font-extrabold
                                                       text-amber-700">
                                    {{ $documento->area->nombre }}
                                </span>

                                @endif
                            </div>

                            <h3
                                class="mt-5 text-xl font-extrabold
                                               leading-7 text-emerald-950
                                               transition
                                               group-hover:text-emerald-800">
                                {{ $documento->titulo }}
                            </h3>

                            <p
                                class="mt-3 line-clamp-3 text-sm
                                               leading-7 text-gray-600">
                                {{ $documento->descripcion
                                            ?: 'Documento institucional disponible para consulta y descarga.' }}
                            </p>

                            <div
                                class="mt-6 grid grid-cols-2 gap-3
                                               text-sm">
                                <div
                                    class="rounded-xl border
                                                   border-gray-200
                                                   bg-gray-50 p-3">
                                    <p
                                        class="text-xs font-extrabold
                                                       uppercase
                                                       tracking-[0.12em]
                                                       text-gray-500">
                                        Publicación
                                    </p>

                                    <p
                                        class="mt-1 font-bold
                                                       text-emerald-950">
                                        {{ $documento->fecha_publicacion
                                                    ? $documento->fecha_publicacion->format('d/m/Y')
                                                    : 'Sin fecha' }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-xl border
                                                   border-gray-200
                                                   bg-gray-50 p-3">
                                    <p
                                        class="text-xs font-extrabold
                                                       uppercase
                                                       tracking-[0.12em]
                                                       text-gray-500">
                                        Tamaño
                                    </p>

                                    <p
                                        class="mt-1 font-bold
                                                       text-emerald-950">
                                        {{ $tamano }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-auto pt-6">

                                <a
                                    href="{{ route(
                                        'documentos.descargar',
                                        $documento->id
                                    ) }}"
                                    class="inline-flex w-full
                                                   items-center justify-center
                                                   gap-2 rounded-xl
                                                   bg-emerald-950 px-5 py-3
                                                   font-extrabold text-white
                                                   transition
                                                   hover:bg-emerald-900">
                                    <svg
                                        class="h-5 w-5
                                                       text-amber-300"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M12 3v12" />
                                        <path d="m7 10 5 5 5-5" />
                                        <path d="M5 21h14" />
                                    </svg>

                                    Descargar documento
                                </a>
                            </div>
                        </div>
                    </article>

                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $documentos->links() }}
                </div>

                @else

                <div
                    class="rounded-[28px] border border-dashed
                               border-gray-300 bg-white px-6 py-14
                               text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center
                                   justify-center rounded-2xl
                                   bg-emerald-50 text-emerald-800">
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M6 3h9l4 4v14H6z" />
                            <path d="M14 3v5h5" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>

                    <h3
                        class="mt-5 text-xl font-extrabold
                                   text-emerald-950">
                        No se encontraron documentos
                    </h3>

                    <p
                        class="mx-auto mt-3 max-w-lg text-sm
                                   leading-7 text-gray-600">
                        Prueba con otro término de búsqueda o selecciona
                        una categoría diferente.
                    </p>

                    <a
                        href="{{ route('documentos.index') }}"
                        class="mt-6 inline-flex items-center
                                   justify-center rounded-xl
                                   bg-emerald-950 px-5 py-3
                                   font-extrabold text-white
                                   transition hover:bg-emerald-900">
                        Ver todos los documentos
                    </a>
                </div>

                @endif
            </div>
        </div>
    </section>

</x-public-layout>