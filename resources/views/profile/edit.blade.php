<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div
                class="relative overflow-hidden rounded-[28px]
                       bg-emerald-950 px-6 py-7
                       shadow-[0_18px_50px_rgba(6,78,59,0.14)]
                       sm:px-8"
            >
                <div
                    class="pointer-events-none absolute -right-16 -top-20
                           h-56 w-56 rounded-full
                           bg-amber-300/10 blur-3xl"
                ></div>

                <div class="relative z-10 flex items-start gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0
                               items-center justify-center
                               rounded-2xl border border-amber-300/40
                               bg-white/10 text-amber-300"
                    >
                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21a8 8 0 0 1 16 0" />
                        </svg>
                    </div>

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.2em] text-amber-300"
                        >
                            Mi Perfil
                        </p>

                        <h1
                            class="mt-1 text-2xl font-extrabold
                                   tracking-tight text-white sm:text-3xl"
                        >
                            Configuración de la Cuenta
                        </h1>

                        <p
                            class="mt-2 max-w-2xl text-sm
                                   leading-6 text-emerald-100"
                        >
                            Administra tu información personal y
                            la seguridad de tu cuenta administrativa.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Resumen de cuenta --}}
            <div
                class="mt-6 grid gap-4
                       sm:grid-cols-2 xl:grid-cols-4"
            >

                {{-- Usuario --}}
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white p-5
                           shadow-[0_10px_30px_rgba(15,23,42,0.04)]"
                >
                    <p
                        class="text-[11px] font-extrabold uppercase
                               tracking-[0.14em] text-gray-400"
                    >
                        Usuario
                    </p>

                    <p
                        class="mt-2 truncate text-sm font-extrabold
                               text-emerald-950"
                    >
                        {{ $user->name }}
                    </p>
                </div>

                {{-- DNI --}}
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white p-5
                           shadow-[0_10px_30px_rgba(15,23,42,0.04)]"
                >
                    <p
                        class="text-[11px] font-extrabold uppercase
                               tracking-[0.14em] text-gray-400"
                    >
                        DNI
                    </p>

                    <p
                        class="mt-2 text-sm font-extrabold
                               text-emerald-950"
                    >
                        {{ $user->dni ?? '—' }}
                    </p>
                </div>

                {{-- Rol --}}
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white p-5
                           shadow-[0_10px_30px_rgba(15,23,42,0.04)]"
                >
                    <p
                        class="text-[11px] font-extrabold uppercase
                               tracking-[0.14em] text-gray-400"
                    >
                        Rol
                    </p>

                    <p
                        class="mt-2 text-sm font-extrabold
                               text-emerald-950"
                    >
                        {{ $user->rol?->nombre ?? 'Sin asignar' }}
                    </p>
                </div>

                {{-- Estado --}}
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white p-5
                           shadow-[0_10px_30px_rgba(15,23,42,0.04)]"
                >
                    <p
                        class="text-[11px] font-extrabold uppercase
                               tracking-[0.14em] text-gray-400"
                    >
                        Estado de la Cuenta
                    </p>

                    <div class="mt-2">
                        @if ($user->estado)
                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full bg-emerald-50
                                       px-3 py-1
                                       text-xs font-extrabold
                                       text-emerald-700"
                            >
                                <span
                                    class="h-2 w-2 rounded-full
                                           bg-emerald-500"
                                ></span>

                                Activa
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full bg-red-50
                                       px-3 py-1
                                       text-xs font-extrabold
                                       text-red-700"
                            >
                                <span
                                    class="h-2 w-2 rounded-full
                                           bg-red-500"
                                ></span>

                                Inactiva
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Formularios --}}
            <div
                class="mt-6 grid items-start gap-6
                       2xl:grid-cols-2"
            >

                <section
                    class="rounded-[26px]
                           border border-gray-200
                           bg-white p-6
                           shadow-[0_15px_40px_rgba(15,23,42,0.05)]
                           sm:p-7"
                >
                    @include(
                        'profile.partials.update-profile-information-form'
                    )
                </section>

                <section
                    class="rounded-[26px]
                           border border-gray-200
                           bg-white p-6
                           shadow-[0_15px_40px_rgba(15,23,42,0.05)]
                           sm:p-7"
                >
                    @include(
                        'profile.partials.update-password-form'
                    )
                </section>

            </div>

            {{-- Aviso --}}
            <div
                class="mt-6 flex items-start gap-4
                       rounded-2xl border border-amber-200
                       bg-amber-50/70 p-5"
            >
                <div
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl bg-amber-100
                           text-amber-700"
                >
                    <svg
                        class="h-5 w-5"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            d="M12 3 4 6v6c0 5 3.5 8 8 9
                               4.5-1 8-4 8-9V6z"
                        />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                </div>

                <div>
                    <p
                        class="text-sm font-extrabold
                               text-amber-950"
                    >
                        Cuenta Administrativa
                    </p>

                    <p
                        class="mt-1 text-xs leading-5
                               text-amber-900/70"
                    >
                        Los roles, permisos y el estado de la cuenta
                        son administrados exclusivamente por usuarios
                        autorizados del sistema.
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>