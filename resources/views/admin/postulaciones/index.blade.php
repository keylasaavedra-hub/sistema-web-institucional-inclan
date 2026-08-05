<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Gestión institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Postulaciones
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Revisa y evalúa las postulaciones registradas en las convocatorias.
                </p>
            </div>

            <a
                href="{{ route('admin.convocatorias.index') }}"
                class="inline-flex w-fit items-center justify-center
                       rounded-xl border border-gray-300 bg-white
                       px-5 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50"
            >
                Ver convocatorias
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

            {{-- ESTADÍSTICAS --}}
            <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-6">

                <div class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-gray-500">
                        Total
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-emerald-950">
                        {{ $estadisticas['total'] }}
                    </p>
                </div>

                <div class="rounded-[24px] border border-blue-200 bg-blue-50 p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-blue-700">
                        Recibidas
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-blue-900">
                        {{ $estadisticas['recibidas'] }}
                    </p>
                </div>

                <div class="rounded-[24px] border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-amber-700">
                        En revisión
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-amber-900">
                        {{ $estadisticas['revision'] }}
                    </p>
                </div>

                <div class="rounded-[24px] border border-red-200 bg-red-50 p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-red-700">
                        Observadas
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-red-900">
                        {{ $estadisticas['observadas'] }}
                    </p>
                </div>

                <div class="rounded-[24px] border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-emerald-700">
                        Aptas
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-emerald-900">
                        {{ $estadisticas['aptas'] }}
                    </p>
                </div>

                <div class="rounded-[24px] border border-violet-200 bg-violet-50 p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-violet-700">
                        Seleccionadas
                    </p>

                    <p class="mt-3 text-3xl font-extrabold text-violet-900">
                        {{ $estadisticas['seleccionadas'] }}
                    </p>
                </div>

            </section>

            {{-- FILTROS --}}
            <section
                class="mt-8 rounded-[26px] border border-amber-200
                       bg-white p-6
                       shadow-[0_18px_50px_rgba(6,78,59,0.08)]"
            >
                <form
                    method="GET"
                    action="{{ route('admin.postulaciones.index') }}"
                    class="grid gap-5 lg:grid-cols-[1fr_220px_280px_auto]"
                >
                    <div>
                        <label for="buscar" class="text-sm font-extrabold text-emerald-950">
                            Buscar postulante
                        </label>

                        <input
                            id="buscar"
                            name="buscar"
                            type="text"
                            value="{{ request('buscar') }}"
                            placeholder="Código, nombres, DNI o correo..."
                            class="mt-2 w-full rounded-xl border-gray-300 px-4 py-3
                                   shadow-sm focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <div>
                        <label for="estado" class="text-sm font-extrabold text-emerald-950">
                            Estado
                        </label>

                        <select
                            id="estado"
                            name="estado"
                            class="mt-2 w-full rounded-xl border-gray-300 px-4 py-3
                                   shadow-sm focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                            <option value="">Todos</option>
                            <option value="recibida" @selected(request('estado') === 'recibida')>
                                Recibida
                            </option>
                            <option value="en_revision" @selected(request('estado') === 'en_revision')>
                                En revisión
                            </option>
                            <option value="observada" @selected(request('estado') === 'observada')>
                                Observada
                            </option>
                            <option value="apta" @selected(request('estado') === 'apta')>
                                Apta
                            </option>
                            <option value="no_apta" @selected(request('estado') === 'no_apta')>
                                No apta
                            </option>
                            <option value="seleccionada" @selected(request('estado') === 'seleccionada')>
                                Seleccionada
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="convocatoria_id" class="text-sm font-extrabold text-emerald-950">
                            Convocatoria
                        </label>

                        <select
                            id="convocatoria_id"
                            name="convocatoria_id"
                            class="mt-2 w-full rounded-xl border-gray-300 px-4 py-3
                                   shadow-sm focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                            <option value="">Todas las convocatorias</option>

                            @foreach ($convocatorias as $convocatoria)
                                <option
                                    value="{{ $convocatoria->id }}"
                                    @selected(
                                        (string) request('convocatoria_id')
                                        === (string) $convocatoria->id
                                    )
                                >
                                    {{ $convocatoria->codigo }} — {{ $convocatoria->titulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center
                                   rounded-xl bg-emerald-950 px-5 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900"
                        >
                            Filtrar
                        </button>

                        @if (
                            request()->filled('buscar')
                            || request()->filled('estado')
                            || request()->filled('convocatoria_id')
                        )
                            <a
                                href="{{ route('admin.postulaciones.index') }}"
                                class="inline-flex items-center justify-center rounded-xl
                                       border border-gray-300 bg-white px-4 py-3
                                       font-extrabold text-gray-600 transition
                                       hover:bg-gray-50"
                            >
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </section>

            {{-- TABLA --}}
            <section
                class="mt-8 overflow-hidden rounded-[26px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @if ($postulaciones->count())

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-950 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide">
                                        Postulante
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide">
                                        Convocatoria
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide">
                                        Contacto
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide">
                                        Registro
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-extrabold uppercase tracking-wide">
                                        Acción
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($postulaciones as $postulacion)

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

                                    <tr class="transition hover:bg-emerald-50/40">

                                        <td class="px-6 py-5">
                                            <p class="font-extrabold text-emerald-950">
                                                {{ $postulacion->apellidos }},
                                                {{ $postulacion->nombres }}
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-gray-600">
                                                DNI: {{ $postulacion->dni }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $postulacion->codigo }}
                                            </p>
                                        </td>

                                        <td class="max-w-sm px-6 py-5">
                                            <p class="font-bold text-gray-800">
                                                {{ $postulacion->convocatoria->titulo }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $postulacion->convocatoria->codigo }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-5">
                                            <p class="text-sm font-bold text-gray-700">
                                                {{ $postulacion->correo }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $postulacion->telefono ?: 'Sin teléfono' }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <span
                                                class="inline-flex rounded-full border px-3 py-1
                                                       text-xs font-extrabold
                                                       {{ $detalleEstado['clase'] }}"
                                            >
                                                {{ $detalleEstado['texto'] }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-bold text-gray-700">
                                                {{ $postulacion->created_at->format('d/m/Y') }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $postulacion->created_at->format('H:i') }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right">
                                            <a
                                                href="{{ route('admin.postulaciones.mostrar', $postulacion) }}"
                                                class="inline-flex items-center justify-center rounded-xl
                                                       border border-emerald-200 bg-emerald-50
                                                       px-4 py-2 text-sm font-extrabold
                                                       text-emerald-800 transition
                                                       hover:bg-emerald-100"
                                            >
                                                Revisar
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-100 px-6 py-5">
                        {{ $postulaciones->links() }}
                    </div>

                @else

                    <div class="px-6 py-16 text-center">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center
                                   rounded-2xl bg-emerald-50 text-emerald-800"
                        >
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M8 4h8"/>
                                <path d="M9 2h6a1 1 0 0 1 1 1v3H8V3a1 1 0 0 1 1-1Z"/>
                                <path d="M6 5H5a2 2 0 0 0-2 2v14h18V7a2 2 0 0 0-2-2h-1"/>
                                <path d="M7 11h10M7 15h7"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-xl font-extrabold text-emerald-950">
                            No hay postulaciones registradas
                        </h3>

                        <p class="mt-2 text-sm text-gray-600">
                            Las postulaciones enviadas desde el portal público aparecerán aquí.
                        </p>
                    </div>

                @endif
            </section>
        </div>
    </div>

</x-app-layout>