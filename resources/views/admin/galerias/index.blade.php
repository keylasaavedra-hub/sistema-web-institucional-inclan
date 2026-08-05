<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión de contenido
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Galería institucional
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra los álbumes y fotografías del portal institucional.
                </p>
            </div>

            <a
                href="{{ route('admin.galerias.crear') }}"
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

                Nueva galería
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div
                    class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if (session('error'))
                <div
                    class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700"
                >
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filtros --}}
            <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                <form
                    action="{{ route('admin.galerias.index') }}"
                    method="GET"
                    class="grid gap-4 lg:grid-cols-[1fr_220px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar galería
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
                                placeholder="Título, descripción o año..."
                                class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 pl-12 pr-4 text-sm focus:border-amber-400 focus:ring-amber-400"
                            >
                        </div>
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

                            <option
                                value="activo"
                                @selected($estado === 'activo')
                            >
                                Activas
                            </option>

                            <option
                                value="inactivo"
                                @selected($estado === 'inactivo')
                            >
                                Inactivas
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
                            href="{{ route('admin.galerias.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                            title="Limpiar filtros"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </section>

            {{-- Resumen --}}
            <section class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-amber-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Total mostrado
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-emerald-950">
                        {{ $galerias->total() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-emerald-700">
                        Página actual
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-emerald-950">
                        {{ $galerias->currentPage() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-gray-500">
                        Registros por página
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-emerald-950">
                        {{ $galerias->perPage() }}
                    </p>
                </div>
            </section>

            {{-- Galerías --}}
            <section class="mt-8">
                @forelse ($galerias as $galeria)
                    @php
                        $rutaPortada = $galeria->imagen_portada
                            ? asset('storage/' . $galeria->imagen_portada)
                            : asset('images/portada-institucion.jpg');
                    @endphp

                    <article
                        class="mb-6 overflow-hidden rounded-[28px] border border-gray-100 bg-white shadow-sm transition hover:shadow-lg"
                    >
                        <div class="grid lg:grid-cols-[280px_1fr]">

                            {{-- Portada --}}
                            <div class="relative min-h-[240px] overflow-hidden bg-gray-100">
                                <img
                                    src="{{ $rutaPortada }}"
                                    alt="Portada de {{ $galeria->titulo }}"
                                    class="absolute inset-0 h-full w-full object-cover"
                                    onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent"></div>

                                <div class="absolute bottom-4 left-4 right-4 flex flex-wrap gap-2">
                                    <span
                                        class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.13em] text-white"
                                    >
                                        {{ $galeria->tipo }}
                                    </span>

                                    @if ($galeria->anio)
                                        <span
                                            class="rounded-full border border-white/30 bg-white/90 px-3 py-1.5 text-[11px] font-extrabold text-emerald-950"
                                        >
                                            {{ $galeria->anio }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Información --}}
                            <div class="flex flex-col p-6 lg:p-8">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h3 class="text-2xl font-extrabold text-emerald-950">
                                                {{ $galeria->titulo }}
                                            </h3>

                                            @if ($galeria->estado)
                                                <span
                                                    class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700"
                                                >
                                                    Publicada
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-xs font-extrabold text-gray-600"
                                                >
                                                    Oculta
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-3 max-w-3xl text-sm leading-7 text-gray-600">
                                            {{ $galeria->descripcion ?: 'Esta galería no tiene una descripción registrada.' }}
                                        </p>
                                    </div>

                                    <div class="shrink-0 text-left sm:text-right">
                                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-400">
                                            Orden
                                        </p>

                                        <p class="mt-1 text-lg font-extrabold text-emerald-950">
                                            {{ $galeria->orden }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Métricas --}}
                                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                                        <p class="text-xs font-bold text-emerald-700">
                                            Fotografías totales
                                        </p>

                                        <p class="mt-1 text-xl font-extrabold text-emerald-950">
                                            {{ $galeria->archivos_count }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-amber-50 px-4 py-3">
                                        <p class="text-xs font-bold text-amber-700">
                                            Fotografías visibles
                                        </p>

                                        <p class="mt-1 text-xl font-extrabold text-emerald-950">
                                            {{ $galeria->archivos_activos_count }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                        <p class="text-xs font-bold text-gray-500">
                                            Creada
                                        </p>

                                        <p class="mt-1 text-sm font-extrabold text-emerald-950">
                                            {{ $galeria->created_at?->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Acciones --}}
                                <div class="mt-auto flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">

                                    <a
                                        href="{{ route('admin.galerias.editar', $galeria) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-300 bg-white px-5 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-50"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/>
                                        </svg>

                                        Editar y administrar fotos
                                    </a>

                                    <form
                                        action="{{ route('admin.galerias.eliminar', $galeria) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta galería y todas sus fotografías? Esta acción no se puede deshacer.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-extrabold text-red-700 transition hover:bg-red-100"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4h8v2"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v5M14 11v5"/>
                                            </svg>

                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="rounded-[30px] border border-dashed border-amber-300 bg-gradient-to-br from-amber-50 to-emerald-50 px-6 py-16 text-center"
                    >
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg"
                        >
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m8 15 3-3 2 2 3-4 3 5"/>
                                <circle cx="8" cy="9" r="1"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                            No se encontraron galerías
                        </h3>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Crea el primer álbum institucional o cambia los filtros aplicados.
                        </p>

                        <a
                            href="{{ route('admin.galerias.crear') }}"
                            class="mt-7 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Crear galería
                        </a>
                    </div>
                @endforelse
            </section>

            {{-- Paginación --}}
            @if ($galerias->hasPages())
                <div class="mt-8">
                    {{ $galerias->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>