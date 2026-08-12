<x-public-layout title="Reseña histórica">

    @php
        $datos = $contenido?->datos ?? [];

        $portada = $datos['portada'] ?? [];
        $destacados = $datos['destacados'] ?? [];
        $convenio = $datos['convenio'] ?? [];
        $timeline = $datos['timeline'] ?? [];
        $smartSchool = $datos['smart_school'] ?? [];
        $legado = $datos['legado'] ?? [];

        $iconos = [
            'documento' => '
                <path d="M6 3h9l4 4v14H6z"/>
                <path d="M14 3v5h5"/>
                <path d="M9 13h6M9 17h6"/>
            ',
            'estudiantes' => '
                <circle cx="9" cy="8" r="3"/>
                <circle cx="17" cy="9" r="2.5"/>
                <path d="M3 20v-2a6 6 0 0 1 12 0v2"/>
                <path d="M15 14a5 5 0 0 1 6 4.8V20"/>
            ',
            'escuela' => '
                <path d="M3 21h18"/>
                <path d="M5 21V9l7-4 7 4v12"/>
                <path d="M9 13h2v3H9zM13 13h2v3h-2z"/>
            ',
            'construccion' => '
                <path d="M4 20h16"/>
                <path d="M6 20V9h12v11"/>
                <path d="M9 9V5h6v4"/>
                <path d="M9 13h6"/>
            ',
            'laboratorio' => '
                <path d="M9 3h6"/>
                <path d="M10 3v6l-5 9a2 2 0 0 0 1.8 3h10.4A2 2 0 0 0 19 18l-5-9V3"/>
                <path d="M8 15h8"/>
            ',
            'oficinas' => '
                <rect x="4" y="4" width="16" height="16" rx="2"/>
                <path d="M8 8h3v3H8zM13 8h3v3h-3zM8 13h3v3H8zM13 13h3v3h-3z"/>
            ',
            'infraestructura' => '
                <path d="M3 21h18"/>
                <path d="M5 21V8l7-4 7 4v13"/>
                <path d="M9 12h2v3H9zM13 12h2v3h-2z"/>
            ',
            'modernizacion' => '
                <path d="M4 19h16"/>
                <path d="M6 16V9h12v7"/>
                <path d="M9 9V5h6v4"/>
                <path d="m8 13 2 2 5-5"/>
            ',
            'tecnologia' => '
                <rect x="3" y="4" width="18" height="13" rx="2"/>
                <path d="M8 21h8M12 17v4"/>
                <path d="M8 9h2M12 9h4M8 12h8"/>
            ',
            'actualidad' => '
                <circle cx="12" cy="12" r="9"/>
                <path d="m8 12 2.5 2.5L16 9"/>
            ',
        ];

        $imagenPortada = !empty($portada['imagen'])
            ? asset('storage/' . $portada['imagen'])
            : asset('images/resena-historica.png');

        $beneficiosSmart = $smartSchool['beneficios'] ?? [
            'Capacitación docente',
            'Tecnología interactiva',
            'Mejora de los aprendizajes',
            'Inclusión digital familiar',
        ];
    @endphp

    <section class="relative overflow-hidden bg-white">

        {{-- Decoración de fondo --}}
        <div
            class="pointer-events-none absolute -left-32 top-24 h-96 w-96
                   rounded-full bg-emerald-100/60 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 top-[620px] h-96 w-96
                   rounded-full bg-amber-100/60 blur-3xl"
        ></div>

        {{-- Portada --}}
        <div class="relative py-16 sm:py-20 lg:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <a
                    href="{{ route('inicio') }}"
                    class="inline-flex items-center gap-2 text-sm font-extrabold
                           text-emerald-800 transition hover:text-emerald-950"
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
                           lg:grid-cols-[0.95fr_1.05fr]"
                >
                    {{-- Información principal --}}
                    <div>

                        <div
                            class="inline-flex items-center gap-2 rounded-full
                                   border border-amber-200 bg-amber-50
                                   px-4 py-2 text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-700"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>

                            {{ $portada['etiqueta'] ?? 'Nuestra trayectoria' }}
                        </div>

                        <h1
                            class="mt-6 text-4xl font-extrabold tracking-tight
                                   text-emerald-950 sm:text-5xl lg:text-6xl"
                        >
                            {{ $portada['titulo'] ?? 'Reseña histórica' }}
                        </h1>

                        <div class="mt-5 flex items-center gap-3">
                            <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                            <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                        </div>

                        <p class="mt-7 text-base leading-8 text-gray-700">
                            {{ $portada['descripcion']
                                ?? 'La Institución Educativa “Crl. José Joaquín Inclán” fue creada oficialmente el 20 de enero de 1995, mediante Resolución Directoral N.° 021, para brindar educación a los hijos del personal militar y civil del Ejército, así como a estudiantes de la comunidad piurana.' }}
                        </p>

                        <div
                            class="mt-7 rounded-3xl border border-emerald-100
                                   bg-emerald-50/70 p-5"
                        >
                            <div class="flex items-start gap-4">

                                <span
                                    class="flex h-11 w-11 shrink-0 items-center
                                           justify-center rounded-2xl
                                           border border-amber-300
                                           bg-emerald-950 text-amber-300"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z"/>
                                        <path d="M9 12h6M12 9v6"/>
                                    </svg>
                                </span>

                                <div>
                                    <p class="font-extrabold text-emerald-950">
                                        {{ $portada['origen_titulo'] ?? 'Origen de nuestra denominación' }}
                                    </p>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        {{ $portada['origen_descripcion']
                                            ?? 'El nombre de la institución rinde homenaje al coronel José Joaquín Inclán, héroe del Combate del Dos de Mayo de 1866 y patrono del arma de Artillería del Ejército del Perú.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Imagen principal --}}
                    <div class="relative">

                        <div
                            class="absolute -inset-3 rounded-[36px]
                                   border border-amber-200 bg-emerald-50"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[32px]
                                   border border-amber-300 bg-emerald-950
                                   shadow-[0_25px_70px_rgba(6,78,59,0.18)]"
                        >
                            <img
                                src="{{ $imagenPortada }}"
                                alt="Historia de la IE Crl. José Joaquín Inclán"
                                class="h-[460px] w-full object-cover
                                       sm:h-[540px]"
                                onerror="this.onerror=null; this.src='{{ asset('images/portada-institucion.jpg') }}';"
                            >

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-emerald-950/90
                                       via-emerald-950/10
                                       to-transparent"
                            ></div>

                            <div
                                class="absolute left-5 top-5 inline-flex
                                       items-center gap-2 rounded-full
                                       border border-white/25 bg-emerald-950/80
                                       px-4 py-2 text-xs font-extrabold
                                       uppercase tracking-[0.14em] text-white
                                       backdrop-blur"
                            >
                                <svg
                                    class="h-4 w-4 text-amber-300"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M8 2v4M16 2v4M3 10h18"/>
                                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                                </svg>

                                {{ $portada['desde'] ?? 'Desde 1995' }}
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 p-7 text-white">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.18em] text-amber-300"
                                >
                                    {{ $portada['institucion'] ?? 'IE Crl. José Joaquín Inclán' }}
                                </p>

                                <h2 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                                    {{ $portada['frase'] ?? 'Educación, valores y compromiso' }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Datos destacados --}}
                <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    <article
                        class="rounded-3xl border border-amber-200
                               bg-white p-6 shadow-sm"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-2xl bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                            </svg>
                        </div>

                        <p class="mt-5 text-3xl font-extrabold text-emerald-950">
                            {{ $destacados['anio']['valor'] ?? '1995' }}
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-500">
                            {{ $destacados['anio']['texto'] ?? 'Año de creación' }}
                        </p>
                    </article>

                    <article
                        class="rounded-3xl border border-amber-200
                               bg-white p-6 shadow-sm"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-2xl bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="9" cy="8" r="3"/>
                                <circle cx="17" cy="9" r="2.5"/>
                                <path d="M3 20v-2a6 6 0 0 1 12 0v2"/>
                                <path d="M15 14a5 5 0 0 1 6 4.8V20"/>
                            </svg>
                        </div>

                        <p class="mt-5 text-3xl font-extrabold text-emerald-950">
                            {{ $destacados['estudiantes']['valor'] ?? '130' }}
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-500">
                            {{ $destacados['estudiantes']['texto'] ?? 'Estudiantes al iniciar' }}
                        </p>
                    </article>

                    <article
                        class="rounded-3xl border border-amber-200
                               bg-white p-6 shadow-sm"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-2xl bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="7" r="4"/>
                                <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                            </svg>
                        </div>

                        <p class="mt-5 text-3xl font-extrabold text-emerald-950">
                            {{ $destacados['docentes']['valor'] ?? '7' }}
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-500">
                            {{ $destacados['docentes']['texto'] ?? 'Docentes fundadores' }}
                        </p>
                    </article>

                    <article
                        class="rounded-3xl border border-amber-200
                               bg-white p-6 shadow-sm"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-2xl bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M3 21h18"/>
                                <path d="M5 21V9l7-4 7 4v12"/>
                                <path d="M9 13h2v3H9zM13 13h2v3h-2z"/>
                            </svg>
                        </div>

                        <p class="mt-5 text-3xl font-extrabold text-emerald-950">
                            {{ $destacados['niveles']['valor'] ?? '3' }}
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-500">
                            {{ $destacados['niveles']['texto'] ?? 'Niveles educativos' }}
                        </p>
                    </article>
                </div>
            </div>
        </div>

        {{-- Convenio inicial --}}
        <section class="relative border-y border-emerald-100 bg-emerald-50/60 py-20">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="grid items-center gap-10
                           lg:grid-cols-[0.8fr_1.2fr]"
                >
                    <div
                        class="rounded-[32px] border border-amber-300
                               bg-emerald-950 p-8 text-white
                               shadow-[0_20px_60px_rgba(6,78,59,0.15)]"
                    >
                        <div
                            class="flex h-16 w-16 items-center justify-center
                                   rounded-2xl border border-amber-300
                                   bg-emerald-900 text-amber-300"
                        >
                            <svg
                                class="h-8 w-8"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M8 12 11 15 16 10"/>
                                <path d="M3 7h4l3 3M21 7h-4l-3 3"/>
                                <path d="M5 17h4l3-3 3 3h4"/>
                            </svg>
                        </div>

                        <p
                            class="mt-7 text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-300"
                        >
                            {{ $destacados['anio']['valor'] ?? '1995' }}–1999
                        </p>

                        <h2 class="mt-3 text-3xl font-extrabold">
                            {{ $convenio['titulo'] ?? 'Convenio educativo inicial' }}
                        </h2>

                        <p class="mt-5 leading-8 text-emerald-100">
                            {{ $convenio['descripcion']
                                ?? 'El inicio de la institución estuvo respaldado por una alianza entre la Universidad de Piura y la Primera Región Militar.' }}
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        <article
                            class="rounded-[28px] border border-amber-200
                                   bg-white p-7 shadow-sm"
                        >
                            <div class="flex items-center gap-4">

                                <span
                                    class="flex h-12 w-12 shrink-0 items-center
                                           justify-center rounded-2xl
                                           bg-emerald-950 text-amber-300"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M3 10 12 5l9 5-9 5z"/>
                                        <path d="M7 12v5c3 2 7 2 10 0v-5"/>
                                    </svg>
                                </span>

                                <h3 class="text-xl font-extrabold text-emerald-950">
                                    {{ $convenio['entidad_1']['nombre'] ?? 'Universidad de Piura' }}
                                </h3>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-gray-600">
                                {{ $convenio['entidad_1']['descripcion']
                                    ?? 'Tuvo a su cargo la selección del personal académico, la elaboración del plan de estudios y la asesoría permanente en organización, enseñanza y capacitación.' }}
                            </p>
                        </article>

                        <article
                            class="rounded-[28px] border border-amber-200
                                   bg-white p-7 shadow-sm"
                        >
                            <div class="flex items-center gap-4">

                                <span
                                    class="flex h-12 w-12 shrink-0 items-center
                                           justify-center rounded-2xl
                                           bg-emerald-950 text-amber-300"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z"/>
                                        <path d="M8 12h8"/>
                                    </svg>
                                </span>

                                <h3 class="text-xl font-extrabold text-emerald-950">
                                    {{ $convenio['entidad_2']['nombre'] ?? 'Primera Región Militar' }}
                                </h3>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-gray-600">
                                {{ $convenio['entidad_2']['descripcion']
                                    ?? 'Asumió la conducción administrativa, económica y operativa del colegio, además de proporcionar infraestructura, equipamiento y material pedagógico.' }}
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- Línea de tiempo --}}
        <section class="relative py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center
                               justify-center rounded-2xl border
                               border-amber-300 bg-emerald-950
                               text-amber-300"
                    >
                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M8 2v4M16 2v4M3 10h18"/>
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                        </svg>
                    </div>

                    <p
                        class="mt-6 text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-600"
                    >
                        {{ $timeline['etiqueta'] ?? 'Evolución institucional' }}
                    </p>

                    <h2
                        class="mt-3 text-3xl font-extrabold
                               text-emerald-950 sm:text-4xl"
                    >
                        {{ $timeline['titulo'] ?? 'Una historia de crecimiento permanente' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-gray-600">
                        {{ $timeline['descripcion']
                            ?? 'Cada etapa representa el esfuerzo por ofrecer mejores espacios, servicios y oportunidades educativas.' }}
                    </p>
                </div>

                <div class="relative mx-auto mt-16 max-w-6xl">

                    <div
                        class="absolute bottom-0 left-6 top-0 w-px
                               bg-gradient-to-b from-amber-300
                               via-emerald-300 to-emerald-700
                               lg:left-1/2"
                    ></div>

                    <div class="space-y-10">

                        @foreach ($hitos as $index => $hito)

                            <article
                                class="relative grid gap-8 pl-16
                                       lg:grid-cols-2 lg:pl-0"
                            >
                                {{-- Punto central --}}
                                <div
                                    class="absolute left-0 top-5 z-10
                                           flex h-12 w-12 items-center
                                           justify-center rounded-2xl
                                           border-4 border-white
                                           bg-emerald-950 text-amber-300
                                           shadow-lg lg:left-1/2
                                           lg:-translate-x-1/2"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        {!! $iconos[$hito->icono] ?? $iconos['documento'] !!}
                                    </svg>
                                </div>

                                <div
                                    class="{{ $index % 2 === 0
                                        ? 'lg:pr-16'
                                        : 'lg:col-start-2 lg:pl-16' }}"
                                >
                                    <div
                                        class="group rounded-[28px]
                                               border border-amber-200
                                               bg-white p-7
                                               shadow-[0_14px_42px_rgba(6,78,59,0.08)]
                                               transition duration-300
                                               hover:-translate-y-1
                                               hover:shadow-xl"
                                    >
                                        <div
                                            class="flex flex-wrap items-center
                                                   justify-between gap-3"
                                        >
                                            <span
                                                class="inline-flex items-center
                                                       gap-2 rounded-full
                                                       bg-emerald-950 px-4 py-2
                                                       text-sm font-extrabold
                                                       text-white"
                                            >
                                                <svg
                                                    class="h-4 w-4 text-amber-300"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M8 2v4M16 2v4M3 10h18"/>
                                                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                </svg>

                                                {{ $hito->anio }}
                                            </span>

                                            @if ($hito->fecha_texto)
                                                <span
                                                    class="text-xs font-extrabold
                                                           uppercase tracking-[0.12em]
                                                           text-amber-700"
                                                >
                                                    {{ $hito->fecha_texto }}
                                                </span>
                                            @endif
                                        </div>

                                        <h3
                                            class="mt-5 text-xl font-extrabold
                                                   text-emerald-950 sm:text-2xl"
                                        >
                                            {{ $hito->titulo }}
                                        </h3>

                                        <p class="mt-4 text-sm leading-7 text-gray-600">
                                            {{ $hito->descripcion }}
                                        </p>

                                        @if ($hito->imagen)
                                            <div
                                                class="mt-5 overflow-hidden rounded-2xl
                                                       border border-amber-100 bg-gray-100"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $hito->imagen) }}"
                                                    alt="{{ $hito->titulo }}"
                                                    class="h-56 w-full object-cover sm:h-64"
                                                >
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>

                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- Smart School --}}
        <section class="border-y border-emerald-800 bg-emerald-950 py-20 text-white">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="grid items-center gap-12
                           lg:grid-cols-[1fr_0.85fr]"
                >
                    <div>

                        <div
                            class="inline-flex items-center gap-2
                                   rounded-full border border-amber-300/50
                                   bg-emerald-900 px-4 py-2
                                   text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-300"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect x="3" y="4" width="18" height="13" rx="2"/>
                                <path d="M8 21h8M12 17v4"/>
                            </svg>

                            {{ $smartSchool['etiqueta'] ?? 'Innovación educativa' }}
                        </div>

                        <h2
                            class="mt-6 text-3xl font-extrabold
                                   sm:text-4xl lg:text-5xl"
                        >
                            {{ $smartSchool['titulo'] ?? 'Primera aula Smart School del país' }}
                        </h2>

                        <p class="mt-6 max-w-3xl leading-8 text-emerald-100">
                            {{ $smartSchool['parrafo_1']
                                ?? 'El 21 de noviembre de 2013 se inauguró un aula inteligente equipada con herramientas tecnológicas interactivas para fortalecer el rendimiento y la experiencia de aprendizaje.' }}
                        </p>

                        <p class="mt-4 max-w-3xl leading-8 text-emerald-100">
                            {{ $smartSchool['parrafo_2']
                                ?? 'El proyecto integró asesoría institucional, capacitación docente, acompañamiento pedagógico, mejora de los aprendizajes e inclusión digital para las familias.' }}
                        </p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">

                            @foreach ($beneficiosSmart as $beneficio)

                                <div
                                    class="flex items-center gap-3
                                           rounded-2xl border border-emerald-700
                                           bg-emerald-900/70 px-4 py-3"
                                >
                                    <span
                                        class="flex h-8 w-8 shrink-0 items-center
                                               justify-center rounded-xl
                                               bg-amber-300 text-emerald-950"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path d="m6 12 4 4 8-8"/>
                                        </svg>
                                    </span>

                                    <span class="text-sm font-bold">
                                        {{ $beneficio }}
                                    </span>
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <div
                        class="overflow-hidden rounded-[32px] border border-amber-300
                               bg-emerald-900"
                    >
                        @if (!empty($smartSchool['imagen']))
                            <img
                                src="{{ asset('storage/' . $smartSchool['imagen']) }}"
                                alt="{{ $smartSchool['titulo'] ?? 'Smart School' }}"
                                class="h-64 w-full object-cover"
                            >
                        @endif

                        <div class="p-8">
                        <div
                            class="flex h-20 w-20 items-center
                                   justify-center rounded-[26px]
                                   border border-amber-300
                                   bg-emerald-950 text-amber-300"
                        >
                            <svg
                                class="h-10 w-10"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <rect x="3" y="4" width="18" height="13" rx="2"/>
                                <path d="M8 21h8M12 17v4"/>
                                <path d="M7 9h3M12 9h5M7 12h10"/>
                            </svg>
                        </div>

                        <p
                            class="mt-7 text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-300"
                        >
                            {{ $smartSchool['fecha_etiqueta'] ?? 'Fecha de inauguración' }}
                        </p>

                        <p class="mt-3 text-3xl font-extrabold">
                            {{ $smartSchool['fecha'] ?? '21 de noviembre de 2013' }}
                        </p>

                        <div class="mt-7 h-px bg-emerald-700"></div>

                        <p class="mt-7 text-sm leading-7 text-emerald-100">
                            {{ $smartSchool['participantes']
                                ?? 'Iniciativa desarrollada con Samsung, empresarios de la educación y el Gobierno Regional de Piura.' }}
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Cierre --}}
        <section class="relative py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="overflow-hidden rounded-[36px]
                           border border-amber-200 bg-white
                           shadow-[0_22px_65px_rgba(6,78,59,0.11)]"
                >
                    <div
                        class="grid items-stretch
                               lg:grid-cols-[1fr_0.45fr]"
                    >
                        <div class="p-8 sm:p-10 lg:p-12">

                            <div
                                class="flex h-14 w-14 items-center
                                       justify-center rounded-2xl
                                       border border-amber-300
                                       bg-emerald-950 text-amber-300"
                            >
                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7z"/>
                                    <path d="m8 12 2.5 2.5L16 9"/>
                                </svg>
                            </div>

                            <p
                                class="mt-7 text-xs font-extrabold uppercase
                                       tracking-[0.18em] text-amber-600"
                            >
                                {{ $legado['etiqueta'] ?? 'Legado institucional' }}
                            </p>

                            <h2
                                class="mt-3 text-3xl font-extrabold
                                       text-emerald-950 sm:text-4xl"
                            >
                                {{ $legado['titulo'] ?? 'Una historia construida con esfuerzo y compromiso' }}
                            </h2>

                            <p class="mt-5 max-w-4xl leading-8 text-gray-600">
                                {{ $legado['parrafo_1']
                                    ?? 'A lo largo de su trayectoria, la institución ha trabajado de manera permanente para mejorar sus ambientes, fortalecer la enseñanza y ofrecer mejores oportunidades de formación.' }}
                            </p>

                            <p class="mt-4 max-w-4xl leading-8 text-gray-600">
                                {{ $legado['parrafo_2']
                                    ?? 'La Dirección General continúa promoviendo el bienestar de los estudiantes mediante talleres, actividades deportivas, música, innovación tecnológica y mejoras continuas de la infraestructura.' }}
                            </p>
                        </div>

                        <div
                            class="flex items-center justify-center
                                   border-t border-amber-200
                                   bg-emerald-950 p-10
                                   text-center text-white
                                   lg:border-l lg:border-t-0"
                        >
                            <div>
                                <div
                                    class="mx-auto flex h-24 w-24
                                           items-center justify-center
                                           rounded-[28px] border
                                           border-amber-300 bg-emerald-900
                                           text-amber-300"
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

                                <p
                                    class="mt-6 text-xs font-extrabold
                                           uppercase tracking-[0.18em]
                                           text-amber-300"
                                >
                                    {{ $legado['compromiso_etiqueta'] ?? 'Nuestro compromiso' }}
                                </p>

                                <p class="mt-3 text-xl font-extrabold">
                                    {{ $legado['compromiso'] ?? 'Seguir creciendo al servicio de la educación' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</x-public-layout>