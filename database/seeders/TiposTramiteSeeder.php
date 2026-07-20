<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposTramiteSeeder extends Seeder
{
    public function run(): void
    {
        $areaSecretaria = DB::table('areas_institucionales')
            ->where('nombre', 'Secretaría')
            ->value('id');

        $areaAdministracion = DB::table('areas_institucionales')
            ->where('nombre', 'Administración')
            ->value('id');

        $areaRecursosHumanos = DB::table('areas_institucionales')
            ->where('nombre', 'Recursos Humanos')
            ->value('id');

        DB::table('tipos_tramite')->upsert([
            [
                'area_id' => $areaSecretaria,
                'nombre' => 'Solicitud general',
                'codigo' => 'SOL-GEN',
                'descripcion' => 'Presentación de una solicitud general dirigida a la institución.',
                'requisitos' => 'Solicitud con datos completos del solicitante y descripción del pedido.',
                'plazo_dias' => 5,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaSecretaria,
                'nombre' => 'Solicitud de constancia',
                'codigo' => 'SOL-CON',
                'descripcion' => 'Solicitud de emisión de constancias institucionales.',
                'requisitos' => 'DNI del solicitante y detalle de la constancia requerida.',
                'plazo_dias' => 5,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaSecretaria,
                'nombre' => 'Presentación de documentos',
                'codigo' => 'PRE-DOC',
                'descripcion' => 'Registro y presentación de documentos dirigidos a la institución.',
                'requisitos' => 'Documento principal y anexos correspondientes.',
                'plazo_dias' => 3,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaAdministracion,
                'nombre' => 'Justificación',
                'codigo' => 'JUS-001',
                'descripcion' => 'Presentación de una justificación ante la institución.',
                'requisitos' => 'Documento de justificación y archivos de sustento.',
                'plazo_dias' => 3,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaRecursosHumanos,
                'nombre' => 'Permiso',
                'codigo' => 'PER-001',
                'descripcion' => 'Solicitud de permiso para el personal institucional.',
                'requisitos' => 'Solicitud indicando fecha, horario y motivo.',
                'plazo_dias' => 3,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => $areaRecursosHumanos,
                'nombre' => 'Licencia',
                'codigo' => 'LIC-001',
                'descripcion' => 'Solicitud de licencia para el personal institucional.',
                'requisitos' => 'Solicitud formal y documentos que sustenten la licencia.',
                'plazo_dias' => 7,
                'permite_adjuntos' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['codigo'], [
            'area_id',
            'nombre',
            'descripcion',
            'requisitos',
            'plazo_dias',
            'permite_adjuntos',
            'estado',
            'updated_at',
        ]);
    }
}