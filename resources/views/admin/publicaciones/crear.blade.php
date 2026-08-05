<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Contenido institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar publicación
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Crea noticias, anuncios, comunicados o eventos para el portal.
                </p>
            </div>

            <a
                href="{{ route('admin.publicaciones.index') }}"
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
                action="{{ route('admin.publicaciones.guardar') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    portada: null,
                    adjunto: null,

                    previsualizarPortada(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.portada = null;
                            return;
                        }

                        this.portada = URL.createObjectURL(archivo);
                    },

                    seleccionarAdjunto(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.adjunto = null;
                            return;
                        }

                        this.adjunto = {
                            nombre: archivo.name,
                            tamano: (archivo.size / 1024 / 1024).toFixed(2)
                        };
                    }
                }"
            >
                @csrf

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">

                        {{-- INFORMACIÓN PRINCIPAL --}}
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
                                        Información de la publicación
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Completa los datos que se mostrarán en el portal institucional.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="categoria_publicacion_id"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Categoría
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="categoria_publicacion_id"
                                        name="categoria_publicacion_id"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="">
                                            Selecciona una categoría
                                        </option>

                                        @foreach ($categorias as $categoria)
                                            <option
                                                value="{{ $categoria->id }}"
                                                @selected(
                                                    (int) old('categoria_publicacion_id')
                                                    === (int) $categoria->id
                                                )
                                            >
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                            value="borrador"
                                            @selected(old('estado', 'borrador') === 'borrador')
                                        >
                                            Borrador
                                        </option>

                                        <option
                                            value="publicado"
                                            @selected(old('estado') === 'publicado')
                                        >
                                            Publicado
                                        </option>

                                        <option
                                            value="archivado"
                                            @selected(old('estado') === 'archivado')
                                        >
                                            Archivado
                                        </option>
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
                                        placeholder="Ejemplo: Inicio del año escolar 2026"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="contenido"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Contenido
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea
                                        id="contenido"
                                        name="contenido"
                                        rows="14"
                                        maxlength="30000"
                                        required
                                        placeholder="Redacta aquí el contenido completo de la publicación..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-7 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('contenido') }}</textarea>

                                    <p class="mt-2 text-xs text-gray-500">
                                        Puedes usar saltos de línea para organizar el contenido en párrafos.
                                    </p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4">
                                        <input
                                            type="hidden"
                                            name="destacada"
                                            value="0"
                                        >

                                        <input
                                            type="checkbox"
                                            name="destacada"
                                            value="1"
                                            @checked(old('destacada'))
                                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Marcar como destacada
                                            </strong>

                                            <small class="text-gray-600">
                                                Tendrá prioridad visual en el listado público.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </section>

                        {{-- ARCHIVO ADJUNTO --}}
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
                                        <path d="M9 12h6"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Archivo adjunto
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Opcional. Puedes adjuntar un comunicado, formato o documento relacionado.
                                    </p>
                                </div>
                            </div>

                            <label
                                for="archivo_adjunto"
                                class="mt-7 flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-10 text-center transition hover:bg-amber-50"
                            >
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-7 w-7"
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

                                <strong class="mt-4 text-sm text-emerald-950">
                                    Seleccionar archivo adjunto
                                </strong>

                                <span class="mt-2 text-xs text-gray-500">
                                    PDF, Word, Excel, PowerPoint, TXT o ZIP — máximo 20 MB
                                </span>
                            </label>

                            <input
                                type="file"
                                id="archivo_adjunto"
                                name="archivo_adjunto"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip"
                                class="sr-only"
                                @change="seleccionarAdjunto($event)"
                            >

                            <div
                                x-cloak
                                x-show="adjunto"
                                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5"
                            >
                                <p
                                    class="truncate text-sm font-extrabold text-emerald-950"
                                    x-text="adjunto ? adjunto.nombre : ''"
                                ></p>

                                <p
                                    class="mt-1 text-xs text-gray-600"
                                    x-text="adjunto ? adjunto.tamano + ' MB' : ''"
                                ></p>
                            </div>
                        </section>
                    </div>

                    {{-- PANEL LATERAL --}}
                    <aside class="space-y-6">

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Imagen de portada
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Opcional. Se recomienda una imagen horizontal de buena calidad.
                            </p>

                            <label
                                for="imagen_portada"
                                class="mt-5 block cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-amber-300 bg-gray-50"
                            >
                                <div
                                    x-show="!portada"
                                    class="flex aspect-[4/3] flex-col items-center justify-center px-5 text-center"
                                >
                                    <svg
                                        class="h-10 w-10 text-emerald-700"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <circle cx="8" cy="10" r="1.5"/>
                                        <path d="m4 16 5-4 4 3 3-3 4 4"/>
                                    </svg>

                                    <span class="mt-3 text-sm font-bold text-gray-700">
                                        Seleccionar portada
                                    </span>

                                    <span class="mt-1 text-xs text-gray-500">
                                        JPG, PNG o WEBP — máximo 5 MB
                                    </span>
                                </div>

                                <img
                                    x-cloak
                                    x-show="portada"
                                    :src="portada"
                                    alt="Vista previa de portada"
                                    class="aspect-[4/3] w-full object-cover"
                                >
                            </label>

                            <input
                                type="file"
                                id="imagen_portada"
                                name="imagen_portada"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="sr-only"
                                @change="previsualizarPortada($event)"
                            >
                        </section>

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Programación
                            </h3>

                            <div class="mt-6 space-y-5">
                                <div>
                                    <label
                                        for="fecha_publicacion"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Fecha de publicación
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="fecha_publicacion"
                                        name="fecha_publicacion"
                                        value="{{ old(
                                            'fecha_publicacion',
                                            now()->format('Y-m-d\TH:i')
                                        ) }}"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >

                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                        Puedes elegir una fecha futura para programarla.
                                    </p>
                                </div>

                                <div>
                                    <label
                                        for="fecha_vencimiento"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Fecha de vencimiento
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="fecha_vencimiento"
                                        name="fecha_vencimiento"
                                        value="{{ old('fecha_vencimiento') }}"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >

                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                        Déjala vacía si la publicación no debe vencer.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Funcionamiento
                            </p>

                            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                <p>
                                    Una publicación en borrador no aparecerá en el portal.
                                </p>

                                <p>
                                    Las publicaciones programadas aparecerán automáticamente en la fecha indicada.
                                </p>

                                <p>
                                    Al vencer, dejarán de mostrarse públicamente sin ser eliminadas.
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                Guardar publicación
                            </button>

                            <a
                                href="{{ route('admin.publicaciones.index') }}"
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