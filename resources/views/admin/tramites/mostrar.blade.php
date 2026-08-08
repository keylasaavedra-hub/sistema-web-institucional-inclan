<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Mesa de Partes
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Detalle del trámite
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Revisión y atención de la solicitud registrada
                </p>
            </div>

            <a
                href="{{ route('admin.tramites.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl border border-gray-300 bg-white
                       px-4 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    @php
    $estados = [
    'recibido' => [
    'texto' => 'Recibido',
    'clase' => 'border-blue-200 bg-blue-50 text-blue-800',
    ],
    'en_revision' => [
    'texto' => 'En revisión',
    'clase' => 'border-amber-200 bg-amber-50 text-amber-800',
    ],
    'derivado' => [
    'texto' => 'Derivado',
    'clase' => 'border-violet-200 bg-violet-50 text-violet-800',
    ],
    'observado' => [
    'texto' => 'Observado',
    'clase' => 'border-red-200 bg-red-50 text-red-800',
    ],
    'atendido' => [
    'texto' => 'Atendido',
    'clase' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
    ],
    'cerrado' => [
    'texto' => 'Cerrado',
    'clase' => 'border-gray-300 bg-gray-100 text-gray-800',
    ],
    ];

    $detalleEstado = $estados[$tramite->estado] ?? [
    'texto' => ucfirst(str_replace('_', ' ', $tramite->estado)),
    'clase' => 'border-gray-200 bg-gray-50 text-gray-800',
    ];

    $solicitante = $tramite->tipo_persona === 'juridica'
    ? ($tramite->razon_social ?: 'Persona jurídica')
    : trim("{$tramite->nombres} {$tramite->apellidos}");

    $tamanioArchivo = null;

    if ($tramite->archivo_tamanio) {
    $tamanioArchivo = $tramite->archivo_tamanio >= 1048576
    ? number_format($tramite->archivo_tamanio / 1048576, 2) . ' MB'
    : number_format($tramite->archivo_tamanio / 1024, 2) . ' KB';
    }
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('mensaje'))
            <div
                class="mb-7 rounded-2xl border border-emerald-200
                           bg-emerald-50 p-5 text-emerald-800">
                <p class="font-extrabold">
                    {{ session('mensaje') }}
                </p>
            </div>
            @endif

            @if (session('error'))
            <div
                class="mb-7 rounded-2xl border border-red-200
               bg-red-50 p-5 text-red-800">
                <p class="font-extrabold">
                    {{ session('error') }}
                </p>
            </div>
            @endif

            @if ($errors->any())
            <div
                class="mb-7 rounded-2xl border border-red-200
                           bg-red-50 p-5">
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

            <div class="grid gap-8 xl:grid-cols-[1.15fr_0.85fr]">

                {{-- INFORMACIÓN DEL TRÁMITE --}}
                <section
                    class="overflow-hidden rounded-[28px]
                           border border-gray-200 bg-white
                           shadow-[0_18px_50px_rgba(15,23,42,0.06)]">
                    <div
                        class="flex flex-col gap-5 bg-emerald-950
                               p-6 text-white sm:flex-row
                               sm:items-center sm:justify-between sm:p-8">
                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-300">
                                Código de seguimiento
                            </p>

                            <h3 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                                {{ $tramite->codigo }}
                            </h3>
                        </div>

                        <span
                            class="inline-flex w-fit rounded-full border
                                   px-4 py-2 text-sm font-extrabold
                                   {{ $detalleEstado['clase'] }}">
                            {{ $detalleEstado['texto'] }}
                        </span>
                    </div>

                    <div class="space-y-8 p-6 sm:p-8">

                        {{-- DATOS GENERALES --}}
                        <div>
                            <h4 class="text-lg font-extrabold text-emerald-950">
                                Información del solicitante
                            </h4>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                <div
                                    class="rounded-2xl border border-gray-200
                                           bg-gray-50 p-5">
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Tipo de persona
                                    </p>

                                    <p class="mt-2 font-extrabold text-emerald-950">
                                        {{ $tramite->tipo_persona === 'juridica'
                                            ? 'Persona jurídica'
                                            : 'Persona natural' }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-2xl border border-gray-200
                                           bg-gray-50 p-5">
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Solicitante
                                    </p>

                                    <p class="mt-2 font-extrabold text-emerald-950">
                                        {{ $solicitante ?: 'No registrado' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Documento de identidad
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ strtoupper($tramite->tipo_documento_identidad ?? 'Documento') }}
                                        {{ $tramite->numero_documento ?: 'No registrado' }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Correo electrónico
                                    </p>

                                    <p class="mt-2 break-all font-bold text-emerald-950">
                                        {{ $tramite->correo }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Teléfono
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ $tramite->telefono ?: 'No registrado' }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Dirección
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ $tramite->direccion ?: 'No registrada' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- DATOS DEL DOCUMENTO --}}
                        <div>
                            <h4 class="text-lg font-extrabold text-emerald-950">
                                Documento presentado
                            </h4>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                <div
                                    class="rounded-2xl border border-gray-200
                                           bg-gray-50 p-5">
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Tipo de documento
                                    </p>

                                    <p class="mt-2 font-extrabold text-emerald-950">
                                        {{ $tramite->tipo_documento }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-2xl border border-gray-200
                                           bg-gray-50 p-5">
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.14em] text-gray-500">
                                        Número del documento
                                    </p>

                                    <p class="mt-2 font-extrabold text-emerald-950">
                                        {{ $tramite->numero_documento_presentado ?: 'Sin número' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Asunto
                                </p>

                                <p class="mt-2 text-lg font-extrabold text-emerald-950">
                                    {{ $tramite->asunto }}
                                </p>
                            </div>

                            <div class="mt-5">
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-gray-500">
                                    Descripción
                                </p>

                                <div
                                    class="mt-2 whitespace-pre-line rounded-2xl
                                           border border-gray-200 bg-gray-50
                                           p-5 leading-7 text-gray-700">
                                    {{ $tramite->descripcion ?: 'Sin descripción registrada.' }}
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- ARCHIVO --}}
                        <div>
                            <h4 class="text-lg font-extrabold text-emerald-950">
                                Archivo adjunto
                            </h4>

                            @if ($tramite->archivo_ruta)
                            <div
                                class="mt-5 flex flex-col gap-4 rounded-2xl
                                           border border-emerald-200
                                           bg-emerald-50 p-5
                                           sm:flex-row sm:items-center
                                           sm:justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-12 w-12 shrink-0
                                                   items-center justify-center
                                                   rounded-xl bg-red-50 text-red-700">
                                        <svg
                                            class="h-6 w-6"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8">
                                            <path d="M6 3h9l3 3v15H6z" />
                                            <path d="M14 3v4h4" />
                                            <path d="M9 13h6M9 17h4" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="break-all font-extrabold text-emerald-950">
                                            {{ $tramite->archivo_original ?: 'Documento adjunto' }}
                                        </p>

                                        <p class="mt-1 text-sm text-emerald-700">
                                            {{ $tamanioArchivo ?: 'Tamaño no disponible' }}
                                        </p>
                                    </div>
                                </div>

                                <a
                                    href="{{ route('admin.tramites.descargar', $tramite->id) }}"
                                    class="inline-flex shrink-0 items-center
                                               justify-center gap-2 rounded-xl
                                               bg-emerald-950 px-5 py-3
                                               text-sm font-extrabold text-white
                                               transition hover:bg-emerald-900">
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path d="M12 3v12" />
                                        <path d="m7 10 5 5 5-5" />
                                        <path d="M5 21h14" />
                                    </svg>

                                    Descargar archivo
                                </a>
                            </div>
                            @else
                            <div
                                class="mt-5 rounded-2xl border border-gray-200
                                           bg-gray-50 p-5 text-gray-600">
                                Este trámite no tiene un archivo adjunto.
                            </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- FECHAS --}}
                        <div>
                            <h4 class="text-lg font-extrabold text-emerald-950">
                                Historial de atención
                            </h4>

                            <div class="mt-5 grid gap-5 sm:grid-cols-3">
                                <div>
                                    <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                        Registrado
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ $tramite->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                        Atendido
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ $tramite->fecha_atencion
                                            ? $tramite->fecha_atencion->format('d/m/Y H:i')
                                            : 'Pendiente' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-gray-500">
                                        Cerrado
                                    </p>

                                    <p class="mt-2 font-bold text-emerald-950">
                                        {{ $tramite->fecha_cierre
                                            ? $tramite->fecha_cierre->format('d/m/Y H:i')
                                            : 'Pendiente' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($tramite->observacion)
                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                           tracking-[0.14em] text-amber-700">
                                Observación administrativa actual
                            </p>

                            <div
                                class="mt-2 whitespace-pre-line rounded-2xl
                                           border border-amber-200 bg-amber-50
                                           p-5 leading-7 text-amber-900">
                                {{ $tramite->observacion }}
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                @if (
                auth()->user()->esAdministrador()
                || auth()->user()->tienePermiso('solicitudes.atender')
                )

                {{-- FORMULARIO DE ATENCIÓN --}}
                <aside
                    class="h-fit rounded-[28px] border border-amber-200
                           bg-white p-6
                           shadow-[0_18px_50px_rgba(6,78,59,0.08)]
                           sm:p-8">
                    <div class="border-b border-gray-100 pb-6">
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600">
                            Atención administrativa
                        </p>

                        <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                            Actualizar trámite
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Cambia el estado y registra una observación que podrá
                            visualizarse en el seguimiento público.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.tramites.actualizar', $tramite->id) }}"
                        class="mt-7 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label
                                for="estado"
                                class="text-sm font-extrabold text-emerald-950">
                                Estado del trámite
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">
                                <option
                                    value="recibido"
                                    @selected(old('estado', $tramite->estado) === 'recibido')
                                    >
                                    Recibido
                                </option>

                                <option
                                    value="en_revision"
                                    @selected(old('estado', $tramite->estado) === 'en_revision')
                                    >
                                    En revisión
                                </option>

                                <option
                                    value="derivado"
                                    @selected(old('estado', $tramite->estado) === 'derivado')
                                    >
                                    Derivado
                                </option>

                                <option
                                    value="observado"
                                    @selected(old('estado', $tramite->estado) === 'observado')
                                    >
                                    Observado
                                </option>

                                <option
                                    value="atendido"
                                    @selected(old('estado', $tramite->estado) === 'atendido')
                                    >
                                    Atendido
                                </option>

                                <option
                                    value="cerrado"
                                    @selected(old('estado', $tramite->estado) === 'cerrado')
                                    >
                                    Cerrado
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                for="observacion"
                                class="text-sm font-extrabold text-emerald-950">
                                Observación administrativa
                            </label>

                            <textarea
                                id="observacion"
                                name="observacion"
                                rows="11"
                                maxlength="3000"
                                placeholder="Escribe una observación, indicación o resultado de la atención..."
                                class="mt-2 w-full resize-y rounded-xl
                                       border-gray-300 px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700">{{ old('observacion', $tramite->observacion) }}</textarea>

                            <p class="mt-2 text-xs text-gray-500">
                                Máximo 3000 caracteres.
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-amber-200
                                   bg-amber-50 p-4">
                            <p class="text-sm font-extrabold text-amber-900">
                                Consideraciones
                            </p>

                            <p class="mt-2 text-xs leading-5 text-amber-800">
                                Al marcar el trámite como atendido se registrará
                                automáticamente la fecha de atención. Al marcarlo
                                como cerrado se registrará también la fecha de cierre.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center
                                   justify-center rounded-xl bg-emerald-950
                                   px-6 py-4 font-extrabold text-white
                                   transition hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200">
                            Guardar cambios
                        </button>
                    </form>
                </aside>
                @else
                <aside
                    class="h-fit rounded-[28px] border border-gray-200
               bg-white p-6
               shadow-[0_18px_50px_rgba(15,23,42,0.06)]
               sm:p-8">
                    <p
                        class="text-xs font-extrabold uppercase
                   tracking-[0.16em] text-gray-500">
                        Modo consulta
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold text-emerald-950">
                        Acceso de solo lectura
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Puedes revisar los datos y descargar el documento
                        presentado, pero tu rol no tiene permiso para modificar
                        el estado ni registrar observaciones.
                    </p>
                </aside>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>