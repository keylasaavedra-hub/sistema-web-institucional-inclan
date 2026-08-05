<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Página principal del portal institucional.
     */
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

        $logros = DB::table('logros')
            ->leftJoin(
                'niveles_educativos',
                'logros.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'logros.id',
                'logros.tipo',
                'logros.titulo',
                'logros.descripcion',
                'logros.fecha',
                'logros.imagen',
                'logros.archivo_respaldo',
                'niveles_educativos.nombre as nivel',
            ])
            ->where('logros.estado', true)
            ->orderByDesc('logros.fecha')
            ->limit(3)
            ->get();

        $infraestructura = DB::table('archivos_galeria')
            ->join(
                'galerias',
                'archivos_galeria.galeria_id',
                '=',
                'galerias.id'
            )
            ->select([
                'archivos_galeria.id',
                'archivos_galeria.titulo',
                'archivos_galeria.descripcion',
                'archivos_galeria.ruta',
                'archivos_galeria.orden',
            ])
            ->where('galerias.tipo', 'infraestructura')
            ->where('galerias.estado', true)
            ->where('archivos_galeria.estado', true)
            ->where('archivos_galeria.tipo_archivo', 'imagen')
            ->orderBy('archivos_galeria.orden')
            ->limit(8)
            ->get();

        $comunidadEducativa = DB::table('comunidad_educativa')
            ->leftJoin(
                'areas_institucionales',
                'comunidad_educativa.area_id',
                '=',
                'areas_institucionales.id'
            )
            ->leftJoin(
                'cargos',
                'comunidad_educativa.cargo_id',
                '=',
                'cargos.id'
            )
            ->leftJoin(
                'niveles_educativos',
                'comunidad_educativa.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'comunidad_educativa.id',
                'comunidad_educativa.nombres',
                'comunidad_educativa.apellidos',
                'comunidad_educativa.tipo_personal',
                'comunidad_educativa.foto',
                'comunidad_educativa.perfil_profesional',
                'comunidad_educativa.descripcion',
                'areas_institucionales.nombre as area',
                'cargos.nombre as cargo',
                'niveles_educativos.nombre as nivel',
            ])
            ->where('comunidad_educativa.estado', true)
            ->where('comunidad_educativa.publicar', true)
            ->orderBy('comunidad_educativa.orden')
            ->limit(4)
            ->get();

        $promociones = DB::table('promociones')
            ->join(
                'niveles_educativos',
                'promociones.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'promociones.id',
                'promociones.nombre',
                'promociones.anio',
                'promociones.lema',
                'promociones.descripcion',
                'promociones.imagen_portada',
                'niveles_educativos.nombre as nivel',
            ])
            ->where('promociones.estado', true)
            ->orderByDesc('promociones.anio')
            ->orderBy('niveles_educativos.id')
            ->limit(3)
            ->get();

        $documentosPublicos = DB::table('documentos')
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
                'documentos.nombre_original',
                'documentos.tipo_archivo',
                'documentos.tamano_bytes',
                'documentos.version',
                'documentos.fecha_publicacion',
                'documentos.updated_at',
                'categorias_documento.nombre as categoria',
            ])
            ->where('documentos.estado', 'activo')
            ->where('documentos.es_publico', true)
            ->orderByDesc('documentos.fecha_publicacion')
            ->limit(6)
            ->get();

        return view('welcome', compact(
            'configuracion',
            'informacionInstitucional',
            'publicaciones',
            'convocatorias',
            'enlacesExternos',
            'sieweb',
            'logros',
            'infraestructura',
            'comunidadEducativa',
            'promociones',
            'documentosPublicos'
        ));
    }

    /**
     * Lista todos los logros y reconocimientos publicados.
     */
    public function logros(): View
    {
        $logros = DB::table('logros')
            ->leftJoin(
                'niveles_educativos',
                'logros.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'logros.id',
                'logros.tipo',
                'logros.titulo',
                'logros.descripcion',
                'logros.fecha',
                'logros.imagen',
                'logros.archivo_respaldo',
                'niveles_educativos.nombre as nivel',
            ])
            ->where('logros.estado', true)
            ->orderByDesc('logros.fecha')
            ->paginate(9);

        return view('logros.index', compact('logros'));
    }

    /**
     * Muestra el detalle de un logro o reconocimiento.
     */
    public function mostrarLogro(int $id): View
    {
        $logro = DB::table('logros')
            ->leftJoin(
                'niveles_educativos',
                'logros.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'logros.id',
                'logros.tipo',
                'logros.titulo',
                'logros.descripcion',
                'logros.fecha',
                'logros.imagen',
                'logros.archivo_respaldo',
                'niveles_educativos.nombre as nivel',
            ])
            ->where('logros.id', $id)
            ->where('logros.estado', true)
            ->first();

        abort_unless($logro, 404);

        return view('logros.mostrar', compact('logro'));
    }
}