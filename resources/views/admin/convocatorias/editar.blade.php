<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Convocatorias
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar convocatoria
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza la información del proceso seleccionado
                </p>
            </div>

            <a
                href="{{ route('admin.convocatorias.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl border border-gray-300 bg-white
                       px-4 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('mensaje'))
            <div class="mb-7 rounded-2xl border border-emerald-200 bg-emerald-50 p-5">
                <p class="font-extrabold text-emerald-800">
                    {{ session('mensaje') }}
                </p>
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-7 rounded-2xl border border-red-200 bg-red-50 p-5">
                <p class="font-extrabold text-red-800">
                    Revisa la información ingresada
                </p>

                <ul class="mt-3 space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.convocatorias.update', $convocatoria->id) }}"
                class="overflow-hidden rounded-[28px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]">
                @csrf
                @method('PUT')

                <div class="bg-emerald-950 p-7 text-white sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                        Registro existente
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold">
                        {{ $convocatoria->titulo }}
                    </h3>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                        Las convocatorias publicadas podrán mostrarse en el portal institucional.
                    </p>
                </div>

                <div class="space-y-8 p-6 sm:p-8">

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="tipo" class="text-sm font-extrabold text-emerald-950">
                                Tipo de convocatoria
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="tipo"
                                name="tipo"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                                <option value="">Selecciona una opción</option>

                                <option
                                    value="practicas"
                                    @selected(old('tipo', $convocatoria->tipo) === 'practicas')
                                    >
                                    Prácticas
                                </option>

                                <option
                                    value="laboral"
                                    @selected(old('tipo', $convocatoria->tipo) === 'laboral')
                                    >
                                    Laboral
                                </option>

                                <option
                                    value="cas"
                                    @selected(old('tipo', $convocatoria->tipo) === 'cas')
                                    >
                                    CAS
                                </option>

                                <option
                                    value="servicios"
                                    @selected(old('tipo', $convocatoria->tipo) === 'servicios')
                                    >
                                    Servicios
                                </option>

                                <option
                                    value="voluntariado"
                                    @selected(old('tipo', $convocatoria->tipo) === 'voluntariado')
                                    >
                                    Voluntariado
                                </option>

                                <option
                                    value="otro"
                                    @selected(old('tipo', $convocatoria->tipo) === 'otro')
                                    >
                                    Otro
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="vacantes" class="text-sm font-extrabold text-emerald-950">
                                Número de vacantes
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="vacantes"
                                name="vacantes"
                                type="number"
                                min="1"
                                max="999"
                                required
                                value="{{ old('vacantes', $convocatoria->vacantes) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                        </div>
                    </div>

                    <div>
                        <label for="titulo" class="text-sm font-extrabold text-emerald-950">
                            Título
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="titulo"
                            name="titulo"
                            type="text"
                            maxlength="220"
                            required
                            value="{{ old('titulo', $convocatoria->titulo) }}"
                            placeholder="Ejemplo: Convocatoria para practicantes de soporte técnico"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="area_id" class="text-sm font-extrabold text-emerald-950">
                                Área institucional
                            </label>

                            <select
                                id="area_id"
                                name="area_id"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                                <option value="">Sin área específica</option>

                                @foreach ($areas as $area)
                                <option
                                    value="{{ $area->id }}"
                                    @selected(
                                    (string) old('area_id', $convocatoria->area_id)
                                    === (string) $area->id
                                    )
                                    >
                                    {{ $area->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="cargo_id" class="text-sm font-extrabold text-emerald-950">
                                Cargo
                            </label>

                            <select
                                id="cargo_id"
                                name="cargo_id"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                                <option value="">Sin cargo específico</option>

                                @foreach ($cargos as $cargo)
                                <option
                                    value="{{ $cargo->id }}"
                                    @selected(
                                    (string) old('cargo_id', $convocatoria->cargo_id)
                                    === (string) $cargo->id
                                    )
                                    >
                                    {{ $cargo->nombre }}
                                </option>
                                @endforeach
                            </select>

                            @if ($cargos->isEmpty())
                            <p class="mt-2 text-xs text-amber-700">
                                No hay cargos registrados todavía.
                            </p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="descripcion" class="text-sm font-extrabold text-emerald-950">
                            Descripción
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="6"
                            maxlength="5000"
                            required
                            placeholder="Describe el propósito y alcance de la convocatoria..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">{{ old('descripcion', $convocatoria->descripcion) }}</textarea>
                    </div>

                    <div>
                        <label for="perfil" class="text-sm font-extrabold text-emerald-950">
                            Perfil solicitado
                        </label>

                        <textarea
                            id="perfil"
                            name="perfil"
                            rows="5"
                            maxlength="5000"
                            placeholder="Indica las características o experiencia esperada..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">{{ old('perfil', $convocatoria->perfil) }}</textarea>
                    </div>

                    <div>
                        <label for="requisitos" class="text-sm font-extrabold text-emerald-950">
                            Requisitos
                        </label>

                        <textarea
                            id="requisitos"
                            name="requisitos"
                            rows="6"
                            maxlength="5000"
                            placeholder="Escribe un requisito por línea..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">{{ old('requisitos', $convocatoria->requisitos) }}</textarea>
                    </div>

                    <div>
                        <label for="cronograma" class="text-sm font-extrabold text-emerald-950">
                            Cronograma
                        </label>

                        <textarea
                            id="cronograma"
                            name="cronograma"
                            rows="6"
                            maxlength="5000"
                            placeholder="Detalla las etapas y fechas principales del proceso..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700">{{ old('cronograma', $convocatoria->cronograma) }}</textarea>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div>
                            <label for="fecha_inicio" class="text-sm font-extrabold text-emerald-950">
                                Fecha de inicio
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="fecha_inicio"
                                name="fecha_inicio"
                                type="datetime-local"
                                required
                                value="{{ old('fecha_inicio', optional($convocatoria->fecha_inicio)->format('Y-m-d\TH:i')) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                        </div>

                        <div>
                            <label for="fecha_cierre" class="text-sm font-extrabold text-emerald-950">
                                Fecha de cierre
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="fecha_cierre"
                                name="fecha_cierre"
                                type="datetime-local"
                                required
                                value="{{ old('fecha_cierre', optional($convocatoria->fecha_cierre)->format('Y-m-d\TH:i')) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                        </div>

                        <div>
                            <label for="fecha_publicacion" class="text-sm font-extrabold text-emerald-950">
                                Fecha de publicación
                            </label>

                            <input
                                id="fecha_publicacion"
                                name="fecha_publicacion"
                                type="datetime-local"
                                value="{{ old('fecha_publicacion', optional($convocatoria->fecha_publicacion)->format('Y-m-d\TH:i')) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">

                            <p class="mt-2 text-xs text-gray-500">
                                Si publicas sin fecha, se usará la fecha actual.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="estado" class="text-sm font-extrabold text-emerald-950">
                                Estado
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                                <option
                                    value="borrador"
                                    @selected(old('estado', $convocatoria->estado) === 'borrador')
                                    >
                                    Borrador
                                </option>

                                <option
                                    value="publicada"
                                    @selected(old('estado', $convocatoria->estado) === 'publicada')
                                    >
                                    Publicada
                                </option>

                                <option
                                    value="cerrada"
                                    @selected(old('estado', $convocatoria->estado) === 'cerrada')
                                    >
                                    Cerrada
                                </option>

                                <option
                                    value="anulada"
                                    @selected(old('estado', $convocatoria->estado) === 'anulada')
                                    >
                                    Anulada
                                </option>
                            </select>
                        </div>

                        <label
                            class="flex cursor-pointer items-start gap-4
                                   rounded-2xl border border-gray-200
                                   bg-gray-50 p-5 transition
                                   hover:border-amber-200 hover:bg-amber-50">
                            <input
                                type="checkbox"
                                name="destacada"
                                value="1"
                                @checked(old('destacada', $convocatoria->destacada))
                                class="mt-1 rounded border-gray-300
                                       text-amber-600 focus:ring-amber-500">

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Convocatoria destacada
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    Permitirá resaltar este proceso en el portal público.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-7 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('admin.convocatorias.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl border border-gray-300
                                   bg-white px-6 py-3 font-extrabold
                                   text-gray-700 transition hover:bg-gray-50">
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center
                                   rounded-xl bg-emerald-950 px-7 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200">
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>