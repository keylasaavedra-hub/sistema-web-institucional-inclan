<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Contenido institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Publicaciones
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra noticias, anuncios, comunicados y eventos.
                </p>
            </div>

            <a
                href="{{ route('admin.publicaciones.crear') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-900"
            >
                <svg
                    class="h-5 w-5 text-amber-300"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 5v14M5 12h14"/>
                </svg>

                Nueva publicación
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                <form
                    action="{{ route('admin.publicaciones.index') }}"
                    method="GET"
                    class="grid gap-4 xl:grid-cols-[1fr_220px_180px_170px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar publicación
                        </label>

                        <input
                            type="search"
                            id="buscar"
                            name="buscar"
                            value="{{ $buscar }}"
                            placeholder="Título, contenido o enlace..."
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                    </div>

                    <div>
                        <label
                            for="categoria_publicacion_id"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            id="categoria_publicacion_id"
                            name="categoria_publicacion_id"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id }}"
                                    @selected((int) $categoriaId === (int) $categoria->id)
                                >
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="estado"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Estado
                        </label>

                        <select
                            id="estado"
                            name="estado"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todos</option>
                            <option value="borrador" @selected($estado === 'borrador')>
                                Borradores
                            </option>
                            <option value="publicado" @selected($estado === 'publicado')>
                                Publicadas
                            </option>
                            <option value="archivado" @selected($estado === 'archivado')>
                                Archivadas
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="destacada"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Destacada
                        </label>

                        <select
                            id="destacada"
                            name="destacada"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>
                            <option value="si" @selected($destacada === 'si')>
                                Destacadas
                            </option>
                            <option value="no" @selected($destacada === 'no')>
                                No destacadas
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="inline-flex h-12 flex-1 items-center justify-center rounded-xl bg-emerald-950 px-5 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('admin.publicaciones.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </section>

            <div class="mt-8 grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($publicaciones as $publicacion)
                    @php
                        $portadaEnStorage = $publicacion->imagen_portada
                            && \Illuminate\Support\Facades\Storage::disk('public')
                                ->exists($publicacion->imagen_portada);

                        $portadaEnPublic = $publicacion->imagen_portada
                            && file_exists(public_path($publicacion->imagen_portada));

                        if ($portadaEnStorage) {
                            $imagen = asset('storage/' . $publicacion->imagen_portada);
                        } elseif ($portadaEnPublic) {
                            $imagen = asset($publicacion->imagen_portada);
                        } else {
                            $imagen = asset('images/noticia-default.jpg');
                        }

                        $portadaDisponible = $portadaEnStorage || $portadaEnPublic;

                        $publicacionProgramada = $publicacion->estado === 'publicado'
                            && $publicacion->fecha_publicacion
                            && $publicacion->fecha_publicacion->isFuture();

                        $publicacionVencida = $publicacion->fecha_vencimiento
                            && $publicacion->fecha_vencimiento->isPast();
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-[28px] border border-gray-100 bg-white shadow-lg shadow-emerald-950/5 transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="relative h-64 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $imagen }}"
                                alt="{{ $publicacion->titulo }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                onerror="this.src='{{ asset('images/noticia-default.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/10 to-transparent"></div>

                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.1em] text-white">
                                    {{ $publicacion->categoria?->nombre ?? 'Sin categoría' }}
                                </span>

                                @if ($publicacion->destacada)
                                    <span class="rounded-full border border-amber-300 bg-amber-300 px-3 py-1.5 text-[11px] font-extrabold text-emerald-950">
                                        Destacada
                                    </span>
                                @endif
                            </div>

                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-xl font-extrabold leading-tight text-white">
                                    {{ $publicacion->titulo }}
                                </h3>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-wrap gap-2">
                                @if ($publicacion->estado === 'publicado')
                                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-extrabold text-emerald-700">
                                        Publicada
                                    </span>
                                @elseif ($publicacion->estado === 'borrador')
                                    <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-[11px] font-extrabold text-amber-700">
                                        Borrador
                                    </span>
                                @else
                                    <span class="rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-[11px] font-extrabold text-gray-600">
                                        Archivada
                                    </span>
                                @endif

                                @if ($publicacionProgramada)
                                    <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-extrabold text-blue-700">
                                        Programada
                                    </span>
                                @endif

                                @if ($publicacionVencida)
                                    <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-[11px] font-extrabold text-red-700">
                                        Vencida
                                    </span>
                                @endif

                                @if (!$portadaDisponible && $publicacion->imagen_portada)
                                    <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-[11px] font-extrabold text-red-700">
                                        Portada no encontrada
                                    </span>
                                @endif
                            </div>

                            <p class="mt-4 flex-1 text-sm leading-7 text-gray-600">
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($publicacion->contenido),
                                    150
                                ) }}
                            </p>

                            <dl class="mt-6 space-y-3 rounded-2xl bg-gray-50 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <dt class="text-xs font-bold text-gray-500">
                                        Publicación
                                    </dt>

                                    <dd class="text-right text-xs font-extrabold text-emerald-950">
                                        {{ $publicacion->fecha_publicacion
                                            ? $publicacion->fecha_publicacion->format('d/m/Y H:i')
                                            : 'Sin fecha' }}
                                    </dd>
                                </div>

                                <div class="flex items-start justify-between gap-4">
                                    <dt class="text-xs font-bold text-gray-500">
                                        Vencimiento
                                    </dt>

                                    <dd class="text-right text-xs font-extrabold text-emerald-950">
                                        {{ $publicacion->fecha_vencimiento
                                            ? $publicacion->fecha_vencimiento->format('d/m/Y H:i')
                                            : 'Sin vencimiento' }}
                                    </dd>
                                </div>

                                <div class="flex items-start justify-between gap-4">
                                    <dt class="text-xs font-bold text-gray-500">
                                        Responsable
                                    </dt>

                                    <dd class="text-right text-xs font-extrabold text-emerald-950">
                                        {{ $publicacion->usuario
                                            ? trim(
                                                $publicacion->usuario->name
                                                . ' '
                                                . ($publicacion->usuario->apellidos ?? '')
                                            )
                                            : 'Usuario no disponible' }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <a
                                    href="{{ route('admin.publicaciones.editar', $publicacion) }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('admin.publicaciones.eliminar', $publicacion) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta publicación?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-extrabold text-red-700 transition hover:bg-red-100"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                            @if (
                                $publicacion->estado === 'publicado'
                                && !$publicacionProgramada
                                && !$publicacionVencida
                            )
                                <a
                                    href="{{ route('publicaciones.show', $publicacion->slug) }}"
                                    target="_blank"
                                    class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-extrabold text-emerald-700 transition hover:bg-emerald-100"
                                >
                                    Ver en el portal

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M14 3h7v7"/>
                                        <path d="M10 14 21 3"/>
                                        <path d="M21 14v6H4V3h6"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 rounded-[30px] border border-dashed border-amber-300 bg-gradient-to-br from-amber-50 to-emerald-50 px-6 py-16 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg">
                            <svg
                                class="h-8 w-8"
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

                        <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                            No se encontraron publicaciones
                        </h3>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Registra una publicación o cambia los filtros aplicados.
                        </p>

                        <a
                            href="{{ route('admin.publicaciones.crear') }}"
                            class="mt-7 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Registrar publicación
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($publicaciones->hasPages())
                <div class="mt-10">
                    {{ $publicaciones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>