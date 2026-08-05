<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Multimedia institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Promociones escolares
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las promociones de Inicial, Primaria y Secundaria.
                </p>
            </div>

            <a
                href="{{ route('admin.promociones.crear') }}"
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

                Nueva promoción
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
                    action="{{ route('admin.promociones.index') }}"
                    method="GET"
                    class="grid gap-4 xl:grid-cols-[1fr_190px_170px_180px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar promoción
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
                                placeholder="Nombre, lema o descripción..."
                                class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 pl-12 pr-4 text-sm focus:border-amber-400 focus:ring-amber-400"
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            for="nivel_educativo_id"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Nivel
                        </label>

                        <select
                            id="nivel_educativo_id"
                            name="nivel_educativo_id"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todos</option>

                            @foreach ($niveles as $nivel)
                                <option
                                    value="{{ $nivel->id }}"
                                    @selected((int) $nivelId === (int) $nivel->id)
                                >
                                    {{ $nivel->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="anio"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Año
                        </label>

                        <select
                            id="anio"
                            name="anio"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todos</option>

                            @foreach ($anios as $anioDisponible)
                                <option
                                    value="{{ $anioDisponible }}"
                                    @selected((int) $anio === (int) $anioDisponible)
                                >
                                    {{ $anioDisponible }}
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

                            <option
                                value="publicada"
                                @selected($estado === 'publicada')
                            >
                                Publicadas
                            </option>

                            <option
                                value="oculta"
                                @selected($estado === 'oculta')
                            >
                                Ocultas
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
                            href="{{ route('admin.promociones.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </section>

            <div class="mt-8 grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($promociones as $promocion)
                    @php
                        $portada = $promocion->imagen_portada
                            ? asset('storage/' . $promocion->imagen_portada)
                            : asset('images/portada-institucion.jpg');
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-[28px] border border-amber-200 bg-white shadow-lg shadow-emerald-950/10 transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="relative h-72 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $portada }}"
                                alt="{{ $promocion->nombre }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/10 to-transparent"></div>

                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.12em] text-white">
                                    {{ $promocion->nivelEducativo?->nombre ?? 'Sin nivel' }}
                                </span>

                                <span class="rounded-full border border-white/30 bg-white/90 px-3 py-1.5 text-[11px] font-extrabold text-emerald-950">
                                    {{ $promocion->anio }}
                                </span>
                            </div>

                            <div class="absolute bottom-4 left-4 right-4">
                                @if ($promocion->estado)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-50/95 px-3 py-1.5 text-[11px] font-extrabold text-emerald-700">
                                        Publicada
                                    </span>
                                @else
                                    <span class="rounded-full border border-gray-200 bg-white/95 px-3 py-1.5 text-[11px] font-extrabold text-gray-600">
                                        Oculta
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-2xl font-extrabold leading-tight text-emerald-950">
                                {{ $promocion->nombre }}
                            </h3>

                            @if ($promocion->lema)
                                <p class="mt-2 font-serif text-lg font-semibold italic text-amber-700">
                                    “{{ $promocion->lema }}”
                                </p>
                            @endif

                            <p class="mt-4 flex-1 text-sm leading-7 text-gray-600">
                                {{ $promocion->descripcion
                                    ? \Illuminate\Support\Str::limit($promocion->descripcion, 150)
                                    : 'Promoción escolar institucional.' }}
                            </p>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                                    <p class="text-xs font-bold text-emerald-700">
                                        Imágenes totales
                                    </p>

                                    <p class="mt-1 text-xl font-extrabold text-emerald-950">
                                        {{ $promocion->imagenes_count }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-amber-50 px-4 py-3">
                                    <p class="text-xs font-bold text-amber-700">
                                        Imágenes visibles
                                    </p>

                                    <p class="mt-1 text-xl font-extrabold text-emerald-950">
                                        {{ $promocion->imagenes_activas_count }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <a
                                    href="{{ route('admin.promociones.editar', $promocion) }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('admin.promociones.eliminar', $promocion) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta promoción y todas sus imágenes?')"
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
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 20a7 7 0 0 1 14 0"/>
                                <path d="M4 5h4M16 5h4"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                            No se encontraron promociones
                        </h3>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Registra una nueva promoción o cambia los filtros aplicados.
                        </p>

                        <a
                            href="{{ route('admin.promociones.crear') }}"
                            class="mt-7 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Registrar promoción
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($promociones->hasPages())
                <div class="mt-10">
                    {{ $promociones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>