<x-app-layout>

    @php
        $identidad = $contenidos->get('identidad_institucional');
        $mision = $contenidos->get('mision');
        $vision = $contenidos->get('vision');
        $valores = $contenidos->get('valores');
        $enfoque = $contenidos->get('enfoque_inicio');

        $pilaresMision = old(
            'mision_pilares',
            implode(PHP_EOL, $mision?->datos['pilares'] ?? [
                'Aprendizaje significativo y pensamiento crítico.',
                'Formación integral, humana e inclusiva.',
                'Uso responsable de la tecnología educativa.',
                'Mejora continua de los procesos pedagógicos.',
            ])
        );

        $pilaresVision = old(
            'vision_pilares',
            implode(PHP_EOL, $vision?->datos['pilares'] ?? [
                'Educación moderna y de calidad.',
                'Reconocimiento e integración nacional.',
                'Formación ética, cívica y patriótica.',
                'Comunidad preparada para nuevos desafíos.',
            ])
        );

        $itemsValores = $valores?->datos['items'] ?? [
            ['nombre' => 'Vocación de servicio', 'descripcion' => 'Atendemos las necesidades de nuestra comunidad educativa con disposición, empatía y compromiso.'],
            ['nombre' => 'Disciplina', 'descripcion' => 'Actuamos con orden, constancia y respeto por las normas que orientan nuestra convivencia.'],
            ['nombre' => 'Integridad', 'descripcion' => 'Procedemos con honestidad, coherencia y transparencia en todas nuestras acciones.'],
            ['nombre' => 'Compromiso', 'descripcion' => 'Participamos activamente en la formación y el bienestar de nuestros estudiantes.'],
            ['nombre' => 'Responsabilidad', 'descripcion' => 'Cumplimos nuestros deberes con puntualidad, dedicación y sentido institucional.'],
            ['nombre' => 'Excelencia', 'descripcion' => 'Buscamos mejorar continuamente nuestros procesos educativos y resultados.'],
        ];

        $textoValores = old(
            'valores_items',
            collect($itemsValores)
                ->map(fn ($item) => ($item['nombre'] ?? '') . ' | ' . ($item['descripcion'] ?? ''))
                ->implode(PHP_EOL)
        );

        $itemsEnfoque = $enfoque?->datos['items'] ?? [
            ['titulo' => 'Tecnologías educativas', 'texto' => 'Recursos digitales para fortalecer los aprendizajes.'],
            ['titulo' => 'Evaluación formativa', 'texto' => 'Seguimiento y retroalimentación permanente.'],
            ['titulo' => 'Acompañamiento docente', 'texto' => 'Mejora continua de la práctica pedagógica.'],
            ['titulo' => 'Educación inclusiva', 'texto' => 'Atención equitativa y formación integral.'],
        ];

        $textoEnfoque = old(
            'enfoque_items',
            collect($itemsEnfoque)
                ->map(fn ($item) => ($item['titulo'] ?? '') . ' | ' . ($item['texto'] ?? ''))
                ->implode(PHP_EOL)
        );

        $imagenContenido = function (?string $ruta, string $fallback): string {
            return $ruta
                ? asset('storage/' . ltrim($ruta, '/'))
                : asset($fallback);
        };
    @endphp

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="relative overflow-hidden rounded-[30px] bg-emerald-950 px-6 py-8 shadow-[0_20px_60px_rgba(6,78,59,0.14)] sm:px-8 lg:px-10">
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-amber-300/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-amber-300">
                            Contenido institucional
                        </p>

                        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">
                            Misión, visión y valores
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                            Administra el contenido de identidad institucional, misión, visión, valores y enfoque educativo.
                        </p>
                    </div>

                    <a
                        href="{{ route('institucion.mision-vision-valores') }}"
                        target="_blank"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-amber-300 bg-white/10 px-5 text-sm font-extrabold text-white transition hover:bg-white/20">
                        Ver página pública
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    x-data="{ visible: true }"
                    x-show="visible"
                    x-init="setTimeout(() => visible = false, 4000)"
                    x-transition
                    class="fixed right-6 top-6 z-[9999] w-[calc(100%-3rem)] max-w-md">

                    <div class="flex items-start gap-4 rounded-2xl border border-emerald-200 bg-white p-5 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                            ✓
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="font-extrabold text-emerald-950">
                                Cambios guardados
                            </p>
                            <p class="mt-1 text-sm leading-5 text-gray-600">
                                {{ session('success') }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="visible = false"
                            class="text-gray-400 transition hover:text-gray-700">
                            ✕
                        </button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5">
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
                id="form-identidad-institucional"
                method="POST"
                action="{{ route('admin.contenido-institucional.institucion.mision-vision-valores.actualizar') }}"
                enctype="multipart/form-data"
                class="mt-6 space-y-6">

                @csrf
                @method('PUT')

                {{-- 01 ENCABEZADO --}}
                <section class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)] sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">Sección 01</p>
                    <h2 class="mt-1 text-xl font-extrabold text-emerald-950">Encabezado de la página</h2>

                    <div class="mt-6 grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">Etiqueta superior</label>
                            <input
                                name="identidad_etiqueta"
                                type="text"
                                required
                                value="{{ old('identidad_etiqueta', $identidad?->subtitulo ?? 'Nuestra identidad institucional') }}"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-emerald-950">Título</label>
                            <input
                                name="identidad_titulo"
                                type="text"
                                required
                                value="{{ old('identidad_titulo', $identidad?->titulo ?? 'Misión, visión y valores') }}"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-extrabold text-emerald-950">Descripción</label>
                            <textarea
                                name="identidad_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('identidad_descripcion', $identidad?->contenido ?? 'Los principios que orientan nuestra labor educativa, fortalecen nuestra identidad y guían la formación integral de los estudiantes.') }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- 02 MISIÓN --}}
                <section class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)] sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">Sección 02</p>
                    <h2 class="mt-1 text-xl font-extrabold text-emerald-950">Misión</h2>

                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Etiqueta</label>
                                <input
                                    name="mision_etiqueta"
                                    type="text"
                                    required
                                    value="{{ old('mision_etiqueta', $mision?->subtitulo ?? 'Lo que hacemos') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Título</label>
                                <input
                                    name="mision_titulo"
                                    type="text"
                                    required
                                    value="{{ old('mision_titulo', $mision?->titulo ?? 'Formamos estudiantes de manera integral') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Descripción</label>
                                <textarea
                                    name="mision_contenido"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('mision_contenido', $mision?->contenido ?? 'Brindar un servicio educativo de calidad mediante procesos permanentes de mejora continua, aplicando un modelo pedagógico Socio Constructivista Humanista.') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Pilares</label>
                                <p class="mt-1 text-xs text-gray-500">Escribe un pilar por línea.</p>
                                <textarea
                                    name="mision_pilares"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ $pilaresMision }}</textarea>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-extrabold text-emerald-950">Imagen actual</p>
                            <div class="mt-2 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    src="{{ $imagenContenido($mision?->imagen, 'images/mision.png') }}"
                                    alt="Misión"
                                    class="h-80 w-full object-cover">
                            </div>

                            <input
                                name="mision_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600">
                        </div>
                    </div>
                </section>

                {{-- 03 VISIÓN --}}
                <section class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)] sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">Sección 03</p>
                    <h2 class="mt-1 text-xl font-extrabold text-emerald-950">Visión</h2>

                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Etiqueta</label>
                                <input
                                    name="vision_etiqueta"
                                    type="text"
                                    required
                                    value="{{ old('vision_etiqueta', $vision?->subtitulo ?? 'Hacia dónde avanzamos') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Título</label>
                                <input
                                    name="vision_titulo"
                                    type="text"
                                    required
                                    value="{{ old('vision_titulo', $vision?->titulo ?? 'Una institución moderna y reconocida') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Descripción</label>
                                <textarea
                                    name="vision_contenido"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('vision_contenido', $vision?->contenido ?? 'Consolidarnos como una institución educativa de calidad, moderna, reconocida e integrada al sistema educativo nacional.') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Pilares</label>
                                <p class="mt-1 text-xs text-gray-500">Escribe un pilar por línea.</p>
                                <textarea
                                    name="vision_pilares"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ $pilaresVision }}</textarea>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-extrabold text-emerald-950">Imagen actual</p>
                            <div class="mt-2 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    src="{{ $imagenContenido($vision?->imagen, 'images/vision.png') }}"
                                    alt="Visión"
                                    class="h-80 w-full object-cover">
                            </div>

                            <input
                                name="vision_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600">
                        </div>
                    </div>
                </section>

                {{-- 04 VALORES --}}
                <section class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)] sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">Sección 04</p>
                    <h2 class="mt-1 text-xl font-extrabold text-emerald-950">Valores institucionales</h2>

                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Etiqueta</label>
                                <input
                                    name="valores_etiqueta"
                                    type="text"
                                    required
                                    value="{{ old('valores_etiqueta', $valores?->subtitulo ?? 'Nuestra forma de actuar') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Título</label>
                                <input
                                    name="valores_titulo"
                                    type="text"
                                    required
                                    value="{{ old('valores_titulo', $valores?->titulo ?? 'Principios que fortalecen nuestra comunidad') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Descripción</label>
                                <textarea
                                    name="valores_contenido"
                                    rows="5"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('valores_contenido', $valores?->contenido ?? 'Promovemos valores que fortalecen la convivencia, el servicio y la excelencia.') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Valores y descripciones</label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Un valor por línea usando: Nombre | Descripción
                                </p>
                                <textarea
                                    name="valores_items"
                                    rows="10"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ $textoValores }}</textarea>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-extrabold text-emerald-950">Imagen actual</p>
                            <div class="mt-2 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    src="{{ $imagenContenido($valores?->imagen, 'images/valores.png') }}"
                                    alt="Valores"
                                    class="h-80 w-full object-cover">
                            </div>

                            <input
                                name="valores_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600">
                        </div>
                    </div>
                </section>

                {{-- 05 ENFOQUE --}}
                <section class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-[0_18px_50px_rgba(15,23,42,0.05)] sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-amber-600">Sección 05</p>
                    <h2 class="mt-1 text-xl font-extrabold text-emerald-950">Enfoque institucional</h2>

                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Etiqueta</label>
                                <input
                                    name="enfoque_etiqueta"
                                    type="text"
                                    required
                                    value="{{ old('enfoque_etiqueta', $enfoque?->subtitulo ?? 'Enfoque institucional') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Título</label>
                                <input
                                    name="enfoque_titulo"
                                    type="text"
                                    required
                                    value="{{ old('enfoque_titulo', $enfoque?->titulo ?? 'Innovación, acompañamiento y mejora continua') }}"
                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Descripción</label>
                                <textarea
                                    name="enfoque_contenido"
                                    rows="6"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('enfoque_contenido', $enfoque?->contenido ?? 'Fortalecemos nuestros procesos educativos mediante tecnologías de la información, evaluación formativa y acompañamiento docente.') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-extrabold text-emerald-950">Tarjetas del enfoque</label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Una tarjeta por línea usando: Título | Descripción
                                </p>
                                <textarea
                                    name="enfoque_items"
                                    rows="8"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ $textoEnfoque }}</textarea>
                            </div>

                            <div class="grid gap-5 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-extrabold text-emerald-950">Etiqueta del compromiso</label>
                                    <input
                                        name="enfoque_compromiso_etiqueta"
                                        type="text"
                                        required
                                        value="{{ old('enfoque_compromiso_etiqueta', $enfoque?->datos['compromiso_etiqueta'] ?? 'Compromiso educativo') }}"
                                        class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-extrabold text-emerald-950">Compromiso</label>
                                    <input
                                        name="enfoque_compromiso"
                                        type="text"
                                        required
                                        value="{{ old('enfoque_compromiso', $enfoque?->datos['compromiso'] ?? 'Aprender · Innovar · Mejorar') }}"
                                        class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-extrabold text-emerald-950">Imagen actual</p>
                            <div class="mt-2 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    src="{{ $imagenContenido($enfoque?->imagen, 'images/enfoque-institucional.png') }}"
                                    alt="Enfoque institucional"
                                    class="h-80 w-full object-cover">
                            </div>

                            <input
                                name="enfoque_imagen"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-4 block w-full text-sm text-gray-600">
                        </div>
                    </div>
                </section>

            </form>

            <div class="sticky bottom-4 z-30 mt-6 rounded-[24px] border border-emerald-900/10 bg-white/95 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.15)] backdrop-blur sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-extrabold text-emerald-950">
                            Guardar identidad institucional
                        </p>
php artisan optimize:clear
                        <p class="mt-1 text-sm text-gray-500">
                            Guarda todos los cambios de esta página institucional.
                        </p>
                    </div>

                    <button
                        type="submit"
                        form="form-identidad-institucional"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-emerald-950 px-6 text-sm font-extrabold text-white shadow-lg shadow-emerald-950/10 transition hover:bg-emerald-900 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                        ✓ Guardar cambios
                    </button>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>