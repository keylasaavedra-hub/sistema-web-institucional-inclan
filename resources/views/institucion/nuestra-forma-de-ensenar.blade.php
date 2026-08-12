<x-public-layout title="Nuestra forma de enseñar">

    @php
        $datosContenido = $contenido?->datos ?? [];

        $imagenPrincipal = function (?string $ruta): string {
            if (! $ruta) {
                return asset('images/forma-ensenar.jpeg');
            }

            if (str_starts_with($ruta, 'images/')) {
                return asset($ruta);
            }

            return asset('storage/' . ltrim($ruta, '/'));
        };

        $iconos = [
            'libro' => 'M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5z M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5z',
            'corazon' => 'M12 21s-6.5-4.35-9-8.5C1.1 9.3 3.1 5.5 7 5.5c2.1 0 3.5 1.2 5 3 1.5-1.8 2.9-3 5-3 3.9 0 5.9 3.8 4 7-2.5 4.15-9 8.5-9 8.5z',
            'participacion' => 'M12 3v18 M3 12h18 M5 5l14 14 M19 5 5 19',
            'acompanamiento' => 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20 M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z',
            'tecnologia' => 'M4 4h16v12H4z M8 20h8 M12 16v4',
            'diversidad' => 'M8 12h8 M12 8v8 M4 4h16v16H4z',
            'general' => 'M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z M8 12l2.5 2.5L16 9',
        ];

        $etiquetas = $datosContenido['etiquetas'] ?? [
            'Aprendizaje activo',
            'Formación integral',
            'Acompañamiento permanente',
        ];
    @endphp

    <section class="relative overflow-hidden bg-white py-24">

        <div class="pointer-events-none absolute -left-24 top-10 h-80 w-80 rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-amber-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('inicio') }}"
                class="inline-flex items-center gap-2 text-sm font-extrabold text-emerald-800 transition hover:text-emerald-950"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5"/>
                    <path d="m11 18-6-6 6-6"/>
                </svg>

                Volver al inicio
            </a>

            <div class="mt-10 grid items-center gap-12 lg:grid-cols-2">

                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-amber-600">
                        {{ $contenido?->subtitulo ?: 'Propuesta educativa' }}
                    </p>

                    <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                        {{ $contenido?->titulo ?: 'Nuestra forma de enseñar' }}
                    </h1>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-7 text-base leading-8 text-gray-700">
                        {{ $contenido?->contenido ?: 'Nuestra propuesta educativa busca que cada estudiante aprenda de manera activa, comprenda lo que estudia y aplique sus conocimientos en situaciones reales.' }}
                    </p>

                    <p class="mt-5 text-base leading-8 text-gray-700">
                        {{ $datosContenido['descripcion_2'] ?? 'Promovemos una formación integral que fortalece las competencias académicas, los valores, la autonomía, la creatividad y la responsabilidad ciudadana.' }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach ($etiquetas as $index => $etiqueta)
                            <span
                                class="rounded-full border px-4 py-2 text-sm font-extrabold
                                    {{ $index % 3 === 0
                                        ? 'border-emerald-100 bg-emerald-50 text-emerald-800'
                                        : ($index % 3 === 1
                                            ? 'border-amber-200 bg-amber-50 text-amber-700'
                                            : 'border-gray-200 bg-white text-gray-700 shadow-sm')
                                    }}"
                            >
                                {{ $etiqueta }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 rounded-[38px] border border-amber-200 bg-emerald-50/60"></div>

                    <div class="relative overflow-hidden rounded-[32px] border border-amber-300 bg-emerald-950 shadow-[0_25px_70px_rgba(6,78,59,0.18)]">
                        <img
                            src="{{ $imagenPrincipal($contenido?->imagen) }}"
                            alt="{{ $contenido?->titulo ?: 'Nuestra forma de enseñar' }}"
                            class="h-[500px] w-full object-cover"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-7 text-white">
                            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-300">
                                {{ $datosContenido['imagen_etiqueta'] ?? 'Enseñanza centrada en el estudiante' }}
                            </p>

                            <h2 class="mt-2 text-2xl font-extrabold">
                                {{ $datosContenido['imagen_titulo'] ?? 'Aprender, participar y transformar' }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-20">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                        {{ $datosContenido['principios_etiqueta'] ?? 'Principios pedagógicos' }}
                    </p>

                    <h2 class="mt-3 text-3xl font-extrabold text-emerald-950 sm:text-4xl">
                        {{ $datosContenido['principios_titulo'] ?? '¿Cómo desarrollamos el aprendizaje?' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-gray-600">
                        {{ $datosContenido['principios_descripcion'] ?? 'Nuestro trabajo pedagógico se apoya en principios que favorecen el desarrollo integral de cada estudiante.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($principios as $principio)
                        <article
                            class="rounded-[28px] border border-amber-200 bg-white p-7 shadow-[0_16px_45px_rgba(6,78,59,0.09)] transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                        >
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-amber-300 bg-emerald-950 text-amber-300">
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="{{ $iconos[$principio->icono] ?? $iconos['general'] }}"/>
                                </svg>
                            </div>

                            <h3 class="mt-6 text-xl font-extrabold text-emerald-950">
                                {{ $principio->titulo }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-gray-600">
                                {{ $principio->descripcion }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="mt-20 rounded-[36px] border border-amber-200 bg-emerald-950 p-8 text-white sm:p-10 lg:p-12">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-300">
                        {{ $datosContenido['proceso_etiqueta'] ?? 'Proceso de aprendizaje' }}
                    </p>

                    <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">
                        {{ $datosContenido['proceso_titulo'] ?? 'Una experiencia organizada y progresiva' }}
                    </h2>

                    <p class="mt-5 leading-8 text-emerald-100">
                        {{ $datosContenido['proceso_descripcion'] ?? 'Cada experiencia educativa permite al estudiante explorar, comprender, aplicar y reflexionar sobre lo aprendido.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ($etapas as $etapa)
                        <article class="rounded-3xl border border-emerald-700 bg-emerald-900/70 p-6">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-amber-300 text-sm font-extrabold text-amber-300">
                                {{ $etapa->numero }}
                            </span>

                            <h3 class="mt-5 text-xl font-extrabold">
                                {{ $etapa->titulo }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-emerald-100">
                                {{ $etapa->descripcion }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="mt-20">
                <div
                    class="grid items-center gap-10 rounded-[32px] border border-amber-200 bg-emerald-50 p-8
                           {{ !empty($datosContenido['compromiso_imagen']) ? 'lg:grid-cols-[0.45fr_1fr]' : 'lg:grid-cols-[auto_1fr]' }}
                           lg:p-10"
                >
                    @if (!empty($datosContenido['compromiso_imagen']))
                        <div class="overflow-hidden rounded-[28px] border border-amber-300 bg-emerald-950">
                            <img
                                src="{{ $imagenPrincipal($datosContenido['compromiso_imagen']) }}"
                                alt="{{ $datosContenido['compromiso_titulo'] ?? 'Nuestro compromiso' }}"
                                class="h-64 w-full object-cover"
                            >
                        </div>
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-[28px] border border-amber-300 bg-emerald-950 text-amber-300">
                            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 3 2 8l10 5 10-5-10-5z"/>
                                <path d="m6 10 6 3 6-3v6l-6 3-6-3z"/>
                            </svg>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                            {{ $datosContenido['compromiso_etiqueta'] ?? 'Nuestro compromiso' }}
                        </p>

                        <h2 class="mt-3 text-3xl font-extrabold text-emerald-950">
                            {{ $datosContenido['compromiso_titulo'] ?? 'Formamos estudiantes preparados para la vida' }}
                        </h2>

                        <p class="mt-4 max-w-4xl leading-8 text-gray-600">
                            {{ $datosContenido['compromiso_descripcion'] ?? 'Acompañamos a nuestros estudiantes para que desarrollen conocimientos, habilidades, valores y actitudes que les permitan afrontar retos, tomar decisiones responsables y contribuir positivamente con su comunidad.' }}
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </section>

</x-public-layout>