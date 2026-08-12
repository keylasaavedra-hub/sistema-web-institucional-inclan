<x-app-layout>

    @php
        $datos = $contenido?->datos ?? [];

        $imagenUrl = function (?string $ruta, string $fallback): string {
            if (!$ruta) {
                return asset($fallback);
            }

            if (str_starts_with($ruta, 'images/')) {
                return asset($ruta);
            }

            return asset('storage/' . ltrim($ruta, '/'));
        };
    @endphp

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="relative overflow-hidden rounded-[30px] bg-emerald-950 px-6 py-8 shadow-[0_20px_60px_rgba(6,78,59,0.14)] sm:px-8 lg:px-10">
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-amber-300/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-amber-300">
                            Contenido institucional
                        </p>
                        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">
                            Infraestructura
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                            Edita la presentación general, los ambientes y sus galerías fotográficas.
                        </p>
                    </div>

                    <a
                        href="{{ route('institucion.infraestructura') }}"
                        target="_blank"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-amber-300 bg-white/10 px-5 text-sm font-extrabold text-white transition hover:bg-white/20"
                    >
                        Ver página pública
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    x-data="{ visible: true }"
                    x-show="visible"
                    x-init="setTimeout(() => visible = false, 4000)"
                    x-transition
                    class="fixed right-6 top-6 z-[9999] w-[calc(100%-3rem)] max-w-md"
                >
                    <div class="flex items-start gap-4 rounded-2xl border border-emerald-200 bg-white p-5 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">✓</div>
                        <div class="min-w-0 flex-1">
                            <p class="font-extrabold text-emerald-950">Cambios guardados</p>
                            <p class="mt-1 text-sm leading-5 text-gray-600">{{ session('success') }}</p>
                        </div>
                        <button type="button" @click="visible = false" class="text-gray-400 hover:text-gray-700">✕</button>
                    </div>
                </div>
            @endif

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
            <form
                method="POST"
                action="{{ route('admin.contenido-institucional.institucion.infraestructura.actualizar') }}"
                enctype="multipart/form-data"
                class="mt-6 rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
            >
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">Contenido general</p>
                        <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">Presentación de infraestructura</h2>
                    </div>
                    <button class="rounded-xl bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-900">
                        Guardar contenido general
                    </button>
                </div>

                <div class="mt-7 grid gap-5 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Etiqueta</label>
                        <input name="etiqueta" required value="{{ old('etiqueta', $contenido?->subtitulo ?? 'Espacios educativos') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Título</label>
                        <input name="titulo" required value="{{ old('titulo', $contenido?->titulo ?? 'Nuestra infraestructura') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-extrabold text-emerald-950">Descripción principal</label>
                        <textarea name="descripcion_1" rows="4" required class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('descripcion_1', $contenido?->contenido ?? 'Nuestra institución dispone de ambientes destinados al aprendizaje, la gestión, la convivencia y el bienestar de toda la comunidad educativa.') }}</textarea>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-extrabold text-emerald-950">Descripción secundaria</label>
                        <textarea name="descripcion_2" rows="4" required class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('descripcion_2', $datos['descripcion_2'] ?? 'Cada espacio está orientado a brindar condiciones adecuadas para el desarrollo de las actividades de los niveles inicial, primario y secundario.') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Destacado</label>
                        <input name="destacado_titulo" required value="{{ old('destacado_titulo', $datos['destacado_titulo'] ?? 'Espacios seguros y funcionales') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Texto del destacado</label>
                        <input name="destacado_texto" required value="{{ old('destacado_texto', $datos['destacado_texto'] ?? 'Promovemos el cuidado, el orden y el uso responsable de todos nuestros ambientes.') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Etiqueta de ambientes</label>
                        <input name="ambientes_etiqueta" required value="{{ old('ambientes_etiqueta', $datos['ambientes_etiqueta'] ?? 'Ambientes institucionales') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Título de ambientes</label>
                        <input name="ambientes_titulo" required value="{{ old('ambientes_titulo', $datos['ambientes_titulo'] ?? 'Conoce nuestros espacios') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-extrabold text-emerald-950">Descripción de ambientes</label>
                        <textarea name="ambientes_descripcion" rows="3" required class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('ambientes_descripcion', $datos['ambientes_descripcion'] ?? 'Selecciona un ambiente para conocerlo y ver más fotografías de sus instalaciones.') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Etiqueta final</label>
                        <input name="cierre_etiqueta" required value="{{ old('cierre_etiqueta', $datos['cierre_etiqueta'] ?? 'Compromiso institucional') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div>
                        <label class="text-sm font-extrabold text-emerald-950">Título final</label>
                        <input name="cierre_titulo" required value="{{ old('cierre_titulo', $datos['cierre_titulo'] ?? 'Cuidamos los espacios que compartimos') }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-extrabold text-emerald-950">Descripción final</label>
                        <textarea name="cierre_descripcion" rows="3" required class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ old('cierre_descripcion', $datos['cierre_descripcion'] ?? 'Promovemos una cultura de orden, limpieza, seguridad y conservación de nuestras instalaciones.') }}</textarea>
                    </div>
                    <div class="lg:col-span-2 grid gap-5 lg:grid-cols-[0.7fr_1.3fr]">
                        <div class="overflow-hidden rounded-2xl border border-amber-200 bg-gray-100">
                            <img src="{{ $imagenUrl($contenido?->imagen, 'images/infraestructura/infraestructura-principal.png') }}" class="h-56 w-full object-cover" alt="Imagen principal">
                        </div>
                        <div>
                            <label class="text-sm font-extrabold text-emerald-950">Cambiar imagen principal</label>
                            <input name="imagen_principal" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-3 block w-full text-sm text-gray-600">
                            <p class="mt-2 text-xs leading-5 text-gray-500">JPG, PNG o WEBP. Máximo 4 MB.</p>
                        </div>
                    </div>
                </div>
            </form>

            {{-- AMBIENTES --}}
            <div class="mt-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">Ambientes institucionales</p>
                    <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">Gestionar ambientes y fotografías</h2>
                </div>

                <div class="mt-6 space-y-6">
                    @foreach ($ambientes as $ambiente)
                        <section class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-sm">
                            <div class="grid lg:grid-cols-[0.34fr_0.66fr]">
                                <div class="bg-emerald-950 p-5">
                                    <img
                                        src="{{ $imagenUrl($ambiente->imagen, 'images/infraestructura-default.png') }}"
                                        alt="{{ $ambiente->titulo }}"
                                        class="h-64 w-full rounded-2xl object-cover"
                                    >

                                    <div class="mt-4 flex items-center justify-between gap-3">
                                        <span class="rounded-full px-3 py-1.5 text-xs font-extrabold {{ $ambiente->estado ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $ambiente->estado ? 'Publicado' : 'Oculto' }}
                                        </span>

                                        <form method="POST" action="{{ route('admin.contenido-institucional.institucion.infraestructura.ambientes.estado', $ambiente) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="text-xs font-extrabold text-amber-300 hover:text-amber-200">
                                                {{ $ambiente->estado ? 'Ocultar' : 'Publicar' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="p-6 sm:p-8">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.contenido-institucional.institucion.infraestructura.ambientes.actualizar', $ambiente) }}"
                                        enctype="multipart/form-data"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div class="grid gap-5 lg:grid-cols-2">
                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">Título</label>
                                                <input name="titulo" required value="{{ $ambiente->titulo }}" class="mt-2 h-12 w-full rounded-xl border-gray-300 bg-gray-50">
                                            </div>
                                            <div>
                                                <label class="text-sm font-extrabold text-emerald-950">Imagen principal</label>
                                                <input name="imagen" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-3 block w-full text-sm text-gray-600">
                                            </div>
                                            <div class="lg:col-span-2">
                                                <label class="text-sm font-extrabold text-emerald-950">Descripción</label>
                                                <textarea name="descripcion" rows="4" required class="mt-2 w-full rounded-xl border-gray-300 bg-gray-50">{{ $ambiente->descripcion }}</textarea>
                                            </div>
                                        </div>

                                        <div class="mt-5 flex justify-end">
                                            <button class="rounded-xl bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-900">
                                                Guardar ambiente
                                            </button>
                                        </div>
                                    </form>

                                    <div class="mt-7 border-t border-gray-200 pt-6">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                            <div>
                                                <p class="font-extrabold text-emerald-950">Galería fotográfica</p>
                                                <p class="mt-1 text-sm text-gray-500">Agrega varias imágenes o elimina las que ya no necesites.</p>
                                            </div>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.contenido-institucional.institucion.infraestructura.ambientes.imagenes.guardar', $ambiente) }}"
                                                enctype="multipart/form-data"
                                                class="flex flex-col gap-3 sm:flex-row sm:items-center"
                                            >
                                                @csrf
                                                <input name="imagenes[]" type="file" multiple required accept=".jpg,.jpeg,.png,.webp" class="block max-w-xs text-sm text-gray-600">
                                                <button class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs font-extrabold text-emerald-900 hover:bg-emerald-100">
                                                    + Agregar fotografías
                                                </button>
                                            </form>
                                        </div>

                                        @if ($ambiente->imagenes->isNotEmpty())
                                            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                                @foreach ($ambiente->imagenes as $imagen)
                                                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50">
                                                        <img
                                                            src="{{ $imagenUrl($imagen->imagen, 'images/infraestructura-default.png') }}"
                                                            class="h-36 w-full object-cover"
                                                            alt="Fotografía de {{ $ambiente->titulo }}"
                                                        >
                                                        <form
                                                            method="POST"
                                                            action="{{ route('admin.contenido-institucional.institucion.infraestructura.imagenes.eliminar', $imagen) }}"
                                                            onsubmit="return confirm('¿Eliminar esta fotografía?')"
                                                            class="p-3"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="w-full rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-extrabold text-red-700 hover:bg-red-100">
                                                                Eliminar fotografía
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="mt-5 rounded-2xl border border-dashed border-amber-300 bg-amber-50/50 p-6 text-center text-sm text-gray-600">
                                                Este ambiente todavía no tiene fotografías registradas.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</x-app-layout>