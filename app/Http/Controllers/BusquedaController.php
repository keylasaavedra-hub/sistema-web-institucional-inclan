<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BusquedaController extends Controller
{
    public function index(Request $request): View
    {
        $termino = trim((string) $request->query('q', ''));

        $publicaciones = collect();
        $documentos = collect();
        $convocatorias = collect();
        $informacionInstitucional = collect();

        if (mb_strlen($termino) >= 2) {
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
                    'publicaciones.fecha_publicacion',
                    'categorias_publicacion.nombre as categoria',
                ])
                ->where('publicaciones.estado', 'publicado')
                ->where(function ($query) use ($termino) {
                    $query
                        ->where('publicaciones.titulo', 'like', "%{$termino}%")
                        ->orWhere('publicaciones.contenido', 'like', "%{$termino}%");
                })
                ->orderByDesc('publicaciones.fecha_publicacion')
                ->limit(10)
                ->get();

            $documentos = DB::table('documentos')
                ->join(
                    'categorias_documento',
                    'documentos.categoria_documento_id',
                    '=',
                    'categorias_documento.id'
                )
                ->select([
                    'documentos.id',
                    'documentos.titulo',
                    'documentos.descripcion',
                    'documentos.archivo',
                    'documentos.fecha_publicacion',
                    'categorias_documento.nombre as categoria',
                ])
                ->where('documentos.estado', 'activo')
                ->where('documentos.es_publico', true)
                ->where(function ($query) use ($termino) {
                    $query
                        ->where('documentos.titulo', 'like', "%{$termino}%")
                        ->orWhere('documentos.descripcion', 'like', "%{$termino}%");
                })
                ->orderByDesc('documentos.fecha_publicacion')
                ->limit(10)
                ->get();

            $convocatorias = DB::table('convocatorias')
                ->leftJoin(
                    'areas_institucionales',
                    'convocatorias.area_id',
                    '=',
                    'areas_institucionales.id'
                )
                ->select([
                    'convocatorias.id',
                    'convocatorias.codigo',
                    'convocatorias.titulo',
                    'convocatorias.descripcion',
                    'convocatorias.tipo',
                    'convocatorias.fecha_cierre',
                    'areas_institucionales.nombre as area',
                ])
                ->where('convocatorias.estado', 'publicada')
                ->where(function ($query) use ($termino) {
                    $query
                        ->where('convocatorias.titulo', 'like', "%{$termino}%")
                        ->orWhere('convocatorias.descripcion', 'like', "%{$termino}%")
                        ->orWhere('convocatorias.codigo', 'like', "%{$termino}%")
                        ->orWhere('convocatorias.tipo', 'like', "%{$termino}%");
                })
                ->orderByDesc('convocatorias.fecha_publicacion')
                ->limit(10)
                ->get();

            $informacionInstitucional = DB::table('informacion_institucional')
                ->select([
                    'id',
                    'tipo',
                    'titulo',
                    'contenido',
                    'orden',
                ])
                ->where('estado', true)
                ->where(function ($query) use ($termino) {
                    $query
                        ->where('titulo', 'like', "%{$termino}%")
                        ->orWhere('contenido', 'like', "%{$termino}%")
                        ->orWhere('tipo', 'like', "%{$termino}%");
                })
                ->orderBy('orden')
                ->limit(10)
                ->get();
        }

        $totalResultados =
            $publicaciones->count()
            + $documentos->count()
            + $convocatorias->count()
            + $informacionInstitucional->count();

        return view('public.busqueda', compact(
            'termino',
            'publicaciones',
            'documentos',
            'convocatorias',
            'informacionInstitucional',
            'totalResultados'
        ));
    }
}