<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaInstitucional;
use App\Models\Cargo;
use App\Models\Convocatoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConvocatoriaController extends Controller
{
    public function index(Request $request): View
    {
        $convocatorias = Convocatoria::query()
            ->with(['area', 'cargo'])
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim($request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('codigo', 'like', "%{$buscar}%")
                            ->orWhere('titulo', 'like', "%{$buscar}%")
                            ->orWhere('descripcion', 'like', "%{$buscar}%")
                            ->orWhere('perfil', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('tipo'),
                fn($query) => $query->where('tipo', $request->tipo)
            )
            ->when(
                $request->filled('estado'),
                fn($query) => $query->where('estado', $request->estado)
            )
            ->latest('fecha_publicacion')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.convocatorias.index', [
            'convocatorias' => $convocatorias,
        ]);
    }

    public function create(): View
    {
        return view('admin.convocatorias.crear', [
            'areas' => AreaInstitucional::query()
                ->where('estado', true)
                ->orderBy('nombre')
                ->get(),

            'cargos' => Cargo::query()
                ->where('estado', true)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $this->validarConvocatoria($request);

        $datos['usuario_id'] = auth()->id();
        $datos['codigo'] = $this->generarCodigo();
        $datos['destacada'] = $request->boolean('destacada');

        if (
            $datos['estado'] === 'publicada'
            && empty($datos['fecha_publicacion'])
        ) {
            $datos['fecha_publicacion'] = now();
        }

        $convocatoria = Convocatoria::create($datos);

        return redirect()
            ->route('admin.convocatorias.edit', $convocatoria)
            ->with('mensaje', 'La convocatoria fue registrada correctamente.');
    }

    public function edit(Convocatoria $convocatoria): View
    {
        return view('admin.convocatorias.editar', [
            'convocatoria' => $convocatoria,

            'areas' => AreaInstitucional::query()
                ->where('estado', true)
                ->orderBy('nombre')
                ->get(),

            'cargos' => Cargo::query()
                ->where('estado', true)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function update(
        Request $request,
        Convocatoria $convocatoria
    ): RedirectResponse {
        $datos = $this->validarConvocatoria($request);

        $datos['destacada'] = $request->boolean('destacada');

        if (
            $datos['estado'] === 'publicada'
            && empty($datos['fecha_publicacion'])
        ) {
            $datos['fecha_publicacion'] = now();
        }

        $convocatoria->update($datos);

        return redirect()
            ->route('admin.convocatorias.edit', $convocatoria)
            ->with('mensaje', 'La convocatoria fue actualizada correctamente.');
    }

    public function destroy(
        Convocatoria $convocatoria
    ): RedirectResponse {
        $convocatoria->delete();

        return redirect()
            ->route('admin.convocatorias.index')
            ->with('mensaje', 'La convocatoria fue eliminada correctamente.');
    }

    private function validarConvocatoria(Request $request): array
    {
        return $request->validate(
            [
                'area_id' => [
                    'nullable',
                    'exists:areas_institucionales,id',
                ],
                'cargo_id' => [
                    'nullable',
                    'exists:cargos,id',
                ],
                'tipo' => [
                    'required',
                    'in:practicas,laboral,cas,servicios,voluntariado,otro',
                ],
                'titulo' => [
                    'required',
                    'string',
                    'max:220',
                ],
                'descripcion' => [
                    'required',
                    'string',
                    'max:5000',
                ],
                'perfil' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
                'requisitos' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
                'cronograma' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
                'vacantes' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:999',
                ],
                'fecha_inicio' => [
                    'required',
                    'date',
                ],
                'fecha_cierre' => [
                    'required',
                    'date',
                    'after_or_equal:fecha_inicio',
                ],
                'fecha_publicacion' => [
                    'nullable',
                    'date',
                ],
                'estado' => [
                    'required',
                    'in:borrador,publicada,cerrada,anulada',
                ],
            ],
            [
                'tipo.required' => 'Selecciona el tipo de convocatoria.',
                'tipo.in' => 'El tipo seleccionado no es válido.',
                'titulo.required' => 'Ingresa el título de la convocatoria.',
                'descripcion.required' => 'Ingresa la descripción.',
                'vacantes.required' => 'Ingresa el número de vacantes.',
                'vacantes.min' => 'Debe existir al menos una vacante.',
                'fecha_inicio.required' => 'Selecciona la fecha de inicio.',
                'fecha_cierre.required' => 'Selecciona la fecha de cierre.',
                'fecha_cierre.after_or_equal' => 'La fecha de cierre debe ser igual o posterior al inicio.',
                'estado.required' => 'Selecciona el estado.',
            ]
        );
    }

    private function generarCodigo(): string
    {
        do {
            $codigo = 'CONV-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(5));
        } while (
            Convocatoria::query()
            ->where('codigo', $codigo)
            ->exists()
        );

        return $codigo;
    }
}
