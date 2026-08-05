<x-public-layout title="Inicio">

    {{-- ========================================================= --}}
    {{-- 1. PORTADA INSTITUCIONAL --}}
    {{-- ========================================================= --}}
    <section
        class="relative isolate overflow-hidden bg-white"
        aria-labelledby="titulo-portada">
        <div class="pointer-events-none absolute -left-40 -top-32 h-[520px] w-[520px] rounded-full bg-amber-100/60 blur-3xl"></div>
        <div class="pointer-events-none absolute left-[38%] top-1/3 h-80 w-80 rounded-full bg-emerald-100/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-[1800px]">

            <div class="grid min-h-[680px] lg:grid-cols-[0.95fr_1.05fr]">

                {{-- Contenido --}}
                <div class="relative z-20 flex items-center px-6 py-20 sm:px-10 lg:px-16 xl:px-24">
                    <div class="max-w-3xl">

                        <div class="inline-flex items-center gap-3 text-xs font-extrabold uppercase tracking-[0.24em] text-emerald-900 sm:text-sm">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-amber-300 bg-amber-50 text-amber-700 shadow-sm">
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M3 21h18" />
                                    <path d="M5 21V9l7-4 7 4v12" />
                                    <path d="M9 13h2v3H9zM13 13h2v3h-2z" />
                                </svg>
                            </span>

                            Portal institucional
                        </div>

                        <h1
                            id="titulo-portada"
                            class="mt-8 font-serif text-5xl font-semibold leading-[0.98] tracking-[-0.04em] text-emerald-950 sm:text-6xl lg:text-7xl xl:text-[92px]">
                            Institución
                            <span class="block">Educativa</span>
                        </h1>

                        <p class="mt-5 font-serif text-3xl font-medium leading-tight text-amber-700 sm:text-4xl lg:text-5xl">
                            Crl. José Joaquín Inclán
                        </p>

                        <div class="mt-10 flex items-center gap-4">
                            <span class="h-px w-24 bg-amber-400"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-700"></span>
                            <span class="h-px w-14 bg-amber-400"></span>
                        </div>

                        <p class="mt-9 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl sm:leading-9">
                            Información, comunicación, trámites y servicios digitales
                            para estudiantes, padres de familia, docentes y toda nuestra
                            comunidad educativa.
                        </p>
                    </div>
                </div>

                {{-- Fotografía --}}
                <div class="relative min-h-[520px] overflow-hidden lg:min-h-[680px]">
                    <img
                        src="{{ asset('images/portada-institucion.jpg') }}"
                        alt="Fachada de la IE Crl. José Joaquín Inclán"
                        class="absolute inset-0 h-full w-full object-cover object-center">

                    <div class="absolute inset-y-0 left-0 hidden w-56 bg-gradient-to-r from-white via-white/80 to-transparent lg:block"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/20 via-transparent to-transparent"></div>
                    <div class="absolute left-0 top-0 h-full w-32 bg-gradient-to-r from-white/80 to-transparent"></div>
                </div>
            </div>

            {{-- Franja institucional --}}
            <div class="relative z-40 flex min-h-[86px] items-center justify-center border-t-4 border-amber-400 bg-emerald-950 px-6 text-center">
                <p class="font-serif text-lg font-semibold uppercase tracking-[0.32em] text-amber-300 sm:text-xl lg:text-2xl">
                    Dios · Patria · Cultura
                </p>
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 2. BÚSQUEDA RÁPIDA --}}
    {{-- ========================================================= --}}
    <section id="busqueda-rapida" class="relative overflow-hidden bg-gray-50 py-20">

        <div class="pointer-events-none absolute -left-24 top-0 h-72 w-72 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div class="relative w-full px-4 sm:px-6 lg:px-10">

            <div class="w-full rounded-[32px] border border-amber-200 bg-white px-6 py-12 shadow-2xl shadow-emerald-950/10 sm:px-10 lg:px-14">

                <div class="mx-auto max-w-4xl text-center">

                    <p class="text-sm font-bold uppercase tracking-[0.22em] text-amber-600">
                        Encuentra lo que necesitas
                    </p>

                    <h2 class="mt-3 text-3xl font-extrabold text-emerald-950 sm:text-4xl">
                        Búsqueda rápida
                    </h2>

                    <p class="mx-auto mt-4 max-w-3xl text-gray-600">
                        Busca información institucional, documentos, noticias,
                        comunicados y convocatorias.
                    </p>

                </div>

                <form
                    action="{{ route('buscar') }}"
                    method="GET"
                    class="mt-10 flex w-full flex-col gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-3 sm:flex-row">
                    <div class="relative flex-1">

                        <svg
                            class="absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-emerald-700"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-3.5-3.5" />
                        </svg>

                        <input
                            type="search"
                            name="q"
                            minlength="2"
                            required
                            placeholder="Escribe una palabra clave..."
                            class="h-14 w-full rounded-xl border-0 bg-white pl-14 pr-4 text-sm shadow-sm focus:ring-2 focus:ring-amber-400">

                    </div>

                    <button
                        type="submit"
                        class="inline-flex h-14 items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-10 font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900">
                        Buscar
                    </button>

                </form>
            </div>
        </div>
    </section>


    {{-- Separador superior --}}
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-4 py-4">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent via-amber-300/80 to-amber-300"></span>
                <span class="h-2.5 w-2.5 rounded-full border border-amber-300 bg-emerald-700"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent via-amber-300/80 to-amber-300"></span>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- 3. SALUDO DEL DIRECTOR --}}
    {{-- ========================================================= --}}
    @php
    $saludoDirector = $informacionInstitucional->get('saludo_director');
    @endphp

    <section id="saludo-director" class="relative overflow-hidden bg-white py-24">
        <div class="pointer-events-none absolute -left-24 bottom-0 h-96 w-96 rounded-full bg-emerald-200/25 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 top-0 h-96 w-96 rounded-full bg-amber-200/35 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:items-center lg:px-8">

            <div class="relative mx-auto w-full max-w-md">
                <div class="absolute -inset-4 rounded-[36px] border border-amber-300"></div>

                <div class="relative overflow-hidden rounded-[32px] bg-emerald-950 shadow-2xl">
                    <img
                        src="{{ asset('images/director.jpeg') }}"
                        alt="Director de la IE Crl. José Joaquín Inclán"
                        class="h-[520px] w-full object-cover object-top"
                        onerror="this.src='{{ asset('images/personal-default.jpg') }}'">

                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-emerald-950 via-emerald-950/85 to-transparent p-7 pt-24 text-white">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-300">
                            Dirección institucional
                        </p>

                        <h3 class="mt-2 text-2xl font-extrabold">
                            {{ $saludoDirector->titulo ?? 'Director de la institución' }}
                        </h3>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-sm font-bold uppercase tracking-[0.22em] text-amber-600">
                    Mensaje institucional
                </p>

                <h2 class="mt-3 font-serif text-4xl font-semibold leading-tight text-emerald-950 sm:text-5xl">
                    Saludo del director
                </h2>

                <div class="mt-5 flex items-center gap-3">
                    <span class="h-px w-20 bg-amber-400"></span>
                    <span class="h-2 w-2 rounded-full bg-emerald-700"></span>
                </div>

                <div class="relative mt-8 rounded-3xl border border-gray-100 bg-gray-50 p-7 shadow-sm sm:p-9">
                    <span class="absolute left-5 top-2 font-serif text-7xl leading-none text-amber-300">“</span>

                    <p class="relative z-10 whitespace-pre-line text-lg leading-8 text-gray-600">
                        {{ $saludoDirector->contenido
                            ?? 'Reciban una cordial bienvenida al portal institucional de la IE Crl. José Joaquín Inclán. Este espacio ha sido creado para fortalecer la comunicación, acercar nuestros servicios y compartir el trabajo que realizamos en favor de la formación integral de nuestros estudiantes.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- Separador inferior --}}
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-4 py-4">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent via-amber-300/80 to-amber-300"></span>
                <span class="h-2.5 w-2.5 rounded-full border border-amber-300 bg-emerald-700"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent via-amber-300/80 to-amber-300"></span>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MISIÓN, VISIÓN Y VALORES --}}
    {{-- ========================================================= --}}
    <section
        id="mision-vision-valores"
        class="relative overflow-hidden bg-gray-50 py-24">
        {{-- Decoración --}}
        <div class="pointer-events-none absolute -left-28 top-0 h-96 w-96 rounded-full bg-amber-100/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-28 bottom-0 h-96 w-96 rounded-full bg-emerald-100/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-amber-600">
                    Nuestra identidad
                </p>

                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                    Misión, visión y valores
                </h2>

                <div class="mx-auto mt-5 flex w-fit items-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-10 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Principios que orientan la formación integral, ética y académica
                    de nuestra comunidad educativa.
                </p>
            </div>

            {{-- Tarjetas --}}
            <div class="mt-14 grid gap-8 lg:grid-cols-3">

                {{-- Misión --}}
                <article class="group flex h-full flex-col overflow-hidden rounded-[32px] border border-amber-200 bg-white shadow-xl shadow-emerald-950/10 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ asset('images/mision.png') }}"
                            alt="Misión institucional"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'">

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/20 to-transparent"></div>

                        <div class="absolute bottom-5 left-5 flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-amber-300 bg-emerald-950 text-white shadow-lg">
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7l7-4z" />
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
                            </div>

                            <h3 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                                Misión
                            </h3>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-7">
                        <p class="text-base leading-7 text-gray-600">
                            Brindar un servicio educativo de calidad mediante procesos
                            permanentes de mejora continua, aplicando un modelo pedagógico
                            <strong class="text-emerald-900">
                                Socio Constructivista Humanista
                            </strong>.
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Aprendizaje significativo y pensamiento crítico.
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Formación integral e inclusiva.
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Uso de tecnología e infraestructura moderna.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Visión --}}
                <article class="group flex h-full flex-col overflow-hidden rounded-[32px] border border-amber-200 bg-white shadow-xl shadow-emerald-950/10 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ asset('images/vision.png') }}"
                            alt="Visión institucional"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                            onerror="this.src='{{ asset('images/infraestructura-biblioteca.jpg') }}'">

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/20 to-transparent"></div>

                        <div class="absolute bottom-5 left-5 flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-amber-300 bg-emerald-950 text-white shadow-lg">
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z" />
                                    <circle cx="12" cy="12" r="2.5" />
                                </svg>
                            </div>

                            <h3 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                                Visión
                            </h3>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-7">
                        <p class="text-base leading-7 text-gray-600">
                            Consolidarnos como una institución educativa de calidad,
                            moderna, reconocida e integrada al sistema educativo nacional,
                            alineada con la visión del
                            <strong class="text-emerald-900">
                                Sector Defensa
                            </strong>.
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Educación moderna y de calidad.
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Reconocimiento e integración nacional.
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>

                                <p class="text-sm leading-6 text-gray-600">
                                    Formación ética, cívica y patriótica.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Valores --}}
                <article class="group flex h-full flex-col overflow-hidden rounded-[32px] border border-amber-200 bg-white shadow-xl shadow-emerald-950/10 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ asset('images/valores.png') }}"
                            alt="Valores institucionales"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                            onerror="this.src='{{ asset('images/servicio-toece.jpg') }}'">

                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/20 to-transparent"></div>

                        <div class="absolute bottom-5 left-5 flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-amber-300 bg-emerald-950 text-white shadow-lg">
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M12 17.3l-6.16 3.24 1.18-6.88L2 8.76l6.92-1L12 1.5l3.08 6.26 6.92 1-5.02 4.9 1.18 6.88z" />
                                </svg>
                            </div>

                            <h3 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                                Valores
                            </h3>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-7">
                        <p class="text-base leading-7 text-gray-600">
                            Promovemos valores que fortalecen la convivencia, el servicio
                            y la excelencia, formando ciudadanos responsables y
                            comprometidos con su comunidad.
                        </p>

                        @php
                        $valoresInstitucionales = [
                        [
                        'nombre' => 'Vocación de servicio',
                        'icono' => 'corazon',
                        ],
                        [
                        'nombre' => 'Disciplina',
                        'icono' => 'libro',
                        ],
                        [
                        'nombre' => 'Integridad',
                        'icono' => 'escudo',
                        ],
                        [
                        'nombre' => 'Compromiso',
                        'icono' => 'manos',
                        ],
                        [
                        'nombre' => 'Responsabilidad',
                        'icono' => 'check',
                        ],
                        [
                        'nombre' => 'Excelencia',
                        'icono' => 'estrella',
                        ],
                        ];
                        @endphp

                        <div class="mt-7 grid gap-3">
                            @foreach ($valoresInstitucionales as $valor)
                            <div
                                class="group/valor flex min-h-[58px] w-full min-w-0 items-center
                                       gap-3 rounded-2xl border border-amber-200 bg-white
                                       px-4 py-2.5 shadow-sm transition
                                       hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center
                                           rounded-xl bg-emerald-950 text-white">
                                    @switch($valor['icono'])

                                    @case('corazon')
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z" />
                                    </svg>
                                    @break

                                    @case('libro')
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5z" />
                                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5z" />
                                    </svg>
                                    @break

                                    @case('escudo')
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7z" />
                                    </svg>
                                    @break

                                    @case('manos')
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="m8 12 3 3 5-5" />
                                        <path d="M3 7h4l3 3M21 7h-4l-3 3" />
                                        <path d="M5 17h4l3-3 3 3h4" />
                                    </svg>
                                    @break

                                    @case('check')
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="m8 12 2.5 2.5L16 9" />
                                    </svg>
                                    @break

                                    @default
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path d="m12 17.27-5.18 3.05 1.39-5.92L3.5 10.24l6.1-.52L12 4.1l2.4 5.62 6.1.52-4.71 4.16 1.39 5.92z" />
                                    </svg>

                                    @endswitch
                                </span>

                                <p class="min-w-0 text-sm font-extrabold leading-5 text-emerald-950">
                                    {{ $valor['nombre'] }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </div>

            {{-- Enfoque institucional --}}
            <div class="mt-14 overflow-hidden rounded-[36px] border border-amber-300 bg-emerald-950 shadow-2xl shadow-emerald-950/15">

                <div class="grid lg:grid-cols-[1.1fr_0.9fr]">

                    {{-- Contenido --}}
                    <div class="relative flex items-center p-8 sm:p-10 lg:p-12">
                        <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-emerald-700/25 blur-3xl"></div>
                        <div class="pointer-events-none absolute bottom-0 right-0 h-56 w-56 rounded-full bg-amber-300/10 blur-3xl"></div>

                        <div class="relative">
                            <div class="inline-flex items-center gap-3">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl border border-amber-300 bg-emerald-900 text-white">
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M4 19h16" />
                                        <path d="M5 15V7l7-4 7 4v8" />
                                        <path d="M9 11h.01M12 11h.01M15 11h.01" />
                                    </svg>
                                </span>

                                <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-amber-300 sm:text-sm">
                                    Enfoque institucional actual
                                </p>
                            </div>

                            <h3 class="mt-6 max-w-2xl text-3xl font-extrabold leading-[1.15] tracking-tight text-white sm:text-4xl">
                                Innovación, acompañamiento y mejora continua
                            </h3>

                            <div class="mt-5 flex items-center gap-3">
                                <span class="h-px w-20 bg-amber-400"></span>
                                <span class="h-2 w-2 rounded-full bg-white"></span>
                            </div>

                            <p class="mt-7 max-w-3xl text-base leading-8 text-emerald-50 sm:text-lg">
                                La institución fortalece sus procesos educativos mediante
                                tecnologías de la información y comunicación, estrategias de
                                evaluación formativa y acompañamiento docente, con el propósito
                                de garantizar una educación inclusiva, equitativa y de calidad.
                            </p>

                            <div class="mt-8 grid gap-3 sm:grid-cols-2">

                                <div class="group rounded-2xl border border-amber-300/25 bg-white/[0.07] p-4 backdrop-blur-sm transition hover:border-amber-300/60 hover:bg-white/10">
                                    <p class="text-sm font-extrabold text-white">
                                        Tecnologías educativas
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-emerald-100">
                                        Incorporación de TIC para fortalecer los aprendizajes.
                                    </p>
                                </div>

                                <div class="group rounded-2xl border border-amber-300/25 bg-white/[0.07] p-4 backdrop-blur-sm transition hover:border-amber-300/60 hover:bg-white/10">
                                    <p class="text-sm font-extrabold text-white">
                                        Evaluación formativa
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-emerald-100">
                                        Seguimiento y retroalimentación permanente.
                                    </p>
                                </div>

                                <div class="group rounded-2xl border border-amber-300/25 bg-white/[0.07] p-4 backdrop-blur-sm transition hover:border-amber-300/60 hover:bg-white/10">
                                    <p class="text-sm font-extrabold text-white">
                                        Acompañamiento docente
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-emerald-100">
                                        Mejora continua de la práctica pedagógica.
                                    </p>
                                </div>

                                <div class="group rounded-2xl border border-amber-300/25 bg-white/[0.07] p-4 backdrop-blur-sm transition hover:border-amber-300/60 hover:bg-white/10">
                                    <p class="text-sm font-extrabold text-white">
                                        Educación inclusiva
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-emerald-100">
                                        Atención equitativa y formación integral.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Imagen --}}
                    <div class="relative min-h-[380px] overflow-hidden lg:min-h-full">

                        <img
                            src="{{ asset('images/enfoque-institucional.png') }}"
                            alt="Innovación y acompañamiento educativo"
                            class="absolute inset-0 h-full w-full object-cover"
                            onerror="this.src='{{ asset('images/vision.png') }}'">

                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/80 via-emerald-950/20 to-transparent"></div>

                        <div class="absolute bottom-6 right-6 rounded-2xl border border-amber-300 bg-emerald-950/85 px-5 py-4 text-white backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.17em] text-amber-300">
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


    {{-- ========================================================= --}}
    {{-- 5. SERVICIOS COMPLEMENTARIOS --}}
    {{-- ========================================================= --}}
    <section
        id="servicios-complementarios"
        class="relative overflow-hidden bg-white py-24">
        {{-- Fondos decorativos --}}
        <div
            class="pointer-events-none absolute -left-24 top-0 h-96 w-96
               rounded-full bg-emerald-200/25 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96
               rounded-full bg-amber-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">
                    Bienestar estudiantil
                </p>

                <h2 class="mt-3 text-4xl font-extrabold text-emerald-950 sm:text-5xl">
                    Servicios complementarios
                </h2>

                <div class="mx-auto mt-5 flex w-fit items-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-5 text-lg leading-8 text-gray-600">
                    Atención, orientación y acompañamiento para el bienestar integral
                    de nuestros estudiantes.
                </p>
            </div>

            {{-- Datos de los servicios --}}
            @php
            $serviciosComplementarios = [
            [
            'imagen' => 'servicio-topico.jpeg',
            'titulo' => 'Tópico',
            'slug' => 'topico',
            'subtitulo' => 'Salud y primeros auxilios',
            'descripcion' => 'Atención y cuidado básico de la salud para nuestra comunidad educativa.',
            ],
            [
            'imagen' => 'servicio-toece.jpeg',
            'titulo' => 'TOECE',
            'slug' => 'toece',
            'subtitulo' => 'Tutoría y convivencia escolar',
            'descripcion' => 'Orientación educativa, convivencia escolar y acompañamiento a estudiantes.',
            ],
            [
            'imagen' => 'servicio-psicologia.jpeg',
            'titulo' => 'Psicología',
            'slug' => 'psicologia',
            'subtitulo' => 'Bienestar socioemocional',
            'descripcion' => 'Acompañamiento emocional, familiar y personal para nuestra comunidad.',
            ],
            ];
            @endphp

            {{-- Tarjetas --}}
            <div class="mt-12 grid gap-7 md:grid-cols-3">

                @foreach ($serviciosComplementarios as $servicio)

                <article
                    class="group flex h-full flex-col overflow-hidden rounded-[30px]
                           border border-amber-200 bg-white
                           shadow-xl shadow-emerald-950/10
                           transition duration-300
                           hover:-translate-y-2 hover:shadow-2xl">
                    {{-- Imagen --}}
                    <div class="relative h-72 overflow-hidden bg-gray-100">

                        <img
                            src="{{ asset('images/' . $servicio['imagen']) }}"
                            alt="Imagen del servicio {{ $servicio['titulo'] }}"
                            class="h-full w-full object-cover object-center
                                   transition duration-700
                                   group-hover:scale-105"
                            loading="lazy">

                        {{-- Degradado suave --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t
                                   from-emerald-950/55
                                   via-emerald-950/5
                                   to-transparent"></div>

                        {{-- Etiqueta superior --}}
                        <div class="absolute left-5 top-5 right-5">

                            <span
                                class="inline-flex max-w-full rounded-full
                                       border border-amber-300
                                       bg-emerald-950/90
                                       px-4 py-2
                                       text-[11px] font-extrabold uppercase
                                       tracking-[0.12em] text-white
                                       backdrop-blur-sm sm:text-xs">
                                {{ $servicio['subtitulo'] }}
                            </span>

                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="relative flex flex-1 flex-col bg-white p-7">

                        {{-- Triángulo decorativo --}}
                        <div
                            class="absolute -top-5 left-7
                                   h-10 w-10 rotate-45
                                   border-l border-t border-amber-300
                                   bg-white"></div>

                        <h3 class="text-2xl font-extrabold text-emerald-950">
                            {{ $servicio['titulo'] }}
                        </h3>

                        <div class="mt-4 flex items-center gap-2">
                            <span class="h-px w-12 bg-amber-400"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-700"></span>
                        </div>

                        <p class="mt-5 flex-1 text-sm leading-7 text-gray-600">
                            {{ $servicio['descripcion'] }}
                        </p>

                        {{-- Enlace --}}
                        <div class="mt-6 border-t border-gray-100 pt-5">

                            <a
                                href="{{ route('servicios.mostrar', [
                                    'servicio' => $servicio['slug']
                                ]) }}"
                                class="group/enlace inline-flex items-center gap-2
                                       text-sm font-extrabold text-emerald-800
                                       transition hover:text-emerald-950">
                                Ver servicio y galería

                                <svg
                                    class="h-4 w-4 transition
                                           group-hover/enlace:translate-x-1"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M5 12h14" />
                                    <path d="m13 6 6 6-6 6" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </article>

                @endforeach
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 6. CALENDARIO INSTITUCIONAL --}}
    {{-- ========================================================= --}}
    <section id="calendario" class="relative overflow-hidden bg-gray-50 py-24">

        {{-- Fondos decorativos --}}
        <div
            class="pointer-events-none absolute -left-24 top-10 h-80 w-80
               rounded-full bg-amber-200/30 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96
               rounded-full bg-emerald-200/30 blur-3xl"></div>

        @php
        /*
        |--------------------------------------------------------------------------
        | DATOS PRINCIPALES DEL CALENDARIO
        |--------------------------------------------------------------------------
        */

        $fechaCalendario = now();

        $inicioMes = $fechaCalendario->copy()->startOfMonth();
        $finMes = $fechaCalendario->copy()->endOfMonth();

        $espaciosIniciales = $inicioMes->dayOfWeekIso - 1;
        $totalCeldas = $espaciosIniciales + $finMes->day;
        $totalSemanas = (int) ceil($totalCeldas / 7);

        /*
        |--------------------------------------------------------------------------
        | ACTIVIDADES INTERNAS DE LA INSTITUCIÓN
        |--------------------------------------------------------------------------
        |
        | Posteriormente estas actividades podrán venir desde la base de datos.
        |
        */

        $actividadesInstitucionales = collect([
        [
        'dia' => 3,
        'mes' => $fechaCalendario->month,
        'titulo' => 'Jornada académica',
        'tipo' => 'Académico',
        'descripcion' => 'Actividad de planificación y fortalecimiento pedagógico.',
        ],
        [
        'dia' => 24,
        'mes' => $fechaCalendario->month,
        'titulo' => 'Actividad institucional',
        'tipo' => 'Institucional',
        'descripcion' => 'Actividad organizada por la comunidad educativa.',
        ],
        [
        'dia' => 29,
        'mes' => $fechaCalendario->month,
        'titulo' => 'Reunión con padres de familia',
        'tipo' => 'Reunión',
        'descripcion' => 'Reunión informativa con madres, padres y apoderados.',
        ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | EFEMÉRIDES Y CELEBRACIONES ANUALES
        |--------------------------------------------------------------------------
        */

        $efemeridesAnuales = collect([
        [
        'dia' => 1,
        'mes' => 5,
        'titulo' => 'Día del Trabajo',
        'tipo' => 'Celebración',
        'descripcion' => 'Conmemoración del Día Internacional de los Trabajadores.',
        ],
        [
        'dia' => 2,
        'mes' => 5,
        'titulo' => 'Combate del Dos de Mayo',
        'tipo' => 'Efeméride',
        'descripcion' => 'Conmemoración histórica del Combate del Dos de Mayo.',
        ],
        [
        'dia' => 7,
        'mes' => 6,
        'titulo' => 'Día de la Bandera',
        'tipo' => 'Efeméride',
        'descripcion' => 'Conmemoración de la Bandera Nacional y la Batalla de Arica.',
        ],
        [
        'dia' => 24,
        'mes' => 6,
        'titulo' => 'Día del Campesino',
        'tipo' => 'Celebración',
        'descripcion' => 'Reconocimiento a las comunidades campesinas del país.',
        ],
        [
        'dia' => 6,
        'mes' => 7,
        'titulo' => 'Día del Maestro',
        'tipo' => 'Celebración',
        'descripcion' => 'Reconocimiento a la labor de los docentes.',
        ],
        [
        'dia' => 28,
        'mes' => 7,
        'titulo' => 'Fiestas Patrias',
        'tipo' => 'Efeméride',
        'descripcion' => 'Conmemoración de la Independencia del Perú.',
        ],
        [
        'dia' => 29,
        'mes' => 7,
        'titulo' => 'Celebración de Fiestas Patrias',
        'tipo' => 'Efeméride',
        'descripcion' => 'Segundo día de celebraciones por la Independencia del Perú.',
        ],
        [
        'dia' => 30,
        'mes' => 8,
        'titulo' => 'Santa Rosa de Lima',
        'tipo' => 'Celebración',
        'descripcion' => 'Celebración nacional en honor a Santa Rosa de Lima.',
        ],
        [
        'dia' => 23,
        'mes' => 9,
        'titulo' => 'Día del Estudiante',
        'tipo' => 'Celebración',
        'descripcion' => 'Celebración dedicada a los estudiantes.',
        ],
        [
        'dia' => 23,
        'mes' => 9,
        'titulo' => 'Día de la Primavera',
        'tipo' => 'Celebración',
        'descripcion' => 'Inicio de la primavera y actividades de integración.',
        ],
        [
        'dia' => 8,
        'mes' => 10,
        'titulo' => 'Combate de Angamos',
        'tipo' => 'Efeméride',
        'descripcion' => 'Conmemoración del Combate de Angamos.',
        ],
        [
        'dia' => 31,
        'mes' => 10,
        'titulo' => 'Día de la Canción Criolla',
        'tipo' => 'Celebración',
        'descripcion' => 'Celebración de la música y cultura criolla peruana.',
        ],
        [
        'dia' => 20,
        'mes' => 11,
        'titulo' => 'Día de los Derechos del Niño',
        'tipo' => 'Celebración',
        'descripcion' => 'Jornada de reflexión sobre los derechos de niñas y niños.',
        ],
        [
        'dia' => 9,
        'mes' => 12,
        'titulo' => 'Batalla de Ayacucho',
        'tipo' => 'Efeméride',
        'descripcion' => 'Conmemoración de la Batalla de Ayacucho.',
        ],
        [
        'dia' => 25,
        'mes' => 12,
        'titulo' => 'Navidad',
        'tipo' => 'Celebración',
        'descripcion' => 'Celebración navideña de la comunidad educativa.',
        ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTRAR LOS EVENTOS DEL MES ACTUAL
        |--------------------------------------------------------------------------
        */

        $efemeridesDelMes = $efemeridesAnuales
        ->filter(function ($evento) use ($fechaCalendario) {
        return $evento['mes'] === $fechaCalendario->month;
        });

        $actividadesDelMes = $actividadesInstitucionales
        ->filter(function ($evento) use ($fechaCalendario) {
        return $evento['mes'] === $fechaCalendario->month;
        });

        $eventosCalendario = $efemeridesDelMes
        ->merge($actividadesDelMes)
        ->sortBy([
        ['dia', 'asc'],
        ['titulo', 'asc'],
        ])
        ->values();

        /*
        |--------------------------------------------------------------------------
        | AGRUPAR EVENTOS POR DÍA
        |--------------------------------------------------------------------------
        */

        $eventosPorDia = $eventosCalendario->groupBy('dia');

        /*
        |--------------------------------------------------------------------------
        | ESTILOS SEGÚN EL TIPO DE EVENTO
        |--------------------------------------------------------------------------
        */

        $estilosEventos = [
        'Institucional' => [
        'punto' => 'bg-emerald-600',
        'etiqueta' => 'bg-emerald-50 text-emerald-800 border-emerald-100',
        'agenda' => 'bg-emerald-500',
        'icono' => 'bg-emerald-100 text-emerald-900',
        ],

        'Académico' => [
        'punto' => 'bg-sky-500',
        'etiqueta' => 'bg-sky-50 text-sky-800 border-sky-100',
        'agenda' => 'bg-sky-400',
        'icono' => 'bg-sky-100 text-sky-900',
        ],

        'Reunión' => [
        'punto' => 'bg-violet-500',
        'etiqueta' => 'bg-violet-50 text-violet-800 border-violet-100',
        'agenda' => 'bg-violet-400',
        'icono' => 'bg-violet-100 text-violet-900',
        ],

        'Celebración' => [
        'punto' => 'bg-amber-500',
        'etiqueta' => 'bg-amber-50 text-amber-800 border-amber-200',
        'agenda' => 'bg-amber-400',
        'icono' => 'bg-amber-300 text-emerald-950',
        ],

        'Efeméride' => [
        'punto' => 'bg-rose-500',
        'etiqueta' => 'bg-rose-50 text-rose-800 border-rose-100',
        'agenda' => 'bg-rose-400',
        'icono' => 'bg-rose-100 text-rose-900',
        ],
        ];
        @endphp

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-amber-600">
                        Fechas importantes
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                        Calendario institucional
                    </h2>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-600">
                        Consulta actividades académicas, reuniones, ceremonias,
                        celebraciones y fechas importantes.
                    </p>
                </div>

                {{-- Mes actual --}}
                <div
                    class="inline-flex items-center gap-4 self-start rounded-2xl
                       border border-amber-200 bg-white px-5 py-4 shadow-sm
                       lg:self-auto">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-xl
                           bg-emerald-950 text-white">
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="16" rx="3" />
                            <path d="M8 3v4M16 3v4M3 10h18" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                            Mes actual
                        </p>

                        <p class="mt-1 text-lg font-extrabold capitalize text-emerald-950">
                            {{ $fechaCalendario->locale('es')->translatedFormat('F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Leyenda --}}
            <div class="mt-8 flex flex-wrap gap-3">

                @foreach (['Institucional', 'Académico', 'Reunión', 'Celebración', 'Efeméride'] as $tipoEvento)

                <div
                    class="inline-flex items-center gap-2 rounded-full border border-gray-200
                           bg-white px-3 py-2 text-xs font-bold text-gray-700 shadow-sm">
                    <span class="h-2.5 w-2.5 rounded-full {{ $estilosEventos[$tipoEvento]['punto'] }}"></span>

                    {{ $tipoEvento }}
                </div>

                @endforeach
            </div>

            {{-- Calendario y agenda --}}
            <div class="mt-10 grid gap-8 lg:grid-cols-[1.45fr_0.55fr]">

                {{-- Calendario --}}
                <div
                    class="overflow-hidden rounded-[30px] border border-gray-100
                       bg-white shadow-xl shadow-emerald-950/10">
                    {{-- Días de la semana --}}
                    <div
                        class="grid grid-cols-7 bg-emerald-950 text-center
                           text-xs font-bold uppercase tracking-wider text-white">
                        @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $diaSemana)
                        <div class="px-2 py-4">
                            {{ $diaSemana }}
                        </div>
                        @endforeach
                    </div>

                    {{-- Días del mes --}}
                    <div class="grid grid-cols-7">

                        @for ($celda = 0; $celda < $totalSemanas * 7; $celda++)

                            @php
                            $numeroDia=$celda - $espaciosIniciales + 1;

                            $esDiaValido=$numeroDia>= 1 &&
                            $numeroDia <= $finMes->day;

                                $esHoy =
                                $esDiaValido &&
                                $numeroDia === $fechaCalendario->day;

                                $eventosDelDia = $esDiaValido
                                ? $eventosPorDia->get($numeroDia, collect())
                                : collect();
                                @endphp

                                <div
                                    class="min-h-32 border-b border-r border-gray-100 p-2.5
                                   transition hover:bg-gray-50
                                   {{ $esDiaValido ? 'bg-white' : 'bg-gray-50/70' }}">
                                    @if ($esDiaValido)

                                    {{-- Número del día --}}
                                    <div class="flex items-start justify-between gap-2">

                                        <span
                                            class="flex h-8 w-8 items-center justify-center
                                               rounded-full text-sm font-extrabold
                                               {{ $esHoy
                                                   ? 'bg-amber-400 text-emerald-950 shadow-md'
                                                   : 'text-gray-700'
                                               }}">
                                            {{ $numeroDia }}
                                        </span>

                                        @if ($eventosDelDia->isNotEmpty())
                                        <div class="flex items-center gap-1">

                                            @foreach ($eventosDelDia->take(3) as $evento)
                                            <span
                                                class="h-2.5 w-2.5 rounded-full
                                                           {{ $estilosEventos[$evento['tipo']]['punto'] }}"></span>
                                            @endforeach

                                        </div>
                                        @endif
                                    </div>

                                    {{-- Eventos del día --}}
                                    @if ($eventosDelDia->isNotEmpty())

                                    <div class="mt-2 space-y-1.5">

                                        @foreach ($eventosDelDia->take(2) as $evento)

                                        <div
                                            class="rounded-lg border px-2 py-1.5
                                                       text-[10px] font-bold leading-4
                                                       {{ $estilosEventos[$evento['tipo']]['etiqueta'] }}"
                                            title="{{ $evento['descripcion'] }}">
                                            {{ $evento['titulo'] }}
                                        </div>

                                        @endforeach

                                        @if ($eventosDelDia->count() > 2)
                                        <p class="px-1 text-[10px] font-bold text-gray-500">
                                            + {{ $eventosDelDia->count() - 2 }} actividad(es)
                                        </p>
                                        @endif
                                    </div>

                                    @endif
                                    @endif
                                </div>

                                @endfor
                    </div>
                </div>

                {{-- Agenda lateral --}}
                <aside
                    class="relative overflow-hidden rounded-[30px]
                       border-2 border-amber-400 bg-emerald-950
                       p-7 text-white shadow-xl">
                    {{-- Decoración --}}
                    <div
                        class="pointer-events-none absolute -right-20 -top-20
                           h-48 w-48 rounded-full bg-emerald-700/40 blur-3xl"></div>

                    <div class="relative">

                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-300">
                            Actividades del mes
                        </p>

                        <h3 class="mt-3 text-2xl font-extrabold">
                            Agenda institucional
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-emerald-100">
                            Efemérides, celebraciones y actividades programadas.
                        </p>

                        <div class="mt-7 max-h-[560px] space-y-4 overflow-y-auto pr-1">

                            @forelse ($eventosCalendario as $evento)

                            <article
                                class="group rounded-2xl border border-white/10
                                       bg-white/10 p-4 transition
                                       hover:-translate-y-0.5 hover:bg-white/15">
                                <div class="flex items-start gap-3">

                                    {{-- Día --}}
                                    <div
                                        class="flex h-14 w-14 shrink-0 flex-col
                                               items-center justify-center rounded-xl
                                               {{ $estilosEventos[$evento['tipo']]['icono'] }}">
                                        <span class="text-lg font-extrabold leading-none">
                                            {{ $evento['dia'] }}
                                        </span>

                                        <span class="mt-1 text-[9px] font-extrabold uppercase">
                                            {{ $fechaCalendario->locale('es')->translatedFormat('M') }}
                                        </span>
                                    </div>

                                    {{-- Información --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-center gap-2">
                                            <span
                                                class="h-2 w-2 rounded-full
                                                       {{ $estilosEventos[$evento['tipo']]['agenda'] }}"></span>

                                            <p
                                                class="text-[11px] font-extrabold uppercase
                                                       tracking-wide text-amber-300">
                                                {{ $evento['tipo'] }}
                                            </p>
                                        </div>

                                        <h4 class="mt-1 font-extrabold leading-6 text-white">
                                            {{ $evento['titulo'] }}
                                        </h4>

                                        <p class="mt-1 text-xs leading-5 text-emerald-100">
                                            {{ $evento['descripcion'] }}
                                        </p>
                                    </div>
                                </div>
                            </article>

                            @empty

                            <div
                                class="rounded-2xl border border-dashed border-white/20
                                       bg-white/5 px-5 py-8 text-center">
                                <svg
                                    class="mx-auto h-10 w-10 text-amber-300"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6">
                                    <rect x="3" y="5" width="18" height="16" rx="3" />
                                    <path d="M8 3v4M16 3v4M3 10h18" />
                                </svg>

                                <p class="mt-4 font-extrabold">
                                    No hay actividades registradas
                                </p>

                                <p class="mt-2 text-sm leading-6 text-emerald-100">
                                    Todavía no se han programado actividades para este mes.
                                </p>
                            </div>

                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 7. LOGROS Y RECONOCIMIENTOS --}}
    {{-- ========================================================= --}}
    <section
        id="reconocimientos"
        class="relative overflow-hidden bg-white py-24">
        {{-- Fondos decorativos --}}
        <div
            class="pointer-events-none absolute -left-20 bottom-0 h-80 w-80
               rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-20 top-0 h-80 w-80
               rounded-full bg-amber-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">

                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-amber-600">
                        Excelencia institucional
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-emerald-950 sm:text-5xl">
                        Logros y reconocimientos
                    </h2>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-600">
                        Reconocemos el esfuerzo, la dedicación y los resultados alcanzados
                        por nuestros estudiantes, docentes y la comunidad educativa.
                    </p>
                </div>

                <a
                    href="{{ route('logros.index') }}"
                    class="group inline-flex items-center gap-2 self-start
                       rounded-xl border border-amber-300 bg-white
                       px-5 py-3 text-sm font-extrabold text-emerald-800
                       shadow-sm transition
                       hover:-translate-y-0.5 hover:bg-emerald-950 hover:text-white
                       md:self-auto">
                    Ver todos los logros

                    <svg
                        class="h-4 w-4 transition group-hover:translate-x-1"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="m13 6 6 6-6 6" />
                    </svg>
                </a>
            </div>

            {{-- Tarjetas --}}
            <div class="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($logros as $logro)

                @php
                /*
                |--------------------------------------------------------------------------
                | IMAGEN SEGÚN EL TÍTULO DEL LOGRO
                |--------------------------------------------------------------------------
                |
                | Primero se intenta usar la imagen guardada en la base de datos.
                | Si no existe, se asigna automáticamente una de estas imágenes.
                |
                */

                $imagenesLogros = [
                'Primer puesto en Feria de Ciencia'
                => 'images/logros/logro-feria-ciencia.png',

                'Reconocimiento a la excelencia académica'
                => 'images/logros/logro-excelencia-academica.png',

                'Participación destacada en actividades cívicas'
                => 'images/logros/logro-actividades-civicas.png',
                ];

                $rutaImagenGuardada = $logro->imagen;

                if (
                $rutaImagenGuardada &&
                file_exists(public_path($rutaImagenGuardada))
                ) {
                $imagenLogro = asset($rutaImagenGuardada);
                } elseif (
                isset($imagenesLogros[$logro->titulo]) &&
                file_exists(public_path($imagenesLogros[$logro->titulo]))
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
                           hover:shadow-[0_24px_65px_rgba(6,78,59,0.15)]">
                    {{-- Imagen --}}
                    <div class="relative h-72 overflow-hidden bg-gray-100">

                        <img
                            src="{{ $imagenLogro }}"
                            alt="{{ $logro->titulo }}"
                            class="h-full w-full object-cover
                                   transition duration-700
                                   group-hover:scale-105">

                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-emerald-950/85
                                   via-emerald-950/10
                                   to-transparent"></div>

                        {{-- Tipo --}}
                        <div class="absolute left-5 top-5">

                            <span
                                class="inline-flex items-center rounded-full
                                       border border-amber-300
                                       bg-emerald-950/90
                                       px-4 py-2
                                       text-[11px] font-extrabold uppercase
                                       tracking-[0.14em] text-white
                                       backdrop-blur-sm">
                                {{ $logro->tipo }}
                            </span>
                        </div>

                        {{-- Fecha sobre la imagen --}}
                        @if ($fechaLogro)
                        <div
                            class="absolute bottom-5 right-5
                                       flex h-16 w-16 flex-col items-center justify-center
                                       rounded-2xl border border-amber-300
                                       bg-white/95 text-emerald-950 shadow-lg">
                            <span class="text-xl font-extrabold leading-none">
                                {{ $fechaLogro->format('d') }}
                            </span>

                            <span class="mt-1 text-[10px] font-extrabold uppercase text-amber-600">
                                {{ $fechaLogro->locale('es')->translatedFormat('M') }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Contenido --}}
                    <div class="flex flex-1 flex-col p-7">

                        @if ($logro->nivel)
                        <div>
                            <span
                                class="inline-flex rounded-full
                                           border border-amber-200 bg-amber-50
                                           px-3 py-1.5
                                           text-[11px] font-extrabold uppercase
                                           tracking-[0.13em] text-amber-700">
                                Nivel {{ $logro->nivel }}
                            </span>
                        </div>
                        @endif

                        <h3
                            class="mt-4 text-2xl font-extrabold
                                   leading-tight text-emerald-950">
                            {{ $logro->titulo }}
                        </h3>

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

                        {{-- Pie --}}
                        <div
                            class="mt-7 flex items-center justify-between gap-4
                                   border-t border-gray-100 pt-5">
                            <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">

                                <svg
                                    class="h-4 w-4 text-amber-600"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="16" rx="3" />
                                    <path d="M8 3v4M16 3v4M3 10h18" />
                                </svg>

                                <span>
                                    {{ $fechaLogro
                                        ? $fechaLogro->format('d/m/Y')
                                        : 'Fecha no especificada'
                                    }}
                                </span>
                            </div>

                            <a
                                href="{{ route('logros.mostrar', $logro->id) }}"
                                class="group/enlace inline-flex items-center gap-2
                                       text-sm font-extrabold text-emerald-800
                                       transition hover:text-emerald-950">
                                Ver detalle

                                <svg
                                    class="h-4 w-4 transition
                                           group-hover/enlace:translate-x-1"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M5 12h14" />
                                    <path d="m13 6 6 6-6 6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>

                @empty

                {{-- Estado vacío --}}
                <div
                    class="md:col-span-2 lg:col-span-3
                           overflow-hidden rounded-[32px]
                           border border-dashed border-amber-300
                           bg-gradient-to-br from-amber-50/70 to-emerald-50/50
                           px-6 py-16 text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center
                               rounded-2xl border border-amber-300
                               bg-emerald-950 text-white shadow-lg">
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7">
                            <path d="M8 4h8v5a4 4 0 0 1-8 0z" />
                            <path d="M6 5H4v2a4 4 0 0 0 4 4M18 5h2v2a4 4 0 0 1-4 4" />
                            <path d="M12 13v4M8 21h8M9 17h6" />
                        </svg>
                    </div>

                    <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                        Próximamente publicaremos nuestros logros
                    </h3>

                    <p class="mx-auto mt-4 max-w-xl text-base leading-7 text-gray-600">
                        Aquí aparecerán los reconocimientos obtenidos por estudiantes,
                        docentes y la institución.
                    </p>
                </div>

                @endforelse
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 8. CHATBOT FLOTANTE --}}
    {{-- ========================================================= --}}
    <div
        x-data="{ abierto: false }"
        class="fixed bottom-5 right-5 z-[60]">
        <div
            x-cloak
            x-show="abierto"
            x-transition
            class="mb-4 w-[calc(100vw-2.5rem)] max-w-sm overflow-hidden rounded-[28px] border border-amber-300 bg-white shadow-2xl shadow-emerald-950/25">
            <div class="flex items-center justify-between bg-emerald-950 px-5 py-4 text-white">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">
                        Asistente virtual
                    </p>

                    <h3 class="mt-1 font-extrabold">
                        Chatbot institucional
                    </h3>
                </div>

                <button
                    type="button"
                    @click="abierto = false"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 hover:bg-white/20"
                    aria-label="Cerrar chatbot">
                    ×
                </button>
            </div>

            <div class="max-h-[440px] overflow-y-auto p-5">
                <div class="rounded-2xl bg-emerald-50 p-4 text-sm leading-6 text-emerald-950">
                    ¡Hola! Soy el asistente virtual de la IE Crl. José Joaquín Inclán.
                    ¿En qué puedo ayudarte?
                </div>

                <div class="mt-4 grid gap-2">
                    @foreach ([
                    ['Consultas institucionales', route('consultas.crear')],
                    ['Mesa de partes virtual', route('mesa-partes.crear')],
                    ['Documentos y formatos', route('documentos.index')],
                    ['Convocatorias vigentes', '/convocatorias'],
                    ['Calendario institucional', '#calendario'],
                    ] as $opcion)
                    <a
                        href="{{ $opcion[1] }}"
                        class="rounded-xl border border-gray-200 px-4 py-3 text-sm font-bold text-gray-700 transition hover:border-amber-300 hover:bg-amber-50 hover:text-emerald-950">
                        {{ $opcion[0] }} →
                    </a>
                    @endforeach
                </div>

                <p class="mt-4 text-xs leading-5 text-gray-500">
                    La conversación automática y las respuestas desde la base de conocimientos se conectarán en la siguiente etapa.
                </p>
            </div>
        </div>

        <button
            type="button"
            @click="abierto = !abierto"
            class="group flex h-16 w-16 items-center justify-center rounded-full border-2 border-amber-400 bg-emerald-950 text-white shadow-xl shadow-emerald-950/30 transition hover:-translate-y-1 hover:bg-emerald-900"
            aria-label="Abrir chatbot institucional">
            <svg
                class="h-7 w-7 text-amber-300"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z" />
                <path d="M8 9h8M8 13h5" />
            </svg>
        </button>
    </div>

</x-public-layout>