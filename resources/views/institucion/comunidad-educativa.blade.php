<x-public-layout title="Comunidad educativa">

    @php
        $imagenRespaldo = asset('images/comunidad-educativa-default.jpg');
    @endphp

    <section class="relative overflow-hidden bg-white">

        <div
            class="pointer-events-none absolute -left-32 top-28
                   h-96 w-96 rounded-full bg-emerald-100/50 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 top-[760px]
                   h-96 w-96 rounded-full bg-amber-100/50 blur-3xl"
        ></div>

        {{-- ENCABEZADO --}}
        <section class="relative py-16 sm:py-20 lg:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

                <div class="mx-auto mt-10 max-w-4xl text-center">

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
                            <circle cx="8" cy="8" r="3"/>
                            <circle cx="17" cy="8" r="3"/>
                            <path d="M3 20v-2a5 5 0 0 1 5-5"/>
                            <path d="M21 20v-2a5 5 0 0 0-5-5"/>
                            <path d="M10 20v-2a4 4 0 0 1 8 0v2"/>
                        </svg>

                        Nuestra comunidad
                    </div>

                    <h1
                        class="mt-6 text-4xl font-extrabold tracking-tight
                               text-emerald-950 sm:text-5xl lg:text-6xl"
                    >
                        Comunidad educativa
                    </h1>

                    <div class="mx-auto mt-6 flex w-fit items-center gap-3">
                        <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                        <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                    </div>

                    <p
                        class="mx-auto mt-7 max-w-3xl text-base
                               leading-8 text-gray-600 sm:text-lg"
                    >
                        Nuestra institución está conformada por equipos
                        comprometidos con la formación, el bienestar y el
                        desarrollo integral de nuestros estudiantes.
                    </p>
                </div>
            </div>
        </section>

        {{-- PRESENTACIÓN --}}
        <section class="border-y border-emerald-100 bg-emerald-50/60 py-16">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div class="grid items-center gap-8 lg:grid-cols-[auto_1fr]">

                    <div
                        class="flex h-20 w-20 items-center justify-center
                               rounded-[26px] border border-amber-300
                               bg-emerald-950 text-amber-300"
                    >
                        <svg
                            class="h-10 w-10"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <circle cx="12" cy="8" r="3"/>
                            <path d="M6 21v-2a6 6 0 0 1 12 0v2"/>
                            <path d="M4 9a3 3 0 1 0 0 6"/>
                            <path d="M20 9a3 3 0 1 1 0 6"/>
                        </svg>
                    </div>

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-600"
                        >
                            Trabajo colaborativo
                        </p>

                        <h2
                            class="mt-3 text-3xl font-extrabold
                                   text-emerald-950 sm:text-4xl"
                        >
                            Un equipo comprometido con la educación
                        </h2>

                        <p class="mt-5 max-w-4xl text-base leading-8 text-gray-600">
                            Directivos, docentes, especialistas y personal de
                            apoyo trabajan de manera coordinada para brindar un
                            servicio educativo organizado, humano y de calidad.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- GRUPOS --}}
        <section class="relative py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">

                    <p
                        class="text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-600"
                    >
                        Organización institucional
                    </p>

                    <h2
                        class="mt-3 text-3xl font-extrabold
                               text-emerald-950 sm:text-4xl"
                    >
                        Conoce a los equipos que nos representan
                    </h2>

                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Cada grupo cumple una función importante dentro de la
                        comunidad educativa y contribuye al desarrollo de
                        nuestros estudiantes.
                    </p>
                </div>

                <div class="mt-14 grid gap-7 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($grupos as $index => $grupo)

                        <article
                            class="group overflow-hidden rounded-[28px]
                                   border border-amber-200 bg-white
                                   shadow-[0_15px_45px_rgba(6,78,59,0.08)]
                                   transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <div class="relative h-72 overflow-hidden bg-emerald-950">

                                <img
                                    src="{{ asset($grupo['imagen']) }}"
                                    alt="{{ $grupo['titulo'] }}"
                                    class="h-full w-full object-cover
                                           transition duration-500
                                           group-hover:scale-105"
                                    onerror="this.onerror=null; this.src='{{ $imagenRespaldo }}';"
                                >

                                <div
                                    class="absolute inset-0 bg-gradient-to-t
                                           from-emerald-950/85
                                           via-emerald-950/10
                                           to-transparent"
                                ></div>

                                <div
                                    class="absolute left-5 top-5 flex h-12 w-12
                                           items-center justify-center rounded-2xl
                                           border border-amber-300
                                           bg-emerald-950/90 text-amber-300
                                           backdrop-blur"
                                >
                                    @switch($grupo['icono'])

                                        @case('directivos')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="12" cy="7" r="3"/>
                                                <path d="M6 21v-2a6 6 0 0 1 12 0v2"/>
                                                <path d="m9 13 3 3 3-3"/>
                                            </svg>
                                            @break

                                        @case('inicial')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="12" cy="8" r="3"/>
                                                <path d="M6 21v-2a6 6 0 0 1 12 0v2"/>
                                                <path d="M8 4 6 2M16 4l2-2"/>
                                            </svg>
                                            @break

                                        @case('primaria')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5z"/>
                                                <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5z"/>
                                            </svg>
                                            @break

                                        @case('secundaria')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M3 10 12 5l9 5-9 5z"/>
                                                <path d="M7 12v5c3 2 7 2 10 0v-5"/>
                                            </svg>
                                            @break

                                        @case('administrativos')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                                <path d="M8 8h8M8 12h8M8 16h5"/>
                                            </svg>
                                            @break

                                        @case('psicologia')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M12 21v-7"/>
                                                <path d="M8 14a4 4 0 1 1 4-4"/>
                                                <path d="M16 14a4 4 0 1 0-4-4"/>
                                                <path d="M9 21h6"/>
                                            </svg>
                                            @break

                                        @case('toese')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M12 21s8-4.5 8-11a4.5 4.5 0 0 0-8-2.8A4.5 4.5 0 0 0 4 10c0 6.5 8 11 8 11z"/>
                                            </svg>
                                            @break

                                        @case('coordinadores')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="8" cy="8" r="3"/>
                                                <circle cx="17" cy="8" r="3"/>
                                                <path d="M3 20v-2a5 5 0 0 1 5-5"/>
                                                <path d="M21 20v-2a5 5 0 0 0-5-5"/>
                                            </svg>
                                            @break

                                        @case('tecnicos')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M14 6 18 2l4 4-4 4"/>
                                                <path d="m10 14-8 8"/>
                                                <path d="M6 2a4 4 0 0 0 5 5l6 6"/>
                                                <path d="M18 14a4 4 0 0 1-5 5l-6-6"/>
                                            </svg>
                                            @break

                                        @default
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z"/>
                                                <path d="m8 12 2.5 2.5L16 9"/>
                                            </svg>

                                    @endswitch
                                </div>

                                <div class="absolute bottom-5 left-5 right-5">
                                    <span
                                        class="inline-flex rounded-full
                                               border border-amber-300
                                               bg-emerald-950/90 px-3 py-1.5
                                               text-xs font-extrabold uppercase
                                               tracking-[0.12em] text-amber-300"
                                    >
                                        Comunidad educativa
                                    </span>
                                </div>
                            </div>

                            <div class="p-7">

                                <div class="flex items-start justify-between gap-4">

                                    <h3
                                        class="text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        {{ $grupo['titulo'] }}
                                    </h3>

                                    <span
                                        class="text-sm font-extrabold
                                               text-amber-600"
                                    >
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                <p class="mt-4 text-sm leading-7 text-gray-600">
                                    {{ $grupo['descripcion'] }}
                                </p>
                            </div>
                        </article>

                    @endforeach
                </div>
            </div>
        </section>

        {{-- CIERRE --}}
        <section class="border-t border-emerald-100 bg-gray-50 py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="overflow-hidden rounded-[36px]
                           border border-amber-300 bg-emerald-950
                           p-8 text-white
                           shadow-[0_24px_70px_rgba(6,78,59,0.16)]
                           sm:p-10 lg:p-12"
                >
                    <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.18em] text-amber-300"
                            >
                                Compromiso compartido
                            </p>

                            <h2
                                class="mt-3 text-3xl font-extrabold
                                       sm:text-4xl"
                            >
                                Unidos por una educación de calidad
                            </h2>

                            <p
                                class="mt-5 max-w-4xl text-base
                                       leading-8 text-emerald-100"
                            >
                                Nuestra comunidad educativa trabaja con
                                responsabilidad, vocación de servicio y
                                compromiso institucional.
                            </p>
                        </div>

                        <div
                            class="flex h-24 w-24 items-center justify-center
                                   rounded-[28px] border border-amber-300
                                   bg-emerald-900 text-amber-300"
                        >
                            <svg
                                class="h-12 w-12"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <circle cx="8" cy="8" r="3"/>
                                <circle cx="17" cy="8" r="3"/>
                                <path d="M3 20v-2a5 5 0 0 1 5-5"/>
                                <path d="M21 20v-2a5 5 0 0 0-5-5"/>
                                <path d="M10 20v-2a4 4 0 0 1 8 0v2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</x-public-layout>