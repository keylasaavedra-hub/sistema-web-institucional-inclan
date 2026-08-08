<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-600">
                    Convocatorias
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950">
                    Registrar convocatoria
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Publica un nuevo proceso institucional
                </p>
            </div>

            <a
                href="{{ route('admin.convocatorias.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2
                       rounded-xl border border-gray-300 bg-white
                       px-4 py-3 text-sm font-extrabold text-gray-700
                       transition hover:bg-gray-50"
            >
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

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

            @if (session('error'))
                <div class="mb-7 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <p class="font-extrabold text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.convocatorias.store') }}"
                class="overflow-hidden rounded-[28px]
                       border border-gray-200 bg-white
                       shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
            >
                @csrf

                <div class="bg-emerald-950 p-7 text-white sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-amber-300">
                        Nuevo proceso
                    </p>

                    <h3 class="mt-2 text-2xl font-extrabold">
                        Información de la convocatoria
                    </h3>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-100">
                        Las convocatorias publicadas podrán mostrarse en el portal institucional.
                    </p>
                </div>

                <div class="space-y-8 p-6 sm:p-8">

                    {{-- TIPO Y VACANTES --}}
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                for="tipo"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Tipo de convocatoria
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="tipo"
                                name="tipo"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                                <option value="">Selecciona una opción</option>

                                <option
                                    value="practicas"
                                    {{ old('tipo') === 'practicas' ? 'selected' : '' }}
                                >
                                    Prácticas
                                </option>

                                <option
                                    value="laboral"
                                    {{ old('tipo') === 'laboral' ? 'selected' : '' }}
                                >
                                    Laboral
                                </option>

                                <option
                                    value="cas"
                                    {{ old('tipo') === 'cas' ? 'selected' : '' }}
                                >
                                    CAS
                                </option>

                                <option
                                    value="servicios"
                                    {{ old('tipo') === 'servicios' ? 'selected' : '' }}
                                >
                                    Servicios
                                </option>

                                <option
                                    value="voluntariado"
                                    {{ old('tipo') === 'voluntariado' ? 'selected' : '' }}
                                >
                                    Voluntariado
                                </option>

                                <option
                                    value="otro"
                                    {{ old('tipo') === 'otro' ? 'selected' : '' }}
                                >
                                    Otro
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                for="vacantes"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Número de vacantes
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="vacantes"
                                name="vacantes"
                                type="number"
                                min="1"
                                max="999"
                                required
                                value="{{ old('vacantes', 1) }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>
                    </div>

                    {{-- TÍTULO --}}
                    <div>
                        <label
                            for="titulo"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Título
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="titulo"
                            name="titulo"
                            type="text"
                            maxlength="220"
                            required
                            value="{{ old('titulo') }}"
                            placeholder="Ejemplo: Convocatoria para practicantes de soporte técnico"
                            class="mt-2 w-full rounded-xl border-gray-300
                                   px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >
                    </div>

                    {{-- ÁREA Y CARGO --}}
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                for="area_id"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Área institucional
                            </label>

                            <select
                                id="area_id"
                                name="area_id"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                                <option value="">
                                    Sin área específica
                                </option>

                                @foreach ($areas as $area)
                                    <option
                                        value="{{ $area->id }}"
                                        {{ (string) old('area_id') === (string) $area->id ? 'selected' : '' }}
                                    >
                                        {{ $area->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label
                                for="cargo_id"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Cargo
                            </label>

                            <select
                                id="cargo_id"
                                name="cargo_id"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                                <option value="">
                                    Sin cargo específico
                                </option>

                                @foreach ($cargos as $cargo)
                                    <option
                                        value="{{ $cargo->id }}"
                                        {{ (string) old('cargo_id') === (string) $cargo->id ? 'selected' : '' }}
                                    >
                                        {{ $cargo->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($cargos->isEmpty())
                                <p class="mt-2 text-xs text-amber-700">
                                    No hay cargos registrados todavía.
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div>
                        <label
                            for="descripcion"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Descripción
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="6"
                            maxlength="5000"
                            required
                            placeholder="Describe el propósito y alcance de la convocatoria..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('descripcion') }}</textarea>
                    </div>

                    {{-- PERFIL --}}
                    <div>
                        <label
                            for="perfil"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Perfil solicitado
                        </label>

                        <textarea
                            id="perfil"
                            name="perfil"
                            rows="5"
                            maxlength="5000"
                            placeholder="Indica las características o experiencia esperada..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('perfil') }}</textarea>
                    </div>

                    {{-- REQUISITOS --}}
                    <div>
                        <label
                            for="requisitos"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Requisitos
                        </label>

                        <textarea
                            id="requisitos"
                            name="requisitos"
                            rows="6"
                            maxlength="5000"
                            placeholder="Escribe un requisito por línea..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('requisitos') }}</textarea>
                    </div>

                    {{-- CRONOGRAMA --}}
                    <div>
                        <label
                            for="cronograma"
                            class="text-sm font-extrabold text-emerald-950"
                        >
                            Cronograma
                        </label>

                        <textarea
                            id="cronograma"
                            name="cronograma"
                            rows="6"
                            maxlength="5000"
                            placeholder="Detalla las etapas y fechas principales del proceso..."
                            class="mt-2 w-full resize-y rounded-xl
                                   border-gray-300 px-4 py-3 shadow-sm
                                   focus:border-emerald-700
                                   focus:ring-emerald-700"
                        >{{ old('cronograma') }}</textarea>
                    </div>

                    {{-- FECHAS --}}
                    <div class="grid gap-6 md:grid-cols-3">
                        <div>
                            <label
                                for="fecha_inicio"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Fecha de inicio
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="fecha_inicio"
                                name="fecha_inicio"
                                type="datetime-local"
                                required
                                value="{{ old('fecha_inicio') }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>

                        <div>
                            <label
                                for="fecha_cierre"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Fecha de cierre
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="fecha_cierre"
                                name="fecha_cierre"
                                type="datetime-local"
                                required
                                value="{{ old('fecha_cierre') }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                        </div>

                        <div>
                            <label
                                for="fecha_publicacion"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Fecha de publicación
                            </label>

                            <input
                                id="fecha_publicacion"
                                name="fecha_publicacion"
                                type="datetime-local"
                                value="{{ old('fecha_publicacion') }}"
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Si publicas sin fecha, se usará la fecha actual.
                            </p>
                        </div>
                    </div>

                    {{-- ESTADO Y DESTACADA --}}
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                for="estado"
                                class="text-sm font-extrabold text-emerald-950"
                            >
                                Estado
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                required
                                class="mt-2 w-full rounded-xl border-gray-300
                                       px-4 py-3 shadow-sm
                                       focus:border-emerald-700
                                       focus:ring-emerald-700"
                            >
                                <option
                                    value="borrador"
                                    {{ old('estado', 'borrador') === 'borrador' ? 'selected' : '' }}
                                >
                                    Borrador
                                </option>

                                <option
                                    value="publicada"
                                    {{ old('estado', 'borrador') === 'publicada' ? 'selected' : '' }}
                                >
                                    Publicada
                                </option>

                                <option
                                    value="cerrada"
                                    {{ old('estado', 'borrador') === 'cerrada' ? 'selected' : '' }}
                                >
                                    Cerrada
                                </option>

                                <option
                                    value="anulada"
                                    {{ old('estado', 'borrador') === 'anulada' ? 'selected' : '' }}
                                >
                                    Anulada
                                </option>
                            </select>
                        </div>

                        <label
                            class="flex cursor-pointer items-start gap-4
                                   rounded-2xl border border-gray-200
                                   bg-gray-50 p-5 transition
                                   hover:border-amber-200 hover:bg-amber-50"
                        >
                            <input
                                type="checkbox"
                                name="destacada"
                                value="1"
                                {{ old('destacada') ? 'checked' : '' }}
                                class="mt-1 rounded border-gray-300
                                       text-amber-600 focus:ring-amber-500"
                            >

                            <span>
                                <span class="block font-extrabold text-emerald-950">
                                    Convocatoria destacada
                                </span>

                                <span class="mt-1 block text-sm leading-6 text-gray-500">
                                    Permitirá resaltar este proceso en el portal público.
                                </span>
                            </span>
                        </label>
                    </div>

                    {{-- BOTONES --}}
                    <div
                        class="flex flex-col-reverse gap-3
                               border-t border-gray-100 pt-7
                               sm:flex-row sm:justify-end"
                    >
                        <a
                            href="{{ route('admin.convocatorias.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl border border-gray-300
                                   bg-white px-6 py-3 font-extrabold
                                   text-gray-700 transition hover:bg-gray-50"
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
                            Registrar convocatoria
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>