<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    public function run(): void
    {
        $rolAdministradorId = DB::table('roles')
            ->where('nombre', 'Administrador')
            ->value('id');

        if (!$rolAdministradorId) {
            $this->command?->error(
                'No se encontró el rol Administrador. Ejecuta primero RolesSeeder.'
            );

            return;
        }

        DB::table('users')->updateOrInsert(
            ['dni' => '12345678'],
            [
                'name' => 'Administrador',
                'apellidos' => 'De Prueba',
                'email' => 'admin@inclan.test',
                'telefono' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('Admin123*'),
                'rol_id' => $rolAdministradorId,
                'estado' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}