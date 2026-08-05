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

        $informacionInstitucional = [
            [
                'tipo' => 'mision',
                'titulo' => 'Misión',
                'contenido' => 'Brindar una educación integral, inclusiva y de calidad, orientada al desarrollo académico, personal y social de nuestros estudiantes.',
                'orden' => 1,
            ],
            [
                'tipo' => 'vision',
                'titulo' => 'Visión',
                'contenido' => 'Ser una institución educativa referente en Piura, reconocida por la formación en valores, la innovación y la excelencia académica.',
                'orden' => 2,
            ],
            [
                'tipo' => 'valores',
                'titulo' => 'Valores institucionales',
                'contenido' => 'Promovemos el respeto, la responsabilidad, la disciplina, la solidaridad, la honestidad y el compromiso con nuestra comunidad.',
                'orden' => 3,
            ],
        ];

        foreach ($informacionInstitucional as $informacion) {
            DB::table('informacion_institucional')->updateOrInsert(
                ['tipo' => $informacion['tipo']],
                [
                    'titulo' => $informacion['titulo'],
                    'contenido' => $informacion['contenido'],
                    'imagen' => null,
                    'orden' => $informacion['orden'],
                    'estado' => true,
                    'usuario_id' => $usuarioId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $nivelSecundariaId = DB::table('niveles_educativos')
            ->where('nombre', 'Secundaria')
            ->value('id');

        $logros = [
            [
                'tipo' => 'logro',
                'titulo' => 'Primer puesto en Feria de Ciencia',
                'descripcion' => 'Estudiantes de secundaria obtuvieron el primer puesto en una feria escolar de ciencia y tecnología.',
                'fecha' => now()->subMonths(2)->toDateString(),
                'imagen' => 'images/logro-1.jpg',
            ],
            [
                'tipo' => 'reconocimiento',
                'titulo' => 'Reconocimiento a la excelencia académica',
                'descripcion' => 'La institución recibió un reconocimiento por su compromiso con la formación integral y la calidad educativa.',
                'fecha' => now()->subMonths(4)->toDateString(),
                'imagen' => 'images/logro-2.jpg',
            ],
            [
                'tipo' => 'reconocimiento',
                'titulo' => 'Participación destacada en actividades cívicas',
                'descripcion' => 'Nuestra delegación escolar obtuvo una participación destacada representando a la institución.',
                'fecha' => now()->subMonths(6)->toDateString(),
                'imagen' => 'images/logro-3.jpg',
            ],
        ];

        foreach ($logros as $logro) {
            DB::table('logros')->updateOrInsert(
                ['titulo' => $logro['titulo']],
                [
                    'nivel_educativo_id' => $nivelSecundariaId,
                    'usuario_id' => $usuarioId,
                    'tipo' => $logro['tipo'],
                    'descripcion' => $logro['descripcion'],
                    'fecha' => $logro['fecha'],
                    'imagen' => $logro['imagen'],
                    'archivo_respaldo' => null,
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $galeriaInfraestructura = DB::table('galerias')
            ->where('titulo', 'Infraestructura institucional')
            ->value('id');

        if (! $galeriaInfraestructura) {
            $galeriaInfraestructura = DB::table('galerias')->insertGetId([
                'usuario_id' => $usuarioId,
                'titulo' => 'Infraestructura institucional',
                'descripcion' => 'Principales ambientes y espacios de la institución educativa.',
                'tipo' => 'infraestructura',
                'anio' => now()->year,
                'imagen_portada' => 'images/infraestructura-biblioteca.jpg',
                'orden' => 1,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $espacios = [
            [
                'titulo' => 'Biblioteca',
                'descripcion' => 'Espacio destinado a la lectura, investigación y aprendizaje.',
                'ruta' => 'images/infraestructura-biblioteca.jpg',
                'orden' => 1,
            ],
            [
                'titulo' => 'Campos deportivos',
                'descripcion' => 'Espacios para actividades físicas, recreativas y deportivas.',
                'ruta' => 'images/infraestructura-campo.jpg',
                'orden' => 2,
            ],
            [
                'titulo' => 'Laboratorio de ciencia',
                'descripcion' => 'Ambiente equipado para el aprendizaje práctico de las ciencias.',
                'ruta' => 'images/infraestructura-ciencia.jpg',
                'orden' => 3,
            ],
            [
                'titulo' => 'Laboratorio de cómputo',
                'descripcion' => 'Espacio tecnológico destinado al aprendizaje digital.',
                'ruta' => 'images/infraestructura-computo.jpg',
                'orden' => 4,
            ],
        ];

        foreach ($espacios as $espacio) {
            DB::table('archivos_galeria')->updateOrInsert(
                [
                    'galeria_id' => $galeriaInfraestructura,
                    'titulo' => $espacio['titulo'],
                ],
                [
                    'tipo_archivo' => 'imagen',
                    'ruta' => $espacio['ruta'],
                    'nombre_original' => basename($espacio['ruta']),
                    'mime_type' => 'image/jpeg',
                    'tamano_bytes' => null,
                    'descripcion' => $espacio['descripcion'],
                    'orden' => $espacio['orden'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $areaDireccionId = DB::table('areas_institucionales')
            ->where('nombre', 'Dirección')
            ->value('id');

        $areaAdministracionId = DB::table('areas_institucionales')
            ->where('nombre', 'Administración')
            ->value('id');

        $areaAcademicaId = DB::table('areas_institucionales')
            ->where('nombre', 'Departamento Académico')
            ->value('id');

        $personalInstitucional = [
            [
                'nombres' => 'María Elena',
                'apellidos' => 'García Ramírez',
                'tipo_personal' => 'directivo',
                'area_id' => $areaDireccionId,
                'nivel_educativo_id' => null,
                'correo_institucional' => 'direccion@inclan.test',
                'telefono' => null,
                'foto' => 'images/personal-directora.jpg',
                'perfil_profesional' => 'Directora de la institución educativa.',
                'descripcion' => 'Responsable de la dirección y gestión institucional.',
                'orden' => 1,
            ],
            [
                'nombres' => 'Carlos Alberto',
                'apellidos' => 'Mendoza Ruiz',
                'tipo_personal' => 'docente',
                'area_id' => $areaAcademicaId,
                'nivel_educativo_id' => $nivelSecundariaId,
                'correo_institucional' => 'docente@inclan.test',
                'telefono' => null,
                'foto' => 'images/personal-docente.jpg',
                'perfil_profesional' => 'Docente del nivel secundaria.',
                'descripcion' => 'Comprometido con la formación académica y personal de los estudiantes.',
                'orden' => 2,
            ],
            [
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Torres Castillo',
                'tipo_personal' => 'administrativo',
                'area_id' => $areaAdministracionId,
                'nivel_educativo_id' => null,
                'correo_institucional' => 'administracion@inclan.test',
                'telefono' => null,
                'foto' => 'images/personal-administrativo.jpg',
                'perfil_profesional' => 'Personal administrativo.',
                'descripcion' => 'Brinda apoyo en los procesos administrativos institucionales.',
                'orden' => 3,
            ],
        ];

        foreach ($personalInstitucional as $persona) {
            DB::table('comunidad_educativa')->updateOrInsert(
                [
                    'nombres' => $persona['nombres'],
                    'apellidos' => $persona['apellidos'],
                ],
                [
                    'cargo_id' => null,
                    'area_id' => $persona['area_id'],
                    'nivel_educativo_id' => $persona['nivel_educativo_id'],
                    'usuario_registro_id' => $usuarioId,
                    'tipo_personal' => $persona['tipo_personal'],
                    'correo_institucional' => $persona['correo_institucional'],
                    'telefono' => $persona['telefono'],
                    'foto' => $persona['foto'],
                    'perfil_profesional' => $persona['perfil_profesional'],
                    'descripcion' => $persona['descripcion'],
                    'orden' => $persona['orden'],
                    'publicar' => true,
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $nivelInicialId = DB::table('niveles_educativos')
            ->where('nombre', 'Inicial')
            ->value('id');

        $nivelPrimariaId = DB::table('niveles_educativos')
            ->where('nombre', 'Primaria')
            ->value('id');

        $promociones = [
            [
                'nivel_educativo_id' => $nivelInicialId,
                'nombre' => 'Pequeños triunfadores',
                'anio' => now()->year,
                'lema' => 'Creciendo con alegría y valores',
                'descripcion' => 'Promoción del nivel inicial.',
                'imagen_portada' => 'images/promocion-inicial.jpg',
            ],
            [
                'nivel_educativo_id' => $nivelPrimariaId,
                'nombre' => 'Sembradores del futuro',
                'anio' => now()->year,
                'lema' => 'Aprendemos, crecemos y avanzamos',
                'descripcion' => 'Promoción del nivel primaria.',
                'imagen_portada' => 'images/promocion-primaria.jpg',
            ],
            [
                'nivel_educativo_id' => $nivelSecundariaId,
                'nombre' => 'Generación Inclán',
                'anio' => now()->year,
                'lema' => 'Dios, patria y cultura',
                'descripcion' => 'Promoción del nivel secundaria.',
                'imagen_portada' => 'images/promocion-secundaria.jpg',
            ],
        ];

        foreach ($promociones as $promocion) {
            DB::table('promociones')->updateOrInsert(
                [
                    'nombre' => $promocion['nombre'],
                    'anio' => $promocion['anio'],
                    'nivel_educativo_id' => $promocion['nivel_educativo_id'],
                ],
                [
                    'usuario_id' => $usuarioId,
                    'lema' => $promocion['lema'],
                    'descripcion' => $promocion['descripcion'],
                    'imagen_portada' => $promocion['imagen_portada'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $categoriaReglamentosId = DB::table('categorias_documento')
            ->where('nombre', 'Reglamentos')
            ->value('id');

        $categoriaFormatosId = DB::table('categorias_documento')
            ->where('nombre', 'Formatos')
            ->value('id');

        $categoriaPlanesId = DB::table('categorias_documento')
            ->where('nombre', 'Planes')
            ->value('id');

        $documentos = [
            [
                'categoria_documento_id' => $categoriaReglamentosId,
                'titulo' => 'Reglamento interno institucional',
                'descripcion' => 'Documento que contiene las normas de convivencia y organización institucional.',
                'archivo' => 'documentos/reglamento-interno.pdf',
                'nombre_original' => 'reglamento-interno.pdf',
                'tipo_archivo' => 'application/pdf',
                'version' => '1.0',
            ],
            [
                'categoria_documento_id' => $categoriaFormatosId,
                'titulo' => 'Formato de solicitud general',
                'descripcion' => 'Formato disponible para la presentación de solicitudes institucionales.',
                'archivo' => 'documentos/formato-solicitud-general.pdf',
                'nombre_original' => 'formato-solicitud-general.pdf',
                'tipo_archivo' => 'application/pdf',
                'version' => '1.0',
            ],
            [
                'categoria_documento_id' => $categoriaPlanesId,
                'titulo' => 'Plan anual de trabajo',
                'descripcion' => 'Documento de planificación institucional correspondiente al año escolar.',
                'archivo' => 'documentos/plan-anual-trabajo.pdf',
                'nombre_original' => 'plan-anual-trabajo.pdf',
                'tipo_archivo' => 'application/pdf',
                'version' => '1.0',
            ],
        ];

        foreach ($documentos as $documento) {
            DB::table('documentos')->updateOrInsert(
                [
                    'titulo' => $documento['titulo'],
                ],
                [
                    'categoria_documento_id' => $documento['categoria_documento_id'],
                    'area_id' => null,
                    'usuario_id' => $usuarioId,
                    'descripcion' => $documento['descripcion'],
                    'archivo' => $documento['archivo'],
                    'nombre_original' => $documento['nombre_original'],
                    'tipo_archivo' => $documento['tipo_archivo'],
                    'tamano_bytes' => null,
                    'version' => $documento['version'],
                    'fecha_publicacion' => now(),
                    'es_publico' => true,
                    'estado' => 'activo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
