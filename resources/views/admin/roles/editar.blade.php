<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad y acceso
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar rol
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza la información del rol y los permisos asignados.
                </p>
            </div>

            <a
                href="{{ route('admin.roles.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
            >
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.roles.actualizar', $rol) }}"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">
                        <p class="font-bold text-red-800">
                            Revisa los datos ingresados.
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-extrabold text-emerald-950">
                                    Información del rol
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Modifica el nombre y la descripción del rol institucional.
                                </p>
                            </div>

                            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-950 text-white">
                                    <svg
                                        class="h-5 w-5"
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
                                    <p class="text-sm font-extrabold text-emerald-950">
                                        {{ $rol->nombre }}
                                    </p>

                                    <p class="text-xs font-semibold text-emerald-700">
                                        {{ $rol->permisos->count() }}
                                        {{ $rol->permisos->count() === 1 ? 'permiso asignado' : 'permisos asignados' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 p-6 md:grid-cols-2">
                        <div>
                            <label
                                for="nombre"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Nombre del rol *
                            </label>

                            <input
                                id="nombre"
                                name="nombre"
                                type="text"
                                maxlength="100"
                                value="{{ old('nombre', $rol->nombre) }}"
                                required
                                @readonly($rol->nombre === 'Administrador')
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600 read-only:cursor-not-allowed read-only:bg-slate-100 read-only:text-slate-500"
                            >

                            @if ($rol->nombre === 'Administrador')
                                <p class="mt-2 text-xs font-semibold text-amber-700">
                                    El nombre del rol Administrador está protegido.
                                </p>
                            @endif

                            @error('nombre')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="descripcion"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Descripción
                            </label>

                            <input
                                id="descripcion"
                                name="descripcion"
                                type="text"
                                maxlength="200"
                                value="{{ old('descripcion', $rol->descripcion) }}"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('descripcion')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div
                    x-data="{
                        seleccionarTodos: false,
                        marcarTodos() {
                            const cajas = this.$root.querySelectorAll('input[name=\'permisos[]\']:not(:disabled)');

                            cajas.forEach(caja => {
                                caja.checked = this.seleccionarTodos;
                            });
                        },
                        actualizarSeleccionGeneral() {
                            const cajas = Array.from(
                                this.$root.querySelectorAll('input[name=\'permisos[]\']:not(:disabled)')
                            );

                            this.seleccionarTodos =
                                cajas.length > 0 &&
                                cajas.every(caja => caja.checked);
                        }
                    }"
                    x-init="actualizarSeleccionGeneral()"
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="flex flex-col gap-4 border-b border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Permisos del rol
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Marca las funciones que podrá utilizar este tipo de usuario.
                            </p>
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                            <input
                                type="checkbox"
                                x-model="seleccionarTodos"
                                @change="marcarTodos()"
                                class="h-5 w-5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                            >

                            <span class="text-sm font-bold text-emerald-800">
                                Seleccionar todos
                            </span>
                        </label>
                    </div>

                    <div class="space-y-6 p-6">
                        @forelse ($permisos as $modulo => $permisosModulo)
                            <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-base font-extrabold text-emerald-950">
                                            {{ $modulo }}
                                        </h4>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $permisosModulo->count() }}
                                            {{ $permisosModulo->count() === 1 ? 'permiso disponible' : 'permisos disponibles' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                                    @foreach ($permisosModulo as $permiso)
                                        @php
                                            $seleccionado = in_array(
                                                $permiso->id,
                                                old('permisos', $permisosAsignados)
                                            );

                                            $permisoProtegido =
                                                $rol->nombre === 'Administrador'
                                                && $permiso->codigo === 'seguridad.administrar';
                                        @endphp

                                        <label
                                            class="flex items-start gap-3 rounded-xl border p-4 transition
                                                {{ $permisoProtegido
                                                    ? 'cursor-not-allowed border-amber-300 bg-amber-50'
                                                    : 'cursor-pointer border-slate-200 bg-white hover:border-emerald-300 hover:bg-emerald-50' }}"
                                        >
                                            @if ($permisoProtegido)
                                                <input
                                                    type="hidden"
                                                    name="permisos[]"
                                                    value="{{ $permiso->id }}"
                                                >
                                            @endif

                                            <input
                                                name="permisos[]"
                                                type="checkbox"
                                                value="{{ $permiso->id }}"
                                                @checked($seleccionado || $permisoProtegido)
                                                @disabled($permisoProtegido)
                                                @change="actualizarSeleccionGeneral()"
                                                class="mt-1 h-5 w-5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600 disabled:cursor-not-allowed disabled:opacity-60"
                                            >

                                            <div>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <p class="text-sm font-bold text-slate-800">
                                                        {{ $permiso->nombre }}
                                                    </p>

                                                    @if ($permisoProtegido)
                                                        <span class="rounded-full bg-amber-200 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-amber-900">
                                                            Protegido
                                                        </span>
                                                    @endif
                                                </div>

                                                @if ($permiso->descripcion)
                                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                                        {{ $permiso->descripcion }}
                                                    </p>
                                                @endif

                                                <p class="mt-2 font-mono text-[11px] font-semibold text-emerald-700">
                                                    {{ $permiso->codigo }}
                                                </p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </section>
                        @empty
                            <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-semibold text-amber-800">
                                No hay permisos activos disponibles.
                            </div>
                        @endforelse

                        @error('permisos')
                            <p class="text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('permisos.*')
                            <p class="text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('admin.roles.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-emerald-900"
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>