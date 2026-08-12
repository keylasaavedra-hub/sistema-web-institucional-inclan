<x-app-layout>

    @php
        $datosContenido = $contenido->datos ?? [];

        $imagenUrl = function (?string $ruta): ?string {
            if (! $ruta) {
                return null;
            }

            if (str_starts_with($ruta, 'images/')) {
                return asset($ruta);
            }

            return asset('storage/' . ltrim($ruta, '/'));
        };

        $etiquetasTexto = old(
            'etiquetas',
            implode(
                PHP_EOL,
                $datosContenido['etiquetas'] ?? [
                    'Aprendizaje activo',
                    'Formación integral',
                    'Acompañamiento permanente',
                ]
            )
        );
    @endphp

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- CABECERA --}}
            <div class="relative overflow-hidden rounded-[30px] bg-emerald-950 px-6 py-8 shadow-[0_20px_60px_rgba(6,78,59,0.14)] sm:px-8 lg:px-10">
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-amber-300/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-amber-300">
                            Contenido institucional
                        </p>

                        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">
                            Nuestra forma de enseñar
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                            Administra la propuesta educativa, los principios pedagógicos y las etapas del proceso de aprendizaje.
                        </p>
                    </div>

                    <a
                        href="{{ route('institucion.nuestra-forma-de-ensenar') }}"
                        target="_blank"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-amber-300 bg-white/10 px-5 text-sm font-extrabold text-white transition hover:bg-white/20"
                    >
                        Ver página pública
                    </a>
                </div>
            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div
                    x-data="{ visible: true }"
                    x-show="visible"
                    x-init="setTimeout(() => visible = false, 4000)"
                    x-transition
                    class="fixed right-6 top-6 z-[9999] w-[calc(100%-3rem)] max-w-md"
                >
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
                            class="text-gray-400 hover:text-gray-700"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            @endif

            {{-- ERRORES --}}
            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                    <p class="font-extrabold">Revisa los campos indicados.</p>

                    <ul class="mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CONTENIDO GENERAL --}}
            <section class="mt-6 rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Página pública
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                        Contenido general
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Edita la cabecera, imagen principal, secciones informativas y bloque final.
                    </p>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.actualizar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-7"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta principal
                            </label>

                            <input
                                type="text"
                                name="etiqueta"
                                value="{{ old('etiqueta', $contenido->subtitulo ?: 'Propuesta educativa') }}"
                                required
                                maxlength="120"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título principal
                            </label>

                            <input
                                type="text"
                                name="titulo"
                                value="{{ old('titulo', $contenido->titulo ?: 'Nuestra forma de enseñar') }}"
                                required
                                maxlength="180"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Primer párrafo
                            </label>

                            <textarea
                                name="descripcion_1"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('descripcion_1', $contenido->contenido ?: 'Nuestra propuesta educativa busca que cada estudiante aprenda de manera activa, comprenda lo que estudia y aplique sus conocimientos en situaciones reales.') }}</textarea>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Segundo párrafo
                            </label>

                            <textarea
                                name="descripcion_2"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('descripcion_2', $datosContenido['descripcion_2'] ?? 'Promovemos una formación integral que fortalece las competencias académicas, los valores, la autonomía, la creatividad y la responsabilidad ciudadana.') }}</textarea>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiquetas destacadas
                            </label>

                            <textarea
                                name="etiquetas"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Una etiqueta por línea"
                            >{{ $etiquetasTexto }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Escribe una etiqueta por línea.
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta de la imagen
                            </label>

                            <input
                                type="text"
                                name="imagen_etiqueta"
                                value="{{ old('imagen_etiqueta', $datosContenido['imagen_etiqueta'] ?? 'Enseñanza centrada en el estudiante') }}"
                                required
                                maxlength="150"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título sobre la imagen
                            </label>

                            <input
                                type="text"
                                name="imagen_titulo"
                                value="{{ old('imagen_titulo', $datosContenido['imagen_titulo'] ?? 'Aprender, participar y transformar') }}"
                                required
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Imagen principal
                            </label>

                            @if ($imagenUrl($contenido->imagen))
                                <div class="mt-3 overflow-hidden rounded-2xl border border-gray-200 bg-gray-50">
                                    <img
                                        src="{{ $imagenUrl($contenido->imagen) }}"
                                        alt="Imagen principal actual"
                                        class="h-64 w-full object-cover"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                name="imagen_principal"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-sm text-gray-600"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Recomendado: fotografía horizontal. JPG, PNG o WEBP. Máximo 4 MB.
                            </p>
                        </div>

                        {{-- PRINCIPIOS - ENCABEZADO --}}
                        <div class="lg:col-span-2 mt-3 border-t border-gray-200 pt-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                Principios pedagógicos
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta
                            </label>

                            <input
                                type="text"
                                name="principios_etiqueta"
                                value="{{ old('principios_etiqueta', $datosContenido['principios_etiqueta'] ?? 'Principios pedagógicos') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="principios_titulo"
                                value="{{ old('principios_titulo', $datosContenido['principios_titulo'] ?? '¿Cómo desarrollamos el aprendizaje?') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="principios_descripcion"
                                rows="3"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('principios_descripcion', $datosContenido['principios_descripcion'] ?? 'Nuestro trabajo pedagógico se apoya en principios que favorecen el desarrollo integral de cada estudiante.') }}</textarea>
                        </div>

                        {{-- PROCESO - ENCABEZADO --}}
                        <div class="lg:col-span-2 mt-3 border-t border-gray-200 pt-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                Proceso de aprendizaje
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta
                            </label>

                            <input
                                type="text"
                                name="proceso_etiqueta"
                                value="{{ old('proceso_etiqueta', $datosContenido['proceso_etiqueta'] ?? 'Proceso de aprendizaje') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="proceso_titulo"
                                value="{{ old('proceso_titulo', $datosContenido['proceso_titulo'] ?? 'Una experiencia organizada y progresiva') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="proceso_descripcion"
                                rows="3"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('proceso_descripcion', $datosContenido['proceso_descripcion'] ?? 'Cada experiencia educativa permite al estudiante explorar, comprender, aplicar y reflexionar sobre lo aprendido.') }}</textarea>
                        </div>

                        {{-- COMPROMISO --}}
                        <div class="lg:col-span-2 mt-3 border-t border-gray-200 pt-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                Bloque final
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta
                            </label>

                            <input
                                type="text"
                                name="compromiso_etiqueta"
                                value="{{ old('compromiso_etiqueta', $datosContenido['compromiso_etiqueta'] ?? 'Nuestro compromiso') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="compromiso_titulo"
                                value="{{ old('compromiso_titulo', $datosContenido['compromiso_titulo'] ?? 'Formamos estudiantes preparados para la vida') }}"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="compromiso_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('compromiso_descripcion', $datosContenido['compromiso_descripcion'] ?? 'Acompañamos a nuestros estudiantes para que desarrollen conocimientos, habilidades, valores y actitudes que les permitan afrontar retos, tomar decisiones responsables y contribuir positivamente con su comunidad.') }}</textarea>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Imagen opcional del compromiso
                            </label>

                            @if ($imagenUrl($datosContenido['compromiso_imagen'] ?? null))
                                <div class="mt-3 overflow-hidden rounded-2xl border border-gray-200 bg-gray-50">
                                    <img
                                        src="{{ $imagenUrl($datosContenido['compromiso_imagen']) }}"
                                        alt="Imagen actual del compromiso"
                                        class="h-56 w-full object-cover"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                name="compromiso_imagen"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-sm text-gray-600"
                            >
                        </div>
                    </div>

                    <div class="mt-7 flex justify-end">
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Guardar contenido general
                        </button>
                    </div>
                </form>
            </section>

            {{-- AGREGAR PRINCIPIO --}}
            <section class="mt-8 rounded-[28px] border border-emerald-200 bg-emerald-50/50 p-6 shadow-sm sm:p-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Nuevo registro
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                        Agregar principio pedagógico
                    </h2>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.principios.guardar') }}"
                    method="POST"
                    class="mt-7"
                >
                    @csrf

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Título</label>
                            <input
                                type="text"
                                name="titulo"
                                required
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Orden</label>
                            <input
                                type="number"
                                name="orden"
                                value="{{ ($principios->max('orden') ?? 0) + 1 }}"
                                min="0"
                                max="9999"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">Descripción</label>
                            <textarea
                                name="descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-white"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Agregar principio
                        </button>
                    </div>
                </form>
            </section>

            {{-- PRINCIPIOS REGISTRADOS --}}
            <section class="mt-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Principios pedagógicos
                        </p>

                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                            Principios registrados
                        </h2>
                    </div>

                    <span class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm font-extrabold text-emerald-800">
                        {{ $principios->count() }}
                    </span>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-2">
                    @forelse ($principios as $principio)
                        <article class="rounded-[26px] border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $principio->estado ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                        {{ $principio->estado ? 'Publicado' : 'Oculto' }}
                                    </span>

                                    <h3 class="mt-3 text-xl font-extrabold text-emerald-950">
                                        {{ $principio->titulo }}
                                    </h3>
                                </div>

                                <span class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-extrabold text-amber-700">
                                    Orden {{ $principio->orden }}
                                </span>
                            </div>

                            <form
                                action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.principios.actualizar', $principio->id) }}"
                                method="POST"
                                class="mt-5"
                            >
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-extrabold text-emerald-950">Título</label>
                                        <input
                                            type="text"
                                            name="titulo"
                                            value="{{ $principio->titulo }}"
                                            required
                                            class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >
                                    </div>

                                    <div>
                                        <label class="text-sm font-extrabold text-emerald-950">Descripción</label>
                                        <textarea
                                            name="descripcion"
                                            rows="4"
                                            required
                                            class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >{{ $principio->descripcion }}</textarea>
                                    </div>

                                    <div>
                                        <label class="text-sm font-extrabold text-emerald-950">Orden</label>
                                        <input
                                            type="number"
                                            name="orden"
                                            value="{{ $principio->orden }}"
                                            min="0"
                                            max="9999"
                                            required
                                            class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >
                                    </div>
                                </div>

                                <div class="mt-5 flex justify-end">
                                    <button
                                        type="submit"
                                        class="rounded-xl bg-emerald-950 px-5 py-2.5 text-sm font-extrabold text-white"
                                    >
                                        Guardar cambios
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 flex flex-wrap justify-end gap-2 border-t border-gray-100 pt-4">
                                <form
                                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.principios.estado', $principio->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="rounded-xl border px-4 py-2.5 text-sm font-extrabold transition
                                            {{ $principio->estado
                                                ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                            }}"
                                    >
                                        {{ $principio->estado ? 'Ocultar' : 'Publicar' }}
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.principios.eliminar', $principio->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este principio pedagógico?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-extrabold text-red-700 hover:bg-red-100"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="lg:col-span-2 rounded-[26px] border border-dashed border-gray-300 bg-white p-10 text-center">
                            <p class="font-extrabold text-emerald-950">No hay principios registrados.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- AGREGAR ETAPA --}}
            <section class="mt-10 rounded-[28px] border border-amber-200 bg-amber-50/40 p-6 shadow-sm sm:p-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Nuevo registro
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                        Agregar etapa de aprendizaje
                    </h2>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.etapas.guardar') }}"
                    method="POST"
                    class="mt-7"
                >
                    @csrf

                    <div class="grid gap-5 lg:grid-cols-3">
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Número</label>
                            <input
                                type="text"
                                name="numero"
                                value="{{ str_pad(($etapas->max('orden') ?? 0) + 1, 2, '0', STR_PAD_LEFT) }}"
                                required
                                maxlength="20"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Título</label>
                            <input
                                type="text"
                                name="titulo"
                                required
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Orden</label>
                            <input
                                type="number"
                                name="orden"
                                value="{{ ($etapas->max('orden') ?? 0) + 1 }}"
                                min="0"
                                max="9999"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div class="lg:col-span-3">
                            <label class="text-sm font-extrabold text-emerald-950">Descripción</label>
                            <textarea
                                name="descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-white"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Agregar etapa
                        </button>
                    </div>
                </form>
            </section>

            {{-- ETAPAS REGISTRADAS --}}
            <section class="mt-8 pb-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Proceso de aprendizaje
                        </p>

                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                            Etapas registradas
                        </h2>
                    </div>

                    <span class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-extrabold text-amber-700">
                        {{ $etapas->count() }}
                    </span>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-2">
                    @forelse ($etapas as $etapa)
                        <article class="rounded-[26px] border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-amber-300 bg-emerald-950 text-sm font-extrabold text-amber-300">
                                        {{ $etapa->numero }}
                                    </span>

                                    <div>
                                        <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $etapa->estado ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $etapa->estado ? 'Publicado' : 'Oculto' }}
                                        </span>

                                        <h3 class="mt-2 text-xl font-extrabold text-emerald-950">
                                            {{ $etapa->titulo }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <form
                                action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.etapas.actualizar', $etapa->id) }}"
                                method="POST"
                                class="mt-5"
                            >
                                @csrf
                                @method('PUT')

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-sm font-extrabold text-emerald-950">Número</label>
                                        <input
                                            type="text"
                                            name="numero"
                                            value="{{ $etapa->numero }}"
                                            required
                                            class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >
                                    </div>

                                    <div>
                                        <label class="text-sm font-extrabold text-emerald-950">Orden</label>
                                        <input
                                            type="number"
                                            name="orden"
                                            value="{{ $etapa->orden }}"
                                            min="0"
                                            max="9999"
                                            required
                                            class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-extrabold text-emerald-950">Título</label>
                                        <input
                                            type="text"
                                            name="titulo"
                                            value="{{ $etapa->titulo }}"
                                            required
                                            class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-extrabold text-emerald-950">Descripción</label>
                                        <textarea
                                            name="descripcion"
                                            rows="4"
                                            required
                                            class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                        >{{ $etapa->descripcion }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-5 flex justify-end">
                                    <button
                                        type="submit"
                                        class="rounded-xl bg-emerald-950 px-5 py-2.5 text-sm font-extrabold text-white"
                                    >
                                        Guardar cambios
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 flex flex-wrap justify-end gap-2 border-t border-gray-100 pt-4">
                                <form
                                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.etapas.estado', $etapa->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="rounded-xl border px-4 py-2.5 text-sm font-extrabold transition
                                            {{ $etapa->estado
                                                ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                            }}"
                                    >
                                        {{ $etapa->estado ? 'Ocultar' : 'Publicar' }}
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.contenido-institucional.institucion.nuestra-forma-de-ensenar.etapas.eliminar', $etapa->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta etapa?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-extrabold text-red-700 hover:bg-red-100"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="lg:col-span-2 rounded-[26px] border border-dashed border-gray-300 bg-white p-10 text-center">
                            <p class="font-extrabold text-emerald-950">No hay etapas registradas.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

</x-app-layout>