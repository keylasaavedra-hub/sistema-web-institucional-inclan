<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usuario = auth()->user();

        $rol = Schema::hasTable('roles')
            ? DB::table('roles')
                ->where('id', $usuario->rol_id)
                ->value('nombre')
            : null;

        $ahora = now();

        $estadisticas = [
            'usuarios' => DB::table('users')->count(),

            'publicaciones_total' => DB::table('publicaciones')->count(),

            'publicaciones_publicadas' => DB::table('publicaciones')
                ->where('estado', 'publicado')
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_publicacion')
                        ->orWhere('fecha_publicacion', '<=', $ahora);
                })
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_vencimiento')
                        ->orWhere('fecha_vencimiento', '>=', $ahora);
                })
                ->count(),

            'publicaciones_programadas' => DB::table('publicaciones')
                ->where('estado', 'publicado')
                ->whereNotNull('fecha_publicacion')
                ->where('fecha_publicacion', '>', $ahora)
                ->count(),

            'publicaciones_borradores' => DB::table('publicaciones')
                ->where('estado', 'borrador')
                ->count(),

            'consultas_total' => DB::table('consultas')->count(),

            'consultas_pendientes' => DB::table('consultas')
                ->whereIn('estado', [
                    'recibida',
                    'asignada',
                    'en_atencion',
                ])
                ->count(),

            'consultas_respondidas' => DB::table('consultas')
                ->whereIn('estado', [
                    'respondida',
                    'cerrada',
                ])
                ->count(),

            'tramites_total' => DB::table('tramites')->count(),

            'tramites_pendientes' => DB::table('tramites')
                ->whereIn('estado', [
                    'recibido',
                    'en_revision',
                    'observado',
                ])
                ->count(),

            'tramites_finalizados' => DB::table('tramites')
                ->whereIn('estado', [
                    'atendido',
                    'finalizado',
                    'cerrado',
                ])
                ->count(),

            'postulaciones_total' => DB::table('postulaciones')->count(),

            'postulaciones_pendientes' => DB::table('postulaciones')
                ->whereIn('estado', [
                    'recibida',
                    'pendiente',
                    'en_revision',
                ])
                ->count(),

            'convocatorias_total' => DB::table('convocatorias')->count(),

            'convocatorias_vigentes' => DB::table('convocatorias')
                ->where('estado', 'publicada')
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_inicio')
                        ->orWhere('fecha_inicio', '<=', $ahora);
                })
                ->where(function ($query) use ($ahora) {
                    $query
                        ->whereNull('fecha_cierre')
                        ->orWhere('fecha_cierre', '>=', $ahora);
                })
                ->count(),

            'documentos_total' => DB::table('documentos')->count(),

            'documentos_publicos' => DB::table('documentos')
                ->where('estado', 'activo')
                ->where('es_publico', true)
                ->count(),

            'eventos_proximos' => DB::table('eventos')
                ->where('activo', true)
                ->where('fecha_inicio', '>=', $ahora)
                ->count(),
        ];

        $ultimasConsultas = DB::table('consultas')
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

        $ultimosTramites = DB::table('tramites')
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

        $ultimasPostulaciones = DB::table('postulaciones')
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

        $proximosEventos = DB::table('eventos')
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

        $ultimasPublicaciones = DB::table('publicaciones')
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

        return view('dashboard', compact(
            'usuario',
            'rol',
            'estadisticas',
            'ultimasConsultas',
            'ultimosTramites',
            'ultimasPostulaciones',
            'proximosEventos',
            'ultimasPublicaciones'
        ));
    }
}