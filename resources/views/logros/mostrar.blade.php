<x-public-layout :title="$logro->titulo">

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

    <section class="relative overflow-hidden bg-white py-24">

        {{-- Fondos decorativos --}}
        <div
            class="pointer-events-none absolute -left-24 top-10 h-80 w-80
                   rounded-full bg-emerald-200/30 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80
                   rounded-full bg-amber-200/40 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Regresar --}}
            <a
                href="{{ route('logros.index') }}"
                class="inline-flex items-center gap-2
                       text-sm font-extrabold text-emerald-800
                       transition hover:text-emerald-950"
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

                Volver a logros
            </a>

            <div
                class="mt-10 grid items-start gap-12
                       lg:grid-cols-[1.05fr_0.95fr]"
            >
                {{-- Imagen --}}
                <div
                    class="overflow-hidden rounded-[32px]
                           border border-amber-300 bg-emerald-950
                           shadow-[0_25px_70px_rgba(6,78,59,0.18)]"
                >
                    <img
                        src="{{ $imagenLogro }}"
                        alt="{{ $logro->titulo }}"
                        class="h-[520px] w-full object-cover"
                        onerror="this.onerror=null; this.src='{{ asset('images/logro-default.jpg') }}';"
                    >
                </div>

                {{-- Información --}}
                <div>
                    <span
                        class="inline-flex rounded-full
                               border border-amber-300 bg-emerald-950
                               px-4 py-2 text-xs font-extrabold
                               uppercase tracking-[0.14em] text-white"
                    >
                        {{ $logro->tipo }}
                    </span>

                    <h1
                        class="mt-6 text-4xl font-extrabold
                               tracking-tight text-emerald-950
                               sm:text-5xl"
                    >
                        {{ $logro->titulo }}
                    </h1>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <div class="mt-7 flex flex-wrap gap-3">

                        @if ($logro->nivel)
                            <span
                                class="rounded-full border border-amber-200
                                       bg-amber-50 px-4 py-2
                                       text-sm font-extrabold text-amber-700"
                            >
                                Nivel {{ $logro->nivel }}
                            </span>
                        @endif

                        @if ($fechaLogro)
                            <span
                                class="rounded-full border border-gray-200
                                       bg-white px-4 py-2 text-sm
                                       font-bold text-gray-600 shadow-sm"
                            >
                                {{ $fechaLogro->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-8 text-base leading-8 text-gray-700">
                        {!! nl2br(e($logro->descripcion)) !!}
                    </div>

                    @if ($logro->archivo_respaldo)
                        <div class="mt-8">

                            <a
                                href="{{ asset($logro->archivo_respaldo) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2
                                       rounded-xl border border-amber-300
                                       bg-emerald-950 px-5 py-3
                                       text-sm font-extrabold text-white
                                       transition hover:bg-emerald-900"
                            >
                                Ver documento de respaldo

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M14 3h7v7"/>
                                    <path d="M10 14 21 3"/>
                                    <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-public-layout>