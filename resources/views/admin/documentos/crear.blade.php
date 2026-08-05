<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión documental
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar documento
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Publica reglamentos, formatos, planes y otros archivos institucionales.
                </p>
            </div>

            <a
                href="{{ route('admin.documentos.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-extrabold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

            <form
                action="{{ route('admin.documentos.guardar') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    archivo: null,

                    seleccionarArchivo(evento) {
                        const seleccionado = evento.target.files[0];

                        if (!seleccionado) {
                            this.archivo = null;
                            return;
                        }

                        this.archivo = {
                            nombre: seleccionado.name,
                            tamano: (seleccionado.size / 1024 / 1024).toFixed(2),
                            tipo: seleccionado.type || 'Tipo no identificado'
                        };
                    }
                }"
            >
                @csrf

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">

                        {{-- DATOS PRINCIPALES --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M6 3h9l3 3v15H6z"/>
                                        <path d="M14 3v4h4"/>
                                        <path d="M9 12h6M9 16h4"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Información del documento
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Completa los datos que permitirán identificar y organizar el archivo.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="categoria_documento_id"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Categoría
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="categoria_documento_id"
                                        name="categoria_documento_id"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="">
                                            Selecciona una categoría
                                        </option>

                                        @foreach ($categorias as $categoria)
                                            <option
                                                value="{{ $categoria->id }}"
                                                @selected((int) old('categoria_documento_id') === (int) $categoria->id)
                                            >
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="area_id"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Área responsable
                                    </label>

                                    <select
                                        id="area_id"
                                        name="area_id"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="">
                                            Sin área asignada
                                        </option>

                                        @foreach ($areas as $area)
                                            <option
                                                value="{{ $area->id }}"
                                                @selected((int) old('area_id') === (int) $area->id)
                                            >
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="titulo"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Título
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="titulo"
                                        name="titulo"
                                        value="{{ old('titulo') }}"
                                        maxlength="200"
                                        required
                                        placeholder="Ejemplo: Reglamento interno institucional"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="descripcion"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Descripción
                                    </label>

                                    <textarea
                                        id="descripcion"
                                        name="descripcion"
                                        rows="6"
                                        maxlength="3000"
                                        placeholder="Describe brevemente el contenido y finalidad del documento..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion') }}</textarea>
                                </div>
                            </div>
                        </section>

                        {{-- ARCHIVO --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M12 3v12"/>
                                        <path d="m7 10 5 5 5-5"/>
                                        <path d="M5 21h14"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Archivo del documento
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Se registrará automáticamente como la primera versión.
                                    </p>
                                </div>
                            </div>

                            <label
                                for="archivo"
                                class="mt-7 flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-12 text-center transition hover:border-amber-400 hover:bg-amber-50"
                            >
                                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg">
                                    <svg
                                        class="h-8 w-8"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M12 3v12"/>
                                        <path d="m7 10 5 5 5-5"/>
                                        <path d="M5 21h14"/>
                                    </svg>
                                </span>

                                <strong class="mt-5 text-base text-emerald-950">
                                    Seleccionar archivo
                                </strong>

                                <span class="mt-2 text-sm text-gray-500">
                                    PDF, Word, Excel, PowerPoint, TXT o ZIP
                                </span>

                                <span class="mt-1 text-xs text-gray-400">
                                    Tamaño máximo: 20 MB
                                </span>
                            </label>

                            <input
                                type="file"
                                id="archivo"
                                name="archivo"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip"
                                required
                                class="sr-only"
                                @change="seleccionarArchivo($event)"
                            >

                            <div
                                x-cloak
                                x-show="archivo"
                                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5"
                            >
                                <div class="flex items-center gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">
                                        <svg
                                            class="h-6 w-6"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M6 3h9l3 3v15H6z"/>
                                            <path d="M14 3v4h4"/>
                                        </svg>
                                    </span>

                                    <div class="min-w-0 flex-1">
                                        <p
                                            class="truncate text-sm font-extrabold text-emerald-950"
                                            x-text="archivo ? archivo.nombre : ''"
                                        ></p>

                                        <p class="mt-1 text-xs text-gray-600">
                                            <span x-text="archivo ? archivo.tamano + ' MB' : ''"></span>
                                            <span class="px-1">·</span>
                                            <span x-text="archivo ? archivo.tipo : ''"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- PANEL LATERAL --}}
                    <aside class="space-y-6">

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Publicación
                            </h3>

                            <div class="mt-6 space-y-5">

                                <div>
                                    <label
                                        for="version"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Versión inicial
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="version"
                                        name="version"
                                        value="{{ old('version', '1.0') }}"
                                        maxlength="20"
                                        required
                                        placeholder="Ejemplo: 1.0"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="fecha_publicacion"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Fecha de publicación
                                    </label>

                                    <input
                                        type="date"
                                        id="fecha_publicacion"
                                        name="fecha_publicacion"
                                        value="{{ old('fecha_publicacion', now()->toDateString()) }}"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="estado"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
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
                                            @selected(old('estado', 'activo') === 'activo')
                                        >
                                            Activo
                                        </option>

                                        <option
                                            value="inactivo"
                                            @selected(old('estado') === 'inactivo')
                                        >
                                            Inactivo
                                        </option>
                                    </select>
                                </div>

                                <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                    <input
                                        type="hidden"
                                        name="es_publico"
                                        value="0"
                                    >

                                    <input
                                        type="checkbox"
                                        name="es_publico"
                                        value="1"
                                        @checked(old('es_publico', true))
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
                        </section>

                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Recomendaciones
                            </p>

                            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                <p>
                                    Usa nombres claros y evita subir archivos duplicados.
                                </p>

                                <p>
                                    Para documentos oficiales, se recomienda usar formato PDF.
                                </p>

                                <p>
                                    Los archivos internos no aparecerán en el portal público.
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                Guardar documento
                            </button>

                            <a
                                href="{{ route('admin.documentos.index') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                            >
                                Cancelar
                            </a>
                        </section>
                    </aside>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>