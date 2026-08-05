<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublicacionController extends Controller
{
    public function index(): View
    {
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
            ->where(function ($query) {
                $query
                    ->whereNull('publicaciones.fecha_publicacion')
                    ->orWhere('publicaciones.fecha_publicacion', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('publicaciones.fecha_vencimiento')
                    ->orWhere('publicaciones.fecha_vencimiento', '>=', now());
            })
            ->orderByDesc('publicaciones.destacada')
            ->orderByDesc('publicaciones.fecha_publicacion')
            ->paginate(9);

        return view('public.publicaciones.index', compact('publicaciones'));
    }

    public function show(string $slug): View
    {
        $publicacion = DB::table('publicaciones')
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
                'publicaciones.archivo_adjunto',
                'publicaciones.fecha_publicacion',
                'categorias_publicacion.nombre as categoria',
            ])
            ->where('publicaciones.slug', $slug)
            ->where('publicaciones.estado', 'publicado')
            ->where(function ($query) {
                $query
                    ->whereNull('publicaciones.fecha_publicacion')
                    ->orWhere('publicaciones.fecha_publicacion', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('publicaciones.fecha_vencimiento')
                    ->orWhere('publicaciones.fecha_vencimiento', '>=', now());
            })
            ->first();

        if (! $publicacion) {
            throw new NotFoundHttpException(
                'La publicación solicitada no se encuentra disponible.'
            );
        }

        $relacionadas = DB::table('publicaciones')
            ->leftJoin(
                'categorias_publicacion',
                'publicaciones.categoria_publicacion_id',
                '=',
                'categorias_publicacion.id'
            )
            ->select([
                'publicaciones.titulo',
                'publicaciones.slug',
                'publicaciones.imagen_portada',
                'publicaciones.fecha_publicacion',
                'categorias_publicacion.nombre as categoria',
            ])
            ->where('publicaciones.estado', 'publicado')
            ->where('publicaciones.id', '!=', $publicacion->id)
            ->orderByDesc('publicaciones.fecha_publicacion')
            ->limit(3)
            ->get();

        return view(
            'public.publicaciones.show',
            compact('publicacion', 'relacionadas')
        );
    }
}