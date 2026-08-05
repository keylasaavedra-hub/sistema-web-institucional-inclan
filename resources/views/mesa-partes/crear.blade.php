<x-public-layout title="Mesa de Partes Virtual">

    <section class="relative overflow-hidden bg-gray-50 py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-24
                   h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-16
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

            {{-- NAVEGACIÓN DE MESA DE PARTES --}}
<div
    class="mx-auto mt-10 grid max-w-3xl gap-3 rounded-2xl
           border border-gray-200 bg-white p-2
           shadow-[0_12px_35px_rgba(6,78,59,0.08)]
           sm:grid-cols-2"
>
    <a
        href="{{ route('mesa-partes.crear') }}"
        class="inline-flex items-center justify-center gap-3
               rounded-xl bg-emerald-950 px-5 py-4
               font-extrabold text-white shadow-sm"
    >
        <svg
            class="h-5 w-5 text-amber-300"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <path d="M12 5v14"/>
            <path d="M5 12h14"/>
        </svg>

        Presentar documento
    </a>

    <a
        href="{{ route('mesa-partes.seguimiento') }}"
        class="inline-flex items-center justify-center gap-3
               rounded-xl px-5 py-4 font-extrabold
               text-gray-600 transition
               hover:bg-emerald-50 hover:text-emerald-950"
    >
        <svg
            class="h-5 w-5"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <circle cx="11" cy="11" r="7"/>
            <path d="m20 20-4-4"/>
        </svg>

        Consultar seguimiento
    </a>
