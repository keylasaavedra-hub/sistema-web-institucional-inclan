<x-public-layout>

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('convocatorias.index') }}"
                class="font-extrabold text-emerald-800 hover:text-emerald-950">
                ← Volver a convocatorias
            </a>

            <article
                class="mt-6 overflow-hidden rounded-[30px]
                       border border-gray-200 bg-white
                       shadow-[0_20px_55px_rgba(15,23,42,0.08)]">
                <header class="bg-emerald-950 p-8 text-white">
                    <div class="flex flex-wrap gap-3">
                        <span
                            class="rounded-full border border-emerald-400/40
                                   bg-white/10 px-3 py-1 text-xs font-extrabold">
                            {{ ucfirst($convocatoria->tipo) }}
                        </span>

                        @if ($convocatoria->destacada)
                        <span
                            class="rounded-full bg-amber-400 px-3 py-1
                                       text-xs font-extrabold text-emerald-950">
                            Destacada
                        </span>
                        @endif
                    </div>

                    <h1 class="mt-5 text-3xl font-extrabold">
                        {{ $convocatoria->titulo }}
                    </h1>

                    <p class="mt-3 text-emerald-100">
                        Código: {{ $convocatoria->codigo }}
                    </p>
                </header>

                <div class="space-y-8 p-7 sm:p-9">

                    <div class="grid gap-5 sm:grid-cols-3">
                        <div class="rounded-2xl bg-emerald-50 p-5">
                            <p class="text-xs font-extrabold uppercase text-gray-500">
                                Vacantes
                            </p>
                            <p class="mt-2 text-2xl font-extrabold text-emerald-950">
                                {{ $convocatoria->vacantes }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-emerald-50 p-5">
                            <p class="text-xs font-extrabold uppercase text-gray-500">
                                Inicio
                            </p>
                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $convocatoria->fecha_inicio->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-emerald-50 p-5">
                            <p class="text-xs font-extrabold uppercase text-gray-500">
                                Cierre
                            </p>
                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $convocatoria->fecha_cierre->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <section>
                        <h2 class="text-xl font-extrabold text-emerald-950">
                            Descripción
                        </h2>
                        <div class="mt-3 whitespace-pre-line leading-8 text-gray-700">
                            {{ $convocatoria->descripcion }}
                        </div>
                    </section>

                    @if ($convocatoria->perfil)
                    <section>
                        <h2 class="text-xl font-extrabold text-emerald-950">
                            Perfil solicitado
                        </h2>
                        <div class="mt-3 whitespace-pre-line leading-8 text-gray-700">
                            {{ $convocatoria->perfil }}
                        </div>
                    </section>
                    @endif

                    @if ($convocatoria->requisitos)
                    <section>
                        <h2 class="text-xl font-extrabold text-emerald-950">
                            Requisitos
                        </h2>
                        <div class="mt-3 whitespace-pre-line leading-8 text-gray-700">
                            {{ $convocatoria->requisitos }}
                        </div>
                    </section>
                    @endif

                    @if ($convocatoria->cronograma)
                    <section>
                        <h2 class="text-xl font-extrabold text-emerald-950">
                            Cronograma
                        </h2>
                        <div class="mt-3 whitespace-pre-line leading-8 text-gray-700">
                            {{ $convocatoria->cronograma }}
                        </div>
                    </section>
                    @endif

                    <div
                        class="rounded-2xl border border-amber-200
                               bg-amber-50 p-5 text-amber-900">
                        <p class="font-extrabold">
                            Área responsable:
                            {{ $convocatoria->area?->nombre ?: 'No especificada' }}
                        </p>

                        @if ($convocatoria->cargo)
                        <p class="mt-2">
                            Cargo: {{ $convocatoria->cargo->nombre }}
                        </p>
                        @endif
                    </div>

                    <section
                        class="rounded-[24px] border border-emerald-200
           bg-emerald-50 p-6">
                        <div class="flex flex-col gap-5 sm:flex-row
                sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-extrabold text-emerald-950">
                                    ¿Deseas participar?
                                </h2>

                                @if (
                                now()->between(
                                $convocatoria->fecha_inicio,
                                $convocatoria->fecha_cierre
                                )
                                )
                                <p class="mt-2 text-sm leading-6 text-emerald-800">
                                    La convocatoria está disponible. Completa el formulario
                                    para registrar tu postulación.
                                </p>
                                @elseif (now()->lt($convocatoria->fecha_inicio))
                                <p class="mt-2 text-sm leading-6 text-blue-700">
                                    La postulación estará disponible desde
                                    {{ $convocatoria->fecha_inicio->format('d/m/Y H:i') }}.
                                </p>
                                @else
                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    El periodo de postulación finalizó el
                                    {{ $convocatoria->fecha_cierre->format('d/m/Y H:i') }}.
                                </p>
                                @endif
                            </div>

                            @if (
                            now()->between(
                            $convocatoria->fecha_inicio,
                            $convocatoria->fecha_cierre
                            )
                            )
                            <a
                                href="{{ route('postulaciones.crear', $convocatoria) }}"
                                class="inline-flex shrink-0 items-center justify-center
                       rounded-xl bg-emerald-950 px-6 py-3
                       font-extrabold text-white transition
                       hover:bg-emerald-900">
                                Postular ahora
                            </a>
                            @else
                            <span
                                class="inline-flex shrink-0 items-center justify-center
                       rounded-xl bg-gray-200 px-6 py-3
                       font-extrabold text-gray-600">
                                Postulación no disponible
                            </span>
                            @endif
                        </div>
                    </section>

                </div>
            </article>
        </div>
    </section>

</x-public-layout>