<x-public-layout title="Calendario institucional">

    @php
    $inicioMes = $fechaCalendario->copy()->startOfMonth();
    $finMes = $fechaCalendario->copy()->endOfMonth();

    $primerDiaSemana = $inicioMes->dayOfWeekIso;
    $diasDelMes = $finMes->day;

    $eventos = collect($eventos)
    ->sortBy('dia')
    ->values();

    $eventosPorDia = $eventos->groupBy('dia');

    $estilosEventos = [
    'Institucional' => [
    'punto' => 'bg-emerald-600',
    'etiqueta' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
    'tarjeta' => 'border-emerald-200 bg-emerald-50/70',
    ],

    'Académico' => [
    'punto' => 'bg-blue-600',
    'etiqueta' => 'bg-blue-50 text-blue-800 border-blue-200',
    'tarjeta' => 'border-blue-200 bg-blue-50/70',
    ],

    'Cívico' => [
    'punto' => 'bg-amber-600',
    'etiqueta' => 'bg-amber-50 text-amber-800 border-amber-200',
    'tarjeta' => 'border-amber-200 bg-amber-50/70',
    ],

    'Deportivo' => [
    'punto' => 'bg-orange-600',
    'etiqueta' => 'bg-orange-50 text-orange-800 border-orange-200',
    'tarjeta' => 'border-orange-200 bg-orange-50/70',
    ],

    'Cultural' => [
    'punto' => 'bg-pink-600',
    'etiqueta' => 'bg-pink-50 text-pink-800 border-pink-200',
    'tarjeta' => 'border-pink-200 bg-pink-50/70',
    ],

    'Reunión' => [
    'punto' => 'bg-violet-600',
    'etiqueta' => 'bg-violet-50 text-violet-800 border-violet-200',
    'tarjeta' => 'border-violet-200 bg-violet-50/70',
    ],

    'Otro' => [
    'punto' => 'bg-gray-600',
    'etiqueta' => 'bg-gray-50 text-gray-800 border-gray-200',
    'tarjeta' => 'border-gray-200 bg-gray-50/70',
    ],
    ];

    $mesAnterior = $fechaCalendario
    ->copy()
    ->subMonth()
    ->format('Y-m');

    $mesSiguiente = $fechaCalendario
    ->copy()
    ->addMonth()
    ->format('Y-m');

    $cantidadCeldas = (int) ceil(
    ($primerDiaSemana - 1 + $diasDelMes) / 7
    ) * 7;
    @endphp

    <section class="relative overflow-hidden bg-slate-50 py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-20
                   h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-20
                   h-96 w-96 rounded-full bg-amber-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('inicio') }}"
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

                Volver al inicio
            </a>

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
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>

                    Agenda institucional
                </div>

                <h1
                    class="mt-6 text-4xl font-extrabold
                           tracking-tight text-emerald-950
                           sm:text-5xl">
                    Calendario institucional
                </h1>

                <div class="mt-5 flex justify-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-600">
                    Consulta actividades académicas, reuniones, celebraciones
                    y fechas importantes de la institución.
                </p>
            </div>

            <div
                class="mt-12 grid gap-8
                       lg:grid-cols-[1.35fr_0.65fr]">
                {{-- CALENDARIO --}}
                <div
                    class="overflow-hidden rounded-[30px]
                           border border-amber-200 bg-white
                           shadow-[0_24px_70px_rgba(6,78,59,0.10)]">
                    <div
                        class="flex flex-col gap-5 border-b border-gray-100
                               bg-emerald-950 p-6 text-white
                               sm:flex-row sm:items-center
                               sm:justify-between sm:p-8">
                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-300">
                                Vista mensual
                            </p>

                            <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                                {{ $fechaCalendario->locale('es')->translatedFormat('F Y') }}
                            </h2>
                        </div>

                        <div class="flex items-center gap-3">

                            <a
                                href="{{ route('calendario.index', ['mes' => $mesAnterior]) }}"
                                class="inline-flex h-11 w-11 items-center
                                       justify-center rounded-xl
                                       border border-amber-300/70
                                       bg-emerald-900 text-amber-300
                                       transition hover:bg-emerald-800"
                                aria-label="Mes anterior">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>

                            <a
                                href="{{ route('calendario.index') }}"
                                class="inline-flex items-center justify-center
                                       rounded-xl border border-amber-300/70
                                       bg-emerald-900 px-4 py-3
                                       text-sm font-extrabold text-white
                                       transition hover:bg-emerald-800">
                                Hoy
                            </a>

                            <a
                                href="{{ route('calendario.index', ['mes' => $mesSiguiente]) }}"
                                class="inline-flex h-11 w-11 items-center
                                       justify-center rounded-xl
                                       border border-amber-300/70
                                       bg-emerald-900 text-amber-300
                                       transition hover:bg-emerald-800"
                                aria-label="Mes siguiente">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 lg:p-8">

                        <div
                            class="grid grid-cols-7 overflow-hidden
                                   rounded-2xl border border-gray-200">
                            @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $diaSemana)

                            <div
                                class="border-b border-gray-200
                                           bg-gray-50 px-2 py-3 text-center
                                           text-xs font-extrabold uppercase
                                           tracking-[0.1em] text-gray-500">
                                {{ $diaSemana }}
                            </div>

                            @endforeach

                            @for ($celda = 1; $celda <= 42; $celda++)

                                @php
                                $numeroDia=$celda - $primerDiaSemana + 1;
                                $esDiaValido=$numeroDia>= 1
                                && $numeroDia <= $diasDelMes;

                                    $esHoy=$esDiaValido
                                    && $fechaCalendario->year === now()->year
                                    && $fechaCalendario->month === now()->month
                                    && $numeroDia === now()->day;

                                    $eventosDelDia = $esDiaValido
                                    ? $eventosPorDia->get($numeroDia, collect())
                                    : collect();
                                    @endphp

                                    <div
                                        class="relative min-h-28 border-b
                                           border-r border-gray-200 p-2
                                           sm:min-h-32 sm:p-3
                                           {{ !$esDiaValido ? 'bg-gray-50/70' : 'bg-white' }}">
                                        @if ($esDiaValido)

                                        <div class="flex items-start justify-between">

                                            <span
                                                class="inline-flex h-8 w-8 items-center
                                                       justify-center rounded-full
                                                       text-sm font-extrabold
                                                       {{ $esHoy
                                                            ? 'bg-emerald-950 text-amber-300'
                                                            : 'text-emerald-950' }}">
                                                {{ $numeroDia }}
                                            </span>

                                            @if ($eventosDelDia->isNotEmpty())

                                            <span
                                                class="rounded-full
                                                           bg-amber-100 px-2 py-1
                                                           text-[10px] font-extrabold
                                                           text-amber-800">
                                                {{ $eventosDelDia->count() }}
                                            </span>

                                            @endif
                                        </div>

                                        @if ($eventosDelDia->isNotEmpty())

                                        <div class="mt-3 space-y-2">

                                            @foreach ($eventosDelDia->take(2) as $evento)

                                            <div
                                                class="rounded-lg border
                                                               px-2 py-1.5 text-[11px]
                                                               font-bold leading-4
                                                               {{ $estilosEventos[$evento['tipo']]['etiqueta'] }}"
                                                title="{{ $evento['titulo'] }}">
                                                {{ \Illuminate\Support\Str::limit($evento['titulo'], 28) }}
                                            </div>

                                            @endforeach

                                            @if ($eventosDelDia->count() > 2)

                                            <p
                                                class="text-[10px]
                                                               font-bold text-gray-500">
                                                + {{ $eventosDelDia->count() - 2 }}
                                                actividad(es)
                                            </p>

                                            @endif
                                        </div>

                                        @endif
                                        @endif
                                    </div>

                                    @endfor
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">

                            @foreach (array_keys($estilosEventos) as $tipoEvento)

                            <span
                                class="inline-flex items-center gap-2
                                           rounded-full border border-gray-200
                                           bg-white px-3 py-2 text-xs
                                           font-bold text-gray-600">
                                <span
                                    class="h-2.5 w-2.5 rounded-full
                                               {{ $estilosEventos[$tipoEvento]['punto'] }}"></span>

                                {{ $tipoEvento }}
                            </span>

                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- AGENDA --}}
                <aside class="space-y-6">

                    <div
                        class="rounded-[28px] border border-amber-200
                               bg-white p-6
                               shadow-[0_18px_50px_rgba(6,78,59,0.08)]">
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600">
                            Agenda del mes
                        </p>

                        <h2
                            class="mt-2 text-2xl font-extrabold
                                   text-emerald-950">
                            Próximas actividades
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Actividades programadas para
                            {{ $fechaCalendario->locale('es')->translatedFormat('F') }}.
                        </p>
                    </div>

                    <div class="space-y-4">

                        @forelse ($eventos as $evento)

                        <article
                            class="rounded-[24px] border p-5
                                       shadow-[0_12px_35px_rgba(15,23,42,0.05)]
                                       {{ $estilosEventos[$evento['tipo']]['tarjeta'] }}">
                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-14 w-14 shrink-0
                                               flex-col items-center justify-center
                                               rounded-2xl bg-emerald-950
                                               text-white">
                                    <span
                                        class="text-lg font-extrabold
                                                   text-amber-300">
                                        {{ $evento['dia'] }}
                                    </span>

                                    <span class="text-[10px] uppercase">
                                        {{ $fechaCalendario->locale('es')->translatedFormat('M') }}
                                    </span>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <span
                                        class="inline-flex rounded-full
                                                   border px-3 py-1
                                                   text-[11px] font-extrabold
                                                   {{ $estilosEventos[$evento['tipo']]['etiqueta'] }}">
                                        {{ $evento['tipo'] }}
                                    </span>

                                    <h3
                                        class="mt-3 text-lg font-extrabold
                                                   leading-6 text-emerald-950">
                                        {{ $evento['titulo'] }}
                                    </h3>

                                    <p
                                        class="mt-2 text-sm leading-6
                                                   text-gray-600">
                                        {{ $evento['descripcion'] }}
                                    </p>

                                    @if ($evento['hora'] || $evento['lugar'])

                                    <div
                                        class="mt-4 space-y-2
                                                       border-t border-black/5 pt-4">
                                        @if ($evento['hora'])

                                        <p
                                            class="flex items-center
                                                               gap-2 text-xs
                                                               font-bold text-gray-600">
                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 7v5l3 2" />
                                            </svg>

                                            {{ str_replace(
                                                ['am', 'pm'],
                                                ['a. m.', 'p. m.'],
                                                $evento['hora']
                                            ) }} 
                                        </p>

                                        @endif

                                        @if ($evento['lugar'])

                                        <p
                                            class="flex items-center
                                                               gap-2 text-xs
                                                               font-bold text-gray-600">
                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                                                <circle cx="12" cy="10" r="2" />
                                            </svg>

                                            {{ $evento['lugar'] }}
                                        </p>

                                        @endif
                                    </div>

                                    @endif
                                </div>
                            </div>
                        </article>

                        @empty

                        <div
                            class="rounded-[24px] border border-dashed
                                       border-gray-300 bg-white p-8
                                       text-center">
                            <div
                                class="mx-auto flex h-14 w-14
                                           items-center justify-center
                                           rounded-2xl bg-emerald-50
                                           text-emerald-800">
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M16 3v4M8 3v4M3 10h18" />
                                </svg>
                            </div>

                            <h3
                                class="mt-4 font-extrabold
                                           text-emerald-950">
                                Sin actividades registradas
                            </h3>

                            <p
                                class="mt-2 text-sm leading-6
                                           text-gray-600">
                                No hay actividades programadas para este mes.
                            </p>
                        </div>

                        @endforelse
                    </div>
                </aside>
            </div>
        </div>
    </section>

</x-public-layout>