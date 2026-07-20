<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias_documento')->upsert([
            [
                'nombre' => 'Reglamentos',
                'descripcion' => 'Reglamentos institucionales vigentes.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Directivas',
                'descripcion' => 'Directivas y disposiciones institucionales.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Planes',
                'descripcion' => 'Planes institucionales y documentos de gestión.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Formatos',
                'descripcion' => 'Formatos disponibles para descargar.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Formularios',
                'descripcion' => 'Formularios institucionales para trámites y solicitudes.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['nombre'], [
            'descripcion',
            'estado',
            'updated_at',
        ]);
    }
}