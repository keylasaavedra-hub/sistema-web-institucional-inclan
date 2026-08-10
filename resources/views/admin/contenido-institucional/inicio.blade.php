<x-app-layout>

    @php
    $portada = $contenidos->get('portada_inicio');
    $director = $contenidos->get('saludo_director');
    $mision = $contenidos->get('mision');
    $vision = $contenidos->get('vision');
    $valores = $contenidos->get('valores');
    $enfoque = $contenidos->get('enfoque_inicio');

    $listaValores = old(
    'valores_lista',
    implode(
    PHP_EOL,
    $valores?->datos['lista'] ?? [
    'Vocación de servicio',
    'Disciplina',
    'Integridad',
    'Compromiso',
    'Responsabilidad',
    'Excelencia',
    ]
    )
    );
    @endphp

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{-- ENCABEZADO --}}
            {{-- ====================================================== --}}
            <div
                class="relative overflow-hidden rounded-[30px]
                       bg-emerald-950 px-6 py-8
                       shadow-[0_20px_60px_rgba(6,78,59,0.14)]
                       sm:px-8 lg:px-10">
                <div
                    class="pointer-events-none absolute -right-20 -top-20
                           h-64 w-64 rounded-full
                           bg-amber-300/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-14 w-14 shrink-0 items-center
                                   justify-center rounded-2xl
                                   border border-amber-300/40
                                   bg-white/10 text-amber-300">
                            <svg
                                class="h-7 w-7"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M3 21h18" />
                                <path d="M5 21V9l7-4 7 4v12" />
                                <path d="M9 13h2v3H9zM13 13h2v3h-2z" />
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.2em] text-amber-300">
                                Contenido Institucional
                            </p>

                            <h1
                                class="mt-2 text-3xl font-extrabold
                                       tracking-tight text-white">
                                Página de Inicio
                            </h1>

                            <p
                                class="mt-2 max-w-2xl text-sm
                                       leading-6 text-emerald-100">
                                Administra los principales textos e imágenes
                                que se muestran en la portada pública
                                del portal institucional.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('inicio') }}"
                        target="_blank"
                        class="inline-flex h-12 items-center justify-center
                               gap-2 self-start rounded-xl
                               border border-amber-300 bg-white/10
                               px-5 text-sm font-extrabold text-white
                               transition hover:bg-white/20 lg:self-auto">
                        Ver página pública

                        <svg
                            class="h-4 w-4"
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

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
            <div
                class="mt-6 flex items-start gap-3 rounded-2xl
                           border border-emerald-200 bg-emerald-50
                           p-5 text-emerald-800">
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="m8 12 2.5 2.5L16 9" />
                </svg>

                <p class="text-sm font-bold">
                    {{ session('success') }}
                </p>
            </div>
            @endif

            {{-- ERRORES --}}
            @if ($errors->any())
            <div
                class="mt-6 rounded-2xl border border-red-200
                           bg-red-50 p-5">
                <p class="font-extrabold text-red-800">
                    Revisa los siguientes campos:
                </p>

                <ul class="mt-3 space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.contenido-institucional.inicio.actualizar') }}"
                enctype="multipart/form-data"
                class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- ================================================== --}}
                {{-- 1. PORTADA --}}
                {{-- ================================================== --}}
                <section
                    class="overflow-hidden rounded-[28px]
                           border border-gray-200 bg-white
                           shadow-[0_18px_50px_rgba(15,23,42,0.05)]">
                    <div
                        class="flex items-center gap-4 border-b
                               border-gray-100 px-6 py-5 sm:px-8">
                        <div
                            class="flex h-11 w-11 items-center
                                   justify-center rounded-xl
                                   bg-emerald-50 text-emerald-800">
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M3 21h18" />
                                <path d="M5 21V9l7-4 7 4v12" />
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.15em] text-amber-600">
                                Sección 01
                            </p>

                            <h2 class="text-xl font-extrabold text-emerald-950">
                                Portada institucional
                            </h2>
                        </div>
                    </div>

                    <div class="grid gap-7 p-6 sm:p-8 lg:grid-cols-2">

                        <div class="space-y-5">
                            <div>
                                <label
                                    for="portada_titulo"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Título principal
                                </label>

                                <input
                                    id="portada_titulo"
                                    name="portada_titulo"
                                    type="text"
                                    required
                                    value="{{ old(
                                        'portada_titulo',
                                        $portada?->titulo ?? 'Institución Educativa'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>

                            <div>
                                <label
                                    for="portada_subtitulo"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Nombre de la institución
                                </label>

                                <input
                                    id="portada_subtitulo"
                                    name="portada_subtitulo"
                                    type="text"
                                    required
                                    value="{{ old(
                                        'portada_subtitulo',
                                        $portada?->subtitulo
                                            ?? 'Crl. José Joaquín Inclán'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>

                            <div>
                                <label
                                    for="portada_contenido"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Descripción
                                </label>

                                <textarea
                                    id="portada_contenido"
                                    name="portada_contenido"
                                    rows="4"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">{{ old(
                                    'portada_contenido',
                                    $portada?->contenido
                                        ?? 'Información, comunicación, trámites y servicios digitales para estudiantes, padres de familia, docentes y toda nuestra comunidad educativa.'
                                ) }}</textarea>
                            </div>

                            <div>
                                <label
                                    for="portada_lema"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Lema institucional
                                </label>

                                <input
                                    id="portada_lema"
                                    name="portada_lema"
                                    type="text"
                                    value="{{ old(
                                        'portada_lema',
                                        $portada?->datos['lema']
                                            ?? 'Dios · Patria · Cultura'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-extrabold
                                       text-emerald-950">
                                Imagen de portada
                            </label>

                            <div
                                class="mt-2 overflow-hidden rounded-2xl
                                       border border-amber-200 bg-gray-100">
                                <img
                                    src="{{
                                        $portada?->imagen
                                            ? asset('storage/' . $portada->imagen)
                                            : asset('images/portada-institucion.jpg')
                                    }}"
                                    alt="Portada institucional"
                                    class="h-64 w-full object-cover">
                            </div>

                            <input
                                name="portada_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600
                                       file:mr-4 file:rounded-xl
                                       file:border-0 file:bg-emerald-950
                                       file:px-4 file:py-2.5
                                       file:font-bold file:text-white
                                       hover:file:bg-emerald-900">

                            <p class="mt-2 text-xs text-gray-400">
                                JPG, PNG o WEBP. Máximo 4 MB.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 2. DIRECTOR --}}
                {{-- ================================================== --}}
                <section
                    class="overflow-hidden rounded-[28px]
                           border border-gray-200 bg-white
                           shadow-[0_18px_50px_rgba(15,23,42,0.05)]">
                    <div
                        class="flex items-center gap-4 border-b
                               border-gray-100 px-6 py-5 sm:px-8">
                        <div
                            class="flex h-11 w-11 items-center
                                   justify-center rounded-xl
                                   bg-amber-50 text-amber-700">
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 21a8 8 0 0 1 16 0" />
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.15em] text-amber-600">
                                Sección 02
                            </p>

                            <h2 class="text-xl font-extrabold text-emerald-950">
                                Mensaje del director
                            </h2>
                        </div>
                    </div>

                    <div class="grid gap-7 p-6 sm:p-8 lg:grid-cols-[1.25fr_0.75fr]">

                        <div class="space-y-5">
                            <div>
                                <label
                                    for="director_nombre"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Nombre / título mostrado
                                </label>

                                <input
                                    id="director_nombre"
                                    name="director_nombre"
                                    type="text"
                                    required
                                    value="{{ old(
                                        'director_nombre',
                                        $director?->titulo
                                            ?? 'Director de la institución'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>

                            <div>
                                <label
                                    for="director_cargo"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Cargo
                                </label>

                                <input
                                    id="director_cargo"
                                    name="director_cargo"
                                    type="text"
                                    required
                                    value="{{ old(
                                        'director_cargo',
                                        $director?->subtitulo
                                            ?? 'Dirección institucional'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>

                            <div>
                                <label
                                    for="director_mensaje"
                                    class="block text-sm font-extrabold
                                           text-emerald-950">
                                    Mensaje institucional
                                </label>

                                <textarea
                                    id="director_mensaje"
                                    name="director_mensaje"
                                    rows="7"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">{{ old(
                                    'director_mensaje',
                                    $director?->contenido
                                        ?? 'Reciban una cordial bienvenida al portal institucional de la IE Crl. José Joaquín Inclán. Este espacio ha sido creado para fortalecer la comunicación, acercar nuestros servicios y compartir el trabajo que realizamos en favor de la formación integral de nuestros estudiantes.'
                                ) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-extrabold
                                       text-emerald-950">
                                Fotografía
                            </label>

                            <div
                                class="mt-2 overflow-hidden rounded-2xl
                                       border border-amber-200 bg-gray-100">
                                <img
                                    src="{{
                                        $director?->imagen
                                            ? asset('storage/' . $director->imagen)
                                            : asset('images/director.jpeg')
                                    }}"
                                    alt="Director"
                                    class="h-72 w-full object-cover object-top">
                            </div>

                            <input
                                name="director_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600
                                       file:mr-4 file:rounded-xl
                                       file:border-0 file:bg-emerald-950
                                       file:px-4 file:py-2.5
                                       file:font-bold file:text-white">
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 3. MISIÓN / VISIÓN / VALORES --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200
                           bg-white p-6
                           shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.15em] text-amber-600">
                            Sección 03
                        </p>

                        <h2
                            class="mt-1 text-xl font-extrabold
                                   text-emerald-950">
                            Misión, visión y valores
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-6 xl:grid-cols-3">

                        {{-- MISIÓN --}}
                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-slate-50 p-5">
                            <h3 class="font-extrabold text-emerald-950">
                                Misión
                            </h3>

                            <input
                                name="mision_titulo"
                                type="text"
                                required
                                value="{{ old(
                                    'mision_titulo',
                                    $mision?->titulo ?? 'Misión'
                                ) }}"
                                class="mt-4 h-11 w-full rounded-xl
                                       border-gray-300 bg-white">

                            <textarea
                                name="mision_contenido"
                                rows="7"
                                required
                                class="mt-3 w-full rounded-xl
                                       border-gray-300 bg-white">{{ old(
                                'mision_contenido',
                                $mision?->contenido
                                    ?? 'Brindar un servicio educativo de calidad mediante procesos permanentes de mejora continua, aplicando un modelo pedagógico Socio Constructivista Humanista.'
                            ) }}</textarea>

                            <input
                                name="mision_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-xs
                                       text-gray-500">
                        </div>

                        {{-- VISIÓN --}}
                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-slate-50 p-5">
                            <h3 class="font-extrabold text-emerald-950">
                                Visión
                            </h3>

                            <input
                                name="vision_titulo"
                                type="text"
                                required
                                value="{{ old(
                                    'vision_titulo',
                                    $vision?->titulo ?? 'Visión'
                                ) }}"
                                class="mt-4 h-11 w-full rounded-xl
                                       border-gray-300 bg-white">

                            <textarea
                                name="vision_contenido"
                                rows="7"
                                required
                                class="mt-3 w-full rounded-xl
                                       border-gray-300 bg-white">{{ old(
                                'vision_contenido',
                                $vision?->contenido
                                    ?? 'Consolidarnos como una institución educativa de calidad, moderna, reconocida e integrada al sistema educativo nacional, alineada con la visión del Sector Defensa.'
                            ) }}</textarea>

                            <input
                                name="vision_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-xs
                                       text-gray-500">
                        </div>

                        {{-- VALORES --}}
                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-slate-50 p-5">
                            <h3 class="font-extrabold text-emerald-950">
                                Valores
                            </h3>

                            <input
                                name="valores_titulo"
                                type="text"
                                required
                                value="{{ old(
                                    'valores_titulo',
                                    $valores?->titulo
                                        ?? 'Valores institucionales'
                                ) }}"
                                class="mt-4 h-11 w-full rounded-xl
                                       border-gray-300 bg-white">

                            <textarea
                                name="valores_contenido"
                                rows="4"
                                required
                                class="mt-3 w-full rounded-xl
                                       border-gray-300 bg-white">{{ old(
                                'valores_contenido',
                                $valores?->contenido
                                    ?? 'Promovemos valores que fortalecen la convivencia, el servicio y la excelencia, formando ciudadanos responsables y comprometidos con su comunidad.'
                            ) }}</textarea>

                            <label
                                class="mt-3 block text-xs
                                       font-extrabold text-gray-600">
                                Lista de valores
                            </label>

                            <textarea
                                name="valores_lista"
                                rows="6"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-white">{{ $listaValores }}</textarea>

                            <p class="mt-2 text-xs text-gray-400">
                                Escribe un valor por línea.
                            </p>

                            <input
                                name="valores_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-xs
                                       text-gray-500">
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 4. ENFOQUE --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200
                           bg-white p-6
                           shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.15em] text-amber-600">
                            Sección 04
                        </p>

                        <h2
                            class="mt-1 text-xl font-extrabold
                                   text-emerald-950">
                            Enfoque institucional
                        </h2>
                    </div>

                    <div class="mt-6 grid gap-6 lg:grid-cols-2">

                        <div>
                            <label
                                class="block text-sm font-extrabold
                                       text-emerald-950">
                                Título
                            </label>

                            <input
                                name="enfoque_titulo"
                                type="text"
                                required
                                value="{{ old(
                                    'enfoque_titulo',
                                    $enfoque?->titulo
                                        ?? 'Innovación, acompañamiento y mejora continua'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50">

                            <label
                                class="mt-5 block text-sm font-extrabold
                                       text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="enfoque_contenido"
                                rows="7"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-gray-50">{{ old(
                                'enfoque_contenido',
                                $enfoque?->contenido
                                    ?? 'La institución fortalece sus procesos educativos mediante tecnologías de la información y comunicación, estrategias de evaluación formativa y acompañamiento docente, con el propósito de garantizar una educación inclusiva, equitativa y de calidad.'
                            ) }}</textarea>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-extrabold
                                       text-emerald-950">
                                Imagen del enfoque
                            </label>

                            <div
                                class="mt-2 overflow-hidden rounded-2xl
                                       border border-amber-200">
                                <img
                                    src="{{
                                        $enfoque?->imagen
                                            ? asset('storage/' . $enfoque->imagen)
                                            : asset('images/enfoque-institucional.png')
                                    }}"
                                    alt="Enfoque institucional"
                                    class="h-64 w-full object-cover">
                            </div>

                            <input
                                name="enfoque_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm
                                       text-gray-600">
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 5. SERVICIOS COMPLEMENTARIOS --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200
           bg-white p-6
           shadow-[0_18px_50px_rgba(15,23,42,0.05)]
           sm:p-8">
                    @php
                    $servicios = $contenidos->get('servicios_inicio');

                    $datosServicios = $servicios?->datos ?? [];

                    $topico = $datosServicios['topico'] ?? [];
                    $toece = $datosServicios['toece'] ?? [];
                    $psicologia = $datosServicios['psicologia'] ?? [];

                    $funcionesTopico = $topico['funciones'] ?? [
                    'Brindar atención básica ante molestias o accidentes leves.',
                    'Orientar a estudiantes y familias sobre el cuidado de la salud.',
                    'Registrar las atenciones realizadas.',
                    'Coordinar acciones preventivas con la comunidad educativa.',
                    ];

                    $funcionesToece = $toece['funciones'] ?? [
                    'Desarrollar acciones de tutoría y orientación educativa.',
                    'Promover una convivencia escolar respetuosa.',
                    'Prevenir situaciones de violencia escolar.',
                    'Coordinar actividades con estudiantes y familias.',
                    ];

                    $funcionesPsicologia = $psicologia['funciones'] ?? [
                    'Brindar orientación socioemocional a los estudiantes.',
                    'Realizar acciones preventivas y de acompañamiento.',
                    'Orientar a madres, padres y apoderados.',
                    'Coordinar intervenciones con docentes y directivos.',
                    ];

                    $galeriaTopico = $topico['galeria'] ?? [];
                    $galeriaToece = $toece['galeria'] ?? [];
                    $galeriaPsicologia = $psicologia['galeria'] ?? [];
                    @endphp

                    {{-- ENCABEZADO --}}
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                   tracking-[0.15em] text-amber-600">
                            Sección 05
                        </p>

                        <h2
                            class="mt-1 text-xl font-extrabold
                   text-emerald-950">
                            Servicios complementarios
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Administra la información pública de Tópico,
                            TOECE y Psicología, incluyendo sus páginas de detalle.
                        </p>
                    </div>

                    {{-- ================================================== --}}
                    {{-- ENCABEZADO GENERAL --}}
                    {{-- ================================================== --}}
                    <div
                        class="mt-7 rounded-2xl border border-emerald-100
               bg-emerald-50/40 p-5">
                        <h3 class="font-extrabold text-emerald-950">
                            Encabezado de la sección
                        </h3>

                        <div class="mt-5 grid gap-5 lg:grid-cols-2">

                            <div>
                                <label
                                    for="servicios_etiqueta"
                                    class="block text-sm font-extrabold text-emerald-950">
                                    Etiqueta superior
                                </label>

                                <input
                                    id="servicios_etiqueta"
                                    name="servicios_etiqueta"
                                    type="text"
                                    required
                                    value="{{ old(
                        'servicios_etiqueta',
                        $servicios?->subtitulo ?? 'Bienestar estudiantil'
                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white
                           focus:border-emerald-700
                           focus:ring-emerald-700">
                            </div>

                            <div>
                                <label
                                    for="servicios_titulo"
                                    class="block text-sm font-extrabold text-emerald-950">
                                    Título
                                </label>

                                <input
                                    id="servicios_titulo"
                                    name="servicios_titulo"
                                    type="text"
                                    required
                                    value="{{ old(
                        'servicios_titulo',
                        $servicios?->titulo ?? 'Servicios complementarios'
                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white
                           focus:border-emerald-700
                           focus:ring-emerald-700">
                            </div>

                            <div class="lg:col-span-2">
                                <label
                                    for="servicios_descripcion"
                                    class="block text-sm font-extrabold text-emerald-950">
                                    Descripción general
                                </label>

                                <textarea
                                    id="servicios_descripcion"
                                    name="servicios_descripcion"
                                    rows="3"
                                    required
                                    class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white
                           focus:border-emerald-700
                           focus:ring-emerald-700">{{ old(
                    'servicios_descripcion',
                    $servicios?->contenido
                        ?? 'Atención, orientación y acompañamiento para el bienestar integral de nuestros estudiantes.'
                ) }}</textarea>
                            </div>

                        </div>
                    </div>

                    {{-- ================================================== --}}
                    {{-- TÓPICO --}}
                    {{-- ================================================== --}}
                    <div
                        class="mt-8 rounded-[24px] border border-gray-200
               bg-slate-50 p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                           tracking-[0.14em] text-amber-600">
                                    Servicio 01
                                </p>

                                <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                                    Tópico
                                </h3>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-5 lg:grid-cols-2">

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Título
                                </label>

                                <input
                                    name="topico_titulo"
                                    type="text"
                                    required
                                    value="{{ old(
                        'topico_titulo',
                        $topico['titulo'] ?? 'Tópico'
                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Subtítulo
                                </label>

                                <input
                                    name="topico_subtitulo"
                                    type="text"
                                    required
                                    value="{{ old(
                        'topico_subtitulo',
                        $topico['subtitulo']
                            ?? 'Salud y primeros auxilios'
                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-bold text-gray-700">
                                    Descripción
                                </label>

                                <textarea
                                    name="topico_descripcion"
                                    rows="4"
                                    required
                                    class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'topico_descripcion',
                    $topico['descripcion']
                        ?? 'El servicio de Tópico brinda atención preventiva, orientación y cuidado básico de la salud para estudiantes y personal de nuestra comunidad educativa.'
                ) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Horario de atención
                                </label>

                                <input
                                    name="topico_horario"
                                    type="text"
                                    required
                                    value="{{ old(
                        'topico_horario',
                        $topico['horario']
                            ?? 'De 7:30 a. m. a 3:00 p. m.'
                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Imagen principal
                                </label>

                                <input
                                    name="topico_imagen"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="mt-2 block w-full rounded-xl
                           border border-gray-300 bg-white p-3
                           text-sm text-gray-500">
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-bold text-gray-700">
                                    Principales funciones
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Escribe una función por línea.
                                </p>

                                <textarea
                                    name="topico_funciones"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'topico_funciones',
                    implode(PHP_EOL, $funcionesTopico)
                ) }}</textarea>
                            </div>
                        </div>

                        {{-- Imagen actual --}}
                        <div class="mt-6">
                            <p class="text-sm font-bold text-gray-700">
                                Imagen principal actual
                            </p>

                            <div
                                class="mt-2 max-w-md overflow-hidden rounded-2xl
                       border border-gray-200 bg-white">
                                <img
                                    src="{{
                        !empty($topico['imagen'])
                            ? asset('storage/' . $topico['imagen'])
                            : asset('images/servicio-topico.jpeg')
                    }}"
                                    alt="Tópico"
                                    class="h-52 w-full object-cover">
                            </div>
                        </div>

                        {{-- GALERÍA TÓPICO --}}
                        <div class="mt-8 border-t border-gray-200 pt-6">

                            <h4 class="font-extrabold text-emerald-950">
                                Galería del servicio
                            </h4>

                            <p class="mt-1 text-sm text-gray-500">
                                Puedes reemplazar individualmente las cuatro fotografías.
                            </p>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                                @for ($i = 1; $i <= 4; $i++)
                                    @php
                                    $fotoTopico=$galeriaTopico[$i - 1] ?? null;
                                    @endphp

                                    <div
                                    class="rounded-2xl border border-gray-200
                               bg-white p-4">
                                    <p class="text-xs font-extrabold text-gray-600">
                                        Fotografía {{ $i }}
                                    </p>

                                    <div
                                        class="mt-3 overflow-hidden rounded-xl
                                   border border-gray-100">
                                        <img
                                            src="{{
                                    $fotoTopico
                                        ? asset('storage/' . $fotoTopico)
                                        : asset(
                                            'images/topico/topico-' . $i . '.jpg'
                                        )
                                }}"
                                            alt="Tópico - fotografía {{ $i }}"
                                            class="h-36 w-full object-cover">
                                    </div>

                                    <input
                                        name="topico_galeria_{{ $i }}"
                                        type="file"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="mt-3 block w-full text-xs text-gray-500">
                            </div>
                            @endfor

                        </div>
                    </div>
        </div>

        {{-- ================================================== --}}
        {{-- TOECE --}}
        {{-- ================================================== --}}
        <div
            class="mt-8 rounded-[24px] border border-gray-200
               bg-slate-50 p-6">
            <div>
                <p
                    class="text-xs font-extrabold uppercase
                       tracking-[0.14em] text-amber-600">
                    Servicio 02
                </p>

                <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                    TOECE
                </h3>
            </div>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">

                <div>
                    <label class="block text-sm font-bold text-gray-700">
                        Título
                    </label>

                    <input
                        name="toece_titulo"
                        type="text"
                        required
                        value="{{ old(
                        'toece_titulo',
                        $toece['titulo'] ?? 'TOECE'
                    ) }}"
                        class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">
                        Subtítulo
                    </label>

                    <input
                        name="toece_subtitulo"
                        type="text"
                        required
                        value="{{ old(
                        'toece_subtitulo',
                        $toece['subtitulo']
                            ?? 'Tutoría, orientación educativa y convivencia escolar'
                    ) }}"
                        class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-bold text-gray-700">
                        Descripción
                    </label>

                    <textarea
                        name="toece_descripcion"
                        rows="4"
                        required
                        class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'toece_descripcion',
                    $toece['descripcion']
                        ?? 'TOECE acompaña a los estudiantes en su desarrollo personal, social y académico, promoviendo una convivencia respetuosa, segura e inclusiva.'
                ) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">
                        Horario de atención
                    </label>

                    <input
                        name="toece_horario"
                        type="text"
                        required
                        value="{{ old(
                        'toece_horario',
                        $toece['horario']
                            ?? 'De 7:30 a. m. a 3:00 p. m.'
                    ) }}"
                        class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">
                        Imagen principal
                    </label>

                    <input
                        name="toece_imagen"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="mt-2 block w-full rounded-xl
                           border border-gray-300 bg-white p-3
                           text-sm text-gray-500">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-bold text-gray-700">
                        Principales funciones
                    </label>

                    <p class="mt-1 text-xs text-gray-500">
                        Escribe una función por línea.
                    </p>

                    <textarea
                        name="toece_funciones"
                        rows="6"
                        required
                        class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'toece_funciones',
                    implode(PHP_EOL, $funcionesToece)
                ) }}</textarea>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm font-bold text-gray-700">
                    Imagen principal actual
                </p>

                <div
                    class="mt-2 max-w-md overflow-hidden rounded-2xl
                       border border-gray-200 bg-white">
                    <img
                        src="{{
                        !empty($toece['imagen'])
                            ? asset('storage/' . $toece['imagen'])
                            : asset('images/servicio-toece.jpeg')
                    }}"
                        alt="TOECE"
                        class="h-52 w-full object-cover">
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">

                <h4 class="font-extrabold text-emerald-950">
                    Galería del servicio
                </h4>

                <p class="mt-1 text-sm text-gray-500">
                    Puedes reemplazar individualmente las cuatro fotografías.
                </p>

                <div class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                    @for ($i = 1; $i <= 4; $i++)
                        @php
                        $fotoToece=$galeriaToece[$i - 1] ?? null;
                        @endphp

                        <div
                        class="rounded-2xl border border-gray-200
                               bg-white p-4">
                        <p class="text-xs font-extrabold text-gray-600">
                            Fotografía {{ $i }}
                        </p>

                        <div
                            class="mt-3 overflow-hidden rounded-xl
                                   border border-gray-100">
                            <img
                                src="{{
                                    $fotoToece
                                        ? asset('storage/' . $fotoToece)
                                        : asset(
                                            'images/toece/toece-' . $i . '.jpg'
                                        )
                                }}"
                                alt="TOECE - fotografía {{ $i }}"
                                class="h-36 w-full object-cover">
                        </div>

                        <input
                            name="toece_galeria_{{ $i }}"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="mt-3 block w-full text-xs text-gray-500">
                </div>
                @endfor

            </div>
        </div>
    </div>

    {{-- ================================================== --}}
    {{-- PSICOLOGÍA --}}
    {{-- ================================================== --}}
    <div
        class="mt-8 rounded-[24px] border border-gray-200
               bg-slate-50 p-6">
        <div>
            <p
                class="text-xs font-extrabold uppercase
                       tracking-[0.14em] text-amber-600">
                Servicio 03
            </p>

            <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                Psicología
            </h3>
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-2">

            <div>
                <label class="block text-sm font-bold text-gray-700">
                    Título
                </label>

                <input
                    name="psicologia_titulo"
                    type="text"
                    required
                    value="{{ old(
                        'psicologia_titulo',
                        $psicologia['titulo'] ?? 'Psicología'
                    ) }}"
                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700">
                    Subtítulo
                </label>

                <input
                    name="psicologia_subtitulo"
                    type="text"
                    required
                    value="{{ old(
                        'psicologia_subtitulo',
                        $psicologia['subtitulo']
                            ?? 'Bienestar socioemocional'
                    ) }}"
                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
            </div>

            <div class="lg:col-span-2">
                <label class="block text-sm font-bold text-gray-700">
                    Descripción
                </label>

                <textarea
                    name="psicologia_descripcion"
                    rows="4"
                    required
                    class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'psicologia_descripcion',
                    $psicologia['descripcion']
                        ?? 'El servicio de Psicología brinda acompañamiento emocional, personal y familiar para fortalecer el desarrollo integral de nuestros estudiantes.'
                ) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700">
                    Horario de atención
                </label>

                <input
                    name="psicologia_horario"
                    type="text"
                    required
                    value="{{ old(
                        'psicologia_horario',
                        $psicologia['horario']
                            ?? 'De 7:30 a. m. a 3:00 p. m.'
                    ) }}"
                    class="mt-2 h-12 w-full rounded-xl
                           border-gray-300 bg-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700">
                    Imagen principal
                </label>

                <input
                    name="psicologia_imagen"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="mt-2 block w-full rounded-xl
                           border border-gray-300 bg-white p-3
                           text-sm text-gray-500">
            </div>

            <div class="lg:col-span-2">
                <label class="block text-sm font-bold text-gray-700">
                    Principales funciones
                </label>

                <p class="mt-1 text-xs text-gray-500">
                    Escribe una función por línea.
                </p>

                <textarea
                    name="psicologia_funciones"
                    rows="6"
                    required
                    class="mt-2 w-full rounded-xl
                           border-gray-300 bg-white">{{ old(
                    'psicologia_funciones',
                    implode(PHP_EOL, $funcionesPsicologia)
                ) }}</textarea>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-sm font-bold text-gray-700">
                Imagen principal actual
            </p>

            <div
                class="mt-2 max-w-md overflow-hidden rounded-2xl
                       border border-gray-200 bg-white">
                <img
                    src="{{
                        !empty($psicologia['imagen'])
                            ? asset('storage/' . $psicologia['imagen'])
                            : asset('images/servicio-psicologia.jpeg')
                    }}"
                    alt="Psicología"
                    class="h-52 w-full object-cover">
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-6">

            <h4 class="font-extrabold text-emerald-950">
                Galería del servicio
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                Puedes reemplazar individualmente las cuatro fotografías.
            </p>

            <div class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                @for ($i = 1; $i <= 4; $i++)
                    @php
                    $fotoPsicologia=$galeriaPsicologia[$i - 1] ?? null;
                    @endphp

                    <div
                    class="rounded-2xl border border-gray-200
                               bg-white p-4">
                    <p class="text-xs font-extrabold text-gray-600">
                        Fotografía {{ $i }}
                    </p>

                    <div
                        class="mt-3 overflow-hidden rounded-xl
                                   border border-gray-100">
                        <img
                            src="{{
                                    $fotoPsicologia
                                        ? asset(
                                            'storage/' . $fotoPsicologia
                                        )
                                        : asset(
                                            'images/psicologia/psicologia-'
                                            . $i
                                            . '.jpg'
                                        )
                                }}"
                            alt="Psicología - fotografía {{ $i }}"
                            class="h-36 w-full object-cover">
                    </div>

                    <input
                        name="psicologia_galeria_{{ $i }}"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="mt-3 block w-full text-xs text-gray-500">
            </div>
            @endfor

        </div>
    </div>
    </div>

    </section>


    {{-- =========================================================
    SECCIÓN 06 - LOGROS Y RECONOCIMIENTOS
========================================================= --}}

    @php
    $contenidoLogros = $contenidos->get('logros_inicio');
    @endphp

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8 lg:p-10">

        {{-- ENCABEZADO --}}
        <div class="mb-8">
            <p class="text-sm font-extrabold uppercase tracking-[0.22em] text-amber-600">
                Sección 06
            </p>

            <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900">
                Logros y reconocimientos
            </h2>

            <p class="mt-3 max-w-4xl text-sm leading-6 text-slate-500 sm:text-base">
                Administra el encabezado de esta sección y consulta los logros
                y reconocimientos registrados en el sistema.
            </p>
        </div>


        {{-- =====================================================
        ENCABEZADO GENERAL
    ====================================================== --}}

        <div class="rounded-3xl border border-slate-200 bg-slate-50/70 p-5 sm:p-6">

            <div class="mb-6">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-5 w-5">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.21 13.89 7 23l5-3 5 3-1.21-9.11M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm4 0a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900">
                            Encabezado de la sección
                        </h3>

                        <p class="text-sm text-slate-500">
                            Este contenido aparece antes de las tarjetas de logros.
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid gap-6 lg:grid-cols-2">

                {{-- ETIQUETA --}}
                <div>
                    <label
                        for="logros_etiqueta"
                        class="mb-2 block text-sm font-bold text-slate-800">
                        Etiqueta superior
                    </label>

                    <input
                        id="logros_etiqueta"
                        type="text"
                        name="logros_etiqueta"
                        value="{{ old(
                        'logros_etiqueta',
                        $contenidoLogros?->subtitulo ?? 'Excelencia institucional'
                    ) }}"
                        required
                        maxlength="100"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
                </div>


                {{-- TÍTULO --}}
                <div>
                    <label
                        for="logros_titulo"
                        class="mb-2 block text-sm font-bold text-slate-800">
                        Título
                    </label>

                    <input
                        id="logros_titulo"
                        type="text"
                        name="logros_titulo"
                        value="{{ old(
                        'logros_titulo',
                        $contenidoLogros?->titulo ?? 'Logros y reconocimientos'
                    ) }}"
                        required
                        maxlength="150"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
                </div>


                {{-- DESCRIPCIÓN --}}
                <div class="lg:col-span-2">

                    <label
                        for="logros_descripcion"
                        class="mb-2 block text-sm font-bold text-slate-800">
                        Descripción
                    </label>

                    <textarea
                        id="logros_descripcion"
                        name="logros_descripcion"
                        rows="5"
                        required
                        maxlength="1000"
                        class="w-full resize-y rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">{{ old(
                    'logros_descripcion',
                    $contenidoLogros?->contenido
                        ?? 'Reconocemos el esfuerzo, la dedicación y los resultados alcanzados por nuestros estudiantes, docentes y la comunidad educativa.'
                ) }}</textarea>

                </div>

            </div>
        </div>


        {{-- =====================================================
        LOGROS REGISTRADOS
    ====================================================== --}}

        <div class="mt-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">
                        Contenido publicado
                    </p>

                    <h3 class="mt-1 text-xl font-extrabold text-slate-900">
                        Logros registrados
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Estos registros alimentan las tarjetas del portal
                        y sus respectivas páginas de detalle.
                    </p>
                </div>


                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-bold text-slate-600">

                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                    {{ $logrosRegistrados->count() }}

                    {{ $logrosRegistrados->count() === 1
                    ? 'registro'
                    : 'registros'
                }}

                </div>

            </div>
{{-- =====================================================
    NUEVO LOGRO
====================================================== --}}

