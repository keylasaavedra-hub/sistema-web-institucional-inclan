<?php

namespace Database\Seeders;

use App\Models\FormaEnsenarEtapa;
use App\Models\FormaEnsenarPrincipio;
use Illuminate\Database\Seeder;

class FormaEnsenarSeeder extends Seeder
{
    public function run(): void
    {
        $principios = [
            [
                'titulo' => 'Aprendizaje significativo',
                'descripcion' => 'Relacionamos los nuevos conocimientos con experiencias cercanas a la realidad del estudiante.',
                'icono' => 'libro',
                'imagen' => null,
                'orden' => 1,
                'estado' => true,
            ],
            [
                'titulo' => 'Formación en valores',
                'descripcion' => 'Promovemos el respeto, la responsabilidad, la disciplina, la solidaridad y el compromiso.',
                'icono' => 'corazon',
                'imagen' => null,
                'orden' => 2,
                'estado' => true,
            ],
            [
                'titulo' => 'Participación activa',
                'descripcion' => 'El estudiante investiga, pregunta, propone, crea y participa en la construcción de su aprendizaje.',
                'icono' => 'participacion',
                'imagen' => null,
                'orden' => 3,
                'estado' => true,
            ],
            [
                'titulo' => 'Acompañamiento docente',
                'descripcion' => 'El docente orienta, motiva y brinda retroalimentación durante todo el proceso educativo.',
                'icono' => 'acompanamiento',
                'imagen' => null,
                'orden' => 4,
                'estado' => true,
            ],
            [
                'titulo' => 'Uso responsable de la tecnología',
                'descripcion' => 'Integramos recursos digitales como apoyo para investigar, comunicar, crear y aprender.',
                'icono' => 'tecnologia',
                'imagen' => null,
                'orden' => 5,
                'estado' => true,
            ],
            [
                'titulo' => 'Atención a la diversidad',
                'descripcion' => 'Reconocemos los distintos ritmos, capacidades y necesidades de aprendizaje de los estudiantes.',
                'icono' => 'diversidad',
                'imagen' => null,
                'orden' => 6,
                'estado' => true,
            ],
        ];

        foreach ($principios as $principio) {
            FormaEnsenarPrincipio::updateOrCreate(
                [
                    'titulo' => $principio['titulo'],
                ],
                [
                    ...$principio,
                    'usuario_id' => null,
                ]
            );
        }

        $etapas = [
            [
                'numero' => '01',
                'titulo' => 'Exploramos',
                'descripcion' => 'Partimos de conocimientos previos, preguntas, experiencias y situaciones cercanas.',
                'imagen' => null,
                'orden' => 1,
                'estado' => true,
            ],
            [
                'numero' => '02',
                'titulo' => 'Comprendemos',
                'descripcion' => 'Analizamos información, desarrollamos conceptos y fortalecemos capacidades.',
                'imagen' => null,
                'orden' => 2,
                'estado' => true,
            ],
            [
                'numero' => '03',
                'titulo' => 'Aplicamos',
                'descripcion' => 'Resolvemos problemas y utilizamos lo aprendido en situaciones prácticas.',
                'imagen' => null,
                'orden' => 3,
                'estado' => true,
            ],
            [
                'numero' => '04',
                'titulo' => 'Reflexionamos',
                'descripcion' => 'Evaluamos nuestros avances, reconocemos dificultades y planteamos mejoras.',
                'imagen' => null,
                'orden' => 4,
                'estado' => true,
            ],
        ];

        foreach ($etapas as $etapa) {
            FormaEnsenarEtapa::updateOrCreate(
                [
                    'numero' => $etapa['numero'],
                ],
                [
                    ...$etapa,
                    'usuario_id' => null,
                ]
            );
        }
    }
}