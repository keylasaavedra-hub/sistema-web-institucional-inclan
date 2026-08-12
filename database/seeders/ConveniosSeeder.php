<?php

namespace Database\Seeders;

use App\Models\Convenio;
use App\Models\ConvenioArchivo;
use Illuminate\Database\Seeder;

class ConveniosSeeder extends Seeder
{
    public function run(): void
    {
        $convenios = [
            [
                'slug' => 'crecer',
                'nombre' => 'Centro de Psicoterapia Integral CRECER',
                'institucion' => 'Centro de Psicoterapia Integral CRECER',
                'tipo' => 'Convenio de alianza estratégica',
                'descripcion' => 'Alianza orientada al fortalecimiento de la salud mental, el acompañamiento psicológico y el bienestar de la comunidad educativa.',
                'imagen' => 'images/convenios/crecer.jpg',
                'archivo' => null,
                'estado_texto' => 'Vigente',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => null,
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
                'orden' => 1,
                'estado' => true,
                'galeria' => [
                    'images/convenios/crecer/documento-1.jpg',
                ],
            ],

            [
                'slug' => 'alianza-francesa',
                'nombre' => 'Alianza Francesa de Piura',
                'institucion' => 'Alianza Francesa de Piura',
                'tipo' => 'Convenio de cooperación interinstitucional',
                'descripcion' => 'Cooperación educativa y cultural para promover el aprendizaje del idioma francés y acercar a la comunidad educativa a la cultura francófona.',
                'imagen' => 'images/convenios/alianza-francesa.jpg',
                'archivo' => null,
                'estado_texto' => 'Vigente',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => null,
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
                'orden' => 2,
                'estado' => true,
                'galeria' => [
                    'images/convenios/alianza-francesa/documento-1.jpg',
                    'images/convenios/alianza-francesa/documento-2.jpg',
                ],
            ],

            [
                'slug' => 'utp',
                'nombre' => 'Universidad Tecnológica del Perú',
                'institucion' => 'Universidad Tecnológica del Perú',
                'tipo' => 'Carta de intención de voluntariado',
                'descripcion' => 'Alianza orientada al desarrollo de actividades de voluntariado y prácticas formativas con estudiantes universitarios de Psicología.',
                'imagen' => 'images/convenios/utp.jpg',
                'archivo' => null,
                'estado_texto' => 'Vigente',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => null,
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
                'orden' => 3,
                'estado' => true,
                'galeria' => [
                    'images/convenios/utp/documento-1.jpg',
                ],
            ],

            [
                'slug' => 'essalud',
                'nombre' => 'EsSalud',
                'institucion' => 'EsSalud',
                'tipo' => 'Alianza de intervención preventiva',
                'descripcion' => 'Alianza destinada a fortalecer la prevención de enfermedades y la promoción de hábitos saludables entre los trabajadores de la institución.',
                'imagen' => 'images/convenios/essalud.jpg',
                'archivo' => null,
                'estado_texto' => 'Vigente',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => null,
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
                'orden' => 4,
                'estado' => true,
                'galeria' => [
                    'images/convenios/essalud/documento-1.jpg',
                ],
            ],
        ];

        foreach ($convenios as $datos) {
            $galeria = $datos['galeria'];
            unset($datos['galeria']);

            $convenio = Convenio::updateOrCreate(
                [
                    'slug' => $datos['slug'],
                ],
                $datos
            );

            foreach ($galeria as $indice => $archivo) {
                ConvenioArchivo::updateOrCreate(
                    [
                        'convenio_id' => $convenio->id,
                        'archivo' => $archivo,
                    ],
                    [
                        'tipo' => 'imagen',
                        'orden' => $indice + 1,
                        'estado' => true,
                        'usuario_id' => null,
                    ]
                );
            }
        }
    }
}