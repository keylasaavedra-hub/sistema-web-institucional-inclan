<x-public-layout title="Noticias y comunicados">

    <section class="relative overflow-hidden bg-emerald-950 py-20 text-white">
        <div class="absolute -left-24 top-0 h-80 w-80 rounded-full bg-amber-300/10 blur-3xl"></div>
        <div class="absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-emerald-400/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">
                Actualidad institucional
            </p>

            <h1 class="mt-3 text-4xl font-extrabold sm:text-5xl">
                Noticias y comunicados
            </h1>

            <p class="mt-5 max-w-2xl text-lg leading-8 text-emerald-100">
                Conoce las actividades, comunicados y novedades de nuestra
                institución educativa.
            </p>
        </div>
    </section>

    <main class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($publicaciones as $publicacion)

                    @php
                        $imagen = $publicacion->imagen_portada
                            && file_exists(public_path($publicacion->imagen_portada))
                                ? asset($publicacion->imagen_portada)
                                : asset('images/noticia-default.jpg');
                    @endphp

                    <article class="group overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg transition hover:-translate-y-1 hover:shadow-xl">

                        <a href="{{ route('publicaciones.show', $publicacion->slug) }}">
                            <div class="relative h-60 overflow-hidden bg-gray-100">

                                <img
                                    src="{{ $imagen }}"
                                    alt="{{ $publicacion->titulo }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                                @if ($publicacion->destacada)
                                    <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1 text-xs font-bold text-emerald-950">
                                        Destacada
                                    </span>
                                @endif

                            </div>
                        </a>

                        <div class="p-7">

                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                {{ $publicacion->categoria ?? 'Publicación' }}
                            </span>

                            <h2 class="mt-4 text-xl font-extrabold text-emerald-950">
                                <a
                                    href="{{ route('publicaciones.show', $publicacion->slug) }}"
                                    class="transition hover:text-emerald-700"
                                >
                                    {{ $publicacion->titulo }}
                                </a>
                            </h2>

                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($publicacion->contenido),
                                    145
                                ) }}
                            </p>

                            <div class="mt-6 flex items-center justify-between gap-4">

                                <span class="text-xs text-gray-500">
                                    {{ $publicacion->fecha_publicacion
                                        ? \Illuminate\Support\Carbon::parse(
                                            $publicacion->fecha_publicacion
                                        )->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </span>

                                <a
                                    href="{{ route('publicaciones.show', $publicacion->slug) }}"
                                    class="text-sm font-bold text-emerald-700 hover:text-emerald-900"
                                >
                                    Leer más →
                                </a>

                            </div>

                        </div>
                    </article>

                @empty

                    <div class="md:col-span-2 lg:col-span-3 rounded-3xl border border-dashed border-emerald-200 bg-white p-14 text-center">
                        <h2 class="text-2xl font-extrabold text-emerald-950">
                            No hay publicaciones disponibles
                        </h2>

                        <p class="mt-3 text-gray-600">
                            Las nuevas noticias y comunicados aparecerán aquí.
                        </p>
                    </div>

                @endforelse

            </div>

            @if ($publicaciones->hasPages())
                <div class="mt-12">
                    {{ $publicaciones->links() }}
                </div>
            @endif

        </div>
    </main>

</x-public-layout>