<div
    x-data="{ nuevoLogro: false }"
    class="mt-6"
>
    <button
        type="button"
        @click="nuevoLogro = ! nuevoLogro"
        class="inline-flex items-center gap-2
               rounded-xl bg-emerald-950
               px-5 py-3 text-sm font-extrabold
               text-white transition
               hover:bg-emerald-900"
    >
        <span class="text-lg leading-none">+</span>

        <span x-text="nuevoLogro ? 'Cerrar formulario' : 'Nuevo logro'"></span>
    </button>

    <div
        x-show="nuevoLogro"
        x-cloak
        x-transition
        class="mt-5 rounded-3xl
               border border-emerald-100
               bg-emerald-50/40 p-5"
    >
        <form
            method="POST"
            action="{{ route('admin.contenido-institucional.logros.guardar') }}"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            @csrf

            <div class="grid gap-5 md:grid-cols-2">

                <div>
                    <label class="block text-sm font-bold text-slate-700">
                        Tipo
                    </label>

                    <select
                        name="logro_tipo"
                        required
                        class="mt-2 h-12 w-full rounded-xl
                               border-slate-300 bg-white"
                    >
                        <option value="logro">
                            Logro
                        </option>

                        <option value="reconocimiento">
                            Reconocimiento
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700">
                        Nivel educativo
                    </label>

                    <select
                        name="logro_nivel_educativo_id"
                        class="mt-2 h-12 w-full rounded-xl
                               border-slate-300 bg-white"
                    >
                        <option value="">
                            Sin nivel
                        </option>

                        @foreach ($nivelesEducativos as $nivelEducativo)
                            <option value="{{ $nivelEducativo->id }}">
                                {{ $nivelEducativo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">
                    Título
                </label>

                <input
                    type="text"
                    name="logro_titulo"
                    required
                    maxlength="255"
                    class="mt-2 h-12 w-full rounded-xl
                           border-slate-300 bg-white"
                >
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">
                    Fecha
                </label>

                <input
                    type="date"
                    name="logro_fecha"
                    required
                    class="mt-2 h-12 w-full rounded-xl
                           border-slate-300 bg-white"
                >
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">
                    Descripción
                </label>

                <textarea
                    name="logro_descripcion"
                    rows="5"
                    required
                    maxlength="5000"
                    class="mt-2 w-full rounded-xl
                           border-slate-300 bg-white"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">
                    Imagen
                </label>

                <input
                    type="file"
                    name="logro_imagen"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="mt-2 block w-full rounded-xl
                           border border-slate-300
                           bg-white p-3 text-sm"
                >
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-xl bg-emerald-950
                           px-6 py-3 text-sm font-extrabold
                           text-white transition
                           hover:bg-emerald-900"
                >
                    Registrar logro
                </button>
            </div>

        </form>
    </div>
</div>

            {{-- =====================================================
            LISTADO
        ====================================================== --}}

            <div class="mt-6 grid gap-5 xl:grid-cols-2">

                @forelse ($logrosRegistrados as $logro)

                @php
                $imagenLogro = $logro->imagen
                ? asset('storage/' . $logro->imagen)
                : asset('images/portada-institucion.jpg');

                $tipoLogro = $logro->tipo ?: 'Logro';

                $nivelLogro = $logro->nivel
                ?: 'Nivel no especificado';

                $fechaLogro = $logro->fecha
                ? \Illuminate\Support\Carbon::parse($logro->fecha)
                ->format('d/m/Y')
                : 'Sin fecha';

                $descripcionLogro = $logro->descripcion
                ?: 'Sin descripción registrada.';

                $estadoTexto = $logro->estado
                ? 'Publicado'
                : 'Oculto';

                $estadoClase = $logro->estado
                ? 'bg-emerald-50 text-emerald-700'
                : 'bg-slate-100 text-slate-500';

                $puntoClase = $logro->estado
                ? 'bg-emerald-500'
                : 'bg-slate-400';
                @endphp


                <article
                    class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="grid sm:grid-cols-[170px_minmax(0,1fr)]">

                        {{-- IMAGEN --}}
                        <div class="relative min-h-[190px] overflow-hidden bg-slate-100">

                            <img
                                src="{{ $imagenLogro }}"
                                alt="{{ $logro->titulo }}"
                                class="absolute inset-0 h-full w-full object-cover">

                        </div>


                        {{-- INFORMACIÓN --}}
                        <div class="flex flex-col p-5">

                            {{-- TIPO Y ESTADO --}}
                            <div class="flex flex-wrap items-center justify-between gap-2">

                                <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    {{ $tipoLogro }}
                                </span>


                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold {{ $estadoClase }}">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $puntoClase }}"></span>

                                    {{ $estadoTexto }}
                                </span>

                            </div>


                            {{-- TÍTULO --}}
                            <h4 class="mt-4 text-lg font-extrabold leading-snug text-slate-900">
                                {{ $logro->titulo }}
                            </h4>


                            {{-- NIVEL Y FECHA --}}
                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">

                                <span class="inline-flex items-center gap-2">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        class="h-4 w-4">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 3 2.25 8.25 12 13.5l9.75-5.25L12 3Zm-6.75 8.25V15c0 1.657 3.022 3 6.75 3s6.75-1.343 6.75-3v-3.75" />
                                    </svg>

                                    {{ $nivelLogro }}

                                </span>


                                <span class="inline-flex items-center gap-2">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        class="h-4 w-4">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12A1.5 1.5 0 0 1 18.75 20.25H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>

                                    {{ $fechaLogro }}

                                </span>

                            </div>


                            {{-- DESCRIPCIÓN --}}
                            <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600">
                                {{ $descripcionLogro }}
                            </p>


                            {{-- ACCIONES DEL LOGRO --}}
                            <div
                                x-data="{ editar: false }"
                                class="mt-auto pt-5">
                                <div
                                    class="flex flex-wrap items-center justify-between gap-3
               rounded-2xl border border-slate-200
               bg-slate-50 px-4 py-3">
                                    <p class="text-xs font-semibold text-slate-500">
                                        Registro #{{ $logro->id }}
                                    </p>

                                    <div class="flex flex-wrap gap-2">

                                        <button
                                            type="button"
                                            @click="editar = ! editar"
                                            class="inline-flex items-center gap-2 rounded-xl
                       border border-emerald-200 bg-white
                       px-3 py-2 text-xs font-extrabold
                       text-emerald-800 transition
                       hover:bg-emerald-50">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                class="h-4 w-4">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L18.55 2.799" />
                                            </svg>

                                            <span x-text="editar ? 'Cerrar' : 'Editar'"></span>
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route(
                    'admin.contenido-institucional.logros.estado',
                    $logro->id
                ) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 rounded-xl
                           border px-3 py-2 text-xs font-extrabold
                           transition
                           {{ $logro->estado
                                ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100'
                                : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100'
                           }}">
                                                {{ $logro->estado ? 'Ocultar' : 'Publicar' }}
                                            </button>
                                        </form>

                                    </div>
                                </div>


                                {{-- FORMULARIO DE EDICIÓN --}}
                                <div
                                    x-show="editar"
                                    x-cloak
                                    x-transition
                                    class="mt-4 rounded-2xl border border-emerald-100
               bg-emerald-50/40 p-4">
                                    <form
                                        method="POST"
                                        action="{{ route(
                'admin.contenido-institucional.logros.actualizar',
                $logro->id
            ) }}"
                                        enctype="multipart/form-data"
                                        class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid gap-4 md:grid-cols-2">

                                            <div>
                                                <label
                                                    class="block text-xs font-extrabold
                               uppercase tracking-wide text-slate-600">
                                                    Tipo
                                                </label>

                                                <select
                                                    name="logro_tipo"
                                                    required
                                                    class="mt-2 h-11 w-full rounded-xl
                               border-slate-300 bg-white
                               text-sm">
                                                    <option
                                                        value="logro"
                                                        @selected($logro->tipo === 'logro')
                                                        >
                                                        Logro
                                                    </option>

                                                    <option
                                                        value="reconocimiento"
                                                        @selected($logro->tipo === 'reconocimiento')
                                                        >
                                                        Reconocimiento
                                                    </option>
                                                </select>
                                            </div>


                                            <div>
                                                <label
                                                    class="block text-xs font-extrabold
                               uppercase tracking-wide text-slate-600">
                                                    Nivel educativo
                                                </label>

                                                <select
                                                    name="logro_nivel_educativo_id"
                                                    class="mt-2 h-11 w-full rounded-xl
                               border-slate-300 bg-white
                               text-sm">
                                                    <option value="">
                                                        Sin nivel
                                                    </option>

                                                    @foreach ($nivelesEducativos as $nivelEducativo)
                                                    <option
                                                        value="{{ $nivelEducativo->id }}"
                                                        @selected(
                                                        (int) $logro->nivel_educativo_id
                                                        === (int) $nivelEducativo->id
                                                        )
                                                        >
                                                        {{ $nivelEducativo->nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>


                                        <div>
                                            <label
                                                class="block text-xs font-extrabold
                           uppercase tracking-wide text-slate-600">
                                                Título
                                            </label>

                                            <input
                                                type="text"
                                                name="logro_titulo"
                                                value="{{ $logro->titulo }}"
                                                required
                                                maxlength="255"
                                                class="mt-2 h-11 w-full rounded-xl
                           border-slate-300 bg-white
                           text-sm">
                                        </div>


                                        <div>
                                            <label
                                                class="block text-xs font-extrabold
                           uppercase tracking-wide text-slate-600">
                                                Fecha
                                            </label>

                                            <input
                                                type="date"
                                                name="logro_fecha"
                                                value="{{ $logro->fecha
                        ? \Illuminate\Support\Carbon::parse($logro->fecha)
                            ->format('Y-m-d')
                        : ''
                    }}"
                                                required
                                                class="mt-2 h-11 w-full rounded-xl
                           border-slate-300 bg-white
                           text-sm">
                                        </div>


                                        <div>
                                            <label
                                                class="block text-xs font-extrabold
                           uppercase tracking-wide text-slate-600">
                                                Descripción
                                            </label>

                                            <textarea
                                                name="logro_descripcion"
                                                rows="4"
                                                required
                                                maxlength="5000"
                                                class="mt-2 w-full rounded-xl
                           border-slate-300 bg-white
                           text-sm">{{ $logro->descripcion }}</textarea>
                                        </div>


                                        <div>
                                            <label
                                                class="block text-xs font-extrabold
                           uppercase tracking-wide text-slate-600">
                                                Reemplazar imagen
                                            </label>

                                            <input
                                                type="file"
                                                name="logro_imagen"
                                                accept=".jpg,.jpeg,.png,.webp"
                                                class="mt-2 block w-full rounded-xl
                           border border-slate-300 bg-white
                           p-3 text-sm text-slate-500">
                                        </div>


                                        <div class="flex justify-end">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center
                           rounded-xl bg-emerald-950 px-5 py-2.5
                           text-sm font-extrabold text-white
                           transition hover:bg-emerald-900">
                                                Guardar cambios
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

                </article>


                @empty

                <div
                    class="col-span-full rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            class="h-7 w-7">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.21 13.89 7 23l5-3 5 3-1.21-9.11M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm4 0a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>

                    </div>


                    <h4 class="mt-4 font-extrabold text-slate-800">
                        No hay logros registrados
                    </h4>


                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Cuando registres un logro o reconocimiento,
                        aparecerá automáticamente en este apartado.
                    </p>

                </div>

                @endforelse

            </div>

        </div>

    </section>

    {{-- ================================================== --}}
    {{-- GUARDAR CAMBIOS --}}
    {{-- ================================================== --}}

    <div
        class="sticky bottom-4 z-30 rounded-[24px]
                           border border-emerald-900/10
                           bg-white/95 p-4
                           shadow-[0_20px_60px_rgba(15,23,42,0.15)]
                           backdrop-blur sm:p-5">
        <div
            class="flex flex-col gap-4
                               sm:flex-row sm:items-center
                               sm:justify-between">
            <div>
                <p class="font-extrabold text-emerald-950">
                    Guardar contenido institucional
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Guarda los cambios realizados en las
                    secciones de la página de inicio.
                </p>
            </div>

            <button
                type="submit"
                class="inline-flex h-12 items-center
                                   justify-center gap-2 rounded-xl
                                   bg-emerald-950 px-6
                                   text-sm font-extrabold text-white
                                   shadow-lg shadow-emerald-950/10
                                   transition
                                   hover:bg-emerald-900
                                   focus:outline-none
                                   focus:ring-4
                                   focus:ring-emerald-200">
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 12.5 9.5 17 19 7.5" />
                </svg>

                Guardar cambios
            </button>
        </div>
    </div>

    </form>

    </div>
    </div>

</x-app-layout>