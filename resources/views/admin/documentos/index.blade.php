<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Gestión documental
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Documentos y descargas
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra archivos públicos, internos y su historial de versiones.
                </p>
            </div>

            <a
                href="{{ route('admin.documentos.crear') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-900"
            >
                <svg
                    class="h-5 w-5 text-amber-300"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 5v14M5 12h14"/>
                </svg>

                Nuevo documento
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm">
                <form
                    action="{{ route('admin.documentos.index') }}"
                    method="GET"
                    class="grid gap-4 xl:grid-cols-[1fr_190px_190px_160px_160px_auto]"
                >
                    <div>
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar documento
                        </label>

                        <input
                            type="search"
                            id="buscar"
                            name="buscar"
                            value="{{ $buscar }}"
                            placeholder="Título, descripción, archivo o versión..."
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                    </div>

                    <div>
                        <label
                            for="categoria_documento_id"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            id="categoria_documento_id"
                            name="categoria_documento_id"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id }}"
                                    @selected((int) $categoriaId === (int) $categoria->id)
                                >
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="area_id"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Área
                        </label>

                        <select
                            id="area_id"
                            name="area_id"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>

                            @foreach ($areas as $area)
                                <option
                                    value="{{ $area->id }}"
                                    @selected((int) $areaId === (int) $area->id)
                                >
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="estado"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Estado
                        </label>

                        <select
                            id="estado"
                            name="estado"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todos</option>
                            <option value="activo" @selected($estado === 'activo')>
                                Activos
                            </option>
                            <option value="inactivo" @selected($estado === 'inactivo')>
                                Inactivos
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="visibilidad"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Visibilidad
                        </label>

                        <select
                            id="visibilidad"
                            name="visibilidad"
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"
                        >
                            <option value="">Todas</option>
                            <option value="publico" @selected($visibilidad === 'publico')>
                                Públicos
                            </option>
                            <option value="interno" @selected($visibilidad === 'interno')>
                                Internos
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="inline-flex h-12 flex-1 items-center justify-center rounded-xl bg-emerald-950 px-5 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('admin.documentos.index') }}"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </section>

            <div class="mt-8 overflow-hidden rounded-[28px] border border-gray-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-emerald-950">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Documento
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Categoría / área
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Archivo
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Publicación
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Estado
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-100">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($documentos as $documento)
                                @php
                                    $archivoExiste = $documento->archivo
                                        && \Illuminate\Support\Facades\Storage::disk('public')->exists($documento->archivo);

                                    $tamano = $documento->tamano_bytes
                                        ? number_format($documento->tamano_bytes / 1024 / 1024, 2) . ' MB'
                                        : 'No registrado';
                                @endphp

                                <tr class="align-top transition hover:bg-gray-50">
                                    <td class="px-5 py-5">
                                        <div class="flex gap-4">
                                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-800">
                                                <svg
                                                    class="h-6 w-6"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path d="M6 3h9l3 3v15H6z"/>
                                                    <path d="M14 3v4h4"/>
                                                    <path d="M9 12h6M9 16h4"/>
                                                </svg>
                                            </span>

                                            <div class="min-w-0">
                                                <p class="font-extrabold text-emerald-950">
                                                    {{ $documento->titulo }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    Versión {{ $documento->version }}
                                                    · {{ $documento->versiones_count }} registro(s) en historial
                                                </p>

                                                @if ($documento->descripcion)
                                                    <p class="mt-2 max-w-md text-sm leading-6 text-gray-600">
                                                        {{ \Illuminate\Support\Str::limit($documento->descripcion, 100) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-5">
                                        <p class="text-sm font-extrabold text-gray-800">
                                            {{ $documento->categoria?->nombre ?? 'Sin categoría' }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $documento->area?->nombre ?? 'Sin área asignada' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-5">
                                        <p class="max-w-[220px] truncate text-sm font-bold text-gray-700">
                                            {{ $documento->nombre_original }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $tamano }}
                                        </p>

                                        @if ($archivoExiste)
                                            <span class="mt-2 inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-extrabold text-emerald-700">
                                                Archivo disponible
                                            </span>
                                        @else
                                            <span class="mt-2 inline-flex rounded-full border border-red-200 bg-red-50 px-3 py-1 text-[11px] font-extrabold text-red-700">
                                                Archivo no encontrado
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-5">
                                        <p class="text-sm font-bold text-gray-800">
                                            {{ $documento->fecha_publicacion?->format('d/m/Y') ?? 'Sin fecha' }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $documento->usuario
                                                ? trim($documento->usuario->name . ' ' . ($documento->usuario->apellidos ?? ''))
                                                : 'Usuario no disponible' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="flex flex-col items-start gap-2">
                                            @if ($documento->estado === 'activo')
                                                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-extrabold text-emerald-700">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-[11px] font-extrabold text-gray-600">
                                                    Inactivo
                                                </span>
                                            @endif

                                            @if ($documento->es_publico)
                                                <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-[11px] font-extrabold text-amber-700">
                                                    Público
                                                </span>
                                            @else
                                                <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-extrabold text-blue-700">
                                                    Interno
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="flex justify-end gap-2">
                                            @if ($archivoExiste)
                                                <a
                                                    href="{{ route('admin.documentos.descargar', $documento) }}"
                                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 transition hover:bg-emerald-100"
                                                    title="Descargar archivo"
                                                >
                                                    <svg
                                                        class="h-5 w-5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M12 3v12"/>
                                                        <path d="m7 10 5 5 5-5"/>
                                                        <path d="M5 21h14"/>
                                                    </svg>
                                                </a>
                                            @endif

                                            <a
                                                href="{{ route('admin.documentos.editar', $documento) }}"
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-amber-200 bg-amber-50 text-amber-700 transition hover:bg-amber-100"
                                                title="Editar documento"
                                            >
                                                <svg
                                                    class="h-5 w-5"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M12 20h9"/>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/>
                                                </svg>
                                            </a>

                                            <form
                                                action="{{ route('admin.documentos.eliminar', $documento) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este documento y todas sus versiones?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-red-200 bg-red-50 text-red-700 transition hover:bg-red-100"
                                                    title="Eliminar documento"
                                                >
                                                    <svg
                                                        class="h-5 w-5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M4 7h16"/>
                                                        <path d="M10 11v6M14 11v6"/>
                                                        <path d="M6 7l1 14h10l1-14"/>
                                                        <path d="M9 7V4h6v3"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-950 text-amber-300">
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

                                        <h3 class="mt-6 text-2xl font-extrabold text-emerald-950">
                                            No se encontraron documentos
                                        </h3>

                                        <p class="mt-2 text-sm text-gray-600">
                                            Registra un documento o cambia los filtros aplicados.
                                        </p>

                                        <a
                                            href="{{ route('admin.documentos.crear') }}"
                                            class="mt-6 inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white"
                                        >
                                            Registrar documento
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($documentos->hasPages())
                <div class="mt-8">
                    {{ $documentos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>