<x-public-layout title="Misión, visión y valores">

    @php
        /*
        |--------------------------------------------------------------------------
        | CONTENIDO DESDE LA BASE DE DATOS
        |--------------------------------------------------------------------------
        */

        $misionRegistrada = $informacion->get('mision')->contenido ?? null;
        $visionRegistrada = $informacion->get('vision')->contenido ?? null;
        $valoresRegistrados = $informacion->get('valores')->contenido ?? null;

        /*
        |--------------------------------------------------------------------------
        | CONTENIDO DE RESPALDO
        |--------------------------------------------------------------------------
        */

        $misionTexto = $misionRegistrada
            ?: 'Brindar un servicio educativo de calidad mediante procesos permanentes de mejora continua, aplicando un modelo pedagógico Socio Constructivista Humanista, que favorezca el aprendizaje significativo, la formación integral y el desarrollo de ciudadanos responsables.';

        $visionTexto = $visionRegistrada
            ?: 'Consolidarnos como una institución educativa de calidad, moderna, reconocida e integrada al sistema educativo nacional, alineada con la visión del Sector Defensa y comprometida con la formación ética, cívica y patriótica.';

        $valoresInstitucionales = [
            [
                'nombre' => 'Vocación de servicio',
                'descripcion' => 'Atendemos las necesidades de nuestra comunidad educativa con disposición, empatía y compromiso.',
                'icono' => 'corazon',
            ],
            [
                'nombre' => 'Disciplina',
                'descripcion' => 'Actuamos con orden, constancia y respeto por las normas que orientan nuestra convivencia.',
                'icono' => 'libro',
            ],
            [
                'nombre' => 'Integridad',
                'descripcion' => 'Procedemos con honestidad, coherencia y transparencia en todas nuestras acciones.',
                'icono' => 'escudo',
            ],
            [
                'nombre' => 'Compromiso',
                'descripcion' => 'Participamos activamente en la formación y el bienestar de nuestros estudiantes.',
                'icono' => 'manos',
            ],
            [
                'nombre' => 'Responsabilidad',
                'descripcion' => 'Cumplimos nuestros deberes con puntualidad, dedicación y sentido institucional.',
                'icono' => 'check',
            ],
            [
                'nombre' => 'Excelencia',
                'descripcion' => 'Buscamos mejorar continuamente nuestros procesos educativos y resultados.',
                'icono' => 'estrella',
            ],
        ];

        $pilaresMision = [
            'Aprendizaje significativo y pensamiento crítico.',
            'Formación integral, humana e inclusiva.',
            'Uso responsable de la tecnología educativa.',
            'Mejora continua de los procesos pedagógicos.',
        ];

        $pilaresVision = [
            'Educación moderna y de calidad.',
            'Reconocimiento e integración nacional.',
            'Formación ética, cívica y patriótica.',
            'Comunidad preparada para nuevos desafíos.',
        ];
    @endphp

    <section class="relative overflow-hidden bg-white">

        {{-- Decoraciones de fondo --}}
        <div
            class="pointer-events-none absolute -left-32 top-24
                   h-96 w-96 rounded-full bg-emerald-100/60 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 top-[650px]
                   h-96 w-96 rounded-full bg-amber-100/60 blur-3xl"
        ></div>

        {{-- ===================================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ===================================================== --}}
        <section class="relative py-16 sm:py-20 lg:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <a
                    href="{{ route('inicio') }}"
                    class="inline-flex items-center gap-2 text-sm
                           font-extrabold text-emerald-800
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

                    Volver al inicio
                </a>

                <div class="mx-auto mt-10 max-w-4xl text-center">

                    <div
                        class="inline-flex items-center gap-2 rounded-full
                               border border-amber-200 bg-amber-50
                               px-4 py-2 text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-700"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="m8 12 2.5 2.5L16 9"/>
                        </svg>

                        Nuestra identidad institucional
                    </div>

                    <h1
                        class="mt-6 text-4xl font-extrabold tracking-tight
                               text-emerald-950 sm:text-5xl lg:text-6xl"
                    >
                        Misión, visión y valores
                    </h1>

                    <div class="mx-auto mt-6 flex w-fit items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p
                        class="mx-auto mt-7 max-w-3xl text-base
                               leading-8 text-gray-600 sm:text-lg"
                    >
                        Los principios que orientan nuestra labor educativa,
                        fortalecen nuestra identidad y guían la formación
                        integral de los estudiantes.
                    </p>
                </div>

                </div>
        </section>

        {{-- ===================================================== --}}
        {{-- MISIÓN --}}
        {{-- ===================================================== --}}
        <section class="border-y border-emerald-100 bg-emerald-50/60 py-20">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="grid items-center gap-12
                           lg:grid-cols-[1fr_0.95fr]"
                >
                    {{-- Imagen --}}
                    <div class="relative">

                        <div
                            class="absolute -inset-3 rounded-[36px]
                                   border border-amber-200 bg-white"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[32px]
                                   border border-amber-300 bg-emerald-950
                                   shadow-[0_24px_65px_rgba(6,78,59,0.16)]"
                        >
                            <img
                                src="{{ asset('images/mision.png') }}"
                                alt="Misión institucional"
                                class="h-[460px] w-full object-cover
                                       sm:h-[520px]"
                                onerror="this.onerror=null; this.src='{{ asset('images/portada-institucion.jpg') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/90
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div class="absolute bottom-0 left-0 right-0 p-7">

                                <div class="flex items-center gap-4">

                                    <span
                                        class="flex h-14 w-14 items-center
                                               justify-center rounded-2xl
                                               border border-amber-300
                                               bg-emerald-950 text-amber-300"
                                    >
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7z"/>
                                            <path d="M9 12l2 2 4-4"/>
                                        </svg>
                                    </span>

                                    <div>
                                        <p
                                            class="text-xs font-extrabold uppercase
                                                   tracking-[0.16em] text-amber-300"
                                        >
                                            Nuestro propósito
                                        </p>

                                        <h2 class="mt-1 text-3xl font-extrabold text-white">
                                            Misión
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div>

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.2em] text-amber-600"
                        >
                            Lo que hacemos
                        </p>

                        <h2
                            class="mt-3 text-3xl font-extrabold
                                   text-emerald-950 sm:text-4xl"
                        >
                            Formamos estudiantes de manera integral
                        </h2>

                        <div class="mt-5 flex items-center gap-3">
                            <span class="h-1 w-14 rounded-full bg-emerald-700"></span>
                            <span class="h-1 w-8 rounded-full bg-amber-400"></span>
                        </div>

                        <div
                            class="mt-7 rounded-[28px] border
                                   border-amber-200 bg-white p-7
                                   shadow-sm"
                        >
                            <p class="text-base leading-8 text-gray-700">
                                {{ $misionTexto }}
                            </p>
                        </div>

                        <div class="mt-7 grid gap-3">

                            @foreach ($pilaresMision as $pilar)

                                <div
                                    class="flex items-start gap-4
                                           rounded-2xl border border-emerald-100
                                           bg-white px-5 py-4"
                                >
                                    <span
                                        class="flex h-9 w-9 shrink-0
                                               items-center justify-center
                                               rounded-xl bg-emerald-950
                                               text-amber-300"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path d="m6 12 4 4 8-8"/>
                                        </svg>
                                    </span>

                                    <p class="pt-1 text-sm font-bold leading-6 text-gray-700">
                                        {{ $pilar }}
                                    </p>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================================================== --}}
        {{-- VISIÓN --}}
        {{-- ===================================================== --}}
        <section class="relative py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="grid items-center gap-12
                           lg:grid-cols-[0.95fr_1fr]"
                >
                    {{-- Contenido --}}
                    <div class="order-2 lg:order-1">

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.2em] text-amber-600"
                        >
                            Hacia dónde avanzamos
                        </p>

                        <h2
                            class="mt-3 text-3xl font-extrabold
                                   text-emerald-950 sm:text-4xl"
                        >
                            Una institución moderna y reconocida
                        </h2>

                        <div class="mt-5 flex items-center gap-3">
                            <span class="h-1 w-14 rounded-full bg-emerald-700"></span>
                            <span class="h-1 w-8 rounded-full bg-amber-400"></span>
                        </div>

                        <div
                            class="mt-7 rounded-[28px] border
                                   border-amber-200 bg-white p-7
                                   shadow-sm"
                        >
                            <p class="text-base leading-8 text-gray-700">
                                {{ $visionTexto }}
                            </p>
                        </div>

                        <div class="mt-7 grid gap-3">

                            @foreach ($pilaresVision as $pilar)

                                <div
                                    class="flex items-start gap-4
                                           rounded-2xl border border-emerald-100
                                           bg-emerald-50/60 px-5 py-4"
                                >
                                    <span
                                        class="flex h-9 w-9 shrink-0
                                               items-center justify-center
                                               rounded-xl bg-emerald-950
                                               text-amber-300"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path d="m6 12 4 4 8-8"/>
                                        </svg>
                                    </span>

                                    <p class="pt-1 text-sm font-bold leading-6 text-gray-700">
                                        {{ $pilar }}
                                    </p>
                                </div>

                            @endforeach
                        </div>
                    </div>

                    {{-- Imagen --}}
                    <div class="relative order-1 lg:order-2">

                        <div
                            class="absolute -inset-3 rounded-[36px]
                                   border border-amber-200 bg-emerald-50"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[32px]
                                   border border-amber-300 bg-emerald-950
                                   shadow-[0_24px_65px_rgba(6,78,59,0.16)]"
                        >
                            <img
                                src="{{ asset('images/vision.png') }}"
                                alt="Visión institucional"
                                class="h-[460px] w-full object-cover
                                       sm:h-[520px]"
                                onerror="this.onerror=null; this.src='{{ asset('images/infraestructura-biblioteca.jpg') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/90
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div class="absolute bottom-0 left-0 right-0 p-7">

                                <div class="flex items-center gap-4">

                                    <span
                                        class="flex h-14 w-14 items-center
                                               justify-center rounded-2xl
                                               border border-amber-300
                                               bg-emerald-950 text-amber-300"
                                    >
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"/>
                                            <circle cx="12" cy="12" r="2.5"/>
                                        </svg>
                                    </span>

                                    <div>
                                        <p
                                            class="text-xs font-extrabold uppercase
                                                   tracking-[0.16em] text-amber-300"
                                        >
                                            Nuestra proyección
                                        </p>

                                        <h2 class="mt-1 text-3xl font-extrabold text-white">
                                            Visión
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================================================== --}}
        {{-- VALORES --}}
        {{-- ===================================================== --}}
        <section class="border-y border-emerald-100 bg-gray-50 py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="grid items-center gap-12
                           lg:grid-cols-[0.8fr_1.2fr]"
                >
                    {{-- Imagen --}}
                    <div class="relative">

                        <div
                            class="absolute -inset-3 rounded-[36px]
                                   border border-amber-200 bg-white"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[32px]
                                   border border-amber-300 bg-emerald-950
                                   shadow-[0_24px_65px_rgba(6,78,59,0.16)]"
                        >
                            <img
                                src="{{ asset('images/valores.png') }}"
                                alt="Valores institucionales"
                                class="h-[520px] w-full object-cover"
                                onerror="this.onerror=null; this.src='{{ asset('images/servicio-toece.jpg') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/90
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div class="absolute bottom-0 left-0 right-0 p-7">

                                <div class="flex items-center gap-4">

                                    <span
                                        class="flex h-14 w-14 items-center
                                               justify-center rounded-2xl
                                               border border-amber-300
                                               bg-emerald-950 text-amber-300"
                                    >
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M12 17.3l-6.16 3.24 1.18-6.88L2 8.76l6.92-1L12 1.5l3.08 6.26 6.92 1-5.02 4.9 1.18 6.88z"/>
                                        </svg>
                                    </span>

                                    <div>
                                        <p
                                            class="text-xs font-extrabold uppercase
                                                   tracking-[0.16em] text-amber-300"
                                        >
                                            Principios institucionales
                                        </p>

                                        <h2 class="mt-1 text-3xl font-extrabold text-white">
                                            Valores
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div>

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.2em] text-amber-600"
                        >
                            Nuestra forma de actuar
                        </p>

                        <h2
                            class="mt-3 text-3xl font-extrabold
                                   text-emerald-950 sm:text-4xl"
                        >
                            Principios que fortalecen nuestra comunidad
                        </h2>

                        <p class="mt-5 text-base leading-8 text-gray-600">
                            {{ $valoresRegistrados
                                ?: 'Promovemos valores que fortalecen la convivencia, el servicio y la excelencia, formando ciudadanos responsables y comprometidos con su comunidad.' }}
                        </p>

                        <div class="mt-9 grid gap-5 sm:grid-cols-2">

                            @foreach ($valoresInstitucionales as $valor)

                                <article
                                    class="group rounded-[26px]
                                           border border-amber-200 bg-white
                                           p-6 shadow-sm transition
                                           duration-300 hover:-translate-y-1
                                           hover:shadow-lg"
                                >
                                    <div class="flex items-start gap-4">

                                        <span
                                            class="flex h-12 w-12 shrink-0
                                                   items-center justify-center
                                                   rounded-2xl bg-emerald-950
                                                   text-amber-300"
                                        >
                                            @switch($valor['icono'])

                                                @case('corazon')
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>
                                                    </svg>
                                                    @break

                                                @case('libro')
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5z"/>
                                                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5z"/>
                                                    </svg>
                                                    @break

                                                @case('escudo')
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7z"/>
                                                    </svg>
                                                    @break

                                                @case('manos')
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="m8 12 3 3 5-5"/>
                                                        <path d="M3 7h4l3 3M21 7h-4l-3 3"/>
                                                        <path d="M5 17h4l3-3 3 3h4"/>
                                                    </svg>
                                                    @break

                                                @case('check')
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <circle cx="12" cy="12" r="9"/>
                                                        <path d="m8 12 2.5 2.5L16 9"/>
                                                    </svg>
                                                    @break

                                                @default
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                    >
                                                        <path d="m12 17.27-5.18 3.05 1.39-5.92L3.5 10.24l6.1-.52L12 4.1l2.4 5.62 6.1.52-4.71 4.16 1.39 5.92z"/>
                                                    </svg>

                                            @endswitch
                                        </span>

                                        <div>
                                            <h3
                                                class="text-lg font-extrabold
                                                       text-emerald-950"
                                            >
                                                {{ $valor['nombre'] }}
                                            </h3>

                                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                                {{ $valor['descripcion'] }}
                                            </p>
                                        </div>
                                    </div>
                                </article>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================================================== --}}
        {{-- ENFOQUE INSTITUCIONAL --}}
        {{-- ===================================================== --}}
        <section class="relative py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="overflow-hidden rounded-[36px]
                           border border-amber-300 bg-emerald-950
                           shadow-[0_25px_70px_rgba(6,78,59,0.18)]"
                >
                    <div class="grid lg:grid-cols-[1.1fr_0.9fr]">

                        {{-- Contenido --}}
                        <div class="relative flex items-center p-8 sm:p-10 lg:p-12">

                            <div
                                class="pointer-events-none absolute -left-24
                                       -top-24 h-72 w-72 rounded-full
                                       bg-emerald-700/25 blur-3xl"
                            ></div>

                            <div
                                class="pointer-events-none absolute bottom-0
                                       right-0 h-56 w-56 rounded-full
                                       bg-amber-300/10 blur-3xl"
                            ></div>

                            <div class="relative">

                                <div class="inline-flex items-center gap-3">

                                    <span
                                        class="flex h-12 w-12 items-center
                                               justify-center rounded-2xl
                                               border border-amber-300
                                               bg-emerald-900 text-amber-300"
                                    >
                                        <svg
                                            class="h-6 w-6"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M4 19h16"/>
                                            <path d="M5 15V7l7-4 7 4v8"/>
                                            <path d="M9 11h.01M12 11h.01M15 11h.01"/>
                                        </svg>
                                    </span>

                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.2em] text-amber-300"
                                    >
                                        Enfoque institucional
                                    </p>
                                </div>

                                <h2
                                    class="mt-6 max-w-2xl text-3xl
                                           font-extrabold leading-tight
                                           text-white sm:text-4xl"
                                >
                                    Innovación, acompañamiento y mejora continua
                                </h2>

                                <p
                                    class="mt-6 max-w-3xl text-base
                                           leading-8 text-emerald-100"
                                >
                                    Fortalecemos nuestros procesos educativos
                                    mediante tecnologías de la información,
                                    evaluación formativa y acompañamiento docente,
                                    con el propósito de brindar una educación
                                    inclusiva, equitativa y de calidad.
                                </p>

                                <div class="mt-8 grid gap-4 sm:grid-cols-2">

                                    @foreach ([
                                        [
                                            'titulo' => 'Tecnologías educativas',
                                            'texto' => 'Recursos digitales para fortalecer los aprendizajes.',
                                        ],
                                        [
                                            'titulo' => 'Evaluación formativa',
                                            'texto' => 'Seguimiento y retroalimentación permanente.',
                                        ],
                                        [
                                            'titulo' => 'Acompañamiento docente',
                                            'texto' => 'Mejora continua de la práctica pedagógica.',
                                        ],
                                        [
                                            'titulo' => 'Educación inclusiva',
                                            'texto' => 'Atención equitativa y formación integral.',
                                        ],
                                    ] as $enfoque)

                                        <article
                                            class="rounded-2xl border
                                                   border-amber-300/25
                                                   bg-white/[0.07] p-5"
                                        >
                                            <div class="flex items-start gap-3">

                                                <span
                                                    class="flex h-8 w-8 shrink-0
                                                           items-center justify-center
                                                           rounded-xl bg-amber-300
                                                           text-emerald-950"
                                                >
                                                    <svg
                                                        class="h-4 w-4"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path d="m6 12 4 4 8-8"/>
                                                    </svg>
                                                </span>

                                                <div>
                                                    <h3 class="text-sm font-extrabold text-white">
                                                        {{ $enfoque['titulo'] }}
                                                    </h3>

                                                    <p
                                                        class="mt-1 text-sm
                                                               leading-6 text-emerald-100"
                                                    >
                                                        {{ $enfoque['texto'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </article>

                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Imagen --}}
                        <div
                            class="relative min-h-[400px] overflow-hidden
                                   border-t border-amber-300/40
                                   lg:min-h-full lg:border-l lg:border-t-0"
                        >
                            <img
                                src="{{ asset('images/enfoque-institucional.png') }}"
                                alt="Innovación y acompañamiento educativo"
                                class="absolute inset-0 h-full w-full object-cover"
                                onerror="this.onerror=null; this.src='{{ asset('images/vision.png') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-r
                                       from-emerald-950/70
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div
                                class="absolute bottom-6 right-6 rounded-2xl
                                       border border-amber-300
                                       bg-emerald-950/90 px-5 py-4
                                       text-white backdrop-blur"
                            >
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.16em] text-amber-300"
                                >
                                    Compromiso educativo
                                </p>

                                <p class="mt-1 font-extrabold">
                                    Aprender · Innovar · Mejorar
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</x-public-layout>