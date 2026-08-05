<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Panel administrativo
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Consultas recibidas
                </h2>
            </div>

            <span
                class="inline-flex w-fit items-center rounded-full
                       border border-emerald-200 bg-emerald-50
                       px-4 py-2 text-sm font-extrabold text-emerald-800"
            >
                {{ $consultas->total() }}
                {{ $consultas->total() === 1 ? 'consulta' : 'consultas' }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- FILTROS --}}
            <div
                class="rounded-[26px] border border-amber-200
                       bg-white p-6
                       shadow-[0_18px_50px_rgba(6,78,59,0.08)]"
            >
                <form
                    method="GET"
                    action="{{ route('admin.consultas.index') }}"
                    class="grid gap-5 lg:grid-cols-[1fr_260px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Buscar consulta
                        </label>

                        <input
                            id="buscar"
                            name="buscar"
                            type="text"
                            value="{{ request('buscar') }}"
                            placeholder="Código, nombre, correo o asunto..."
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

                            <option value="recibida" @selected(request('estado') === 'recibida')>
                                Recibida
                            </option>

                            <option value="en_revision" @selected(request('estado') === 'en_revision')>
                                En revisión
                            </option>

                            <option value="derivada" @selected(request('estado') === 'derivada')>
                                Derivada
                            </option>

                            <option value="respondida" @selected(request('estado') === 'respondida')>
                                Respondida
                            </option>

                            <option value="cerrada" @selected(request('estado') === 'cerrada')>
                                Cerrada
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
                                href="{{ route('admin.consultas.index') }}"
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
            </div>

            {{-- TABLA --}}
            <div
                class="mt-8 overflow-hidden rounded-[26px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @if ($consultas->count())

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
                                        Asunto
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

                                @foreach ($consultas as $consulta)

                                    @php
                                        $estados = [
                                            'recibida' => [
                                                'texto' => 'Recibida',
                                                'clase' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            ],
                                            'en_revision' => [
                                                'texto' => 'En revisión',
                                                'clase' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            ],
                                            'derivada' => [
                                                'texto' => 'Derivada',
                                                'clase' => 'bg-violet-50 text-violet-700 border-violet-200',
                                            ],
                                            'respondida' => [
                                                'texto' => 'Respondida',
                                                'clase' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            ],
                                            'cerrada' => [
                                                'texto' => 'Cerrada',
                                                'clase' => 'bg-gray-100 text-gray-700 border-gray-300',
                                            ],
                                        ];

                                        $detalleEstado = $estados[$consulta->estado] ?? [
                                            'texto' => ucfirst(str_replace('_', ' ', $consulta->estado)),
                                            'clase' => 'bg-gray-50 text-gray-700 border-gray-200',
                                        ];
                                    @endphp

                                    <tr class="transition hover:bg-emerald-50/40">
                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-extrabold text-emerald-950">
                                                {{ $consulta->codigo }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-5">
                                            <p class="font-bold text-gray-900">
                                                {{ $consulta->nombres }}
                                                {{ $consulta->apellidos }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $consulta->correo }}
                                            </p>
                                        </td>

                                        <td class="max-w-xs px-6 py-5">
                                            <p class="font-semibold text-gray-800">
                                                {{ \Illuminate\Support\Str::limit($consulta->asunto, 60) }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                            {{ $consulta->created_at->format('d/m/Y') }}

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $consulta->created_at->format('H:i') }}
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
                                                href="{{ route('admin.consultas.mostrar', $consulta) }}"
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
                        {{ $consultas->links() }}
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
                                <path d="M4 4h16v12H5.5L4 18z"/>
                                <path d="M8 8h8M8 12h5"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-xl font-extrabold text-emerald-950">
                            No se encontraron consultas
                        </h3>

                        <p class="mt-2 text-sm text-gray-600">
                            No existen registros que coincidan con los filtros utilizados.
                        </p>
                    </div>

                @endif
            </div>
        </div>
    </div>

</x-app-layout>