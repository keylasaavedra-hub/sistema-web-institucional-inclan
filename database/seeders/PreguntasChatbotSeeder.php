<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntasChatbotSeeder extends Seeder
{
    public function run(): void
    {
        $preguntas = [
            [
                'pregunta' => '¿Cuál es el horario de atención?',
                'respuesta' => 'El horario de atención institucional se encuentra publicado en la sección de contacto del portal.',
                'palabras_clave' => 'horario, atención, atienden, oficina',
                'enlace_relacionado' => '/contacto',
                'orden' => 1,
            ],
            [
                'pregunta' => '¿Dónde se encuentra ubicada la institución?',
                'respuesta' => 'La ubicación y el mapa de la institución se encuentran disponibles en la sección de contacto.',
                'palabras_clave' => 'ubicación, dirección, mapa, dónde, institución',
                'enlace_relacionado' => '/contacto',
                'orden' => 2,
            ],
            [
                'pregunta' => '¿Cómo puedo realizar un trámite?',
                'respuesta' => 'Puedes registrar tu solicitud desde la sección de trámites del portal y consultar posteriormente su estado.',
                'palabras_clave' => 'trámite, solicitud, expediente, documento',
                'enlace_relacionado' => '/tramites',
                'orden' => 3,
            ],
            [
                'pregunta' => '¿Cómo ingreso a Sieweb?',
                'respuesta' => 'Puedes acceder a Sieweb desde el enlace disponible en la sección de enlaces institucionales.',
                'palabras_clave' => 'sieweb, plataforma, ingresar, acceso',
                'enlace_relacionado' => '/enlaces',
                'orden' => 4,
            ],
            [
                'pregunta' => '¿Dónde puedo revisar las convocatorias?',
                'respuesta' => 'Las convocatorias vigentes se publican en la sección de convocatorias del portal institucional.',
                'palabras_clave' => 'convocatoria, trabajo, prácticas, postulación, vacante',
                'enlace_relacionado' => '/convocatorias',
                'orden' => 5,
            ],
        ];

        foreach ($preguntas as $pregunta) {
            DB::table('preguntas_chatbot')->updateOrInsert(
                ['pregunta' => $pregunta['pregunta']],
                [
                    'usuario_id' => null,
                    'respuesta' => $pregunta['respuesta'],
                    'palabras_clave' => $pregunta['palabras_clave'],
                    'enlace_relacionado' => $pregunta['enlace_relacionado'],
                    'orden' => $pregunta['orden'],
                    'veces_utilizada' => 0,
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}