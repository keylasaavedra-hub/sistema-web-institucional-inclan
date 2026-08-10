<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformacionInstitucional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
