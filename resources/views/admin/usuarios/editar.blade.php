<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguridad y acceso
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Editar usuario
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Actualiza los datos, el rol y el estado de acceso de la cuenta.
                </p>
            </div>

            <a
                href="{{ route('admin.usuarios.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
            >
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

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

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-extrabold text-emerald-950">
                                Datos de la cuenta
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Los campos marcados con asterisco son obligatorios.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-sm font-extrabold text-emerald-800">
                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                {{ strtoupper(substr($usuario->apellidos ?? '', 0, 1)) }}
                            </div>

                            <div>
                                <p class="font-bold text-slate-900">
                                    {{ $usuario->name }} {{ $usuario->apellidos }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ $usuario->rol?->nombre ?? 'Sin rol' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.usuarios.actualizar', $usuario) }}"
                    class="space-y-8 p-6"
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

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                for="dni"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                DNI *
                            </label>

                            <input
                                id="dni"
                                name="dni"
                                type="text"
                                inputmode="numeric"
                                maxlength="8"
                                value="{{ old('dni', $usuario->dni) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('dni')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="telefono"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Teléfono
                            </label>

                            <input
                                id="telefono"
                                name="telefono"
                                type="text"
                                maxlength="20"
                                value="{{ old('telefono', $usuario->telefono) }}"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('telefono')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="name"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Nombres *
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                maxlength="100"
                                value="{{ old('name', $usuario->name) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('name')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="apellidos"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Apellidos *
                            </label>

                            <input
                                id="apellidos"
                                name="apellidos"
                                type="text"
                                maxlength="100"
                                value="{{ old('apellidos', $usuario->apellidos) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('apellidos')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label
                                for="email"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Correo electrónico *
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                maxlength="255"
                                value="{{ old('email', $usuario->email) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >

                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="rol_id"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Rol *
                            </label>

                            <select
                                id="rol_id"
                                name="rol_id"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                            >
                                <option value="">Selecciona un rol</option>

                                @foreach ($roles as $rol)
                                    <option
                                        value="{{ $rol->id }}"
                                        @selected((int) old('rol_id', $usuario->rol_id) === $rol->id)
                                    >
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('rol_id')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-end">
                            <label class="flex w-full cursor-pointer items-center justify-between rounded-xl border border-slate-300 bg-slate-50 px-4 py-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">
                                        Cuenta activa
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Las cuentas inactivas no pueden iniciar sesión.
                                    </p>
                                </div>

                                <input
                                    name="estado"
                                    type="hidden"
                                    value="0"
                                >

                                <input
                                    id="estado"
                                    name="estado"
                                    type="checkbox"
                                    value="1"
                                    @checked((string) old('estado', $usuario->estado ? '1' : '0') === '1')
                                    @disabled($usuario->is(auth()->user()))
                                    class="h-5 w-5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                            </label>

                            @if ($usuario->is(auth()->user()))
                                <input
                                    type="hidden"
                                    name="estado"
                                    value="1"
                                >
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                        <h4 class="font-extrabold text-amber-900">
                            Cambiar contraseña
                        </h4>

                        <p class="mt-1 text-sm text-amber-800">
                            Deja estos campos vacíos para conservar la contraseña actual.
                        </p>

                        <div class="mt-5 grid gap-6 md:grid-cols-2">
                            <div>
                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Nueva contraseña
                                </label>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                                >

                                <p class="mt-2 text-xs text-slate-500">
                                    Mínimo 8 caracteres, con mayúscula, minúscula, número y símbolo.
                                </p>

                                @error('password')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="password_confirmation"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Confirmar nueva contraseña
                                </label>

                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('admin.usuarios.index') }}"
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
    </div>
</x-app-layout>