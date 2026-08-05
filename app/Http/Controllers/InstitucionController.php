<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstitucionController extends Controller
{
    public function resenaHistorica(): View
    {
        $contenido = DB::table('informacion_institucional')
            ->where('tipo', 'resena_historica')
            ->where('estado', true)
            ->first();

        return view(
            'institucion.resena-historica',
            compact('contenido')
        );
    }

    public function misionVisionValores(): View
    {
        $informacion = DB::table('informacion_institucional')
            ->whereIn('tipo', [
                'mision',
                'vision',
                'valores',
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
        $ambientes = collect(
            $this->ambientesInfraestructura()
        );

        return view(
            'institucion.infraestructura',
            compact('ambientes')
        );
    }

    public function mostrarInfraestructura(string $ambiente): View
    {
        $ambientes = collect(
            $this->ambientesInfraestructura()
        );

        $detalle = $ambientes->firstWhere(
            'slug',
            $ambiente
        );

        abort_if(!$detalle, 404);

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
        $convenios = collect(
            $this->conveniosInstitucionales()
        )->map(function (array $convenio) {
            return (object) [
                'id' => $convenio['slug'],
                'slug' => $convenio['slug'],

                'nombre' => $convenio['nombre'],
                'titulo' => $convenio['nombre'],
                'institucion' => $convenio['nombre'],
                'nombre_institucion' => $convenio['nombre'],

                'tipo' => $convenio['tipo'],
                'descripcion' => $convenio['descripcion'],
                'estado' => $convenio['estado'],

                'fecha' => $convenio['fecha'],
                'fecha_inicio' => $convenio['fecha'] . '-01-01',
                'fecha_fin' => null,

                'imagen' => $convenio['imagen'],
                'logo' => $convenio['imagen'],

                'objetivos' => $convenio['objetivos'],
                'beneficios' => $convenio['beneficios'],
                'galeria' => $convenio['galeria'],
            ];
        });

        return view(
            'institucion.convenios',
            compact('convenios')
        );
    }

    public function mostrarConvenio(string $convenio): View
    {
        $convenios = collect(
            $this->conveniosInstitucionales()
        );

        $detalle = $convenios->firstWhere(
            'slug',
            $convenio
        );

        abort_if(!$detalle, 404);

        return view(
            'institucion.convenio-detalle',
            compact('detalle')
        );
    }

    private function conveniosInstitucionales(): array
    {
        return [
            [
                'slug' => 'crecer',
                'nombre' => 'Centro de Psicoterapia Integral CRECER',
                'tipo' => 'Convenio de alianza estratégica',
                'descripcion' => 'Alianza orientada al fortalecimiento de la salud mental, el acompañamiento psicológico y el bienestar de la comunidad educativa.',
                'imagen' => 'images/convenios/crecer.jpg',
                'estado' => 'Vigente',
                'fecha' => '2026',
                'objetivos' => [
                    'Promover acciones de prevención y cuidado de la salud mental.',
                    'Desarrollar talleres dirigidos a estudiantes, docentes y familias.',
                    'Brindar orientación y acompañamiento psicológico especializado.',
                    'Fortalecer las capacidades socioemocionales de la comunidad educativa.',
                ],
                'beneficios' => [
                    'Atención y orientación psicológica.',
                    'Capacitaciones en salud mental.',
                    'Talleres preventivos y formativos.',
                    'Acompañamiento a estudiantes y familias.',
                ],
                'galeria' => [
                    'images/convenios/crecer/documento-1.jpg',
                ],
            ],
            [
                'slug' => 'alianza-francesa',
                'nombre' => 'Alianza Francesa de Piura',
                'tipo' => 'Convenio de cooperación interinstitucional',
                'descripcion' => 'Cooperación educativa y cultural para promover el aprendizaje del idioma francés y acercar a la comunidad educativa a la cultura francófona.',
                'imagen' => 'images/convenios/alianza-francesa.jpg',
                'estado' => 'Vigente',
                'fecha' => '2026',
                'objetivos' => [
                    'Promover la enseñanza y difusión del idioma francés.',
                    'Impulsar actividades académicas y culturales conjuntas.',
                    'Generar oportunidades educativas para estudiantes y docentes.',
                    'Fortalecer la cooperación entre ambas instituciones.',
                ],
                'beneficios' => [
                    'Acceso a formación en idioma francés.',
                    'Actividades culturales y académicas.',
                    'Beneficios para estudiantes, docentes y familiares.',
                    'Participación en programas de cooperación educativa.',
                ],
                'galeria' => [
                    'images/convenios/alianza-francesa/documento-1.jpg',
                    'images/convenios/alianza-francesa/documento-2.jpg',
                ],
            ],
            [
                'slug' => 'utp',
                'nombre' => 'Universidad Tecnológica del Perú',
                'tipo' => 'Carta de intención de voluntariado',
                'descripcion' => 'Alianza orientada al desarrollo de actividades de voluntariado y prácticas formativas con estudiantes universitarios de Psicología.',
                'imagen' => 'images/convenios/utp.jpg',
                'estado' => 'Vigente',
                'fecha' => '2026',
                'objetivos' => [
                    'Facilitar espacios de voluntariado para estudiantes universitarios.',
                    'Apoyar actividades de acompañamiento psicológico y educativo.',
                    'Fortalecer la formación profesional mediante experiencias reales.',
                    'Promover la colaboración entre la universidad y la institución educativa.',
                ],
                'beneficios' => [
                    'Participación de estudiantes de Psicología.',
                    'Actividades de voluntariado.',
                    'Acompañamiento profesional supervisado.',
                    'Coordinación académica interinstitucional.',
                ],
                'galeria' => [
                    'images/convenios/utp/documento-1.jpg',
                ],
            ],
            [
                'slug' => 'essalud',
                'nombre' => 'EsSalud',
                'tipo' => 'Alianza de intervención preventiva',
                'descripcion' => 'Alianza destinada a fortalecer la prevención de enfermedades y la promoción de hábitos saludables entre los trabajadores de la institución.',
                'imagen' => 'images/convenios/essalud.jpg',
                'estado' => 'Vigente',
                'fecha' => '2026',
                'objetivos' => [
                    'Promover la prevención y el cuidado integral de la salud.',
                    'Realizar evaluaciones preventivas a los trabajadores.',
                    'Fomentar hábitos saludables en el entorno laboral.',
                    'Facilitar orientación médica y seguimiento oportuno.',
                ],
                'beneficios' => [
                    'Evaluaciones integrales de salud.',
                    'Prevención de enfermedades.',
                    'Promoción de hábitos saludables.',
                    'Atención presencial y mediante telesalud.',
                ],
                'galeria' => [
                    'images/convenios/essalud/documento-1.jpg',
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | COMUNIDAD EDUCATIVA
    |--------------------------------------------------------------------------
    */

    public function comunidadEducativa(): View
    {
        $grupos = collect([
            [
                'titulo' => 'Equipo directivo',
                'descripcion' => 'Responsable de conducir, organizar y fortalecer la gestión institucional y educativa.',
                'imagen' => 'images/comunidad-educativa/directivos.jpg',
                'icono' => 'directivos',
            ],
            [
                'titulo' => 'Docentes de nivel inicial',
                'descripcion' => 'Acompañan los primeros aprendizajes y el desarrollo integral de nuestros estudiantes.',
                'imagen' => 'images/comunidad-educativa/docentes-inicial.jpg',
                'icono' => 'inicial',
            ],
            [
                'titulo' => 'Docentes de nivel primario',
                'descripcion' => 'Promueven aprendizajes fundamentales, valores y competencias para la vida.',
                'imagen' => 'images/comunidad-educativa/docentes-primaria.jpg',
                'icono' => 'primaria',
            ],
            [
                'titulo' => 'Docentes de nivel secundario',
                'descripcion' => 'Fortalecen la formación académica, ciudadana y personal de los estudiantes.',
                'imagen' => 'images/comunidad-educativa/docentes-secundaria.jpg',
                'icono' => 'secundaria',
            ],
            [
                'titulo' => 'Personal administrativo',
                'descripcion' => 'Apoya la gestión documental, organizativa y operativa de la institución.',
                'imagen' => 'images/comunidad-educativa/administrativos.jpg',
                'icono' => 'administrativos',
            ],
            [
                'titulo' => 'Área de Psicología',
                'descripcion' => 'Brinda orientación, acompañamiento emocional y apoyo a la comunidad educativa.',
                'imagen' => 'images/comunidad-educativa/psicologia.jpg',
                'icono' => 'psicologia',
            ],
            [
                'titulo' => 'TOESE',
                'descripcion' => 'Fortalece la tutoría, la convivencia escolar y el bienestar de los estudiantes.',
                'imagen' => 'images/comunidad-educativa/toese.jpg',
                'icono' => 'toese',
            ],
            [
                'titulo' => 'Coordinadores',
                'descripcion' => 'Articulan, supervisan y acompañan el desarrollo de los procesos educativos.',
                'imagen' => 'images/comunidad-educativa/coordinadores.jpg',
                'icono' => 'coordinadores',
            ],
            [
                'titulo' => 'Personal técnico',
                'descripcion' => 'Brinda soporte especializado para el funcionamiento de los servicios institucionales.',
                'imagen' => 'images/comunidad-educativa/tecnicos.jpg',
                'icono' => 'tecnicos',
            ],
            [
                'titulo' => 'Suboficial',
                'descripcion' => 'Contribuye al orden, la disciplina y el cumplimiento de las disposiciones institucionales.',
                'imagen' => 'images/comunidad-educativa/suboficial.jpg',
                'icono' => 'suboficial',
            ],
        ]);

        return view(
            'institucion.comunidad-educativa',
            compact('grupos')
        );
    }
    /*
    |--------------------------------------------------------------------------
    | NUESTRA FORMA DE ENSEÑAR
    |--------------------------------------------------------------------------
    */

    public function nuestraFormaDeEnsenar(): View
    {
        return view(
            'institucion.nuestra-forma-de-ensenar'
        );
    }


    
}