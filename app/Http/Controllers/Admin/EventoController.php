<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventoController extends Controller
{
    public function index(Request $request): View
    {
        $eventos = Evento::query()
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim($request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('titulo', 'like', "%{$buscar}%")
                            ->orWhere('descripcion', 'like', "%{$buscar}%")
                            ->orWhere('lugar', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('tipo'),
                fn ($query) => $query->where('tipo', $request->tipo)
            )
            ->when(
                $request->estado === 'activo',
                fn ($query) => $query->where('activo', true)
            )
            ->when(
                $request->estado === 'inactivo',
                fn ($query) => $query->where('activo', false)
            )
            ->orderByDesc('fecha_inicio')
            ->paginate(15)
            ->withQueryString();

        return view('admin.eventos.index', [
            'eventos' => $eventos,
        ]);
    }

    public function create(): View
    {
        return view('admin.eventos.crear');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $this->validarEvento($request);

        $datos['es_publico'] = $request->boolean('es_publico');
        $datos['activo'] = $request->boolean('activo');

        $evento = Evento::create($datos);

        return redirect()
            ->route('admin.eventos.edit', $evento)
            ->with('mensaje', 'El evento fue registrado correctamente.');
    }

    public function edit(Evento $evento): View
    {
        return view('admin.eventos.editar', [
            'evento' => $evento,
        ]);
    }

    public function update(
        Request $request,
        Evento $evento
    ): RedirectResponse {
        $datos = $this->validarEvento($request);

        $datos['es_publico'] = $request->boolean('es_publico');
        $datos['activo'] = $request->boolean('activo');

        $evento->update($datos);

        return redirect()
            ->route('admin.eventos.edit', $evento)
            ->with('mensaje', 'El evento fue actualizado correctamente.');
    }

    public function destroy(Evento $evento): RedirectResponse
    {
        $evento->delete();

        return redirect()
            ->route('admin.eventos.index')
            ->with('mensaje', 'El evento fue eliminado correctamente.');
    }

    private function validarEvento(Request $request): array
    {
        return $request->validate(
            [
                'titulo' => [
                    'required',
                    'string',
                    'max:180',
                ],
                'descripcion' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],
                'lugar' => [
                    'nullable',
                    'string',
                    'max:180',
                ],
                'fecha_inicio' => [
                    'required',
                    'date',
                ],
                'fecha_fin' => [
                    'nullable',
                    'date',
                    'after_or_equal:fecha_inicio',
                ],
                'tipo' => [
                    'required',
                    'in:institucional,academico,civico,deportivo,cultural,reunion,otro',
                ],
            ],
            [
                'titulo.required' => 'Ingresa el título del evento.',
                'titulo.max' => 'El título no puede superar los 180 caracteres.',
                'descripcion.max' => 'La descripción no puede superar los 3000 caracteres.',
                'lugar.max' => 'El lugar no puede superar los 180 caracteres.',
                'fecha_inicio.required' => 'Selecciona la fecha y hora de inicio.',
                'fecha_inicio.date' => 'La fecha de inicio no es válida.',
                'fecha_fin.date' => 'La fecha de finalización no es válida.',
                'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior al inicio.',
                'tipo.required' => 'Selecciona el tipo de evento.',
                'tipo.in' => 'El tipo de evento seleccionado no es válido.',
            ]
        );
    }
}