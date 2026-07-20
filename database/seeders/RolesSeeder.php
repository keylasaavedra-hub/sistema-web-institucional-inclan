<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->upsert([
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Administra integralmente el sistema.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Personal administrativo',
                'descripcion' => 'Gestiona contenidos, consultas, trámites y postulaciones.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Docente',
                'descripcion' => 'Accede a documentos y presenta solicitudes institucionales.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Director o supervisor',
                'descripcion' => 'Consulta reportes y supervisa procesos institucionales.',
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