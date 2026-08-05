<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Atención institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Mesa de Partes
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Solicitudes y documentos presentados por los ciudadanos
                </p>
            </div>

            <span
                class="inline-flex w-fit items-center rounded-full
                       border border-emerald-200 bg-emerald-50
                       px-4 py-2 text-sm font-extrabold text-emerald-800"
            >
                {{ $tramites->total() }}
                {{ $tramites->total() === 1 ? 'trámite' : 'trámites' }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- FILTROS --}}
            <section
                class="rounded-[26px] border border-amber-200
                       bg-white p-6
                       shadow-[0_18px_50px_rgba(6,78,59,0.08)]"
            >
                <form
                    method="GET"
                    action="{{ route('admin.tramites.index') }}"
                    class="grid gap-5 lg:grid-cols-[1fr_260px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Buscar trámite
                        </label>

                        <input
                            id="buscar"
                            name="buscar"
                            type="text"
                            value="{{ request('buscar') }}"
                            placeholder="Código, nombre, documento, correo o asunto..."
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <div>
                        <label
                            for="estado"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Estado
                        </label>

                        <select
                            id="estado"
                            name="estado"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                            <option value="">Todos los estados</option>
                            <option value="recibido" @selected(request('estado') === 'recibido')>
                                Recibido
                            </option>
                            <option value="en_revision" @selected(request('estado') === 'en_revision')>
                                En revisión
                            </option>
                            <option value="derivado" @selected(request('estado') === 'derivado')>
                                Derivado
                            </option>
                            <option value="observado" @selected(request('estado') === 'observado')>
                                Observado
                            </option>
                            <option value="atendido" @selected(request('estado') === 'atendido')>
                                Atendido
                            </option>
                            <option value="cerrado" @selected(request('estado') === 'cerrado')>
                                Cerrado
                            </option>
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

                        @if (request()->filled('buscar') || request()->filled('estado'))
                            <a
                                href="{{ route('admin.tramites.index') }}"
                                class="inline-flex items-center justify-center
                                       rounded-xl border border-gray-300
                                       bg-white px-4 py-3 font-extrabold
                                       text-gray-600 transition hover:bg-gray-50"
                            >
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </section>

            {{-- LISTADO --}}
            <section
                class="mt-8 overflow-hidden rounded-[26px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @if ($tramites->count())

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-emerald-950 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Código
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Solicitante
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Documento
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Fecha
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-extrabold uppercase tracking-wider">
                                        Acción
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($tramites as $tramite)

                                    @php
                                        $estados = [
                                            'recibido' => [
                                                'texto' => 'Recibido',
                                                'clase' => 'border-blue-200 bg-blue-50 text-blue-700',
                                            ],
                                            'en_revision' => [
                                                'texto' => 'En revisión',
                                                'clase' => 'border-amber-200 bg-amber-50 text-amber-700',
                                            ],
                                            'derivado' => [
                                                'texto' => 'Derivado',
                                                'clase' => 'border-violet-200 bg-violet-50 text-violet-700',
                                            ],
                                            'observado' => [
                                                'texto' => 'Observado',
                                                'clase' => 'border-red-200 bg-red-50 text-red-700',
                                            ],
                                            'atendido' => [
                                                'texto' => 'Atendido',
                                                'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            ],
                                            'cerrado' => [
                                                'texto' => 'Cerrado',
                                                'clase' => 'border-gray-300 bg-gray-100 text-gray-700',
                                            ],
                                        ];

                                        $detalleEstado = $estados[$tramite->estado] ?? [
                                            'texto' => ucfirst(str_replace('_', ' ', $tramite->estado)),
                                            'clase' => 'border-gray-200 bg-gray-50 text-gray-700',
                                        ];

                                        $solicitante = $tramite->tipo_persona === 'juridica'
                                            ? ($tramite->razon_social ?: 'Persona jurídica')
                                            : trim("{$tramite->nombres} {$tramite->apellidos}");
                                    @endphp

                                    <tr class="transition hover:bg-emerald-50/40">
                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-extrabold text-emerald-950">
                                                {{ $tramite->codigo }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ ucfirst($tramite->tipo_persona) }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-5">
                                            <p class="font-bold text-gray-900">
                                                {{ $solicitante ?: 'Sin nombre registrado' }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $tramite->correo }}
                                            </p>
                                        </td>

                                        <td class="max-w-xs px-6 py-5">
                                            <p class="font-bold text-gray-800">
                                                {{ $tramite->tipo_documento }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ \Illuminate\Support\Str::limit($tramite->asunto, 55) }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                            {{ $tramite->created_at->format('d/m/Y') }}

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $tramite->created_at->format('H:i') }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <span
                                                class="inline-flex rounded-full border
                                                       px-3 py-1 text-xs font-extrabold
                                                       {{ $detalleEstado['clase'] }}"
                                            >
                                                {{ $detalleEstado['texto'] }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right">
                                            <a
                                                href="{{ route('admin.tramites.mostrar', $tramite) }}"
                                                class="inline-flex items-center justify-center
                                                       rounded-xl bg-emerald-950
                                                       px-4 py-2 text-sm font-extrabold
                                                       text-white transition
                                                       hover:bg-emerald-900"
                                            >
                                                Ver detalle
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-100 px-6 py-5">
                        {{ $tramites->links() }}
                    </div>

                @else

                    <div class="px-6 py-16 text-center">
                        <div
                            class="mx-auto flex h-16 w-16 items-center
                                   justify-center rounded-2xl
                                   bg-emerald-50 text-emerald-800"
                        >
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M6 3h9l3 3v15H6z"/>
                                <path d="M14 3v4h4"/>
                                <path d="M9 12h6M9 16h4"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-xl font-extrabold text-emerald-950">
                            No se encontraron trámites
                        </h3>

                        <p class="mt-2 text-sm text-gray-600">
                            No existen registros que coincidan con los filtros utilizados.
                        </p>
                    </div>

                @endif
            </section>
        </div>
    </div>

</x-app-layout>