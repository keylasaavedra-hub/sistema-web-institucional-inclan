<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargosSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            'Director',
            'Subdirector',
            'Docente',
            'Auxiliar de educación',
            'Personal administrativo',
            'Secretaría',
            'Soporte técnico',
            'Logística',
            'Practicante',
        ];

        foreach ($cargos as $nombre) {
            Cargo::updateOrCreate(
                [
                    'nombre' => $nombre,
                ],
                [
                    'estado' => true,
                ]
            );
        }
    }
}