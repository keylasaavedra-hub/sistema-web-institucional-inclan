<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Multimedia institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar promoción escolar
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Registra una promoción y carga sus fotografías institucionales.
                </p>
            </div>

            <a
                href="{{ route('admin.promociones.index') }}"
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
                action="{{ route('admin.promociones.guardar') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    portada: null,
                    imagenes: [],

                    previsualizarPortada(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.portada = null;
                            return;
                        }

                        this.portada = URL.createObjectURL(archivo);
                    },

                    previsualizarImagenes(evento) {
                        this.imagenes.forEach((imagen) => {
                            URL.revokeObjectURL(imagen.url);
                        });

                        this.imagenes = Array.from(evento.target.files).map((archivo) => ({
                            nombre: archivo.name,
                            tamano: (archivo.size / 1024 / 1024).toFixed(2),
                            url: URL.createObjectURL(archivo)
                        }));
                    }
                }"
            >
                @csrf

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">

                        {{-- Información principal --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="8" r="3"/>
                                        <path d="M5 20a7 7 0 0 1 14 0"/>
                                        <path d="M4 5h4M16 5h4"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Información de la promoción
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Estos datos se mostrarán en el portal público.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div>
                                    <label for="nivel_educativo_id" class="mb-2 block text-sm font-bold text-gray-700">
                                        Nivel educativo
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="nivel_educativo_id"
                                        name="nivel_educativo_id"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="">Selecciona un nivel</option>

                                        @foreach ($niveles as $nivel)
                                            <option
                                                value="{{ $nivel->id }}"
                                                @selected((int) old('nivel_educativo_id') === (int) $nivel->id)
                                            >
                                                {{ $nivel->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="anio" class="mb-2 block text-sm font-bold text-gray-700">
                                        Año
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="anio"
                                        name="anio"
                                        value="{{ old('anio', now()->year) }}"
                                        min="1900"
                                        max="{{ now()->year + 1 }}"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre" class="mb-2 block text-sm font-bold text-gray-700">
                                        Nombre de la promoción
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="nombre"
                                        name="nombre"
                                        value="{{ old('nombre') }}"
                                        maxlength="180"
                                        required
                                        placeholder="Ejemplo: Promoción Guardianes del Futuro"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="lema" class="mb-2 block text-sm font-bold text-gray-700">
                                        Lema
                                    </label>

                                    <input
                                        type="text"
                                        id="lema"
                                        name="lema"
                                        value="{{ old('lema') }}"
                                        maxlength="255"
                                        placeholder="Ejemplo: Unidos por un futuro mejor"
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
                                        placeholder="Describe brevemente la promoción, sus integrantes o su historia..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion') }}</textarea>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                        <input type="hidden" name="estado" value="0">

                                        <input
                                            type="checkbox"
                                            name="estado"
                                            value="1"
                                            @checked(old('estado', true))
                                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Publicar promoción
                                            </strong>

                                            <small class="text-gray-600">
                                                Será visible para los visitantes del portal.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </section>

                        {{-- Imágenes --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <circle cx="8" cy="10" r="1.5"/>
                                        <path d="m4 16 5-4 4 3 3-3 4 4"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Fotografías de la promoción
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Selecciona entre 1 y 20 imágenes. Cada archivo puede pesar hasta 5 MB.
                                    </p>
                                </div>
                            </div>

                            <label
                                for="imagenes"
                                class="mt-7 flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-12 text-center transition hover:border-amber-400 hover:bg-amber-50"
                            >
                                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg">
                                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                </span>

                                <strong class="mt-5 text-base text-emerald-950">
                                    Seleccionar fotografías
                                </strong>

                                <span class="mt-2 text-sm text-gray-500">
                                    JPG, JPEG, PNG o WEBP
                                </span>
                            </label>

                            <input
                                type="file"
                                id="imagenes"
                                name="imagenes[]"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                multiple
                                required
                                class="sr-only"
                                @change="previsualizarImagenes($event)"
                            >

                            <div
                                x-cloak
                                x-show="imagenes.length > 0"
                                class="mt-8"
                            >
                                <div class="flex items-center justify-between gap-4">
                                    <h4 class="font-extrabold text-emerald-950">
                                        Imágenes seleccionadas
                                    </h4>

                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700"
                                        x-text="imagenes.length + ' imagen(es)'"
                                    ></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <template x-for="(imagen, indice) in imagenes" :key="imagen.url">
                                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                            <img
                                                :src="imagen.url"
                                                :alt="'Vista previa ' + (indice + 1)"
                                                class="aspect-[4/3] w-full object-cover"
                                            >

                                            <div class="p-3">
                                                <p
                                                    class="truncate text-xs font-extrabold text-emerald-950"
                                                    x-text="imagen.nombre"
                                                ></p>

                                                <p
                                                    class="mt-1 text-[11px] text-gray-500"
                                                    x-text="imagen.tamano + ' MB'"
                                                ></p>
                                            </div>
                                        </article>
                                    </template>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- Barra lateral --}}
                    <aside class="space-y-6">

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Imagen de portada
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Es opcional. Si no seleccionas una, se usará la primera fotografía.
                            </p>

                            <label
                                for="imagen_portada"
                                class="mt-5 block cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-amber-300 bg-gray-50"
                            >
                                <div
                                    x-show="!portada"
                                    class="flex aspect-[4/3] flex-col items-center justify-center px-5 text-center"
                                >
                                    <svg class="h-10 w-10 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m8 15 3-3 2 2 3-4 3 5"/>
                                    </svg>

                                    <span class="mt-3 text-sm font-bold text-gray-700">
                                        Seleccionar portada
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

                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Recomendaciones
                            </p>

                            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                <p>
                                    Usa una fotografía grupal horizontal como portada.
                                </p>

                                <p>
                                    Evita imágenes borrosas, repetidas o con datos personales visibles.
                                </p>

                                <p>
                                    Verifica que exista autorización para publicar fotografías de estudiantes.
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                Guardar promoción
                            </button>

                            <a
                                href="{{ route('admin.promociones.index') }}"
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