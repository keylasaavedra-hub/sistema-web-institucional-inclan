<x-public-layout>

    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div
                class="overflow-hidden rounded-[30px]
                       border border-emerald-200 bg-white
                       shadow-[0_20px_55px_rgba(15,23,42,0.08)]"
            >
                <div class="bg-emerald-950 p-8 text-center text-white sm:p-10">
                    <div
                        class="mx-auto flex h-20 w-20 items-center justify-center
                               rounded-full bg-white/10"
                    >
                        <svg
                            class="h-11 w-11 text-amber-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                    </div>

                    <p
                        class="mt-6 text-xs font-extrabold uppercase
                               tracking-[0.18em] text-amber-300"
                    >
                        Registro completado
                    </p>

                    <h1 class="mt-3 text-3xl font-extrabold sm:text-4xl">
                        Postulación registrada correctamente
                    </h1>

                    <p class="mx-auto mt-4 max-w-2xl leading-7 text-emerald-100">
                        Tu información fue recibida por la institución. Conserva
                        el código de seguimiento para consultar el estado del proceso.
                    </p>
                </div>

                <div class="space-y-8 p-6 sm:p-9">

                    <section
                        class="rounded-[26px] border border-amber-200
                               bg-amber-50 p-6 text-center"
                    >
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-700"
                        >
                            Código de postulación
                        </p>

                        <p
                            id="codigo-postulacion"
                            class="mt-3 break-all text-3xl font-extrabold
                                   tracking-wide text-emerald-950 sm:text-4xl"
                        >
                            {{ $postulacion->codigo }}
                        </p>

                        <button
                            type="button"
                            onclick="copiarCodigo()"
                            class="mt-5 inline-flex items-center justify-center gap-2
                                   rounded-xl bg-emerald-950 px-5 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>

                            Copiar código
                        </button>

                        <p
                            id="mensaje-copia"
                            class="mt-3 hidden text-sm font-bold text-emerald-700"
                        >
                            Código copiado correctamente.
                        </p>
                    </section>

                    <section class="grid gap-5 sm:grid-cols-2">
                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-5"
                        >
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Convocatoria
                            </p>

                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $postulacion->convocatoria->titulo }}
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-5"
                        >
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Estado inicial
                            </p>

                            <p class="mt-2 font-extrabold text-blue-700">
                                Recibida
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-5"
                        >
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Postulante
                            </p>

                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $postulacion->nombres }}
                                {{ $postulacion->apellidos }}
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-gray-200
                                   bg-gray-50 p-5"
                        >
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.14em] text-gray-500"
                            >
                                Fecha de registro
                            </p>

                            <p class="mt-2 font-extrabold text-emerald-950">
                                {{ $postulacion->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </section>

                    <section
                        class="rounded-2xl border border-blue-200
                               bg-blue-50 p-5"
                    >
                        <p class="font-extrabold text-blue-900">
                            Datos para consultar tu postulación
                        </p>

                        <p class="mt-2 text-sm leading-6 text-blue-800">
                            Necesitarás el código mostrado arriba y tu DNI o correo
                            electrónico registrado.
                        </p>
                    </section>

                    <div
                        class="flex flex-col gap-3 border-t border-gray-100 pt-7
                               sm:flex-row sm:justify-center"
                    >
                        <a
                            href="{{ route('postulaciones.seguimiento') }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl bg-emerald-950 px-6 py-3
                                   font-extrabold text-white transition
                                   hover:bg-emerald-900"
                        >
                            Consultar postulación
                        </a>

                        <a
                            href="{{ route('convocatorias.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl border border-gray-300 bg-white
                                   px-6 py-3 font-extrabold text-gray-700
                                   transition hover:bg-gray-50"
                        >
                            Ver más convocatorias
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copiarCodigo() {
            const codigo = document
                .getElementById('codigo-postulacion')
                .innerText
                .trim();

            navigator.clipboard.writeText(codigo).then(() => {
                const mensaje = document.getElementById('mensaje-copia');

                mensaje.classList.remove('hidden');

                setTimeout(() => {
                    mensaje.classList.add('hidden');
                }, 2500);
            });
        }
    </script>

</x-public-layout>