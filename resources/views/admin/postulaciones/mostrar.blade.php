<x-app-layout>

    @php
        $estados = [
            'recibida' => [
                'texto' => 'Recibida',
                'clase' => 'border-blue-200 bg-blue-50 text-blue-700',
            ],
            'en_revision' => [
                'texto' => 'En revisión',
                'clase' => 'border-amber-200 bg-amber-50 text-amber-700',
            ],
            'observada' => [
                'texto' => 'Observada',
                'clase' => 'border-red-200 bg-red-50 text-red-700',
            ],
            'apta' => [
                'texto' => 'Apta',
                'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            ],
            'no_apta' => [
                'texto' => 'No apta',
                'clase' => 'border-gray-300 bg-gray-100 text-gray-700',
            ],
            'seleccionada' => [
                'texto' => 'Seleccionada',
                'clase' => 'border-violet-200 bg-violet-50 text-violet-700',
            ],
        ];

        $detalleEstado = $estados[$postulacion->estado] ?? [
            'texto' => ucfirst(str_replace('_', ' ', $postulacion->estado)),
            'clase' => 'border-gray-200 bg-gray-50 text-gray-700',
        ];
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Gestión de postulaciones
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Revisar postulación
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $postulacion->codigo }}
                </p>
            </div>

            <a
                href="{{ route('admin.postulaciones.index') }}"
                class="inline-flex w-fit items-center justify-center
                       rounded-xl border border-gray-300 bg-white
                       px-5 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50"
            >
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

            <div class="grid gap-8 xl:grid-cols-[1fr_380px]">

                <div class="space-y-8">

                    {{-- DATOS PRINCIPALES --}}
                    <section
                        class="overflow-hidden rounded-[28px]
                               border border-gray-200 bg-white
                               shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
                    >
                        <header
                            class="flex flex-col gap-4 bg-emerald-950
                                   p-7 text-white sm:flex-row
                                   sm:items-center sm:justify-between"
                        >
                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                    Postulante
                                </p>

                                <h3 class="mt-2 text-2xl font-extrabold">
                                    {{ $postulacion->nombres }}
                                    {{ $postulacion->apellidos }}
                                </h3>

                                <p class="mt-2 text-sm text-emerald-100">
                                    DNI: {{ $postulacion->dni }}
                                </p>
                            </div>

                            <span
                                class="inline-flex w-fit rounded-full border px-4 py-2
                                       text-sm font-extrabold
                                       {{ $detalleEstado['clase'] }}"
                            >
                                {{ $detalleEstado['texto'] }}
                            </span>
                        </header>

                        <div class="grid gap-6 p-6 sm:grid-cols-2 sm:p-8">

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Tipo de postulante
                                </p>

                                <p class="mt-2 font-extrabold text-emerald-950">
                                    {{ ucfirst($postulacion->tipo_postulante) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Fecha de registro
                                </p>

                                <p class="mt-2 font-extrabold text-emerald-950">
                                    {{ $postulacion->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Correo electrónico
                                </p>

                                <p class="mt-2 break-all font-bold text-gray-700">
                                    {{ $postulacion->correo }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Teléfono
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->telefono ?: 'No registrado' }}
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Dirección
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->direccion ?: 'No registrada' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- INFORMACIÓN ACADÉMICA --}}
                    <section
                        class="rounded-[28px] border border-gray-200
                               bg-white p-6
                               shadow-[0_18px_50px_rgba(15,23,42,0.06)]
                               sm:p-8"
                    >
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Información académica
                        </p>

                        <h3 class="mt-2 text-xl font-extrabold text-emerald-950">
                            Formación del postulante
                        </h3>

                        <div class="mt-6 grid gap-6 sm:grid-cols-2">

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Universidad o instituto
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->universidad ?: 'No registrada' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Carrera o especialidad
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->carrera ?: 'No registrada' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Ciclo
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->ciclo ?: 'No registrado' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- CONVOCATORIA --}}
                    <section
                        class="rounded-[28px] border border-amber-200
                               bg-amber-50 p-6 sm:p-8"
                    >
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-700">
                            Convocatoria
                        </p>

                        <h3 class="mt-2 text-xl font-extrabold text-emerald-950">
                            {{ $postulacion->convocatoria->titulo }}
                        </h3>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    Código
                                </p>

                                <p class="mt-2 font-bold text-amber-900">
                                    {{ $postulacion->convocatoria->codigo }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    Área
                                </p>

                                <p class="mt-2 font-bold text-amber-900">
                                    {{ $postulacion->convocatoria->area?->nombre ?: 'Sin área asignada' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    Cargo
                                </p>

                                <p class="mt-2 font-bold text-amber-900">
                                    {{ $postulacion->convocatoria->cargo?->nombre ?: 'Sin cargo específico' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    Fecha de cierre
                                </p>

                                <p class="mt-2 font-bold text-amber-900">
                                    {{ $postulacion->convocatoria->fecha_cierre->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.convocatorias.edit', $postulacion->convocatoria) }}"
                            class="mt-6 inline-flex items-center justify-center
                                   rounded-xl border border-amber-300 bg-white
                                   px-5 py-3 text-sm font-extrabold
                                   text-amber-900 transition hover:bg-amber-100"
                        >
                            Ver convocatoria administrativa
                        </a>
                    </section>

                    {{-- HISTORIAL DE REVISIÓN --}}
                    <section
                        class="rounded-[28px] border border-gray-200
                               bg-white p-6
                               shadow-[0_18px_50px_rgba(15,23,42,0.06)]
                               sm:p-8"
                    >
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-gray-500">
                            Revisión
                        </p>

                        <h3 class="mt-2 text-xl font-extrabold text-emerald-950">
                            Información de la última revisión
                        </h3>

                        <div class="mt-6 grid gap-6 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Revisor
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->revisor?->name ?: 'Pendiente de asignación' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                                    Fecha de revisión
                                </p>

                                <p class="mt-2 font-bold text-gray-700">
                                    {{ $postulacion->fecha_revision
                                        ? $postulacion->fecha_revision->format('d/m/Y H:i')
                                        : 'Pendiente de revisión' }}
                                </p>
                            </div>
                        </div>

                        @if ($postulacion->observacion)
                            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5">
                                <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                                    Observación registrada
                                </p>

                                <div class="mt-2 whitespace-pre-line leading-7 text-amber-900">
                                    {{ $postulacion->observacion }}
                                </div>
                            </div>
                        @endif
                    </section>
                </div>

                {{-- PANEL DE EVALUACIÓN --}}
                <aside>
                    <div
                        class="sticky top-28 rounded-[28px]
                               border border-emerald-200 bg-white
                               shadow-[0_18px_50px_rgba(6,78,59,0.10)]"
                    >
                        <div class="rounded-t-[27px] bg-emerald-950 p-6 text-white">
                            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                Evaluación administrativa
                            </p>

                            <h3 class="mt-2 text-xl font-extrabold">
                                Actualizar estado
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-emerald-100">
                                El estado seleccionado podrá ser consultado por el postulante.
                            </p>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('admin.postulaciones.actualizar', $postulacion) }}"
                            class="space-y-6 p-6"
                        >
                            @csrf
                            @method('PATCH')

                            <div>
                                <label
                                    for="estado"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Estado de la postulación
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="estado"
                                    name="estado"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300
                                           px-4 py-3 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                                    <option
                                        value="recibida"
                                        @selected(old('estado', $postulacion->estado) === 'recibida')
                                    >
                                        Recibida
                                    </option>

                                    <option
                                        value="en_revision"
                                        @selected(old('estado', $postulacion->estado) === 'en_revision')
                                    >
                                        En revisión
                                    </option>

                                    <option
                                        value="observada"
                                        @selected(old('estado', $postulacion->estado) === 'observada')
                                    >
                                        Observada
                                    </option>

                                    <option
                                        value="apta"
                                        @selected(old('estado', $postulacion->estado) === 'apta')
                                    >
                                        Apta
                                    </option>

                                    <option
                                        value="no_apta"
                                        @selected(old('estado', $postulacion->estado) === 'no_apta')
                                    >
                                        No apta
                                    </option>

                                    <option
                                        value="seleccionada"
                                        @selected(old('estado', $postulacion->estado) === 'seleccionada')
                                    >
                                        Seleccionada
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    for="observacion"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Observación
                                </label>

                                <textarea
                                    id="observacion"
                                    name="observacion"
                                    rows="8"
                                    maxlength="5000"
                                    placeholder="Registra una observación para el postulante..."
                                    class="mt-2 w-full resize-y rounded-xl
                                           border-gray-300 px-4 py-3 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >{{ old('observacion', $postulacion->observacion) }}</textarea>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    La observación será visible cuando el postulante consulte su estado.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4">
                                <p class="text-sm font-extrabold text-blue-900">
                                    Publicación de resultados
                                </p>

                                <p class="mt-2 text-xs leading-5 text-blue-800">
                                    Las postulaciones marcadas como “Apta” o “Seleccionada”
                                    aparecerán automáticamente en los resultados públicos.
                                </p>
                            </div>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center
                                       rounded-xl bg-emerald-950 px-6 py-4
                                       font-extrabold text-white transition
                                       hover:bg-emerald-900
                                       focus:outline-none focus:ring-4
                                       focus:ring-emerald-200"
                            >
                                Guardar evaluación
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>

</x-app-layout>