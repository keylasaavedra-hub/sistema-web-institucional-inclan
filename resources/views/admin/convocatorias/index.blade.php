<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Gestión institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Convocatorias
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las convocatorias publicadas en el portal institucional
                </p>
            </div>

            <a
                href="{{ route('admin.convocatorias.create') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl bg-emerald-950 px-5 py-3
                       font-extrabold text-white transition
                       hover:bg-emerald-900"
            >
                <span class="text-xl leading-none">+</span>
                Nueva convocatoria
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

            <section
                class="rounded-[26px] border border-amber-200
                       bg-white p-6
                       shadow-[0_18px_50px_rgba(6,78,59,0.08)]"
            >
                <form
                    method="GET"
                    action="{{ route('admin.convocatorias.index') }}"
                    class="grid gap-5 lg:grid-cols-[1fr_220px_220px_auto]"
                >
                    <div>
                        <label for="buscar" class="text-sm font-extrabold text-emerald-950">
                            Buscar convocatoria
                        </label>

                        <input
                            id="buscar"
                            name="buscar"
                            type="text"
                            value="{{ request('buscar') }}"
                            placeholder="Código, título, descripción o perfil..."
                            class="mt-2 w-full rounded-xl border-gray-300 px-4 py-3
                                   shadow-sm focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <div>
                        <label for="tipo" class="text-sm font-extrabold text-emerald-950">
                            Tipo
                        </label>

                        <select
                            id="tipo"
                            name="tipo"
                            class="mt-2 w-full rounded-xl border-gray-300 px-4 py-3
                                   shadow-sm focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                            <option value="">Todos</option>
                            <option value="practicas" @selected(request('tipo') === 'practicas')>Prácticas</option>
                            <option value="laboral" @selected(request('tipo') === 'laboral')>Laboral</option>
                            <option value="cas" @selected(request('tipo') === 'cas')>CAS</option>
                            <option value="servicios" @selected(request('tipo') === 'servicios')>Servicios</option>
                            <option value="voluntariado" @selected(request('tipo') === 'voluntariado')>Voluntariado</option>
                            <option value="otro" @selected(request('tipo') === 'otro')>Otro</option>
                        </select>
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
                            <option value="borrador" @selected(request('estado') === 'borrador')>Borrador</option>
                            <option value="publicada" @selected(request('estado') === 'publicada')>Publicada</option>
                            <option value="cerrada" @selected(request('estado') === 'cerrada')>Cerrada</option>
                            <option value="anulada" @selected(request('estado') === 'anulada')>Anulada</option>
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

                        @if (request()->filled('buscar') || request()->filled('tipo') || request()->filled('estado'))
                            <a
                                href="{{ route('admin.convocatorias.index') }}"
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

            <section
                class="mt-8 overflow-hidden rounded-[26px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @if ($convocatorias->count())

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-950 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Convocatoria
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Área
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Vacantes
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-extrabold uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($convocatorias as $convocatoria)

                                    @php
                                        $estados = [
                                            'borrador' => 'border-gray-200 bg-gray-100 text-gray-700',
                                            'publicada' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'cerrada' => 'border-amber-200 bg-amber-50 text-amber-700',
                                            'anulada' => 'border-red-200 bg-red-50 text-red-700',
                                        ];
                                    @endphp

                                    <tr class="transition hover:bg-emerald-50/40">

                                        <td class="max-w-md px-6 py-5">
                                            <div class="flex items-start gap-3">
                                                @if ($convocatoria->destacada)
                                                    <span
                                                        class="mt-1 inline-flex shrink-0 rounded-full
                                                               bg-amber-100 px-2 py-1 text-[10px]
                                                               font-extrabold uppercase text-amber-800"
                                                    >
                                                        Destacada
                                                    </span>
                                                @endif

                                                <div>
                                                    <p class="font-extrabold text-emerald-950">
                                                        {{ $convocatoria->titulo }}
                                                    </p>

                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $convocatoria->codigo }}
                                                    </p>

                                                    <p class="mt-1 text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        {{ ucfirst($convocatoria->tipo) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-5">
                                            <p class="font-bold text-gray-800">
                                                {{ $convocatoria->area?->nombre ?: 'Sin área asignada' }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $convocatoria->cargo?->nombre ?: 'Sin cargo específico' }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-bold text-gray-800">
                                                {{ $convocatoria->fecha_inicio->format('d/m/Y') }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Hasta {{ $convocatoria->fecha_cierre->format('d/m/Y') }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <span
                                                class="inline-flex h-10 min-w-10 items-center justify-center
                                                       rounded-xl bg-blue-50 px-3
                                                       font-extrabold text-blue-700"
                                            >
                                                {{ $convocatoria->vacantes }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <span
                                                class="inline-flex rounded-full border px-3 py-1
                                                       text-xs font-extrabold
                                                       {{ $estados[$convocatoria->estado] ?? 'border-gray-200 bg-gray-50 text-gray-700' }}"
                                            >
                                                {{ ucfirst($convocatoria->estado) }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right">
                                            <div class="flex justify-end gap-2">

                                                <a
                                                    href="{{ route('admin.convocatorias.edit', $convocatoria) }}"
                                                    class="inline-flex items-center justify-center rounded-xl
                                                           border border-emerald-200 bg-emerald-50
                                                           px-4 py-2 text-sm font-extrabold
                                                           text-emerald-800 transition hover:bg-emerald-100"
                                                >
                                                    Editar
                                                </a>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.convocatorias.destroy', $convocatoria) }}"
                                                    onsubmit="return confirm('¿Deseas eliminar esta convocatoria? Esta acción no se puede deshacer.');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-xl
                                                               border border-red-200 bg-red-50
                                                               px-4 py-2 text-sm font-extrabold
                                                               text-red-700 transition hover:bg-red-100"
                                                    >
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-100 px-6 py-5">
                        {{ $convocatorias->links() }}
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
                                <path d="M4 5h16v14H4z"/>
                                <path d="M8 9h8M8 13h5"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-xl font-extrabold text-emerald-950">
                            No hay convocatorias registradas
                        </h3>

                        <p class="mt-2 text-sm text-gray-600">
                            Registra la primera convocatoria institucional.
                        </p>

                        <a
                            href="{{ route('admin.convocatorias.create') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl
                                   bg-emerald-950 px-5 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900"
                        >
                            Crear convocatoria
                        </a>
                    </div>

                @endif
            </section>
        </div>
    </div>

</x-app-layout>