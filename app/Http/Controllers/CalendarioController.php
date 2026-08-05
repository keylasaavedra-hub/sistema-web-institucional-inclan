<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarioController extends Controller
{
    public function index(Request $request): View
    {
        try {
            $fechaCalendario = $request->filled('mes')
                ? Carbon::createFromFormat('Y-m', $request->mes)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable $e) {
            $fechaCalendario = now()->startOfMonth();
        }

        $inicioMes = $fechaCalendario->copy()->startOfMonth();
        $finMes = $fechaCalendario->copy()->endOfMonth();

        $nombresTipos = [
            'institucional' => 'Institucional',
            'academico' => 'Académico',
            'civico' => 'Cívico',
            'deportivo' => 'Deportivo',
            'cultural' => 'Cultural',
            'reunion' => 'Reunión',
            'otro' => 'Otro',
        ];

        $eventos = Evento::query()
            ->where('activo', true)
            ->where('es_publico', true)
            ->whereBetween('fecha_inicio', [
                $inicioMes->copy()->startOfDay(),
                $finMes->copy()->endOfDay(),
            ])
            ->orderBy('fecha_inicio')
            ->get()
            ->map(function (Evento $evento) use ($nombresTipos) {
                return [
                    'id' => $evento->id,
                    'dia' => $evento->fecha_inicio->day,
                    'mes' => $evento->fecha_inicio->month,
                    'anio' => $evento->fecha_inicio->year,

                    'tipo' => $nombresTipos[$evento->tipo] ?? 'Otro',

                    'titulo' => $evento->titulo,

                    'descripcion' => $evento->descripcion
                        ?: 'Actividad institucional programada.',

                    'hora' => $evento->fecha_inicio
                        ? $evento->fecha_inicio->format('h:i a')
                        : null,

                    'hora_fin' => $evento->fecha_fin
                        ? $evento->fecha_fin->format('h:i a')
                        : null,

                    'lugar' => $evento->lugar,
                ];
            })
            ->values();

        return view('calendario.index', [
            'fechaCalendario' => $fechaCalendario,
            'eventos' => $eventos,
        ]);
    }
}   