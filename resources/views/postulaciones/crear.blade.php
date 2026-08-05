<x-public-layout>

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('convocatorias.mostrar', $convocatoria) }}"
                class="inline-flex items-center gap-2 font-extrabold
                       text-emerald-800 hover:text-emerald-950"
            >
                ← Volver a la convocatoria
            </a>

            <div class="mt-6 overflow-hidden rounded-[30px]
                        border border-gray-200 bg-white
                        shadow-[0_20px_55px_rgba(15,23,42,0.08)]">

                <header class="bg-emerald-950 p-7 text-white sm:p-9">
                    <p class="text-xs font-extrabold uppercase
                              tracking-[0.18em] text-amber-300">
                        Formulario de postulación
                    </p>

                    <h1 class="mt-3 text-3xl font-extrabold">
                        {{ $convocatoria->titulo }}
                    </h1>

                    <div class="mt-5 flex flex-wrap gap-3 text-sm">
                        <span class="rounded-full bg-white/10 px-4 py-2 font-bold">
                            Código: {{ $convocatoria->codigo }}
                        </span>

                        <span class="rounded-full bg-white/10 px-4 py-2 font-bold">
                            {{ $convocatoria->vacantes }}
                            {{ $convocatoria->vacantes === 1 ? 'vacante' : 'vacantes' }}
                        </span>

                        <span class="rounded-full bg-white/10 px-4 py-2 font-bold">
                            Cierre:
                            {{ $convocatoria->fecha_cierre->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </header>

                <div class="p-6 sm:p-9">

                    @if ($errors->any())
                        <div class="mb-8 rounded-2xl border border-red-200
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

                    <div class="mb-8 rounded-2xl border border-amber-200
                                bg-amber-50 p-5">
                        <p class="font-extrabold text-amber-900">
                            Antes de continuar
                        </p>

                        <p class="mt-2 text-sm leading-6 text-amber-800">
                            Verifica que tus datos sean correctos. Solo se permite
                            una postulación por DNI en esta convocatoria. Al finalizar
                            recibirás un código de seguimiento.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('postulaciones.guardar', $convocatoria) }}"
                        class="space-y-9"
                    >
                        @csrf

                        <section>
                            <div class="border-b border-gray-100 pb-4">
                                <p class="text-xs font-extrabold uppercase
                                          tracking-[0.16em] text-amber-600">
                                    Paso 1
                                </p>

                                <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                                    Información personal
                                </h2>
                            </div>

                            <div class="mt-6 grid gap-6 md:grid-cols-2">
                                <div>
                                    <label
                                        for="tipo_postulante"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Tipo de postulante
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="tipo_postulante"
                                        name="tipo_postulante"
                                        required
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                        <option value="">Selecciona una opción</option>

                                        <option
                                            value="estudiante"
                                            @selected(old('tipo_postulante') === 'estudiante')
                                        >
                                            Estudiante
                                        </option>

                                        <option
                                            value="egresado"
                                            @selected(old('tipo_postulante') === 'egresado')
                                        >
                                            Egresado
                                        </option>

                                        <option
                                            value="profesional"
                                            @selected(old('tipo_postulante') === 'profesional')
                                        >
                                            Profesional
                                        </option>

                                        <option
                                            value="otro"
                                            @selected(old('tipo_postulante') === 'otro')
                                        >
                                            Otro
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="dni"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        DNI
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="dni"
                                        name="dni"
                                        type="text"
                                        inputmode="numeric"
                                        maxlength="8"
                                        minlength="8"
                                        pattern="[0-9]{8}"
                                        required
                                        value="{{ old('dni') }}"
                                        placeholder="8 dígitos"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="nombres"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Nombres
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="nombres"
                                        name="nombres"
                                        type="text"
                                        maxlength="120"
                                        required
                                        value="{{ old('nombres') }}"
                                        placeholder="Ingresa tus nombres"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="apellidos"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Apellidos
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="apellidos"
                                        name="apellidos"
                                        type="text"
                                        maxlength="120"
                                        required
                                        value="{{ old('apellidos') }}"
                                        placeholder="Ingresa tus apellidos"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
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
                                        maxlength="150"
                                        required
                                        value="{{ old('correo') }}"
                                        placeholder="correo@ejemplo.com"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
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
                                        inputmode="tel"
                                        maxlength="20"
                                        value="{{ old('telefono') }}"
                                        placeholder="Número de contacto"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>

                            <div class="mt-6">
                                <label
                                    for="direccion"
                                    class="text-sm font-extrabold text-emerald-950"
                                >
                                    Dirección
                                </label>

                                <input
                                    id="direccion"
                                    name="direccion"
                                    type="text"
                                    maxlength="250"
                                    value="{{ old('direccion') }}"
                                    placeholder="Dirección actual"
                                    class="mt-2 w-full rounded-xl border-gray-300
                                           px-4 py-3 shadow-sm
                                           focus:border-emerald-700
                                           focus:ring-emerald-700"
                                >
                            </div>
                        </section>

                        <section>
                            <div class="border-b border-gray-100 pb-4">
                                <p class="text-xs font-extrabold uppercase
                                          tracking-[0.16em] text-amber-600">
                                    Paso 2
                                </p>

                                <h2 class="mt-1 text-xl font-extrabold text-emerald-950">
                                    Información académica
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Completa estos campos cuando correspondan a tu postulación.
                                </p>
                            </div>

                            <div class="mt-6 grid gap-6 md:grid-cols-2">
                                <div>
                                    <label
                                        for="universidad"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Universidad o instituto
                                    </label>

                                    <input
                                        id="universidad"
                                        name="universidad"
                                        type="text"
                                        maxlength="200"
                                        value="{{ old('universidad') }}"
                                        placeholder="Nombre de la institución educativa"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="carrera"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Carrera o especialidad
                                    </label>

                                    <input
                                        id="carrera"
                                        name="carrera"
                                        type="text"
                                        maxlength="180"
                                        value="{{ old('carrera') }}"
                                        placeholder="Carrera profesional o técnica"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="ciclo"
                                        class="text-sm font-extrabold text-emerald-950"
                                    >
                                        Ciclo académico
                                    </label>

                                    <input
                                        id="ciclo"
                                        name="ciclo"
                                        type="number"
                                        min="1"
                                        max="20"
                                        value="{{ old('ciclo') }}"
                                        placeholder="Ejemplo: 8"
                                        class="mt-2 w-full rounded-xl border-gray-300
                                               px-4 py-3 shadow-sm
                                               focus:border-emerald-700
                                               focus:ring-emerald-700"
                                    >
                                </div>
                            </div>
                        </section>

                        <section
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-5"
                        >
                            <label class="flex cursor-pointer items-start gap-4">
                                <input
                                    type="checkbox"
                                    required
                                    class="mt-1 rounded border-gray-300
                                           text-emerald-700
                                           focus:ring-emerald-600"
                                >

                                <span>
                                    <span class="block font-extrabold text-emerald-950">
                                        Declaración de veracidad
                                    </span>

                                    <span class="mt-1 block text-sm leading-6 text-gray-600">
                                        Declaro que la información registrada es verdadera
                                        y autorizo su uso para la evaluación de esta postulación.
                                    </span>
                                </span>
                            </label>
                        </section>

                        <div class="flex flex-col-reverse gap-3
                                    border-t border-gray-100 pt-7
                                    sm:flex-row sm:justify-end">
                            <a
                                href="{{ route('convocatorias.mostrar', $convocatoria) }}"
                                class="inline-flex items-center justify-center
                                       rounded-xl border border-gray-300 bg-white
                                       px-6 py-3 font-extrabold text-gray-700
                                       transition hover:bg-gray-50"
                            >
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                       rounded-xl bg-emerald-950 px-7 py-3
                                       font-extrabold text-white transition
                                       hover:bg-emerald-900
                                       focus:outline-none focus:ring-4
                                       focus:ring-emerald-200"
                            >
                                Enviar postulación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>