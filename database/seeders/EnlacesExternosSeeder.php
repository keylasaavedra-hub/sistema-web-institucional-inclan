<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnlacesExternosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('enlaces_externos')->upsert([
            [
                'usuario_id' => null,
                'nombre' => 'Sieweb',
                'url' => 'https://www.sieweb.com.pe/',
                'descripcion' => 'Acceso a la plataforma educativa Sieweb.',
                'icono' => 'school',
                'tipo' => 'plataforma_educativa',
                'orden' => 1,
                'abrir_nueva_pestana' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usuario_id' => null,
                'nombre' => 'Ministerio de Educación',
                'url' => 'https://www.gob.pe/minedu',
                'descripcion' => 'Portal oficial del Ministerio de Educación del Perú.',
                'icono' => 'account_balance',
                'tipo' => 'institucional',
                'orden' => 2,
                'abrir_nueva_pestana' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usuario_id' => null,
                'nombre' => 'SIAGIE',
                'url' => 'https://siagie.minedu.gob.pe/',
                'descripcion' => 'Sistema de Información de Apoyo a la Gestión de la Institución Educativa.',
                'icono' => 'folder_shared',
                'tipo' => 'plataforma_educativa',
                'orden' => 3,
                'abrir_nueva_pestana' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usuario_id' => null,
                'nombre' => 'PerúEduca',
                'url' => 'https://www.perueduca.pe/',
                'descripcion' => 'Sistema Digital para el Aprendizaje PerúEduca.',
                'icono' => 'menu_book',
                'tipo' => 'plataforma_educativa',
                'orden' => 4,
                'abrir_nueva_pestana' => true,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['nombre', 'url'], [
            'descripcion',
            'icono',
            'tipo',
            'orden',
            'abrir_nueva_pestana',
            'estado',
            'updated_at',
        ]);
    }
}