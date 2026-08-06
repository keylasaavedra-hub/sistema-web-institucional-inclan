<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Detalle de auditoría
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Información completa de la acción administrativa registrada.
                </p>
            </div>

            <a
                href="{{ route('admin.auditorias.index') }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-2xl border border-gray-300 bg-white
                       px-5 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6" />
                </svg>

                Volver al historial
            </a>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @php
                $claseAccion = match ($auditoria->accion) {
                    'crear' => 'bg-blue-100 text-blue-800',
                    'actualizar' => 'bg-amber-100 text-amber-800',
                    'activar' => 'bg-emerald-100 text-emerald-800',
                    'desactivar' => 'bg-gray-200 text-gray-700',
                    'eliminar' => 'bg-red-100 text-red-800',
                    default => 'bg-slate-100 text-slate-700',
                };

                $formatearValor = function ($valor) {
                    if (is_bool($valor)) {
                        return $valor ? 'Sí' : 'No';
                    }

                    if ($valor === null) {
                        return 'Sin valor';
                    }

                    if (is_array($valor)) {
                        return json_encode(
                            $valor,
                            JSON_PRETTY_PRINT
                            | JSON_UNESCAPED_UNICODE
                            | JSON_UNESCAPED_SLASHES
                        );
                    }

                    return (string) $valor;
                };
            @endphp

            {{-- INFORMACIÓN GENERAL --}}
            <div
                class="overflow-hidden rounded-3xl
                       border border-gray-200 bg-white shadow-sm"
            >
                <div
                    class="border-b border-gray-200
                           bg-emerald-950 px-6 py-5"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-bold text-emerald-200">
                                Registro #{{ $auditoria->id }}
                            </p>

                            <h3 class="mt-1 text-xl font-extrabold text-white">
                                {{ $auditoria->modulo }}
                            </h3>
                        </div>

                        <span
                            class="inline-flex w-fit rounded-full
                                   px-4 py-2 text-xs font-extrabold
                                   {{ $claseAccion }}"
                        >
                            {{ ucfirst($auditoria->accion) }}
                        </span>
                    </div>
                </div>

                <div class="grid gap-6 p-6 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Fecha y hora
                        </p>

                        <p class="mt-2 text-sm font-extrabold text-gray-900">
                            {{ $auditoria->created_at?->format('d/m/Y') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $auditoria->created_at?->format('h:i:s A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Usuario responsable
                        </p>

                        @if ($auditoria->usuario)
                            <p class="mt-2 text-sm font-extrabold text-gray-900">
                                {{ $auditoria->usuario->name }}
                                {{ $auditoria->usuario->apellidos }}
                            </p>

                            <p class="mt-1 text-sm text-gray-600">
                                DNI: {{ $auditoria->usuario->dni }}
                            </p>

                            <p class="mt-1 break-all text-sm text-gray-600">
                                {{ $auditoria->usuario->email }}
                            </p>
                        @else
                            <p class="mt-2 text-sm font-semibold text-gray-500">
                                Usuario eliminado o acción del sistema
                            </p>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Registro afectado
                        </p>

                        <p class="mt-2 text-sm font-extrabold text-gray-900">
                            {{ $auditoria->tabla ?: 'No especificado' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-600">
                            ID:
                            {{ $auditoria->registro_id ?: 'No especificado' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Dirección IP
                        </p>

                        <p class="mt-2 text-sm font-extrabold text-gray-900">
                            {{ $auditoria->ip ?: 'No registrada' }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-6 py-5">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                        Descripción
                    </p>

                    <p class="mt-2 text-sm leading-7 text-gray-700">
                        {{ $auditoria->descripcion ?: 'No se registró una descripción.' }}
                    </p>
                </div>
            </div>

            {{-- VALORES ANTERIORES Y NUEVOS --}}
            <div class="mt-6 grid gap-6 xl:grid-cols-2">
                <div
                    class="overflow-hidden rounded-3xl
                           border border-gray-200 bg-white shadow-sm"
                >
                    <div class="border-b border-gray-200 bg-red-50 px-6 py-5">
                        <h3 class="text-lg font-extrabold text-red-900">
                            Valores anteriores
                        </h3>

                        <p class="mt-1 text-sm text-red-700">
                            Información almacenada antes de realizar la acción.
                        </p>
                    </div>

                    <div class="p-6">
                        @if (! empty($auditoria->valores_anteriores))
                            <div class="space-y-4">
                                @foreach ($auditoria->valores_anteriores as $campo => $valor)
                                    <div
                                        class="rounded-2xl border
                                               border-gray-200 bg-gray-50 p-4"
                                    >
                                        <p
                                            class="text-xs font-extrabold
                                                   uppercase tracking-wider
                                                   text-gray-500"
                                        >
                                            {{ str($campo)->replace('_', ' ')->title() }}
                                        </p>

                                        @if (is_array($valor))
                                            <pre
                                                class="mt-3 max-h-96 overflow-auto
                                                       whitespace-pre-wrap break-words
                                                       rounded-xl bg-slate-950 p-4
                                                       text-xs leading-6 text-slate-100"
                                            >{{ $formatearValor($valor) }}</pre>
                                        @else
                                            <p
                                                class="mt-2 break-words
                                                       text-sm font-semibold
                                                       text-gray-800"
                                            >
                                                {{ $formatearValor($valor) }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <p class="text-sm font-semibold text-gray-500">
                                    Esta acción no tiene valores anteriores.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div
                    class="overflow-hidden rounded-3xl
                           border border-gray-200 bg-white shadow-sm"
                >
                    <div class="border-b border-gray-200 bg-emerald-50 px-6 py-5">
                        <h3 class="text-lg font-extrabold text-emerald-900">
                            Valores nuevos
                        </h3>

                        <p class="mt-1 text-sm text-emerald-700">
                            Información almacenada después de realizar la acción.
                        </p>
                    </div>

                    <div class="p-6">
                        @if (! empty($auditoria->valores_nuevos))
                            <div class="space-y-4">
                                @foreach ($auditoria->valores_nuevos as $campo => $valor)
                                    <div
                                        class="rounded-2xl border
                                               border-gray-200 bg-gray-50 p-4"
                                    >
                                        <p
                                            class="text-xs font-extrabold
                                                   uppercase tracking-wider
                                                   text-gray-500"
                                        >
                                            {{ str($campo)->replace('_', ' ')->title() }}
                                        </p>

                                        @if (is_array($valor))
                                            <pre
                                                class="mt-3 max-h-96 overflow-auto
                                                       whitespace-pre-wrap break-words
                                                       rounded-xl bg-slate-950 p-4
                                                       text-xs leading-6 text-slate-100"
                                            >{{ $formatearValor($valor) }}</pre>
                                        @else
                                            <p
                                                class="mt-2 break-words
                                                       text-sm font-semibold
                                                       text-gray-800"
                                            >
                                                {{ $formatearValor($valor) }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <p class="text-sm font-semibold text-gray-500">
                                    Esta acción no tiene valores nuevos.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- INFORMACIÓN TÉCNICA --}}
            <div
                class="mt-6 rounded-3xl border
                       border-gray-200 bg-white p-6 shadow-sm"
            >
                <h3 class="text-lg font-extrabold text-emerald-950">
                    Información técnica
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Dirección IP
                        </p>

                        <p class="mt-2 break-all text-sm font-semibold text-gray-700">
                            {{ $auditoria->ip ?: 'No registrada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Navegador y dispositivo
                        </p>

                        <p class="mt-2 break-words text-sm leading-6 text-gray-700">
                            {{ $auditoria->user_agent ?: 'No registrado' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>