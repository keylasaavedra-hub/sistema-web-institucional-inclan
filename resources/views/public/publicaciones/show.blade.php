<x-public-layout :title="$publicacion->titulo">

    @php
    $portadaEnStorage = $publicacion->imagen_portada
    && \Illuminate\Support\Facades\Storage::disk('public')
    ->exists($publicacion->imagen_portada);

    $portadaEnPublic = $publicacion->imagen_portada
    && file_exists(public_path($publicacion->imagen_portada));

    if ($portadaEnStorage) {
    $imagen = asset('storage/' . $publicacion->imagen_portada);
    } elseif ($portadaEnPublic) {
    $imagen = asset($publicacion->imagen_portada);
    } else {
    $imagen = asset('images/noticia-default.jpg');
    }

    $adjuntoEnStorage = $publicacion->archivo_adjunto
    && \Illuminate\Support\Facades\Storage::disk('public')
    ->exists($publicacion->archivo_adjunto);

    $adjuntoEnPublic = $publicacion->archivo_adjunto
    && file_exists(public_path($publicacion->archivo_adjunto));

    $archivoDisponible = $adjuntoEnStorage || $adjuntoEnPublic;

    if ($adjuntoEnStorage) {
    $urlAdjunto = asset('storage/' . $publicacion->archivo_adjunto);
    } elseif ($adjuntoEnPublic) {
    $urlAdjunto = asset($publicacion->archivo_adjunto);
    } else {
    $urlAdjunto = null;
    }
    @endphp

    <article class="bg-gray-50">

        <header class="relative overflow-hidden bg-emerald-950 py-16 text-white">
            <div class="absolute -left-24 top-0 h-80 w-80 rounded-full bg-amber-300/10 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-emerald-400/20 blur-3xl"></div>

            <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

                <a
                    href="{{ route('publicaciones.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-amber-300 hover:text-white">
                    ← Volver a noticias
                </a>

                <div class="mt-8">

                    <span class="rounded-full bg-amber-400 px-3 py-1 text-xs font-bold text-emerald-950">
                        {{ $publicacion->categoria ?? 'Publicación' }}
                    </span>

                    <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">
                        {{ $publicacion->titulo }}
                    </h1>

                    <p class="mt-5 text-sm font-semibold text-emerald-100">
                        Publicado el
                        {{ $publicacion->fecha_publicacion
                            ? \Illuminate\Support\Carbon::parse(
                                $publicacion->fecha_publicacion
                            )->format('d/m/Y')
                            : 'fecha no especificada' }}
                    </p>

                </div>
            </div>
        </header>

        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-3xl bg-gray-200 shadow-xl">
                <img
                    src="{{ $imagen }}"
                    alt="{{ $publicacion->titulo }}"
                    class="max-h-[620px] w-full object-cover">
            </div>

            <div class="mt-10 rounded-3xl bg-white p-7 shadow-sm sm:p-10">

                <div class="prose prose-lg max-w-none prose-headings:text-emerald-950 prose-a:text-emerald-700">
                    {!! nl2br(e($publicacion->contenido)) !!}
                </div>

                @if ($archivoDisponible)
                <div class="mt-10 border-t border-gray-100 pt-8">

                    <h2 class="text-xl font-extrabold text-emerald-950">
                        Documento adjunto
                    </h2>

                    <a
                        href="{{ $urlAdjunto }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-800 px-6 py-3 font-bold text-white transition hover:bg-emerald-700">
                        Abrir documento
                    </a>

                </div>
                @endif

            </div>

            @if ($relacionadas->isNotEmpty())

            <section class="mt-16">

                <h2 class="text-3xl font-extrabold text-emerald-950">
                    También puede interesarte
                </h2>

                <div class="mt-8 grid gap-6 md:grid-cols-3">

                    @foreach ($relacionadas as $relacionada)

                    @php
                    $imagenRelacionada = $relacionada->imagen_portada
                    && file_exists(public_path($relacionada->imagen_portada))
                    ? asset($relacionada->imagen_portada)
                    : asset('images/noticia-default.jpg');
                    @endphp

                    <a
                        href="{{ route('publicaciones.show', $relacionada->slug) }}"
                        class="group overflow-hidden rounded-2xl bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <img
                            src="{{ $imagenRelacionada }}"
                            alt="{{ $relacionada->titulo }}"
                            class="h-44 w-full object-cover transition duration-500 group-hover:scale-105">

                        <div class="p-5">
                            <p class="text-xs font-bold text-amber-600">
                                {{ $relacionada->categoria ?? 'Publicación' }}
                            </p>

                            <h3 class="mt-2 font-extrabold text-emerald-950">
                                {{ $relacionada->titulo }}
                            </h3>
                        </div>
                    </a>

                    @endforeach

                </div>
            </section>

            @endif

        </div>
    </article>

</x-public-layout>