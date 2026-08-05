<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    public function index(Request $request): View
    {
        $consultas = Consulta::query()
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim($request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('codigo', 'like', "%{$buscar}%")
                            ->orWhere('nombres', 'like', "%{$buscar}%")
                            ->orWhere('apellidos', 'like', "%{$buscar}%")
                            ->orWhere('correo', 'like', "%{$buscar}%")
                            ->orWhere('asunto', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('estado'),
                fn ($query) => $query->where('estado', $request->estado)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.consultas.index', [
            'consultas' => $consultas,
        ]);
    }

    public function mostrar(Consulta $consulta): View
    {
        return view('admin.consultas.mostrar', [
            'consulta' => $consulta,
        ]);
    }

    public function actualizar(Request $request, Consulta $consulta)
    {
        $datos = $request->validate(
            [
                'estado' => [
                    'required',
                    'in:recibida,en_revision,derivada,respondida,cerrada',
                ],
                'respuesta' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],
            ],
            [
                'estado.required' => 'Selecciona el estado.',
                'estado.in' => 'El estado seleccionado no es válido.',
                'respuesta.max' => 'La respuesta no puede superar los 3000 caracteres.',
            ]
        );

        $consulta->estado = $datos['estado'];
        $consulta->respuesta = $datos['respuesta'] ?? null;

        if (!empty($datos['respuesta'])) {
            $consulta->respondido_en = now();

            if ($consulta->estado === 'recibida') {
                $consulta->estado = 'respondida';
            }
        }

        $consulta->save();

        return redirect()
            ->route('admin.consultas.mostrar', $consulta)
            ->with('mensaje', 'La consulta fue actualizada correctamente.');
    }
}