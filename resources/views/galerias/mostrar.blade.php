<x-public-layout :title="$galeria->titulo">

    <section
        x-data="{ imagenAbierta: null }"
        @keydown.escape.window="imagenAbierta = null"
        class="relative overflow-hidden bg-gray-50 py-20"
    >
        <div class="pointer-events-none absolute -left-24 top-0 h-80 w-80 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('galerias.index') }}"
                class="inline-flex items-center gap-2 text-sm font-extrabold text-emerald-800 transition hover:text-emerald-950"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Volver a la galería
            </a>

            <div class="mt-8 overflow-hidden rounded-[36px] border border-amber-300 bg-emerald-950 shadow-2xl">
                <div class="grid lg:grid-cols-[1fr_1.1fr]">
                    <div class="flex items-center p-8 text-white sm:p-10 lg:p-12">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-amber-300">
                                Galería institucional
                            </p>

                            <h1 class="mt-5 font-serif text-4xl font-semibold leading-tight sm:text-5xl">
                                {{ $galeria->titulo }}
                            </h1>

                            <div class="mt-5 flex items-center gap-3">
                                <span class="h-px w-20 bg-amber-400"></span>
                                <span class="h-2 w-2 rounded-full bg-white"></span>
                            </div>

                            @if ($galeria->descripcion)
                                <p class="mt-7 text-base leading-8 text-emerald-50 sm:text-lg">
                                    {{ $galeria->descripcion }}
                                </p>
                            @endif

                            <div class="mt-7 flex flex-wrap gap-3">
                                @if ($galeria->anio)
                                    <span class="rounded-full border border-amber-300 bg-white/10 px-4 py-2 text-sm font-extrabold">
                                        Año {{ $galeria->anio }}
                                    </span>
                                @endif

                                <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-extrabold">
                                    {{ $galeria->archivosActivos->count() }} fotografía(s)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="relative min-h-[380px] overflow-hidden">
                        <img
                            src="{{ $galeria->imagen_portada
                                ? asset('storage/' . $galeria->imagen_portada)
                                : asset('images/portada-institucion.jpg') }}"
                            alt="{{ $galeria->titulo }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/75 via-emerald-950/10 to-transparent"></div>
                    </div>
                </div>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($galeria->archivosActivos as $archivo)
                    @php
                        $urlImagen = asset('storage/' . $archivo->ruta);
                    @endphp

                    <button
                        type="button"
                        @click="imagenAbierta = @js($urlImagen)"
                        class="group overflow-hidden rounded-[26px] border border-amber-200 bg-white text-left shadow-lg shadow-emerald-950/10 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <img
                                src="{{ $urlImagen }}"
                                alt="{{ $archivo->titulo ?: $galeria->titulo }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                loading="lazy"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/45 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></div>

                            <div class="absolute bottom-4 right-4 flex h-11 w-11 items-center justify-center rounded-xl border border-amber-300 bg-emerald-950 text-amber-300 opacity-0 shadow-lg transition group-hover:opacity-100">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m20 20-3.5-3.5"/>
                                    <path d="M8 11h6M11 8v6"/>
                                </svg>
                            </div>
                        </div>

                        @if ($archivo->titulo || $archivo->descripcion)
                            <div class="p-5">
                                @if ($archivo->titulo)
                                    <h2 class="font-extrabold text-emerald-950">
                                        {{ $archivo->titulo }}
                                    </h2>
                                @endif

                                @if ($archivo->descripcion)
                                    <p class="mt-2 text-sm leading-6 text-gray-600">
                                        {{ $archivo->descripcion }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </button>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-[30px] border border-dashed border-amber-300 bg-white px-6 py-14 text-center">
                        <p class="text-xl font-extrabold text-emerald-950">
                            No hay fotografías visibles
                        </p>

                        <p class="mt-3 text-sm text-gray-600">
                            Las imágenes de este álbum aún no están disponibles.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Visor ampliado --}}
        <div
            x-cloak
            x-show="imagenAbierta"
            x-transition.opacity
            @click.self="imagenAbierta = null"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 sm:p-8"
        >
            <button
                type="button"
                @click="imagenAbierta = null"
                class="absolute right-5 top-5 flex h-12 w-12 items-center justify-center rounded-full border border-white/30 bg-white/10 text-3xl text-white backdrop-blur transition hover:bg-white/20"
                aria-label="Cerrar imagen"
            >
                ×
            </button>

            <img
                :src="imagenAbierta"
                alt="Fotografía ampliada"
                class="max-h-full max-w-full rounded-2xl object-contain shadow-2xl"
            >
        </div>
    </section>

</x-public-layout>