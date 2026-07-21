<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $ahora = now();

        $configuracion = DB::table('configuracion_sitio')
            ->first();

        $informacionInstitucional = DB::table('informacion_institucional')
            ->where('estado', true)
            ->orderBy('orden')
            ->get()
            ->keyBy('tipo');

        $publicaciones = DB::table('publicaciones')
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
                'publicaciones.contenido',
                'publicaciones.imagen_portada',
                'publicaciones.fecha_publicacion',
                'publicaciones.destacada',
                'categorias_publicacion.nombre as categoria',
            ])
            ->where('publicaciones.estado', 'publicado')
            ->where(function ($consulta) use ($ahora) {
                $consulta
                    ->whereNull('publicaciones.fecha_publicacion')
                    ->orWhere(
                        'publicaciones.fecha_publicacion',
                        '<=',
                        $ahora
                    );
            })
            ->where(function ($consulta) use ($ahora) {
                $consulta
                    ->whereNull('publicaciones.fecha_vencimiento')
                    ->orWhere(
                        'publicaciones.fecha_vencimiento',
                        '>=',
                        $ahora
                    );
            })
            ->orderByDesc('publicaciones.destacada')
            ->orderByDesc('publicaciones.fecha_publicacion')
            ->limit(3)
            ->get();

        $convocatorias = DB::table('convocatorias')
            ->leftJoin(
                'areas_institucionales',
                'convocatorias.area_id',
                '=',
                'areas_institucionales.id'
            )
            ->leftJoin(
                'cargos',
                'convocatorias.cargo_id',
                '=',
                'cargos.id'
            )
            ->select([
                'convocatorias.id',
                'convocatorias.codigo',
                'convocatorias.tipo',
                'convocatorias.titulo',
                'convocatorias.descripcion',
                'convocatorias.vacantes',
                'convocatorias.fecha_inicio',
                'convocatorias.fecha_cierre',
                'areas_institucionales.nombre as area',
                'cargos.nombre as cargo',
            ])
            ->where('convocatorias.estado', 'publicada')
            ->where('convocatorias.fecha_inicio', '<=', $ahora)
            ->where('convocatorias.fecha_cierre', '>=', $ahora)
            ->orderBy('convocatorias.fecha_cierre')
            ->limit(3)
            ->get();

        $enlacesExternos = DB::table('enlaces_externos')
            ->where('estado', true)
            ->orderBy('orden')
            ->get();

        $sieweb = $enlacesExternos->firstWhere('nombre', 'Sieweb');

        return view('welcome', compact(
            'configuracion',
            'informacionInstitucional',
            'publicaciones',
            'convocatorias',
            'enlacesExternos',
            'sieweb'
        ));
    }
}