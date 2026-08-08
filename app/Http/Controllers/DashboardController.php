<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usuario = auth()->user();

        $usuario->load([
            'rol.permisos' => fn($query) => $query
                ->where('permisos.estado', true),
        ]);

        $rol = $usuario->rol?->nombre ?? 'Sin rol asignado';
        $esAdministrador = $usuario->esAdministrador();

        $permisosUsuario = $esAdministrador
            ? collect()
            : $usuario->rol?->permisos->pluck('codigo') ?? collect();

        $puede = static function (
            string $permiso
        ) use (
            $esAdministrador,
            $permisosUsuario
        ): bool {
            return $esAdministrador
                || $permisosUsuario->contains($permiso);
        };

        $ahora = now();

        $estadisticas = [
            'usuarios' => 0,
            'usuarios_activos' => 0,

            'publicaciones_total' => 0,
            'publicaciones_publicadas' => 0,
            'publicaciones_programadas' => 0,
            'publicaciones_borradores' => 0,

            'consultas_total' => 0,
            'consultas_pendientes' => 0,
            'consultas_respondidas' => 0,

            'tramites_total' => 0,
            'tramites_pendientes' => 0,
            'tramites_finalizados' => 0,

            'postulaciones_total' => 0,
            'postulaciones_pendientes' => 0,

            'convocatorias_total' => 0,
            'convocatorias_vigentes' => 0,

            'documentos_total' => 0,
            'documentos_publicos' => 0,

            'eventos_proximos' => 0,

            'auditorias_total' => 0,
            'auditorias_hoy' => 0,
        ];

        if ($puede('usuarios.ver')) {
            $estadisticas['usuarios'] = DB::table('users')
                ->count();

            $estadisticas['usuarios_activos'] = DB::table('users')
                ->where('estado', true)
                ->count();
        }

        if ($puede('publicaciones.gestionar')) {
            $estadisticas['publicaciones_total'] = DB::table(
                'publicaciones'
            )->count();

            $estadisticas['publicaciones_publicadas'] = DB::table(
                'publicaciones'
            )
                ->where('estado', 'publicado')
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_publicacion')
                        ->orWhere(
                            'fecha_publicacion',
                            '<=',
                            $ahora
                        );
                })
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_vencimiento')
                        ->orWhere(
                            'fecha_vencimiento',
                            '>=',
                            $ahora
                        );
                })
                ->count();

            $estadisticas['publicaciones_programadas'] = DB::table(
                'publicaciones'
            )
                ->where('estado', 'publicado')
                ->whereNotNull('fecha_publicacion')
                ->where('fecha_publicacion', '>', $ahora)
                ->count();

            $estadisticas['publicaciones_borradores'] = DB::table(
                'publicaciones'
            )
                ->where('estado', 'borrador')
                ->count();

            $estadisticas['eventos_proximos'] = DB::table('eventos')
                ->where('activo', true)
                ->where('fecha_inicio', '>=', $ahora)
                ->count();
        }

        if ($puede('consultas.ver')) {
            $estadisticas['consultas_total'] = DB::table('consultas')
                ->count();

            $estadisticas['consultas_pendientes'] = DB::table(
                'consultas'
            )
                ->whereIn('estado', [
                    'recibida',
                    'en_revision',
                    'derivada',
                ])
                ->count();

            $estadisticas['consultas_respondidas'] = DB::table(
                'consultas'
            )
                ->whereIn('estado', [
                    'respondida',
                    'cerrada',
                ])
                ->count();
        }

        if ($puede('solicitudes.ver')) {
            $estadisticas['tramites_total'] = DB::table('tramites')
                ->count();

            $estadisticas['tramites_pendientes'] = DB::table(
                'tramites'
            )
                ->whereIn('estado', [
                    'recibido',
                    'en_revision',
                    'derivado',
                    'observado',
                ])
                ->count();

            $estadisticas['tramites_finalizados'] = DB::table(
                'tramites'
            )
                ->whereIn('estado', [
                    'atendido',
                    'cerrado',
                ])
                ->count();
        }

        if ($puede('postulaciones.revisar')) {
            $estadisticas['postulaciones_total'] = DB::table(
                'postulaciones'
            )->count();

            $estadisticas['postulaciones_pendientes'] = DB::table(
                'postulaciones'
            )
                ->whereIn('estado', [
                    'recibida',
                    'pendiente',
                    'en_revision',
                ])
                ->count();
        }

        if ($puede('convocatorias.gestionar')) {
            $estadisticas['convocatorias_total'] = DB::table(
                'convocatorias'
            )->count();

            $estadisticas['convocatorias_vigentes'] = DB::table(
                'convocatorias'
            )
                ->where('estado', 'publicada')
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_inicio')
                        ->orWhere(
                            'fecha_inicio',
                            '<=',
                            $ahora
                        );
                })
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_cierre')
                        ->orWhere(
                            'fecha_cierre',
                            '>=',
                            $ahora
                        );
                })
                ->count();
        }

        if ($puede('documentos.gestionar')) {
            $estadisticas['documentos_total'] = DB::table(
                'documentos'
            )->count();

            $estadisticas['documentos_publicos'] = DB::table(
                'documentos'
            )
                ->where('estado', 'activo')
                ->where('es_publico', true)
                ->count();
        }

        if ($puede('auditoria.ver')) {
            $estadisticas['auditorias_total'] = Auditoria::query()
                ->count();

            $estadisticas['auditorias_hoy'] = Auditoria::query()
                ->whereDate('created_at', today())
                ->count();
        }

        $ultimasConsultas = $puede('consultas.ver')
            ? $this->ultimasConsultas()
            : collect();

        $ultimosTramites = $puede('solicitudes.ver')
            ? $this->ultimosTramites()
            : collect();

        $ultimasPostulaciones = $puede(
            'postulaciones.revisar'
        )
            ? $this->ultimasPostulaciones()
            : collect();

        $proximosEventos = $puede(
            'publicaciones.gestionar'
        )
            ? $this->proximosEventos($ahora)
            : collect();

        $ultimasPublicaciones = $puede(
            'publicaciones.gestionar'
        )
            ? $this->ultimasPublicaciones()
            : collect();

        $ultimasAuditorias = $puede('auditoria.ver')
            ? Auditoria::query()
            ->with('usuario:id,name,apellidos,dni')
            ->latest()
            ->limit(6)
            ->get()
            : collect();

        $indicadores = $this->construirIndicadores(
            $estadisticas,
            $puede
        );

        $accesosRapidos = $this->construirAccesosRapidos(
            $puede
        );

        return view('dashboard', compact(
            'usuario',
            'rol',
            'estadisticas',
            'ultimasConsultas',
            'ultimosTramites',
            'ultimasPostulaciones',
            'proximosEventos',
            'ultimasPublicaciones',
            'ultimasAuditorias',
            'indicadores',
            'accesosRapidos',
            'esAdministrador',
            'permisosUsuario'
        ));
    }

    private function ultimasConsultas(): Collection
    {
        return DB::table('consultas')
            ->select([
                'id',
                'codigo',
                'nombres',
                'apellidos',
                'asunto',
                'estado',
                'created_at',
            ])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    private function ultimosTramites(): Collection
    {
        return DB::table('tramites')
            ->select([
                'id',
                'codigo',
                'nombres',
                'apellidos',
                'razon_social',
                'asunto',
                'estado',
                'created_at',
            ])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    private function ultimasPostulaciones(): Collection
    {
        return DB::table('postulaciones')
            ->leftJoin(
                'convocatorias',
                'postulaciones.convocatoria_id',
                '=',
                'convocatorias.id'
            )
            ->select([
                'postulaciones.id',
                'postulaciones.codigo',
                'postulaciones.nombres',
                'postulaciones.apellidos',
                'postulaciones.estado',
                'postulaciones.created_at',
                'convocatorias.titulo as convocatoria',
            ])
            ->orderByDesc('postulaciones.created_at')
            ->limit(5)
            ->get();
    }

    private function proximosEventos(
        mixed $ahora
    ): Collection {
        return DB::table('eventos')
            ->select([
                'id',
                'titulo',
                'lugar',
                'fecha_inicio',
                'fecha_fin',
                'tipo',
            ])
            ->where('activo', true)
            ->where('fecha_inicio', '>=', $ahora)
            ->orderBy('fecha_inicio')
            ->limit(5)
            ->get();
    }

    private function ultimasPublicaciones(): Collection
    {
        return DB::table('publicaciones')
            ->leftJoin(
                'categorias_publicacion',
                'publicaciones.categoria_publicacion_id',
                '=',
                'categorias_publicacion.id'
            )
            ->select([
                'publicaciones.id',
                'publicaciones.titulo',
                'publicaciones.slug',
                'publicaciones.estado',
                'publicaciones.fecha_publicacion',
                'publicaciones.created_at',
                'categorias_publicacion.nombre as categoria',
            ])
            ->orderByDesc('publicaciones.created_at')
            ->limit(5)
            ->get();
    }

    private function construirIndicadores(
        array $estadisticas,
        callable $puede
    ): array {
        $indicadores = [];

        if ($puede('usuarios.ver')) {
            $indicadores[] = [
                'titulo' => 'Usuarios',
                'valor' => $estadisticas['usuarios'],
                'detalle' => sprintf(
                    '%d usuario(s) activo(s)',
                    $estadisticas['usuarios_activos']
                ),
            ];
        }

        if ($puede('publicaciones.gestionar')) {
            $indicadores[] = [
                'titulo' => 'Publicaciones',
                'valor' => $estadisticas['publicaciones_total'],
                'detalle' => sprintf(
                    '%d publicación(es) visible(s)',
                    $estadisticas['publicaciones_publicadas']
                ),
            ];

            $indicadores[] = [
                'titulo' => 'Borradores',
                'valor' => $estadisticas['publicaciones_borradores'],
                'detalle' => 'Publicaciones aún no publicadas',
            ];

            $indicadores[] = [
                'titulo' => 'Programadas',
                'valor' => $estadisticas['publicaciones_programadas'],
                'detalle' => 'Publicaciones con fecha futura',
            ];
        }

        if ($puede('consultas.ver')) {
            $indicadores[] = [
                'titulo' => 'Consultas',
                'valor' => $estadisticas['consultas_total'],
                'detalle' => sprintf(
                    '%d consulta(s) respondida(s)',
                    $estadisticas['consultas_respondidas']
                ),
            ];
        }

        if ($puede('solicitudes.ver')) {
            $indicadores[] = [
                'titulo' => 'Trámites',
                'valor' => $estadisticas['tramites_total'],
                'detalle' => sprintf(
                    '%d trámite(s) finalizado(s)',
                    $estadisticas['tramites_finalizados']
                ),
            ];
        }

        if ($puede('documentos.gestionar')) {
            $indicadores[] = [
                'titulo' => 'Documentos públicos',
                'valor' => $estadisticas['documentos_publicos'],
                'detalle' => sprintf(
                    '%d documento(s) registrado(s)',
                    $estadisticas['documentos_total']
                ),
            ];
        }

        if ($puede('convocatorias.gestionar')) {
            $indicadores[] = [
                'titulo' => 'Convocatorias vigentes',
                'valor' => $estadisticas['convocatorias_vigentes'],
                'detalle' => sprintf(
                    '%d convocatoria(s) registrada(s)',
                    $estadisticas['convocatorias_total']
                ),
            ];
        }

        if ($puede('auditoria.ver')) {
            $indicadores[] = [
                'titulo' => 'Actividad de auditoría',
                'valor' => $estadisticas['auditorias_total'],
                'detalle' => sprintf(
                    '%d acción(es) registrada(s) hoy',
                    $estadisticas['auditorias_hoy']
                ),
            ];
        }

        return $indicadores;
    }

    private function construirAccesosRapidos(
        callable $puede
    ): array {
        $accesos = [];

        if ($puede('publicaciones.gestionar')) {
            $accesos[] = [
                'nombre' => 'Publicaciones',
                'ruta' => route('admin.publicaciones.index'),
            ];

            $accesos[] = [
                'nombre' => 'Calendario',
                'ruta' => route('admin.eventos.index'),
            ];
        }

        if ($puede('documentos.gestionar')) {
            $accesos[] = [
                'nombre' => 'Documentos',
                'ruta' => route('admin.documentos.index'),
            ];
        }

        if ($puede('consultas.ver')) {
            $accesos[] = [
                'nombre' => 'Consultas',
                'ruta' => route('admin.consultas.index'),
            ];
        }

        if ($puede('solicitudes.ver')) {
            $accesos[] = [
                'nombre' => 'Mesa de partes',
                'ruta' => route('admin.tramites.index'),
            ];
        }

        if ($puede('convocatorias.gestionar')) {
            $accesos[] = [
                'nombre' => 'Convocatorias',
                'ruta' => route('admin.convocatorias.index'),
            ];
        }

        if ($puede('postulaciones.revisar')) {
            $accesos[] = [
                'nombre' => 'Postulaciones',
                'ruta' => route('admin.postulaciones.index'),
            ];
        }

        if ($puede('galerias.gestionar')) {
            $accesos[] = [
                'nombre' => 'Galerías',
                'ruta' => route('admin.galerias.index'),
            ];

            $accesos[] = [
                'nombre' => 'Videos',
                'ruta' => route('admin.videos.index'),
            ];
        }

        if ($puede('promociones.gestionar')) {
            $accesos[] = [
                'nombre' => 'Promociones',
                'ruta' => route('admin.promociones.index'),
            ];
        }

        if ($puede('usuarios.ver')) {
            $accesos[] = [
                'nombre' => 'Usuarios',
                'ruta' => route('admin.usuarios.index'),
            ];
        }

        if ($puede('seguridad.administrar')) {
            $accesos[] = [
                'nombre' => 'Roles y permisos',
                'ruta' => route('admin.roles.index'),
            ];
        }

        if ($puede('auditoria.ver')) {
            $accesos[] = [
                'nombre' => 'Auditoría',
                'ruta' => route('admin.auditorias.index'),
            ];
        }

        return $accesos;
    }
}
