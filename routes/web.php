<?php

use App\Http\Controllers\Admin\CategoriaPublicacionController;
use App\Http\Controllers\Admin\ConsultaController as AdminConsultaController;
use App\Http\Controllers\Admin\ContenidoInstitucionalController;
use App\Http\Controllers\Admin\ConvocatoriaController as AdminConvocatoriaController;
use App\Http\Controllers\Admin\DocumentoController as AdminDocumentoController;
use App\Http\Controllers\Admin\EventoController as AdminEventoController;
use App\Http\Controllers\Admin\GaleriaController as AdminGaleriaController;
use App\Http\Controllers\Admin\PostulacionController as AdminPostulacionController;
use App\Http\Controllers\Admin\PromocionController as AdminPromocionController;
use App\Http\Controllers\Admin\PublicacionController as AdminPublicacionController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\TramiteController as AdminTramiteController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\AuditoriaController;

use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MesaPartesController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ServicioComplementarioController;
use App\Http\Controllers\VideoController;

use Illuminate\Support\Facades\Route;

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
| PUBLICACIONES - PORTAL PÚBLICO
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

        Route::get(
            '/convenios',
            [InstitucionController::class, 'convenios']
        )->name('convenios');

        Route::get(
            '/convenios/{convenio}',
            [InstitucionController::class, 'mostrarConvenio']
        )
            ->where('convenio', '[A-Za-z0-9-]+')
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
| LOGROS
|--------------------------------------------------------------------------
*/

Route::get('/logros', [HomeController::class, 'logros'])
    ->name('logros.index');

Route::get('/logros/{id}', [HomeController::class, 'mostrarLogro'])
    ->whereNumber('id')
    ->name('logros.mostrar');

/*
|--------------------------------------------------------------------------
| MULTIMEDIA - PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/videos', [VideoController::class, 'index'])
    ->name('videos.index');

Route::get('/videos/{video}', [VideoController::class, 'mostrar'])
    ->whereNumber('video')
    ->name('videos.mostrar');

Route::get('/promociones', [PromocionController::class, 'index'])
    ->name('promociones.index');

Route::get('/promociones/{promocion}', [PromocionController::class, 'mostrar'])
    ->whereNumber('promocion')
    ->name('promociones.mostrar');

Route::get('/galeria', [GaleriaController::class, 'index'])
    ->name('galerias.index');

Route::get('/galeria/{galeria}', [GaleriaController::class, 'mostrar'])
    ->whereNumber('galeria')
    ->name('galerias.mostrar');

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
| CONSULTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/consultas', [ConsultaController::class, 'crear'])
    ->name('consultas.crear');

Route::post('/consultas', [ConsultaController::class, 'guardar'])
    ->name('consultas.guardar');

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
| MESA DE PARTES PÚBLICA
|--------------------------------------------------------------------------
*/

Route::get('/mesa-de-partes', [MesaPartesController::class, 'crear'])
    ->name('mesa-partes.crear');

Route::post('/mesa-de-partes', [MesaPartesController::class, 'guardar'])
    ->name('mesa-partes.guardar');

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
| DOCUMENTOS PÚBLICOS
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
| CALENDARIO PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/calendario', [CalendarioController::class, 'index'])
    ->name('calendario.index');

