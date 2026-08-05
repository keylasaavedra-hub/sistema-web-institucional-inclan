<x-public-layout :title="$video->titulo">

    <section class="relative overflow-hidden bg-gray-50 py-20">
        <div class="pointer-events-none absolute -left-24 top-0 h-80 w-80 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('videos.index') }}"
                class="inline-flex items-center gap-2 text-sm font-extrabold text-emerald-800 transition hover:text-emerald-950"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Volver a videos
            </a>

            <article class="mt-8 overflow-hidden rounded-[36px] border border-amber-300 bg-white shadow-2xl shadow-emerald-950/15">

                <div class="bg-emerald-950 p-5 sm:p-7">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full border border-amber-300 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.14em] text-amber-300">
                            {{ $video->categoria }}
                        </span>

                        @if ($video->destacado)
                            <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.14em] text-white">
                                Video destacado
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-5 font-serif text-3xl font-semibold leading-tight text-white sm:text-4xl lg:text-5xl">
                        {{ $video->titulo }}
                    </h1>

                    @if ($video->fecha_publicacion)
                        <p class="mt-4 text-sm font-semibold text-emerald-100">
                            Publicado el
                            {{ $video->fecha_publicacion->locale('es')->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                    @endif
                </div>

                <div class="aspect-video bg-black">
                    @if ($video->url_insercion)
                        <iframe
                            src="{{ $video->url_insercion }}"
                            title="{{ $video->titulo }}"
                            class="h-full w-full"
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    @else
                        <div class="flex h-full items-center justify-center px-6 text-center text-white">
                            <p>No se pudo cargar el video.</p>
                        </div>
                    @endif
                </div>

                <div class="p-7 sm:p-10">
                    @if ($video->descripcion)
                        <h2 class="text-xl font-extrabold text-emerald-950">
                            Descripción
                        </h2>

                        <div class="mt-4 whitespace-pre-line text-base leading-8 text-gray-600">
                            {{ $video->descripcion }}
                        </div>
                    @endif

                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <a
                            href="{{ $video->url_youtube }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-400 bg-emerald-950 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-900"
                        >
                            Ver directamente en YouTube ↗
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

</x-public-layout>