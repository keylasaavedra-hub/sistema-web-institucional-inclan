<x-public-layout>

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Oportunidades institucionales
                </p>

                <h1 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Convocatorias
                </h1>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Consulta los procesos vigentes publicados por la institución.
                </p>

                <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                    <a
                        href="{{ route('postulaciones.seguimiento') }}"
                        class="inline-flex items-center justify-center
               rounded-xl border border-emerald-200
               bg-white px-5 py-3
               font-extrabold text-emerald-800 transition
               hover:bg-emerald-50">
                        Consultar postulación
                    </a>

                    <a
                        href="{{ route('postulaciones.resultados') }}"
                        class="inline-flex items-center justify-center
               rounded-xl bg-amber-500 px-5 py-3
               font-extrabold text-emerald-950 transition
               hover:bg-amber-400">
                        Ver resultados
                    </a>
                </div>
            </div>

            <form
                method="GET"
                action="{{ route('convocatorias.index') }}"
                class="mx-auto mt-10 grid max-w-5xl gap-4 rounded-[26px]
                       border border-amber-200 bg-white p-6
                       shadow-[0_18px_50px_rgba(6,78,59,0.08)]
                       md:grid-cols-[1fr_240px_auto]">
                <input
                    name="buscar"
                    type="text"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por título, código o descripción..."
                    class="rounded-xl border-gray-300 px-4 py-3
                           focus:border-emerald-700 focus:ring-emerald-700">

                <select
                    name="tipo"
                    class="rounded-xl border-gray-300 px-4 py-3
                           focus:border-emerald-700 focus:ring-emerald-700">
                    <option value="">Todos los tipos</option>
                    <option value="practicas" @selected(request('tipo')==='practicas' )>
                        Prácticas
                    </option>
                    <option value="laboral" @selected(request('tipo')==='laboral' )>
                        Laboral
                    </option>
                    <option value="cas" @selected(request('tipo')==='cas' )>
                        CAS
                    </option>
                    <option value="servicios" @selected(request('tipo')==='servicios' )>
                        Servicios
                    </option>
                    <option value="voluntariado" @selected(request('tipo')==='voluntariado' )>
                        Voluntariado
                    </option>
                    <option value="otro" @selected(request('tipo')==='otro' )>
                        Otro
                    </option>
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-emerald-950 px-6 py-3
                           font-extrabold text-white transition
                           hover:bg-emerald-900">
                    Buscar
                </button>
            </form>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($convocatorias as $convocatoria)

                <article
                    class="flex h-full flex-col rounded-[26px]
                               border border-gray-200 bg-white p-6
                               shadow-[0_16px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex items-start justify-between gap-3">
                        <span
                            class="rounded-full border border-emerald-200
                                       bg-emerald-50 px-3 py-1
                                       text-xs font-extrabold text-emerald-800">
                            {{ ucfirst($convocatoria->tipo) }}
                        </span>

                        @if ($convocatoria->destacada)
                        <span
                            class="rounded-full bg-amber-100 px-3 py-1
                                           text-xs font-extrabold text-amber-800">
                            Destacada
                        </span>
                        @endif
                    </div>

                    <h2 class="mt-5 text-xl font-extrabold text-emerald-950">
                        {{ $convocatoria->titulo }}
                    </h2>

                    <p class="mt-3 flex-1 leading-7 text-gray-600">
                        {{ \Illuminate\Support\Str::limit($convocatoria->descripcion, 180) }}
                    </p>

                    <div class="mt-6 space-y-2 text-sm text-gray-600">
                        <p>
                            <strong class="text-emerald-950">Área:</strong>
                            {{ $convocatoria->area?->nombre ?: 'No especificada' }}
                        </p>

                        <p>
                            <strong class="text-emerald-950">Vacantes:</strong>
                            {{ $convocatoria->vacantes }}
                        </p>

                        <p>
                            <strong class="text-emerald-950">Cierre:</strong>
                            {{ $convocatoria->fecha_cierre->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <a
                            href="{{ route('convocatorias.mostrar', $convocatoria) }}"
                            class="inline-flex items-center justify-center
               rounded-xl border border-emerald-200
               bg-emerald-50 px-5 py-3
               font-extrabold text-emerald-800 transition
               hover:bg-emerald-100">
                            Ver detalles
                        </a>

                        @if (
                        now()->between(
                        $convocatoria->fecha_inicio,
                        $convocatoria->fecha_cierre
                        )
                        )
                        <a
                            href="{{ route('postulaciones.crear', $convocatoria) }}"
                            class="inline-flex items-center justify-center
                   rounded-xl bg-emerald-950 px-5 py-3
                   font-extrabold text-white transition
                   hover:bg-emerald-900">
                            Postular
                        </a>
                        @elseif (now()->lt($convocatoria->fecha_inicio))
                        <span
                            class="inline-flex items-center justify-center
                   rounded-xl bg-blue-50 px-5 py-3
                   text-center font-extrabold text-blue-700">
                            Próximamente
                        </span>
                        @else
                        <span
                            class="inline-flex items-center justify-center
                   rounded-xl bg-gray-100 px-5 py-3
                   text-center font-extrabold text-gray-600">
                            Convocatoria cerrada
                        </span>
                        @endif
                    </div>
                </article>

                @empty

                <div
                    class="col-span-full rounded-[26px] border border-gray-200
                               bg-white px-6 py-16 text-center">
                    <h2 class="text-2xl font-extrabold text-emerald-950">
                        No hay convocatorias disponibles
                    </h2>

                    <p class="mt-3 text-gray-600">
                        No existen procesos publicados que coincidan con la búsqueda.
                    </p>
                </div>

                @endforelse
            </div>

            <div class="mt-8">
                {{ $convocatorias->links() }}
            </div>
        </div>
    </section>

</x-public-layout>