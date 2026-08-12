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
                            Comunidad educativa
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                            Edita el contenido general y administra los grupos que se muestran en la página pública.
                        </p>
                    </div>

                    <a
                        href="{{ route('institucion.comunidad-educativa') }}"
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
                        Estos textos aparecerán en la cabecera y bloques informativos de Comunidad educativa.
                    </p>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.comunidad-educativa.actualizar') }}"
                    method="POST"
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
                                value="{{ old('etiqueta', $contenido->subtitulo ?: 'Nuestra comunidad') }}"
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
                                value="{{ old('titulo', $contenido->titulo ?: 'Comunidad educativa') }}"
                                required
                                maxlength="180"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción principal
                            </label>

                            <textarea
                                name="descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('descripcion', $contenido->contenido ?: 'Nuestra comunidad educativa está conformada por personas comprometidas con el aprendizaje, el bienestar y el desarrollo integral de los estudiantes.') }}</textarea>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta de trabajo colaborativo
                            </label>

                            <input
                                type="text"
                                name="trabajo_etiqueta"
                                value="{{ old('trabajo_etiqueta', $datosContenido['trabajo_etiqueta'] ?? 'Trabajo colaborativo') }}"
                                required
                                maxlength="120"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título de trabajo colaborativo
                            </label>

                            <input
                                type="text"
                                name="trabajo_titulo"
                                value="{{ old('trabajo_titulo', $datosContenido['trabajo_titulo'] ?? 'Un equipo que trabaja por nuestros estudiantes') }}"
                                required
                                maxlength="180"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción de trabajo colaborativo
                            </label>

                            <textarea
                                name="trabajo_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('trabajo_descripcion', $datosContenido['trabajo_descripcion'] ?? 'Cada integrante de nuestra institución cumple un rol importante y contribuye al desarrollo académico, personal y social de los estudiantes.') }}</textarea>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Etiqueta de cierre
                            </label>

                            <input
                                type="text"
                                name="cierre_etiqueta"
                                value="{{ old('cierre_etiqueta', $datosContenido['cierre_etiqueta'] ?? 'Compromiso compartido') }}"
                                required
                                maxlength="120"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título de cierre
                            </label>

                            <input
                                type="text"
                                name="cierre_titulo"
                                value="{{ old('cierre_titulo', $datosContenido['cierre_titulo'] ?? 'Juntos construimos una mejor comunidad educativa') }}"
                                required
                                maxlength="180"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción de cierre
                            </label>

                            <textarea
                                name="cierre_descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                            >{{ old('cierre_descripcion', $datosContenido['cierre_descripcion'] ?? 'El compromiso, la coordinación y la participación de todos fortalecen el crecimiento de nuestra institución.') }}</textarea>
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

            {{-- NUEVO GRUPO --}}
            <section class="mt-8 rounded-[28px] border border-emerald-200 bg-emerald-50/50 p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Nuevo registro
                        </p>

                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                            Agregar grupo
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Crea un nuevo grupo para mostrarlo en la página pública.
                        </p>
                    </div>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.comunidad-educativa.grupos.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-7"
                >
                    @csrf

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Título
                            </label>

                            <input
                                type="text"
                                name="titulo"
                                value="{{ old('titulo') }}"
                                required
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                                placeholder="Ej. Auxiliares de educación"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Orden
                            </label>

                            <input
                                type="number"
                                name="orden"
                                value="{{ old('orden', ($grupos->max('orden') ?? 0) + 1) }}"
                                min="0"
                                max="9999"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-white"
                            >
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Descripción
                            </label>

                            <textarea
                                name="descripcion"
                                rows="4"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-white"
                                placeholder="Describe la función de este grupo dentro de la comunidad educativa."
                            >{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="text-sm font-extrabold text-emerald-950">
                                Imagen
                            </label>

                            <input
                                type="file"
                                name="imagen"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-sm text-gray-600"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                JPG, PNG o WEBP. Máximo 4 MB.
                            </p>
                        </div>
                    </div>

                    <div class="mt-7 flex justify-end">
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Agregar grupo
                        </button>
                    </div>
                </form>
            </section>

            {{-- GRUPOS --}}
            <div class="mt-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Integrantes
                        </p>

                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                            Grupos de la comunidad educativa
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Cambia el texto, la imagen, el orden o la visibilidad de cada grupo.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-3">
                        <span class="text-sm font-semibold text-gray-600">
                            Registrados
                        </span>

                        <span class="ml-2 text-xl font-extrabold text-emerald-800">
                            {{ $grupos->count() }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 space-y-6">
                    @forelse ($grupos as $grupo)
                        <section class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-sm">
                            <div class="grid lg:grid-cols-[0.30fr_0.70fr]">

                                {{-- PREVISUALIZACIÓN --}}
                                <div class="bg-emerald-950 p-5">
                                    <div class="overflow-hidden rounded-2xl bg-emerald-900">
                                        @if ($imagenUrl($grupo->imagen))
                                            <img
                                                src="{{ $imagenUrl($grupo->imagen) }}"
                                                alt="{{ $grupo->titulo }}"
                                                class="h-64 w-full object-cover"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            >
                                        @endif

                                        <div
                                            class="{{ $imagenUrl($grupo->imagen) ? 'hidden' : 'flex' }} h-64 items-center justify-center bg-emerald-900 text-5xl font-extrabold text-amber-300"
                                        >
                                            {{ mb_substr($grupo->titulo, 0, 1) }}
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-wrap items-center gap-2">
                                        <span class="rounded-full px-3 py-1.5 text-xs font-extrabold {{ $grupo->estado ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $grupo->estado ? 'Publicado' : 'Oculto' }}
                                        </span>

                                        <span class="rounded-full bg-amber-300 px-3 py-1.5 text-xs font-extrabold text-emerald-950">
                                            Orden {{ $grupo->orden }}
                                        </span>
                                    </div>

                                    <p class="mt-4 break-all text-xs leading-5 text-emerald-200">
                                        {{ $grupo->slug }}
                                    </p>
                                </div>

                                {{-- FORMULARIO --}}
                                <div class="p-6 sm:p-8">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                                Grupo
                                            </p>

                                            <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                                                {{ $grupo->titulo }}
                                            </h3>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <form
                                                action="{{ route('admin.contenido-institucional.institucion.comunidad-educativa.grupos.estado', $grupo->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border px-4 py-2.5 text-sm font-extrabold transition
                                                        {{ $grupo->estado
                                                            ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                            : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                                        }}"
                                                >
                                                    {{ $grupo->estado ? 'Ocultar' : 'Publicar' }}
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('admin.contenido-institucional.institucion.comunidad-educativa.grupos.eliminar', $grupo->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este grupo? Esta acción no se puede deshacer.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-extrabold text-red-700 transition hover:bg-red-100"
                                                >
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form
                                        action="{{ route('admin.contenido-institucional.institucion.comunidad-educativa.grupos.actualizar', $grupo->id) }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="mt-6"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div class="grid gap-5 lg:grid-cols-2">
                                            <div class="lg:col-span-2">
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Título
                                                </label>

                                                <input
                                                    type="text"
                                                    name="titulo"
                                                    value="{{ $grupo->titulo }}"
                                                    required
                                                    maxlength="200"
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div class="lg:col-span-2">
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Descripción
                                                </label>

                                                <textarea
                                                    name="descripcion"
                                                    rows="5"
                                                    required
                                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >{{ $grupo->descripcion }}</textarea>
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Orden
                                                </label>

                                                <input
                                                    type="number"
                                                    name="orden"
                                                    value="{{ $grupo->orden }}"
                                                    min="0"
                                                    max="9999"
                                                    required
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Cambiar imagen
                                                </label>

                                                <input
                                                    type="file"
                                                    name="imagen"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    class="mt-3 block w-full text-sm text-gray-600"
                                                >

                                                <p class="mt-2 text-xs text-gray-500">
                                                    Esta imagen se mostrará en la tarjeta pública del grupo.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <button
                                                type="submit"
                                                class="rounded-xl bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                                            >
                                                Guardar cambios
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    @empty
                        <div class="rounded-[28px] border border-dashed border-gray-300 bg-white px-6 py-12 text-center shadow-sm">
                            <p class="text-lg font-extrabold text-emerald-950">
                                No hay grupos registrados
                            </p>

                            <p class="mt-2 text-sm text-gray-500">
                                Ejecuta el seeder de Comunidad educativa para cargar los grupos iniciales.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-app-layout>