<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasPublicacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias_publicacion')->upsert([
            [
                'nombre' => 'Noticias',
                'descripcion' => 'Noticias y novedades de la institución.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Anuncios',
                'descripcion' => 'Anuncios dirigidos a la comunidad educativa.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comunicados',
                'descripcion' => 'Comunicados oficiales de la institución.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Eventos',
                'descripcion' => 'Actividades y eventos institucionales.',
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