</div>

            <div
                class="mt-10 grid gap-10
                       lg:grid-cols-[0.8fr_1.2fr]"
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
                            <path d="M4 4h16v16H4z"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>

                        Trámite documentario
                    </div>

                    <h1
                        class="mt-6 text-4xl font-extrabold
                               tracking-tight text-emerald-950
                               sm:text-5xl"
                    >
                        Mesa de Partes Virtual
                    </h1>

                    <div class="mt-5 flex items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p class="mt-7 text-base leading-8 text-gray-600">
                        Registra documentos, solicitudes y comunicaciones
                        dirigidas a la institución educativa de forma virtual.
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
                                <path d="M6 2h9l5 5v15H6z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M9 13h6M9 17h6"/>
                            </svg>
                        </div>

                        <p
                            class="mt-5 text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-300"
                        >
                            Documento requerido
                        </p>

                        <p class="mt-3 leading-7 text-emerald-100">
                            Adjunta un único archivo en formato PDF. El tamaño
                            máximo permitido es de 10 MB.
                        </p>
                    </div>

                    <div class="mt-6 space-y-4">

                        <div
                            class="flex items-start gap-4 rounded-2xl
                                   border border-emerald-100
                                   bg-white p-5"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center
                                       justify-center rounded-xl
                                       bg-emerald-50 text-emerald-800"
                            >
                                1
                            </div>

                            <div>
                                <p class="font-extrabold text-emerald-950">
                                    Completa tus datos
                                </p>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Registra correctamente la información
                                    del remitente.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-2xl
                                   border border-emerald-100
                                   bg-white p-5"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center
                                       justify-center rounded-xl
                                       bg-emerald-50 text-emerald-800"
                            >
                                2
                            </div>

                            <div>
                                <p class="font-extrabold text-emerald-950">
                                    Adjunta el documento
                                </p>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    El archivo debe estar en formato PDF y ser
                                    legible.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-2xl
                                   border border-amber-200
                                   bg-amber-50 p-5"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center
                                       justify-center rounded-xl
                                       bg-white text-amber-700"
                            >
                                3
                            </div>

                            <div>
                                <p class="font-extrabold text-emerald-950">
                                    Guarda tu código
                                </p>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Al finalizar se generará un código único
                                    de seguimiento.
                                </p>
                            </div>
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

                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600"
                        >
                            Registro virtual
                        </p>

                        <h2
                            class="mt-2 text-2xl font-extrabold
                                   text-emerald-950"
                        >
                            Presenta tu documento
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Los campos marcados con asterisco son obligatorios.
                        </p>
                    </div>

                    @if (session('tramite_enviado'))

                        <div
                            id="mensaje-tramite-enviado"
                            class="mb-8 overflow-hidden rounded-[26px]
                                   border border-emerald-300 bg-emerald-50
                                   shadow-[0_16px_45px_rgba(6,78,59,0.12)]"
                        >
                            <div class="flex items-start gap-4 p-6">

                                <div
                                    class="flex h-14 w-14 shrink-0 items-center
                                           justify-center rounded-2xl
                                           bg-emerald-950 text-amber-300"
                                >
                                    <svg
                                        class="h-7 w-7"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.16em]
                                               text-emerald-700"
                                    >
                                        Documento registrado
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        ¡Tu trámite fue enviado correctamente!
                                    </h3>

                                    <p
                                        class="mt-3 text-sm leading-7
                                               text-emerald-800"
                                    >
                                        Guarda el siguiente código para realizar
                                        el seguimiento del documento presentado.
                                    </p>

                                    <div
                                        class="mt-5 flex flex-col gap-3
                                               rounded-2xl border
                                               border-amber-300 bg-white p-4
                                               sm:flex-row sm:items-center
                                               sm:justify-between"
                                    >
                                        <div>
                                            <p
                                                class="text-xs font-extrabold
                                                       uppercase
                                                       tracking-[0.14em]
                                                       text-gray-500"
                                            >
                                                Código de seguimiento
                                            </p>

                                            <p
                                                id="codigo-tramite"
                                                class="mt-1 break-all text-xl
                                                       font-extrabold
                                                       tracking-wider
                                                       text-emerald-950"
                                            >
                                                {{ session('codigo_tramite') }}
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            onclick="copiarCodigoTramite()"
                                            class="inline-flex items-center
                                                   justify-center gap-2
                                                   rounded-xl bg-emerald-950
                                                   px-5 py-3 text-sm
                                                   font-extrabold text-white
                                                   transition
                                                   hover:bg-emerald-900"
                                        >
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
                        </div>

                    @endif

                    @if ($errors->any())

                        <div
                            class="mb-7 rounded-2xl border border-red-200
                                   bg-red-50 p-5"
                        >
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
                        action="{{ route('mesa-partes.guardar') }}"
                        enctype="multipart/form-data"
                        class="space-y-8"
                    >
                        @csrf

                        {{-- DATOS DEL REMITENTE --}}
                        <div>
                            <div class="mb-5">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.15em]
                                           text-emerald-700"
                                >
                                    1. Datos del remitente
                                </p>

                                <h3
                                    class="mt-1 text-lg font-extrabold
                                           text-emerald-950"
                                >
                                    Identificación
                                </h3>
                            </div>

                            <div>
                                <label
                                    for="tipo_persona"
                                    class="text-sm font-extrabold
                                           text-emerald-950"
                                >
                                    Tipo de persona
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="tipo_persona"
                                    name="tipo_persona"
                                    required
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                                    <option value="natural"
                                        @selected(old('tipo_persona', 'natural') === 'natural')
                                    >
                                        Persona natural
                                    </option>

                                    <option value="juridica"
                                        @selected(old('tipo_persona') === 'juridica')
                                    >
                                        Persona jurídica
                                    </option>
                                </select>
                            </div>

                            <div
                                id="campos-persona-natural"
                                class="mt-5 grid gap-5 sm:grid-cols-2"
                            >
                                <div>
                                    <label
                                        for="nombres"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Nombres
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="nombres"
                                        name="nombres"
                                        type="text"
                                        maxlength="100"
                                        value="{{ old('nombres') }}"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="apellidos"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Apellidos
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="apellidos"
                                        name="apellidos"
                                        type="text"
                                        maxlength="100"
                                        value="{{ old('apellidos') }}"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>

                            <div
                                id="campo-persona-juridica"
                                class="mt-5 hidden"
                            >
                                <label
                                    for="razon_social"
                                    class="text-sm font-extrabold
                                           text-emerald-950"
                                >
                                    Razón social
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="razon_social"
                                    name="razon_social"
                                    type="text"
                                    maxlength="180"
                                    value="{{ old('razon_social') }}"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="tipo_documento_identidad"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Tipo de documento
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="tipo_documento_identidad"
                                        name="tipo_documento_identidad"
                                        required
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                        <option value="">Seleccionar</option>

                                        <option value="dni"
                                            @selected(old('tipo_documento_identidad') === 'dni')
                                        >
                                            DNI
                                        </option>

                                        <option value="ce"
                                            @selected(old('tipo_documento_identidad') === 'ce')
                                        >
                                            Carné de extranjería
                                        </option>

                                        <option value="ruc"
                                            @selected(old('tipo_documento_identidad') === 'ruc')
                                        >
                                            RUC
                                        </option>

                                        <option value="pasaporte"
                                            @selected(old('tipo_documento_identidad') === 'pasaporte')
                                        >
                                            Pasaporte
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="numero_documento"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Número de documento
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="numero_documento"
                                        name="numero_documento"
                                        type="text"
                                        maxlength="20"
                                        required
                                        value="{{ old('numero_documento') }}"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>

                            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="correo"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Correo electrónico
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="correo"
                                        name="correo"
                                        type="email"
                                        maxlength="150"
                                        required
                                        value="{{ old('correo') }}"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="telefono"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Teléfono
                                    </label>

                                    <input
                                        id="telefono"
                                        name="telefono"
                                        type="text"
                                        maxlength="20"
                                        value="{{ old('telefono') }}"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>

                            <div class="mt-5">

                                <label
                                    for="direccion"
                                    class="text-sm font-extrabold
                                           text-emerald-950"
                                >
                                    Dirección
                                </label>

                                <input
                                    id="direccion"
                                    name="direccion"
                                    type="text"
                                    maxlength="250"
                                    value="{{ old('direccion') }}"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- DATOS DEL DOCUMENTO --}}
                        <div>
                            <div class="mb-5">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.15em]
                                           text-emerald-700"
                                >
                                    2. Datos del documento
                                </p>

                                <h3
                                    class="mt-1 text-lg font-extrabold
                                           text-emerald-950"
                                >
                                    Información del trámite
                                </h3>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>
                                    <label
                                        for="tipo_documento"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Tipo de documento
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="tipo_documento"
                                        name="tipo_documento"
                                        required
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                        <option value="">Seleccionar</option>

                                        @foreach ([
                                            'Solicitud',
                                            'Carta',
                                            'Oficio',
                                            'Informe',
                                            'Memorando',
                                            'Expediente',
                                            'Reclamo',
                                            'Otro',
                                        ] as $tipo)

                                            <option
                                                value="{{ $tipo }}"
                                                @selected(old('tipo_documento') === $tipo)
                                            >
                                                {{ $tipo }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="numero_documento_presentado"
                                        class="text-sm font-extrabold
                                               text-emerald-950"
                                    >
                                        Número del documento
                                    </label>

                                    <input
                                        id="numero_documento_presentado"
                                        name="numero_documento_presentado"
                                        type="text"
                                        maxlength="50"
                                        value="{{ old('numero_documento_presentado') }}"
                                        placeholder="Ejemplo: Carta N.° 001-2026"
                                        class="mt-2 w-full rounded-xl
                                               border-gray-300 bg-white
                                               px-4 py-3 text-gray-800
                                               shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>

                            <div class="mt-5">

                                <label
                                    for="asunto"
                                    class="text-sm font-extrabold
                                           text-emerald-950"
                                >
                                    Asunto
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="asunto"
                                    name="asunto"
                                    type="text"
                                    maxlength="200"
                                    required
                                    value="{{ old('asunto') }}"
                                    placeholder="Indica brevemente el motivo"
                                    class="mt-2 w-full rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>

                            <div class="mt-5">

                                <label
                                    for="descripcion"
                                    class="text-sm font-extrabold
                                           text-emerald-950"
                                >
                                    Descripción adicional
                                </label>

                                <textarea
                                    id="descripcion"
                                    name="descripcion"
                                    rows="5"
                                    maxlength="3000"
                                    placeholder="Agrega información complementaria..."
                                    class="mt-2 w-full resize-y rounded-xl
                                           border-gray-300 bg-white
                                           px-4 py-3 text-gray-800 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- ARCHIVO --}}
                        <div>
                            <div class="mb-5">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.15em]
                                           text-emerald-700"
                                >
                                    3. Documento adjunto
                                </p>

                                <h3
                                    class="mt-1 text-lg font-extrabold
                                           text-emerald-950"
                                >
                                    Carga el archivo PDF
                                </h3>
                            </div>

                            <label
                                for="archivo"
                                class="group flex cursor-pointer flex-col
                                       items-center justify-center rounded-2xl
                                       border-2 border-dashed
                                       border-emerald-300 bg-emerald-50/60
                                       px-6 py-10 text-center transition
                                       hover:border-emerald-500
                                       hover:bg-emerald-50"
                            >
                                <svg
                                    class="h-12 w-12 text-emerald-700"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path d="M12 16V4"/>
                                    <path d="m7 9 5-5 5 5"/>
                                    <path d="M5 20h14"/>
                                </svg>

                                <span
                                    class="mt-4 font-extrabold
                                           text-emerald-950"
                                >
                                    Selecciona el documento PDF
                                </span>

                                <span
                                    id="nombre-archivo"
                                    class="mt-2 text-sm text-gray-600"
                                >
                                    Tamaño máximo permitido: 10 MB
                                </span>

                                <input
                                    id="archivo"
                                    name="archivo"
                                    type="file"
                                    accept=".pdf,application/pdf"
                                    required
                                    class="hidden"
                                >
                            </label>
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
                                    Declaro que la información y el documento
                                    adjunto son correctos y autorizo su
                                    tratamiento para la atención del trámite.
                                </span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-emerald-950 px-6 py-4
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900
                                   focus:outline-none focus:ring-4
                                   focus:ring-emerald-200"
                        >
                            Presentar documento

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipoPersona = document.getElementById('tipo_persona');
            const camposNatural = document.getElementById(
                'campos-persona-natural'
            );
            const campoJuridica = document.getElementById(
                'campo-persona-juridica'
            );
            const nombres = document.getElementById('nombres');
            const apellidos = document.getElementById('apellidos');
            const razonSocial = document.getElementById('razon_social');
            const archivo = document.getElementById('archivo');
            const nombreArchivo = document.getElementById('nombre-archivo');

            function actualizarTipoPersona() {
                const esNatural = tipoPersona.value === 'natural';

                camposNatural.classList.toggle('hidden', !esNatural);
                campoJuridica.classList.toggle('hidden', esNatural);

                nombres.required = esNatural;
                apellidos.required = esNatural;
                razonSocial.required = !esNatural;
            }

            actualizarTipoPersona();

            tipoPersona.addEventListener(
                'change',
                actualizarTipoPersona
            );

            archivo.addEventListener('change', function () {
                if (archivo.files.length > 0) {
                    nombreArchivo.textContent =
                        archivo.files[0].name;
                } else {
                    nombreArchivo.textContent =
                        'Tamaño máximo permitido: 10 MB';
                }
            });

            const mensaje = document.getElementById(
                'mensaje-tramite-enviado'
            );

            if (mensaje) {
                mensaje.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });

        function copiarCodigoTramite() {
            const elemento = document.getElementById('codigo-tramite');
            const confirmacion = document.getElementById('mensaje-copiado');

            if (!elemento) {
                return;
            }

            const codigo = elemento.textContent.trim();

            navigator.clipboard.writeText(codigo)
                .then(function () {
                    confirmacion.classList.remove('hidden');

                    setTimeout(function () {
                        confirmacion.classList.add('hidden');
                    }, 3000);
                })
                .catch(function () {
                    window.prompt(
                        'Copia tu código de seguimiento:',
                        codigo
                    );
                });
        }
    </script>

</x-public-layout>