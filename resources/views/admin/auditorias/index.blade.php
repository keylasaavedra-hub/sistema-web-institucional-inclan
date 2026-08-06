<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Historial de auditoría
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Consulta las acciones realizadas por los usuarios administrativos.
                </p>
            </div>

            <div
                class="inline-flex items-center gap-2 rounded-2xl
                       border border-emerald-100 bg-emerald-50
                       px-4 py-3 text-sm font-bold text-emerald-900"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.9"
                >
                    <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z" />
                    <path d="m9 12 2 2 4-4" />
                </svg>

                {{ $auditorias->total() }} registro(s)
            </div>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            {{-- FILTROS --}}
            <div
                class="rounded-3xl border border-gray-200
                       bg-white p-5 shadow-sm sm:p-6"
            >
                <form
                    method="GET"
                    action="{{ route('admin.auditorias.index') }}"
                    class="grid gap-4 md:grid-cols-2 xl:grid-cols-4"
                >
                    <div class="xl:col-span-2">
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar
                        </label>

                        <input
                            id="buscar"
                            name="buscar"
                            type="text"
                            value="{{ $buscar }}"
                            placeholder="Descripción, DNI, tabla, IP o registro..."
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                    </div>

                    <div>
                        <label
                            for="modulo"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Módulo
                        </label>

                        <select
                            id="modulo"
                            name="modulo"
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                            <option value="">Todos los módulos</option>

                            @foreach ($modulos as $opcionModulo)
                                <option
                                    value="{{ $opcionModulo }}"
                                    @selected($modulo === $opcionModulo)
                                >
                                    {{ $opcionModulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="accion"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Acción
                        </label>

                        <select
                            id="accion"
                            name="accion"
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                            <option value="">Todas las acciones</option>

                            @foreach ($acciones as $opcionAccion)
                                <option
                                    value="{{ $opcionAccion }}"
                                    @selected($accion === $opcionAccion)
                                >
                                    {{ ucfirst($opcionAccion) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="usuario_id"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Usuario
                        </label>

                        <select
                            id="usuario_id"
                            name="usuario_id"
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                            <option value="">Todos los usuarios</option>

                            @foreach ($usuarios as $usuario)
                                <option
                                    value="{{ $usuario->id }}"
                                    @selected($usuarioId === $usuario->id)
                                >
                                    {{ $usuario->name }}
                                    {{ $usuario->apellidos }}
                                    — {{ $usuario->dni }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="fecha_desde"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Desde
                        </label>

                        <input
                            id="fecha_desde"
                            name="fecha_desde"
                            type="date"
                            value="{{ $fechaDesde }}"
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                    </div>

                    <div>
                        <label
                            for="fecha_hasta"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Hasta
                        </label>

                        <input
                            id="fecha_hasta"
                            name="fecha_hasta"
                            type="date"
                            value="{{ $fechaHasta }}"
                            class="w-full rounded-2xl border-gray-300
                                   focus:border-emerald-600
                                   focus:ring-emerald-600"
                        >
                    </div>

                    <div class="flex items-end gap-3">
                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center
                                   gap-2 rounded-2xl bg-emerald-950 px-5 py-3
                                   text-sm font-extrabold text-white
                                   transition hover:bg-emerald-900"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>

                            Filtrar
                        </button>

                        <a
                            href="{{ route('admin.auditorias.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-2xl border border-gray-300
                                   px-4 py-3 text-sm font-extrabold
                                   text-gray-700 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- TABLA --}}
            <div
                class="mt-6 overflow-hidden rounded-3xl
                       border border-gray-200 bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-emerald-950">
                            <tr>
                                <th
                                    class="px-5 py-4 text-left text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Fecha
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Usuario
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Módulo
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Acción
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Descripción
                                </th>

                                <th
                                    class="px-5 py-4 text-right text-xs
                                           font-extrabold uppercase
                                           tracking-wider text-emerald-100"
                                >
                                    Detalle
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($auditorias as $auditoria)
                                @php
                                    $claseAccion = match ($auditoria->accion) {
                                        'crear' => 'bg-blue-100 text-blue-800',
                                        'actualizar' => 'bg-amber-100 text-amber-800',
                                        'activar' => 'bg-emerald-100 text-emerald-800',
                                        'desactivar' => 'bg-gray-200 text-gray-700',
                                        'eliminar' => 'bg-red-100 text-red-800',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp

                                <tr class="transition hover:bg-emerald-50/40">
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <p class="text-sm font-extrabold text-gray-900">
                                            {{ $auditoria->created_at?->format('d/m/Y') }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $auditoria->created_at?->format('h:i:s A') }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($auditoria->usuario)
                                            <p class="text-sm font-extrabold text-gray-900">
                                                {{ $auditoria->usuario->name }}
                                                {{ $auditoria->usuario->apellidos }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                DNI: {{ $auditoria->usuario->dni }}
                                            </p>
                                        @else
                                            <span class="text-sm font-semibold text-gray-400">
                                                Usuario eliminado o sistema
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <span
                                            class="inline-flex rounded-full
                                                   bg-emerald-100 px-3 py-1
                                                   text-xs font-extrabold
                                                   text-emerald-800"
                                        >
                                            {{ $auditoria->modulo }}
                                        </span>

                                        @if ($auditoria->tabla)
                                            <p class="mt-2 text-xs text-gray-500">
                                                {{ $auditoria->tabla }}
                                                @if ($auditoria->registro_id)
                                                    #{{ $auditoria->registro_id }}
                                                @endif
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <span
                                            class="inline-flex rounded-full
                                                   px-3 py-1 text-xs
                                                   font-extrabold {{ $claseAccion }}"
                                        >
                                            {{ ucfirst($auditoria->accion) }}
                                        </span>
                                    </td>

                                    <td class="max-w-md px-5 py-4">
                                        <p class="text-sm leading-6 text-gray-700">
                                            {{ $auditoria->descripcion ?: 'Sin descripción.' }}
                                        </p>

                                        @if ($auditoria->ip)
                                            <p class="mt-2 text-xs font-semibold text-gray-400">
                                                IP: {{ $auditoria->ip }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        <a
                                            href="{{ route(
                                                'admin.auditorias.mostrar',
                                                $auditoria
                                            ) }}"
                                            class="inline-flex items-center gap-2
                                                   rounded-xl border
                                                   border-emerald-200
                                                   px-3 py-2 text-xs
                                                   font-extrabold
                                                   text-emerald-800 transition
                                                   hover:bg-emerald-50"
                                        >
                                            Ver detalle

                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="m9 18 6-6-6-6" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex h-16 w-16
                                                   items-center justify-center
                                                   rounded-2xl bg-gray-100
                                                   text-gray-400"
                                        >
                                            <svg
                                                class="h-8 w-8"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z" />
                                                <path d="M9 12h6" />
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 text-lg font-extrabold text-gray-800">
                                            No se encontraron registros
                                        </h3>

                                        <p class="mt-2 text-sm text-gray-500">
                                            Modifica los filtros o realiza una nueva acción administrativa.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($auditorias->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4">
                        {{ $auditorias->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>