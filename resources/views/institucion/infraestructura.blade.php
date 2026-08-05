<x-public-layout title="Infraestructura">

    @php
        $imagenPrincipal = asset(
            'images/infraestructura/infraestructura-principal.png'
        );

        $imagenRespaldo = asset(
            'images/infraestructura-default.png'
        );
    @endphp

    <section class="relative overflow-hidden bg-white">

        <div
            class="pointer-events-none absolute -left-32 top-24
                   h-96 w-96 rounded-full bg-emerald-100/50 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 top-[720px]
                   h-96 w-96 rounded-full bg-amber-100/50 blur-3xl"
        ></div>

        {{-- Encabezado --}}
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

                <div
                    class="mt-10 grid items-center gap-12
                           lg:grid-cols-[0.9fr_1.1fr]"
                >
                    <div>

                        <div
                            class="inline-flex items-center gap-2
                                   rounded-full border border-amber-200
                                   bg-amber-50 px-4 py-2 text-xs
                                   font-extrabold uppercase
                                   tracking-[0.18em] text-amber-700"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M3 21h18"/>
                                <path d="M5 21V8l7-4 7 4v13"/>
                            </svg>

                            Espacios educativos
                        </div>

                        <h1
                            class="mt-6 text-4xl font-extrabold
                                   tracking-tight text-emerald-950
                                   sm:text-5xl lg:text-6xl"
                        >
                            Nuestra infraestructura
                        </h1>

                        <div class="mt-5 flex items-center gap-3">
                            <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                            <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                        </div>

                        <p class="mt-7 text-base leading-8 text-gray-700">
                            Nuestra institución dispone de ambientes destinados
                            al aprendizaje, la gestión, la convivencia y el
                            bienestar de toda la comunidad educativa.
                        </p>

                        <p class="mt-5 text-base leading-8 text-gray-700">
                            Cada espacio está orientado a brindar condiciones
                            adecuadas para el desarrollo de las actividades de
                            los niveles inicial, primario y secundario.
                        </p>

                        <div
                            class="mt-8 rounded-3xl border border-emerald-100
                                   bg-emerald-50/70 p-6"
                        >
                            <div class="flex items-start gap-4">

                                <span
                                    class="flex h-12 w-12 shrink-0
                                           items-center justify-center
                                           rounded-2xl bg-emerald-950
                                           text-amber-300"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                </span>

                                <div>
                                    <p class="font-extrabold text-emerald-950">
                                        Espacios seguros y funcionales
                                    </p>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        Promovemos el cuidado, el orden y el uso
                                        responsable de todos nuestros ambientes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">

                        <div
                            class="absolute -inset-3 rounded-[36px]
                                   border border-amber-200 bg-emerald-50"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[32px]
                                   border border-amber-300 bg-emerald-950
                                   shadow-[0_25px_70px_rgba(6,78,59,0.16)]"
                        >
                            <img
                                src="{{ $imagenPrincipal }}"
                                alt="Infraestructura institucional"
                                class="h-[470px] w-full object-cover sm:h-[550px]"
                                onerror="this.onerror=null; this.src='{{ $imagenRespaldo }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/85
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div class="absolute bottom-0 left-0 right-0 p-7 text-white">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.18em] text-amber-300"
                                >
                                    IE Crl. José Joaquín Inclán
                                </p>

                                <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                                    Espacios para aprender y crecer
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Ambientes --}}
        <section class="border-y border-emerald-100 bg-gray-50 py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center
                               justify-center rounded-2xl
                               border border-amber-300 bg-emerald-950
                               text-amber-300"
                    >
                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="m8 15 3-3 2 2 3-4 3 5"/>
                            <circle cx="8" cy="9" r="1"/>
                        </svg>
                    </div>

                    <p
                        class="mt-6 text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-600"
                    >
                        Ambientes institucionales
                    </p>

                    <h2
                        class="mt-3 text-3xl font-extrabold
                               text-emerald-950 sm:text-4xl"
                    >
                        Conoce nuestros espacios
                    </h2>

                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Selecciona un ambiente para conocerlo y ver más
                        fotografías de sus instalaciones.
                    </p>
                </div>

                <div class="mt-14 grid gap-7 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($ambientes as $index => $ambiente)

                        @php
                            $rutaImagen = asset($ambiente['imagen']);
                        @endphp

                        <a
                            href="{{ route(
                                'institucion.infraestructura.mostrar',
                                $ambiente['slug']
                            ) }}"
                            class="group overflow-hidden rounded-[28px]
                                   border border-amber-200 bg-white
                                   shadow-[0_15px_45px_rgba(6,78,59,0.08)]
                                   transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <div
                                class="relative h-72 overflow-hidden
                                       bg-emerald-950"
                            >
                                <img
                                    src="{{ $rutaImagen }}"
                                    alt="{{ $ambiente['titulo'] }}"
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
                                    class="absolute left-5 top-5
                                           flex h-12 w-12 items-center
                                           justify-center rounded-2xl
                                           border border-amber-300
                                           bg-emerald-950/90
                                           text-amber-300 backdrop-blur"
                                >
                                    @switch($ambiente['icono'])

                                        @case('computacion')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <rect x="3" y="4" width="18" height="13" rx="2"/>
                                                <path d="M8 21h8M12 17v4"/>
                                            </svg>
                                            @break

                                        @case('direccion')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                                <path d="M8 8h8M8 12h8M8 16h5"/>
                                            </svg>
                                            @break

                                        @case('patio')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M3 20h18M5 16h14"/>
                                                <path d="M7 16V8h10v8M10 8V5h4v3"/>
                                            </svg>
                                            @break

                                        @case('naturaleza')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M12 21V10"/>
                                                <path d="M7 13c-2-5 2-9 5-10 1 4-1 8-5 10z"/>
                                                <path d="M17 15c2-4-1-7-5-8 0 4 2 7 5 8z"/>
                                            </svg>
                                            @break

                                        @case('reunion')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="8" cy="8" r="3"/>
                                                <circle cx="17" cy="8" r="3"/>
                                                <path d="M3 20v-2a5 5 0 0 1 5-5"/>
                                                <path d="M21 20v-2a5 5 0 0 0-5-5"/>
                                            </svg>
                                            @break

                                        @case('salud')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <rect x="4" y="4" width="16" height="16" rx="3"/>
                                                <path d="M12 8v8M8 12h8"/>
                                            </svg>
                                            @break

                                        @case('inicial')
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <circle cx="12" cy="8" r="3"/>
                                                <path d="M6 21v-2a6 6 0 0 1 12 0v2"/>
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

                                        @default
                                            <svg class="h-6 w-6" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path d="M3 21h18"/>
                                                <path d="M5 21V8l7-4 7 4v13"/>
                                            </svg>

                                    @endswitch
                                </div>

                                <div class="absolute bottom-5 left-5 right-5">

                                    <span
                                        class="inline-flex items-center gap-2
                                               rounded-full border
                                               border-amber-300
                                               bg-emerald-950/90
                                               px-4 py-2 text-xs
                                               font-extrabold uppercase
                                               tracking-[0.12em]
                                               text-amber-300"
                                    >
                                        Ver fotografías

                                        <svg
                                            class="h-4 w-4 transition
                                                   group-hover:translate-x-1"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M5 12h14"/>
                                            <path d="m13 6 6 6-6 6"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="p-7">

                                <div class="flex items-start justify-between gap-4">

                                    <h3
                                        class="text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        {{ $ambiente['titulo'] }}
                                    </h3>

                                    <span
                                        class="text-sm font-extrabold
                                               text-amber-600"
                                    >
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                <p class="mt-4 text-sm leading-7 text-gray-600">
                                    {{ $ambiente['descripcion'] }}
                                </p>
                            </div>
                        </a>

                    @endforeach
                </div>
            </div>
        </section>

        {{-- Cierre --}}
        <section class="py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="rounded-[36px] border border-amber-300
                           bg-emerald-950 p-8 text-white
                           shadow-[0_24px_70px_rgba(6,78,59,0.16)]
                           sm:p-10 lg:p-12"
                >
                    <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.18em] text-amber-300"
                            >
                                Compromiso institucional
                            </p>

                            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">
                                Cuidamos los espacios que compartimos
                            </h2>

                            <p class="mt-5 max-w-4xl leading-8 text-emerald-100">
                                Promovemos una cultura de orden, limpieza,
                                seguridad y conservación de nuestras instalaciones.
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
                                <path d="M3 21h18"/>
                                <path d="M5 21V8l7-4 7 4v13"/>
                                <path d="M9 12h2v3H9zM13 12h2v3h-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</x-public-layout>