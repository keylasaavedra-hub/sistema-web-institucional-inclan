<x-public-layout>

    @php
        $estados = [
            'recibida' => [
                'texto' => 'Recibida',
                'clase' => 'border-blue-200 bg-blue-50 text-blue-800',
            ],
            'en_revision' => [
                'texto' => 'En revisión',
                'clase' => 'border-amber-200 bg-amber-50 text-amber-800',
            ],
            'observada' => [
                'texto' => 'Observada',
                'clase' => 'border-red-200 bg-red-50 text-red-800',
            ],
            'apta' => [
                'texto' => 'Apta',
                'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
            ],
            'no_apta' => [
                'texto' => 'No apta',
                'clase' => 'border-gray-300 bg-gray-100 text-gray-800',
            ],
            'seleccionada' => [
                'texto' => 'Seleccionada',
                'clase' => 'border-violet-200 bg-violet-50 text-violet-800',
            ],
        ];
    @endphp

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Seguimiento de postulación
                </p>

                <h1 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Consulta tu postulación
                </h1>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Ingresa el código recibido y tu DNI o correo electrónico
                    para consultar el estado de tu postulación.
                </p>
            </div>

            <div class="mx-auto mt-10 max-w-3xl">

                @if ($errors->any())
                    <div class="mb-7 rounded-2xl border border-red-200 bg-red-50 p-5">
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
                    action="{{ route('postulaciones.consultar') }}"
                    class="rounded-[28px] border border-amber-200
                           bg-white p-6
                           shadow-[0_18px_50px_rgba(6,78,59,0.08)]
                           sm:p-8"
                >
                    @csrf

                    <div>
                        <label
                            for="codigo"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Código de postulación
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="codigo"
                            name="codigo"
                            type="text"
                            maxlength="35"
                            required
                            value="{{ old('codigo') }}"
                            placeholder="Ejemplo: POST-20260804-ABC123"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 uppercase shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <div class="mt-6">
                        <label
                            for="identificador"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            DNI o correo electrónico
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="identificador"
                            name="identificador"
                            type="text"
                            maxlength="150"
                            required
                            value="{{ old('identificador') }}"
                            placeholder="Ingresa tu DNI o correo"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    <button
                        type="submit"
                        class="mt-7 inline-flex w-full items-center justify-center
                               rounded-xl bg-emerald-950 px-6 py-4
                               font-extrabold text-white transition
                               hover:bg-emerald-900
                               focus:outline-none focus:ring-4
                               focus:ring-emerald-200"
                    >
                        Consultar postulación
                    </button>
                </form>

                @isset($consultaRealizada)

                    @if ($postulacion)

                        @php
                            $detalleEstado = $estados[$postulacion->estado] ?? [
                                'texto' => ucfirst(str_replace('_', ' ', $postulacion->estado)),
                                'clase' => 'border-gray-200 bg-gray-50 text-gray-800',
                            ];
                        @endphp

                        <article
                            class="mt-8 overflow-hidden rounded-[28px]
                                   border border-gray-200 bg-white
                                   shadow-[0_18px_50px_rgba(15,23,42,0.08)]"
                        >
                            <header
                                class="flex flex-col gap-4 bg-emerald-950
                                       p-6 text-white sm:flex-row
                                       sm:items-center sm:justify-between sm:p-8"
                            >
                                <div>
                                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                                        Código de seguimiento
                                    </p>

                                    <h2 class="mt-2 text-2xl font-extrabold">
                                        {{ $postulacion->codigo }}
                                    </h2>
                                </div>

                                <span
                                    class="inline-flex w-fit rounded-full border
                                           px-4 py-2 text-sm font-extrabold
                                           {{ $detalleEstado['clase'] }}"
                                >
                                    {{ $detalleEstado['texto'] }}
                                </span>
                            </header>

                            <div class="space-y-7 p-6 sm:p-8">

                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                            Convocatoria
                                        </p>

                                        <p class="mt-2 font-extrabold text-emerald-950">
                                            {{ $postulacion->convocatoria->titulo }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                            Fecha de registro
                                        </p>

                                        <p class="mt-2 font-extrabold text-emerald-950">
                                            {{ $postulacion->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                            Postulante
                                        </p>

                                        <p class="mt-2 font-bold text-emerald-950">
                                            {{ $postulacion->nombres }}
                                            {{ $postulacion->apellidos }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                            Última revisión
                                        </p>

                                        <p class="mt-2 font-bold text-emerald-950">
                                            {{ $postulacion->fecha_revision
                                                ? $postulacion->fecha_revision->format('d/m/Y H:i')
                                                : 'Pendiente de revisión' }}
                                        </p>
                                    </div>
                                </div>

                                @if ($postulacion->observacion)
                                    <div>
                                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-amber-700">
                                            Observación institucional
                                        </p>

                                        <div
                                            class="mt-2 whitespace-pre-line rounded-2xl
                                                   border border-amber-200 bg-amber-50
                                                   p-5 leading-7 text-amber-900"
                                        >
                                            {{ $postulacion->observacion }}
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="rounded-2xl border border-blue-200
                                           bg-blue-50 p-5 text-blue-900"
                                >
                                    @switch($postulacion->estado)
                                        @case('recibida')
                                            Tu postulación fue recibida correctamente y está pendiente de revisión.
                                            @break

                                        @case('en_revision')
                                            Tu postulación está siendo evaluada por el personal responsable.
                                            @break

                                        @case('observada')
                                            Tu postulación presenta una observación. Revisa el mensaje registrado.
                                            @break

                                        @case('apta')
                                            Tu postulación fue declarada apta para continuar en el proceso.
                                            @break

                                        @case('no_apta')
                                            Tu postulación fue declarada no apta para este proceso.
                                            @break

                                        @case('seleccionada')
                                            Has sido seleccionado para esta convocatoria.
                                            @break

                                        @default
                                            Consulta nuevamente más adelante para conocer nuevas actualizaciones.
                                    @endswitch
                                </div>
                            </div>
                        </article>

                    @else

                        <div
                            class="mt-8 rounded-[26px] border border-red-200
                                   bg-red-50 px-6 py-12 text-center"
                        >
                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center
                                       rounded-full bg-red-100 text-red-700"
                            >
                                <svg
                                    class="h-8 w-8"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="m9 9 6 6M15 9l-6 6"/>
                                </svg>
                            </div>

                            <h2 class="mt-5 text-xl font-extrabold text-red-900">
                                Postulación no encontrada
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-red-700">
                                Verifica que el código y el DNI o correo sean correctos.
                            </p>
                        </div>

                    @endif

                @endisset
            </div>
        </div>
    </section>

</x-public-layout>