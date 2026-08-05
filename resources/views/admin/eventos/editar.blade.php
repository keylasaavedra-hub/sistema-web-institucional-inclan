<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Calendario institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar evento
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza la información del evento seleccionado
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
                action="{{ route('admin.eventos.update', $evento) }}"
                class="overflow-hidden rounded-[28px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @csrf
                @method('PUT')

                <div class="bg-emerald-950 p-7 text-white sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                        Registro existente
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold">
                        {{ $evento->titulo }}
                    </h3>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                        Los cambios realizados se aplicarán al calendario institucional.
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
                            value="{{ old('titulo', $evento->titulo) }}"
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
                                <option value="institucional" @selected(old('tipo', $evento->tipo) === 'institucional')>
                                    Institucional
                                </option>

                                <option value="academico" @selected(old('tipo', $evento->tipo) === 'academico')>
                                    Académico
                                </option>

                                <option value="civico" @selected(old('tipo', $evento->tipo) === 'civico')>
                                    Cívico
                                </option>

                                <option value="deportivo" @selected(old('tipo', $evento->tipo) === 'deportivo')>
                                    Deportivo
                                </option>

                                <option value="cultural" @selected(old('tipo', $evento->tipo) === 'cultural')>
                                    Cultural
                                </option>

                                <option value="reunion" @selected(old('tipo', $evento->tipo) === 'reunion')>
                                    Reunión
                                </option>

                                <option value="otro" @selected(old('tipo', $evento->tipo) === 'otro')>
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
                                value="{{ old('lugar', $evento->lugar) }}"
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
                                value="{{ old('fecha_inicio', optional($evento->fecha_inicio)->format('Y-m-d\TH:i')) }}"
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
                                value="{{ old('fecha_fin', optional($evento->fecha_fin)->format('Y-m-d\TH:i')) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
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
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('descripcion', $evento->descripcion) }}</textarea>

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
                                @checked(old('es_publico', $evento->es_publico))
                                class="mt-1 rounded border-gray-300
                                       text-emerald-700 focus:ring-emerald-600"
                            >

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Mostrar en el portal público
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    El evento será visible para los visitantes.
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
                                @checked(old('activo', $evento->activo))
                                class="mt-1 rounded border-gray-300
                                       text-emerald-700 focus:ring-emerald-600"
                            >

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Evento activo
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    Permite ocultarlo temporalmente sin eliminarlo.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-7 sm:flex-row sm:justify-between">

                        <div class="flex flex-col-reverse gap-3 sm:flex-row">
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
                                       hover:bg-emerald-900"
                            >
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>