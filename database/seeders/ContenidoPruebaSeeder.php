<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContenidoPruebaSeeder extends Seeder
{
    public function run(): void
    {
        $categoriaNoticia = DB::table('categorias_publicacion')
            ->where('nombre', 'Noticias')
            ->value('id');

        $categoriaComunicado = DB::table('categorias_publicacion')
            ->where('nombre', 'Comunicados')
            ->value('id');

        $categoriaEvento = DB::table('categorias_publicacion')
            ->where('nombre', 'Eventos')
            ->value('id');

        $usuarioId = DB::table('users')
            ->where('dni', '12345678')
            ->value('id');

        $publicaciones = [
            [
                'categoria_publicacion_id' => $categoriaNoticia,
                'usuario_id' => $usuarioId,
                'titulo' => 'Inicio de actividades académicas',
                'contenido' => 'La institución educativa da la bienvenida a estudiantes, docentes y padres de familia para el inicio de las actividades académicas.',
                'imagen_portada' => 'images/noticia-1.jpg',
                'destacada' => true,
            ],
            [
                'categoria_publicacion_id' => $categoriaComunicado,
                'usuario_id' => $usuarioId,
                'titulo' => 'Comunicado dirigido a padres de familia',
                'contenido' => 'Se comunica a los padres de familia información relacionada con reuniones, horarios y actividades institucionales.',
                'imagen_portada' => 'images/noticia-2.jpg',
                'destacada' => false,
            ],
            [
                'categoria_publicacion_id' => $categoriaEvento,
                'usuario_id' => $usuarioId,
                'titulo' => 'Feria de Ciencia y Tecnología',
                'contenido' => 'Nuestros estudiantes participarán en la Feria de Ciencia y Tecnología presentando proyectos desarrollados durante el año escolar.',
                'imagen_portada' => 'images/noticia-3.jpg',
                'destacada' => false,
            ],
        ];

        foreach ($publicaciones as $publicacion) {
            DB::table('publicaciones')->updateOrInsert(
                [
                    'slug' => Str::slug($publicacion['titulo']),
                ],
                [
                    'categoria_publicacion_id' => $publicacion['categoria_publicacion_id'],
                    'usuario_id' => $publicacion['usuario_id'],
                    'titulo' => $publicacion['titulo'],
                    'contenido' => $publicacion['contenido'],
                    'imagen_portada' => $publicacion['imagen_portada'],
                    'archivo_adjunto' => null,
                    'fecha_publicacion' => now(),
                    'fecha_vencimiento' => null,
                    'destacada' => $publicacion['destacada'],
                    'estado' => 'publicado',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $areaId = DB::table('areas_institucionales')
            ->where('nombre', 'Administración')
            ->value('id');

        DB::table('convocatorias')->updateOrInsert(
            [
                'codigo' => 'CONV-PRUEBA-001',
            ],
            [
                'area_id' => $areaId,
                'cargo_id' => null,
                'usuario_id' => $usuarioId,
                'tipo' => 'practicas',
                'titulo' => 'Convocatoria para practicantes',
                'descripcion' => 'Proceso de convocatoria dirigido a estudiantes interesados en realizar prácticas en la institución.',
                'perfil' => 'Estudiante responsable, organizado y con disposición para aprender.',
                'requisitos' => 'Currículum vitae y carta de presentación.',
                'cronograma' => 'Recepción de documentos durante el periodo indicado.',
                'vacantes' => 2,
                'fecha_inicio' => now()->subDay(),
                'fecha_cierre' => now()->addDays(15),
                'fecha_publicacion' => now(),
                'estado' => 'publicada',
                'destacada' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}