<x-app-layout>

    @php
        $imagenUrl = function (?string $ruta): ?string {
            if (! $ruta) {
                return null;
            }

            if (str_starts_with($ruta, 'images/')) {
                return asset($ruta);
            }

            return asset('storage/' . ltrim($ruta, '/'));
        };

        $listaTexto = function ($valor): string {
            return is_array($valor)
                ? implode(PHP_EOL, array_filter($valor))
                : '';
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
                            Convenios institucionales
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                            Registra, edita, publica u oculta los convenios y administra sus imágenes de respaldo.
                        </p>
                    </div>

                    <a
                        href="{{ route('institucion.convenios') }}"
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
                    <p class="font-extrabold">
                        Revisa los campos indicados.
                    </p>

                    <ul class="mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- NUEVO CONVENIO --}}
            <section class="mt-6 rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Nuevo convenio
                        </p>

                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                            Registrar convenio institucional
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Los convenios publicados aparecerán automáticamente en la página pública.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-3">
                        <span class="text-sm font-semibold text-gray-600">
                            Registrados
                        </span>

                        <span class="ml-2 text-xl font-extrabold text-emerald-800">
                            {{ $convenios->count() }}
                        </span>
                    </div>
                </div>

                <form
                    action="{{ route('admin.contenido-institucional.institucion.convenios.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-7"
                >
                    @csrf

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Nombre del convenio o institución
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                required
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Ej. Universidad Nacional de Piura"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Tipo de convenio
                            </label>

                            <input
                                type="text"
                                name="tipo"
                                value="{{ old('tipo') }}"
                                maxlength="200"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Ej. Convenio de cooperación interinstitucional"
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
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Describe brevemente el propósito y alcance del convenio."
                            >{{ old('descripcion') }}</textarea>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Estado visible
                            </label>

                            <input
                                type="text"
                                name="estado_texto"
                                value="{{ old('estado_texto', 'Vigente') }}"
                                required
                                maxlength="100"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Orden
                            </label>

                            <input
                                type="number"
                                name="orden"
                                value="{{ old('orden', ($convenios->max('orden') ?? 0) + 1) }}"
                                min="0"
                                max="9999"
                                required
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Fecha de inicio
                            </label>

                            <input
                                type="date"
                                name="fecha_inicio"
                                value="{{ old('fecha_inicio') }}"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Fecha de fin
                            </label>

                            <input
                                type="date"
                                name="fecha_fin"
                                value="{{ old('fecha_fin') }}"
                                class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Objetivos
                            </label>

                            <textarea
                                name="objetivos"
                                rows="6"
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Escribe un objetivo por línea"
                            >{{ old('objetivos') }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Escribe un objetivo por línea.
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Beneficios
                            </label>

                            <textarea
                                name="beneficios"
                                rows="6"
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                placeholder="Escribe un beneficio por línea"
                            >{{ old('beneficios') }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Escribe un beneficio por línea.
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">
                                Imagen del convenio
                            </label>

                            <input
                                type="file"
                                name="imagen"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="mt-3 block w-full text-sm text-gray-600"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Esta será la única imagen del convenio y aparecerá
                                en la parte superior de la tarjeta pública.
                            </p>
                        </div>
                    </div>

                    <div class="mt-7 flex justify-end">
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Guardar convenio
                        </button>
                    </div>
                </form>
            </section>

            {{-- CONVENIOS REGISTRADOS --}}
            <div class="mt-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                        Convenios institucionales
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                        Gestionar convenios registrados
                    </h2>
                </div>

                <div class="mt-6 space-y-6">
                    @forelse ($convenios as $convenio)
                        <section class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-sm">
                            <div class="grid lg:grid-cols-[0.30fr_0.70fr]">

                                {{-- COLUMNA VISUAL --}}
                                <div class="bg-emerald-950 p-5">
                                    <div class="overflow-hidden rounded-2xl bg-emerald-900">
                                        @if ($imagenUrl($convenio->imagen))
                                            <img
                                                src="{{ $imagenUrl($convenio->imagen) }}"
                                                alt="{{ $convenio->nombre }}"
                                                class="h-64 w-full object-cover"
                                            >
                                        @else
                                            <div class="flex h-64 items-center justify-center text-6xl font-extrabold text-amber-300">
                                                {{ mb_substr($convenio->nombre, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex flex-wrap items-center gap-2">
                                        <span class="rounded-full px-3 py-1.5 text-xs font-extrabold {{ $convenio->estado ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $convenio->estado ? 'Publicado' : 'Oculto' }}
                                        </span>

                                        <span class="rounded-full bg-amber-300 px-3 py-1.5 text-xs font-extrabold text-emerald-950">
                                            {{ $convenio->estado_texto ?: 'Vigente' }}
                                        </span>
                                    </div>

                                    <p class="mt-4 break-all text-xs leading-5 text-emerald-200">
                                        /institucion/convenios/{{ $convenio->slug }}
                                    </p>
                                </div>

                                {{-- EDICIÓN --}}
                                <div class="p-6 sm:p-8">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                                                Convenio
                                            </p>

                                            <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                                                {{ $convenio->nombre }}
                                            </h3>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $convenio->tipo ?: 'Sin tipo especificado' }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <form
                                                action="{{ route('admin.contenido-institucional.institucion.convenios.estado', $convenio->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border px-4 py-2.5 text-sm font-extrabold transition
                                                        {{ $convenio->estado
                                                            ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                            : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                                        }}"
                                                >
                                                    {{ $convenio->estado ? 'Ocultar' : 'Publicar' }}
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('admin.contenido-institucional.institucion.convenios.eliminar', $convenio->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este convenio?');"
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
                                        action="{{ route('admin.contenido-institucional.institucion.convenios.actualizar', $convenio->id) }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="mt-6"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div class="grid gap-5 lg:grid-cols-2">
                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Nombre
                                                </label>

                                                <input
                                                    type="text"
                                                    name="nombre"
                                                    value="{{ $convenio->nombre }}"
                                                    required
                                                    maxlength="200"
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Tipo
                                                </label>

                                                <input
                                                    type="text"
                                                    name="tipo"
                                                    value="{{ $convenio->tipo }}"
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
                                                    rows="4"
                                                    required
                                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >{{ $convenio->descripcion }}</textarea>
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Estado visible
                                                </label>

                                                <input
                                                    type="text"
                                                    name="estado_texto"
                                                    value="{{ $convenio->estado_texto ?: 'Vigente' }}"
                                                    required
                                                    maxlength="100"
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Orden
                                                </label>

                                                <input
                                                    type="number"
                                                    name="orden"
                                                    value="{{ $convenio->orden }}"
                                                    min="0"
                                                    max="9999"
                                                    required
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Fecha de inicio
                                                </label>

                                                <input
                                                    type="date"
                                                    name="fecha_inicio"
                                                    value="{{ optional($convenio->fecha_inicio)->format('Y-m-d') }}"
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Fecha de fin
                                                </label>

                                                <input
                                                    type="date"
                                                    name="fecha_fin"
                                                    value="{{ optional($convenio->fecha_fin)->format('Y-m-d') }}"
                                                    class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Objetivos
                                                </label>

                                                <textarea
                                                    name="objetivos"
                                                    rows="6"
                                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >{{ $listaTexto($convenio->objetivos) }}</textarea>
                                            </div>

                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Beneficios
                                                </label>

                                                <textarea
                                                    name="beneficios"
                                                    rows="6"
                                                    class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50"
                                                >{{ $listaTexto($convenio->beneficios) }}</textarea>
                                            </div>

                                            <div class="lg:col-span-2">
                                                <label class="text-sm font-extrabold text-emerald-950">
                                                    Cambiar imagen del convenio
                                                </label>

                                                <input
                                                    type="file"
                                                    name="imagen"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    class="mt-3 block w-full text-sm text-gray-600"
                                                >

                                                <p class="mt-2 text-xs text-gray-500">
                                                    Esta imagen reemplazará la actual y se mostrará
                                                    en la parte superior de la tarjeta pública.
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
                                No hay convenios registrados
                            </p>

                            <p class="mt-2 text-sm text-gray-500">
                                Utiliza el formulario superior para registrar el primero.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-app-layout>