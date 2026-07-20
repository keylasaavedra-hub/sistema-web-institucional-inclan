<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasConsultaSeeder extends Seeder
{
    public function run(): void
    {
        $areaAdministracion = DB::table('areas_institucionales')
            ->where('nombre', 'Administración')
            ->value('id');

        $areaSecretaria = DB::table('areas_institucionales')
            ->where('nombre', 'Secretaría')
            ->value('id');

        $areaSoporte = DB::table('areas_institucionales')
            ->where('nombre', 'Soporte Técnico')
            ->value('id');

        DB::table('categorias_consulta')->upsert([
            [
                'area_id' => $areaAdministracion,
                'nombre' => 'Información general',
                'descripcion' => 'Consultas generales sobre la institución educativa.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaSecretaria,
                'nombre' => 'Documentos y formatos',
                'descripcion' => 'Consultas relacionadas con documentos, formatos y formularios.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaSecretaria,
                'nombre' => 'Trámites administrativos',
                'descripcion' => 'Consultas sobre solicitudes y trámites institucionales.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaAdministracion,
                'nombre' => 'Convocatorias',
                'descripcion' => 'Consultas relacionadas con convocatorias y postulaciones.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaSoporte,
                'nombre' => 'Soporte tecnológico',
                'descripcion' => 'Consultas sobre acceso y funcionamiento del portal institucional.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['nombre'], [
            'area_id',
            'descripcion',
            'estado',
            'updated_at',
        ]);
    }
}