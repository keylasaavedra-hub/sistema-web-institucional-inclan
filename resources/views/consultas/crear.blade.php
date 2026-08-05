<x-public-layout title="Consultas">

    <section class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-20
                   h-96 w-96 rounded-full bg-emerald-100/60 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-20
                   h-96 w-96 rounded-full bg-amber-100/60 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('inicio') }}"
                class="inline-flex items-center gap-2 text-sm
                       font-extrabold text-emerald-800
                       transition hover:text-emerald-950"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M19 12H5"/>
                    <path d="m11 18-6-6 6-6"/>
                </svg>

                Volver al inicio
            </a>

            <div
                class="mt-10 grid gap-10
                       lg:grid-cols-[0.85fr_1.15fr]"
            >
                {{-- INFORMACIÓN --}}
                <div>

                    <div
                        class="inline-flex items-center gap-2 rounded-full
                               border border-amber-200 bg-amber-50
                               px-4 py-2 text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-700"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M4 4h16v12H5.5L4 18z"/>
                            <path d="M8 8h8M8 12h5"/>
                        </svg>

                        Atención al ciudadano
                    </div>

                    <h1
                        class="mt-6 text-4xl font-extrabold
                               tracking-tight text-emerald-950
                               sm:text-5xl"
                    >
                        Envíanos tu consulta
                    </h1>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-7 text-base leading-8 text-gray-600">
                        Completa el formulario con tus datos y describe tu
                        consulta de manera clara. La institución registrará
                        la solicitud para su atención.
                    </p>

                    <div
                        class="mt-8 rounded-[28px]
                               border border-amber-300
                               bg-emerald-950 p-7 text-white
                               shadow-[0_22px_60px_rgba(6,78,59,0.14)]"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-2xl border border-amber-300
                                   bg-emerald-900 text-amber-300"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 8v5"/>
                                <path d="M12 16h.01"/>
                            </svg>
                        </div>

                        <p
                            class="mt-5 text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-300"
                        >
                            Información importante
                        </p>

                        <p class="mt-3 leading-7 text-emerald-100">
                            Al registrar la consulta se generará un código único.
                            Guárdalo para realizar el seguimiento posteriormente.
                        </p>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">

                        <div
                            class="rounded-2xl border border-emerald-100
                                   bg-emerald-50 p-5"
                        >
                            <p class="font-extrabold text-emerald-950">
                                Datos protegidos
                            </p>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                La información será utilizada únicamente para
                                atender tu consulta.
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-amber-200
                                   bg-amber-50 p-5"
                        >
                            <p class="font-extrabold text-emerald-950">
                                Respuesta institucional
                            </p>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                La consulta será revisada por el área
                                correspondiente.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- FORMULARIO --}}
                <div
                    class="rounded-[32px] border border-amber-200
                           bg-white p-6
                           shadow-[0_22px_60px_rgba(6,78,59,0.10)]
                           sm:p-8"
                >
                    <div class="mb-8 border-b border-gray-100 pb-6">

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-12 w-12 shrink-0 items-center
                                       justify-center rounded-2xl bg-emerald-950
                                       text-amber-300"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 4h16v12H5.5L4 18z"/>
                                    <path d="M8 8h8M8 12h5"/>
                                </svg>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.16em] text-amber-600"
                                >
                                    Formulario de atención
                                </p>

                                <h2
                                    class="mt-1 text-2xl font-extrabold
                                           text-emerald-950"
                                >
                                    Registra tu consulta
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-gray-500">
                                    Los campos marcados con asterisco son obligatorios.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if (session('consulta_enviada'))

                        <div
                            id="mensaje-consulta-enviada"
                            class="mb-8 overflow-hidden rounded-[26px]
                                   border border-emerald-300 bg-emerald-50
                                   shadow-[0_16px_45px_rgba(6,78,59,0.12)]"
                        >
                            <div class="flex items-start gap-4 p-6">

                                <div
                                    class="flex h-14 w-14 shrink-0 items-center
                                           justify-center rounded-2xl bg-emerald-950
                                           text-amber-300"
                                >
                                    <svg
                                        class="h-7 w-7"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.16em] text-emerald-700"
                                    >
                                        Registro completado
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        ¡Tu consulta fue enviada correctamente!
                                    </h3>

                                    <p class="mt-3 text-sm leading-7 text-emerald-800">
                                        Hemos recibido tu solicitud. Guarda el
                                        siguiente código, porque lo necesitarás
                                        para consultar el estado de atención.
                                    </p>

                                    <div
                                        class="mt-5 flex flex-col gap-3
                                               rounded-2xl border border-amber-300
                                               bg-white p-4
                                               sm:flex-row sm:items-center
                                               sm:justify-between"
                                    >
                                        <div>
                                            <p
                                                class="text-xs font-extrabold
                                                       uppercase tracking-[0.14em]
                                                       text-gray-500"
                                            >
                                                Código de seguimiento
                                            </p>

                                            <p
                                                id="codigo-consulta"
                                                class="mt-1 break-all text-xl
                                                       font-extrabold tracking-wider
                                                       text-emerald-950"
                                            >
                                                {{ session('codigo_consulta') }}
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            onclick="copiarCodigoConsulta()"
                                            class="inline-flex items-center
                                                   justify-center gap-2 rounded-xl
                                                   bg-emerald-950 px-5 py-3
                                                   text-sm font-extrabold text-white
                                                   transition hover:bg-emerald-900"
                                        >
                                            <svg
                                                class="h-4 w-4 text-amber-300"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                            </svg>

                                            Copiar código
                                        </button>
                                    </div>

                                    <p
                                        id="mensaje-copiado"
                                        class="mt-3 hidden text-sm font-bold
                                               text-emerald-700"
                                    >
                                        Código copiado correctamente.
                                    </p>
                                </div>
                            </div>

                            <div
                                class="border-t border-emerald-200
                                       bg-emerald-100/60 px-6 py-4"
                            >
                                <p class="text-sm font-semibold text-emerald-800">
                                    La institución revisará tu consulta y la
                                    derivará al área correspondiente.
                                </p>
                            </div>
                        </div>

                    @endif

                    @if ($errors->any())

                        <div
                            class="mb-7 rounded-2xl border
                                   border-red-200 bg-red-50 p-5"
                        >
                            <p class="font-extrabold text-red-800">
                                Revisa la información ingresada
                            </p>

                            <ul class="mt-3 space-y-1 text-sm text-red-700">

                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('consultas.guardar') }}"
                        class="space-y-6"
                    >
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <label
                                    for="nombres"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Nombres <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="nombres"
                                    name="nombres"
                                    type="text"
                                    value="{{ old('nombres') }}"
                                    required
                                    maxlength="100"
                                    autocomplete="given-name"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>

                            <div>
                                <label
                                    for="apellidos"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Apellidos <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="apellidos"
                                    name="apellidos"
                                    type="text"
                                    value="{{ old('apellidos') }}"
                                    required
                                    maxlength="100"
                                    autocomplete="family-name"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <label
                                    for="dni"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    DNI
                                </label>

                                <input
                                    id="dni"
                                    name="dni"
                                    type="text"
                                    inputmode="numeric"
                                    maxlength="8"
                                    pattern="[0-9]{8}"
                                    value="{{ old('dni') }}"
                                    placeholder="8 dígitos"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>

                            <div>
                                <label
                                    for="telefono"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Teléfono
                                </label>

                                <input
                                    id="telefono"
                                    name="telefono"
                                    type="text"
                                    value="{{ old('telefono') }}"
                                    maxlength="20"
                                    autocomplete="tel"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>
                        </div>

                        <div>
                            <label
                                for="correo"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Correo electrónico
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="correo"
                                name="correo"
                                type="email"
                                value="{{ old('correo') }}"
                                required
                                maxlength="150"
                                autocomplete="email"
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-white
                                       px-4 py-3 text-gray-800 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>

                        <div>
                            <label
                                for="asunto"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Asunto <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="asunto"
                                name="asunto"
                                type="text"
                                maxlength="180"
                                value="{{ old('asunto') }}"
                                required
                                placeholder="Resumen breve de la consulta"
                                class="mt-2 w-full rounded-xl
                                       border-gray-300 bg-white
                                       px-4 py-3 text-gray-800 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>

                        <div>
                            <label
                                for="mensaje"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Detalle de la consulta
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                id="mensaje"
                                name="mensaje"
                                rows="7"
                                maxlength="3000"
                                required
                                placeholder="Describe tu consulta de manera clara..."
                                class="mt-2 w-full resize-y rounded-xl
                                       border-gray-300 bg-white
                                       px-4 py-3 text-gray-800 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >{{ old('mensaje') }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Máximo 3000 caracteres.
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-4"
                        >
                            <label
                                class="flex items-start gap-3
                                       text-sm leading-6 text-gray-600"
                            >
                                <input
                                    type="checkbox"
                                    required
                                    class="mt-1 rounded border-gray-300
                                           text-emerald-700
                                           focus:ring-emerald-700"
                                >

                                <span>
                                    Declaro que la información ingresada es
                                    correcta y autorizo su uso para la atención
                                    de esta consulta.
                                </span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-emerald-950 px-6 py-4
                                   font-extrabold text-white
                                   transition hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200"
                        >
                            Enviar consulta

                            <svg
                                class="h-5 w-5 text-amber-300"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M22 2 11 13"/>
                                <path d="m22 2-7 20-4-9-9-4z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @if (session('consulta_enviada'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mensaje = document.getElementById(
                    'mensaje-consulta-enviada'
                );

                if (mensaje) {
                    mensaje.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });

            function copiarCodigoConsulta() {
                const elemento = document.getElementById('codigo-consulta');
                const confirmacion = document.getElementById('mensaje-copiado');

                if (!elemento) {
                    return;
                }

                const codigo = elemento.textContent.trim();

                navigator.clipboard.writeText(codigo)
                    .then(function () {
                        if (confirmacion) {
                            confirmacion.classList.remove('hidden');

                            setTimeout(function () {
                                confirmacion.classList.add('hidden');
                            }, 3000);
                        }
                    })
                    .catch(function () {
                        window.prompt(
                            'Copia tu código de seguimiento:',
                            codigo
                        );
                    });
            }
        </script>

    @endif

</x-public-layout>