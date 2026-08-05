<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad y acceso
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Nuevo rol
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Define el nombre del rol y selecciona los permisos que tendrá disponibles.
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
            <form
                method="POST"
                action="{{ route('admin.roles.guardar') }}"
                class="space-y-6"
            >
                @csrf

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
                        <h3 class="text-lg font-extrabold text-emerald-950">
                            Información del rol
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Registra un nombre claro y una breve descripción.
                        </p>
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
                                value="{{ old('nombre') }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

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
                                value="{{ old('descripcion') }}"
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
                            const cajas = this.$root.querySelectorAll('input[name=\'permisos[]\']');

                            cajas.forEach(caja => {
                                caja.checked = this.seleccionarTodos;
                            });
                        }
                    }"
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="flex flex-col gap-4 border-b border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Permisos del rol
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Selecciona las funciones que podrá utilizar este rol.
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
                                <div class="mb-4">
                                    <h4 class="text-base font-extrabold text-emerald-950">
                                        {{ $modulo }}
                                    </h4>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $permisosModulo->count() }}
                                        {{ $permisosModulo->count() === 1 ? 'permiso disponible' : 'permisos disponibles' }}
                                    </p>
                                </div>

                                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                                    @foreach ($permisosModulo as $permiso)
                                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-emerald-300 hover:bg-emerald-50">
                                            <input
                                                name="permisos[]"
                                                type="checkbox"
                                                value="{{ $permiso->id }}"
                                                @checked(in_array($permiso->id, old('permisos', [])))
                                                class="mt-1 h-5 w-5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                                            >

                                            <div>
                                                <p class="text-sm font-bold text-slate-800">
                                                    {{ $permiso->nombre }}
                                                </p>

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
                        Registrar rol
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>