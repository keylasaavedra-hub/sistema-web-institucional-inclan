<x-public-layout :title="$servicio['titulo']">

    {{-- ========================================================= --}}
    {{-- PORTADA DEL SERVICIO --}}
    {{-- ========================================================= --}}
    <section class="relative overflow-hidden bg-white">

        <div class="pointer-events-none absolute -left-24 top-20 h-80 w-80 rounded-full bg-emerald-100/60 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-amber-100/60 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">

            <div class="grid items-center gap-12 lg:grid-cols-[0.95fr_1.05fr]">

                {{-- Información --}}
                <div>
                    <a
                        href="{{ route('inicio') }}#servicios-complementarios"
                        class="inline-flex items-center gap-2 text-sm font-extrabold text-emerald-800 transition hover:text-emerald-950"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M19 12H5"/>
                            <path d="m11 18-6-6 6-6"/>
                        </svg>

                        Volver a servicios
                    </a>

                    <p class="mt-8 text-sm font-extrabold uppercase tracking-[0.22em] text-amber-600">
                        Servicio complementario
                    </p>

                    <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl lg:text-6xl">
                        {{ $servicio['titulo'] }}
                    </h1>

                    <p class="mt-4 text-base font-bold text-emerald-800 sm:text-lg">
                        {{ $servicio['subtitulo'] }}
                    </p>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-7 max-w-2xl text-lg leading-8 text-gray-600">
                        {{ $servicio['descripcion'] }}
                    </p>

                    <div class="mt-8">
                        <div
                            class="inline-flex items-center gap-4 rounded-2xl
                                   border border-amber-200 bg-white
                                   px-5 py-4 shadow-sm"
                        >
                            <span
                                class="flex h-11 w-11 shrink-0 items-center justify-center
                                       rounded-xl bg-emerald-950 text-white"
                            >
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 2"/>
                                </svg>
                            </span>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                    Horario de atención
                                </p>

                                <p class="mt-1 font-bold text-emerald-950">
                                    {{ $servicio['horario'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Imagen principal --}}
                <div class="relative">

                    <div
                        class="absolute -inset-4 rounded-[38px] border border-amber-200 bg-emerald-50/60"
                    ></div>

                    <div
                        class="relative overflow-hidden rounded-[32px] border border-amber-300
                               bg-emerald-950 shadow-[0_25px_70px_rgba(6,78,59,0.18)]"
                    >
                        <img
                            src="{{ asset($servicio['imagen_portada']) }}"
                            alt="{{ $servicio['titulo'] }}"
                            class="h-[430px] w-full object-cover"
                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/70 via-transparent to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-7 text-white">
                            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-300">
                                Bienestar estudiantil
                            </p>

                            <h2 class="mt-2 text-2xl font-extrabold">
                                {{ $servicio['titulo'] }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- FUNCIONES DEL SERVICIO --}}
    {{-- ========================================================= --}}
    <section class="bg-emerald-950 py-20 text-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">

                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.22em] text-amber-300">
                        Atención institucional
                    </p>

                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Principales funciones
                    </h2>

                    <p class="mt-5 max-w-xl text-base leading-7 text-emerald-100">
                        Estas acciones permiten brindar una atención organizada, preventiva
                        y cercana a los estudiantes y sus familias.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    @foreach ($servicio['funciones'] as $funcion)

                        <div
                            class="flex items-start gap-4 rounded-2xl border border-amber-300/40
                                   bg-emerald-900/70 p-5"
                        >
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center
                                       rounded-xl border border-amber-300 bg-emerald-950"
                            >
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                            </span>

                            <p class="pt-1 text-sm font-semibold leading-6 text-emerald-50">
                                {{ $funcion }}
                            </p>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- GALERÍA --}}
    {{-- ========================================================= --}}
    <section class="relative overflow-hidden bg-white py-24">

        <div class="pointer-events-none absolute -right-24 top-0 h-80 w-80 rounded-full bg-amber-100/50 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-extrabold uppercase tracking-[0.22em] text-amber-600">
                    Actividades y evidencias
                </p>

                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                    Galería del servicio
                </h2>

                <div class="mx-auto mt-5 flex w-fit items-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Registro fotográfico de las actividades, jornadas y acciones
                    desarrolladas por este servicio.
                </p>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($servicio['galeria'] as $indice => $foto)

                    <a
                        href="{{ asset($foto) }}"
                        target="_blank"
                        class="group relative overflow-hidden rounded-[26px]
                               border border-amber-200 bg-emerald-950
                               shadow-lg shadow-emerald-950/10"
                    >
                        <img
                            src="{{ asset($foto) }}"
                            alt="{{ $servicio['titulo'] }} - Foto {{ $indice + 1 }}"
                            class="h-72 w-full object-cover transition duration-700 group-hover:scale-110"
                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/85 via-transparent to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                Fotografía {{ $indice + 1 }}
                            </p>

                            <p class="mt-1 font-bold text-white">
                                {{ $servicio['titulo'] }}
                            </p>
                        </div>
                    </a>

                @endforeach
            </div>
        </div>
    </section>

</x-public-layout>