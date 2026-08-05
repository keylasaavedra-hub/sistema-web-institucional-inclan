<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión documental
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar documento
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza sus datos y administra el historial de versiones.
                </p>
            </div>

            <a
                href="{{ route('admin.documentos.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-extrabold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
                    <p class="text-sm font-extrabold text-red-700">
                        Revisa los siguientes campos:
                    </p>

                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $archivoActualExiste = $documento->archivo
                    && \Illuminate\Support\Facades\Storage::disk('public')->exists($documento->archivo);

                $tamanoActual = $documento->tamano_bytes
                    ? number_format($documento->tamano_bytes / 1024 / 1024, 2) . ' MB'
                    : 'No registrado';
            @endphp

            <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                <div class="space-y-8">

                    {{-- FORMULARIO DE DATOS --}}
                    <form
                        action="{{ route('admin.documentos.actualizar', $documento) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M6 3h9l3 3v15H6z"/>
                                        <path d="M14 3v4h4"/>
                                        <path d="M9 12h6M9 16h4"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Datos del documento
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Modifica la información descriptiva y su publicación.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="categoria_documento_id" class="mb-2 block text-sm font-bold text-gray-700">
                                        Categoría
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="categoria_documento_id"
                                        name="categoria_documento_id"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        @foreach ($categorias as $categoria)
                                            <option
                                                value="{{ $categoria->id }}"
                                                @selected(
                                                    (int) old(
                                                        'categoria_documento_id',
                                                        $documento->categoria_documento_id
                                                    ) === (int) $categoria->id
                                                )
                                            >
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="area_id" class="mb-2 block text-sm font-bold text-gray-700">
                                        Área responsable
                                    </label>

                                    <select
                                        id="area_id"
                                        name="area_id"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="">Sin área asignada</option>

                                        @foreach ($areas as $area)
                                            <option
                                                value="{{ $area->id }}"
                                                @selected(
                                                    (int) old(
                                                        'area_id',
                                                        $documento->area_id
                                                    ) === (int) $area->id
                                                )
                                            >
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo" class="mb-2 block text-sm font-bold text-gray-700">
                                        Título
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="titulo"
                                        name="titulo"
                                        value="{{ old('titulo', $documento->titulo) }}"
                                        maxlength="200"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="descripcion" class="mb-2 block text-sm font-bold text-gray-700">
                                        Descripción
                                    </label>

                                    <textarea
                                        id="descripcion"
                                        name="descripcion"
                                        rows="6"
                                        maxlength="3000"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion', $documento->descripcion) }}</textarea>
                                </div>

                                <div>
                                    <label for="fecha_publicacion" class="mb-2 block text-sm font-bold text-gray-700">
                                        Fecha de publicación
                                    </label>

                                    <input
                                        type="date"
                                        id="fecha_publicacion"
                                        name="fecha_publicacion"
                                        value="{{ old(
                                            'fecha_publicacion',
                                            $documento->fecha_publicacion?->format('Y-m-d')
                                        ) }}"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div>
                                    <label for="estado" class="mb-2 block text-sm font-bold text-gray-700">
                                        Estado
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="estado"
                                        name="estado"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option
                                            value="activo"
                                            @selected(old('estado', $documento->estado) === 'activo')
                                        >
                                            Activo
                                        </option>

                                        <option
                                            value="inactivo"
                                            @selected(old('estado', $documento->estado) === 'inactivo')
                                        >
                                            Inactivo
                                        </option>
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                        <input type="hidden" name="es_publico" value="0">

                                        <input
                                            type="checkbox"
                                            name="es_publico"
                                            value="1"
                                            @checked(old('es_publico', $documento->es_publico))
                                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Documento público
                                            </strong>

                                            <small class="text-gray-600">
                                                Los visitantes podrán verlo y descargarlo.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                                <a
                                    href="{{ route('admin.documentos.index') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                                >
                                    Cancelar
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                                >
                                    Guardar cambios
                                </button>
                            </div>
                        </section>
                    </form>

                    {{-- NUEVA VERSIÓN --}}
                    <form
                        action="{{ route('admin.documentos.versiones.guardar', $documento) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        x-data="{
                            archivoVersion: null,

                            seleccionar(evento) {
                                const archivo = evento.target.files[0];

                                if (!archivo) {
                                    this.archivoVersion = null;
                                    return;
                                }

                                this.archivoVersion = {
                                    nombre: archivo.name,
                                    tamano: (archivo.size / 1024 / 1024).toFixed(2)
                                };
                            }
                        }"
                    >
                        @csrf

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Registrar nueva versión
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        El nuevo archivo se convertirá en la versión vigente.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="version" class="mb-2 block text-sm font-bold text-gray-700">
                                        Número de versión
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="version"
                                        name="version"
                                        value="{{ old('version') }}"
                                        maxlength="20"
                                        required
                                        placeholder="Ejemplo: 1.1"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div>
                                    <label for="archivo_version" class="mb-2 block text-sm font-bold text-gray-700">
                                        Archivo
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <label
                                        for="archivo_version"
                                        class="flex h-12 cursor-pointer items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-4 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100"
                                    >
                                        Seleccionar archivo
                                    </label>

                                    <input
                                        type="file"
                                        id="archivo_version"
                                        name="archivo_version"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip"
                                        required
                                        class="sr-only"
                                        @change="seleccionar($event)"
                                    >
                                </div>

                                <div
                                    x-cloak
                                    x-show="archivoVersion"
                                    class="sm:col-span-2 rounded-2xl border border-emerald-200 bg-emerald-50 p-4"
                                >
                                    <p
                                        class="truncate text-sm font-extrabold text-emerald-950"
                                        x-text="archivoVersion ? archivoVersion.nombre : ''"
                                    ></p>

                                    <p
                                        class="mt-1 text-xs text-gray-600"
                                        x-text="archivoVersion ? archivoVersion.tamano + ' MB' : ''"
                                    ></p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="descripcion_cambio" class="mb-2 block text-sm font-bold text-gray-700">
                                        Descripción del cambio
                                    </label>

                                    <textarea
                                        id="descripcion_cambio"
                                        name="descripcion_cambio"
                                        rows="4"
                                        maxlength="2000"
                                        placeholder="Describe las modificaciones realizadas en esta versión..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion_cambio') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-7 flex justify-end">
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                                >
                                    Registrar nueva versión
                                </button>
                            </div>
                        </section>
                    </form>

                    {{-- HISTORIAL --}}
                    <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-extrabold text-emerald-950">
                                    Historial de versiones
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Registro completo de archivos publicados.
                                </p>
                            </div>

                            <span class="self-start rounded-full bg-emerald-50 px-4 py-2 text-xs font-extrabold text-emerald-700 sm:self-auto">
                                {{ $documento->versiones->count() }} versión(es)
                            </span>
                        </div>

                        <div class="mt-7 space-y-4">
                            @forelse ($documento->versiones as $version)
                                @php
                                    $versionExiste = $version->archivo
                                        && \Illuminate\Support\Facades\Storage::disk('public')->exists($version->archivo);

                                    $tamanoVersion = $version->tamano_bytes
                                        ? number_format($version->tamano_bytes / 1024 / 1024, 2) . ' MB'
                                        : 'No registrado';
                                @endphp

                                <article class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full bg-emerald-950 px-3 py-1 text-xs font-extrabold text-white">
                                                    Versión {{ $version->version }}
                                                </span>

                                                @if ($documento->version === $version->version)
                                                    <span class="rounded-full border border-amber-300 bg-amber-50 px-3 py-1 text-xs font-extrabold text-amber-700">
                                                        Vigente
                                                    </span>
                                                @endif

                                                @if ($versionExiste)
                                                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700">
                                                        Disponible
                                                    </span>
                                                @else
                                                    <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-extrabold text-red-700">
                                                        Archivo no encontrado
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="mt-3 truncate text-sm font-extrabold text-emerald-950">
                                                {{ $version->nombre_original }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $tamanoVersion }}
                                                · {{ $version->created_at?->format('d/m/Y H:i') }}
                                                · {{ $version->usuario?->name ?? 'Usuario no disponible' }}
                                            </p>

                                            @if ($version->descripcion_cambio)
                                                <p class="mt-3 text-sm leading-6 text-gray-600">
                                                    {{ $version->descripcion_cambio }}
                                                </p>
                                            @endif
                                        </div>

                                        @if ($versionExiste)
                                            <a
                                                href="{{ route('admin.documentos.versiones.descargar', $version) }}"
                                                class="inline-flex shrink-0 items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs font-extrabold text-emerald-700 transition hover:bg-emerald-100"
                                            >
                                                Descargar
                                            </a>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-amber-300 bg-amber-50 px-6 py-10 text-center">
                                    <p class="font-extrabold text-emerald-950">
                                        No existen versiones registradas.
                                    </p>

                                    <p class="mt-2 text-sm text-gray-600">
                                        Registra un archivo nuevo para crear el historial.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                {{-- PANEL LATERAL --}}
                <aside class="space-y-6">

                    <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Archivo vigente
                        </p>

                        <h3 class="mt-2 text-lg font-extrabold text-emerald-950">
                            {{ $documento->nombre_original }}
                        </h3>

                        <dl class="mt-5 space-y-4">
                            <div class="flex justify-between gap-4 border-b border-gray-100 pb-4">
                                <dt class="text-sm font-bold text-gray-500">
                                    Versión
                                </dt>

                                <dd class="text-sm font-extrabold text-emerald-950">
                                    {{ $documento->version }}
                                </dd>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-gray-100 pb-4">
                                <dt class="text-sm font-bold text-gray-500">
                                    Tamaño
                                </dt>

                                <dd class="text-sm font-extrabold text-emerald-950">
                                    {{ $tamanoActual }}
                                </dd>
                            </div>

                            <div class="flex justify-between gap-4">
                                <dt class="text-sm font-bold text-gray-500">
                                    Disponibilidad
                                </dt>

                                <dd>
                                    @if ($archivoActualExiste)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-extrabold text-red-700">
                                            No encontrado
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        @if ($archivoActualExiste)
                            <a
                                href="{{ route('admin.documentos.descargar', $documento) }}"
                                class="mt-6 inline-flex w-full items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 transition hover:bg-emerald-100"
                            >
                                Descargar archivo vigente
                            </a>
                        @endif
                    </section>

                    <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                            Información
                        </p>

                        <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                            <p>
                                <strong>Categoría:</strong>
                                {{ $documento->categoria?->nombre ?? 'Sin categoría' }}
                            </p>

                            <p>
                                <strong>Área:</strong>
                                {{ $documento->area?->nombre ?? 'Sin área asignada' }}
                            </p>

                            <p>
                                <strong>Registrado por:</strong>
                                {{ $documento->usuario?->name ?? 'Usuario no disponible' }}
                            </p>

                            <p>
                                <strong>Creado:</strong>
                                {{ $documento->created_at?->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-red-200 bg-red-50 p-6">
                        <h3 class="font-extrabold text-red-800">
                            Eliminar documento
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-red-700">
                            Se eliminarán el registro, todas las versiones y los archivos asociados.
                        </p>

                        <form
                            action="{{ route('admin.documentos.eliminar', $documento) }}"
                            method="POST"
                            class="mt-5"
                            onsubmit="return confirm('¿Seguro que deseas eliminar este documento y todo su historial?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl border border-red-300 bg-white px-5 py-3 text-sm font-extrabold text-red-700 transition hover:bg-red-100"
                            >
                                Eliminar definitivamente
                            </button>
                        </form>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>