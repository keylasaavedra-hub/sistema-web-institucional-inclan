<x-public-layout title="Galería institucional">

    <section class="relative overflow-hidden bg-gray-50 py-20">
        <div class="pointer-events-none absolute -left-24 top-0 h-80 w-80 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-extrabold uppercase tracking-[0.22em] text-amber-600">
                    Multimedia institucional
                </p>

                <h1 class="mt-4 font-serif text-4xl font-semibold text-emerald-950 sm:text-5xl">
                    Galería institucional
                </h1>

                <div class="mx-auto mt-5 flex w-fit items-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-10 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Conoce nuestras actividades académicas, cívicas, culturales y deportivas.
                </p>
            </div>

            @if ($anios->isNotEmpty())
                <form
                    action="{{ route('galerias.index') }}"
                    method="GET"
                    class="mx-auto mt-10 flex max-w-xl flex-col gap-3 rounded-2xl border border-amber-200 bg-white p-4 shadow-sm sm:flex-row"
                >
                    <select
                        name="anio"
                        class="h-12 flex-1 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
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

                    <button
                        type="submit"
                        class="inline-flex h-12 items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                    >
                        Filtrar
                    </button>

                    @if ($anio)
                        <a
                            href="{{ route('galerias.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    @endif
                </form>
            @endif

            <div class="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($galerias as $galeria)
                    @php
                        $portada = $galeria->imagen_portada
                            ? asset('storage/' . $galeria->imagen_portada)
                            : asset('images/portada-institucion.jpg');
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-[30px] border border-amber-200 bg-white shadow-xl shadow-emerald-950/10 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                        <div class="relative h-72 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $portada }}"
                                alt="{{ $galeria->titulo }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/85 via-emerald-950/10 to-transparent"></div>

                            <div class="absolute left-5 top-5 flex flex-wrap gap-2">
                                @if ($galeria->anio)
                                    <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-4 py-2 text-xs font-extrabold text-white">
                                        {{ $galeria->anio }}
                                    </span>
                                @endif

                                <span class="rounded-full border border-white/30 bg-white/90 px-4 py-2 text-xs font-extrabold text-emerald-950">
                                    {{ $galeria->archivos_activos_count }} foto(s)
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-7">
                            <h2 class="text-2xl font-extrabold leading-tight text-emerald-950">
                                {{ $galeria->titulo }}
                            </h2>

                            <div class="mt-4 flex items-center gap-2">
                                <span class="h-px w-12 bg-amber-400"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-700"></span>
                            </div>

                            <p class="mt-5 flex-1 text-sm leading-7 text-gray-600">
                                {{ $galeria->descripcion
                                    ? \Illuminate\Support\Str::limit($galeria->descripcion, 160)
                                    : 'Álbum fotográfico institucional.' }}
                            </p>

                            <div class="mt-7 border-t border-gray-100 pt-5">
                                <a
                                    href="{{ route('galerias.mostrar', $galeria) }}"
                                    class="group/enlace inline-flex items-center gap-2 text-sm font-extrabold text-emerald-800 transition hover:text-emerald-950"
                                >
                                    Ver fotografías

                                    <svg
                                        class="h-4 w-4 transition group-hover/enlace:translate-x-1"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 rounded-[32px] border border-dashed border-amber-300 bg-white px-6 py-16 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m8 15 3-3 2 2 3-4 3 5"/>
                            </svg>
                        </div>

                        <h2 class="mt-6 text-2xl font-extrabold text-emerald-950">
                            No hay galerías publicadas
                        </h2>

                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                            Próximamente publicaremos nuevas actividades institucionales.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($galerias->hasPages())
                <div class="mt-12">
                    {{ $galerias->links() }}
                </div>
            @endif
        </div>
    </section>

</x-public-layout>