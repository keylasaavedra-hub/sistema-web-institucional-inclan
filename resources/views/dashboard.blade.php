<x-app-layout>
    @php
        $puede = fn (string $codigo): bool =>
            $esAdministrador || $permisosUsuario->contains($codigo);
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-600">
                    Portal institucional
                </p>

                <h2 class="mt-1 text-2xl font-extrabold text-emerald-950 sm:text-3xl">
                    Panel administrativo
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    I.E. Crl. José Joaquín Inclán
                </p>
            </div>

            <div
                class="flex w-fit items-center gap-3 rounded-2xl
                       border border-emerald-100 bg-emerald-50 px-4 py-3"
            >
                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-emerald-950 text-lg
                           font-extrabold text-white"
                >
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>

                <div>
                    <p class="font-extrabold text-emerald-950">
                        {{ $usuario->name }}
                        {{ $usuario->apellidos ?? '' }}
                    </p>

                    <p class="text-sm font-semibold text-emerald-700">
                        {{ $rol }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- BIENVENIDA --}}
            <section
                class="relative overflow-hidden rounded-[30px]
                       bg-emerald-950 p-7 text-white
                       shadow-[0_22px_55px_rgba(6,78,59,0.20)]
                       sm:p-9"
            >
                <div
                    class="absolute -right-16 -top-20
                           h-60 w-60 rounded-full bg-amber-400/10"
                ></div>

                <div
                    class="absolute -bottom-20 right-28
                           h-44 w-44 rounded-full bg-emerald-400/10"
                ></div>

                <div
                    class="relative z-10 flex flex-col gap-7
                           lg:flex-row lg:items-center
                           lg:justify-between"
                >
                    <div class="max-w-2xl">
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.18em] text-amber-300"
                        >
                            Administración institucional
                        </p>

                        <h3 class="mt-3 text-3xl font-extrabold sm:text-4xl">
                            Bienvenido, {{ $usuario->name }}
                        </h3>

                        <p class="mt-3 max-w-xl leading-7 text-emerald-50">
                            Revisa las actividades recientes, los registros
                            pendientes y los módulos disponibles según tu rol.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        @if ($puede('publicaciones.gestionar'))
                            <a
                                href="{{ route('admin.publicaciones.crear') }}"
                                class="inline-flex items-center justify-center
                                       rounded-xl border border-amber-300
                                       bg-amber-300 px-5 py-3 text-sm
                                       font-extrabold text-emerald-950
                                       transition hover:bg-amber-200"
                            >
                                Nueva publicación
                            </a>
                        @endif

                        <a
                            href="{{ route('inicio') }}"
                            target="_blank"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-xl bg-white px-5 py-3
                                   text-sm font-extrabold text-emerald-950
                                   transition hover:bg-emerald-50"
                        >
                            Ver portal público

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M14 3h7v7" />
                                <path d="M10 14 21 3" />
                                <path d="M21 14v6H4V3h6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </section>

            {{-- ALERTAS PENDIENTES --}}
            @if (
                $puede('consultas.ver')
                || $puede('solicitudes.ver')
                || $puede('postulaciones.revisar')
                || $puede('publicaciones.gestionar')
            )
                <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    @if ($puede('consultas.ver'))
                        <a
                            href="{{ route('admin.consultas.index') }}"
                            class="rounded-[24px] border border-amber-200
                                   bg-amber-50 p-6 transition
                                   hover:-translate-y-1 hover:shadow-lg"
                        >
                            <p class="text-sm font-bold text-amber-800">
                                Consultas pendientes
                            </p>

                            <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                {{ $estadisticas['consultas_pendientes'] }}
                            </p>

                            <p class="mt-3 text-xs font-bold text-amber-700">
                                Revisar consultas →
                            </p>
                        </a>
                    @endif

                    @if ($puede('solicitudes.ver'))
                        <a
                            href="{{ route('admin.tramites.index') }}"
                            class="rounded-[24px] border border-violet-200
                                   bg-violet-50 p-6 transition
                                   hover:-translate-y-1 hover:shadow-lg"
                        >
                            <p class="text-sm font-bold text-violet-800">
                                Trámites pendientes
                            </p>

                            <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                {{ $estadisticas['tramites_pendientes'] }}
                            </p>

                            <p class="mt-3 text-xs font-bold text-violet-700">
                                Revisar trámites →
                            </p>
                        </a>
                    @endif

                    @if ($puede('postulaciones.revisar'))
                        <a
                            href="{{ route('admin.postulaciones.index') }}"
                            class="rounded-[24px] border border-cyan-200
                                   bg-cyan-50 p-6 transition
                                   hover:-translate-y-1 hover:shadow-lg"
                        >
                            <p class="text-sm font-bold text-cyan-800">
                                Postulaciones pendientes
                            </p>

                            <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                {{ $estadisticas['postulaciones_pendientes'] }}
                            </p>

                            <p class="mt-3 text-xs font-bold text-cyan-700">
                                Revisar postulaciones →
                            </p>
                        </a>
                    @endif

                    @if ($puede('publicaciones.gestionar'))
                        <a
                            href="{{ route('admin.eventos.index') }}"
                            class="rounded-[24px] border border-emerald-200
                                   bg-emerald-50 p-6 transition
                                   hover:-translate-y-1 hover:shadow-lg"
                        >
                            <p class="text-sm font-bold text-emerald-800">
                                Próximos eventos
                            </p>

                            <p class="mt-3 text-4xl font-extrabold text-emerald-950">
                                {{ $estadisticas['eventos_proximos'] }}
                            </p>

                            <p class="mt-3 text-xs font-bold text-emerald-700">
                                Administrar calendario →
                            </p>
                        </a>
                    @endif
                </section>
            @endif

            {{-- INDICADORES --}}
            @if (! empty($indicadores))
                <section class="mt-10">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600"
                        >
                            Resumen general
                        </p>

                        <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Indicadores del sistema
                        </h3>
                    </div>

                    <div
                        class="mt-5 grid gap-5 sm:grid-cols-2
                               lg:grid-cols-3 xl:grid-cols-4"
                    >
                        @foreach ($indicadores as $indicador)
                            <article
                                class="rounded-[24px] border border-gray-200
                                       bg-white p-6 shadow-sm transition
                                       hover:-translate-y-1
                                       hover:border-emerald-200
                                       hover:shadow-lg"
                            >
                                <p class="text-sm font-bold text-gray-500">
                                    {{ $indicador['titulo'] }}
                                </p>

                                <p
                                    class="mt-3 text-4xl font-extrabold
                                           text-emerald-950"
                                >
                                    {{ $indicador['valor'] }}
                                </p>

                                <p class="mt-4 text-sm text-gray-500">
                                    {{ $indicador['detalle'] }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- REGISTROS RECIENTES --}}
            @if (
                $puede('consultas.ver')
                || $puede('solicitudes.ver')
                || $puede('publicaciones.gestionar')
                || $puede('postulaciones.revisar')
                || $puede('auditoria.ver')
            )
                <section class="mt-10 grid gap-7 xl:grid-cols-2">
                    {{-- CONSULTAS --}}
                    @if ($puede('consultas.ver'))
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Atención institucional
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Consultas recientes
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.consultas.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver todas
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($ultimasConsultas as $consulta)
                                    <a
                                        href="{{ route(
                                            'admin.consultas.mostrar',
                                            $consulta->id
                                        ) }}"
                                        class="block rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <div
                                            class="flex items-start
                                                   justify-between gap-4"
                                        >
                                            <div class="min-w-0">
                                                <p
                                                    class="truncate font-extrabold
                                                           text-emerald-950"
                                                >
                                                    {{ $consulta->asunto }}
                                                </p>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ trim(
                                                        $consulta->nombres
                                                        .' '
                                                        .$consulta->apellidos
                                                    ) }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ $consulta->codigo }}
                                                    ·
                                                    {{
                                                        \Illuminate\Support\Carbon::parse(
                                                            $consulta->created_at
                                                        )->format('d/m/Y H:i')
                                                    }}
                                                </p>
                                            </div>

                                            <span
                                                class="shrink-0 rounded-full
                                                       bg-amber-100 px-3 py-1
                                                       text-[11px] font-extrabold
                                                       text-amber-800"
                                            >
                                                {{
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        ucfirst($consulta->estado)
                                                    )
                                                }}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay consultas registradas.
                                    </p>
                                @endforelse
                            </div>
                        </article>
                    @endif

                    {{-- TRÁMITES --}}
                    @if ($puede('solicitudes.ver'))
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Mesa de partes
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Trámites recientes
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.tramites.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver todos
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($ultimosTramites as $tramite)
                                    <a
                                        href="{{ route(
                                            'admin.tramites.mostrar',
                                            $tramite->id
                                        ) }}"
                                        class="block rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <div
                                            class="flex items-start
                                                   justify-between gap-4"
                                        >
                                            <div class="min-w-0">
                                                <p
                                                    class="truncate font-extrabold
                                                           text-emerald-950"
                                                >
                                                    {{ $tramite->asunto }}
                                                </p>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{
                                                        $tramite->razon_social
                                                        ?: trim(
                                                            $tramite->nombres
                                                            .' '
                                                            .$tramite->apellidos
                                                        )
                                                    }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ $tramite->codigo }}
                                                    ·
                                                    {{
                                                        \Illuminate\Support\Carbon::parse(
                                                            $tramite->created_at
                                                        )->format('d/m/Y H:i')
                                                    }}
                                                </p>
                                            </div>

                                            <span
                                                class="shrink-0 rounded-full
                                                       bg-violet-100 px-3 py-1
                                                       text-[11px] font-extrabold
                                                       text-violet-800"
                                            >
                                                {{
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        ucfirst($tramite->estado)
                                                    )
                                                }}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay trámites registrados.
                                    </p>
                                @endforelse
                            </div>
                        </article>
                    @endif

                    {{-- PUBLICACIONES --}}
                    @if ($puede('publicaciones.gestionar'))
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Contenido institucional
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Publicaciones recientes
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.publicaciones.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver todas
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($ultimasPublicaciones as $publicacion)
                                    <a
                                        href="{{ route(
                                            'admin.publicaciones.editar',
                                            $publicacion->id
                                        ) }}"
                                        class="block rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <div
                                            class="flex items-start
                                                   justify-between gap-4"
                                        >
                                            <div class="min-w-0">
                                                <p
                                                    class="truncate font-extrabold
                                                           text-emerald-950"
                                                >
                                                    {{ $publicacion->titulo }}
                                                </p>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{
                                                        $publicacion->categoria
                                                        ?? 'Sin categoría'
                                                    }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{
                                                        \Illuminate\Support\Carbon::parse(
                                                            $publicacion->created_at
                                                        )->format('d/m/Y H:i')
                                                    }}
                                                </p>
                                            </div>

                                            <span
                                                class="shrink-0 rounded-full
                                                       bg-emerald-100 px-3 py-1
                                                       text-[11px] font-extrabold
                                                       text-emerald-800"
                                            >
                                                {{ ucfirst($publicacion->estado) }}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay publicaciones registradas.
                                    </p>
                                @endforelse
                            </div>
                        </article>

                        {{-- EVENTOS --}}
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Calendario institucional
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Próximos eventos
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.eventos.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver calendario
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($proximosEventos as $evento)
                                    <a
                                        href="{{ route(
                                            'admin.eventos.edit',
                                            $evento->id
                                        ) }}"
                                        class="flex items-center gap-4
                                               rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <div
                                            class="flex h-14 w-14 shrink-0
                                                   flex-col items-center
                                                   justify-center rounded-2xl
                                                   bg-emerald-950 text-white"
                                        >
                                            <span class="text-lg font-extrabold">
                                                {{
                                                    \Illuminate\Support\Carbon::parse(
                                                        $evento->fecha_inicio
                                                    )->format('d')
                                                }}
                                            </span>

                                            <span
                                                class="text-[10px] font-bold
                                                       uppercase text-amber-300"
                                            >
                                                {{
                                                    \Illuminate\Support\Carbon::parse(
                                                        $evento->fecha_inicio
                                                    )
                                                        ->locale('es')
                                                        ->translatedFormat('M')
                                                }}
                                            </span>
                                        </div>

                                        <div class="min-w-0">
                                            <p
                                                class="truncate font-extrabold
                                                       text-emerald-950"
                                            >
                                                {{ $evento->titulo }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-600">
                                                {{
                                                    $evento->lugar
                                                    ?: 'Lugar por confirmar'
                                                }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{
                                                    \Illuminate\Support\Carbon::parse(
                                                        $evento->fecha_inicio
                                                    )->format('H:i')
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay próximos eventos programados.
                                    </p>
                                @endforelse
                            </div>
                        </article>
                    @endif

                    {{-- POSTULACIONES --}}
                    @if ($puede('postulaciones.revisar'))
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Convocatorias
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Postulaciones recientes
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.postulaciones.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver todas
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($ultimasPostulaciones as $postulacion)
                                    <a
                                        href="{{ route(
                                            'admin.postulaciones.mostrar',
                                            $postulacion->id
                                        ) }}"
                                        class="block rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <p
                                            class="font-extrabold
                                                   text-emerald-950"
                                        >
                                            {{
                                                trim(
                                                    $postulacion->nombres
                                                    .' '
                                                    .$postulacion->apellidos
                                                )
                                            }}
                                        </p>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{
                                                $postulacion->convocatoria
                                                ?? 'Convocatoria no disponible'
                                            }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $postulacion->codigo }}
                                            ·
                                            {{
                                                \Illuminate\Support\Carbon::parse(
                                                    $postulacion->created_at
                                                )->format('d/m/Y H:i')
                                            }}
                                        </p>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay postulaciones registradas.
                                    </p>
                                @endforelse
                            </div>
                        </article>
                    @endif

                    {{-- AUDITORÍA --}}
                    @if ($puede('auditoria.ver'))
                        <article
                            class="rounded-[28px] border border-gray-100
                                   bg-white p-6 shadow-sm"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p
                                        class="text-xs font-extrabold uppercase
                                               tracking-[0.15em] text-amber-600"
                                    >
                                        Seguridad
                                    </p>

                                    <h3
                                        class="mt-1 text-xl font-extrabold
                                               text-emerald-950"
                                    >
                                        Actividad reciente
                                    </h3>
                                </div>

                                <a
                                    href="{{ route('admin.auditorias.index') }}"
                                    class="text-sm font-extrabold
                                           text-emerald-700
                                           hover:text-emerald-950"
                                >
                                    Ver historial
                                </a>
                            </div>

                            <div class="mt-6 space-y-3">
                                @forelse ($ultimasAuditorias as $auditoria)
                                    <a
                                        href="{{ route(
                                            'admin.auditorias.mostrar',
                                            $auditoria
                                        ) }}"
                                        class="block rounded-2xl border
                                               border-gray-100 bg-gray-50
                                               p-4 transition
                                               hover:border-emerald-200
                                               hover:bg-emerald-50"
                                    >
                                        <div
                                            class="flex items-start
                                                   justify-between gap-4"
                                        >
                                            <div class="min-w-0">
                                                <p
                                                    class="truncate font-extrabold
                                                           text-emerald-950"
                                                >
                                                    {{
                                                        $auditoria->descripcion
                                                        ?: 'Acción administrativa'
                                                    }}
                                                </p>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{
                                                        $auditoria->usuario
                                                            ? trim(
                                                                $auditoria->usuario->name
                                                                .' '
                                                                .$auditoria->usuario->apellidos
                                                            )
                                                            : 'Sistema'
                                                    }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{
                                                        $auditoria->created_at
                                                            ?->format('d/m/Y H:i')
                                                    }}
                                                </p>
                                            </div>

                                            <span
                                                class="shrink-0 rounded-full
                                                       bg-slate-100 px-3 py-1
                                                       text-[11px] font-extrabold
                                                       text-slate-700"
                                            >
                                                {{ ucfirst($auditoria->accion) }}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <p
                                        class="rounded-2xl bg-gray-50 p-6
                                               text-center text-sm text-gray-500"
                                    >
                                        No hay actividad registrada.
                                    </p>
                                @endforelse
                            </div>
                        </article>
                    @endif
                </section>
            @endif

            {{-- ACCESOS RÁPIDOS --}}
            @if (! empty($accesosRapidos))
                <section class="mt-10">
                    <div>
                        <p
                            class="text-xs font-extrabold uppercase
                                   tracking-[0.16em] text-amber-600"
                        >
                            Accesos rápidos
                        </p>

                        <h3 class="mt-1 text-xl font-extrabold text-emerald-950">
                            Gestión administrativa
                        </h3>
                    </div>

                    <div
                        class="mt-5 grid gap-4 sm:grid-cols-2
                               lg:grid-cols-3 xl:grid-cols-4"
                    >
                        @foreach ($accesosRapidos as $acceso)
                            <a
                                href="{{ $acceso['ruta'] }}"
                                class="group flex items-center justify-between
                                       rounded-2xl border border-gray-200
                                       bg-white p-5 font-extrabold
                                       text-gray-700 shadow-sm transition
                                       hover:-translate-y-1
                                       hover:border-emerald-200
                                       hover:bg-emerald-50
                                       hover:text-emerald-950
                                       hover:shadow-lg"
                            >
                                {{ $acceso['nombre'] }}

                                <span
                                    class="text-emerald-700 transition
                                           group-hover:translate-x-1"
                                >
                                    →
                                </span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>