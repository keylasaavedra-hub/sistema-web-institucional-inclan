<?php

namespace Database\Seeders;

use App\Models\ComunidadEducativaGrupo;
use Illuminate\Database\Seeder;

class ComunidadEducativaSeeder extends Seeder
{
    public function run(): void
    {
        $grupos = [
            [
                'slug' => 'equipo-directivo',
                'titulo' => 'Equipo directivo',
                'descripcion' => 'Responsable de conducir, organizar y fortalecer la gestión institucional y educativa.',
                'imagen' => 'images/comunidad-educativa/directivos.jpg',
                'icono' => 'directivos',
                'orden' => 1,
                'estado' => true,
            ],
            [
                'slug' => 'docentes-inicial',
                'titulo' => 'Docentes de nivel inicial',
                'descripcion' => 'Acompañan los primeros aprendizajes y el desarrollo integral de nuestros estudiantes.',
                'imagen' => 'images/comunidad-educativa/docentes-inicial.jpg',
                'icono' => 'inicial',
                'orden' => 2,
                'estado' => true,
            ],
            [
                'slug' => 'docentes-primaria',
                'titulo' => 'Docentes de nivel primario',
                'descripcion' => 'Promueven aprendizajes fundamentales, valores y competencias para la vida.',
                'imagen' => 'images/comunidad-educativa/docentes-primaria.jpg',
                'icono' => 'primaria',
                'orden' => 3,
                'estado' => true,
            ],
            [
                'slug' => 'docentes-secundaria',
                'titulo' => 'Docentes de nivel secundario',
                'descripcion' => 'Fortalecen la formación académica, ciudadana y personal de los estudiantes.',
                'imagen' => 'images/comunidad-educativa/docentes-secundaria.jpg',
                'icono' => 'secundaria',
                'orden' => 4,
                'estado' => true,
            ],
            [
                'slug' => 'personal-administrativo',
                'titulo' => 'Personal administrativo',
                'descripcion' => 'Apoya la gestión documental, organizativa y operativa de la institución.',
                'imagen' => 'images/comunidad-educativa/administrativos.jpg',
                'icono' => 'administrativos',
                'orden' => 5,
                'estado' => true,
            ],
            [
                'slug' => 'area-psicologia',
                'titulo' => 'Área de Psicología',
                'descripcion' => 'Brinda orientación, acompañamiento emocional y apoyo a la comunidad educativa.',
                'imagen' => 'images/comunidad-educativa/psicologia.jpg',
                'icono' => 'psicologia',
                'orden' => 6,
                'estado' => true,
            ],
            [
                'slug' => 'toese',
                'titulo' => 'TOESE',
                'descripcion' => 'Fortalece la tutoría, la convivencia escolar y el bienestar de los estudiantes.',
                'imagen' => 'images/comunidad-educativa/toese.jpg',
                'icono' => 'toese',
                'orden' => 7,
                'estado' => true,
            ],
            [
                'slug' => 'coordinadores',
                'titulo' => 'Coordinadores',
                'descripcion' => 'Articulan, supervisan y acompañan el desarrollo de los procesos educativos.',
                'imagen' => 'images/comunidad-educativa/coordinadores.jpg',
                'icono' => 'coordinadores',
                'orden' => 8,
                'estado' => true,
            ],
            [
                'slug' => 'personal-tecnico',
                'titulo' => 'Personal técnico',
                'descripcion' => 'Brinda soporte especializado para el funcionamiento de los servicios institucionales.',
                'imagen' => 'images/comunidad-educativa/tecnicos.jpg',
                'icono' => 'tecnicos',
                'orden' => 9,
                'estado' => true,
            ],
            [
                'slug' => 'suboficial',
                'titulo' => 'Suboficial',
                'descripcion' => 'Contribuye al orden, la disciplina y el cumplimiento de las disposiciones institucionales.',
                'imagen' => 'images/comunidad-educativa/suboficial.jpg',
                'icono' => 'suboficial',
                'orden' => 10,
                'estado' => true,
            ],
        ];

        foreach ($grupos as $grupo) {
            ComunidadEducativaGrupo::updateOrCreate(
                ['slug' => $grupo['slug']],
                [
                    ...$grupo,
                    'usuario_id' => null,
                ]
            );
        }
    }
}