/*
|--------------------------------------------------------------------------
| CONVOCATORIAS Y POSTULACIONES PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/convocatorias', [ConvocatoriaController::class, 'index'])
    ->name('convocatorias.index');

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

Route::get(
    '/postulaciones/{postulacion}/registro-exitoso',
    [PostulacionController::class, 'exito']
)
    ->whereNumber('postulacion')
    ->name('postulaciones.exito');

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
    '/convocatorias/{convocatoria}',
    [ConvocatoriaController::class, 'mostrar']
)
    ->whereNumber('convocatoria')
    ->name('convocatorias.mostrar');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([
        'auth',
        'permiso:dashboard.ver',
    ])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PANEL ADMINISTRATIVO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/usuarios')
        ->name('admin.usuarios.')
        ->controller(UsuarioController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->middleware('permiso:usuarios.ver')
                ->name('index');

            Route::get('/crear', 'crear')
                ->middleware('permiso:usuarios.crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->middleware('permiso:usuarios.crear')
                ->name('guardar');

            Route::get('/{usuario}/editar', 'editar')
                ->whereNumber('usuario')
                ->middleware('permiso:usuarios.editar')
                ->name('editar');

            Route::put('/{usuario}', 'actualizar')
                ->whereNumber('usuario')
                ->middleware('permiso:usuarios.editar')
                ->name('actualizar');

            Route::patch('/{usuario}/estado', 'cambiarEstado')
                ->whereNumber('usuario')
                ->middleware('permiso:usuarios.editar')
                ->name('estado');

            Route::delete('/{usuario}', 'eliminar')
                ->whereNumber('usuario')
                ->middleware('permiso:usuarios.editar')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | ROLES Y PERMISOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/roles')
        ->name('admin.roles.')
        ->controller(RolController::class)
        ->middleware('permiso:seguridad.administrar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::get('/{rol}/editar', 'editar')
                ->whereNumber('rol')
                ->name('editar');

            Route::put('/{rol}', 'actualizar')
                ->whereNumber('rol')
                ->name('actualizar');

            Route::patch('/{rol}/estado', 'cambiarEstado')
                ->whereNumber('rol')
                ->name('estado');

            Route::delete('/{rol}', 'eliminar')
                ->whereNumber('rol')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | GALERÍAS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/galerias')
        ->name('admin.galerias.')
        ->controller(AdminGaleriaController::class)
        ->middleware('permiso:galerias.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::patch(
                '/archivos/{archivo}/estado',
                'cambiarEstadoArchivo'
            )
                ->whereNumber('archivo')
                ->name('archivos.estado');

            Route::delete(
                '/archivos/{archivo}',
                'eliminarArchivo'
            )
                ->whereNumber('archivo')
                ->name('archivos.eliminar');

            Route::get('/{galeria}/editar', 'editar')
                ->whereNumber('galeria')
                ->name('editar');

            Route::put('/{galeria}', 'actualizar')
                ->whereNumber('galeria')
                ->name('actualizar');

            Route::delete('/{galeria}', 'eliminar')
                ->whereNumber('galeria')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | CATEGORÍAS DE PUBLICACIONES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/categorias-publicacion')
        ->name('admin.categorias-publicacion.')
        ->controller(CategoriaPublicacionController::class)
        ->middleware('permiso:publicaciones.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::put('/{categoria}', 'actualizar')
                ->whereNumber('categoria')
                ->name('actualizar');

            Route::patch('/{categoria}/estado', 'cambiarEstado')
                ->whereNumber('categoria')
                ->name('estado');

            Route::delete('/{categoria}', 'eliminar')
                ->whereNumber('categoria')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | PUBLICACIONES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/publicaciones')
        ->name('admin.publicaciones.')
        ->controller(AdminPublicacionController::class)
        ->middleware('permiso:publicaciones.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::get('/{publicacion:id}/editar', 'editar')
                ->whereNumber('publicacion')
                ->name('editar');

            Route::put('/{publicacion:id}', 'actualizar')
                ->whereNumber('publicacion')
                ->name('actualizar');

            Route::delete('/{publicacion:id}', 'eliminar')
                ->whereNumber('publicacion')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/documentos')
        ->name('admin.documentos.')
        ->controller(AdminDocumentoController::class)
        ->middleware('permiso:documentos.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::get(
                '/versiones/{version}/descargar',
                'descargarVersion'
            )
                ->whereNumber('version')
                ->name('versiones.descargar');

            Route::get('/{documento}/editar', 'editar')
                ->whereNumber('documento')
                ->name('editar');

            Route::put('/{documento}', 'actualizar')
                ->whereNumber('documento')
                ->name('actualizar');

            Route::post(
                '/{documento}/versiones',
                'nuevaVersion'
            )
                ->whereNumber('documento')
                ->name('versiones.guardar');

            Route::get(
                '/{documento}/descargar',
                'descargarActual'
            )
                ->whereNumber('documento')
                ->name('descargar');

            Route::delete('/{documento}', 'eliminar')
                ->whereNumber('documento')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | PROMOCIONES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/promociones')
        ->name('admin.promociones.')
        ->controller(AdminPromocionController::class)
        ->middleware('permiso:promociones.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::patch(
                '/imagenes/{imagen}/estado',
                'cambiarEstadoImagen'
            )
                ->whereNumber('imagen')
                ->name('imagenes.estado');

            Route::delete(
                '/imagenes/{imagen}',
                'eliminarImagen'
            )
                ->whereNumber('imagen')
                ->name('imagenes.eliminar');

            Route::get('/{promocion}/editar', 'editar')
                ->whereNumber('promocion')
                ->name('editar');

            Route::put('/{promocion}', 'actualizar')
                ->whereNumber('promocion')
                ->name('actualizar');

            Route::delete('/{promocion}', 'eliminar')
                ->whereNumber('promocion')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | VIDEOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/videos')
        ->name('admin.videos.')
        ->controller(AdminVideoController::class)
        ->middleware('permiso:galerias.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'crear')
                ->name('crear');

            Route::post('/', 'guardar')
                ->name('guardar');

            Route::get('/{video}/editar', 'editar')
                ->whereNumber('video')
                ->name('editar');

            Route::put('/{video}', 'actualizar')
                ->whereNumber('video')
                ->name('actualizar');

            Route::delete('/{video}', 'eliminar')
                ->whereNumber('video')
                ->name('eliminar');
        });

    /*
    |--------------------------------------------------------------------------
    | CONVOCATORIAS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/convocatorias')
        ->name('admin.convocatorias.')
        ->controller(AdminConvocatoriaController::class)
        ->middleware('permiso:convocatorias.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'create')
                ->name('create');

            Route::post('/', 'store')
                ->name('store');

            Route::get('/{convocatoria}/editar', 'edit')
                ->whereNumber('convocatoria')
                ->name('edit');

            Route::put('/{convocatoria}', 'update')
                ->whereNumber('convocatoria')
                ->name('update');

            Route::delete('/{convocatoria}', 'destroy')
                ->whereNumber('convocatoria')
                ->name('destroy');

            Route::patch(
                '/{convocatoria}/publicar-resultados',
                'publicarResultados'
            )
                ->whereNumber('convocatoria')
                ->name('publicar-resultados');

            Route::patch(
                '/{convocatoria}/retirar-resultados',
                'retirarResultados'
            )
                ->whereNumber('convocatoria')
                ->name('retirar-resultados');
        });

    /*
    |--------------------------------------------------------------------------
    | POSTULACIONES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/postulaciones')
        ->name('admin.postulaciones.')
        ->controller(AdminPostulacionController::class)
        ->middleware('permiso:postulaciones.revisar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/{postulacion}', 'mostrar')
                ->whereNumber('postulacion')
                ->name('mostrar');

            Route::patch('/{postulacion}', 'actualizar')
                ->whereNumber('postulacion')
                ->name('actualizar');
        });

    /*
    |--------------------------------------------------------------------------
    | CALENDARIO
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/eventos')
        ->name('admin.eventos.')
        ->controller(AdminEventoController::class)
        ->middleware('permiso:publicaciones.gestionar')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/crear', 'create')
                ->name('create');

            Route::post('/', 'store')
                ->name('store');

            Route::get('/{evento}/editar', 'edit')
                ->whereNumber('evento')
                ->name('edit');

            Route::put('/{evento}', 'update')
                ->whereNumber('evento')
                ->name('update');

            Route::delete('/{evento}', 'destroy')
                ->whereNumber('evento')
                ->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | TRÁMITES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/tramites')
        ->name('admin.tramites.')
        ->controller(AdminTramiteController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->middleware('permiso:solicitudes.ver')
                ->name('index');

            Route::get('/{tramite}', 'mostrar')
                ->whereNumber('tramite')
                ->middleware('permiso:solicitudes.ver')
                ->name('mostrar');

            Route::patch('/{tramite}', 'actualizar')
                ->whereNumber('tramite')
                ->middleware('permiso:solicitudes.atender')
                ->name('actualizar');

            Route::get('/{tramite}/descargar', 'descargar')
                ->whereNumber('tramite')
                ->middleware('permiso:solicitudes.ver')
                ->name('descargar');
        });

    /*
    |--------------------------------------------------------------------------
    | CONSULTAS
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/consultas')
        ->name('admin.consultas.')
        ->controller(AdminConsultaController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->middleware('permiso:consultas.ver')
                ->name('index');

            Route::get('/{consulta}', 'mostrar')
                ->whereNumber('consulta')
                ->middleware('permiso:consultas.ver')
                ->name('mostrar');

            Route::patch('/{consulta}', 'actualizar')
                ->whereNumber('consulta')
                ->middleware('permiso:consultas.atender')
                ->name('actualizar');
        });

    /*
    |--------------------------------------------------------------------------
    | AUDITORÍA
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/auditorias')
        ->name('admin.auditorias.')
        ->controller(AuditoriaController::class)
        ->middleware('permiso:auditoria.ver')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/{auditoria}', 'mostrar')
                ->whereNumber('auditoria')
                ->name('mostrar');
        });

    /*
    |--------------------------------------------------------------------------
    | CONTENIDO INSTITUCIONAL
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/contenido-institucional')
        ->name('admin.contenido-institucional.')
        ->controller(ContenidoInstitucionalController::class)
        ->middleware('permiso:publicaciones.gestionar')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | PÁGINA DE INICIO
            |--------------------------------------------------------------------------
            */

            Route::get('/inicio', 'inicio')
                ->name('inicio');

            Route::put('/inicio', 'actualizarInicio')
                ->name('inicio.actualizar');

            /*
            |--------------------------------------------------------------------------
            | LOGROS Y RECONOCIMIENTOS
            |--------------------------------------------------------------------------
            */

            Route::post('/logros', 'guardarLogro')
                ->name('logros.guardar');

            Route::put('/logros/{id}', 'actualizarLogro')
                ->whereNumber('id')
                ->name('logros.actualizar');

            Route::patch(
                '/logros/{id}/estado',
                'cambiarEstadoLogro'
            )
                ->whereNumber('id')
                ->name('logros.estado');

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - RESEÑA HISTÓRICA
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/resena-historica',
                'resenaHistorica'
            )->name('institucion.resena');

            Route::put(
                '/institucion/resena-historica',
                'actualizarResenaHistorica'
            )->name('institucion.resena.actualizar');

            /*
            |--------------------------------------------------------------------------
            | HITOS HISTÓRICOS
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/institucion/resena-historica/hitos',
                'guardarHitoHistorico'
            )->name('institucion.resena.hitos.guardar');

            Route::put(
                '/institucion/resena-historica/hitos/{id}',
                'actualizarHitoHistorico'
            )
                ->whereNumber('id')
                ->name('institucion.resena.hitos.actualizar');

            Route::patch(
                '/institucion/resena-historica/hitos/{id}/estado',
                'cambiarEstadoHitoHistorico'
            )
                ->whereNumber('id')
                ->name('institucion.resena.hitos.estado');

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - MISIÓN, VISIÓN Y VALORES
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/mision-vision-valores',
                'misionVisionValores'
            )->name('institucion.mision-vision-valores');

            Route::put(
                '/institucion/mision-vision-valores',
                'actualizarMisionVisionValores'
            )->name('institucion.mision-vision-valores.actualizar');

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - INFRAESTRUCTURA
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/infraestructura',
                'infraestructura'
            )->name('institucion.infraestructura');

            Route::put(
                '/institucion/infraestructura',
                'actualizarInfraestructura'
            )->name('institucion.infraestructura.actualizar');

            /*
            |--------------------------------------------------------------------------
            | AMBIENTES DE INFRAESTRUCTURA
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/institucion/infraestructura/ambientes/{ambiente}',
                'actualizarAmbienteInfraestructura'
            )
                ->whereNumber('ambiente')
                ->name(
                    'institucion.infraestructura.ambientes.actualizar'
                );

            Route::patch(
                '/institucion/infraestructura/ambientes/{ambiente}/estado',
                'cambiarEstadoInfraestructura'
            )
                ->whereNumber('ambiente')
                ->name(
                    'institucion.infraestructura.ambientes.estado'
                );

            /*
            |--------------------------------------------------------------------------
            | GALERÍA DE AMBIENTES
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/institucion/infraestructura/ambientes/{ambiente}/imagenes',
                'agregarImagenInfraestructura'
            )
                ->whereNumber('ambiente')
                ->name(
                    'institucion.infraestructura.ambientes.imagenes.guardar'
                );

            Route::delete(
                '/institucion/infraestructura/imagenes/{imagen}',
                'eliminarImagenInfraestructura'
            )
                ->whereNumber('imagen')
                ->name(
                    'institucion.infraestructura.imagenes.eliminar'
                );

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - CONVENIOS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/convenios',
                'convenios'
            )->name('institucion.convenios');

            Route::post(
                '/institucion/convenios',
                'guardarConvenio'
            )->name('institucion.convenios.guardar');

            Route::put(
                '/institucion/convenios/{convenio}',
                'actualizarConvenio'
            )
                ->whereNumber('convenio')
                ->name('institucion.convenios.actualizar');

            Route::patch(
                '/institucion/convenios/{convenio}/estado',
                'cambiarEstadoConvenio'
            )
                ->whereNumber('convenio')
                ->name('institucion.convenios.estado');

            Route::post(
                '/institucion/convenios/{convenio}/imagenes',
                'agregarImagenesConvenio'
            )
                ->whereNumber('convenio')
                ->name('institucion.convenios.imagenes.guardar');

            Route::delete(
                '/institucion/convenios/imagenes/{imagen}',
                'eliminarImagenConvenio'
            )
                ->whereNumber('imagen')
                ->name('institucion.convenios.imagenes.eliminar');

            Route::delete(
                '/institucion/convenios/{convenio}',
                'eliminarConvenio'
            )
                ->whereNumber('convenio')
                ->name('institucion.convenios.eliminar');

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - COMUNIDAD EDUCATIVA
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/comunidad-educativa',
                'comunidadEducativa'
            )->name('institucion.comunidad-educativa');

            Route::put(
                '/institucion/comunidad-educativa',
                'actualizarComunidadEducativa'
            )->name(
                'institucion.comunidad-educativa.actualizar'
            );

            Route::post(
                '/institucion/comunidad-educativa/grupos',
                'guardarGrupoComunidadEducativa'
            )->name(
                'institucion.comunidad-educativa.grupos.guardar'
            );

            Route::put(
                '/institucion/comunidad-educativa/grupos/{grupo}',
                'actualizarGrupoComunidadEducativa'
            )
                ->whereNumber('grupo')
                ->name(
                    'institucion.comunidad-educativa.grupos.actualizar'
                );

            Route::patch(
                '/institucion/comunidad-educativa/grupos/{grupo}/estado',
                'cambiarEstadoGrupoComunidadEducativa'
            )
                ->whereNumber('grupo')
                ->name(
                    'institucion.comunidad-educativa.grupos.estado'
                );

            Route::delete(
                '/institucion/comunidad-educativa/grupos/{grupo}',
                'eliminarGrupoComunidadEducativa'
            )
                ->whereNumber('grupo')
                ->name(
                    'institucion.comunidad-educativa.grupos.eliminar'
                );

            /*
            |--------------------------------------------------------------------------
            | INSTITUCIÓN - NUESTRA FORMA DE ENSEÑAR
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/institucion/nuestra-forma-de-ensenar',
                'nuestraFormaEnsenar'
            )->name(
                'institucion.nuestra-forma-de-ensenar'
            );

            Route::put(
                '/institucion/nuestra-forma-de-ensenar',
                'actualizarNuestraFormaEnsenar'
            )->name(
                'institucion.nuestra-forma-de-ensenar.actualizar'
            );

            /*
            |--------------------------------------------------------------------------
            | PRINCIPIOS PEDAGÓGICOS
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/institucion/nuestra-forma-de-ensenar/principios',
                'guardarPrincipioFormaEnsenar'
            )->name(
                'institucion.nuestra-forma-de-ensenar.principios.guardar'
            );

            Route::put(
                '/institucion/nuestra-forma-de-ensenar/principios/{principio}',
                'actualizarPrincipioFormaEnsenar'
            )
                ->whereNumber('principio')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.principios.actualizar'
                );

            Route::patch(
                '/institucion/nuestra-forma-de-ensenar/principios/{principio}/estado',
                'cambiarEstadoPrincipioFormaEnsenar'
            )
                ->whereNumber('principio')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.principios.estado'
                );

            Route::delete(
                '/institucion/nuestra-forma-de-ensenar/principios/{principio}',
                'eliminarPrincipioFormaEnsenar'
            )
                ->whereNumber('principio')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.principios.eliminar'
                );

            /*
            |--------------------------------------------------------------------------
            | ETAPAS DEL PROCESO DE APRENDIZAJE
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/institucion/nuestra-forma-de-ensenar/etapas',
                'guardarEtapaFormaEnsenar'
            )->name(
                'institucion.nuestra-forma-de-ensenar.etapas.guardar'
            );

            Route::put(
                '/institucion/nuestra-forma-de-ensenar/etapas/{etapa}',
                'actualizarEtapaFormaEnsenar'
            )
                ->whereNumber('etapa')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.etapas.actualizar'
                );

            Route::patch(
                '/institucion/nuestra-forma-de-ensenar/etapas/{etapa}/estado',
                'cambiarEstadoEtapaFormaEnsenar'
            )
                ->whereNumber('etapa')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.etapas.estado'
                );

            Route::delete(
                '/institucion/nuestra-forma-de-ensenar/etapas/{etapa}',
                'eliminarEtapaFormaEnsenar'
            )
                ->whereNumber('etapa')
                ->name(
                    'institucion.nuestra-forma-de-ensenar.etapas.eliminar'
                );

        });

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';