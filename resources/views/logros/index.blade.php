<x-public-layout title="Logros y reconocimientos">

    <section class="relative overflow-hidden bg-white py-24">

        <div
            class="pointer-events-none absolute -left-24 top-10 h-80 w-80
                   rounded-full bg-emerald-200/30 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80
                   rounded-full bg-amber-200/40 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-amber-600">
                    Excelencia institucional
                </p>

                <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                    Logros y reconocimientos
                </h1>

                <div class="mx-auto mt-5 flex w-fit items-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Conoce los reconocimientos obtenidos por nuestros estudiantes,
                    docentes y la institución.
                </p>
            </div>

            {{-- Tarjetas --}}
            <div class="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($logros as $logro)

                    @php
                        /*
                        |--------------------------------------------------------------------------
                        | IMAGEN DEL LOGRO
                        |--------------------------------------------------------------------------
                        */

                        $imagenesLogros = [
                            'Primer puesto en Feria de Ciencia'
                                => 'images/logros/logro-feria-ciencia.png',

                            'Reconocimiento a la excelencia académica'
                                => 'images/logros/logro-excelencia-academica.png',

                            'Participación destacada en actividades cívicas'
                                => 'images/logros/logro-actividades-civicas.png',
                        ];

                        $rutaImagenGuardada = $logro->imagen ?? null;

                        if (
                            $rutaImagenGuardada &&
                            file_exists(public_path($rutaImagenGuardada))
                        ) {
                            $imagenLogro = asset($rutaImagenGuardada);
                        } elseif (
                            isset($imagenesLogros[$logro->titulo]) &&
                            file_exists(
                                public_path($imagenesLogros[$logro->titulo])
                            )
                        ) {
                            $imagenLogro = asset(
                                $imagenesLogros[$logro->titulo]
                            );
                        } else {
                            $imagenLogro = asset(
                                'images/logro-default.jpg'
                            );
                        }

                        $fechaLogro = $logro->fecha
                            ? \Illuminate\Support\Carbon::parse($logro->fecha)
                            : null;
                    @endphp

                    <article
                        class="group flex h-full flex-col overflow-hidden
                               rounded-[30px] border border-amber-200 bg-white
                               shadow-[0_18px_50px_rgba(6,78,59,0.08)]
                               transition duration-300
                               hover:-translate-y-2
                               hover:shadow-[0_24px_65px_rgba(6,78,59,0.15)]"
                    >
                        {{-- Imagen --}}
                        <div class="relative h-72 overflow-hidden bg-gray-100">

                            <img
                                src="{{ $imagenLogro }}"
                                alt="{{ $logro->titulo }}"
                                class="h-full w-full object-cover
                                       transition duration-700
                                       group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('images/logro-default.jpg') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/85
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            {{-- Tipo --}}
                            <span
                                class="absolute left-5 top-5 inline-flex rounded-full
                                       border border-amber-300 bg-emerald-950/90
                                       px-4 py-2 text-[11px] font-extrabold uppercase
                                       tracking-[0.14em] text-white backdrop-blur"
                            >
                                {{ $logro->tipo }}
                            </span>

                            {{-- Fecha --}}
                            @if ($fechaLogro)
                                <div
                                    class="absolute bottom-5 right-5 flex h-16 w-16
                                           flex-col items-center justify-center rounded-2xl
                                           border border-amber-300 bg-white/95
                                           text-emerald-950 shadow-lg"
                                >
                                    <span class="text-xl font-extrabold leading-none">
                                        {{ $fechaLogro->format('d') }}
                                    </span>

                                    <span class="mt-1 text-[10px] font-extrabold uppercase text-amber-600">
                                        {{ $fechaLogro
                                            ->locale('es')
                                            ->translatedFormat('M') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Contenido --}}
                        <div class="flex flex-1 flex-col p-7">

                            @if ($logro->nivel)
                                <span
                                    class="inline-flex w-fit rounded-full
                                           border border-amber-200 bg-amber-50
                                           px-3 py-1.5 text-[11px]
                                           font-extrabold uppercase tracking-[0.13em]
                                           text-amber-700"
                                >
                                    Nivel {{ $logro->nivel }}
                                </span>
                            @endif

                            <h2
                                class="mt-4 text-2xl font-extrabold
                                       leading-tight text-emerald-950"
                            >
                                {{ $logro->titulo }}
                            </h2>

                            <div class="mt-4 flex items-center gap-2">
                                <span class="h-px w-12 bg-amber-400"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-700"></span>
                            </div>

                            <p class="mt-5 flex-1 text-sm leading-7 text-gray-600">
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($logro->descripcion),
                                    150
                                ) }}
                            </p>

                            <div class="mt-7 border-t border-gray-100 pt-5">

                                <a
                                    href="{{ route('logros.mostrar', $logro->id) }}"
                                    class="group/enlace inline-flex items-center gap-2
                                           text-sm font-extrabold text-emerald-800
                                           transition hover:text-emerald-950"
                                >
                                    Ver detalle

                                    <svg
                                        class="h-4 w-4 transition
                                               group-hover/enlace:translate-x-1"
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

                    <div
                        class="md:col-span-2 lg:col-span-3
                               rounded-[32px] border border-dashed border-amber-300
                               bg-amber-50/40 px-6 py-16 text-center"
                    >
                        <h2 class="text-2xl font-extrabold text-emerald-950">
                            No hay logros publicados
                        </h2>

                        <p class="mx-auto mt-4 max-w-xl text-gray-600">
                            Los logros y reconocimientos aparecerán en esta sección.
                        </p>
                    </div>

                @endforelse
            </div>

            @if ($logros->hasPages())
                <div class="mt-12">
                    {{ $logros->links() }}
                </div>
            @endif
        </div>
    </section>

</x-public-layout>