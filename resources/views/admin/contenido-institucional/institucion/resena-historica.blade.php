<x-app-layout>

    @php
        $datosResena = $resena?->datos ?? [];

        $portada = $datosResena['portada'] ?? [];
        $destacados = $datosResena['destacados'] ?? [];
        $convenio = $datosResena['convenio'] ?? [];
        $timeline = $datosResena['timeline'] ?? [];
        $smartSchool = $datosResena['smart_school'] ?? [];
        $legado = $datosResena['legado'] ?? [];

        $beneficiosSmart = old(
            'smart_beneficios',
            implode(
                PHP_EOL,
                $smartSchool['beneficios'] ?? [
                    'Capacitación docente',
                    'Tecnología interactiva',
                    'Mejora de los aprendizajes',
                    'Inclusión digital familiar',
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
                       sm:px-8 lg:px-10"
            >
                <div
                    class="pointer-events-none absolute -right-20 -top-20
                           h-64 w-64 rounded-full bg-amber-300/10 blur-3xl"
                ></div>

                <div
                    class="relative z-10 flex flex-col gap-6
                           lg:flex-row lg:items-center lg:justify-between"
                >
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-14 w-14 shrink-0 items-center
                                   justify-center rounded-2xl
                                   border border-amber-300/40
                                   bg-white/10 text-amber-300"
                        >
                            <svg
                                class="h-7 w-7"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.2em] text-amber-300"
                            >
                                Contenido institucional
                            </p>

                            <h1
                                class="mt-2 text-3xl font-extrabold
                                       tracking-tight text-white"
                            >
                                Reseña histórica
                            </h1>

                            <p
                                class="mt-2 max-w-3xl text-sm
                                       leading-6 text-emerald-100"
                            >
                                Administra la portada, datos históricos,
                                convenios, línea de tiempo, Smart School
                                y legado institucional.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a
                            href="{{ route('admin.contenido-institucional.inicio') }}"
                            class="inline-flex h-12 items-center justify-center
                                   rounded-xl border border-white/20
                                   bg-white/10 px-5 text-sm font-extrabold
                                   text-white transition hover:bg-white/20"
                        >
                            Página de inicio
                        </a>

                        <a
                            href="{{ route('institucion.resena-historica') }}"
                            target="_blank"
                            class="inline-flex h-12 items-center justify-center
                                   gap-2 rounded-xl border border-amber-300
                                   bg-amber-300 px-5 text-sm font-extrabold
                                   text-emerald-950 transition
                                   hover:bg-amber-200"
                        >
                            Ver página pública
                        </a>
                    </div>
                </div>
            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div
                    class="mt-6 flex items-start gap-3 rounded-2xl
                           border border-emerald-200 bg-emerald-50
                           p-5 text-emerald-800"
                >
                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 2.5 2.5L16 9"/>
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
                           bg-red-50 p-5"
                >
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

            {{-- ====================================================== --}}
            {{-- FORMULARIO GENERAL DE LA RESEÑA --}}
            {{-- ====================================================== --}}
            <form
                method="POST"
                action="{{ route('admin.contenido-institucional.institucion.resena.actualizar') }}"
                enctype="multipart/form-data"
                class="mt-6 space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- ================================================== --}}
                {{-- 01. PORTADA --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.15em] text-amber-600"
                        >
                            Sección 01
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Portada de la reseña
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Edita los textos principales y la imagen de presentación.
                        </p>
                    </div>

                    <div class="mt-7 grid gap-6 lg:grid-cols-2">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Etiqueta superior
                                </label>

                                <input
                                    type="text"
                                    name="resena_etiqueta"
                                    required
                                    value="{{ old(
                                        'resena_etiqueta',
                                        $portada['etiqueta'] ?? 'Nuestra trayectoria'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Título
                                </label>

                                <input
                                    type="text"
                                    name="resena_titulo"
                                    required
                                    value="{{ old(
                                        'resena_titulo',
                                        $portada['titulo'] ?? 'Reseña histórica'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Descripción principal
                                </label>

                                <textarea
                                    name="resena_descripcion"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ old(
                                    'resena_descripcion',
                                    $portada['descripcion']
                                        ?? 'La Institución Educativa “Crl. José Joaquín Inclán” fue creada oficialmente el 20 de enero de 1995, mediante Resolución Directoral N.° 021, para brindar educación a los hijos del personal militar y civil del Ejército, así como a estudiantes de la comunidad piurana.'
                                ) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Título del origen de la denominación
                                </label>

                                <input
                                    type="text"
                                    name="resena_origen_titulo"
                                    required
                                    value="{{ old(
                                        'resena_origen_titulo',
                                        $portada['origen_titulo']
                                            ?? 'Origen de nuestra denominación'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Descripción del origen
                                </label>

                                <textarea
                                    name="resena_origen_descripcion"
                                    rows="5"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ old(
                                    'resena_origen_descripcion',
                                    $portada['origen_descripcion']
                                        ?? 'El nombre de la institución rinde homenaje al coronel José Joaquín Inclán, héroe del Combate del Dos de Mayo de 1866 y patrono del arma de Artillería del Ejército del Perú.'
                                ) }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Imagen principal
                                </label>

                                <div
                                    class="mt-2 overflow-hidden rounded-2xl
                                           border border-amber-200 bg-gray-100"
                                >
                                    <img
                                        src="{{
                                            !empty($portada['imagen'])
                                                ? asset('storage/' . $portada['imagen'])
                                                : asset('images/resena-historica.png')
                                        }}"
                                        alt="Reseña histórica"
                                        class="h-72 w-full object-cover"
                                    >
                                </div>

                                <input
                                    type="file"
                                    name="resena_imagen"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="mt-4 block w-full text-sm text-gray-600
                                           file:mr-4 file:rounded-xl
                                           file:border-0 file:bg-emerald-950
                                           file:px-4 file:py-2.5
                                           file:font-bold file:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Texto “Desde”
                                </label>

                                <input
                                    type="text"
                                    name="resena_desde"
                                    required
                                    value="{{ old(
                                        'resena_desde',
                                        $portada['desde'] ?? 'Desde 1995'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Nombre mostrado sobre la imagen
                                </label>

                                <input
                                    type="text"
                                    name="resena_institucion"
                                    required
                                    value="{{ old(
                                        'resena_institucion',
                                        $portada['institucion']
                                            ?? 'IE Crl. José Joaquín Inclán'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Frase destacada
                                </label>

                                <input
                                    type="text"
                                    name="resena_frase"
                                    required
                                    value="{{ old(
                                        'resena_frase',
                                        $portada['frase']
                                            ?? 'Educación, valores y compromiso'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 02. DATOS DESTACADOS --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Sección 02
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Datos destacados
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                        @php
                            $tarjetasDestacadas = [
                                [
                                    'clave' => 'anio',
                                    'valor' => $destacados['anio']['valor'] ?? '1995',
                                    'texto' => $destacados['anio']['texto'] ?? 'Año de creación',
                                ],
                                [
                                    'clave' => 'estudiantes',
                                    'valor' => $destacados['estudiantes']['valor'] ?? '130',
                                    'texto' => $destacados['estudiantes']['texto'] ?? 'Estudiantes al iniciar',
                                ],
                                [
                                    'clave' => 'docentes',
                                    'valor' => $destacados['docentes']['valor'] ?? '7',
                                    'texto' => $destacados['docentes']['texto'] ?? 'Docentes fundadores',
                                ],
                                [
                                    'clave' => 'niveles',
                                    'valor' => $destacados['niveles']['valor'] ?? '3',
                                    'texto' => $destacados['niveles']['texto'] ?? 'Niveles educativos',
                                ],
                            ];
                        @endphp

                        @foreach ($tarjetasDestacadas as $tarjeta)
                            <div class="rounded-2xl border border-gray-200 bg-slate-50 p-5">
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Valor
                                </label>

                                <input
                                    type="text"
                                    name="dato_{{ $tarjeta['clave'] }}_valor"
                                    required
                                    value="{{ old(
                                        'dato_' . $tarjeta['clave'] . '_valor',
                                        $tarjeta['valor']
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-white"
                                >

                                <label class="mt-4 block text-sm font-extrabold text-emerald-950">
                                    Texto
                                </label>

                                <input
                                    type="text"
                                    name="dato_{{ $tarjeta['clave'] }}_texto"
                                    required
                                    value="{{ old(
                                        'dato_' . $tarjeta['clave'] . '_texto',
                                        $tarjeta['texto']
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-white"
                                >
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 03. CONVENIO EDUCATIVO INICIAL --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Sección 03
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Convenio educativo inicial
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-6 lg:grid-cols-2">
                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Periodo
                            </label>

                            <input
                                type="text"
                                name="convenio_periodo"
                                required
                                value="{{ old(
                                    'convenio_periodo',
                                    $convenio['periodo'] ?? '1995–1999'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="convenio_titulo"
                                required
                                value="{{ old(
                                    'convenio_titulo',
                                    $convenio['titulo'] ?? 'Convenio educativo inicial'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="convenio_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >{{ old(
                                'convenio_descripcion',
                                $convenio['descripcion']
                                    ?? 'El inicio de la institución estuvo respaldado por una alianza entre la Universidad de Piura y la Primera Región Militar.'
                            ) }}</textarea>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50/40 p-5">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Entidad 1
                            </label>

                            <input
                                type="text"
                                name="convenio_entidad_1"
                                required
                                value="{{ old(
                                    'convenio_entidad_1',
                                    $convenio['entidad_1']['nombre']
                                        ?? 'Universidad de Piura'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-white"
                            >

                            <label class="mt-4 block text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="convenio_entidad_1_descripcion"
                                rows="6"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-white"
                            >{{ old(
                                'convenio_entidad_1_descripcion',
                                $convenio['entidad_1']['descripcion']
                                    ?? 'Tuvo a su cargo la selección del personal académico, la elaboración del plan de estudios y la asesoría permanente en organización, enseñanza y capacitación.'
                            ) }}</textarea>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50/40 p-5">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Entidad 2
                            </label>

                            <input
                                type="text"
                                name="convenio_entidad_2"
                                required
                                value="{{ old(
                                    'convenio_entidad_2',
                                    $convenio['entidad_2']['nombre']
                                        ?? 'Primera Región Militar'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-white"
                            >

                            <label class="mt-4 block text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="convenio_entidad_2_descripcion"
                                rows="6"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-white"
                            >{{ old(
                                'convenio_entidad_2_descripcion',
                                $convenio['entidad_2']['descripcion']
                                    ?? 'Asumió la conducción administrativa, económica y operativa del colegio, además de proporcionar infraestructura, equipamiento y material pedagógico.'
                            ) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 04. ENCABEZADO DE LÍNEA DE TIEMPO --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Sección 04
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Encabezado de la línea de tiempo
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Etiqueta superior
                            </label>

                            <input
                                type="text"
                                name="timeline_etiqueta"
                                required
                                value="{{ old(
                                    'timeline_etiqueta',
                                    $timeline['etiqueta'] ?? 'Evolución institucional'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="timeline_titulo"
                                required
                                value="{{ old(
                                    'timeline_titulo',
                                    $timeline['titulo']
                                        ?? 'Una historia de crecimiento permanente'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="timeline_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >{{ old(
                                'timeline_descripcion',
                                $timeline['descripcion']
                                    ?? 'Cada etapa representa el esfuerzo por ofrecer mejores espacios, servicios y oportunidades educativas.'
                            ) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 05. SMART SCHOOL --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Sección 05
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Smart School
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-6 lg:grid-cols-2">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Etiqueta
                                </label>

                                <input
                                    type="text"
                                    name="smart_etiqueta"
                                    required
                                    value="{{ old(
                                        'smart_etiqueta',
                                        $smartSchool['etiqueta'] ?? 'Innovación educativa'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Título
                                </label>

                                <input
                                    type="text"
                                    name="smart_titulo"
                                    required
                                    value="{{ old(
                                        'smart_titulo',
                                        $smartSchool['titulo']
                                            ?? 'Primera aula Smart School del país'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Párrafo 1
                                </label>

                                <textarea
                                    name="smart_parrafo_1"
                                    rows="5"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ old(
                                    'smart_parrafo_1',
                                    $smartSchool['parrafo_1']
                                        ?? 'El 21 de noviembre de 2013 se inauguró un aula inteligente equipada con herramientas tecnológicas interactivas para fortalecer el rendimiento y la experiencia de aprendizaje.'
                                ) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Párrafo 2
                                </label>

                                <textarea
                                    name="smart_parrafo_2"
                                    rows="5"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ old(
                                    'smart_parrafo_2',
                                    $smartSchool['parrafo_2']
                                        ?? 'El proyecto integró asesoría institucional, capacitación docente, acompañamiento pedagógico, mejora de los aprendizajes e inclusión digital para las familias.'
                                ) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Beneficios
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Escribe un beneficio por línea.
                                </p>

                                <textarea
                                    name="smart_beneficios"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ $beneficiosSmart }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Imagen opcional
                                </label>

                                @if (!empty($smartSchool['imagen']))
                                    <div
                                        class="mt-2 overflow-hidden rounded-2xl
                                               border border-amber-200 bg-gray-100"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $smartSchool['imagen']) }}"
                                            alt="Smart School"
                                            class="h-64 w-full object-cover"
                                        >
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    name="smart_imagen"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="mt-3 block w-full text-sm text-gray-600
                                           file:mr-4 file:rounded-xl
                                           file:border-0 file:bg-emerald-950
                                           file:px-4 file:py-2.5
                                           file:font-bold file:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Etiqueta de fecha
                                </label>

                                <input
                                    type="text"
                                    name="smart_fecha_etiqueta"
                                    required
                                    value="{{ old(
                                        'smart_fecha_etiqueta',
                                        $smartSchool['fecha_etiqueta']
                                            ?? 'Fecha de inauguración'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Fecha mostrada
                                </label>

                                <input
                                    type="text"
                                    name="smart_fecha"
                                    required
                                    value="{{ old(
                                        'smart_fecha',
                                        $smartSchool['fecha']
                                            ?? '21 de noviembre de 2013'
                                    ) }}"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">
                                    Participantes
                                </label>

                                <textarea
                                    name="smart_participantes"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-gray-50"
                                >{{ old(
                                    'smart_participantes',
                                    $smartSchool['participantes']
                                        ?? 'Iniciativa desarrollada con Samsung, empresarios de la educación y el Gobierno Regional de Piura.'
                                ) }}</textarea>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- 06. LEGADO INSTITUCIONAL --}}
                {{-- ================================================== --}}
                <section
                    class="rounded-[28px] border border-gray-200 bg-white
                           p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                           sm:p-8"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Sección 06
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Legado institucional
                        </h2>
                    </div>

                    <div class="mt-7 grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Etiqueta
                            </label>

                            <input
                                type="text"
                                name="legado_etiqueta"
                                required
                                value="{{ old(
                                    'legado_etiqueta',
                                    $legado['etiqueta'] ?? 'Legado institucional'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="legado_titulo"
                                required
                                value="{{ old(
                                    'legado_titulo',
                                    $legado['titulo']
                                        ?? 'Una historia construida con esfuerzo y compromiso'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Párrafo 1
                            </label>

                            <textarea
                                name="legado_parrafo_1"
                                rows="5"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >{{ old(
                                'legado_parrafo_1',
                                $legado['parrafo_1']
                                    ?? 'A lo largo de su trayectoria, la institución ha trabajado de manera permanente para mejorar sus ambientes, fortalecer la enseñanza y ofrecer mejores oportunidades de formación.'
                            ) }}</textarea>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Párrafo 2
                            </label>

                            <textarea
                                name="legado_parrafo_2"
                                rows="5"
                                required
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >{{ old(
                                'legado_parrafo_2',
                                $legado['parrafo_2']
                                    ?? 'La Dirección General continúa promoviendo el bienestar de los estudiantes mediante talleres, actividades deportivas, música, innovación tecnológica y mejoras continuas de la infraestructura.'
                            ) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Etiqueta del compromiso
                            </label>

                            <input
                                type="text"
                                name="legado_compromiso_etiqueta"
                                required
                                value="{{ old(
                                    'legado_compromiso_etiqueta',
                                    $legado['compromiso_etiqueta']
                                        ?? 'Nuestro compromiso'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">
                                Compromiso
                            </label>

                            <input
                                type="text"
                                name="legado_compromiso"
                                required
                                value="{{ old(
                                    'legado_compromiso',
                                    $legado['compromiso']
                                        ?? 'Seguir creciendo al servicio de la educación'
                                ) }}"
                                class="mt-2 h-12 w-full rounded-xl
                                       border-gray-300 bg-gray-50"
                            >
                        </div>
                    </div>
                </section>

                {{-- ================================================== --}}
                {{-- GUARDAR CONTENIDO GENERAL --}}
                {{-- ================================================== --}}
                <div
                    class="sticky bottom-4 z-30 rounded-[24px]
                           border border-emerald-900/10 bg-white/95
                           p-4 shadow-[0_20px_60px_rgba(15,23,42,0.15)]
                           backdrop-blur sm:p-5"
                >
                    <div
                        class="flex flex-col gap-4 sm:flex-row
                               sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="font-extrabold text-emerald-950">
                                Guardar reseña histórica
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Guarda los cambios generales de esta página.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex h-12 items-center
                                   justify-center rounded-xl
                                   bg-emerald-950 px-6
                                   text-sm font-extrabold text-white
                                   transition hover:bg-emerald-900"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </form>

            {{-- ====================================================== --}}
            {{-- GESTIÓN DE HITOS HISTÓRICOS --}}
            {{-- ====================================================== --}}
            <section
                class="mt-6 rounded-[28px] border border-gray-200 bg-white
                       p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)]
                       sm:p-8"
            >
                <div
                    class="flex flex-col gap-4
                           lg:flex-row lg:items-center lg:justify-between"
                >
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">
                            Línea de tiempo
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Hitos históricos
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Crea, edita, ordena y publica los acontecimientos
                            que aparecen en la línea de tiempo.
                        </p>
                    </div>

                    <div
                        class="inline-flex w-fit rounded-full
                               border border-gray-200 bg-slate-50
                               px-4 py-2 text-sm font-extrabold text-gray-600"
                    >
                        {{ $hitosHistoricos->count() }}
                        {{ $hitosHistoricos->count() === 1 ? 'hito' : 'hitos' }}
                    </div>
                </div>

                {{-- NUEVO HITO --}}
                <div x-data="{ abierto: false }" class="mt-7">
                    <button
                        type="button"
                        @click="abierto = ! abierto"
                        class="inline-flex items-center gap-2 rounded-xl
                               bg-emerald-950 px-5 py-3
                               text-sm font-extrabold text-white
                               transition hover:bg-emerald-900"
                    >
                        <span class="text-lg">+</span>
                        <span x-text="abierto ? 'Cerrar formulario' : 'Nuevo hito'"></span>
                    </button>

                    <div
                        x-show="abierto"
                        x-cloak
                        x-transition
                        class="mt-5 rounded-3xl border
                               border-emerald-100 bg-emerald-50/40 p-5"
                    >
                        <form
                            method="POST"
                            action="{{ route('admin.contenido-institucional.institucion.resena.hitos.guardar') }}"
                            enctype="multipart/form-data"
                            class="space-y-5"
                        >
                            @csrf

                            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700">
                                        Año o periodo
                                    </label>

                                    <input
                                        type="text"
                                        name="hito_anio"
                                        required
                                        maxlength="50"
                                        placeholder="Ej.: 1995 o 2000–2004"
                                        class="mt-2 h-12 w-full rounded-xl
                                               border-gray-300 bg-white"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700">
                                        Fecha opcional
                                    </label>

                                    <input
                                        type="text"
                                        name="hito_fecha"
                                        maxlength="100"
                                        placeholder="Ej.: 20 de enero"
                                        class="mt-2 h-12 w-full rounded-xl
                                               border-gray-300 bg-white"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700">
                                        Icono
                                    </label>

                                    <select
                                        name="hito_icono"
                                        required
                                        class="mt-2 h-12 w-full rounded-xl
                                               border-gray-300 bg-white"
                                    >
                                        @foreach ($iconosHistoricos as $codigo => $nombre)
                                            <option value="{{ $codigo }}">
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700">
                                        Orden
                                    </label>

                                    <input
                                        type="number"
                                        name="hito_orden"
                                        min="0"
                                        max="9999"
                                        required
                                        value="{{ ($hitosHistoricos->max('orden') ?? 0) + 1 }}"
                                        class="mt-2 h-12 w-full rounded-xl
                                               border-gray-300 bg-white"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Título
                                </label>

                                <input
                                    type="text"
                                    name="hito_titulo"
                                    required
                                    maxlength="200"
                                    class="mt-2 h-12 w-full rounded-xl
                                           border-gray-300 bg-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Descripción
                                </label>

                                <textarea
                                    name="hito_descripcion"
                                    rows="5"
                                    required
                                    maxlength="5000"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white"
                                ></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">
                                    Imagen opcional
                                </label>

                                <input
                                    type="file"
                                    name="hito_imagen"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="mt-2 block w-full rounded-xl
                                           border border-gray-300
                                           bg-white p-3 text-sm text-gray-500"
                                >

                                <p class="mt-2 text-xs text-gray-400">
                                    JPG, PNG o WEBP. Máximo 4 MB.
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="rounded-xl bg-emerald-950
                                           px-6 py-3 text-sm font-extrabold
                                           text-white transition
                                           hover:bg-emerald-900"
                                >
                                    Registrar hito
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- LISTADO DE HITOS --}}
                <div class="mt-8 space-y-5">
                    @forelse ($hitosHistoricos as $hito)
                        <article
                            x-data="{ editar: false }"
                            class="overflow-hidden rounded-3xl
                                   border border-gray-200 bg-slate-50"
                        >
                            <div
                                class="grid gap-0
                                       lg:grid-cols-[220px_minmax(0,1fr)]"
                            >
                                <div class="relative min-h-[190px] bg-gray-100">
                                    @if ($hito->imagen)
                                        <img
                                            src="{{ asset('storage/' . $hito->imagen) }}"
                                            alt="{{ $hito->titulo }}"
                                            class="absolute inset-0 h-full
                                                   w-full object-cover"
                                        >
                                    @else
                                        <div
                                            class="absolute inset-0 flex
                                                   flex-col items-center
                                                   justify-center gap-3
                                                   p-6 text-center text-gray-400"
                                        >
                                            <svg
                                                class="h-10 w-10"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            >
                                                <path d="M4 19h16"/>
                                                <path d="M6 17V7h12v10"/>
                                                <path d="M9 11h6"/>
                                            </svg>

                                            <span class="text-xs font-bold">
                                                Sin fotografía
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 sm:p-6">
                                    <div
                                        class="flex flex-col gap-4
                                               sm:flex-row sm:items-start
                                               sm:justify-between"
                                    >
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span
                                                    class="rounded-full bg-emerald-950
                                                           px-3 py-1 text-xs
                                                           font-extrabold text-white"
                                                >
                                                    {{ $hito->anio }}
                                                </span>

                                                @if ($hito->fecha_texto)
                                                    <span
                                                        class="rounded-full
                                                               bg-amber-50 px-3 py-1
                                                               text-xs font-extrabold
                                                               text-amber-700"
                                                    >
                                                        {{ $hito->fecha_texto }}
                                                    </span>
                                                @endif

                                                <span
                                                    class="rounded-full px-3 py-1
                                                           text-xs font-bold
                                                           {{ $hito->estado
                                                               ? 'bg-emerald-50 text-emerald-700'
                                                               : 'bg-gray-200 text-gray-600' }}"
                                                >
                                                    {{ $hito->estado ? 'Publicado' : 'Oculto' }}
                                                </span>
                                            </div>

                                            <h3
                                                class="mt-4 text-xl font-extrabold
                                                       text-emerald-950"
                                            >
                                                {{ $hito->titulo }}
                                            </h3>

                                            <p
                                                class="mt-3 max-w-4xl
                                                       text-sm leading-7 text-gray-600"
                                            >
                                                {{ $hito->descripcion }}
                                            </p>

                                            <p class="mt-3 text-xs font-bold text-gray-400">
                                                Icono: {{ $iconosHistoricos[$hito->icono] ?? $hito->icono }}
                                                · Orden: {{ $hito->orden }}
                                            </p>
                                        </div>

                                        <div class="flex shrink-0 flex-wrap gap-2">
                                            <button
                                                type="button"
                                                @click="editar = ! editar"
                                                class="rounded-xl border
                                                       border-emerald-200 bg-white
                                                       px-4 py-2 text-xs
                                                       font-extrabold
                                                       text-emerald-800
                                                       transition
                                                       hover:bg-emerald-50"
                                            >
                                                <span x-text="editar ? 'Cerrar' : 'Editar'"></span>
                                            </button>

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'admin.contenido-institucional.institucion.resena.hitos.estado',
                                                    $hito->id
                                                ) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border px-4 py-2
                                                           text-xs font-extrabold
                                                           transition
                                                           {{ $hito->estado
                                                               ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100'
                                                               : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}"
                                                >
                                                    {{ $hito->estado ? 'Ocultar' : 'Publicar' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- FORMULARIO DE EDICIÓN --}}
                                    <div
                                        x-show="editar"
                                        x-cloak
                                        x-transition
                                        class="mt-6 border-t
                                               border-gray-200 pt-6"
                                    >
                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.contenido-institucional.institucion.resena.hitos.actualizar',
                                                $hito->id
                                            ) }}"
                                            enctype="multipart/form-data"
                                            class="space-y-5"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700">
                                                        Año o periodo
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="hito_anio"
                                                        required
                                                        maxlength="50"
                                                        value="{{ $hito->anio }}"
                                                        class="mt-2 h-12 w-full
                                                               rounded-xl border-gray-300
                                                               bg-white"
                                                    >
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700">
                                                        Fecha
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="hito_fecha"
                                                        maxlength="100"
                                                        value="{{ $hito->fecha_texto }}"
                                                        class="mt-2 h-12 w-full
                                                               rounded-xl border-gray-300
                                                               bg-white"
                                                    >
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700">
                                                        Icono
                                                    </label>

                                                    <select
                                                        name="hito_icono"
                                                        required
                                                        class="mt-2 h-12 w-full
                                                               rounded-xl border-gray-300
                                                               bg-white"
                                                    >
                                                        @foreach ($iconosHistoricos as $codigo => $nombre)
                                                            <option
                                                                value="{{ $codigo }}"
                                                                @selected($hito->icono === $codigo)
                                                            >
                                                                {{ $nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700">
                                                        Orden
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="hito_orden"
                                                        min="0"
                                                        max="9999"
                                                        required
                                                        value="{{ $hito->orden }}"
                                                        class="mt-2 h-12 w-full
                                                               rounded-xl border-gray-300
                                                               bg-white"
                                                    >
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700">
                                                    Título
                                                </label>

                                                <input
                                                    type="text"
                                                    name="hito_titulo"
                                                    required
                                                    maxlength="200"
                                                    value="{{ $hito->titulo }}"
                                                    class="mt-2 h-12 w-full
                                                           rounded-xl border-gray-300
                                                           bg-white"
                                                >
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700">
                                                    Descripción
                                                </label>

                                                <textarea
                                                    name="hito_descripcion"
                                                    rows="5"
                                                    required
                                                    maxlength="5000"
                                                    class="mt-2 w-full rounded-xl
                                                           border-gray-300 bg-white"
                                                >{{ $hito->descripcion }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700">
                                                    Reemplazar imagen
                                                </label>

                                                <input
                                                    type="file"
                                                    name="hito_imagen"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    class="mt-2 block w-full
                                                           rounded-xl border
                                                           border-gray-300
                                                           bg-white p-3 text-sm
                                                           text-gray-500"
                                                >
                                            </div>

                                            <div class="flex justify-end">
                                                <button
                                                    type="submit"
                                                    class="rounded-xl
                                                           bg-emerald-950
                                                           px-6 py-3 text-sm
                                                           font-extrabold text-white
                                                           transition
                                                           hover:bg-emerald-900"
                                                >
                                                    Guardar hito
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div
                            class="rounded-3xl border-2 border-dashed
                                   border-gray-200 bg-slate-50
                                   px-6 py-12 text-center"
                        >
                            <h3 class="font-extrabold text-gray-700">
                                No hay hitos registrados
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                Crea el primer hito histórico usando el botón
                                “Nuevo hito”.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>
    </div>

</x-app-layout>