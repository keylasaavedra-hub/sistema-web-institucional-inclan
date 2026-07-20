<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            AreasInstitucionalesSeeder::class,
            NivelesEducativosSeeder::class,
            CategoriasPublicacionSeeder::class,
            CategoriasDocumentoSeeder::class,
            CategoriasConsultaSeeder::class,
            TiposTramiteSeeder::class,
            EnlacesExternosSeeder::class,
            ConfiguracionSitioSeeder::class,
            PreguntasChatbotSeeder::class,

            PermisosSeeder::class,
            RolPermisoSeeder::class,
            AdministradorSeeder::class,
        ]);
    }
}