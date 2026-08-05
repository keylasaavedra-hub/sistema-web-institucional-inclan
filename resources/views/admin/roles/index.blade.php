<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad y acceso
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Roles y permisos
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Configura las funciones disponibles para cada tipo de usuario.
                </p>
            </div>

            <a
                href="{{ route('admin.roles.crear') }}"
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

                Nuevo rol
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">
                        Total de roles
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-emerald-950">
                        {{ $roles->count() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-emerald-700">
                        Roles activos
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-emerald-800">
                        {{ $roles->where('estado', true)->count() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-amber-700">
                        Roles inactivos
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-amber-800">
                        {{ $roles->where('estado', false)->count() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">
                        Permisos registrados
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-slate-900">
                        {{ \App\Models\Permiso::where('estado', true)->count() }}
                    </p>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                    <h3 class="text-lg font-extrabold text-emerald-950">
                        Roles institucionales
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Cada rol agrupa permisos y puede estar asignado a uno o más usuarios.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                    Rol
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                    Usuarios
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                    Permisos
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                    Estado
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($roles as $rol)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800">
                                                <svg
                                                    class="h-6 w-6"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                                                    <path d="M4 21v-2a6 6 0 016-6h4a6 6 0 016 6v2"/>
                                                </svg>
                                            </div>

                                            <div>
                                                <p class="font-extrabold text-slate-900">
                                                    {{ $rol->nombre }}
                                                </p>

                                                <p class="mt-1 max-w-md text-sm text-slate-500">
                                                    {{ $rol->descripcion ?: 'Sin descripción registrada.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                            {{ $rol->usuarios_count }}
                                            {{ $rol->usuarios_count === 1 ? 'usuario' : 'usuarios' }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5">
                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                            {{ $rol->permisos_count }}
                                            {{ $rol->permisos_count === 1 ? 'permiso' : 'permisos' }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5">
                                        @if ($rol->estado)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                                <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.roles.editar', $rol) }}"
                                                class="inline-flex rounded-lg border border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-emerald-500 hover:text-emerald-700"
                                            >
                                                Editar permisos
                                            </a>

                                            @if ($rol->nombre !== 'Administrador')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.roles.estado', $rol) }}"
                                                    onsubmit="return confirm('¿Deseas cambiar el estado de este rol?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex rounded-lg border px-3 py-2 text-xs font-bold transition
                                                            {{ $rol->estado
                                                                ? 'border-amber-300 text-amber-700 hover:bg-amber-50'
                                                                : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}"
                                                    >
                                                        {{ $rol->estado ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.roles.eliminar', $rol) }}"
                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este rol?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex rounded-lg border border-red-300 px-3 py-2 text-xs font-bold text-red-700 transition hover:bg-red-50"
                                                    >
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700">
                                                    Rol protegido
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="px-6 py-14 text-center"
                                    >
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                            <svg
                                                class="h-7 w-7 text-slate-400"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                                                <path d="M4 21v-2a6 6 0 016-6h4a6 6 0 016 6v2"/>
                                            </svg>
                                        </div>

                                        <p class="mt-4 font-bold text-slate-800">
                                            No hay roles registrados
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Registra un rol para comenzar a asignar permisos.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>