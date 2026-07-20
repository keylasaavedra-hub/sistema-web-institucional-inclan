<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Panel
            [
                'nombre' => 'Ver panel administrativo',
                'codigo' => 'dashboard.ver',
                'modulo' => 'Dashboard',
                'descripcion' => 'Permite acceder al panel administrativo.',
            ],

            // Usuarios y seguridad
            [
                'nombre' => 'Ver usuarios',
                'codigo' => 'usuarios.ver',
                'modulo' => 'Usuarios',
                'descripcion' => 'Permite consultar usuarios registrados.',
            ],
            [
                'nombre' => 'Crear usuarios',
                'codigo' => 'usuarios.crear',
                'modulo' => 'Usuarios',
                'descripcion' => 'Permite registrar nuevos usuarios.',
            ],
            [
                'nombre' => 'Editar usuarios',
                'codigo' => 'usuarios.editar',
                'modulo' => 'Usuarios',
                'descripcion' => 'Permite actualizar usuarios.',
            ],
            [
                'nombre' => 'Administrar roles y permisos',
                'codigo' => 'seguridad.administrar',
                'modulo' => 'Seguridad',
                'descripcion' => 'Permite administrar roles y permisos.',
            ],

            // Contenido institucional
            [
                'nombre' => 'Gestionar información institucional',
                'codigo' => 'institucion.gestionar',
                'modulo' => 'Información institucional',
                'descripcion' => 'Permite administrar misión, visión, historia y otros contenidos.',
            ],
            [
                'nombre' => 'Gestionar publicaciones',
                'codigo' => 'publicaciones.gestionar',
                'modulo' => 'Publicaciones',
                'descripcion' => 'Permite crear, editar y publicar noticias, anuncios y comunicados.',
            ],
            [
                'nombre' => 'Gestionar logros',
                'codigo' => 'logros.gestionar',
                'modulo' => 'Logros',
                'descripcion' => 'Permite administrar los logros institucionales.',
            ],
            [
                'nombre' => 'Gestionar convenios',
                'codigo' => 'convenios.gestionar',
                'modulo' => 'Convenios',
                'descripcion' => 'Permite administrar convenios institucionales.',
            ],
            [
                'nombre' => 'Gestionar documentos',
                'codigo' => 'documentos.gestionar',
                'modulo' => 'Documentos',
                'descripcion' => 'Permite subir, modificar y publicar documentos.',
            ],

            // Multimedia y comunidad
            [
                'nombre' => 'Gestionar galerías',
                'codigo' => 'galerias.gestionar',
                'modulo' => 'Galerías',
                'descripcion' => 'Permite administrar galerías y archivos multimedia.',
            ],
            [
                'nombre' => 'Gestionar promociones',
                'codigo' => 'promociones.gestionar',
                'modulo' => 'Promociones',
                'descripcion' => 'Permite administrar promociones educativas.',
            ],
            [
                'nombre' => 'Gestionar comunidad educativa',
                'codigo' => 'comunidad.gestionar',
                'modulo' => 'Comunidad educativa',
                'descripcion' => 'Permite administrar información del personal institucional.',
            ],

            // Consultas y trámites
            [
                'nombre' => 'Ver consultas',
                'codigo' => 'consultas.ver',
                'modulo' => 'Consultas',
                'descripcion' => 'Permite revisar consultas recibidas.',
            ],
            [
                'nombre' => 'Atender consultas',
                'codigo' => 'consultas.atender',
                'modulo' => 'Consultas',
                'descripcion' => 'Permite responder y cambiar el estado de las consultas.',
            ],
            [
                'nombre' => 'Ver solicitudes',
                'codigo' => 'solicitudes.ver',
                'modulo' => 'Trámites',
                'descripcion' => 'Permite revisar solicitudes y expedientes.',
            ],
            [
                'nombre' => 'Atender solicitudes',
                'codigo' => 'solicitudes.atender',
                'modulo' => 'Trámites',
                'descripcion' => 'Permite atender y cambiar el estado de solicitudes.',
            ],
            [
                'nombre' => 'Gestionar tipos de trámite',
                'codigo' => 'tramites.configurar',
                'modulo' => 'Trámites',
                'descripcion' => 'Permite administrar los tipos de trámite.',
            ],

            // Convocatorias
            [
                'nombre' => 'Gestionar convocatorias',
                'codigo' => 'convocatorias.gestionar',
                'modulo' => 'Convocatorias',
                'descripcion' => 'Permite crear y publicar convocatorias.',
            ],
            [
                'nombre' => 'Revisar postulaciones',
                'codigo' => 'postulaciones.revisar',
                'modulo' => 'Postulaciones',
                'descripcion' => 'Permite revisar documentos y estados de postulaciones.',
            ],

            // Chatbot y configuración
            [
                'nombre' => 'Gestionar chatbot',
                'codigo' => 'chatbot.gestionar',
                'modulo' => 'Chatbot',
                'descripcion' => 'Permite administrar preguntas y respuestas automáticas.',
            ],
            [
                'nombre' => 'Gestionar enlaces externos',
                'codigo' => 'enlaces.gestionar',
                'modulo' => 'Enlaces externos',
                'descripcion' => 'Permite administrar enlaces institucionales.',
            ],
            [
                'nombre' => 'Configurar sitio',
                'codigo' => 'configuracion.gestionar',
                'modulo' => 'Configuración',
                'descripcion' => 'Permite modificar la configuración general del portal.',
            ],
            [
                'nombre' => 'Ver auditoría',
                'codigo' => 'auditoria.ver',
                'modulo' => 'Auditoría',
                'descripcion' => 'Permite revisar las acciones realizadas en el sistema.',
            ],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(
                ['codigo' => $permiso['codigo']],
                [
                    'nombre' => $permiso['nombre'],
                    'modulo' => $permiso['modulo'],
                    'descripcion' => $permiso['descripcion'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}