<x-public-layout>

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Resultados institucionales
                </p>

                <h1 class="mt-3 text-4xl font-extrabold text-emerald-950">
                    Resultados de convocatorias
                </h1>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Consulta las postulaciones declaradas aptas y seleccionadas
                    en los procesos publicados por la institución.
                </p>
            </div>

            <div class="mt-10 space-y-8">

                @forelse ($convocatorias as $convocatoria)

                    <article
                        class="overflow-hidden rounded-[28px]
                               border border-gray-200 bg-white
                               shadow-[0_18px_50px_rgba(15,23,42,0.07)]"
                    >
                        <header
                            class="flex flex-col gap-4 bg-emerald-950
                                   p-6 text-white sm:flex-row
                                   sm:items-center sm:justify-between sm:p-8"
                        >
                            <div>
                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.16em] text-amber-300"
                                >
                                    {{ $convocatoria->codigo }}
                                </p>

                                <h2 class="mt-2 text-2xl font-extrabold">
                                    {{ $convocatoria->titulo }}
                                </h2>

                                <p class="mt-2 text-sm text-emerald-100">
                                    Cierre:
                                    {{ $convocatoria->fecha_cierre->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <a
                                href="{{ route('convocatorias.mostrar', $convocatoria) }}"
                                class="inline-flex w-fit items-center justify-center
                                       rounded-xl border border-white/20 bg-white/10
                                       px-5 py-3 text-sm font-extrabold
                                       text-white transition hover:bg-white/20"
                            >
                                Ver convocatoria
                            </a>
                        </header>

                        <div class="p-6 sm:p-8">

                            @php
                                $seleccionadas = $convocatoria->postulaciones
                                    ->where('estado', 'seleccionada');

                                $aptas = $convocatoria->postulaciones
                                    ->where('estado', 'apta');
                            @endphp

                            @if ($seleccionadas->isNotEmpty())

                                <section>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center
                                                   rounded-xl bg-amber-100 text-amber-800"
                                        >
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M8 21h8"/>
                                                <path d="M12 17v4"/>
                                                <path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"/>
                                                <path d="M5 6H3v1a4 4 0 0 0 4 4"/>
                                                <path d="M19 6h2v1a4 4 0 0 1-4 4"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <h3 class="text-xl font-extrabold text-emerald-950">
                                                Postulantes seleccionados
                                            </h3>

                                            <p class="text-sm text-gray-500">
                                                Personas seleccionadas para cubrir las vacantes.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-200">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-amber-50">
                                                <tr>
                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-amber-900"
                                                    >
                                                        N.°
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-amber-900"
                                                    >
                                                        Postulante
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-amber-900"
                                                    >
                                                        DNI
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-amber-900"
                                                    >
                                                        Estado
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-gray-100 bg-white">
                                                @foreach ($seleccionadas as $postulacion)
                                                    <tr>
                                                        <td class="px-5 py-4 font-bold text-gray-600">
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <td class="px-5 py-4">
                                                            <p class="font-extrabold text-emerald-950">
                                                                {{ $postulacion->apellidos }},
                                                                {{ $postulacion->nombres }}
                                                            </p>
                                                        </td>

                                                        <td class="px-5 py-4 font-bold text-gray-700">
                                                            {{ substr($postulacion->dni, 0, 4) }}****
                                                        </td>

                                                        <td class="px-5 py-4">
                                                            <span
                                                                class="inline-flex rounded-full
                                                                       border border-amber-200
                                                                       bg-amber-50 px-3 py-1
                                                                       text-xs font-extrabold
                                                                       text-amber-800"
                                                            >
                                                                Seleccionada
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>

                            @endif

                            @if ($aptas->isNotEmpty())

                                <section class="{{ $seleccionadas->isNotEmpty() ? 'mt-8' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center
                                                   rounded-xl bg-emerald-100 text-emerald-800"
                                        >
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <h3 class="text-xl font-extrabold text-emerald-950">
                                                Postulantes aptos
                                            </h3>

                                            <p class="text-sm text-gray-500">
                                                Personas que cumplen los requisitos del proceso.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-200">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-emerald-50">
                                                <tr>
                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-emerald-900"
                                                    >
                                                        N.°
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-emerald-900"
                                                    >
                                                        Postulante
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-emerald-900"
                                                    >
                                                        DNI
                                                    </th>

                                                    <th
                                                        class="px-5 py-4 text-left text-xs
                                                               font-extrabold uppercase tracking-wide
                                                               text-emerald-900"
                                                    >
                                                        Estado
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-gray-100 bg-white">
                                                @foreach ($aptas as $postulacion)
                                                    <tr>
                                                        <td class="px-5 py-4 font-bold text-gray-600">
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <td class="px-5 py-4">
                                                            <p class="font-extrabold text-emerald-950">
                                                                {{ $postulacion->apellidos }},
                                                                {{ $postulacion->nombres }}
                                                            </p>
                                                        </td>

                                                        <td class="px-5 py-4 font-bold text-gray-700">
                                                            {{ substr($postulacion->dni, 0, 4) }}****
                                                        </td>

                                                        <td class="px-5 py-4">
                                                            <span
                                                                class="inline-flex rounded-full
                                                                       border border-emerald-200
                                                                       bg-emerald-50 px-3 py-1
                                                                       text-xs font-extrabold
                                                                       text-emerald-800"
                                                            >
                                                                Apta
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>

                            @endif
                        </div>
                    </article>

                @empty

                    <div
                        class="rounded-[28px] border border-gray-200
                               bg-white px-6 py-16 text-center
                               shadow-[0_18px_50px_rgba(15,23,42,0.06)]"
                    >
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center
                                   rounded-2xl bg-emerald-50 text-emerald-800"
                        >
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M4 5h16v14H4z"/>
                                <path d="M8 9h8M8 13h5"/>
                            </svg>
                        </div>

                        <h2 class="mt-5 text-2xl font-extrabold text-emerald-950">
                            No hay resultados publicados
                        </h2>

                        <p class="mx-auto mt-3 max-w-xl leading-7 text-gray-600">
                            Los resultados aparecerán cuando la institución termine
                            la revisión de las postulaciones.
                        </p>
                    </div>

                @endforelse
            </div>
        </div>
    </section>

</x-public-layout>