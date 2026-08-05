<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión de contenido
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Nueva galería institucional
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Registra un álbum y carga sus fotografías.
                </p>
            </div>

            <a
                href="{{ route('admin.galerias.index') }}"
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
                action="{{ route('admin.galerias.guardar') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    portada: null,
                    fotografias: [],

                    previsualizarPortada(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.portada = null;
                            return;
                        }

                        this.portada = URL.createObjectURL(archivo);
                    },

                    previsualizarFotografias(evento) {
                        this.fotografias.forEach((foto) => {
                            URL.revokeObjectURL(foto.url);
                        });

                        this.fotografias = Array.from(evento.target.files).map((archivo) => ({
                            nombre: archivo.name,
                            tamano: (archivo.size / 1024 / 1024).toFixed(2),
                            url: URL.createObjectURL(archivo)
                        }));
                    }
                }"
            >
                @csrf

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    {{-- Información principal --}}
                    <div class="space-y-8">

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
                                        <path d="M4 5h16v14H4z"/>
                                        <path d="m8 15 3-3 2 2 3-4 3 5"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Información del álbum
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Estos datos serán visibles en el portal público.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label
                                        for="titulo"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Título de la galería
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="titulo"
                                        name="titulo"
                                        value="{{ old('titulo') }}"
                                        maxlength="180"
                                        required
                                        placeholder="Ejemplo: Feria de Ciencia 2026"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >

                                    @error('titulo')
                                        <p class="mt-2 text-sm font-semibold text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        for="tipo"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Tipo
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="tipo"
                                        name="tipo"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        <option value="fotografias" @selected(old('tipo', 'fotografias') === 'fotografias')>
                                            Fotografías
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="anio"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Año
                                    </label>

                                    <input
                                        type="number"
                                        id="anio"
                                        name="anio"
                                        value="{{ old('anio', now()->year) }}"
                                        min="1900"
                                        max="{{ now()->year + 1 }}"
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
                                        placeholder="Describe brevemente la actividad o acontecimiento registrado..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion') }}</textarea>

                                    @error('descripcion')
                                        <p class="mt-2 text-sm font-semibold text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        for="orden"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Orden de aparición
                                    </label>

                                    <input
                                        type="number"
                                        id="orden"
                                        name="orden"
                                        value="{{ old('orden', 0) }}"
                                        min="0"
                                        max="9999"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >

                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                        Los valores menores se mostrarán primero.
                                    </p>
                                </div>

                                <div class="flex items-end">
                                    <label class="flex w-full cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="0"
                                        >

                                        <input
                                            type="checkbox"
                                            name="estado"
                                            value="1"
                                            @checked(old('estado', true))
                                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Publicar galería
                                            </strong>

                                            <small class="text-gray-600">
                                                Será visible en el portal público.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </section>

                        {{-- Fotografías --}}
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
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <circle cx="8" cy="10" r="1.5"/>
                                        <path d="m4 16 5-4 4 3 3-3 4 4"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Fotografías del álbum
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Selecciona entre 1 y 20 imágenes. Cada archivo puede pesar hasta 5 MB.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7">
                                <label
                                    for="fotografias"
                                    class="group flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-12 text-center transition hover:border-amber-400 hover:bg-amber-50"
                                >
                                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300 shadow-lg">
                                        <svg
                                            class="h-8 w-8"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
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
                                    id="fotografias"
                                    name="fotografias[]"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    multiple
                                    required
                                    class="sr-only"
                                    @change="previsualizarFotografias($event)"
                                >

                                @error('fotografias')
                                    <p class="mt-3 text-sm font-semibold text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                @error('fotografias.*')
                                    <p class="mt-3 text-sm font-semibold text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div
                                x-cloak
                                x-show="fotografias.length > 0"
                                class="mt-8"
                            >
                                <div class="flex items-center justify-between gap-4">
                                    <h4 class="font-extrabold text-emerald-950">
                                        Archivos seleccionados
                                    </h4>

                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700"
                                        x-text="fotografias.length + ' fotografía(s)'"
                                    ></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <template x-for="(foto, indice) in fotografias" :key="foto.url">
                                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                            <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                                                <img
                                                    :src="foto.url"
                                                    :alt="'Vista previa ' + (indice + 1)"
                                                    class="h-full w-full object-cover"
                                                >
                                            </div>

                                            <div class="p-3">
                                                <p
                                                    class="truncate text-xs font-extrabold text-emerald-950"
                                                    x-text="foto.nombre"
                                                ></p>

                                                <p
                                                    class="mt-1 text-[11px] text-gray-500"
                                                    x-text="foto.tamano + ' MB'"
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

                        {{-- Portada --}}
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
                                    <svg
                                        class="h-10 w-10 text-emerald-700"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
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

                            @error('imagen_portada')
                                <p class="mt-3 text-sm font-semibold text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>

                        {{-- Recomendaciones --}}
                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Recomendaciones
                            </p>

                            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                <p>
                                    Usa fotografías horizontales para mejorar la presentación.
                                </p>

                                <p>
                                    Evita imágenes borrosas, repetidas o con información sensible.
                                </p>

                                <p>
                                    Verifica que exista autorización para publicar fotografías de menores.
                                </p>
                            </div>
                        </section>

                        {{-- Botones --}}
                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                <svg
                                    class="h-5 w-5 text-amber-300"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>

                                Guardar galería
                            </button>

                            <a
                                href="{{ route('admin.galerias.index') }}"
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