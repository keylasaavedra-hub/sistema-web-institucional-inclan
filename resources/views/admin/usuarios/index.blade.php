<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad y acceso
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Gestión de usuarios
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las cuentas, roles y estados de acceso al sistema.
                </p>
            </div>

            <a
                href="{{ route('admin.usuarios.crear') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-5 py-3 text-sm font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-900">
                <svg
                    class="h-5 w-5 text-amber-300"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>

                Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">

                {{-- Mensajes --}}
                @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
                @endif

                {{-- Resumen --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">
                            Usuarios mostrados
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $usuarios->total() }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                        <p class="text-sm font-medium text-emerald-700">
                            Activos en esta página
                        </p>

                        <p class="mt-2 text-3xl font-bold text-emerald-800">
                            {{ $usuarios->getCollection()->where('estado', true)->count() }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                        <p class="text-sm font-medium text-amber-700">
                            Inactivos en esta página
                        </p>

                        <p class="mt-2 text-3xl font-bold text-amber-800">
                            {{ $usuarios->getCollection()->where('estado', false)->count() }}
                        </p>
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <form
                        method="GET"
                        action="{{ route('admin.usuarios.index') }}"
                        class="grid gap-4 lg:grid-cols-4">
                        <div class="lg:col-span-2">
                            <label
                                for="buscar"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Buscar usuario
                            </label>

                            <input
                                id="buscar"
                                name="buscar"
                                type="text"
                                value="{{ $buscar }}"
                                placeholder="DNI, nombres, apellidos o correo"
                                class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>

                        <div>
                            <label
                                for="rol_id"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Rol
                            </label>

                            <select
                                id="rol_id"
                                name="rol_id"
                                class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                                <option value="">Todos los roles</option>

                                @foreach ($roles as $rol)
                                <option
                                    value="{{ $rol->id }}"
                                    @selected((int) $rolId===$rol->id)
                                    >
                                    {{ $rol->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label
                                for="estado"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Estado
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                                <option value="">Todos</option>
                                <option value="activo" @selected($estado==='activo' )>
                                    Activos
                                </option>
                                <option value="inactivo" @selected($estado==='inactivo' )>
                                    Inactivos
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-3 lg:col-span-4">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Aplicar filtros
                            </button>

                            <a
                                href="{{ route('admin.usuarios.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Tabla --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Usuario
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        DNI y contacto
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Rol
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($usuarios as $usuario)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-800">
                                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                                {{ strtoupper(substr($usuario->apellidos ?? '', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-900">
                                                    {{ $usuario->name }}
                                                    {{ $usuario->apellidos }}
                                                </p>

                                                @if ($usuario->is(auth()->user()))
                                                <span class="text-xs font-semibold text-emerald-700">
                                                    Tu cuenta
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-slate-800">
                                            DNI: {{ $usuario->dni }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $usuario->email }}
                                        </p>

                                        @if ($usuario->telefono)
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $usuario->telefono }}
                                        </p>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                            {{ $usuario->rol?->nombre ?? 'Sin rol' }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($usuario->estado)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                            <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                            Activo
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                            Inactivo
                                        </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.usuarios.editar', $usuario) }}"
                                                class="inline-flex rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-emerald-500 hover:text-emerald-700">
                                                Editar
                                            </a>

                                            @if (! $usuario->is(auth()->user()))
                                            <form
                                                method="POST"
                                                action="{{ route('admin.usuarios.estado', $usuario) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="inline-flex rounded-lg border px-3 py-2 text-xs font-semibold transition
                                                    {{ $usuario->estado
                                                        ? 'border-amber-300 text-amber-700 hover:bg-amber-50'
                                                        : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}">
                                                    {{ $usuario->estado ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.usuarios.eliminar', $usuario) }}"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex rounded-lg border border-red-300 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-50">
                                                    Eliminar
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="px-6 py-14 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                            <svg
                                                class="h-7 w-7 text-slate-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3m6 6v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m10-12a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 11-6 0" />
                                            </svg>
                                        </div>

                                        <p class="mt-4 font-semibold text-slate-800">
                                            No se encontraron usuarios
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Modifica los filtros o registra una nueva cuenta.
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($usuarios->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $usuarios->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>