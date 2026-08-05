<x-public-layout :title="$detalle['titulo']">

    @php
        $imagenRespaldo = asset(
            'images/infraestructura-default.png'
        );

        $imagenesDisponibles = collect($detalle['galeria'])
            ->filter(function ($imagen) {
                return file_exists(public_path($imagen));
            });
    @endphp

    <section class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-24">

        <div
            class="pointer-events-none absolute -left-32 top-20
                   h-96 w-96 rounded-full bg-emerald-100/50 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 bottom-20
                   h-96 w-96 rounded-full bg-amber-100/50 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('institucion.infraestructura') }}"
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

                Volver a infraestructura
            </a>

            <div
                class="mt-10 overflow-hidden rounded-[36px]
                       border border-amber-300 bg-emerald-950
                       shadow-[0_25px_70px_rgba(6,78,59,0.16)]"
            >
                <div class="grid lg:grid-cols-[1fr_0.85fr]">

                    <div class="relative min-h-[420px] overflow-hidden">

                        <img
                            src="{{ asset($detalle['imagen']) }}"
                            alt="{{ $detalle['titulo'] }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            onerror="this.onerror=null; this.src='{{ $imagenRespaldo }}';"
                        >

                        <div
                            class="absolute inset-0 bg-gradient-to-t
                                   from-emerald-950/75
                                   via-transparent to-transparent"
                        ></div>
                    </div>

                    <div class="flex items-center p-8 text-white sm:p-10 lg:p-12">

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.18em] text-amber-300"
                            >
                                Infraestructura institucional
                            </p>

                            <h1
                                class="mt-4 text-4xl font-extrabold
                                       tracking-tight sm:text-5xl"
                            >
                                {{ $detalle['titulo'] }}
                            </h1>

                            <div class="mt-5 flex items-center gap-3">
                                <span class="h-1 w-16 rounded-full bg-white"></span>
                                <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                            </div>

                            <p class="mt-7 text-base leading-8 text-emerald-100">
                                {{ $detalle['descripcion'] }}
                            </p>

                            <div
                                class="mt-8 inline-flex items-center gap-3
                                       rounded-2xl border border-emerald-700
                                       bg-emerald-900 px-5 py-4"
                            >
                                <svg
                                    class="h-6 w-6 text-amber-300"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path d="m8 15 3-3 2 2 3-4 3 5"/>
                                </svg>

                                <span class="font-extrabold">
                                    Galería fotográfica
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-16">

                <div class="max-w-3xl">

                    <p
                        class="text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-600"
                    >
                        Conoce este ambiente
                    </p>

                    <h2
                        class="mt-3 text-3xl font-extrabold
                               text-emerald-950 sm:text-4xl"
                    >
                        Más fotografías
                    </h2>

                    <p class="mt-4 text-base leading-8 text-gray-600">
                        En esta sección podrás incorporar diferentes fotografías
                        del ambiente institucional.
                    </p>
                </div>

                @if ($imagenesDisponibles->isNotEmpty())

                    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                        @foreach ($imagenesDisponibles as $index => $imagen)

                            <figure
                                class="group overflow-hidden rounded-[28px]
                                       border border-amber-200 bg-white
                                       shadow-[0_14px_40px_rgba(6,78,59,0.08)]"
                            >
                                <div class="relative h-72 overflow-hidden">

                                    <img
                                        src="{{ asset($imagen) }}"
                                        alt="{{ $detalle['titulo'] }} - Fotografía {{ $index + 1 }}"
                                        class="h-full w-full object-cover
                                               transition duration-500
                                               group-hover:scale-105"
                                    >

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t
                                               from-emerald-950/55
                                               via-transparent to-transparent"
                                    ></div>

                                    <span
                                        class="absolute bottom-4 left-4
                                               rounded-full border
                                               border-amber-300
                                               bg-emerald-950/90
                                               px-3 py-1.5 text-xs
                                               font-extrabold text-amber-300"
                                    >
                                        Fotografía {{ $index + 1 }}
                                    </span>
                                </div>
                            </figure>

                        @endforeach
                    </div>

                @else

                    <div
                        class="mt-10 rounded-[30px] border
                               border-dashed border-amber-300
                               bg-amber-50/50 px-6 py-14 text-center"
                    >
                        <div
                            class="mx-auto flex h-16 w-16 items-center
                                   justify-center rounded-2xl
                                   bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-8 w-8"
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

                        <h3
                            class="mt-5 text-xl font-extrabold
                                   text-emerald-950"
                        >
                            Galería pendiente
                        </h3>

                        <p class="mx-auto mt-3 max-w-xl leading-7 text-gray-600">
                            Agrega fotografías en la carpeta correspondiente
                            para que aparezcan automáticamente en esta sección.
                        </p>
                    </div>

                @endif
            </section>
        </div>
    </section>

</x-public-layout>