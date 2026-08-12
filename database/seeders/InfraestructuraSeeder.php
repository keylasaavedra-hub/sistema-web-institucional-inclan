<?php

namespace Database\Seeders;

use App\Models\InfraestructuraAmbiente;
use App\Models\InfraestructuraImagen;
use Illuminate\Database\Seeder;

class InfraestructuraSeeder extends Seeder
{
    public function run(): void
    {
        $ambientes = [
            [
                'slug' => 'aulas',
                'titulo' => 'Aulas',
                'descripcion' => 'Espacios organizados y acondicionados para el desarrollo de las actividades académicas de nuestros estudiantes.',
                'imagen' => 'images/infraestructura/aulas.png',
                'icono' => 'aula',
                'orden' => 1,
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
                'orden' => 2,
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
                'orden' => 3,
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
                'orden' => 4,
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
                'orden' => 5,
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
                'orden' => 6,
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
                'orden' => 7,
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
                'orden' => 8,
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
                'orden' => 9,
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
                'orden' => 10,
                'galeria' => [
                    'images/infraestructura/secundaria/secundaria-1.png',
                    'images/infraestructura/secundaria/secundaria-2.png',
                    'images/infraestructura/secundaria/secundaria-3.png',
                    'images/infraestructura/secundaria/secundaria-4.png',
                ],
            ],
        ];

        foreach ($ambientes as $datos) {
            $galeria = $datos['galeria'];
            unset($datos['galeria']);

            $ambiente = InfraestructuraAmbiente::updateOrCreate(
                [
                    'slug' => $datos['slug'],
                ],
                array_merge($datos, [
                    'estado' => true,
                ])
            );

            foreach ($galeria as $indice => $imagen) {
                InfraestructuraImagen::updateOrCreate(
                    [
                        'infraestructura_ambiente_id' => $ambiente->id,
                        'imagen' => $imagen,
                    ],
                    [
                        'orden' => $indice + 1,
                        'estado' => true,
                    ]
                );
            }
        }
    }
}