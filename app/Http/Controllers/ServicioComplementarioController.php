<?php

namespace App\Http\Controllers;

use App\Models\InformacionInstitucional;
use Illuminate\View\View;

class ServicioComplementarioController extends Controller
{
    public function mostrar(string $servicio): View
    {
        $serviciosBase = [
            'topico' => [
                'titulo' => 'Tópico',
                'subtitulo' => 'Salud y primeros auxilios',
                'descripcion' => 'El servicio de Tópico brinda atención preventiva, orientación y cuidado básico de la salud para estudiantes y personal de nuestra comunidad educativa.',
                'imagen_portada' => 'images/servicio-topico.jpeg',
                'horario' => 'De 7:30 a. m. a 3:00 p. m.',
                'funciones' => [
                    'Brindar atención básica ante molestias o accidentes leves.',
                    'Orientar a estudiantes y familias sobre el cuidado de la salud.',
                    'Registrar las atenciones realizadas.',
                    'Coordinar acciones preventivas con la comunidad educativa.',
                ],
                'galeria' => [
                    'images/topico/topico-1.jpg',
                    'images/topico/topico-2.jpg',
                    'images/topico/topico-3.jpg',
                    'images/topico/topico-4.jpg',
                ],
            ],

            'toece' => [
                'titulo' => 'TOECE',
                'subtitulo' => 'Tutoría, orientación educativa y convivencia escolar',
                'descripcion' => 'TOECE acompaña a los estudiantes en su desarrollo personal, social y académico, promoviendo una convivencia respetuosa, segura e inclusiva.',
                'imagen_portada' => 'images/servicio-toece.jpeg',
                'horario' => 'De 7:30 a. m. a 3:00 p. m.',
                'funciones' => [
                    'Desarrollar acciones de tutoría y orientación educativa.',
                    'Promover una convivencia escolar respetuosa.',
                    'Prevenir situaciones de violencia escolar.',
                    'Coordinar actividades con estudiantes y familias.',
                ],
                'galeria' => [
                    'images/toece/toece-1.jpg',
                    'images/toece/toece-2.jpg',
                    'images/toece/toece-3.jpg',
                    'images/toece/toece-4.jpg',
                ],
            ],

            'psicologia' => [
                'titulo' => 'Psicología',
                'subtitulo' => 'Bienestar socioemocional',
                'descripcion' => 'El servicio de Psicología brinda acompañamiento emocional, personal y familiar para fortalecer el desarrollo integral de nuestros estudiantes.',
                'imagen_portada' => 'images/servicio-psicologia.jpeg',
                'horario' => 'De 7:30 a. m. a 3:00 p. m.',
                'funciones' => [
                    'Brindar orientación socioemocional a los estudiantes.',
                    'Realizar acciones preventivas y de acompañamiento.',
                    'Orientar a madres, padres y apoderados.',
                    'Coordinar intervenciones con docentes y directivos.',
                ],
                'galeria' => [
                    'images/psicologia/psicologia-1.jpg',
                    'images/psicologia/psicologia-2.jpg',
                    'images/psicologia/psicologia-3.jpg',
                    'images/psicologia/psicologia-4.jpg',
                ],
            ],
        ];

        abort_unless(isset($serviciosBase[$servicio]), 404);

        $contenidoServicios = InformacionInstitucional::query()
            ->where('tipo', 'servicios_inicio')
            ->where('estado', true)
            ->first();

        $datosServicios = $contenidoServicios?->datos ?? [];
        $datosEditados = $datosServicios[$servicio] ?? [];

        $base = $serviciosBase[$servicio];

        $imagenPortada = $this->normalizarRutaPublica(
            $datosEditados['imagen'] ?? null,
            $base['imagen_portada']
        );

        $galeriaEditada = collect(
            $datosEditados['galeria'] ?? []
        )
            ->filter()
            ->map(
                fn (string $ruta) => $this->normalizarRutaPublica(
                    $ruta,
                    $ruta
                )
            )
            ->values()
            ->all();

        $servicioFinal = [
            'titulo' =>
                $datosEditados['titulo']
                ?? $base['titulo'],

            'subtitulo' =>
                $datosEditados['subtitulo']
                ?? $base['subtitulo'],

            'descripcion' =>
                $datosEditados['descripcion']
                ?? $base['descripcion'],

            'imagen_portada' =>
                $imagenPortada,

            'horario' =>
                $datosEditados['horario']
                ?? $base['horario'],

            'funciones' =>
                !empty($datosEditados['funciones'])
                    ? array_values($datosEditados['funciones'])
                    : $base['funciones'],

            'galeria' =>
                !empty($galeriaEditada)
                    ? $galeriaEditada
                    : $base['galeria'],
        ];

        return view(
            'servicios.mostrar',
            [
                'servicio' => $servicioFinal,
            ]
        );
    }

    private function normalizarRutaPublica(
        ?string $ruta,
        string $fallback
    ): string {
        if (!$ruta) {
            return $fallback;
        }

        $ruta = ltrim($ruta, '/');

        if (
            str_starts_with($ruta, 'images/')
            || str_starts_with($ruta, 'storage/')
        ) {
            return $ruta;
        }

        return 'storage/' . $ruta;
    }
}