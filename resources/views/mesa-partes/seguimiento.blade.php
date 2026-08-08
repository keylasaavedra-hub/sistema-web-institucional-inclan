<x-public-layout title="Seguimiento de Mesa de Partes">

    <section class="relative overflow-hidden bg-slate-50 py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-20
                   h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-10
                   h-96 w-96 rounded-full bg-amber-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('mesa-partes.crear') }}"
                class="inline-flex items-center gap-2 text-sm
                       font-extrabold text-emerald-800
                       transition hover:text-emerald-950">
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="M19 12H5" />
                    <path d="m11 18-6-6 6-6" />
                </svg>

                Volver a Mesa de Partes
            </a>

            {{-- ENCABEZADO --}}
            <div class="mx-auto mt-10 max-w-3xl text-center">

                <div
                    class="inline-flex items-center gap-2 rounded-full
                           border border-amber-200 bg-amber-50
                           px-4 py-2 text-xs font-extrabold uppercase
                           tracking-[0.18em] text-amber-700">
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-4-4" />
                    </svg>

                    Consulta documentaria
                </div>

                <h1
                    class="mt-6 text-4xl font-extrabold
                           tracking-tight text-emerald-950
                           sm:text-5xl">
                    Seguimiento de trámite
                </h1>

                <div class="mt-5 flex justify-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-600">
                    Consulta el estado de tu documento utilizando el código
                    generado y el correo registrado al momento de presentarlo.
                </p>
            </div>

            {{-- NAVEGACIÓN DEL MÓDULO --}}
            <div
                class="mx-auto mt-10 grid max-w-3xl gap-3 rounded-2xl
                       border border-gray-200 bg-white p-2 shadow-sm
                       sm:grid-cols-2">
                <a
                    href="{{ route('mesa-partes.crear') }}"
                    class="inline-flex items-center justify-center gap-3
                           rounded-xl px-5 py-4 font-extrabold
                           text-gray-600 transition
                           hover:bg-emerald-50 hover:text-emerald-900">
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>

                    Presentar documento
                </a>

                <a
                    href="{{ route('mesa-partes.seguimiento') }}"
                    class="inline-flex items-center justify-center gap-3
                           rounded-xl bg-emerald-950 px-5 py-4
                           font-extrabold text-white shadow-sm">
                    <svg
                        class="h-5 w-5 text-amber-300"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-4-4" />
                    </svg>

                    Consultar seguimiento
                </a>
            </div>

            {{-- FORMULARIO DE BÚSQUEDA --}}
            <div
                class="mx-auto mt-8 max-w-3xl overflow-hidden
                       rounded-[32px] border border-amber-200
                       bg-white shadow-[0_24px_70px_rgba(6,78,59,0.10)]">
                <div class="border-b border-gray-100 p-6 sm:p-8">

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center
                                   justify-center rounded-2xl bg-emerald-950
                                   text-amber-300">
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M6 3h9l4 4v14H6z" />
                                <path d="M14 3v5h5" />
                                <path d="M9 13h6M9 17h4" />
                            </svg>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-600">
                                Verificación del trámite
                            </p>

                            <h2
                                class="mt-1 text-2xl font-extrabold
                                       text-emerald-950">
                                Ingresa los datos de seguimiento
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                El código y el correo deben coincidir con los
                                registrados al presentar el documento.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">

                    @if ($errors->any())

                    <div
                        class="mb-7 rounded-2xl border border-red-200
                                   bg-red-50 p-5">
                        <p class="font-extrabold text-red-800">
                            Revisa los datos ingresados
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
                        action="{{ route('mesa-partes.seguimiento.consultar') }}"
                        class="space-y-6">
                        @csrf

                        <div>
                            <label
                                for="codigo"
                                class="text-sm font-extrabold text-emerald-950">
                                Código de seguimiento
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative mt-2">

                                <span
                                    class="pointer-events-none absolute
                                           inset-y-0 left-0 flex items-center
                                           pl-4 text-gray-400">
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M6 3h9l4 4v14H6z" />
                                        <path d="M14 3v5h5" />
                                    </svg>
                                </span>

                                <input
                                    id="codigo"
                                    name="codigo"
                                    type="text"
                                    maxlength="30"
                                    required
                                    value="{{ old('codigo', $codigoBuscado ?? '') }}"
                                    placeholder="Ejemplo: MDP-20260721-VHYQI"
                                    oninput="this.value = this.value.toUpperCase()"
                                    class="w-full rounded-xl border-gray-300
                                           bg-white py-3 pl-12 pr-4
                                           font-bold uppercase tracking-wide
                                           text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700">
                            </div>
                        </div>

                        <div>
                            <label
                                for="correo"
                                class="text-sm font-extrabold text-emerald-950">
                                Correo electrónico
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative mt-2">

                                <span
                                    class="pointer-events-none absolute
                                           inset-y-0 left-0 flex items-center
                                           pl-4 text-gray-400">
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M4 6h16v12H4z" />
                                        <path d="m4 7 8 6 8-6" />
                                    </svg>
                                </span>

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
                                           focus:ring-emerald-700">
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-emerald-950 px-6 py-4
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200">
                            Consultar estado

                            <svg
                                class="h-5 w-5 text-amber-300"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- NO ENCONTRADO --}}
            @if (($busquedaRealizada ?? false) && !$tramite)

            <div
                class="mx-auto mt-8 max-w-3xl rounded-[26px]
                           border border-red-200 bg-red-50 p-6 shadow-sm">
                <div class="flex items-start gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center
                                   justify-center rounded-2xl
                                   bg-red-100 text-red-700">
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M9 9l6 6M15 9l-6 6" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-lg font-extrabold text-red-900">
                            No se encontró el trámite
                        </h3>

                        <p class="mt-2 text-sm leading-7 text-red-700">
                            Verifica que el código y el correo sean los
                            mismos que utilizaste al presentar el documento.
                        </p>
                    </div>
                </div>
            </div>

            @endif

            {{-- RESULTADO --}}
            @if (($busquedaRealizada ?? false) && $tramite)

            @php
            $estado = strtolower($tramite->estado);

            $estados = [
            'recibido' => [
            'titulo' => 'Documento recibido',
            'descripcion' => 'El documento fue registrado correctamente en Mesa de Partes.',
            'clase' => 'border-blue-200 bg-blue-50 text-blue-900',
            ],
            'en_revision' => [
            'titulo' => 'En revisión',
            'descripcion' => 'El documento está siendo revisado por la institución.',
            'clase' => 'border-amber-200 bg-amber-50 text-amber-900',
            ],
            'derivado' => [
            'titulo' => 'Derivado al área responsable',
            'descripcion' => 'El documento fue remitido al área correspondiente.',
            'clase' => 'border-violet-200 bg-violet-50 text-violet-900',
            ],
            'observado' => [
            'titulo' => 'Trámite observado',
            'descripcion' =>
            'La institución ha registrado una observación que debes revisar.',
            'clase' => 'border-red-200 bg-red-50 text-red-900',
            ],
            'observado' => [
            'titulo' => 'Trámite observado',
            'descripcion' => 'La institución ha registrado una observación que debes revisar.',
            'clase' => 'border-red-200 bg-red-50 text-red-900',
            ],
            'atendido' => [
            'titulo' => 'Trámite atendido',
            'descripcion' => 'La institución ha completado la atención del trámite.',
            'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
            ],
            'cerrado' => [
            'titulo' => 'Trámite cerrado',
            'descripcion' => 'El procedimiento documentario ha finalizado.',
            'clase' => 'border-gray-300 bg-gray-100 text-gray-900',
            ],
            ];

            $detalleEstado = $estados[$estado] ?? [
            'titulo' => ucfirst(str_replace('_', ' ', $estado)),
            'descripcion' => 'El trámite se encuentra registrado en el sistema.',
            'clase' => 'border-gray-200 bg-gray-50 text-gray-900',
            ];

            $remitente = $tramite->tipo_persona === 'juridica'
            ? $tramite->razon_social
            : trim($tramite->nombres . ' ' . $tramite->apellidos);
            @endphp

            <div
                id="resultado-tramite"
                class="mx-auto mt-8 max-w-3xl overflow-hidden
                           rounded-[30px] border border-emerald-200
                           bg-white shadow-[0_24px_70px_rgba(6,78,59,0.12)]">
                <div
                    class="flex flex-col gap-5 bg-emerald-950
                               p-6 text-white sm:flex-row
                               sm:items-center sm:justify-between sm:p-8">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-300">
                            Resultado del trámite
                        </p>

                        <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                            {{ $tramite->codigo }}
                        </h2>
                    </div>

                    <span
                        class="inline-flex w-fit items-center rounded-full
                                   border border-amber-300 bg-emerald-900
                                   px-4 py-2 text-sm font-extrabold
                                   text-amber-300">
                        {{ $detalleEstado['titulo'] }}
                    </span>
                </div>

                <div class="space-y-7 p-6 sm:p-8">

                    <div
                        class="rounded-2xl border p-5
                                   {{ $detalleEstado['clase'] }}">
                        <p class="font-extrabold">
                            {{ $detalleEstado['titulo'] }}
                        </p>

                        <p class="mt-2 text-sm leading-6">
                            {{ $detalleEstado['descripcion'] }}
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        <div
                            class="rounded-2xl border border-gray-200
                                       bg-gray-50 p-5">
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                Remitente
                            </p>

                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $remitente }}
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-gray-200
                                       bg-gray-50 p-5">
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                Fecha de presentación
                            </p>

                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $tramite->created_at->format('d/m/Y') }}
                                a las
                                {{ $tramite->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                Tipo de documento
                            </p>

                            <p class="mt-2 font-bold text-emerald-950">
                                {{ $tramite->tipo_documento }}
                            </p>
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                Número del documento
                            </p>

                            <p class="mt-2 font-bold text-emerald-950">
                                {{ $tramite->numero_documento_presentado ?: 'No registrado' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500">
                            Asunto
                        </p>

                        <p class="mt-2 font-extrabold text-emerald-950">
                            {{ $tramite->asunto }}
                        </p>
                    </div>

                    @if ($tramite->descripcion)

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                            Descripción
                        </p>

                        <div
                            class="mt-2 rounded-2xl border
                                           border-gray-200 bg-gray-50
                                           p-5 text-sm leading-7 text-gray-700">
                            {{ $tramite->descripcion }}
                        </div>
                    </div>

                    @endif

                    @if ($tramite->observacion)

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-emerald-700">
                            Observación institucional
                        </p>

                        <div
                            class="mt-2 rounded-2xl border
                                           border-emerald-200 bg-emerald-50
                                           p-5 leading-7 text-emerald-900">
                            {{ $tramite->observacion }}
                        </div>
                    </div>

                    @else

                    <div
                        class="rounded-2xl border border-amber-200
                                       bg-amber-50 p-5">
                        <p class="font-extrabold text-amber-900">
                            Sin observaciones registradas
                        </p>

                        <p class="mt-2 text-sm leading-6 text-amber-800">
                            La institución todavía no ha añadido
                            observaciones sobre este trámite.
                        </p>
                    </div>

                    @endif

                    @if ($tramite->fecha_atencion)

                    <p class="text-sm text-gray-500">
                        Fecha de atención:
                        <strong>
                            {{ $tramite->fecha_atencion->format('d/m/Y H:i') }}
                        </strong>
                    </p>

                    @endif

                    @if ($tramite->fecha_cierre)

                    <p class="text-sm text-gray-500">
                        Fecha de cierre:
                        <strong>
                            {{ $tramite->fecha_cierre->format('d/m/Y H:i') }}
                        </strong>
                    </p>

                    @endif
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const resultado =
                        document.getElementById('resultado-tramite');

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