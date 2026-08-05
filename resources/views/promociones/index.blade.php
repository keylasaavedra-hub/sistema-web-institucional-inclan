<x-public-layout>
    <section class="relative overflow-hidden bg-emerald-950">
        <div class="absolute inset-0">
            <div class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-amber-400/10 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <div class="max-w-3xl">
                <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-amber-300">
                    Comunidad educativa
                </p>

                <h1 class="mt-4 text-4xl font-black leading-tight text-white sm:text-5xl">
                    Promociones escolares
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-8 text-emerald-100 sm:text-lg">
                    Conoce a las promociones que forman parte de la historia de nuestra institución educativa.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                <form
                    action="{{ route('promociones.index') }}"
                    method="GET"
                    class="grid gap-4 md:grid-cols-[1fr_1fr_auto]"
                >
                    <div>
                        <label
                            for="nivel"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Nivel educativo
                        </label>

                        <select
                            id="nivel"
                            name="nivel"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todos los niveles</option>

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
                            <option value="">Todos los años</option>

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

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="inline-flex h-12 flex-1 items-center justify-center rounded-xl bg-emerald-950 px-6 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('promociones.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($promociones as $promocion)
                    @php
                        $portada = $promocion->imagen_portada
                            ? asset('storage/' . $promocion->imagen_portada)
                            : asset('images/portada-institucion.jpg');
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-[30px] border border-amber-200 bg-white shadow-lg shadow-emerald-950/10 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <a
                            href="{{ route('promociones.mostrar', $promocion) }}"
                            class="relative block h-72 overflow-hidden bg-gray-100"
                        >
                            <img
                                src="{{ $portada }}"
                                alt="{{ $promocion->nombre }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/95 via-emerald-950/20 to-transparent"></div>

                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.12em] text-white">
                                    {{ $promocion->nivelEducativo?->nombre ?? 'Sin nivel' }}
                                </span>

                                <span class="rounded-full border border-white/30 bg-white/95 px-3 py-1.5 text-[11px] font-extrabold text-emerald-950">
                                    {{ $promocion->anio }}
                                </span>
                            </div>

                            <div class="absolute bottom-4 left-4 right-4">
                                <h2 class="text-2xl font-black leading-tight text-white">
                                    {{ $promocion->nombre }}
                                </h2>
                            </div>
                        </a>

                        <div class="flex flex-1 flex-col p-6">
                            @if ($promocion->lema)
                                <p class="font-serif text-lg font-semibold italic text-amber-700">
                                    “{{ $promocion->lema }}”
                                </p>
                            @endif

                            <p class="mt-4 flex-1 text-sm leading-7 text-gray-600">
                                {{ $promocion->descripcion
                                    ? \Illuminate\Support\Str::limit($promocion->descripcion, 150)
                                    : 'Conoce la historia y las fotografías de esta promoción escolar.' }}
                            </p>

                            <div class="mt-6 flex items-center justify-between gap-4 border-t border-gray-100 pt-5">
                                <span class="inline-flex items-center gap-2 text-xs font-extrabold text-emerald-700">
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m4 16 5-4 4 3 3-3 4 4"/>
                                    </svg>

                                    {{ $promocion->imagenesActivas->count() }} fotografía(s)
                                </span>

                                <a
                                    href="{{ route('promociones.mostrar', $promocion) }}"
                                    class="inline-flex items-center gap-2 text-sm font-extrabold text-emerald-950 transition hover:text-amber-700"
                                >
                                    Ver promoción

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="m9 18 6-6-6-6"/>
                                    </svg>
                                </a>
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

                        <h2 class="mt-6 text-2xl font-black text-emerald-950">
                            No se encontraron promociones
                        </h2>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Actualmente no existen promociones publicadas con los filtros seleccionados.
                        </p>

                        <a
                            href="{{ route('promociones.index') }}"
                            class="mt-7 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Ver todas las promociones
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($promociones->hasPages())
                <div class="mt-12">
                    {{ $promociones->links() }}
                </div>
            @endif
        </div>
    </section>
</x-public-layout>