<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Calendario institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar evento
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Añade una actividad al calendario institucional
                </p>
            </div>

            <a
                href="{{ route('admin.eventos.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl border border-gray-300 bg-white
                       px-4 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50"
            >
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

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
                action="{{ route('admin.eventos.store') }}"
                class="overflow-hidden rounded-[28px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @csrf

                <div class="bg-emerald-950 p-7 text-white sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                        Nuevo registro
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold">
                        Información del evento
                    </h3>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                        Los eventos activos y públicos podrán mostrarse en el calendario del portal.
                    </p>
                </div>

                <div class="space-y-8 p-6 sm:p-8">

                    <div>
                        <label for="titulo" class="text-sm font-extrabold text-emerald-950">
                            Título del evento
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="titulo"
                            name="titulo"
                            type="text"
                            maxlength="180"
                            required
                            value="{{ old('titulo') }}"
                            placeholder="Ejemplo: Ceremonia por Fiestas Patrias"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="tipo" class="text-sm font-extrabold text-emerald-950">
                                Tipo de evento
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="tipo"
                                name="tipo"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                                <option value="">Selecciona una opción</option>
                                <option value="institucional" @selected(old('tipo') === 'institucional')>
                                    Institucional
                                </option>
                                <option value="academico" @selected(old('tipo') === 'academico')>
                                    Académico
                                </option>
                                <option value="civico" @selected(old('tipo') === 'civico')>
                                    Cívico
                                </option>
                                <option value="deportivo" @selected(old('tipo') === 'deportivo')>
                                    Deportivo
                                </option>
                                <option value="cultural" @selected(old('tipo') === 'cultural')>
                                    Cultural
                                </option>
                                <option value="reunion" @selected(old('tipo') === 'reunion')>
                                    Reunión
                                </option>
                                <option value="otro" @selected(old('tipo') === 'otro')>
                                    Otro
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="lugar" class="text-sm font-extrabold text-emerald-950">
                                Lugar
                            </label>

                            <input
                                id="lugar"
                                name="lugar"
                                type="text"
                                maxlength="180"
                                value="{{ old('lugar') }}"
                                placeholder="Ejemplo: Patio principal"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="fecha_inicio" class="text-sm font-extrabold text-emerald-950">
                                Fecha y hora de inicio
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="fecha_inicio"
                                name="fecha_inicio"
                                type="datetime-local"
                                required
                                value="{{ old('fecha_inicio') }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>

                        <div>
                            <label for="fecha_fin" class="text-sm font-extrabold text-emerald-950">
                                Fecha y hora de finalización
                            </label>

                            <input
                                id="fecha_fin"
                                name="fecha_fin"
                                type="datetime-local"
                                value="{{ old('fecha_fin') }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Puede dejarse vacío si el evento no tiene una hora final definida.
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="descripcion" class="text-sm font-extrabold text-emerald-950">
                            Descripción
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="7"
                            maxlength="3000"
                            placeholder="Describe brevemente la actividad..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('descripcion') }}</textarea>

                        <p class="mt-2 text-xs text-gray-500">
                            Máximo 3000 caracteres.
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        <label
                            class="flex cursor-pointer items-start gap-4
                                   rounded-2xl border border-gray-200
                                   bg-gray-50 p-5 transition
                                   hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <input
                                type="checkbox"
                                name="es_publico"
                                value="1"
                                @checked(old('es_publico', true))
                                class="mt-1 rounded border-gray-300
                                       text-emerald-700 focus:ring-emerald-600"
                            >

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Mostrar en el portal público
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    El evento será visible en el calendario para los visitantes.
                                </span>
                            </span>
                        </label>

                        <label
                            class="flex cursor-pointer items-start gap-4
                                   rounded-2xl border border-gray-200
                                   bg-gray-50 p-5 transition
                                   hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                @checked(old('activo', true))
                                class="mt-1 rounded border-gray-300
                                       text-emerald-700 focus:ring-emerald-600"
                            >

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Evento activo
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    Permite desactivar temporalmente el evento sin eliminarlo.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-7 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('admin.eventos.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl border border-gray-300
                                   bg-white px-6 py-3 font-extrabold
                                   text-gray-700 transition hover:bg-gray-50"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center
                                   rounded-xl bg-emerald-950 px-7 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200"
                        >
                            Registrar evento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>