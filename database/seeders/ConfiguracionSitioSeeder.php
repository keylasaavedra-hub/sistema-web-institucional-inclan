<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracionSitioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('configuracion_sitio')->updateOrInsert(
            ['id' => 1],
            [
                'usuario_id' => null,
                'nombre_sitio' => 'Institución Educativa Crl. José Joaquín Inclán',
                'nombre_corto' => 'IE José Joaquín Inclán',
                'logo' => null,
                'favicon' => null,
                'direccion' => 'Piura, Perú',
                'telefono' => null,
                'correo' => null,
                'horario_atencion' => 'Lunes a viernes',
                'descripcion' => 'Portal web institucional de la IE Crl. José Joaquín Inclán.',
                'facebook' => null,
                'youtube' => null,
                'instagram' => null,
                'tiktok' => null,
                'mapa_url' => null,
                'color_principal' => '#7B1E2B',
                'color_secundario' => '#D4AF37',
                'modo_mantenimiento' => false,
                'mensaje_mantenimiento' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}