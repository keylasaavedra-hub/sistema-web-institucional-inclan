<?php

use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MesaPartesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ServicioComplementarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\Admin\ConsultaController as AdminConsultaController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Admin\TramiteController as AdminTramiteController;
use App\Http\Controllers\Admin\EventoController as AdminEventoController;
use App\Http\Controllers\Admin\ConvocatoriaController as AdminConvocatoriaController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\Admin\PostulacionController as AdminPostulacionController;
use App\Http\Controllers\Admin\GaleriaController as AdminGaleriaController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Admin\PromocionController as AdminPromocionController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\Admin\DocumentoController as AdminDocumentoController;

/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('inicio');

Route::get('/buscar', [BusquedaController::class, 'index'])
    ->name('buscar');

/*
|--------------------------------------------------------------------------
| PUBLICACIONES
|--------------------------------------------------------------------------
*/

Route::get('/publicaciones', [PublicacionController::class, 'index'])
    ->name('publicaciones.index');

Route::get('/publicaciones/{slug}', [PublicacionController::class, 'show'])
    ->name('publicaciones.show');

/*
|--------------------------------------------------------------------------
| INSTITUCIÓN
|--------------------------------------------------------------------------
*/

Route::prefix('institucion')
    ->name('institucion.')
    ->group(function () {

        Route::get(
            '/resena-historica',
            [InstitucionController::class, 'resenaHistorica']
        )->name('resena-historica');

        Route::get(
            '/mision-vision-valores',
            [InstitucionController::class, 'misionVisionValores']
        )->name('mision-vision-valores');

        /*
        |--------------------------------------------------------------------------
        | INFRAESTRUCTURA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/infraestructura',
            [InstitucionController::class, 'infraestructura']
        )->name('infraestructura');

        Route::get(
            '/infraestructura/{ambiente}',
            [InstitucionController::class, 'mostrarInfraestructura']
        )
            ->whereIn('ambiente', [
                'aulas',
                'computacion',
                'direccion',
                'patios',
                'areas-verdes',
                'sala-reuniones',
                'topico',
                'nivel-inicial',
                'nivel-primario',
                'nivel-secundario',
            ])
            ->name('infraestructura.mostrar');

        /*
        |--------------------------------------------------------------------------
        | CONVENIOS Y ALIANZAS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/convenios',
            [InstitucionController::class, 'convenios']
        )->name('convenios');

        Route::get(
            '/convenios/{convenio}',
            [InstitucionController::class, 'mostrarConvenio']
        )
            ->whereIn('convenio', [
                'crecer',
                'alianza-francesa',
                'utp',
                'essalud',
            ])
            ->name('convenios.mostrar');

        Route::get(
            '/comunidad-educativa',
            [InstitucionController::class, 'comunidadEducativa']
        )->name('comunidad-educativa');

        Route::get(
            '/nuestra-forma-de-ensenar',
            [InstitucionController::class, 'nuestraFormaDeEnsenar']
        )->name('nuestra-forma-de-ensenar');
    });

/*
|--------------------------------------------------------------------------
| LOGROS Y RECONOCIMIENTOS
|--------------------------------------------------------------------------
*/

Route::get('/logros', [HomeController::class, 'logros'])
    ->name('logros.index');

Route::get('/logros/{id}', [HomeController::class, 'mostrarLogro'])
    ->whereNumber('id')
    ->name('logros.mostrar');


/*
|--------------------------------------------------------------------------
| VIDEOS INSTITUCIONALES - PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get(
    '/videos',
    [VideoController::class, 'index']
)->name('videos.index');

Route::get(
    '/videos/{video}',
    [VideoController::class, 'mostrar']
)->whereNumber('video')
    ->name('videos.mostrar');
/*
|--------------------------------------------------------------------------
| PROMOCIONES ESCOLARES - PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get(
    '/promociones',
    [PromocionController::class, 'index']
)->name('promociones.index');

Route::get(
    '/promociones/{promocion}',
    [PromocionController::class, 'mostrar']
)->whereNumber('promocion')
    ->name('promociones.mostrar');
/*
|--------------------------------------------------------------------------
| SERVICIOS COMPLEMENTARIOS
|--------------------------------------------------------------------------
*/

Route::get(
    '/servicios/{servicio}',
    [ServicioComplementarioController::class, 'mostrar']
)
    ->whereIn('servicio', [
        'topico',
        'toece',
        'psicologia',
    ])
    ->name('servicios.mostrar');

/*
|--------------------------------------------------------------------------
| CONSULTAS
|--------------------------------------------------------------------------
*/

Route::get(
    '/consultas',
    [ConsultaController::class, 'crear']
)->name('consultas.crear');

Route::post(
    '/consultas',
    [ConsultaController::class, 'guardar']
)->name('consultas.guardar');

/*
|--------------------------------------------------------------------------
| SEGUIMIENTO DE CONSULTAS
|--------------------------------------------------------------------------
*/

Route::get(
    '/consultas/seguimiento',
    [ConsultaController::class, 'seguimiento']
)->name('consultas.seguimiento');

Route::post(
    '/consultas/seguimiento',
    [ConsultaController::class, 'consultarSeguimiento']
)->name('consultas.seguimiento.consultar');

/*
|--------------------------------------------------------------------------
| MESA DE PARTES VIRTUAL
|--------------------------------------------------------------------------
*/
Route::get(
    '/mesa-de-partes',
    [MesaPartesController::class, 'crear']
)->name('mesa-partes.crear');

Route::post(
    '/mesa-de-partes',
    [MesaPartesController::class, 'guardar']
)->name('mesa-partes.guardar');

Route::get(
    '/mesa-de-partes/seguimiento',
    [MesaPartesController::class, 'seguimiento']
)->name('mesa-partes.seguimiento');

Route::post(
    '/mesa-de-partes/seguimiento',
    [MesaPartesController::class, 'consultarSeguimiento']
)->name('mesa-partes.seguimiento.consultar');


/*
|--------------------------------------------------------------------------
| DOCUMENTOS Y DESCARGAS
|--------------------------------------------------------------------------
*/

Route::get(
    '/documentos-y-descargas',
    [DocumentoController::class, 'index']
)->name('documentos.index');

Route::get(
    '/documentos-y-descargas/{documento}/descargar',
    [DocumentoController::class, 'descargar']
)
    ->whereNumber('documento')
    ->name('documentos.descargar');



/*
|--------------------------------------------------------------------------
| CALENDARIO INSTITUCIONAL
|--------------------------------------------------------------------------
*/

Route::get(
    '/calendario',
    [CalendarioController::class, 'index']
)->name('calendario.index');
/*
|--------------------------------------------------------------------------
| PANEL Y PERFIL
|--------------------------------------------------------------------------
*/
Route::get(
    '/convocatorias',
    [ConvocatoriaController::class, 'index']
)->name('convocatorias.index');

Route::get(
    '/convocatorias/{convocatoria}',
    [ConvocatoriaController::class, 'mostrar']
)
    ->whereNumber('convocatoria')
    ->name('convocatorias.mostrar');

/*
|--------------------------------------------------------------------------
| GALERÍA INSTITUCIONAL - PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get(
    '/galeria',
    [GaleriaController::class, 'index']
)->name('galerias.index');

Route::get(
    '/galeria/{galeria}',
    [GaleriaController::class, 'mostrar']
)->whereNumber('galeria')
    ->name('galerias.mostrar');
/*
|--------------------------------------------------------------------------
| POSTULACIONES PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get(
    '/convocatorias/{convocatoria}/postular',
    [PostulacionController::class, 'crear']
)
    ->whereNumber('convocatoria')
    ->name('postulaciones.crear');

Route::post(
    '/convocatorias/{convocatoria}/postular',
    [PostulacionController::class, 'guardar']
)
    ->whereNumber('convocatoria')
    ->name('postulaciones.guardar');

Route::get(
    '/postulaciones/{postulacion}/registro-exitoso',
    [PostulacionController::class, 'exito']
)
    ->whereNumber('postulacion')
    ->name('postulaciones.exito');

Route::get(
    '/convocatorias/consultar-postulacion',
    [PostulacionController::class, 'seguimiento']
)->name('postulaciones.seguimiento');

Route::post(
    '/convocatorias/consultar-postulacion',
    [PostulacionController::class, 'consultar']
)->name('postulaciones.consultar');

Route::get(
    '/convocatorias/resultados',
    [PostulacionController::class, 'resultados']
)->name('postulaciones.resultados');

Route::get('/dashboard', function () {
    $usuario = auth()->user();

    $estadisticas = [
        'usuarios' => Schema::hasTable('users')
            ? DB::table('users')->count()
            : 0,

        'publicaciones' => Schema::hasTable('publicaciones')
            ? DB::table('publicaciones')->count()
            : 0,

        'consultas' => Schema::hasTable('consultas')
            ? DB::table('consultas')->count()
            : 0,

        'solicitudes' => Schema::hasTable('tramites')
            ? DB::table('tramites')->count()
            : 0,

        'convocatorias' => Schema::hasTable('convocatorias')
            ? DB::table('convocatorias')->count()
            : 0,

        'postulaciones' => Schema::hasTable('postulaciones')
            ? DB::table('postulaciones')->count()
            : 0,
    ];

    $rol = $usuario->rol
        ?? $usuario->role
        ?? 'Administrador';

    return view('dashboard', [
        'usuario' => $usuario,
        'rol' => ucfirst($rol),
        'estadisticas' => $estadisticas,
    ]);
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    /*
|--------------------------------------------------------------------------
| GALERÍA INSTITUCIONAL - ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/galerias',
        [AdminGaleriaController::class, 'index']
    )->name('admin.galerias.index');

    Route::get(
        '/admin/galerias/crear',
        [AdminGaleriaController::class, 'crear']
    )->name('admin.galerias.crear');

    Route::post(
        '/admin/galerias',
        [AdminGaleriaController::class, 'guardar']
    )->name('admin.galerias.guardar');

    Route::get(
        '/admin/galerias/{galeria}/editar',
        [AdminGaleriaController::class, 'editar']
    )->whereNumber('galeria')
        ->name('admin.galerias.editar');

    Route::put(
        '/admin/galerias/{galeria}',
        [AdminGaleriaController::class, 'actualizar']
    )->whereNumber('galeria')
        ->name('admin.galerias.actualizar');

    Route::patch(
        '/admin/galerias/archivos/{archivo}/estado',
        [AdminGaleriaController::class, 'cambiarEstadoArchivo']
    )->whereNumber('archivo')
        ->name('admin.galerias.archivos.estado');

    Route::delete(
        '/admin/galerias/archivos/{archivo}',
        [AdminGaleriaController::class, 'eliminarArchivo']
    )->whereNumber('archivo')
        ->name('admin.galerias.archivos.eliminar');

    Route::delete(
        '/admin/galerias/{galeria}',
        [AdminGaleriaController::class, 'eliminar']
    )->whereNumber('galeria')
        ->name('admin.galerias.eliminar');



    /*
|--------------------------------------------------------------------------
| DOCUMENTOS - ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/documentos',
        [AdminDocumentoController::class, 'index']
    )->name('admin.documentos.index');

    Route::get(
        '/admin/documentos/crear',
        [AdminDocumentoController::class, 'crear']
    )->name('admin.documentos.crear');

    Route::post(
        '/admin/documentos',
        [AdminDocumentoController::class, 'guardar']
    )->name('admin.documentos.guardar');

    Route::get(
        '/admin/documentos/{documento}/editar',
        [AdminDocumentoController::class, 'editar']
    )->whereNumber('documento')
        ->name('admin.documentos.editar');

    Route::put(
        '/admin/documentos/{documento}',
        [AdminDocumentoController::class, 'actualizar']
    )->whereNumber('documento')
        ->name('admin.documentos.actualizar');

    Route::post(
        '/admin/documentos/{documento}/versiones',
        [AdminDocumentoController::class, 'nuevaVersion']
    )->whereNumber('documento')
        ->name('admin.documentos.versiones.guardar');

    Route::get(
        '/admin/documentos/{documento}/descargar',
        [AdminDocumentoController::class, 'descargarActual']
    )->whereNumber('documento')
        ->name('admin.documentos.descargar');

    Route::get(
        '/admin/documentos/versiones/{version}/descargar',
        [AdminDocumentoController::class, 'descargarVersion']
    )->whereNumber('version')
        ->name('admin.documentos.versiones.descargar');

    Route::delete(
        '/admin/documentos/{documento}',
        [AdminDocumentoController::class, 'eliminar']
    )->whereNumber('documento')
        ->name('admin.documentos.eliminar');
    /*
|--------------------------------------------------------------------------
| PROMOCIONES ESCOLARES - ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/promociones',
        [AdminPromocionController::class, 'index']
    )->name('admin.promociones.index');

    Route::get(
        '/admin/promociones/crear',
        [AdminPromocionController::class, 'crear']
    )->name('admin.promociones.crear');

    Route::post(
        '/admin/promociones',
        [AdminPromocionController::class, 'guardar']
    )->name('admin.promociones.guardar');

    Route::get(
        '/admin/promociones/{promocion}/editar',
        [AdminPromocionController::class, 'editar']
    )->whereNumber('promocion')
        ->name('admin.promociones.editar');

    Route::put(
        '/admin/promociones/{promocion}',
        [AdminPromocionController::class, 'actualizar']
    )->whereNumber('promocion')
        ->name('admin.promociones.actualizar');

    Route::patch(
        '/admin/promociones/imagenes/{imagen}/estado',
        [AdminPromocionController::class, 'cambiarEstadoImagen']
    )->whereNumber('imagen')
        ->name('admin.promociones.imagenes.estado');

    Route::delete(
        '/admin/promociones/imagenes/{imagen}',
        [AdminPromocionController::class, 'eliminarImagen']
    )->whereNumber('imagen')
        ->name('admin.promociones.imagenes.eliminar');

    Route::delete(
        '/admin/promociones/{promocion}',
        [AdminPromocionController::class, 'eliminar']
    )->whereNumber('promocion')
        ->name('admin.promociones.eliminar');
    /*
|--------------------------------------------------------------------------
| VIDEOS INSTITUCIONALES - ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/videos',
        [AdminVideoController::class, 'index']
    )->name('admin.videos.index');

    Route::get(
        '/admin/videos/crear',
        [AdminVideoController::class, 'crear']
    )->name('admin.videos.crear');

    Route::post(
        '/admin/videos',
        [AdminVideoController::class, 'guardar']
    )->name('admin.videos.guardar');

    Route::get(
        '/admin/videos/{video}/editar',
        [AdminVideoController::class, 'editar']
    )->whereNumber('video')
        ->name('admin.videos.editar');

    Route::put(
        '/admin/videos/{video}',
        [AdminVideoController::class, 'actualizar']
    )->whereNumber('video')
        ->name('admin.videos.actualizar');

    Route::delete(
        '/admin/videos/{video}',
        [AdminVideoController::class, 'eliminar']
    )->whereNumber('video')
        ->name('admin.videos.eliminar');
    /*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DE CONVOCATORIAS
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/convocatorias',
        [AdminConvocatoriaController::class, 'index']
    )->name('admin.convocatorias.index');

    Route::get(
        '/admin/convocatorias/crear',
        [AdminConvocatoriaController::class, 'create']
    )->name('admin.convocatorias.create');

    Route::post(
        '/admin/convocatorias',
        [AdminConvocatoriaController::class, 'store']
    )->name('admin.convocatorias.store');

    Route::get(
        '/admin/convocatorias/{convocatoria}/editar',
        [AdminConvocatoriaController::class, 'edit']
    )
        ->whereNumber('convocatoria')
        ->name('admin.convocatorias.edit');

    Route::put(
        '/admin/convocatorias/{convocatoria}',
        [AdminConvocatoriaController::class, 'update']
    )
        ->whereNumber('convocatoria')
        ->name('admin.convocatorias.update');

    Route::delete(
        '/admin/convocatorias/{convocatoria}',
        [AdminConvocatoriaController::class, 'destroy']
    )
        ->whereNumber('convocatoria')
        ->name('admin.convocatorias.destroy');


    /*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DE POSTULACIONES
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/postulaciones',
        [AdminPostulacionController::class, 'index']
    )->name('admin.postulaciones.index');

    Route::get(
        '/admin/postulaciones/{postulacion}',
        [AdminPostulacionController::class, 'mostrar']
    )
        ->whereNumber('postulacion')
        ->name('admin.postulaciones.mostrar');

    Route::patch(
        '/admin/postulaciones/{postulacion}',
        [AdminPostulacionController::class, 'actualizar']
    )
        ->whereNumber('postulacion')
        ->name('admin.postulaciones.actualizar');

    /*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DEL CALENDARIO
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/eventos',
        [AdminEventoController::class, 'index']
    )->name('admin.eventos.index');

    Route::get(
        '/admin/eventos/crear',
        [AdminEventoController::class, 'create']
    )->name('admin.eventos.create');

    Route::post(
        '/admin/eventos',
        [AdminEventoController::class, 'store']
    )->name('admin.eventos.store');

    Route::get(
        '/admin/eventos/{evento}/editar',
        [AdminEventoController::class, 'edit']
    )
        ->whereNumber('evento')
        ->name('admin.eventos.edit');

    Route::put(
        '/admin/eventos/{evento}',
        [AdminEventoController::class, 'update']
    )
        ->whereNumber('evento')
        ->name('admin.eventos.update');

    Route::delete(
        '/admin/eventos/{evento}',
        [AdminEventoController::class, 'destroy']
    )
        ->whereNumber('evento')
        ->name('admin.eventos.destroy');
    /*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DE TRÁMITES
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/tramites',
        [AdminTramiteController::class, 'index']
    )->name('admin.tramites.index');

    Route::get(
        '/admin/tramites/{tramite}',
        [AdminTramiteController::class, 'mostrar']
    )
        ->whereNumber('tramite')
        ->name('admin.tramites.mostrar');

    Route::patch(
        '/admin/tramites/{tramite}',
        [AdminTramiteController::class, 'actualizar']
    )
        ->whereNumber('tramite')
        ->name('admin.tramites.actualizar');

    Route::get(
        '/admin/tramites/{tramite}/descargar',
        [AdminTramiteController::class, 'descargar']
    )
        ->whereNumber('tramite')
        ->name('admin.tramites.descargar');

    /*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DE CONSULTAS
|--------------------------------------------------------------------------
*/

    Route::get(
        '/admin/consultas',
        [AdminConsultaController::class, 'index']
    )->name('admin.consultas.index');

    Route::get(
        '/admin/consultas/{consulta}',
        [AdminConsultaController::class, 'mostrar']
    )
        ->whereNumber('consulta')
        ->name('admin.consultas.mostrar');

    Route::patch(
        '/admin/consultas/{consulta}',
        [AdminConsultaController::class, 'actualizar']
    )
        ->whereNumber('consulta')
        ->name('admin.consultas.actualizar');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
