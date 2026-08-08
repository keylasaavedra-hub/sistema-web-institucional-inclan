<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Acceso administrativo | IE José Joaquín Inclán
    </title>

    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="font-sans antialiased">

    <main
        class="relative min-h-screen overflow-hidden
               bg-slate-50"
    >
        {{-- Decoración --}}
        <div
            class="pointer-events-none absolute -left-32 -top-32
                   h-[500px] w-[500px] rounded-full
                   bg-amber-200/30 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-40 -right-32
                   h-[550px] w-[550px] rounded-full
                   bg-emerald-200/30 blur-3xl"
        ></div>

        <div
            class="relative grid min-h-screen
                   lg:grid-cols-[1.05fr_0.95fr]"
        >
            {{-- Panel institucional --}}
            <section
                class="relative hidden overflow-hidden
                       bg-emerald-950 lg:flex"
            >
                <img
                    src="{{ asset('images/portada-institucion.jpg') }}"
                    alt="IE Crl. José Joaquín Inclán"
                    class="absolute inset-0 h-full w-full
                           object-cover opacity-35"
                >

                <div
                    class="absolute inset-0
                           bg-gradient-to-br
                           from-emerald-950
                           via-emerald-950/90
                           to-emerald-900/75"
                ></div>

                <div
                    class="relative z-10 flex w-full flex-col
                           justify-between p-12 xl:p-16"
                >
                    <a
                        href="{{ route('inicio') }}"
                        class="flex w-fit items-center gap-4"
                    >
                        <div
                            class="flex h-16 w-16 items-center
                                   justify-center rounded-2xl
                                   border border-amber-300
                                   bg-white shadow-xl"
                        >
                            <x-application-logo
                                class="h-11 w-11 fill-current
                                       text-emerald-950"
                            />
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.2em]
                                       text-amber-300"
                            >
                                Portal institucional
                            </p>

                            <p
                                class="mt-1 text-xl font-extrabold
                                       text-white"
                            >
                                IE José Joaquín Inclán
                            </p>
                        </div>
                    </a>

                    <div class="max-w-xl">
                        <p
                            class="text-sm font-extrabold uppercase
                                   tracking-[0.22em]
                                   text-amber-300"
                        >
                            Sistema administrativo
                        </p>

                        <h1
                            class="mt-5 font-serif text-5xl
                                   font-semibold leading-tight
                                   text-white xl:text-6xl"
                        >
                            Gestión institucional
                            segura y centralizada
                        </h1>

                        <div class="mt-7 flex items-center gap-3">
                            <span
                                class="h-px w-20 bg-amber-400"
                            ></span>

                            <span
                                class="h-2 w-2 rounded-full bg-white"
                            ></span>
                        </div>

                        <p
                            class="mt-7 max-w-lg text-lg
                                   leading-8 text-emerald-50"
                        >
                            Acceso exclusivo para el personal autorizado
                            de la Institución Educativa Crl. José Joaquín
                            Inclán.
                        </p>
                    </div>

                    <p class="text-sm text-emerald-200">
                        Dios · Patria · Cultura
                    </p>
                </div>
            </section>

            {{-- Zona de autenticación --}}
            <section
                class="flex min-h-screen items-center
                       justify-center px-5 py-12
                       sm:px-8 lg:px-12"
            >
                <div class="w-full max-w-md">

                    {{-- Logo móvil --}}
                    <a
                        href="{{ route('inicio') }}"
                        class="mb-10 flex items-center
                               justify-center gap-3 lg:hidden"
                    >
                        <div
                            class="flex h-14 w-14 items-center
                                   justify-center rounded-2xl
                                   bg-emerald-950 text-white"
                        >
                            <x-application-logo
                                class="h-9 w-9 fill-current"
                            />
                        </div>

                        <div>
                            <p
                                class="text-xs font-extrabold uppercase
                                       tracking-[0.16em]
                                       text-amber-600"
                            >
                                IE J.J. Inclán
                            </p>

                            <p
                                class="font-extrabold
                                       text-emerald-950"
                            >
                                Portal institucional
                            </p>
                        </div>
                    </a>

                    <div
                        class="overflow-hidden rounded-[32px]
                               border border-amber-200
                               bg-white p-7
                               shadow-2xl
                               shadow-emerald-950/10
                               sm:p-9"
                    >
                        {{ $slot }}
                    </div>

                    <div class="mt-7 text-center">
                        <a
                            href="{{ route('inicio') }}"
                            class="inline-flex items-center gap-2
                                   text-sm font-bold
                                   text-emerald-800
                                   transition
                                   hover:text-emerald-950"
                        >
                            ← Volver al portal institucional
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>