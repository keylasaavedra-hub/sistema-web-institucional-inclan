<x-public-layout>
    @php
        $portada = $promocion->imagen_portada
            ? asset('storage/' . $promocion->imagen_portada)
            : asset('images/portada-institucion.jpg');
    @endphp

    <section class="relative overflow-hidden bg-emerald-950">
        <div class="absolute inset-0">
            <img
                src="{{ $portada }}"
                alt="{{ $promocion->nombre }}"
                class="h-full w-full object-cover opacity-25"
                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
            >

            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950 via-emerald-950/95 to-emerald-950/65"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <a
                href="{{ route('promociones.index') }}"
                class="inline-flex items-center gap-2 text-sm font-extrabold text-amber-300 transition hover:text-amber-200"
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

                Volver a promociones
            </a>

            <div class="mt-10 max-w-4xl">
                <div class="flex flex-wrap gap-3">
                    <span class="rounded-full border border-amber-300 bg-amber-300/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.14em] text-amber-300">
                        {{ $promocion->nivelEducativo?->nombre ?? 'Sin nivel' }}
                    </span>

                    <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-extrabold text-white">
                        Promoción {{ $promocion->anio }}
                    </span>
                </div>

                <h1 class="mt-6 text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $promocion->nombre }}
                </h1>

                @if ($promocion->lema)
                    <p class="mt-5 font-serif text-2xl font-semibold italic text-amber-300 sm:text-3xl">
                        “{{ $promocion->lema }}”
                    </p>
                @endif

                @if ($promocion->descripcion)
                    <p class="mt-7 max-w-3xl text-base leading-8 text-emerald-100 sm:text-lg">
                        {{ $promocion->descripcion }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-8 lg:grid-cols-[330px_1fr]">

                <aside>
                    <div class="sticky top-28 space-y-6">

                        <section class="overflow-hidden rounded-[28px] border border-amber-200 bg-white shadow-lg shadow-emerald-950/10">
                            <img
                                src="{{ $portada }}"
                                alt="Portada de {{ $promocion->nombre }}"
                                class="aspect-[4/3] w-full object-cover"
                                onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                            >

                            <div class="p-6">
                                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                    Información
                                </p>

                                <dl class="mt-5 space-y-4">
                                    <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
                                        <dt class="text-sm font-bold text-gray-500">
                                            Nivel
                                        </dt>

                                        <dd class="text-right text-sm font-extrabold text-emerald-950">
                                            {{ $promocion->nivelEducativo?->nombre ?? 'No especificado' }}
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
                                        <dt class="text-sm font-bold text-gray-500">
                                            Año
                                        </dt>

                                        <dd class="text-right text-sm font-extrabold text-emerald-950">
                                            {{ $promocion->anio }}
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-sm font-bold text-gray-500">
                                            Fotografías
                                        </dt>

                                        <dd class="text-right text-sm font-extrabold text-emerald-950">
                                            {{ $promocion->imagenesActivas->count() }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </section>

                        <a
                            href="{{ route('promociones.index') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                        >
                            Ver todas las promociones
                        </a>
                    </div>
                </aside>

                <div>
                    <div class="mb-8">
                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                            Recuerdos institucionales
                        </p>

                        <h2 class="mt-2 text-3xl font-black text-emerald-950">
                            Galería de fotografías
                        </h2>

                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            Fotografías representativas de esta promoción escolar.
                        </p>
                    </div>

                    <div
                        x-data="{
                            abierta: false,
                            imagenActual: '',
                            tituloActual: '',

                            mostrar(imagen, titulo) {
                                this.imagenActual = imagen;
                                this.tituloActual = titulo;
                                this.abierta = true;
                                document.body.style.overflow = 'hidden';
                            },

                            cerrar() {
                                this.abierta = false;
                                document.body.style.overflow = '';
                            }
                        }"
                        @keydown.escape.window="cerrar()"
                    >
                        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse ($promocion->imagenesActivas as $imagen)
                                @php
                                    $urlImagen = asset('storage/' . $imagen->ruta);
                                    $tituloImagen = $imagen->titulo
                                        ?: $imagen->nombre_original
                                        ?: $promocion->nombre;
                                @endphp

                                <button
                                    type="button"
                                    class="group overflow-hidden rounded-[24px] border border-gray-200 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:border-amber-300 hover:shadow-xl"
                                    @click="mostrar(
                                        @js($urlImagen),
                                        @js($tituloImagen)
                                    )"
                                >
                                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                        <img
                                            src="{{ $urlImagen }}"
                                            alt="{{ $tituloImagen }}"
                                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                                        >

                                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></div>

                                        <span class="absolute bottom-4 right-4 flex h-11 w-11 items-center justify-center rounded-full border border-white/30 bg-white/95 text-emerald-950 opacity-0 shadow-lg transition group-hover:opacity-100">
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <circle cx="11" cy="11" r="7"/>
                                                <path d="m20 20-3.5-3.5"/>
                                                <path d="M11 8v6M8 11h6"/>
                                            </svg>
                                        </span>
                                    </div>

                                    @if ($imagen->titulo || $imagen->descripcion)
                                        <div class="p-4">
                                            @if ($imagen->titulo)
                                                <h3 class="text-sm font-extrabold text-emerald-950">
                                                    {{ $imagen->titulo }}
                                                </h3>
                                            @endif

                                            @if ($imagen->descripcion)
                                                <p class="mt-2 text-xs leading-6 text-gray-600">
                                                    {{ \Illuminate\Support\Str::limit($imagen->descripcion, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </button>
                            @empty
                                <div class="sm:col-span-2 xl:col-span-3 rounded-[30px] border border-dashed border-amber-300 bg-gradient-to-br from-amber-50 to-emerald-50 px-6 py-16 text-center">
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg">
                                        <svg
                                            class="h-8 w-8"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                                            <circle cx="8" cy="10" r="1.5"/>
                                            <path d="m4 16 5-4 4 3 3-3 4 4"/>
                                        </svg>
                                    </div>

                                    <h3 class="mt-6 text-2xl font-black text-emerald-950">
                                        Galería en preparación
                                    </h3>

                                    <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-600">
                                        Próximamente se publicarán fotografías de esta promoción.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Visor de imagen --}}
                        <div
                            x-cloak
                            x-show="abierta"
                            x-transition.opacity
                            class="fixed inset-0 z-[100] flex items-center justify-center bg-emerald-950/95 p-4 sm:p-8"
                            role="dialog"
                            aria-modal="true"
                            @click.self="cerrar()"
                        >
                            <button
                                type="button"
                                class="absolute right-5 top-5 flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white transition hover:bg-white/20"
                                @click="cerrar()"
                                aria-label="Cerrar imagen"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M6 6l12 12M18 6 6 18"/>
                                </svg>
                            </button>

                            <div class="max-h-full max-w-6xl text-center">
                                <img
                                    :src="imagenActual"
                                    :alt="tituloActual"
                                    class="mx-auto max-h-[82vh] max-w-full rounded-2xl object-contain shadow-2xl"
                                >

                                <p
                                    x-show="tituloActual"
                                    x-text="tituloActual"
                                    class="mt-5 text-sm font-bold text-white"
                                ></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($relacionadas->isNotEmpty())
                <section class="mt-20 border-t border-gray-200 pt-14">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                                También puedes conocer
                            </p>

                            <h2 class="mt-2 text-3xl font-black text-emerald-950">
                                Otras promociones
                            </h2>
                        </div>

                        <a
                            href="{{ route('promociones.index', [
                                'nivel' => $promocion->nivel_educativo_id
                            ]) }}"
                            class="text-sm font-extrabold text-emerald-700 transition hover:text-amber-700"
                        >
                            Ver promociones del mismo nivel
                        </a>
                    </div>

                    <div class="mt-8 grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($relacionadas as $relacionada)
                            @php
                                $portadaRelacionada = $relacionada->imagen_portada
                                    ? asset('storage/' . $relacionada->imagen_portada)
                                    : asset('images/portada-institucion.jpg');
                            @endphp

                            <a
                                href="{{ route('promociones.mostrar', $relacionada) }}"
                                class="group overflow-hidden rounded-[26px] border border-amber-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                            >
                                <div class="relative h-56 overflow-hidden bg-gray-100">
                                    <img
                                        src="{{ $portadaRelacionada }}"
                                        alt="{{ $relacionada->nombre }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                        onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                                    >

                                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-transparent to-transparent"></div>

                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span class="text-xs font-extrabold text-amber-300">
                                            {{ $relacionada->anio }}
                                        </span>

                                        <h3 class="mt-1 text-xl font-black text-white">
                                            {{ $relacionada->nombre }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
</x-public-layout>