<div>
    <div class="flex items-start gap-4">
        <div
            class="flex h-12 w-12 shrink-0
                   items-center justify-center
                   rounded-2xl bg-emerald-50
                   text-emerald-800"
        >
            <svg
                class="h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>
        </div>

        <div>
            <p
                class="text-xs font-extrabold uppercase
                       tracking-[0.16em] text-amber-600"
            >
                Información Personal
            </p>

            <h2
                class="mt-1 text-2xl font-extrabold
                       text-emerald-950"
            >
                Datos del Perfil
            </h2>

            <p
                class="mt-2 text-sm leading-6
                       text-gray-500"
            >
                Actualiza tu nombre y correo electrónico asociados
                a tu cuenta administrativa.
            </p>
        </div>
    </div>

    <div class="my-7 h-px bg-gray-100"></div>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="space-y-6"
    >
        @csrf
        @method('patch')

        <div>
            <label
                for="name"
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                Nombre Completo
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
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21a7 7 0 0 1 14 0"/>
                    </svg>
                </div>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           pl-12 pr-4 text-sm
                           font-semibold text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                >
            </div>

            @error('name')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="email"
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                Correo Electrónico
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
                            y="5"
                            width="18"
                            height="14"
                            rx="2"
                        />
                        <path d="m3 7 9 6 9-6"/>
                    </svg>
                </div>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="email"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           pl-12 pr-4 text-sm
                           font-semibold text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                >
            </div>

            @error('email')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                DNI
            </label>

            <div
                class="mt-2 flex h-14 items-center
                       rounded-xl border border-gray-200
                       bg-gray-100 px-4"
            >
                <svg
                    class="mr-3 h-5 w-5 text-gray-400"
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

                <span class="text-sm font-bold text-gray-600">
                    {{ $user->dni ?? 'No disponible' }}
                </span>

                <span
                    class="ml-auto rounded-full
                           bg-gray-200 px-2.5 py-1
                           text-[10px] font-extrabold
                           uppercase tracking-wider
                           text-gray-500"
                >
                    Solo lectura
                </span>
            </div>

            <p class="mt-2 text-xs leading-5 text-gray-400">
                El DNI solo puede ser modificado por un administrador
                autorizado.
            </p>
        </div>

        <div
            class="flex flex-col gap-4 border-t
                   border-gray-100 pt-6
                   sm:flex-row sm:items-center
                   sm:justify-between"
        >
            <div>
                @if (session('status') === 'profile-updated')
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="inline-flex items-center gap-2
                               rounded-xl bg-emerald-50
                               px-3 py-2 text-sm
                               font-bold text-emerald-700"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12l4 4L19 6"/>
                        </svg>

                        Perfil actualizado correctamente.
                    </div>
                @endif
            </div>

            <button
                type="submit"
                class="inline-flex h-12 items-center
                       justify-center gap-2 rounded-xl
                       border-2 border-amber-400
                       bg-emerald-950 px-6
                       text-sm font-extrabold text-white
                       shadow-lg shadow-emerald-950/10
                       transition
                       hover:-translate-y-0.5
                       hover:bg-emerald-900
                       focus:outline-none
                       focus:ring-4 focus:ring-emerald-100"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M5 4h11l3 3v13H5z"/>
                    <path d="M8 4v6h8V4"/>
                    <path d="M8 20v-6h8v6"/>
                </svg>

                Guardar Cambios
            </button>
        </div>
    </form>
</div>