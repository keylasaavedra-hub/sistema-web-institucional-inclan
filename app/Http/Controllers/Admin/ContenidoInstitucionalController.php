<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformacionInstitucional;
use App\Models\Convenio;
use App\Models\ConvenioArchivo;
use App\Models\ComunidadEducativaGrupo;
use App\Models\FormaEnsenarPrincipio;
use App\Models\FormaEnsenarEtapa;
use App\Models\InfraestructuraAmbiente;
use App\Models\InfraestructuraImagen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContenidoInstitucionalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PÁGINA DE CONTENIDO INSTITUCIONAL
    |--------------------------------------------------------------------------
    */

    public function inicio(): View
    {
        /*
        |--------------------------------------------------------------------------
        | CONTENIDO GENERAL DEL INICIO
        |--------------------------------------------------------------------------
        */

        $contenidos = InformacionInstitucional::query()
            ->whereIn('tipo', [
                'portada_inicio',
                'saludo_director',
                'mision',
                'vision',
                'valores',
                'enfoque_inicio',
                'servicios_inicio',
                'logros_inicio',
            ])
            ->get()
            ->keyBy('tipo');

        /*
        |--------------------------------------------------------------------------
        | LOGROS Y RECONOCIMIENTOS REGISTRADOS
        |--------------------------------------------------------------------------
        */

        $logrosRegistrados = DB::table('logros')
            ->leftJoin(
                'niveles_educativos',
                'logros.nivel_educativo_id',
                '=',
                'niveles_educativos.id'
            )
            ->select([
                'logros.id',
                'logros.nivel_educativo_id',
                'logros.usuario_id',
                'logros.tipo',
                'logros.titulo',
                'logros.descripcion',
                'logros.fecha',
                'logros.imagen',
                'logros.archivo_respaldo',
                'logros.estado',
                'logros.created_at',
                'logros.updated_at',
                'niveles_educativos.nombre as nivel',
            ])
            ->orderByDesc('logros.fecha')
            ->orderByDesc('logros.id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | NIVELES EDUCATIVOS
        |--------------------------------------------------------------------------
        */

        $nivelesEducativos = DB::table('niveles_educativos')
            ->orderBy('nombre')
            ->get([
                'id',
                'nombre',
            ]);

        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.contenido-institucional.inicio',
            compact(
                'contenidos',
                'logrosRegistrados',
                'nivelesEducativos'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CONTENIDO DEL INICIO
    |--------------------------------------------------------------------------
    */

    public function actualizarInicio(Request $request): RedirectResponse
    {
        $datos = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | PORTADA
            |--------------------------------------------------------------------------
            */

            'portada_titulo' => [
                'required',
                'string',
                'max:150',
            ],

            'portada_subtitulo' => [
                'required',
                'string',
                'max:150',
            ],

            'portada_contenido' => [
                'required',
                'string',
                'max:1000',
            ],

            'portada_lema' => [
                'nullable',
                'string',
                'max:150',
            ],

            'portada_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | DIRECTOR
            |--------------------------------------------------------------------------
            */

            'director_nombre' => [
                'required',
                'string',
                'max:150',
            ],

            'director_cargo' => [
                'required',
                'string',
                'max:150',
            ],

            'director_mensaje' => [
                'required',
                'string',
                'max:5000',
            ],

            'director_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | MISIÓN
            |--------------------------------------------------------------------------
            */

            'mision_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'mision_contenido' => [
                'required',
                'string',
                'max:3000',
            ],

            'mision_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | VISIÓN
            |--------------------------------------------------------------------------
            */

            'vision_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'vision_contenido' => [
                'required',
                'string',
                'max:3000',
            ],

            'vision_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | VALORES
            |--------------------------------------------------------------------------
            */

            'valores_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'valores_contenido' => [
                'required',
                'string',
                'max:3000',
            ],

            'valores_lista' => [
                'required',
                'string',
                'max:2000',
            ],

            'valores_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | ENFOQUE INSTITUCIONAL
            |--------------------------------------------------------------------------
            */

            'enfoque_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'enfoque_contenido' => [
                'required',
                'string',
                'max:3000',
            ],

            'enfoque_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | SERVICIOS COMPLEMENTARIOS - GENERAL
            |--------------------------------------------------------------------------
            */

            'servicios_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'servicios_titulo' => [
                'required',
                'string',
                'max:150',
            ],

            'servicios_descripcion' => [
                'required',
                'string',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | TÓPICO
            |--------------------------------------------------------------------------
            */

            'topico_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'topico_subtitulo' => [
                'required',
                'string',
                'max:150',
            ],

            'topico_descripcion' => [
                'required',
                'string',
                'max:1000',
            ],

            'topico_horario' => [
                'required',
                'string',
                'max:200',
            ],

            'topico_funciones' => [
                'required',
                'string',
                'max:3000',
            ],

            'topico_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'topico_galeria_1' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'topico_galeria_2' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'topico_galeria_3' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'topico_galeria_4' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | TOECE
            |--------------------------------------------------------------------------
            */

            'toece_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'toece_subtitulo' => [
                'required',
                'string',
                'max:150',
            ],

            'toece_descripcion' => [
                'required',
                'string',
                'max:1000',
            ],

            'toece_horario' => [
                'required',
                'string',
                'max:200',
            ],

            'toece_funciones' => [
                'required',
                'string',
                'max:3000',
            ],

            'toece_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'toece_galeria_1' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'toece_galeria_2' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'toece_galeria_3' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'toece_galeria_4' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | PSICOLOGÍA
            |--------------------------------------------------------------------------
            */

            'psicologia_titulo' => [
                'required',
                'string',
                'max:100',
            ],

            'psicologia_subtitulo' => [
                'required',
                'string',
                'max:150',
            ],

            'psicologia_descripcion' => [
                'required',
                'string',
                'max:1000',
            ],

            'psicologia_horario' => [
                'required',
                'string',
                'max:200',
            ],

            'psicologia_funciones' => [
                'required',
                'string',
                'max:3000',
            ],

            'psicologia_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'psicologia_galeria_1' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'psicologia_galeria_2' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'psicologia_galeria_3' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'psicologia_galeria_4' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | LOGROS - ENCABEZADO GENERAL
            |--------------------------------------------------------------------------
            */

            'logros_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'logros_titulo' => [
                'required',
                'string',
                'max:150',
            ],

            'logros_descripcion' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PORTADA
        |--------------------------------------------------------------------------
        */

        $portada = InformacionInstitucional::firstOrNew([
            'tipo' => 'portada_inicio',
        ]);

        $portada->titulo = $datos['portada_titulo'];
        $portada->subtitulo = $datos['portada_subtitulo'];
        $portada->contenido = $datos['portada_contenido'];

        $portada->datos = [
            'lema' => $datos['portada_lema'] ?? null,
        ];

        $portada->orden = 1;
        $portada->estado = true;
        $portada->usuario_id = Auth::id();

        if ($request->hasFile('portada_imagen')) {
            $portada->imagen = $this->guardarImagen(
                $request,
                'portada_imagen',
                $portada->imagen
            );
        }

        $portada->save();

        /*
        |--------------------------------------------------------------------------
        | DIRECTOR
        |--------------------------------------------------------------------------
        */

        $director = InformacionInstitucional::firstOrNew([
            'tipo' => 'saludo_director',
        ]);

        $director->titulo = $datos['director_nombre'];
        $director->subtitulo = $datos['director_cargo'];
        $director->contenido = $datos['director_mensaje'];
        $director->orden = 2;
        $director->estado = true;
        $director->usuario_id = Auth::id();

        if ($request->hasFile('director_imagen')) {
            $director->imagen = $this->guardarImagen(
                $request,
                'director_imagen',
                $director->imagen
            );
        }

        $director->save();

        /*
        |--------------------------------------------------------------------------
        | MISIÓN
        |--------------------------------------------------------------------------
        */

        $mision = InformacionInstitucional::firstOrNew([
            'tipo' => 'mision',
        ]);

        $mision->titulo = $datos['mision_titulo'];
        $mision->contenido = $datos['mision_contenido'];
        $mision->orden = 3;
        $mision->estado = true;
        $mision->usuario_id = Auth::id();

        if ($request->hasFile('mision_imagen')) {
            $mision->imagen = $this->guardarImagen(
                $request,
                'mision_imagen',
                $mision->imagen
            );
        }

        $mision->save();

        /*
        |--------------------------------------------------------------------------
        | VISIÓN
        |--------------------------------------------------------------------------
        */

        $vision = InformacionInstitucional::firstOrNew([
            'tipo' => 'vision',
        ]);

        $vision->titulo = $datos['vision_titulo'];
        $vision->contenido = $datos['vision_contenido'];
        $vision->orden = 4;
        $vision->estado = true;
        $vision->usuario_id = Auth::id();

        if ($request->hasFile('vision_imagen')) {
            $vision->imagen = $this->guardarImagen(
                $request,
                'vision_imagen',
                $vision->imagen
            );
        }

        $vision->save();

        /*
        |--------------------------------------------------------------------------
        | VALORES
        |--------------------------------------------------------------------------
        */

        $listaValores = $this->textoALista(
            $datos['valores_lista']
        );

        $valores = InformacionInstitucional::firstOrNew([
            'tipo' => 'valores',
        ]);

        $valores->titulo = $datos['valores_titulo'];
        $valores->contenido = $datos['valores_contenido'];

        $valores->datos = [
            'lista' => $listaValores,
        ];

        $valores->orden = 5;
        $valores->estado = true;
        $valores->usuario_id = Auth::id();

        if ($request->hasFile('valores_imagen')) {
            $valores->imagen = $this->guardarImagen(
                $request,
                'valores_imagen',
                $valores->imagen
            );
        }

        $valores->save();

        /*
        |--------------------------------------------------------------------------
        | ENFOQUE INSTITUCIONAL
        |--------------------------------------------------------------------------
        */

        $enfoque = InformacionInstitucional::firstOrNew([
            'tipo' => 'enfoque_inicio',
        ]);

        $enfoque->titulo = $datos['enfoque_titulo'];
        $enfoque->contenido = $datos['enfoque_contenido'];
        $enfoque->orden = 6;
        $enfoque->estado = true;
        $enfoque->usuario_id = Auth::id();

        if ($request->hasFile('enfoque_imagen')) {
            $enfoque->imagen = $this->guardarImagen(
                $request,
                'enfoque_imagen',
                $enfoque->imagen
            );
        }

        $enfoque->save();

        /*
        |--------------------------------------------------------------------------
        | SERVICIOS COMPLEMENTARIOS
        |--------------------------------------------------------------------------
        */

        $servicios = InformacionInstitucional::firstOrNew([
            'tipo' => 'servicios_inicio',
        ]);

        $datosServicios = $servicios->datos ?? [];

        /*
        |--------------------------------------------------------------------------
        | FUNCIONES
        |--------------------------------------------------------------------------
        */

        $funcionesTopico = $this->textoALista(
            $datos['topico_funciones']
        );

        $funcionesToece = $this->textoALista(
            $datos['toece_funciones']
        );

        $funcionesPsicologia = $this->textoALista(
            $datos['psicologia_funciones']
        );

        /*
        |--------------------------------------------------------------------------
        | DATOS EXISTENTES DE SERVICIOS
        |--------------------------------------------------------------------------
        */

        $galeriaTopico =
            $datosServicios['topico']['galeria'] ?? [];

        $galeriaToece =
            $datosServicios['toece']['galeria'] ?? [];

        $galeriaPsicologia =
            $datosServicios['psicologia']['galeria'] ?? [];

        $imagenTopico =
            $datosServicios['topico']['imagen'] ?? null;

        $imagenToece =
            $datosServicios['toece']['imagen'] ?? null;

        $imagenPsicologia =
            $datosServicios['psicologia']['imagen'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | IMAGEN PRINCIPAL TÓPICO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('topico_imagen')) {
            $imagenTopico = $this->guardarImagen(
                $request,
                'topico_imagen',
                $imagenTopico
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GALERÍA TÓPICO
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 4; $i++) {
            $campo = 'topico_galeria_' . $i;

            if ($request->hasFile($campo)) {
                $galeriaTopico[$i - 1] =
                    $this->guardarImagen(
                        $request,
                        $campo,
                        $galeriaTopico[$i - 1] ?? null
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IMAGEN PRINCIPAL TOECE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('toece_imagen')) {
            $imagenToece = $this->guardarImagen(
                $request,
                'toece_imagen',
                $imagenToece
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GALERÍA TOECE
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 4; $i++) {
            $campo = 'toece_galeria_' . $i;

            if ($request->hasFile($campo)) {
                $galeriaToece[$i - 1] =
                    $this->guardarImagen(
                        $request,
                        $campo,
                        $galeriaToece[$i - 1] ?? null
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IMAGEN PRINCIPAL PSICOLOGÍA
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('psicologia_imagen')) {
            $imagenPsicologia = $this->guardarImagen(
                $request,
                'psicologia_imagen',
                $imagenPsicologia
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GALERÍA PSICOLOGÍA
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 4; $i++) {
            $campo = 'psicologia_galeria_' . $i;

            if ($request->hasFile($campo)) {
                $galeriaPsicologia[$i - 1] =
                    $this->guardarImagen(
                        $request,
                        $campo,
                        $galeriaPsicologia[$i - 1] ?? null
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TÓPICO
        |--------------------------------------------------------------------------
        */

        $datosServicios['topico'] = [
            'titulo' => $datos['topico_titulo'],
            'subtitulo' => $datos['topico_subtitulo'],
            'descripcion' => $datos['topico_descripcion'],
            'horario' => $datos['topico_horario'],
            'funciones' => $funcionesTopico,
            'imagen' => $imagenTopico,
            'galeria' => array_values(
                $galeriaTopico
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | TOECE
        |--------------------------------------------------------------------------
        */

        $datosServicios['toece'] = [
            'titulo' => $datos['toece_titulo'],
            'subtitulo' => $datos['toece_subtitulo'],
            'descripcion' => $datos['toece_descripcion'],
            'horario' => $datos['toece_horario'],
            'funciones' => $funcionesToece,
            'imagen' => $imagenToece,
            'galeria' => array_values(
                $galeriaToece
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | PSICOLOGÍA
        |--------------------------------------------------------------------------
        */

        $datosServicios['psicologia'] = [
            'titulo' => $datos['psicologia_titulo'],
            'subtitulo' => $datos['psicologia_subtitulo'],
            'descripcion' => $datos['psicologia_descripcion'],
            'horario' => $datos['psicologia_horario'],
            'funciones' => $funcionesPsicologia,
            'imagen' => $imagenPsicologia,
            'galeria' => array_values(
                $galeriaPsicologia
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | INFORMACIÓN GENERAL DE SERVICIOS
        |--------------------------------------------------------------------------
        */

        $servicios->titulo =
            $datos['servicios_titulo'];

        $servicios->subtitulo =
            $datos['servicios_etiqueta'];

        $servicios->contenido =
            $datos['servicios_descripcion'];

        $servicios->datos =
            $datosServicios;

        $servicios->orden = 7;
        $servicios->estado = true;
        $servicios->usuario_id = Auth::id();

        $servicios->save();

        /*
        |--------------------------------------------------------------------------
        | LOGROS - ENCABEZADO GENERAL
        |--------------------------------------------------------------------------
        */

        $logros = InformacionInstitucional::firstOrNew([
            'tipo' => 'logros_inicio',
        ]);

        $logros->titulo =
            $datos['logros_titulo'];

        $logros->subtitulo =
            $datos['logros_etiqueta'];

        $logros->contenido =
            $datos['logros_descripcion'];

        $logros->orden = 8;
        $logros->estado = true;
        $logros->usuario_id = Auth::id();

        $logros->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.inicio'
            )
            ->with(
                'success',
                'El contenido de la página de inicio fue actualizado correctamente.'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVO LOGRO O RECONOCIMIENTO
    |--------------------------------------------------------------------------
    */

    public function guardarLogro(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'logro_tipo' => [
                'required',
                'in:logro,reconocimiento',
            ],

            'logro_titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'logro_nivel_educativo_id' => [
                'nullable',
                'integer',
                'exists:niveles_educativos,id',
            ],

            'logro_fecha' => [
                'required',
                'date',
            ],

            'logro_descripcion' => [
                'required',
                'string',
                'max:5000',
            ],

            'logro_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $imagen = null;

        if ($request->hasFile('logro_imagen')) {
            $imagen = $request
                ->file('logro_imagen')
                ->store(
                    'logros',
                    'public'
                );
        }

        DB::table('logros')->insert([
            'nivel_educativo_id' =>
                $datos['logro_nivel_educativo_id'] ?? null,

            'usuario_id' => Auth::id(),

            'tipo' => $datos['logro_tipo'],

            'titulo' => $datos['logro_titulo'],

            'descripcion' => $datos['logro_descripcion'],

            'fecha' => $datos['logro_fecha'],

            'imagen' => $imagen,

            'archivo_respaldo' => null,

            'estado' => true,

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.inicio'
            )
            ->with(
                'success',
                'El logro o reconocimiento fue registrado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR LOGRO O RECONOCIMIENTO
    |--------------------------------------------------------------------------
    */

    public function actualizarLogro(
        Request $request,
        int $id
    ): RedirectResponse {
        $logro = DB::table('logros')
            ->where('id', $id)
            ->first();

        abort_unless($logro, 404);

        $datos = $request->validate([
            'logro_tipo' => [
                'required',
                'in:logro,reconocimiento',
            ],

            'logro_titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'logro_nivel_educativo_id' => [
                'nullable',
                'integer',
                'exists:niveles_educativos,id',
            ],

            'logro_fecha' => [
                'required',
                'date',
            ],

            'logro_descripcion' => [
                'required',
                'string',
                'max:5000',
            ],

            'logro_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $imagen = $logro->imagen;

        if ($request->hasFile('logro_imagen')) {

            if (
                $imagen
                && Storage::disk('public')->exists($imagen)
            ) {
                Storage::disk('public')->delete($imagen);
            }

            $imagen = $request
                ->file('logro_imagen')
                ->store(
                    'logros',
                    'public'
                );
        }

        DB::table('logros')
            ->where('id', $id)
            ->update([
                'nivel_educativo_id' =>
                    $datos['logro_nivel_educativo_id'] ?? null,

                'usuario_id' => Auth::id(),

                'tipo' => $datos['logro_tipo'],

                'titulo' => $datos['logro_titulo'],

                'descripcion' => $datos['logro_descripcion'],

                'fecha' => $datos['logro_fecha'],

                'imagen' => $imagen,

                'updated_at' => now(),
            ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.inicio'
            )
            ->with(
                'success',
                'El logro o reconocimiento fue actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR LOGRO
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoLogro(
        int $id
    ): RedirectResponse {
        $logro = DB::table('logros')
            ->where('id', $id)
            ->first();

        abort_unless($logro, 404);

        DB::table('logros')
            ->where('id', $id)
            ->update([
                'estado' => ! (bool) $logro->estado,
                'usuario_id' => Auth::id(),
                'updated_at' => now(),
            ]);

        $mensaje = $logro->estado
            ? 'El logro fue ocultado del portal público.'
            : 'El logro fue publicado correctamente.';

        return redirect()
            ->route(
                'admin.contenido-institucional.inicio'
            )
            ->with(
                'success',
                $mensaje
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MISIÓN, VISIÓN Y VALORES - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function misionVisionValores(): View
    {
        $contenidos = InformacionInstitucional::query()
            ->whereIn('tipo', [
                'identidad_institucional',
                'mision',
                'vision',
                'valores',
                'enfoque_inicio',
            ])
            ->get()
            ->keyBy('tipo');

        return view(
            'admin.contenido-institucional.institucion.mision-vision-valores',
            compact('contenidos')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR MISIÓN, VISIÓN Y VALORES
    |--------------------------------------------------------------------------
    */

    public function actualizarMisionVisionValores(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | ENCABEZADO
            |--------------------------------------------------------------------------
            */

            'identidad_etiqueta' => [
                'required', 'string', 'max:120',
            ],

            'identidad_titulo' => [
                'required', 'string', 'max:180',
            ],

            'identidad_descripcion' => [
                'required', 'string', 'max:1500',
            ],

            /*
            |--------------------------------------------------------------------------
            | MISIÓN
            |--------------------------------------------------------------------------
            */

            'mision_etiqueta' => [
                'required', 'string', 'max:100',
            ],

            'mision_titulo' => [
                'required', 'string', 'max:180',
            ],

            'mision_contenido' => [
                'required', 'string', 'max:3000',
            ],

            'mision_pilares' => [
                'required', 'string', 'max:3000',
            ],

            'mision_imagen' => [
                'nullable', 'image',
                'mimes:jpg,jpeg,png,webp', 'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | VISIÓN
            |--------------------------------------------------------------------------
            */

            'vision_etiqueta' => [
                'required', 'string', 'max:100',
            ],

            'vision_titulo' => [
                'required', 'string', 'max:180',
            ],

            'vision_contenido' => [
                'required', 'string', 'max:3000',
            ],

            'vision_pilares' => [
                'required', 'string', 'max:3000',
            ],

            'vision_imagen' => [
                'nullable', 'image',
                'mimes:jpg,jpeg,png,webp', 'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | VALORES
            |--------------------------------------------------------------------------
            */

            'valores_etiqueta' => [
                'required', 'string', 'max:100',
            ],

            'valores_titulo' => [
                'required', 'string', 'max:180',
            ],

            'valores_contenido' => [
                'required', 'string', 'max:3000',
            ],

            'valores_items' => [
                'required', 'string', 'max:6000',
            ],

            'valores_imagen' => [
                'nullable', 'image',
                'mimes:jpg,jpeg,png,webp', 'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | ENFOQUE INSTITUCIONAL
            |--------------------------------------------------------------------------
            */

            'enfoque_etiqueta' => [
                'required', 'string', 'max:100',
            ],

            'enfoque_titulo' => [
                'required', 'string', 'max:180',
            ],

            'enfoque_contenido' => [
                'required', 'string', 'max:3000',
            ],

            'enfoque_items' => [
                'required', 'string', 'max:6000',
            ],

            'enfoque_compromiso_etiqueta' => [
                'required', 'string', 'max:120',
            ],

            'enfoque_compromiso' => [
                'required', 'string', 'max:180',
            ],

            'enfoque_imagen' => [
                'nullable', 'image',
                'mimes:jpg,jpeg,png,webp', 'max:4096',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | ENCABEZADO
        |--------------------------------------------------------------------------
        */

        $identidad = InformacionInstitucional::firstOrNew([
            'tipo' => 'identidad_institucional',
        ]);

        $identidad->titulo = $datos['identidad_titulo'];
        $identidad->subtitulo = $datos['identidad_etiqueta'];
        $identidad->contenido = $datos['identidad_descripcion'];
        $identidad->datos = [];
        $identidad->orden = 10;
        $identidad->estado = true;
        $identidad->usuario_id = Auth::id();
        $identidad->save();

        /*
        |--------------------------------------------------------------------------
        | MISIÓN
        |--------------------------------------------------------------------------
        */

        $mision = InformacionInstitucional::firstOrNew([
            'tipo' => 'mision',
        ]);

        $datosMision = $mision->datos ?? [];

        $mision->titulo = $datos['mision_titulo'];
        $mision->subtitulo = $datos['mision_etiqueta'];
        $mision->contenido = $datos['mision_contenido'];
        $mision->datos = array_merge($datosMision, [
            'pilares' => $this->textoALista(
                $datos['mision_pilares']
            ),
        ]);

        $mision->orden = 3;
        $mision->estado = true;
        $mision->usuario_id = Auth::id();

        if ($request->hasFile('mision_imagen')) {
            $mision->imagen = $this->guardarImagen(
                $request,
                'mision_imagen',
                $mision->imagen
            );
        }

        $mision->save();

        /*
        |--------------------------------------------------------------------------
        | VISIÓN
        |--------------------------------------------------------------------------
        */

        $vision = InformacionInstitucional::firstOrNew([
            'tipo' => 'vision',
        ]);

        $datosVision = $vision->datos ?? [];

        $vision->titulo = $datos['vision_titulo'];
        $vision->subtitulo = $datos['vision_etiqueta'];
        $vision->contenido = $datos['vision_contenido'];
        $vision->datos = array_merge($datosVision, [
            'pilares' => $this->textoALista(
                $datos['vision_pilares']
            ),
        ]);

        $vision->orden = 4;
        $vision->estado = true;
        $vision->usuario_id = Auth::id();

        if ($request->hasFile('vision_imagen')) {
            $vision->imagen = $this->guardarImagen(
                $request,
                'vision_imagen',
                $vision->imagen
            );
        }

        $vision->save();

        /*
        |--------------------------------------------------------------------------
        | VALORES
        |--------------------------------------------------------------------------
        */

        $valores = InformacionInstitucional::firstOrNew([
            'tipo' => 'valores',
        ]);

        $itemsValores = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $datos['valores_items']
            )
        )
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->map(function ($linea) {
                [$nombre, $descripcion] = array_pad(
                    explode('|', $linea, 2),
                    2,
                    ''
                );

                return [
                    'nombre' => trim($nombre),
                    'descripcion' => trim($descripcion),
                ];
            })
            ->filter(fn ($item) => $item['nombre'] !== '')
            ->values()
            ->all();

        $datosValores = $valores->datos ?? [];

        $valores->titulo = $datos['valores_titulo'];
        $valores->subtitulo = $datos['valores_etiqueta'];
        $valores->contenido = $datos['valores_contenido'];
        $valores->datos = array_merge($datosValores, [
            'items' => $itemsValores,
            'lista' => collect($itemsValores)
                ->pluck('nombre')
                ->values()
                ->all(),
        ]);

        $valores->orden = 5;
        $valores->estado = true;
        $valores->usuario_id = Auth::id();

        if ($request->hasFile('valores_imagen')) {
            $valores->imagen = $this->guardarImagen(
                $request,
                'valores_imagen',
                $valores->imagen
            );
        }

        $valores->save();

        /*
        |--------------------------------------------------------------------------
        | ENFOQUE INSTITUCIONAL
        |--------------------------------------------------------------------------
        */

        $enfoque = InformacionInstitucional::firstOrNew([
            'tipo' => 'enfoque_inicio',
        ]);

        $itemsEnfoque = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $datos['enfoque_items']
            )
        )
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->map(function ($linea) {
                [$titulo, $texto] = array_pad(
                    explode('|', $linea, 2),
                    2,
                    ''
                );

                return [
                    'titulo' => trim($titulo),
                    'texto' => trim($texto),
                ];
            })
            ->filter(fn ($item) => $item['titulo'] !== '')
            ->values()
            ->all();

        $datosEnfoque = $enfoque->datos ?? [];

        $enfoque->titulo = $datos['enfoque_titulo'];
        $enfoque->subtitulo = $datos['enfoque_etiqueta'];
        $enfoque->contenido = $datos['enfoque_contenido'];
        $enfoque->datos = array_merge($datosEnfoque, [
            'items' => $itemsEnfoque,
            'compromiso_etiqueta' =>
                $datos['enfoque_compromiso_etiqueta'],
            'compromiso' =>
                $datos['enfoque_compromiso'],
        ]);

        $enfoque->orden = 6;
        $enfoque->estado = true;
        $enfoque->usuario_id = Auth::id();

        if ($request->hasFile('enfoque_imagen')) {
            $enfoque->imagen = $this->guardarImagen(
                $request,
                'enfoque_imagen',
                $enfoque->imagen
            );
        }

        $enfoque->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.mision-vision-valores'
            )
            ->with(
                'success',
                'La misión, visión, valores y enfoque institucional fueron actualizados correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | INFRAESTRUCTURA - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function infraestructura(): View
    {
        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'infraestructura',
        ]);

        $ambientes = InfraestructuraAmbiente::query()
            ->with([
                'imagenes' => function ($query) {
                    $query
                        ->orderBy('orden')
                        ->orderBy('id');
                },
            ])
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'admin.contenido-institucional.institucion.infraestructura',
            compact(
                'contenido',
                'ambientes'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CONTENIDO GENERAL DE INFRAESTRUCTURA
    |--------------------------------------------------------------------------
    */

    public function actualizarInfraestructura(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'etiqueta' => ['required', 'string', 'max:120'],
            'titulo' => ['required', 'string', 'max:180'],
            'descripcion_1' => ['required', 'string', 'max:3000'],
            'descripcion_2' => ['required', 'string', 'max:3000'],
            'destacado_titulo' => ['required', 'string', 'max:180'],
            'destacado_texto' => ['required', 'string', 'max:1000'],
            'ambientes_etiqueta' => ['required', 'string', 'max:120'],
            'ambientes_titulo' => ['required', 'string', 'max:180'],
            'ambientes_descripcion' => ['required', 'string', 'max:1500'],
            'cierre_etiqueta' => ['required', 'string', 'max:120'],
            'cierre_titulo' => ['required', 'string', 'max:180'],
            'cierre_descripcion' => ['required', 'string', 'max:1500'],

            'imagen_principal' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'infraestructura',
        ]);

        $datosActuales = $contenido->datos ?? [];

        $contenido->subtitulo = $datos['etiqueta'];
        $contenido->titulo = $datos['titulo'];
        $contenido->contenido = $datos['descripcion_1'];

        $contenido->datos = array_merge(
            $datosActuales,
            [
                'descripcion_2' => $datos['descripcion_2'],
                'destacado_titulo' => $datos['destacado_titulo'],
                'destacado_texto' => $datos['destacado_texto'],
                'ambientes_etiqueta' => $datos['ambientes_etiqueta'],
                'ambientes_titulo' => $datos['ambientes_titulo'],
                'ambientes_descripcion' => $datos['ambientes_descripcion'],
                'cierre_etiqueta' => $datos['cierre_etiqueta'],
                'cierre_titulo' => $datos['cierre_titulo'],
                'cierre_descripcion' => $datos['cierre_descripcion'],
            ]
        );

        $contenido->orden = 30;
        $contenido->estado = true;
        $contenido->usuario_id = Auth::id();

        if ($request->hasFile('imagen_principal')) {
            $contenido->imagen = $this->guardarImagen(
                $request,
                'imagen_principal',
                $contenido->imagen
            );
        }

        $contenido->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.infraestructura'
            )
            ->with(
                'success',
                'El contenido general de infraestructura fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR AMBIENTE DE INFRAESTRUCTURA
    |--------------------------------------------------------------------------
    */

    public function actualizarAmbienteInfraestructura(
        Request $request,
        int $id
    ): RedirectResponse {
        $ambiente = InfraestructuraAmbiente::findOrFail($id);

        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $imagen = $ambiente->imagen;

        if ($request->hasFile('imagen')) {
            if (
                $imagen
                && ! str_starts_with($imagen, 'images/')
                && Storage::disk('public')->exists($imagen)
            ) {
                Storage::disk('public')->delete($imagen);
            }

            $imagen = $request
                ->file('imagen')
                ->store(
                    'infraestructura/' . $ambiente->slug . '/principal',
                    'public'
                );
        }

        $ambiente->titulo = $datos['titulo'];
        $ambiente->descripcion = $datos['descripcion'];
        $ambiente->imagen = $imagen;
        $ambiente->usuario_id = Auth::id();
        $ambiente->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.infraestructura'
            )
            ->with(
                'success',
                'El ambiente fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AGREGAR FOTOGRAFÍAS A UN AMBIENTE
    |--------------------------------------------------------------------------
    */

    public function agregarImagenInfraestructura(
        Request $request,
        int $id
    ): RedirectResponse {
        $ambiente = InfraestructuraAmbiente::findOrFail($id);

        $request->validate([
            'imagenes' => [
                'required',
                'array',
                'min:1',
                'max:20',
            ],

            'imagenes.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $ultimoOrden = (int) InfraestructuraImagen::query()
            ->where(
                'infraestructura_ambiente_id',
                $ambiente->id
            )
            ->max('orden');

        foreach ($request->file('imagenes') as $archivo) {
            $ultimoOrden++;

            $ruta = $archivo->store(
                'infraestructura/' . $ambiente->slug . '/galeria',
                'public'
            );

            InfraestructuraImagen::create([
                'infraestructura_ambiente_id' => $ambiente->id,
                'imagen' => $ruta,
                'orden' => $ultimoOrden,
                'estado' => true,
                'usuario_id' => Auth::id(),
            ]);
        }

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.infraestructura'
            )
            ->with(
                'success',
                'Las fotografías fueron agregadas correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR FOTOGRAFÍA DE UN AMBIENTE
    |--------------------------------------------------------------------------
    */

    public function eliminarImagenInfraestructura(
        int $id
    ): RedirectResponse {
        $imagen = InfraestructuraImagen::findOrFail($id);

        if (
            $imagen->imagen
            && ! str_starts_with($imagen->imagen, 'images/')
            && Storage::disk('public')->exists(
                $imagen->imagen
            )
        ) {
            Storage::disk('public')->delete(
                $imagen->imagen
            );
        }

        $imagen->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.infraestructura'
            )
            ->with(
                'success',
                'La fotografía fue eliminada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR AMBIENTE
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoInfraestructura(
        int $id
    ): RedirectResponse {
        $ambiente = InfraestructuraAmbiente::findOrFail($id);

        $ambiente->estado = ! $ambiente->estado;
        $ambiente->usuario_id = Auth::id();
        $ambiente->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.infraestructura'
            )
            ->with(
                'success',
                $ambiente->estado
                    ? 'El ambiente fue publicado correctamente.'
                    : 'El ambiente fue ocultado del portal público.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CONVENIOS - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function convenios(): View
    {
        $convenios = Convenio::query()
            ->with([
                'archivos' => function ($query) {
                    $query
                        ->orderBy('orden')
                        ->orderBy('id');
                },
            ])
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'admin.contenido-institucional.institucion.convenios',
            compact('convenios')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVO CONVENIO
    |--------------------------------------------------------------------------
    */

    public function guardarConvenio(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:200',
            ],

            'tipo' => [
                'nullable',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:5000',
            ],

            'estado_texto' => [
                'required',
                'string',
                'max:100',
            ],

            'fecha_inicio' => [
                'nullable',
                'date',
            ],

            'fecha_fin' => [
                'nullable',
                'date',
                'after_or_equal:fecha_inicio',
            ],

            'objetivos' => [
                'nullable',
                'string',
                'max:8000',
            ],

            'beneficios' => [
                'nullable',
                'string',
                'max:8000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'imagenes' => [
                'nullable',
                'array',
                'max:20',
            ],

            'imagenes.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $slugBase = Str::slug($datos['nombre']);
        $slug = $slugBase;
        $contador = 2;

        while (
            Convenio::query()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $slugBase . '-' . $contador;
            $contador++;
        }

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request
                ->file('imagen')
                ->store(
                    'convenios/' . $slug . '/principal',
                    'public'
                );
        }

        $convenio = Convenio::create([
            'slug' => $slug,
            'usuario_id' => Auth::id(),
            'nombre' => $datos['nombre'],
            'institucion' => $datos['nombre'],
            'tipo' => $datos['tipo'] ?? null,
            'descripcion' => $datos['descripcion'],
            'fecha_inicio' => $datos['fecha_inicio'] ?? null,
            'fecha_fin' => $datos['fecha_fin'] ?? null,
            'imagen' => $imagen,
            'archivo' => null,
            'estado_texto' => $datos['estado_texto'],
            'objetivos' => $this->textoALista(
                $datos['objetivos'] ?? ''
            ),
            'beneficios' => $this->textoALista(
                $datos['beneficios'] ?? ''
            ),
            'orden' => $datos['orden'],
            'estado' => true,
        ]);

        if ($request->hasFile('imagenes')) {
            $ordenArchivo = 0;

            foreach ($request->file('imagenes') as $archivo) {
                $ordenArchivo++;

                $ruta = $archivo->store(
                    'convenios/' . $slug . '/galeria',
                    'public'
                );

                ConvenioArchivo::create([
                    'convenio_id' => $convenio->id,
                    'archivo' => $ruta,
                    'tipo' => 'imagen',
                    'orden' => $ordenArchivo,
                    'estado' => true,
                    'usuario_id' => Auth::id(),
                ]);
            }
        }

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                'El convenio fue registrado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CONVENIO
    |--------------------------------------------------------------------------
    */

    public function actualizarConvenio(
        Request $request,
        int $id
    ): RedirectResponse {
        $convenio = Convenio::findOrFail($id);

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:200',
            ],

            'tipo' => [
                'nullable',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:5000',
            ],

            'estado_texto' => [
                'required',
                'string',
                'max:100',
            ],

            'fecha_inicio' => [
                'nullable',
                'date',
            ],

            'fecha_fin' => [
                'nullable',
                'date',
                'after_or_equal:fecha_inicio',
            ],

            'objetivos' => [
                'nullable',
                'string',
                'max:8000',
            ],

            'beneficios' => [
                'nullable',
                'string',
                'max:8000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $imagen = $convenio->imagen;

        if ($request->hasFile('imagen')) {
            if (
                $imagen
                && ! str_starts_with($imagen, 'images/')
                && Storage::disk('public')->exists($imagen)
            ) {
                Storage::disk('public')->delete($imagen);
            }

            $imagen = $request
                ->file('imagen')
                ->store(
                    'convenios/' . $convenio->slug . '/principal',
                    'public'
                );
        }

        $convenio->update([
            'usuario_id' => Auth::id(),
            'nombre' => $datos['nombre'],
            'institucion' => $datos['nombre'],
            'tipo' => $datos['tipo'] ?? null,
            'descripcion' => $datos['descripcion'],
            'fecha_inicio' => $datos['fecha_inicio'] ?? null,
            'fecha_fin' => $datos['fecha_fin'] ?? null,
            'imagen' => $imagen,
            'estado_texto' => $datos['estado_texto'],
            'objetivos' => $this->textoALista(
                $datos['objetivos'] ?? ''
            ),
            'beneficios' => $this->textoALista(
                $datos['beneficios'] ?? ''
            ),
            'orden' => $datos['orden'],
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                'El convenio fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AGREGAR IMÁGENES A UN CONVENIO
    |--------------------------------------------------------------------------
    */

    public function agregarImagenesConvenio(
        Request $request,
        int $id
    ): RedirectResponse {
        $convenio = Convenio::findOrFail($id);

        $request->validate([
            'imagenes' => [
                'required',
                'array',
                'min:1',
                'max:20',
            ],

            'imagenes.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $ultimoOrden = (int) ConvenioArchivo::query()
            ->where('convenio_id', $convenio->id)
            ->max('orden');

        foreach ($request->file('imagenes') as $archivo) {
            $ultimoOrden++;

            $ruta = $archivo->store(
                'convenios/' . $convenio->slug . '/galeria',
                'public'
            );

            ConvenioArchivo::create([
                'convenio_id' => $convenio->id,
                'archivo' => $ruta,
                'tipo' => 'imagen',
                'orden' => $ultimoOrden,
                'estado' => true,
                'usuario_id' => Auth::id(),
            ]);
        }

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                'Las imágenes fueron agregadas correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR IMAGEN DE CONVENIO
    |--------------------------------------------------------------------------
    */

    public function eliminarImagenConvenio(
        int $id
    ): RedirectResponse {
        $archivo = ConvenioArchivo::findOrFail($id);

        if (
            $archivo->archivo
            && ! str_starts_with($archivo->archivo, 'images/')
            && Storage::disk('public')->exists($archivo->archivo)
        ) {
            Storage::disk('public')->delete($archivo->archivo);
        }

        $archivo->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                'La imagen fue eliminada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR CONVENIO
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoConvenio(
        int $id
    ): RedirectResponse {
        $convenio = Convenio::findOrFail($id);

        $convenio->estado = ! (bool) $convenio->estado;
        $convenio->usuario_id = Auth::id();
        $convenio->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                $convenio->estado
                    ? 'El convenio fue publicado correctamente.'
                    : 'El convenio fue ocultado del portal público.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR CONVENIO
    |--------------------------------------------------------------------------
    */

    public function eliminarConvenio(
        int $id
    ): RedirectResponse {
        $convenio = Convenio::query()
            ->with('archivos')
            ->findOrFail($id);

        if (
            $convenio->imagen
            && ! str_starts_with($convenio->imagen, 'images/')
            && Storage::disk('public')->exists($convenio->imagen)
        ) {
            Storage::disk('public')->delete($convenio->imagen);
        }

        foreach ($convenio->archivos as $archivo) {
            if (
                $archivo->archivo
                && ! str_starts_with($archivo->archivo, 'images/')
                && Storage::disk('public')->exists($archivo->archivo)
            ) {
                Storage::disk('public')->delete($archivo->archivo);
            }
        }

        $convenio->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.convenios'
            )
            ->with(
                'success',
                'El convenio fue eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | COMUNIDAD EDUCATIVA - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function comunidadEducativa(): View
    {
        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'comunidad_educativa',
        ]);

        $grupos = ComunidadEducativaGrupo::query()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'admin.contenido-institucional.institucion.comunidad-educativa',
            compact(
                'contenido',
                'grupos'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CONTENIDO GENERAL DE COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function actualizarComunidadEducativa(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'etiqueta' => ['required', 'string', 'max:120'],
            'titulo' => ['required', 'string', 'max:180'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'trabajo_etiqueta' => ['required', 'string', 'max:120'],
            'trabajo_titulo' => ['required', 'string', 'max:180'],
            'trabajo_descripcion' => ['required', 'string', 'max:2000'],
            'cierre_etiqueta' => ['required', 'string', 'max:120'],
            'cierre_titulo' => ['required', 'string', 'max:180'],
            'cierre_descripcion' => ['required', 'string', 'max:2000'],
        ]);

        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'comunidad_educativa',
        ]);

        $contenido->subtitulo = $datos['etiqueta'];
        $contenido->titulo = $datos['titulo'];
        $contenido->contenido = $datos['descripcion'];

        $contenido->datos = [
            'trabajo_etiqueta' => $datos['trabajo_etiqueta'],
            'trabajo_titulo' => $datos['trabajo_titulo'],
            'trabajo_descripcion' => $datos['trabajo_descripcion'],
            'cierre_etiqueta' => $datos['cierre_etiqueta'],
            'cierre_titulo' => $datos['cierre_titulo'],
            'cierre_descripcion' => $datos['cierre_descripcion'],
        ];

        $contenido->orden = 40;
        $contenido->estado = true;
        $contenido->usuario_id = Auth::id();
        $contenido->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.comunidad-educativa'
            )
            ->with(
                'success',
                'El contenido general de Comunidad educativa fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVO GRUPO DE COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function guardarGrupoComunidadEducativa(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $slugBase = Str::slug($datos['titulo']);

        if ($slugBase === '') {
            $slugBase = 'grupo';
        }

        $slug = $slugBase;
        $contador = 2;

        while (
            ComunidadEducativaGrupo::query()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $slugBase . '-' . $contador;
            $contador++;
        }

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request
                ->file('imagen')
                ->store(
                    'comunidad-educativa/' . $slug,
                    'public'
                );
        }

        ComunidadEducativaGrupo::create([
            'slug' => $slug,
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'imagen' => $imagen,
            'icono' => 'comunidad',
            'orden' => $datos['orden'],
            'estado' => true,
            'usuario_id' => Auth::id(),
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.comunidad-educativa'
            )
            ->with(
                'success',
                'El nuevo grupo de Comunidad educativa fue registrado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR GRUPO DE COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function actualizarGrupoComunidadEducativa(
        Request $request,
        int $id
    ): RedirectResponse {
        $grupo = ComunidadEducativaGrupo::findOrFail($id);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string', 'max:3000'],
            'orden' => ['required', 'integer', 'min:0', 'max:9999'],
            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $imagen = $grupo->imagen;

        if ($request->hasFile('imagen')) {
            if (
                $imagen
                && ! str_starts_with($imagen, 'images/')
                && Storage::disk('public')->exists($imagen)
            ) {
                Storage::disk('public')->delete($imagen);
            }

            $imagen = $request
                ->file('imagen')
                ->store(
                    'comunidad-educativa/' . $grupo->slug,
                    'public'
                );
        }

        $grupo->titulo = $datos['titulo'];
        $grupo->descripcion = $datos['descripcion'];
        $grupo->orden = $datos['orden'];
        $grupo->imagen = $imagen;
        $grupo->usuario_id = Auth::id();
        $grupo->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.comunidad-educativa'
            )
            ->with(
                'success',
                'El grupo de Comunidad educativa fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR GRUPO DE COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoGrupoComunidadEducativa(
        int $id
    ): RedirectResponse {
        $grupo = ComunidadEducativaGrupo::findOrFail($id);

        $grupo->estado = ! (bool) $grupo->estado;
        $grupo->usuario_id = Auth::id();
        $grupo->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.comunidad-educativa'
            )
            ->with(
                'success',
                $grupo->estado
                    ? 'El grupo fue publicado correctamente.'
                    : 'El grupo fue ocultado del portal público.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR GRUPO DE COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function eliminarGrupoComunidadEducativa(
        int $id
    ): RedirectResponse {
        $grupo = ComunidadEducativaGrupo::findOrFail($id);

        if (
            $grupo->imagen
            && ! str_starts_with($grupo->imagen, 'images/')
            && Storage::disk('public')->exists($grupo->imagen)
        ) {
            Storage::disk('public')->delete($grupo->imagen);
        }

        $grupo->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.comunidad-educativa'
            )
            ->with(
                'success',
                'El grupo de Comunidad educativa fue eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | NUESTRA FORMA DE ENSEÑAR - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function nuestraFormaEnsenar(): View
    {
        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'forma_ensenar',
        ]);

        $principios = FormaEnsenarPrincipio::query()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $etapas = FormaEnsenarEtapa::query()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar',
            compact(
                'contenido',
                'principios',
                'etapas'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CONTENIDO GENERAL DE NUESTRA FORMA DE ENSEÑAR
    |--------------------------------------------------------------------------
    */

    public function actualizarNuestraFormaEnsenar(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'etiqueta' => [
                'required',
                'string',
                'max:120',
            ],

            'titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'descripcion_1' => [
                'required',
                'string',
                'max:3000',
            ],

            'descripcion_2' => [
                'required',
                'string',
                'max:3000',
            ],

            'etiquetas' => [
                'required',
                'string',
                'max:1500',
            ],

            'imagen_etiqueta' => [
                'required',
                'string',
                'max:150',
            ],

            'imagen_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'principios_etiqueta' => [
                'required',
                'string',
                'max:120',
            ],

            'principios_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'principios_descripcion' => [
                'required',
                'string',
                'max:2000',
            ],

            'proceso_etiqueta' => [
                'required',
                'string',
                'max:120',
            ],

            'proceso_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'proceso_descripcion' => [
                'required',
                'string',
                'max:2000',
            ],

            'compromiso_etiqueta' => [
                'required',
                'string',
                'max:120',
            ],

            'compromiso_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'compromiso_descripcion' => [
                'required',
                'string',
                'max:2500',
            ],

            'imagen_principal' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'compromiso_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);

        $contenido = InformacionInstitucional::firstOrNew([
            'tipo' => 'forma_ensenar',
        ]);

        $datosActuales = $contenido->datos ?? [];
        $imagenCompromiso =
            $datosActuales['compromiso_imagen'] ?? null;

        $contenido->subtitulo = $datos['etiqueta'];
        $contenido->titulo = $datos['titulo'];
        $contenido->contenido = $datos['descripcion_1'];

        if ($request->hasFile('imagen_principal')) {
            $contenido->imagen = $this->guardarImagen(
                $request,
                'imagen_principal',
                $contenido->imagen
            );
        }

        if ($request->hasFile('compromiso_imagen')) {
            $imagenCompromiso = $this->guardarImagen(
                $request,
                'compromiso_imagen',
                $imagenCompromiso
            );
        }

        $contenido->datos = [
            'descripcion_2' => $datos['descripcion_2'],
            'etiquetas' => $this->textoALista(
                $datos['etiquetas']
            ),
            'imagen_etiqueta' => $datos['imagen_etiqueta'],
            'imagen_titulo' => $datos['imagen_titulo'],
            'principios_etiqueta' =>
                $datos['principios_etiqueta'],
            'principios_titulo' =>
                $datos['principios_titulo'],
            'principios_descripcion' =>
                $datos['principios_descripcion'],
            'proceso_etiqueta' =>
                $datos['proceso_etiqueta'],
            'proceso_titulo' =>
                $datos['proceso_titulo'],
            'proceso_descripcion' =>
                $datos['proceso_descripcion'],
            'compromiso_etiqueta' =>
                $datos['compromiso_etiqueta'],
            'compromiso_titulo' =>
                $datos['compromiso_titulo'],
            'compromiso_descripcion' =>
                $datos['compromiso_descripcion'],
            'compromiso_imagen' =>
                $imagenCompromiso,
        ];

        $contenido->orden = 50;
        $contenido->estado = true;
        $contenido->usuario_id = Auth::id();
        $contenido->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'El contenido de Nuestra forma de enseñar fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR PRINCIPIO PEDAGÓGICO
    |--------------------------------------------------------------------------
    */

    public function guardarPrincipioFormaEnsenar(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
        ]);

        FormaEnsenarPrincipio::create([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'icono' => 'general',
            'imagen' => null,
            'orden' => $datos['orden'],
            'estado' => true,
            'usuario_id' => Auth::id(),
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'El principio pedagógico fue registrado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR PRINCIPIO PEDAGÓGICO
    |--------------------------------------------------------------------------
    */

    public function actualizarPrincipioFormaEnsenar(
        Request $request,
        int $id
    ): RedirectResponse {
        $principio = FormaEnsenarPrincipio::findOrFail($id);

        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
        ]);

        $principio->titulo = $datos['titulo'];
        $principio->descripcion = $datos['descripcion'];
        $principio->orden = $datos['orden'];
        $principio->usuario_id = Auth::id();
        $principio->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'El principio pedagógico fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR PRINCIPIO PEDAGÓGICO
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoPrincipioFormaEnsenar(
        int $id
    ): RedirectResponse {
        $principio = FormaEnsenarPrincipio::findOrFail($id);

        $principio->estado = ! (bool) $principio->estado;
        $principio->usuario_id = Auth::id();
        $principio->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                $principio->estado
                    ? 'El principio pedagógico fue publicado correctamente.'
                    : 'El principio pedagógico fue ocultado del portal público.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR PRINCIPIO PEDAGÓGICO
    |--------------------------------------------------------------------------
    */

    public function eliminarPrincipioFormaEnsenar(
        int $id
    ): RedirectResponse {
        $principio = FormaEnsenarPrincipio::findOrFail($id);
        $principio->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'El principio pedagógico fue eliminado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR ETAPA DEL PROCESO DE APRENDIZAJE
    |--------------------------------------------------------------------------
    */

    public function guardarEtapaFormaEnsenar(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'numero' => [
                'required',
                'string',
                'max:20',
            ],

            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
        ]);

        FormaEnsenarEtapa::create([
            'numero' => $datos['numero'],
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'imagen' => null,
            'orden' => $datos['orden'],
            'estado' => true,
            'usuario_id' => Auth::id(),
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'La etapa del proceso de aprendizaje fue registrada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ETAPA DEL PROCESO DE APRENDIZAJE
    |--------------------------------------------------------------------------
    */

    public function actualizarEtapaFormaEnsenar(
        Request $request,
        int $id
    ): RedirectResponse {
        $etapa = FormaEnsenarEtapa::findOrFail($id);

        $datos = $request->validate([
            'numero' => [
                'required',
                'string',
                'max:20',
            ],

            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
        ]);

        $etapa->numero = $datos['numero'];
        $etapa->titulo = $datos['titulo'];
        $etapa->descripcion = $datos['descripcion'];
        $etapa->orden = $datos['orden'];
        $etapa->usuario_id = Auth::id();
        $etapa->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'La etapa del proceso de aprendizaje fue actualizada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR ETAPA DEL PROCESO DE APRENDIZAJE
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoEtapaFormaEnsenar(
        int $id
    ): RedirectResponse {
        $etapa = FormaEnsenarEtapa::findOrFail($id);

        $etapa->estado = ! (bool) $etapa->estado;
        $etapa->usuario_id = Auth::id();
        $etapa->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                $etapa->estado
                    ? 'La etapa fue publicada correctamente.'
                    : 'La etapa fue ocultada del portal público.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ETAPA DEL PROCESO DE APRENDIZAJE
    |--------------------------------------------------------------------------
    */

    public function eliminarEtapaFormaEnsenar(
        int $id
    ): RedirectResponse {
        $etapa = FormaEnsenarEtapa::findOrFail($id);
        $etapa->delete();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.nuestra-forma-de-ensenar'
            )
            ->with(
                'success',
                'La etapa del proceso de aprendizaje fue eliminada correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RESEÑA HISTÓRICA - PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    public function resenaHistorica(): View
    {
        $resena = InformacionInstitucional::firstOrNew([
            'tipo' => 'resena_historica',
        ]);

        $hitosHistoricos = DB::table('hitos_historicos')
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $iconosHistoricos = [
            'documento' => 'Documento',
            'estudiantes' => 'Estudiantes',
            'escuela' => 'Escuela',
            'construccion' => 'Construcción',
            'laboratorio' => 'Laboratorio',
            'oficinas' => 'Oficinas',
            'infraestructura' => 'Infraestructura',
            'modernizacion' => 'Modernización',
            'tecnologia' => 'Tecnología',
            'actualidad' => 'Actualidad',
        ];

        return view(
            'admin.contenido-institucional.institucion.resena-historica',
            compact(
                'resena',
                'hitosHistoricos',
                'iconosHistoricos'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR RESEÑA HISTÓRICA
    |--------------------------------------------------------------------------
    */

    public function actualizarResenaHistorica(
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | PORTADA
            |--------------------------------------------------------------------------
            */

            'resena_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'resena_titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'resena_descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'resena_origen_titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'resena_origen_descripcion' => [
                'required',
                'string',
                'max:3000',
            ],

            'resena_desde' => [
                'required',
                'string',
                'max:80',
            ],

            'resena_institucion' => [
                'required',
                'string',
                'max:180',
            ],

            'resena_frase' => [
                'required',
                'string',
                'max:180',
            ],

            'resena_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | DATOS DESTACADOS
            |--------------------------------------------------------------------------
            */

            'dato_anio_valor' => [
                'required',
                'string',
                'max:50',
            ],

            'dato_anio_texto' => [
                'required',
                'string',
                'max:100',
            ],

            'dato_estudiantes_valor' => [
                'required',
                'string',
                'max:50',
            ],

            'dato_estudiantes_texto' => [
                'required',
                'string',
                'max:100',
            ],

            'dato_docentes_valor' => [
                'required',
                'string',
                'max:50',
            ],

            'dato_docentes_texto' => [
                'required',
                'string',
                'max:100',
            ],

            'dato_niveles_valor' => [
                'required',
                'string',
                'max:50',
            ],

            'dato_niveles_texto' => [
                'required',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | CONVENIO INICIAL
            |--------------------------------------------------------------------------
            */

            'convenio_periodo' => [
                'required',
                'string',
                'max:80',
            ],

            'convenio_titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'convenio_descripcion' => [
                'required',
                'string',
                'max:2000',
            ],

            'convenio_entidad_1' => [
                'required',
                'string',
                'max:180',
            ],

            'convenio_entidad_1_descripcion' => [
                'required',
                'string',
                'max:2500',
            ],

            'convenio_entidad_2' => [
                'required',
                'string',
                'max:180',
            ],

            'convenio_entidad_2_descripcion' => [
                'required',
                'string',
                'max:2500',
            ],

            /*
            |--------------------------------------------------------------------------
            | LÍNEA DE TIEMPO - ENCABEZADO
            |--------------------------------------------------------------------------
            */

            'timeline_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'timeline_titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'timeline_descripcion' => [
                'required',
                'string',
                'max:1500',
            ],

            /*
            |--------------------------------------------------------------------------
            | SMART SCHOOL
            |--------------------------------------------------------------------------
            */

            'smart_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'smart_titulo' => [
                'required',
                'string',
                'max:180',
            ],

            'smart_parrafo_1' => [
                'required',
                'string',
                'max:2500',
            ],

            'smart_parrafo_2' => [
                'required',
                'string',
                'max:2500',
            ],

            'smart_beneficios' => [
                'required',
                'string',
                'max:2000',
            ],

            'smart_fecha_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'smart_fecha' => [
                'required',
                'string',
                'max:120',
            ],

            'smart_participantes' => [
                'required',
                'string',
                'max:2000',
            ],

            'smart_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            /*
            |--------------------------------------------------------------------------
            | LEGADO INSTITUCIONAL
            |--------------------------------------------------------------------------
            */

            'legado_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'legado_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'legado_parrafo_1' => [
                'required',
                'string',
                'max:2500',
            ],

            'legado_parrafo_2' => [
                'required',
                'string',
                'max:2500',
            ],

            'legado_compromiso_etiqueta' => [
                'required',
                'string',
                'max:100',
            ],

            'legado_compromiso' => [
                'required',
                'string',
                'max:200',
            ],
        ]);

        $resena = InformacionInstitucional::firstOrNew([
            'tipo' => 'resena_historica',
        ]);

        $datosActuales = $resena->datos ?? [];

        $imagenPortada = $datosActuales['portada']['imagen']
            ?? $resena->imagen
            ?? null;

        $imagenSmart = $datosActuales['smart_school']['imagen']
            ?? null;

        if ($request->hasFile('resena_imagen')) {
            $imagenPortada = $this->guardarImagen(
                $request,
                'resena_imagen',
                $imagenPortada
            );
        }

        if ($request->hasFile('smart_imagen')) {
            $imagenSmart = $this->guardarImagen(
                $request,
                'smart_imagen',
                $imagenSmart
            );
        }

        $resena->titulo = $datos['resena_titulo'];
        $resena->subtitulo = $datos['resena_etiqueta'];
        $resena->contenido = $datos['resena_descripcion'];
        $resena->imagen = $imagenPortada;

        $resena->datos = [
            'portada' => [
                'etiqueta' => $datos['resena_etiqueta'],
                'titulo' => $datos['resena_titulo'],
                'descripcion' => $datos['resena_descripcion'],
                'origen_titulo' => $datos['resena_origen_titulo'],
                'origen_descripcion' => $datos['resena_origen_descripcion'],
                'desde' => $datos['resena_desde'],
                'institucion' => $datos['resena_institucion'],
                'frase' => $datos['resena_frase'],
                'imagen' => $imagenPortada,
            ],

            'destacados' => [
                'anio' => [
                    'valor' => $datos['dato_anio_valor'],
                    'texto' => $datos['dato_anio_texto'],
                ],
                'estudiantes' => [
                    'valor' => $datos['dato_estudiantes_valor'],
                    'texto' => $datos['dato_estudiantes_texto'],
                ],
                'docentes' => [
                    'valor' => $datos['dato_docentes_valor'],
                    'texto' => $datos['dato_docentes_texto'],
                ],
                'niveles' => [
                    'valor' => $datos['dato_niveles_valor'],
                    'texto' => $datos['dato_niveles_texto'],
                ],
            ],

            'convenio' => [
                'periodo' => $datos['convenio_periodo'],
                'titulo' => $datos['convenio_titulo'],
                'descripcion' => $datos['convenio_descripcion'],
                'entidad_1' => [
                    'nombre' => $datos['convenio_entidad_1'],
                    'descripcion' => $datos['convenio_entidad_1_descripcion'],
                ],
                'entidad_2' => [
                    'nombre' => $datos['convenio_entidad_2'],
                    'descripcion' => $datos['convenio_entidad_2_descripcion'],
                ],
            ],

            'timeline' => [
                'etiqueta' => $datos['timeline_etiqueta'],
                'titulo' => $datos['timeline_titulo'],
                'descripcion' => $datos['timeline_descripcion'],
            ],

            'smart_school' => [
                'etiqueta' => $datos['smart_etiqueta'],
                'titulo' => $datos['smart_titulo'],
                'parrafo_1' => $datos['smart_parrafo_1'],
                'parrafo_2' => $datos['smart_parrafo_2'],
                'beneficios' => $this->textoALista(
                    $datos['smart_beneficios']
                ),
                'fecha_etiqueta' => $datos['smart_fecha_etiqueta'],
                'fecha' => $datos['smart_fecha'],
                'participantes' => $datos['smart_participantes'],
                'imagen' => $imagenSmart,
            ],

            'legado' => [
                'etiqueta' => $datos['legado_etiqueta'],
                'titulo' => $datos['legado_titulo'],
                'parrafo_1' => $datos['legado_parrafo_1'],
                'parrafo_2' => $datos['legado_parrafo_2'],
                'compromiso_etiqueta' =>
                    $datos['legado_compromiso_etiqueta'],
                'compromiso' => $datos['legado_compromiso'],
            ],
        ];

        $resena->orden = 20;
        $resena->estado = true;
        $resena->usuario_id = Auth::id();

        $resena->save();

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.resena'
            )
            ->with(
                'success',
                'La reseña histórica fue actualizada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR HITO HISTÓRICO
    |--------------------------------------------------------------------------
    */

    public function guardarHitoHistorico(
        Request $request
    ): RedirectResponse {
        $datos = $this->validarHitoHistorico($request);

        $imagen = null;

        if ($request->hasFile('hito_imagen')) {
            $imagen = $request
                ->file('hito_imagen')
                ->store(
                    'hitos-historicos',
                    'public'
                );
        }

        DB::table('hitos_historicos')->insert([
            'anio' => $datos['hito_anio'],
            'fecha_texto' => $datos['hito_fecha'] ?? null,
            'titulo' => $datos['hito_titulo'],
            'descripcion' => $datos['hito_descripcion'],
            'icono' => $datos['hito_icono'],
            'imagen' => $imagen,
            'orden' => $datos['hito_orden'],
            'estado' => true,
            'usuario_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.resena'
            )
            ->with(
                'success',
                'El hito histórico fue registrado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR HITO HISTÓRICO
    |--------------------------------------------------------------------------
    */

    public function actualizarHitoHistorico(
        Request $request,
        int $id
    ): RedirectResponse {
        $hito = DB::table('hitos_historicos')
            ->where('id', $id)
            ->first();

        abort_unless($hito, 404);

        $datos = $this->validarHitoHistorico($request);

        $imagen = $hito->imagen;

        if ($request->hasFile('hito_imagen')) {
            if (
                $imagen
                && Storage::disk('public')->exists($imagen)
            ) {
                Storage::disk('public')->delete($imagen);
            }

            $imagen = $request
                ->file('hito_imagen')
                ->store(
                    'hitos-historicos',
                    'public'
                );
        }

        DB::table('hitos_historicos')
            ->where('id', $id)
            ->update([
                'anio' => $datos['hito_anio'],
                'fecha_texto' => $datos['hito_fecha'] ?? null,
                'titulo' => $datos['hito_titulo'],
                'descripcion' => $datos['hito_descripcion'],
                'icono' => $datos['hito_icono'],
                'imagen' => $imagen,
                'orden' => $datos['hito_orden'],
                'usuario_id' => Auth::id(),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.resena'
            )
            ->with(
                'success',
                'El hito histórico fue actualizado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLICAR / OCULTAR HITO HISTÓRICO
    |--------------------------------------------------------------------------
    */

    public function cambiarEstadoHitoHistorico(
        int $id
    ): RedirectResponse {
        $hito = DB::table('hitos_historicos')
            ->where('id', $id)
            ->first();

        abort_unless($hito, 404);

        $nuevoEstado = ! (bool) $hito->estado;

        DB::table('hitos_historicos')
            ->where('id', $id)
            ->update([
                'estado' => $nuevoEstado,
                'usuario_id' => Auth::id(),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route(
                'admin.contenido-institucional.institucion.resena'
            )
            ->with(
                'success',
                $nuevoEstado
                    ? 'El hito histórico fue publicado correctamente.'
                    : 'El hito histórico fue ocultado del portal público.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR HITO HISTÓRICO
    |--------------------------------------------------------------------------
    */

    private function validarHitoHistorico(
        Request $request
    ): array {
        return $request->validate([
            'hito_anio' => [
                'required',
                'string',
                'max:50',
            ],

            'hito_fecha' => [
                'nullable',
                'string',
                'max:100',
            ],

            'hito_titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'hito_descripcion' => [
                'required',
                'string',
                'max:5000',
            ],

            'hito_icono' => [
                'required',
                'in:documento,estudiantes,escuela,construccion,laboratorio,oficinas,infraestructura,modernizacion,tecnologia,actualidad',
            ],

            'hito_orden' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'hito_imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CONVERTIR TEXTO EN LISTA
    |--------------------------------------------------------------------------
    */

    private function textoALista(
        string $texto
    ): array {
        return collect(
            preg_split(
                '/\r\n|\r|\n/',
                $texto
            )
        )
            ->map(
                fn ($item) => trim($item)
            )
            ->filter()
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR IMAGEN
    |--------------------------------------------------------------------------
    */

    private function guardarImagen(
        Request $request,
        string $campo,
        ?string $imagenAnterior = null
    ): string {
        if (
            $imagenAnterior
            && Storage::disk('public')
                ->exists($imagenAnterior)
        ) {
            Storage::disk('public')
                ->delete($imagenAnterior);
        }

        return $request
            ->file($campo)
            ->store(
                'contenido-institucional',
                'public'
            );
    }
}