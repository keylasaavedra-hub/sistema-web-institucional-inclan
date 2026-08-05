<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Multimedia institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar promoción escolar
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza la información y administra las fotografías de la promoción.
                </p>
            </div>

            <a
                href="{{ route('admin.promociones.index') }}"
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

            {{-- ===================================================== --}}
            {{-- IMÁGENES EXISTENTES: FUERA DEL FORMULARIO PRINCIPAL --}}
            {{-- ===================================================== --}}
            <section class="mb-8 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
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
                        {{ $promocion->imagenes->count() }} fotografía(s)
                    </span>
                </div>

                <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($promocion->imagenes as $imagen)
                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                <img
                                    src="{{ asset('storage/' . $imagen->ruta) }}"
                                    alt="{{ $imagen->titulo ?: $promocion->nombre }}"
                                    class="h-full w-full object-cover {{ $imagen->estado ? '' : 'grayscale opacity-60' }}"
                                    onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                                >

                                <div class="absolute left-3 top-3">
                                    @if ($imagen->estado)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50/95 px-3 py-1 text-[11px] font-extrabold text-emerald-700">
                                            Visible
                                        </span>
                                    @else
                                        <span class="rounded-full border border-gray-200 bg-white/95 px-3 py-1 text-[11px] font-extrabold text-gray-600">
                                            Oculta
                                        </span>
                                    @endif
                                </div>

                                @if ($promocion->imagen_portada === $imagen->ruta)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="rounded-full border border-amber-300 bg-emerald-950/90 px-3 py-1 text-[11px] font-extrabold text-amber-300">
                                            Portada actual
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <p class="truncate text-sm font-extrabold text-emerald-950">
                                    {{ $imagen->titulo ?: $imagen->nombre_original ?: 'Fotografía' }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Orden: {{ $imagen->orden }}
                                </p>

                                <div class="mt-4 grid gap-2">
                                    <form
                                        action="{{ route('admin.promociones.imagenes.estado', $imagen) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-xl border px-4 py-2.5 text-xs font-extrabold transition
                                                {{ $imagen->estado
                                                    ? 'border-gray-200 bg-gray-50 text-gray-700 hover:bg-gray-100'
                                                    : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}"
                                        >
                                            {{ $imagen->estado ? 'Ocultar fotografía' : 'Habilitar fotografía' }}
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin.promociones.imagenes.eliminar', $imagen) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta fotografía?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs font-extrabold text-red-700 transition hover:bg-red-100"
                                        >
                                            Eliminar fotografía
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-amber-300 bg-amber-50 px-6 py-10 text-center">
                            <p class="font-extrabold text-emerald-950">
                                Esta promoción no tiene fotografías.
                            </p>

                            <p class="mt-2 text-sm text-gray-600">
                                Usa el formulario inferior para agregar nuevas imágenes.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ===================================================== --}}
            {{-- FORMULARIO PRINCIPAL --}}
            {{-- ===================================================== --}}
            <form
                action="{{ route('admin.promociones.actualizar', $promocion) }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    portadaNueva: null,
                    imagenesNuevas: [],

                    previsualizarPortada(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.portadaNueva = null;
                            return;
                        }

                        this.portadaNueva = URL.createObjectURL(archivo);
                    },

                    previsualizarImagenes(evento) {
                        this.imagenesNuevas.forEach((imagen) => {
                            URL.revokeObjectURL(imagen.url);
                        });

                        this.imagenesNuevas = Array.from(evento.target.files).map((archivo) => ({
                            nombre: archivo.name,
                            tamano: (archivo.size / 1024 / 1024).toFixed(2),
                            url: URL.createObjectURL(archivo)
                        }));
                    }
                }"
            >
                @csrf
                @method('PUT')

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">

                        {{-- Información --}}
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
                                        Modifica los datos visibles en el portal público.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="nivel_educativo_id"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Nivel educativo
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="nivel_educativo_id"
                                        name="nivel_educativo_id"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        @foreach ($niveles as $nivel)
                                            <option
                                                value="{{ $nivel->id }}"
                                                @selected(
                                                    (int) old(
                                                        'nivel_educativo_id',
                                                        $promocion->nivel_educativo_id
                                                    ) === (int) $nivel->id
                                                )
                                            >
                                                {{ $nivel->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="anio"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Año
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="anio"
                                        name="anio"
                                        value="{{ old('anio', $promocion->anio) }}"
                                        min="1900"
                                        max="{{ now()->year + 1 }}"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="nombre"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Nombre de la promoción
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="nombre"
                                        name="nombre"
                                        value="{{ old('nombre', $promocion->nombre) }}"
                                        maxlength="180"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="lema"
                                        class="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Lema
                                    </label>

                                    <input
                                        type="text"
                                        id="lema"
                                        name="lema"
                                        value="{{ old('lema', $promocion->lema) }}"
                                        maxlength="255"
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
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion', $promocion->descripcion) }}</textarea>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="0"
                                        >

                                        <input
                                            type="checkbox"
                                            name="estado"
                                            value="1"
                                            @checked(old('estado', $promocion->estado))
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

                        {{-- Nuevas imágenes --}}
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Agregar nuevas fotografías
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Puedes subir hasta 20 imágenes adicionales por actualización.
                            </p>

                            <label
                                for="imagenes"
                                class="mt-6 flex cursor-pointer flex-col items-center justify-center rounded-[24px] border-2 border-dashed border-amber-300 bg-amber-50/40 px-6 py-10 text-center transition hover:bg-amber-50"
                            >
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg
                                        class="h-7 w-7"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M12 5v14M5 12h14"/>
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
                                id="imagenes"
                                name="imagenes[]"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                multiple
                                class="sr-only"
                                @change="previsualizarImagenes($event)"
                            >

                            <div
                                x-cloak
                                x-show="imagenesNuevas.length > 0"
                                class="mt-7"
                            >
                                <div class="flex items-center justify-between gap-4">
                                    <h4 class="font-extrabold text-emerald-950">
                                        Nuevas imágenes seleccionadas
                                    </h4>

                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700"
                                        x-text="imagenesNuevas.length + ' archivo(s)'"
                                    ></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <template
                                        x-for="(imagen, indice) in imagenesNuevas"
                                        :key="imagen.url"
                                    >
                                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                            <img
                                                :src="imagen.url"
                                                :alt="'Nueva fotografía ' + (indice + 1)"
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
                                Puedes reemplazar la portada actual con una imagen nueva.
                            </p>

                            <div class="mt-5 overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                                <img
                                    x-show="!portadaNueva"
                                    src="{{ $promocion->imagen_portada
                                        ? asset('storage/' . $promocion->imagen_portada)
                                        : asset('images/portada-institucion.jpg') }}"
                                    alt="Portada actual"
                                    class="aspect-[4/3] w-full object-cover"
                                    onerror="this.src='{{ asset('images/portada-institucion.jpg') }}'"
                                >

                                <img
                                    x-cloak
                                    x-show="portadaNueva"
                                    :src="portadaNueva"
                                    alt="Nueva portada"
                                    class="aspect-[4/3] w-full object-cover"
                                >
                            </div>

                            <label
                                for="imagen_portada"
                                class="mt-4 inline-flex w-full cursor-pointer items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-5 py-3 text-sm font-extrabold text-emerald-800 transition hover:bg-amber-100"
                            >
                                Cambiar portada
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
                                Información
                            </p>

                            <div class="mt-4 space-y-3 text-sm text-gray-700">
                                <p>
                                    <strong>Nivel:</strong>
                                    {{ $promocion->nivelEducativo?->nombre ?? 'Sin nivel' }}
                                </p>

                                <p>
                                    <strong>Creada:</strong>
                                    {{ $promocion->created_at?->format('d/m/Y H:i') }}
                                </p>

                                <p>
                                    <strong>Última actualización:</strong>
                                    {{ $promocion->updated_at?->format('d/m/Y H:i') }}
                                </p>

                                <p>
                                    <strong>Fotografías:</strong>
                                    {{ $promocion->imagenes->count() }}
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                Guardar cambios
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