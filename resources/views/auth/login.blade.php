<x-guest-layout>

    <div>
        <p
            class="text-xs font-extrabold uppercase
                   tracking-[0.2em] text-amber-600"
        >
            Acceso restringido
        </p>

        <h1
            class="mt-3 text-3xl font-extrabold
                   tracking-tight text-emerald-950"
        >
            Iniciar sesión
        </h1>

        <p class="mt-3 text-sm leading-6 text-gray-500">
            Ingresa con las credenciales asignadas por la
            administración de la institución.
        </p>
    </div>

    @if (session('status'))
        <div
            class="mt-6 rounded-2xl border
                   border-emerald-200 bg-emerald-50
                   p-4 text-sm font-bold
                   text-emerald-800"
        >
            {{ session('status') }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('login') }}"
        class="mt-8 space-y-6"
    >
        @csrf

        {{-- DNI --}}
        <div>
            <label
                for="dni"
                class="text-sm font-extrabold
                       text-emerald-950"
            >
                DNI
                <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-2">
                <div
                    class="pointer-events-none absolute
                           inset-y-0 left-0 flex
                           items-center pl-4
                           text-gray-400"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="16"
                            rx="2"
                        />
                        <circle cx="9" cy="10" r="2"/>
                        <path d="M6.5 16c.7-2 4.3-2 5 0"/>
                        <path d="M14 9h4M14 13h4"/>
                    </svg>
                </div>

                <input
                    id="dni"
                    name="dni"
                    type="text"
                    value="{{ old('dni') }}"
                    required
                    autofocus
                    autocomplete="username"
                    inputmode="numeric"
                    maxlength="8"
                    pattern="[0-9]{8}"
                    placeholder="Ingrese su DNI"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           pl-12 pr-4 text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                >
            </div>

            @error('dni')
                <p
                    class="mt-2 text-sm font-semibold
                           text-red-600"
                >
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div
            x-data="{ mostrar: false }"
        >
            <label
                for="password"
                class="text-sm font-extrabold
                       text-emerald-950"
            >
                Contraseña
                <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-2">
                <div
                    class="pointer-events-none absolute
                           inset-y-0 left-0 flex
                           items-center pl-4
                           text-gray-400"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="5"
                            y="10"
                            width="14"
                            height="10"
                            rx="2"
                        />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                </div>

                <input
                    id="password"
                    name="password"
                    :type="mostrar ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="Ingrese su contraseña"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           pl-12 pr-14 text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                >

                <button
                    type="button"
                    @click="mostrar = !mostrar"
                    class="absolute inset-y-0 right-0
                           flex items-center px-4
                           text-gray-400 transition
                           hover:text-emerald-800"
                    aria-label="Mostrar u ocultar contraseña"
                >
                    <svg
                        x-show="!mostrar"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"/>
                        <circle cx="12" cy="12" r="2.5"/>
                    </svg>

                    <svg
                        x-cloak
                        x-show="mostrar"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                        <path d="M9.9 4.2A11 11 0 0 1 12 4c6.5 0 10 8 10 8a18 18 0 0 1-2.1 3.2"/>
                        <path d="M6.6 6.6C3.5 8.5 2 12 2 12s3.5 8 10 8a10 10 0 0 0 5.4-1.6"/>
                    </svg>
                </button>
            </div>

            @error('password')
                <p
                    class="mt-2 text-sm font-semibold
                           text-red-600"
                >
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Recordar --}}
        <label
            for="remember"
            class="flex cursor-pointer
                   items-center gap-3"
        >
            <input
                id="remember"
                name="remember"
                type="checkbox"
                class="rounded border-gray-300
                       text-emerald-700
                       shadow-sm
                       focus:ring-emerald-600"
            >

            <span class="text-sm font-semibold text-gray-600">
                Mantener mi sesión iniciada
            </span>
        </label>

        <button
            type="submit"
            class="inline-flex h-14 w-full
                   items-center justify-center gap-2
                   rounded-xl border-2 border-amber-400
                   bg-emerald-950 px-6
                   font-extrabold text-white
                   shadow-lg
                   shadow-emerald-950/15
                   transition
                   hover:-translate-y-0.5
                   hover:bg-emerald-900
                   focus:outline-none
                   focus:ring-4
                   focus:ring-emerald-200"
        >
            Ingresar al panel

            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M5 12h14"/>
                <path d="m13 6 6 6-6 6"/>
            </svg>
        </button>
    </form>

    <div
        class="mt-7 rounded-2xl
               border border-gray-200
               bg-gray-50 p-4"
    >
        <div class="flex items-start gap-3">
            <svg
                class="mt-0.5 h-5 w-5
                       shrink-0 text-amber-600"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>

            <p class="text-xs leading-5 text-gray-500">
                El acceso está reservado al personal autorizado.
                Las operaciones realizadas en el sistema pueden
                quedar registradas para fines de seguridad.
            </p>
        </div>
    </div>

</x-guest-layout>