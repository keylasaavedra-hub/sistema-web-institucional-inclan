<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Multimedia institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Videos institucionales
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra videos de YouTube visibles en el portal público.
                </p>
            </div>

            <a
                href="{{ route('admin.videos.crear') }}"
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

                Nuevo video
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
                    action="{{ route('admin.videos.index') }}"
                    method="GET"
                    class="grid gap-4 xl:grid-cols-[1fr_220px_220px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar video
                        </label>

                        <div class="relative">
                            <svg
                                class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-emerald-700"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-3.5-3.5"/>
                            </svg>

                            <input
                                type="search"
                                id="buscar"
                                name="buscar"
                                value="{{ $buscar }}"
                                placeholder="Título, descripción o enlace..."
                                class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 pl-12 pr-4 text-sm focus:border-amber-400 focus:ring-amber-400"
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            for="categoria"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            id="categoria"
                            name="categoria"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>

                            @foreach ($categorias as $categoriaDisponible)
                                <option
                                    value="{{ $categoriaDisponible }}"
                                    @selected($categoria === $categoriaDisponible)
                                >
                                    {{ ucfirst($categoriaDisponible) }}
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
                            <option value="publicado" @selected($estado === 'publicado')>
                                Publicados
                            </option>
                            <option value="oculto" @selected($estado === 'oculto')>
                                Ocultos
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
                            href="{{ route('admin.videos.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </section>

            <div class="mt-8 grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($videos as $video)
                    <article class="group flex h-full flex-col overflow-hidden rounded-[28px] border border-amber-200 bg-white shadow-lg shadow-emerald-950/10 transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="relative aspect-video overflow-hidden bg-gray-100">
                            <img
                                src="{{ $video->url_miniatura }}"
                                alt="{{ $video->titulo }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent"></div>

                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                @if ($video->destacado)
                                    <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.12em] text-amber-300">
                                        Destacado
                                    </span>
                                @endif

                                @if ($video->estado)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-50/95 px-3 py-1.5 text-[11px] font-extrabold text-emerald-700">
                                        Publicado
                                    </span>
                                @else
                                    <span class="rounded-full border border-gray-200 bg-white/95 px-3 py-1.5 text-[11px] font-extrabold text-gray-600">
                                        Oculto
                                    </span>
                                @endif
                            </div>

                            <div class="absolute bottom-4 right-4 flex h-12 w-12 items-center justify-center rounded-full border-2 border-amber-300 bg-emerald-950 text-amber-300 shadow-lg">
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                >
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-extrabold uppercase tracking-[0.12em] text-emerald-700">
                                    {{ $video->categoria }}
                                </span>

                                @if ($video->fecha_publicacion)
                                    <span class="text-xs font-semibold text-gray-500">
                                        {{ $video->fecha_publicacion->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="mt-4 text-xl font-extrabold leading-tight text-emerald-950">
                                {{ $video->titulo }}
                            </h3>

                            <p class="mt-3 flex-1 text-sm leading-7 text-gray-600">
                                {{ $video->descripcion
                                    ? \Illuminate\Support\Str::limit($video->descripcion, 150)
                                    : 'Video institucional registrado desde YouTube.' }}
                            </p>

                            <div class="mt-6 rounded-2xl bg-gray-50 px-4 py-3">
                                <p class="text-xs font-bold text-gray-500">
                                    ID de YouTube
                                </p>

                                <p class="mt-1 font-mono text-xs font-extrabold text-emerald-950">
                                    {{ $video->youtube_id }}
                                </p>
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <a
                                    href="{{ route('admin.videos.editar', $video) }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100"
                                >
                                    Editar
                                </a>

                                <a
                                    href="{{ $video->url_youtube }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-50"
                                >
                                    Ver en YouTube ↗
                                </a>
                            </div>

                            <form
                                action="{{ route('admin.videos.eliminar', $video) }}"
                                method="POST"
                                class="mt-3"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este video?')"
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
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m10 9 5 3-5 3z"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                            No se encontraron videos
                        </h3>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Registra el primer video institucional o cambia los filtros aplicados.
                        </p>

                        <a
                            href="{{ route('admin.videos.crear') }}"
                            class="mt-7 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Registrar video
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($videos->hasPages())
                <div class="mt-10">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>