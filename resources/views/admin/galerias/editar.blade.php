<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión de contenido
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar galería institucional
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza la información y administra las fotografías del álbum.
                </p>
            </div>

            <a
                href="{{ route('admin.galerias.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-extrabold text-gray-700 shadow-sm transition hover:bg-gray-50">
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="m15 18-6-6 6-6" />
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

            <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($galeria->archivos as $archivo)
                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        <img
                            src="{{ asset('storage/' . $archivo->ruta) }}"
                            alt="{{ $archivo->titulo ?: $galeria->titulo }}"
                            class="h-full w-full object-cover {{ $archivo->estado ? '' : 'grayscale opacity-60' }}"
                            onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'">

                        <div class="absolute left-3 top-3">
                            @if ($archivo->estado)
                            <span class="rounded-full border border-emerald-200 bg-emerald-50/95 px-3 py-1 text-[11px] font-extrabold text-emerald-700">
                                Visible
                            </span>
                            @else
                            <span class="rounded-full border border-gray-200 bg-white/95 px-3 py-1 text-[11px] font-extrabold text-gray-600">
                                Oculta
                            </span>
                            @endif
                        </div>

                        @if ($galeria->imagen_portada === $archivo->ruta)
                        <div class="absolute bottom-3 left-3">
                            <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1 text-[11px] font-extrabold text-amber-300">
                                Portada actual
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <p class="truncate text-sm font-extrabold text-emerald-950">
                            {{ $archivo->titulo ?: $archivo->nombre_original ?: 'Fotografía' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Orden: {{ $archivo->orden }}
                        </p>

                        <div class="mt-4 grid gap-2">
                            <form
                                action="{{ route('admin.galerias.archivos.estado', $archivo) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl border px-4 py-2.5 text-xs font-extrabold transition
                                                            {{ $archivo->estado
                                                                ? 'border-gray-200 bg-gray-50 text-gray-700 hover:bg-gray-100'
                                                                : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                    {{ $archivo->estado ? 'Ocultar fotografía' : 'Habilitar fotografía' }}
                                </button>
                            </form>

                            <form
                                action="{{ route('admin.galerias.archivos.eliminar', $archivo) }}"
                                method="POST"
                                onsubmit="return confirm('¿Seguro que deseas eliminar esta fotografía?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs font-extrabold text-red-700 transition hover:bg-red-100">
                                    Eliminar fotografía
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
                @empty
                <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-amber-300 bg-amber-50 px-6 py-10 text-center">
                    <p class="font-extrabold text-emerald-950">
                        Esta galería no tiene fotografías.
                    </p>

                    <p class="mt-2 text-sm text-gray-600">
                        Utiliza el formulario inferior para agregar nuevas imágenes.
                    </p>
                </div>
                @endforelse
            </div>

            <form
                action="{{ route('admin.galerias.actualizar', $galeria) }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    portadaNueva: null,
                    fotografiasNuevas: [],

                    previsualizarPortada(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.portadaNueva = null;
                            return;
                        }

                        this.portadaNueva = URL.createObjectURL(archivo);
                    },

                    previsualizarFotografias(evento) {
                        this.fotografiasNuevas.forEach((foto) => {
                            URL.revokeObjectURL(foto.url);
                        });

                        this.fotografiasNuevas = Array.from(evento.target.files).map((archivo) => ({
                            nombre: archivo.name,
                            tamano: (archivo.size / 1024 / 1024).toFixed(2),
                            url: URL.createObjectURL(archivo)
                        }));
                    }
                }">
                @csrf
                @method('PUT')

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">

                        {{-- Información general --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M4 5h16v14H4z" />
                                        <path d="m8 15 3-3 2 2 3-4 3 5" />
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Información del álbum
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Modifica los datos visibles en la galería pública.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div class="sm:col-span-2">
                                    <label
                                        for="titulo"
                                        class="mb-2 block text-sm font-bold text-gray-700">
                                        Título de la galería
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="titulo"
                                        name="titulo"
                                        value="{{ old('titulo', $galeria->titulo) }}"
                                        maxlength="180"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                                </div>

                                <div>
                                    <label
                                        for="tipo"
                                        class="mb-2 block text-sm font-bold text-gray-700">
                                        Tipo
                                    </label>

                                    <select
                                        id="tipo"
                                        name="tipo"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                                        <option
                                            value="fotografias"
                                            @selected(old('tipo', $galeria->tipo) === 'fotografias')
                                            >
                                            Fotografías
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="anio"
                                        class="mb-2 block text-sm font-bold text-gray-700">
                                        Año
                                    </label>

                                    <input
                                        type="number"
                                        id="anio"
                                        name="anio"
                                        value="{{ old('anio', $galeria->anio) }}"
                                        min="1900"
                                        max="{{ now()->year + 1 }}"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="descripcion"
                                        class="mb-2 block text-sm font-bold text-gray-700">
                                        Descripción
                                    </label>

                                    <textarea
                                        id="descripcion"
                                        name="descripcion"
                                        rows="6"
                                        maxlength="3000"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400">{{ old('descripcion', $galeria->descripcion) }}</textarea>
                                </div>

                                <div>
                                    <label
                                        for="orden"
                                        class="mb-2 block text-sm font-bold text-gray-700">
                                        Orden de aparición
                                    </label>

                                    <input
                                        type="number"
                                        id="orden"
                                        name="orden"
                                        value="{{ old('orden', $galeria->orden) }}"
                                        min="0"
                                        max="9999"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                                </div>

                                <div class="flex items-end">
                                    <label class="flex w-full cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="0">

                                        <input
                                            type="checkbox"
                                            name="estado"
                                            value="1"
                                            @checked(old('estado', $galeria->estado))
                                        class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Publicar galería
                                            </strong>

                                            <small class="text-gray-600">
                                                Será visible para los visitantes.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </section>

                        {{-- Fotografías existentes --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Fotografías actuales
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Puedes ocultar o eliminar individualmente cada fotografía.
                                    </p>
                                </div>

                                <span class="self-start rounded-full bg-emerald-50 px-4 py-2 text-xs font-extrabold text-emerald-700 sm:self-auto">
                                    {{ $galeria->archivos->count() }} fotografía(s)
                                </span>
                            </div>


                        </section>

                        {{-- Agregar fotografías --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Agregar nuevas fotografías
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Puedes subir hasta 20 imágenes adicionales por actualización.
                            </p>

                            <label
                                for="fotografias"
                                class="mt-6 flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-10 text-center transition hover:bg-amber-50">
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-7 w-7"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </span>

                                <strong class="mt-4 text-sm text-emerald-950">
                                    Seleccionar nuevas fotografías
                                </strong>

                                <span class="mt-1 text-xs text-gray-500">
                                    JPG, JPEG, PNG o WEBP
                                </span>
                            </label>

                            <input
                                type="file"
                                id="fotografias"
                                name="fotografias[]"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                multiple
                                class="sr-only"
                                @change="previsualizarFotografias($event)">

                            <div
                                x-cloak
                                x-show="fotografiasNuevas.length > 0"
                                class="mt-7">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-extrabold text-emerald-950">
                                        Nuevas fotografías seleccionadas
                                    </h4>

                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700"
                                        x-text="fotografiasNuevas.length + ' archivo(s)'"></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <template x-for="(foto, indice) in fotografiasNuevas" :key="foto.url">
                                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                            <img
                                                :src="foto.url"
                                                :alt="'Nueva fotografía ' + (indice + 1)"
                                                class="aspect-[4/3] w-full object-cover">

                                            <div class="p-3">
                                                <p
                                                    class="truncate text-xs font-extrabold text-emerald-950"
                                                    x-text="foto.nombre"></p>

                                                <p
                                                    class="mt-1 text-[11px] text-gray-500"
                                                    x-text="foto.tamano + ' MB'"></p>
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
                                Puedes reemplazar la portada actual con una imagen nueva.
                            </p>

                            <div class="mt-5 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    x-show="!portadaNueva"
                                    src="{{ $galeria->imagen_portada
                                        ? asset('storage/' . $galeria->imagen_portada)
                                        : asset('images/portada-institucion.jpg') }}"
                                    alt="Portada actual"
                                    class="aspect-[4/3] w-full object-cover">

                                <img
                                    x-cloak
                                    x-show="portadaNueva"
                                    :src="portadaNueva"
                                    alt="Nueva portada"
                                    class="aspect-[4/3] w-full object-cover">
                            </div>

                            <label
                                for="imagen_portada"
                                class="mt-4 inline-flex w-full cursor-pointer items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-5 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100">
                                Cambiar portada
                            </label>

                            <input
                                type="file"
                                id="imagen_portada"
                                name="imagen_portada"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="sr-only"
                                @change="previsualizarPortada($event)">
                        </section>

                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Información
                            </p>

                            <div class="mt-4 space-y-3 text-sm text-gray-700">
                                <p>
                                    <strong>Creada:</strong>
                                    {{ $galeria->created_at?->format('d/m/Y H:i') }}
                                </p>

                                <p>
                                    <strong>Última actualización:</strong>
                                    {{ $galeria->updated_at?->format('d/m/Y H:i') }}
                                </p>

                                <p>
                                    <strong>Fotografías:</strong>
                                    {{ $galeria->archivos->count() }}
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900">
                                Guardar cambios
                            </button>

                            <a
                                href="{{ route('admin.galerias.index') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                                Cancelar
                            </a>
                        </section>
                    </aside>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>