<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Configuración
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Categorías de publicaciones
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las categorías usadas en noticias, anuncios, comunicados y eventos.
                </p>
            </div>

            <a
                href="{{ route('admin.publicaciones.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-extrabold text-gray-700 shadow-sm transition hover:bg-gray-50">
                Volver a publicaciones
            </a>
        </div>
    </x-slot>

    <div
        class="py-8"
        x-data="{
            mostrarModalCrear: false,
            mostrarModalEditar: false,
            categoriaEditar: {
                id: null,
                nombre: '',
                descripcion: '',
                estado: true
            },

            abrirEdicion(categoria) {
                this.categoriaEditar = {
                    id: categoria.id,
                    nombre: categoria.nombre ?? '',
                    descripcion: categoria.descripcion ?? '',
                    estado: Boolean(categoria.estado)
                };

                this.mostrarModalEditar = true;
            }
        }">
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

            @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
                <p class="text-sm font-extrabold text-red-700">
                    Revisa los siguientes campos:
                </p>

                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <section class="rounded-[28px] border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold text-emerald-950">
                            Categorías registradas
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Hay {{ $categorias->count() }} categorías disponibles.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="mostrarModalCrear = true"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-900">
                        <svg
                            class="h-5 w-5 text-amber-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>

                        Nueva categoría
                    </button>
                </div>

                <div class="mt-8 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-gray-500">
                                    Categoría
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-gray-500">
                                    Descripción
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-gray-500">
                                    Publicaciones
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-gray-500">
                                    Estado
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-extrabold uppercase tracking-wider text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($categorias as $categoria)
                            <tr class="transition hover:bg-amber-50/30">
                                <td class="px-5 py-5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-950 text-sm font-extrabold text-amber-300">
                                            {{ strtoupper(substr($categoria->nombre, 0, 1)) }}
                                        </span>

                                        <div>
                                            <p class="font-extrabold text-emerald-950">
                                                {{ $categoria->nombre }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                ID: {{ $categoria->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="max-w-sm px-5 py-5 text-sm leading-6 text-gray-600">
                                    {{ $categoria->descripcion ?: 'Sin descripción.' }}
                                </td>

                                <td class="px-5 py-5 text-center">
                                    <span class="inline-flex min-w-10 items-center justify-center rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-extrabold text-emerald-700">
                                        {{ $categoria->publicaciones_count }}
                                    </span>
                                </td>

                                <td class="px-5 py-5 text-center">
                                    @if ($categoria->estado)
                                    <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700">
                                        Activa
                                    </span>
                                    @else
                                    <span class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-xs font-extrabold text-gray-600">
                                        Inactiva
                                    </span>
                                    @endif
                                </td>

                                <td class="px-5 py-5">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        @php
                                        $datosCategoria = [
                                        'id' => $categoria->id,
                                        'nombre' => $categoria->nombre,
                                        'descripcion' => $categoria->descripcion ?? '',
                                        'estado' => (bool) $categoria->estado,
                                        ];
                                        @endphp

                                        <button
                                            type="button"
                                            @click="abrirEdicion({{ Illuminate\Support\Js::from($datosCategoria) }})"
                                            class="inline-flex items-center justify-center rounded-xl border border-amber-300 bg-amber-50 px-4 py-2.5 text-xs font-extrabold text-emerald-800 transition hover:bg-amber-100">
                                            Editar
                                        </button>

                                        <form
                                            action="{{ route('admin.categorias-publicacion.estado', $categoria) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-xl border px-4 py-2.5 text-xs font-extrabold transition
                                                        {{ $categoria->estado
                                                            ? 'border-gray-200 bg-gray-100 text-gray-700 hover:bg-gray-200'
                                                            : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                                {{ $categoria->estado ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.categorias-publicacion.eliminar', $categoria) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs font-extrabold text-red-700 transition hover:bg-red-100">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center">
                                    <h3 class="text-xl font-extrabold text-emerald-950">
                                        No hay categorías registradas
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Registra la primera categoría para organizar las publicaciones.
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        {{-- MODAL CREAR --}}
        <div
            x-cloak
            x-show="mostrarModalCrear"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-emerald-950/70 p-4"
            @keydown.escape.window="mostrarModalCrear = false">
            <div
                x-show="mostrarModalCrear"
                x-transition
                @click.outside="mostrarModalCrear = false"
                class="w-full max-w-xl rounded-[28px] bg-white p-6 shadow-2xl sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Nueva categoría
                        </p>

                        <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                            Registrar categoría
                        </h3>
                    </div>

                    <button
                        type="button"
                        @click="mostrarModalCrear = false"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200">
                        ×
                    </button>
                </div>

                <form
                    action="{{ route('admin.categorias-publicacion.guardar') }}"
                    method="POST"
                    class="mt-7 space-y-5">
                    @csrf

                    <div>
                        <label
                            for="nombre"
                            class="mb-2 block text-sm font-bold text-gray-700">
                            Nombre
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            maxlength="100"
                            required
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>

                    <div>
                        <label
                            for="descripcion"
                            class="mb-2 block text-sm font-bold text-gray-700">
                            Descripción
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="4"
                            maxlength="200"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">{{ old('descripcion') }}</textarea>
                    </div>

                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                        <input type="hidden" name="estado" value="0">

                        <input
                            type="checkbox"
                            name="estado"
                            value="1"
                            checked
                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400">

                        <span>
                            <strong class="block text-sm text-emerald-950">
                                Categoría activa
                            </strong>

                            <small class="text-gray-600">
                                Podrá seleccionarse al crear publicaciones.
                            </small>
                        </span>
                    </label>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            @click="mostrarModalCrear = false"
                            class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-emerald-900">
                            Guardar categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDITAR --}}
        <div
            x-cloak
            x-show="mostrarModalEditar"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-emerald-950/70 p-4"
            @keydown.escape.window="mostrarModalEditar = false">
            <div
                x-show="mostrarModalEditar"
                x-transition
                @click.outside="mostrarModalEditar = false"
                class="w-full max-w-xl rounded-[28px] bg-white p-6 shadow-2xl sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                            Modificación
                        </p>

                        <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                            Editar categoría
                        </h3>
                    </div>

                    <button
                        type="button"
                        @click="mostrarModalEditar = false"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200">
                        ×
                    </button>
                </div>

                <form
                    :action="'{{ url('/admin/categorias-publicacion') }}/' + categoriaEditar.id"
                    method="POST"
                    class="mt-7 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">
                            Nombre
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            x-model="categoriaEditar.nombre"
                            maxlength="100"
                            required
                            class="h-12 w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            rows="4"
                            maxlength="200"
                            x-model="categoriaEditar.descripcion"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-400 focus:ring-amber-400"></textarea>
                    </div>

                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                        <input type="hidden" name="estado" value="0">

                        <input
                            type="checkbox"
                            name="estado"
                            value="1"
                            x-model="categoriaEditar.estado"
                            class="h-5 w-5 rounded border-gray-300 text-emerald-700 focus:ring-amber-400">

                        <span>
                            <strong class="block text-sm text-emerald-950">
                                Categoría activa
                            </strong>

                            <small class="text-gray-600">
                                Estará disponible para nuevas publicaciones.
                            </small>
                        </span>
                    </label>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            @click="mostrarModalEditar = false"
                            class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-emerald-900">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>