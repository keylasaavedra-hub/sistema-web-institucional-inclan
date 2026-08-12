<x-public-layout title="Convenios institucionales">

    @php
        $conveniosRespaldo = [
            [
                'nombre' => 'Alianzas educativas',
                'institucion' => 'Instituciones de educación y formación',
                'descripcion' => 'Convenios orientados al fortalecimiento académico y al desarrollo de actividades educativas.',
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'logo' => null,
            ],
            [
                'nombre' => 'Cooperación institucional',
                'institucion' => 'Entidades públicas y privadas',
                'descripcion' => 'Acciones conjuntas para promover oportunidades, servicios y beneficios para la comunidad educativa.',
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'logo' => null,
            ],
            [
                'nombre' => 'Proyección comunitaria',
                'institucion' => 'Organizaciones de la comunidad',
                'descripcion' => 'Colaboraciones que fortalecen la participación ciudadana, la convivencia y el compromiso social.',
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'logo' => null,
            ],
        ];
    @endphp

    <section class="relative overflow-hidden bg-white py-24">

        <div
            class="pointer-events-none absolute -left-24 top-10 h-80 w-80
                   rounded-full bg-emerald-200/30 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80
                   rounded-full bg-amber-200/40 blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

            <div class="mx-auto mt-10 max-w-3xl text-center">

                <p
                    class="text-sm font-extrabold uppercase
                           tracking-[0.2em] text-amber-600"
                >
                    Alianzas estratégicas
                </p>

                <h1
                    class="mt-4 text-4xl font-extrabold tracking-tight
                           text-emerald-950 sm:text-5xl"
                >
                    Convenios institucionales
                </h1>

                <div class="mt-5 flex items-center justify-center gap-3">
                    <span class="h-1 w-16 rounded-full bg-emerald-700"></span>
                    <span class="h-1 w-9 rounded-full bg-amber-400"></span>
                </div>

                <p class="mt-6 text-base leading-8 text-gray-600">
                    Promovemos alianzas con instituciones públicas,
                    privadas y organizaciones que contribuyen al desarrollo
                    integral de nuestra comunidad educativa.
                </p>
            </div>

            <div class="mt-16 grid gap-7 lg:grid-cols-3">

                @forelse ($convenios as $convenio)

                    @php
                        $fechaInicio = $convenio->fecha_inicio
                            ? \Illuminate\Support\Carbon::parse($convenio->fecha_inicio)
                            : null;

                        $fechaFin = $convenio->fecha_fin
                            ? \Illuminate\Support\Carbon::parse($convenio->fecha_fin)
                            : null;

                        $imagenConvenio = null;

                        if (!empty($convenio->imagen)) {
                            $rutaImagen = ltrim($convenio->imagen, '/');

                            $imagenConvenio = str_starts_with(
                                $rutaImagen,
                                'images/'
                            )
                                ? asset($rutaImagen)
                                : asset('storage/' . $rutaImagen);
                        }
                    @endphp

                    <article
                        class="group flex h-full flex-col overflow-hidden
                               rounded-[30px] border border-amber-200 bg-white
                               shadow-[0_18px_50px_rgba(6,78,59,0.10)]
                               transition duration-300
                               hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="relative flex h-48 items-center justify-center
                                   overflow-hidden bg-emerald-950 p-8"
                        >
                            <div
                                class="absolute -right-10 -top-10 z-10 h-32 w-32
                                       rounded-full bg-amber-300/10"
                            ></div>

                            @if ($imagenConvenio)
                                <img
                                    src="{{ $imagenConvenio }}"
                                    alt="{{ $convenio->nombre }}"
                                    class="absolute inset-0 h-full w-full object-cover"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >
                            @endif

                            <div
                                class="{{ $imagenConvenio ? 'hidden' : 'flex' }}
                                       relative z-10 h-20 w-20 items-center justify-center
                                       rounded-3xl border border-amber-300
                                       bg-emerald-900 text-amber-300"
                            >
                                <svg
                                    class="h-10 w-10"
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
                        </div>

                        <div class="flex flex-1 flex-col p-7">

                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em] text-amber-600"
                            >
                                {{ $convenio->institucion ?? 'Institución aliada' }}
                            </p>

                            <h2 class="mt-3 text-xl font-extrabold text-emerald-950">
                                {{ $convenio->nombre }}
                            </h2>

                            @if ($convenio->descripcion)
                                <p class="mt-4 text-sm leading-7 text-gray-600">
                                    {{ $convenio->descripcion }}
                                </p>
                            @endif

                            @if ($fechaInicio || $fechaFin)
                                <div class="mt-auto pt-6">

                                    <div
                                        class="rounded-2xl border border-emerald-100
                                               bg-emerald-50 px-4 py-3"
                                    >
                                        <p
                                            class="text-xs font-extrabold uppercase
                                                   tracking-[0.14em] text-emerald-800"
                                        >
                                            Vigencia
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-gray-700">

                                            @if ($fechaInicio && $fechaFin)
                                                Del {{ $fechaInicio->format('d/m/Y') }}
                                                al {{ $fechaFin->format('d/m/Y') }}
                                            @elseif ($fechaInicio)
                                                Desde el {{ $fechaInicio->format('d/m/Y') }}
                                            @else
                                                Hasta el {{ $fechaFin->format('d/m/Y') }}
                                            @endif

                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>

                @empty

                    @foreach ($conveniosRespaldo as $convenio)

                        <article
                            class="group flex h-full flex-col overflow-hidden
                                   rounded-[30px] border border-amber-200 bg-white
                                   shadow-[0_18px_50px_rgba(6,78,59,0.10)]
                                   transition duration-300
                                   hover:-translate-y-1 hover:shadow-xl"
                        >
                            <div
                                class="relative flex h-48 items-center justify-center
                                       overflow-hidden bg-emerald-950 p-8"
                            >
                                <div
                                    class="absolute -right-10 -top-10 h-32 w-32
                                           rounded-full bg-amber-300/10"
                                ></div>

                                <div
                                    class="relative flex h-20 w-20 items-center
                                           justify-center rounded-3xl
                                           border border-amber-300 bg-emerald-900
                                           text-amber-300"
                                >
                                    <svg
                                        class="h-10 w-10"
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
                            </div>

                            <div class="flex flex-1 flex-col p-7">

                                <p
                                    class="text-xs font-extrabold uppercase
                                           tracking-[0.16em] text-amber-600"
                                >
                                    {{ $convenio['institucion'] }}
                                </p>

                                <h2 class="mt-3 text-xl font-extrabold text-emerald-950">
                                    {{ $convenio['nombre'] }}
                                </h2>

                                <p class="mt-4 text-sm leading-7 text-gray-600">
                                    {{ $convenio['descripcion'] }}
                                </p>
                            </div>
                        </article>

                    @endforeach

                @endforelse
            </div>

            <div
                class="mt-14 overflow-hidden rounded-[32px]
                       border border-amber-200 bg-emerald-50"
            >
                <div class="grid items-center gap-8 p-8 lg:grid-cols-[auto_1fr] lg:p-10">

                    <div
                        class="flex h-20 w-20 items-center justify-center
                               rounded-3xl border border-amber-300
                               bg-emerald-950 text-amber-300"
                    >
                        <svg
                            class="h-10 w-10"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M8 12h8"/>
                            <path d="M12 8v8"/>
                        </svg>
                    </div>

                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-600"
                        >
                            Trabajo colaborativo
                        </p>

                        <h2 class="mt-3 text-3xl font-extrabold text-emerald-950">
                            Construimos oportunidades en conjunto
                        </h2>

                        <p class="mt-4 max-w-4xl leading-8 text-gray-600">
                            Cada convenio fortalece las oportunidades de
                            aprendizaje, orientación, participación y desarrollo
                            para nuestros estudiantes y demás integrantes de la
                            comunidad educativa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>