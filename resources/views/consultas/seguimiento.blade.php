<x-public-layout title="Seguimiento de consulta">

    <section class="relative overflow-hidden bg-gray-50 py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-16
                   h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-10
                   h-96 w-96 rounded-full bg-amber-100/60 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('consultas.crear') }}"
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

                Volver a consultas
            </a>

            <div class="mx-auto mt-10 max-w-3xl text-center">

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
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                    Consulta en línea
                </div>

                <h1
                    class="mt-6 text-4xl font-extrabold
                           tracking-tight text-emerald-950
                           sm:text-5xl"
                >
                    Seguimiento de consulta
                </h1>

                <div class="mt-5 flex justify-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-600">
                    Ingresa el código de seguimiento y el correo electrónico
                    utilizado al registrar tu consulta.
                </p>
            </div>

            <div
                class="mx-auto mt-12 max-w-3xl overflow-hidden
                       rounded-[32px] border border-amber-200
                       bg-white shadow-[0_24px_70px_rgba(6,78,59,0.10)]"
            >
                <div class="border-b border-gray-100 p-6 sm:p-8">

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
                                <path d="M4 5h16v14H4z"/>
                                <path d="M8 9h8M8 13h5"/>
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-600"
                            >
                                Verificación
                            </p>

                            <h2
                                class="mt-1 text-2xl font-extrabold
                                       text-emerald-950"
                            >
                                Consulta el estado de tu solicitud
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Ambos datos deben coincidir con los registrados.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">

                    @if ($errors->any())

                        <div
                            class="mb-7 rounded-2xl border border-red-200
                                   bg-red-50 p-5"
                        >
                            <div class="flex items-start gap-3">

                                <svg
                                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 8v5"/>
                                    <path d="M12 16h.01"/>
                                </svg>

                                <div>
                                    <p class="font-extrabold text-red-800">
                                        Revisa los datos ingresados
                                    </p>

                                    <ul class="mt-2 space-y-1 text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('consultas.seguimiento.consultar') }}"
                        class="space-y-6"
                    >
                        @csrf

                        <div>
                            <label
                                for="codigo"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Código de seguimiento
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative mt-2">

                                <div
                                    class="pointer-events-none absolute inset-y-0
                                           left-0 flex items-center pl-4
                                           text-gray-400"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M4 5h16v14H4z"/>
                                        <path d="M8 9h8M8 13h5"/>
                                    </svg>
                                </div>

                                <input
                                    id="codigo"
                                    name="codigo"
                                    type="text"
                                    maxlength="30"
                                    required
                                    value="{{ old('codigo', $codigoBuscado ?? '') }}"
                                    placeholder="Ejemplo: CON-20260721-MQ8MG"
                                    class="w-full rounded-xl border-gray-300
                                           bg-white py-3 pl-12 pr-4
                                           font-bold uppercase tracking-wide
                                           text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                    oninput="this.value = this.value.toUpperCase()"
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

                            <div class="relative mt-2">

                                <div
                                    class="pointer-events-none absolute inset-y-0
                                           left-0 flex items-center pl-4
                                           text-gray-400"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M4 6h16v12H4z"/>
                                        <path d="m4 7 8 6 8-6"/>
                                    </svg>
                                </div>

                                <input
                                    id="correo"
                                    name="correo"
                                    type="email"
                                    maxlength="150"
                                    required
                                    autocomplete="email"
                                    value="{{ old('correo', $correoBuscado ?? '') }}"
                                    placeholder="correo@ejemplo.com"
                                    class="w-full rounded-xl border-gray-300
                                           bg-white py-3 pl-12 pr-4
                                           text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>
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
                            Consultar estado

                            <svg
                                class="h-5 w-5 text-amber-300"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-4-4"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if (($busquedaRealizada ?? false) && !$consulta)

                <div
                    class="mx-auto mt-8 max-w-3xl rounded-[26px]
                           border border-red-200 bg-red-50 p-6
                           shadow-sm"
                >
                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center
                                   justify-center rounded-2xl bg-red-100
                                   text-red-700"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M9 9l6 6M15 9l-6 6"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-red-900">
                                No se encontró la consulta
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-red-700">
                                Verifica que el código y el correo electrónico
                                sean exactamente los mismos que utilizaste
                                durante el registro.
                            </p>
                        </div>
                    </div>
                </div>

            @endif

            @if (($busquedaRealizada ?? false) && $consulta)

                @php
                    $estado = strtolower($consulta->estado);

                    $estados = [
                        'recibida' => [
                            'titulo' => 'Consulta recibida',
                            'descripcion' => 'La institución ha recibido tu consulta.',
                            'clase' => 'bg-blue-50 border-blue-200 text-blue-800',
                        ],
                        'en_revision' => [
                            'titulo' => 'En revisión',
                            'descripcion' => 'Tu consulta está siendo revisada.',
                            'clase' => 'bg-amber-50 border-amber-200 text-amber-800',
                        ],
                        'derivada' => [
                            'titulo' => 'Derivada al área responsable',
                            'descripcion' => 'La consulta fue enviada al área correspondiente.',
                            'clase' => 'bg-purple-50 border-purple-200 text-purple-800',
                        ],
                        'respondida' => [
                            'titulo' => 'Consulta respondida',
                            'descripcion' => 'La institución ya registró una respuesta.',
                            'clase' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
                        ],
                        'cerrada' => [
                            'titulo' => 'Consulta cerrada',
                            'descripcion' => 'La atención de la consulta ha finalizado.',
                            'clase' => 'bg-gray-100 border-gray-300 text-gray-800',
                        ],
                    ];

                    $detalleEstado = $estados[$estado] ?? [
                        'titulo' => ucfirst(str_replace('_', ' ', $estado)),
                        'descripcion' => 'Consulta registrada en el sistema.',
                        'clase' => 'bg-gray-50 border-gray-200 text-gray-800',
                    ];
                @endphp

                <div
                    id="resultado-seguimiento"
                    class="mx-auto mt-8 max-w-3xl overflow-hidden
                           rounded-[30px] border border-emerald-200
                           bg-white shadow-[0_20px_60px_rgba(6,78,59,0.10)]"
                >
                    <div
                        class="flex flex-col gap-4 bg-emerald-950
                               p-6 text-white sm:flex-row
                               sm:items-center sm:justify-between"
                    >
                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-300"
                            >
                                Resultado de la consulta
                            </p>

                            <h2 class="mt-2 text-2xl font-extrabold">
                                {{ $consulta->codigo }}
                            </h2>
                        </div>

                        <span
                            class="inline-flex w-fit items-center rounded-full
                                   border border-amber-300 bg-emerald-900
                                   px-4 py-2 text-sm font-extrabold
                                   text-amber-300"
                        >
                            {{ $detalleEstado['titulo'] }}
                        </span>
                    </div>

                    <div class="space-y-7 p-6 sm:p-8">

                        <div
                            class="rounded-2xl border p-5
                                   {{ $detalleEstado['clase'] }}"
                        >
                            <p class="font-extrabold">
                                {{ $detalleEstado['titulo'] }}
                            </p>

                            <p class="mt-2 text-sm leading-6">
                                {{ $detalleEstado['descripcion'] }}
                            </p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500"
                                >
                                    Solicitante
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->nombres }}
                                    {{ $consulta->apellidos }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500"
                                >
                                    Fecha de registro
                                </p>

                                <p class="mt-2 font-bold text-emerald-950">
                                    {{ $consulta->created_at->format('d/m/Y') }}
                                    a las
                                    {{ $consulta->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Asunto
                            </p>

                            <p class="mt-2 font-bold text-emerald-950">
                                {{ $consulta->asunto }}
                            </p>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Consulta registrada
                            </p>

                            <div
                                class="mt-2 rounded-2xl border border-gray-200
                                       bg-gray-50 p-5 text-sm leading-7
                                       text-gray-700"
                            >
                                {{ $consulta->mensaje }}
                            </div>
                        </div>

                        @if ($consulta->respuesta)

                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-emerald-700"
                                >
                                    Respuesta institucional
                                </p>

                                <div
                                    class="mt-2 rounded-2xl border
                                           border-emerald-200 bg-emerald-50
                                           p-5 leading-7 text-emerald-900"
                                >
                                    {{ $consulta->respuesta }}
                                </div>

                                @if ($consulta->respondido_en)

                                    <p class="mt-2 text-xs text-gray-500">
                                        Respondida el
                                        {{ $consulta->respondido_en->format('d/m/Y') }}
                                        a las
                                        {{ $consulta->respondido_en->format('H:i') }}.
                                    </p>

                                @endif
                            </div>

                        @else

                            <div
                                class="rounded-2xl border border-amber-200
                                       bg-amber-50 p-5"
                            >
                                <p class="font-extrabold text-amber-900">
                                    Respuesta pendiente
                                </p>

                                <p class="mt-2 text-sm leading-6 text-amber-800">
                                    La institución todavía no ha registrado una
                                    respuesta para esta consulta.
                                </p>
                            </div>

                        @endif
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const resultado = document.getElementById(
                            'resultado-seguimiento'
                        );

                        if (resultado) {
                            resultado.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                </script>

            @endif
        </div>
    </section>

</x-public-layout>