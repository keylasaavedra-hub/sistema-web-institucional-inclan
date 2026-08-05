<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Multimedia institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar video institucional
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Agrega un video mediante un enlace de YouTube.
                </p>
            </div>

            <a
                href="{{ route('admin.videos.index') }}"
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
                action="{{ route('admin.videos.guardar') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                    miniatura: null,

                    previsualizarMiniatura(evento) {
                        const archivo = evento.target.files[0];

                        if (!archivo) {
                            this.miniatura = null;
                            return;
                        }

                        this.miniatura = URL.createObjectURL(archivo);
                    }
                }"
            >
                @csrf

                <div class="grid gap-8 xl:grid-cols-[1fr_390px]">

                    <div class="space-y-8">
                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m10 9 5 3-5 3z"/>
                                    </svg>
                                </span>

                                <div>
                                    <h3 class="text-lg font-extrabold text-emerald-950">
                                        Información del video
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-gray-500">
                                        Estos datos aparecerán en el portal público.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-6 sm:grid-cols-2">

                                <div class="sm:col-span-2">
                                    <label for="titulo" class="mb-2 block text-sm font-bold text-gray-700">
                                        Título
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="titulo"
                                        name="titulo"
                                        value="{{ old('titulo') }}"
                                        maxlength="180"
                                        required
                                        placeholder="Ejemplo: Ceremonia por el Día de la Bandera"
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="url_youtube" class="mb-2 block text-sm font-bold text-gray-700">
                                        Enlace de YouTube
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="url"
                                        id="url_youtube"
                                        name="url_youtube"
                                        value="{{ old('url_youtube') }}"
                                        maxlength="500"
                                        required
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >

                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                        También admite enlaces de youtu.be, Shorts, transmisiones en vivo y enlaces embed.
                                    </p>
                                </div>

                                <div>
                                    <label for="categoria" class="mb-2 block text-sm font-bold text-gray-700">
                                        Categoría
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="categoria"
                                        name="categoria"
                                        required
                                        class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                                    >
                                        @foreach ([
                                            'institucional' => 'Institucional',
                                            'academico' => 'Académico',
                                            'civico' => 'Cívico',
                                            'cultural' => 'Cultural',
                                            'deportivo' => 'Deportivo',
                                            'promocional' => 'Promocional',
                                            'otro' => 'Otro',
                                        ] as $valor => $etiqueta)
                                            <option
                                                value="{{ $valor }}"
                                                @selected(old('categoria', 'institucional') === $valor)
                                            >
                                                {{ $etiqueta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="fecha_publicacion" class="mb-2 block text-sm font-bold text-gray-700">
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

                                <div class="sm:col-span-2">
                                    <label for="descripcion" class="mb-2 block text-sm font-bold text-gray-700">
                                        Descripción
                                    </label>

                                    <textarea
                                        id="descripcion"
                                        name="descripcion"
                                        rows="6"
                                        maxlength="3000"
                                        placeholder="Describe brevemente el contenido del video..."
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm leading-6 focus:border-amber-400 focus:ring-amber-400"
                                    >{{ old('descripcion') }}</textarea>
                                </div>

                                <div>
                                    <label for="orden" class="mb-2 block text-sm font-bold text-gray-700">
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
                                        Los valores menores aparecen primero.
                                    </p>
                                </div>

                                <div class="space-y-3">
                                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4">
                                        <input type="hidden" name="destacado" value="0">

                                        <input
                                            type="checkbox"
                                            name="destacado"
                                            value="1"
                                            @checked(old('destacado'))
                                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400"
                                        >

                                        <span>
                                            <strong class="block text-sm text-emerald-950">
                                                Video destacado
                                            </strong>

                                            <small class="text-gray-600">
                                                Tendrá prioridad en el listado.
                                            </small>
                                        </span>
                                    </label>

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
                                                Publicar video
                                            </strong>

                                            <small class="text-gray-600">
                                                Será visible para los visitantes.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </section>
                    </div>

                    <aside class="space-y-6">

                        <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Miniatura personalizada
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Es opcional. Sin una imagen propia se usará automáticamente la miniatura de YouTube.
                            </p>

                            <label
                                for="miniatura"
                                class="mt-5 block cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-amber-300 bg-gray-50"
                            >
                                <div
                                    x-show="!miniatura"
                                    class="flex aspect-video flex-col items-center justify-center px-5 text-center"
                                >
                                    <svg class="h-10 w-10 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m8 15 3-3 2 2 3-4 3 5"/>
                                    </svg>

                                    <span class="mt-3 text-sm font-bold text-gray-700">
                                        Seleccionar miniatura
                                    </span>

                                    <span class="mt-1 text-xs text-gray-500">
                                        JPG, PNG o WEBP
                                    </span>
                                </div>

                                <img
                                    x-cloak
                                    x-show="miniatura"
                                    :src="miniatura"
                                    alt="Vista previa de miniatura"
                                    class="aspect-video w-full object-cover"
                                >
                            </label>

                            <input
                                type="file"
                                id="miniatura"
                                name="miniatura"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="sr-only"
                                @change="previsualizarMiniatura($event)"
                            >
                        </section>

                        <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                                Recomendaciones
                            </p>

                            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                <p>
                                    Utiliza videos publicados por la institución o con autorización.
                                </p>

                                <p>
                                    Verifica que el video permita su reproducción desde otros sitios web.
                                </p>

                                <p>
                                    Evita registrar enlaces privados o eliminados.
                                </p>
                            </div>
                        </section>

                        <section class="sticky top-32 rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900"
                            >
                                Guardar video
                            </button>

                            <a
                                href="{{ route('admin.videos.index') }}"
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