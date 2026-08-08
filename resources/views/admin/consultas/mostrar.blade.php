<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Panel administrativo
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Detalle de consulta
                </h2>
            </div>

            <a
                href="{{ route('admin.consultas.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl border border-gray-300 bg-white
                       px-4 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    @php
    $estados = [
    'recibida' => [
    'texto' => 'Recibida',
    'clase' => 'border-blue-200 bg-blue-50 text-blue-800',
    ],
    'en_revision' => [
    'texto' => 'En revisión',
    'clase' => 'border-amber-200 bg-amber-50 text-amber-800',
    ],
    'derivada' => [
    'texto' => 'Derivada',
    'clase' => 'border-violet-200 bg-violet-50 text-violet-800',
    ],
    'respondida' => [
    'texto' => 'Respondida',
    'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
    ],
    'cerrada' => [
    'texto' => 'Cerrada',
    'clase' => 'border-gray-300 bg-gray-100 text-gray-800',
    ],
    ];

    $detalleEstado = $estados[$consulta->estado] ?? [
    'texto' => ucfirst(str_replace('_', ' ', $consulta->estado)),
    'clase' => 'border-gray-200 bg-gray-50 text-gray-800',
    ];
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('mensaje'))

            <div
                class="mb-7 rounded-2xl border border-emerald-200
                           bg-emerald-50 p-5 text-emerald-800">
                <p class="font-extrabold">
                    {{ session('mensaje') }}
                </p>
            </div>

            @endif

            @if (session('error'))
            <div
                class="mb-7 rounded-2xl border border-red-200
               bg-red-50 p-5 text-red-800">
                <p class="font-extrabold">
                    {{ session('error') }}
                </p>
            </div>
            @endif

            @if ($errors->any())

            <div
                class="mb-7 rounded-2xl border border-red-200
                           bg-red-50 p-5">
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

            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">

                {{-- INFORMACIÓN DE LA CONSULTA --}}
                <section
                    class="overflow-hidden rounded-[28px]
                           border border-gray-200 bg-white
                           shadow-[0_18px_50px_rgba(15,23,42,0.06)]">
                    <div
                        class="flex flex-col gap-5 bg-emerald-950
                               p-6 text-white sm:flex-row
                               sm:items-center sm:justify-between sm:p-8">
                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-300">
                                Código de seguimiento
                            </p>

                            <h3 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                                {{ $consulta->codigo }}
                            </h3>
                        </div>

                        <span
                            class="inline-flex w-fit rounded-full border
                                   px-4 py-2 text-sm font-extrabold
                                   {{ $detalleEstado['clase'] }}">
                            {{ $detalleEstado['texto'] }}
                        </span>
                    </div>

                    <div class="space-y-7 p-6 sm:p-8">

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div
                                class="rounded-2xl border border-gray-200
                                       bg-gray-50 p-5">
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Solicitante
                                </p>

                                <p class="mt-2 font-extrabold text-emerald-950">
                                    {{ $consulta->nombres }}
                                    {{ $consulta->apellidos }}
                                </p>
                            </div>

                            <div
                                class="rounded-2xl border border-gray-200
                                       bg-gray-50 p-5">
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Fecha de registro
                                </p>

                                <p class="mt-2 font-extrabold text-emerald-950">
                                    {{ $consulta->created_at->format('d/m/Y') }}
                                    a las
                                    {{ $consulta->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Correo
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->correo }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Teléfono
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->telefono ?: 'No registrado' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    DNI
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->dni ?: 'No registrado' }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Respondida
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->respondido_en
                                        ? $consulta->respondido_en->format('d/m/Y H:i')
                                        : 'Todavía no' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500">
                                Asunto
                            </p>

                            <p class="mt-2 text-lg font-extrabold text-emerald-950">
                                {{ $consulta->asunto }}
                            </p>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500">
                                Consulta registrada
                            </p>

                            <div
                                class="mt-2 whitespace-pre-line rounded-2xl
                                       border border-gray-200 bg-gray-50
                                       p-5 leading-7 text-gray-700">
                                {{ $consulta->mensaje }}
                            </div>
                        </div>

                        @if ($consulta->respuesta)

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-emerald-700">
                                Respuesta actual
                            </p>

                            <div
                                class="mt-2 whitespace-pre-line rounded-2xl
                                           border border-emerald-200
                                           bg-emerald-50 p-5
                                           leading-7 text-emerald-900">
                                {{ $consulta->respuesta }}
                            </div>
                        </div>

                        @endif
                    </div>
                </section>

                @if (
                auth()->user()->esAdministrador()
                || auth()->user()->tienePermiso('consultas.atender')
                )

                {{-- FORMULARIO DE ATENCIÓN --}}
                <aside
                    class="h-fit rounded-[28px] border border-amber-200
                           bg-white p-6
                           shadow-[0_18px_50px_rgba(6,78,59,0.08)]
                           sm:p-8">
                    <div class="border-b border-gray-100 pb-6">

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600">
                            Atención administrativa
                        </p>

                        <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                            Actualizar consulta
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Cambia el estado y registra la respuesta que verá
                            el ciudadano en el seguimiento público.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.consultas.actualizar', $consulta->id) }}"
                        class="mt-7 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label
                                for="estado"
                                class="text-sm font-extrabold text-emerald-950">
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
                                    value="recibida"
                                    @selected(old('estado', $consulta->estado) === 'recibida')
                                    >
                                    Recibida
                                </option>

                                <option
                                    value="en_revision"
                                    @selected(old('estado', $consulta->estado) === 'en_revision')
                                    >
                                    En revisión
                                </option>

                                <option
                                    value="derivada"
                                    @selected(old('estado', $consulta->estado) === 'derivada')
                                    >
                                    Derivada
                                </option>

                                <option
                                    value="respondida"
                                    @selected(old('estado', $consulta->estado) === 'respondida')
                                    >
                                    Respondida
                                </option>

                                <option
                                    value="cerrada"
                                    @selected(old('estado', $consulta->estado) === 'cerrada')
                                    >
                                    Cerrada
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                for="respuesta"
                                class="text-sm font-extrabold text-emerald-950">
                                Respuesta institucional
                            </label>

                            <textarea
                                id="respuesta"
                                name="respuesta"
                                rows="10"
                                maxlength="3000"
                                placeholder="Escribe la respuesta para el ciudadano..."
                                class="mt-2 w-full resize-y rounded-xl
                                       border-gray-300 px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">{{ old('respuesta', $consulta->respuesta) }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Máximo 3000 caracteres.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center
                                   justify-center rounded-xl bg-emerald-950
                                   px-6 py-4 font-extrabold text-white
                                   transition hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200">
                            Guardar cambios
                        </button>
                    </form>
                </aside>
                @else
                <aside
                    class="h-fit rounded-[28px] border border-gray-200
               bg-white p-6
               shadow-[0_18px_50px_rgba(15,23,42,0.06)]
               sm:p-8">
                    <p
                        class="text-xs font-extrabold uppercase
                   tracking-[0.16em] text-gray-500">
                        Modo consulta
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                        Acceso de solo lectura
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Puedes revisar la información y la respuesta de esta
                        consulta, pero tu rol no tiene permiso para modificar
                        su estado ni registrar respuestas.
                    </p>
                </aside>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>