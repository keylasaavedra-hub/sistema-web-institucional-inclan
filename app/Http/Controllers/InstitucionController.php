<?php

namespace App\Http\Controllers;

use App\Models\InformacionInstitucional;
use App\Models\InfraestructuraAmbiente;
use App\Models\Convenio;
use App\Models\ComunidadEducativaGrupo;
use App\Models\FormaEnsenarPrincipio;
use App\Models\FormaEnsenarEtapa;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstitucionController extends Controller
{
    public function resenaHistorica(): View
    {
        $contenido = InformacionInstitucional::query()
            ->where('tipo', 'resena_historica')
            ->where('estado', true)
            ->first();

        $hitos = DB::table('hitos_historicos')
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'institucion.resena-historica',
            compact(
                'contenido',
                'hitos'
            )
        );
    }

    public function misionVisionValores(): View
    {
        $informacion = InformacionInstitucional::query()
            ->whereIn('tipo', [
                'identidad_institucional',
                'mision',
                'vision',
                'valores',
                'enfoque_inicio',
            ])
            ->where('estado', true)
            ->get()
            ->keyBy('tipo');

        return view(
            'institucion.mision-vision-valores',
            compact('informacion')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INFRAESTRUCTURA
    |--------------------------------------------------------------------------
    */

    public function infraestructura(): View
    {
        $contenido = InformacionInstitucional::query()
            ->where('tipo', 'infraestructura')
            ->where('estado', true)
            ->first();

        $ambientes = InfraestructuraAmbiente::query()
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get()
            ->map(function ($ambiente) {
                return [
                    'id' => $ambiente->id,
                    'slug' => $ambiente->slug,
                    'titulo' => $ambiente->titulo,
                    'descripcion' => $ambiente->descripcion,
                    'imagen' => $ambiente->imagen,
                    'icono' => $ambiente->icono,
                    'orden' => $ambiente->orden,
                ];
            });

        return view(
            'institucion.infraestructura',
            compact(
                'contenido',
                'ambientes'
            )
        );
    }

    public function mostrarInfraestructura(string $ambiente): View
    {
        $registro = InfraestructuraAmbiente::query()
            ->with([
                'imagenes' => function ($query) {
                    $query
                        ->where('estado', true)
                        ->orderBy('orden')
                        ->orderBy('id');
                },
            ])
            ->where('slug', $ambiente)
            ->where('estado', true)
            ->firstOrFail();

        $detalle = [
            'id' => $registro->id,
            'slug' => $registro->slug,
            'titulo' => $registro->titulo,
            'descripcion' => $registro->descripcion,
            'imagen' => $registro->imagen,
            'icono' => $registro->icono,
            'galeria' => $registro->imagenes
                ->pluck('imagen')
                ->values()
                ->all(),
        ];

        return view(
            'institucion.infraestructura-detalle',
            compact('detalle')
        );
    }

    private function ambientesInfraestructura(): array
    {
        return [
            [
                'slug' => 'aulas',
                'titulo' => 'Aulas',
                'descripcion' => 'Espacios organizados y acondicionados para el desarrollo de las actividades académicas de nuestros estudiantes.',
                'imagen' => 'images/infraestructura/aulas.png',
                'icono' => 'aula',
                'galeria' => [
                    'images/infraestructura/aulas/aula-1.png',
                    'images/infraestructura/aulas/aula-2.png',
                    'images/infraestructura/aulas/aula-3.png',
                    'images/infraestructura/aulas/aula-4.png',
                ],
            ],
            [
                'slug' => 'computacion',
                'titulo' => 'Aulas de computación',
                'descripcion' => 'Ambientes equipados con recursos tecnológicos para fortalecer el aprendizaje digital y el uso responsable de las tecnologías.',
                'imagen' => 'images/infraestructura/computacion.png',
                'icono' => 'computacion',
                'galeria' => [
                    'images/infraestructura/computacion/computacion-1.png',
                    'images/infraestructura/computacion/computacion-2.png',
                    'images/infraestructura/computacion/computacion-3.png',
                    'images/infraestructura/computacion/computacion-4.png',
                ],
            ],
            [
                'slug' => 'direccion',
                'titulo' => 'Dirección',
                'descripcion' => 'Espacio destinado a la gestión institucional, la atención a la comunidad educativa y la coordinación de las actividades escolares.',
                'imagen' => 'images/infraestructura/direccion.png',
                'icono' => 'direccion',
                'galeria' => [
                    'images/infraestructura/direccion/direccion-1.png',
                    'images/infraestructura/direccion/direccion-2.png',
                    'images/infraestructura/direccion/direccion-3.png',
                    'images/infraestructura/direccion/direccion-4.png',
                ],
            ],
            [
                'slug' => 'patios',
                'titulo' => 'Patios',
                'descripcion' => 'Áreas amplias destinadas a actividades cívicas, recreativas, formativas y de convivencia institucional.',
                'imagen' => 'images/infraestructura/patios.png',
                'icono' => 'patio',
                'galeria' => [
                    'images/infraestructura/patios/patio-1.png',
                    'images/infraestructura/patios/patio-2.png',
                    'images/infraestructura/patios/patio-3.png',
                    'images/infraestructura/patios/patio-4.png',
                ],
            ],
            [
                'slug' => 'areas-verdes',
                'titulo' => 'Áreas verdes',
                'descripcion' => 'Espacios naturales que contribuyen al bienestar, la convivencia y el cuidado del entorno institucional.',
                'imagen' => 'images/infraestructura/areas-verdes.png',
                'icono' => 'naturaleza',
                'galeria' => [
                    'images/infraestructura/areas-verdes/area-verde-1.png',
                    'images/infraestructura/areas-verdes/area-verde-2.png',
                    'images/infraestructura/areas-verdes/area-verde-3.png',
                    'images/infraestructura/areas-verdes/area-verde-4.png',
                ],
            ],
            [
                'slug' => 'sala-reuniones',
                'titulo' => 'Sala de reuniones',
                'descripcion' => 'Ambiente destinado a reuniones de coordinación, planificación y trabajo colaborativo del personal institucional.',
                'imagen' => 'images/infraestructura/sala-reuniones.png',
                'icono' => 'reunion',
                'galeria' => [
                    'images/infraestructura/sala-reuniones/reunion-1.png',
                    'images/infraestructura/sala-reuniones/reunion-2.png',
                    'images/infraestructura/sala-reuniones/reunion-3.png',
                    'images/infraestructura/sala-reuniones/reunion-4.png',
                ],
            ],
            [
                'slug' => 'topico',
                'titulo' => 'Tópico',
                'descripcion' => 'Ambiente destinado a brindar atención básica, orientación y apoyo para el bienestar de los estudiantes.',
                'imagen' => 'images/infraestructura/topico.png',
                'icono' => 'salud',
                'galeria' => [
                    'images/infraestructura/topico/topico-1.png',
                    'images/infraestructura/topico/topico-2.png',
                    'images/infraestructura/topico/topico-3.png',
                    'images/infraestructura/topico/topico-4.png',
                ],
            ],
            [
                'slug' => 'nivel-inicial',
                'titulo' => 'Nivel inicial',
                'descripcion' => 'Ambientes seguros, acogedores y adecuados para acompañar los primeros aprendizajes de nuestros estudiantes.',
                'imagen' => 'images/infraestructura/inicial.png',
                'icono' => 'inicial',
                'galeria' => [
                    'images/infraestructura/inicial/inicial-1.png',
                    'images/infraestructura/inicial/inicial-2.png',
                    'images/infraestructura/inicial/inicial-3.png',
                    'images/infraestructura/inicial/inicial-4.png',
                ],
            ],
            [
                'slug' => 'nivel-primario',
                'titulo' => 'Nivel primario',
                'descripcion' => 'Espacios educativos orientados al desarrollo de competencias, valores y aprendizajes fundamentales.',
                'imagen' => 'images/infraestructura/primaria.png',
                'icono' => 'primaria',
                'galeria' => [
                    'images/infraestructura/primaria/primaria-1.png',
                    'images/infraestructura/primaria/primaria-2.png',
                    'images/infraestructura/primaria/primaria-3.png',
                    'images/infraestructura/primaria/primaria-4.png',
                ],
            ],
            [
                'slug' => 'nivel-secundario',
                'titulo' => 'Nivel secundario',
                'descripcion' => 'Ambientes destinados a fortalecer la formación académica, personal y ciudadana de los estudiantes.',
                'imagen' => 'images/infraestructura/secundaria.png',
                'icono' => 'secundaria',
                'galeria' => [
                    'images/infraestructura/secundaria/secundaria-1.png',
                    'images/infraestructura/secundaria/secundaria-2.png',
                    'images/infraestructura/secundaria/secundaria-3.png',
                    'images/infraestructura/secundaria/secundaria-4.png',
                ],
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CONVENIOS Y ALIANZAS INSTITUCIONALES
    |--------------------------------------------------------------------------
    */

    public function convenios(): View
    {
        $convenios = Convenio::query()
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'institucion.convenios',
            compact('convenios')
        );
    }

    public function mostrarConvenio(string $convenio): View
    {
        $registro = Convenio::query()
            ->with([
                'archivos' => function ($query) {
                    $query
                        ->where('estado', true)
                        ->orderBy('orden')
                        ->orderBy('id');
                },
            ])
            ->where('slug', $convenio)
            ->where('estado', true)
            ->firstOrFail();

        $detalle = [
            'id' => $registro->id,
            'slug' => $registro->slug,
            'nombre' => $registro->nombre,
            'titulo' => $registro->nombre,
            'institucion' => $registro->institucion
                ?: $registro->nombre,
            'nombre_institucion' => $registro->institucion
                ?: $registro->nombre,
            'tipo' => $registro->tipo,
            'descripcion' => $registro->descripcion,
            'estado' => $registro->estado_texto
                ?: 'Vigente',
            'fecha' => $registro->fecha_inicio
                ? $registro->fecha_inicio->format('Y')
                : null,
            'fecha_inicio' => $registro->fecha_inicio
                ? $registro->fecha_inicio->format('Y-m-d')
                : null,
            'fecha_fin' => $registro->fecha_fin
                ? $registro->fecha_fin->format('Y-m-d')
                : null,
            'imagen' => $registro->imagen,
            'logo' => $registro->imagen,
            'objetivos' => $registro->objetivos ?? [],
            'beneficios' => $registro->beneficios ?? [],
            'galeria' => $registro->archivos
                ->pluck('archivo')
                ->values()
                ->all(),
        ];

        return view(
            'institucion.convenio-detalle',
            compact('detalle')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function comunidadEducativa(): View
    {
        $contenido = InformacionInstitucional::query()
            ->where('tipo', 'comunidad_educativa')
            ->where('estado', true)
            ->first();

        $grupos = ComunidadEducativaGrupo::query()
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'institucion.comunidad-educativa',
            compact(
                'contenido',
                'grupos'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NUESTRA FORMA DE ENSEÑAR
    |--------------------------------------------------------------------------
    */

    public function nuestraFormaDeEnsenar(): View
    {
        $contenido = InformacionInstitucional::query()
            ->where('tipo', 'forma_ensenar')
            ->where('estado', true)
            ->first();

        $principios = FormaEnsenarPrincipio::query()
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $etapas = FormaEnsenarEtapa::query()
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        return view(
            'institucion.nuestra-forma-de-ensenar',
            compact(
                'contenido',
                'principios',
                'etapas'
            )
        );
    }


    
}