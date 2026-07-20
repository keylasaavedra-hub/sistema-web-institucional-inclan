<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')
            ->pluck('id', 'nombre');

        $permisos = DB::table('permisos')
            ->pluck('id', 'codigo');

        $asignaciones = [
            'Administrador' => $permisos->keys()->all(),

            'Personal administrativo' => [
                'dashboard.ver',
                'publicaciones.gestionar',
                'documentos.gestionar',
                'galerias.gestionar',
                'comunidad.gestionar',
                'consultas.ver',
                'consultas.atender',
                'solicitudes.ver',
                'solicitudes.atender',
                'convocatorias.gestionar',
                'postulaciones.revisar',
                'chatbot.gestionar',
                'enlaces.gestionar',
            ],

            'Docente' => [
                'dashboard.ver',
                'publicaciones.gestionar',
                'logros.gestionar',
                'documentos.gestionar',
                'galerias.gestionar',
                'promociones.gestionar',
                'consultas.ver',
                'solicitudes.ver',
            ],

            'Director o supervisor' => [
                'dashboard.ver',
                'usuarios.ver',
                'institucion.gestionar',
                'publicaciones.gestionar',
                'logros.gestionar',
                'convenios.gestionar',
                'documentos.gestionar',
                'galerias.gestionar',
                'promociones.gestionar',
                'comunidad.gestionar',
                'consultas.ver',
                'consultas.atender',
                'solicitudes.ver',
                'solicitudes.atender',
                'convocatorias.gestionar',
                'postulaciones.revisar',
                'auditoria.ver',
            ],
        ];

        foreach ($asignaciones as $nombreRol => $codigosPermiso) {
            $rolId = $roles->get($nombreRol);

            if (!$rolId) {
                continue;
            }

            foreach ($codigosPermiso as $codigoPermiso) {
                $permisoId = $permisos->get($codigoPermiso);

                if (!$permisoId) {
                    continue;
                }

                DB::table('rol_permiso')->updateOrInsert(
                    [
                        'rol_id' => $rolId,
                        'permiso_id' => $permisoId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}