<div
    x-data="{
        showCurrent: false,
        showNew: false,
        showConfirmation: false
    }"
>
    <div class="flex items-start gap-4">
        <div
            class="flex h-12 w-12 shrink-0
                   items-center justify-center
                   rounded-2xl bg-amber-50
                   text-amber-700"
        >
            <svg
                class="h-6 w-6"
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

        <div>
            <p
                class="text-xs font-extrabold uppercase
                       tracking-[0.16em] text-amber-600"
            >
                Seguridad de la Cuenta
            </p>

            <h2
                class="mt-1 text-2xl font-extrabold
                       text-emerald-950"
            >
                Cambiar Contraseña
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Utiliza una contraseña segura y única para proteger
                tu cuenta administrativa.
            </p>
        </div>
    </div>

    <div class="my-7 h-px bg-gray-100"></div>

    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="space-y-6"
    >
        @csrf
        @method('put')

        <div>
            <label
                for="update_password_current_password"
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                Contraseña Actual
                <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-2">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    :type="showCurrent ? 'text' : 'password'"
                    autocomplete="current-password"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           px-4 pr-14 text-sm
                           font-semibold text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                    placeholder="Ingresa tu contraseña actual"
                >

                <button
                    type="button"
                    @click="showCurrent = !showCurrent"
                    class="absolute inset-y-0 right-0
                           flex items-center px-4
                           text-gray-400 transition
                           hover:text-emerald-800"
                    aria-label="Mostrar u ocultar contraseña actual"
                >
                    <svg
                        x-show="!showCurrent"
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
                        x-show="showCurrent"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    </svg>
                </button>
            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2"
            />
        </div>

        <div>
            <label
                for="update_password_password"
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                Nueva Contraseña
                <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-2">
                <input
                    id="update_password_password"
                    name="password"
                    :type="showNew ? 'text' : 'password'"
                    autocomplete="new-password"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           px-4 pr-14 text-sm
                           font-semibold text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                    placeholder="Ingresa una nueva contraseña"
                >

                <button
                    type="button"
                    @click="showNew = !showNew"
                    class="absolute inset-y-0 right-0
                           flex items-center px-4
                           text-gray-400 transition
                           hover:text-emerald-800"
                    aria-label="Mostrar u ocultar nueva contraseña"
                >
                    <svg
                        x-show="!showNew"
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
                        x-show="showNew"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    </svg>
                </button>
            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2"
            />
        </div>

        <div>
            <label
                for="update_password_password_confirmation"
                class="block text-sm font-extrabold
                       text-emerald-950"
            >
                Confirmar Nueva Contraseña
                <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-2">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    :type="showConfirmation ? 'text' : 'password'"
                    autocomplete="new-password"
                    class="h-14 w-full rounded-xl
                           border-gray-300 bg-gray-50
                           px-4 pr-14 text-sm
                           font-semibold text-gray-900
                           shadow-sm transition
                           focus:border-emerald-700
                           focus:bg-white
                           focus:ring-emerald-700"
                    placeholder="Repite la nueva contraseña"
                >

                <button
                    type="button"
                    @click="showConfirmation = !showConfirmation"
                    class="absolute inset-y-0 right-0
                           flex items-center px-4
                           text-gray-400 transition
                           hover:text-emerald-800"
                    aria-label="Mostrar u ocultar confirmación"
                >
                    <svg
                        x-show="!showConfirmation"
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
                        x-show="showConfirmation"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    </svg>
                </button>
            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div
            class="rounded-2xl border border-gray-200
                   bg-gray-50 p-4"
        >
            <p class="text-xs leading-5 text-gray-500">
                Para una mayor seguridad, utiliza una contraseña
                que no uses en otros servicios y evita compartir
                tus credenciales.
            </p>
        </div>

        <div
            class="flex flex-col gap-4 border-t
                   border-gray-100 pt-6
                   sm:flex-row sm:items-center
                   sm:justify-between"
        >
            <div>
                @if (session('status') === 'password-updated')
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
                        Contraseña actualizada correctamente.
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
                Actualizar Contraseña
            </button>
        </div>
    </form>
</div>