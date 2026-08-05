<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\Postulacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostulacionController extends Controller
{
    public function index(Request $request): View
    {
        $postulaciones = Postulacion::query()
            ->with([
                'convocatoria:id,codigo,titulo',
                'revisor:id,name',
            ])
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim($request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('codigo', 'like', "%{$buscar}%")
                            ->orWhere('nombres', 'like', "%{$buscar}%")
                            ->orWhere('apellidos', 'like', "%{$buscar}%")
                            ->orWhere('dni', 'like', "%{$buscar}%")
                            ->orWhere('correo', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('estado'),
                fn ($query) => $query->where(
                    'estado',
                    $request->estado
                )
            )
            ->when(
                $request->filled('convocatoria_id'),
                fn ($query) => $query->where(
                    'convocatoria_id',
                    $request->convocatoria_id
                )
            )
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $convocatorias = Convocatoria::query()
            ->select('id', 'codigo', 'titulo')
            ->whereHas('postulaciones')
            ->latest('id')
            ->get();

        $estadisticas = [
            'total' => Postulacion::query()->count(),

            'recibidas' => Postulacion::query()
                ->where('estado', 'recibida')
                ->count(),

            'revision' => Postulacion::query()
                ->where('estado', 'en_revision')
                ->count(),

            'observadas' => Postulacion::query()
                ->where('estado', 'observada')
                ->count(),

            'aptas' => Postulacion::query()
                ->where('estado', 'apta')
                ->count(),

            'seleccionadas' => Postulacion::query()
                ->where('estado', 'seleccionada')
                ->count(),
        ];

        return view('admin.postulaciones.index', [
            'postulaciones' => $postulaciones,
            'convocatorias' => $convocatorias,
            'estadisticas' => $estadisticas,
        ]);
    }

    public function mostrar(Postulacion $postulacion): View
    {
        $postulacion->load([
            'convocatoria.area',
            'convocatoria.cargo',
            'revisor',
        ]);

        return view('admin.postulaciones.mostrar', [
            'postulacion' => $postulacion,
        ]);
    }

    public function actualizar(
        Request $request,
        Postulacion $postulacion
    ): RedirectResponse {
        $datos = $request->validate(
            [
                'estado' => [
                    'required',
                    'in:recibida,en_revision,observada,apta,no_apta,seleccionada',
                ],
                'observacion' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'estado.required' => 'Selecciona el estado de la postulación.',
                'estado.in' => 'El estado seleccionado no es válido.',
                'observacion.max' => 'La observación no puede superar los 5000 caracteres.',
            ]
        );

        $datos['usuario_revisor_id'] = auth()->id();
        $datos['fecha_revision'] = now();

        $postulacion->update($datos);

        return redirect()
            ->route('admin.postulaciones.mostrar', $postulacion)
            ->with(
                'mensaje',
                'La postulación fue actualizada correctamente.'
            );
    }
}