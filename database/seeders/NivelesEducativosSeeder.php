<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesEducativosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('niveles_educativos')->upsert([
            [
                'nombre' => 'Inicial',
                'descripcion' => null,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Primaria',
                'descripcion' => null,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Secundaria',
                'descripcion' => null,
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