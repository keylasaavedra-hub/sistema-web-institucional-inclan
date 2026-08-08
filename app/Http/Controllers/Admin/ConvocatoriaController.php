<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaInstitucional;
use App\Models\Cargo;
use App\Models\Convocatoria;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ConvocatoriaController extends Controller
{
    public function index(Request $request): View
    {
        $convocatorias = Convocatoria::query()
            ->with([
                'area',
                'cargo',
            ])
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim(
                        (string) $request->buscar
                    );

                    $query->where(
                        function ($subquery) use ($buscar) {
                            $subquery
                                ->where(
                                    'codigo',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'titulo',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'descripcion',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'perfil',
                                    'like',
                                    "%{$buscar}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $request->filled('tipo'),
                fn($query) => $query->where(
                    'tipo',
                    $request->tipo
                )
            )
            ->when(
                $request->filled('estado'),
                fn($query) => $query->where(
                    'estado',
                    $request->estado
                )
            )
            ->latest('fecha_publicacion')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.convocatorias.index',
            [
                'convocatorias' => $convocatorias,
            ]
        );
    }

    public function create(): View
    {
        return view(
            'admin.convocatorias.crear',
            [
                'areas' => AreaInstitucional::query()
                    ->where('estado', true)
                    ->orderBy('nombre')
                    ->get(),

                'cargos' => Cargo::query()
                    ->where('estado', true)
                    ->orderBy('nombre')
                    ->get(),
            ]
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $datos = $this->validarConvocatoria(
            $request
        );

        $datos['perfil'] = $datos['perfil'] ?? '';
        $datos['requisitos'] = $datos['requisitos'] ?? '';
        $datos['cronograma'] = $datos['cronograma'] ?? '';
        $datos['usuario_id'] = auth()->id();
        $datos['codigo'] = $this->generarCodigo();

        $datos['destacada'] =
            $request->boolean('destacada');

        if (
            $datos['estado'] === 'publicada'
            && empty($datos['fecha_publicacion'])
        ) {
            $datos['fecha_publicacion'] = now();
        }

        DB::beginTransaction();

        try {
            $convocatoria = Convocatoria::create(
                $datos
            );

            AuditoriaService::registrar(
                modulo: 'Convocatorias',
                accion: 'crear',
                modelo: $convocatoria,
                valoresAnteriores: null,
                valoresNuevos: $this->datosAuditoria(
                    $convocatoria
                ),
                descripcion: sprintf(
                    'Se creó la convocatoria %s: "%s".',
                    $convocatoria->codigo,
                    $convocatoria->titulo
                )
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.convocatorias.edit',
                    $convocatoria->id
                )
                ->with(
                    'mensaje',
                    'La convocatoria fue registrada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar la convocatoria.'
                );
        }
    }

    public function edit(
        Convocatoria $convocatoria
    ): View {
        return view(
            'admin.convocatorias.editar',
            [
                'convocatoria' =>
                $convocatoria,

                'areas' =>
                AreaInstitucional::query()
                    ->where('estado', true)
                    ->orderBy('nombre')
                    ->get(),

                'cargos' =>
                Cargo::query()
                    ->where('estado', true)
                    ->orderBy('nombre')
                    ->get(),
            ]
        );
    }

    public function update(
        Request $request,
        Convocatoria $convocatoria
    ): RedirectResponse {
        $datos = $this->validarConvocatoria(
            $request
        );

        $datos['perfil'] = $datos['perfil'] ?? '';
        $datos['requisitos'] = $datos['requisitos'] ?? '';
        $datos['cronograma'] = $datos['cronograma'] ?? '';
        $datos['destacada'] =
            $request->boolean('destacada');

        if (
            $datos['estado'] === 'publicada'
            && empty($datos['fecha_publicacion'])
        ) {
            $datos['fecha_publicacion'] = now();
        }

        $valoresAnteriores =
            $this->datosAuditoria(
                $convocatoria
            );

        $estadoAnterior =
            $convocatoria->estado;

        DB::beginTransaction();

        try {
            $convocatoria->update($datos);

            $convocatoria->refresh();

            $estadoCambio =
                $estadoAnterior
                !== $convocatoria->estado;

            $accion = $estadoCambio
                ? 'cambiar_estado'
                : 'actualizar';

            $descripcion = $estadoCambio
                ? sprintf(
                    'La convocatoria %s cambió de estado de %s a %s.',
                    $convocatoria->codigo,
                    $estadoAnterior,
                    $convocatoria->estado
                )
                : sprintf(
                    'Se actualizó la convocatoria %s: "%s".',
                    $convocatoria->codigo,
                    $convocatoria->titulo
                );

            AuditoriaService::registrar(
                modulo: 'Convocatorias',
                accion: $accion,
                modelo: $convocatoria,
                valoresAnteriores: $valoresAnteriores,
                valoresNuevos: $this->datosAuditoria(
                    $convocatoria
                ),
                descripcion: $descripcion
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.convocatorias.edit',
                    $convocatoria->id
                )
                ->with(
                    'mensaje',
                    'La convocatoria fue actualizada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la convocatoria.'
                );
        }
    }

    public function destroy(
        Convocatoria $convocatoria
    ): RedirectResponse {
        $valoresAnteriores =
            $this->datosAuditoria(
                $convocatoria
            );

        $codigo = $convocatoria->codigo;
        $titulo = $convocatoria->titulo;

        try {
            DB::transaction(
                function () use (
                    $convocatoria,
                    $valoresAnteriores,
                    $codigo,
                    $titulo
                ) {
                    AuditoriaService::registrar(
                        modulo: 'Convocatorias',
                        accion: 'eliminar',
                        modelo: $convocatoria,
                        valoresAnteriores: $valoresAnteriores,
                        valoresNuevos: null,
                        descripcion: sprintf(
                            'Se eliminó la convocatoria %s: "%s".',
                            $codigo,
                            $titulo
                        )
                    );

                    $convocatoria->delete();
                }
            );

            return redirect()
                ->route(
                    'admin.convocatorias.index'
                )
                ->with(
                    'mensaje',
                    'La convocatoria fue eliminada correctamente.'
                );
        } catch (Throwable $error) {
            report($error);

            return back()->with(
                'error',
                'No se pudo eliminar la convocatoria.'
            );
        }
    }

    private function validarConvocatoria(
        Request $request
    ): array {
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
                'tipo.required' =>
                'Selecciona el tipo de convocatoria.',

                'tipo.in' =>
                'El tipo seleccionado no es válido.',

                'titulo.required' =>
                'Ingresa el título de la convocatoria.',

                'descripcion.required' =>
                'Ingresa la descripción.',

                'vacantes.required' =>
                'Ingresa el número de vacantes.',

                'vacantes.min' =>
                'Debe existir al menos una vacante.',

                'fecha_inicio.required' =>
                'Selecciona la fecha de inicio.',

                'fecha_cierre.required' =>
                'Selecciona la fecha de cierre.',

                'fecha_cierre.after_or_equal' =>
                'La fecha de cierre debe ser igual o posterior al inicio.',

                'estado.required' =>
                'Selecciona el estado.',
            ]
        );
    }

    private function generarCodigo(): string
    {
        do {
            $codigo = 'CONV-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(
                    Str::random(5)
                );
        } while (
            Convocatoria::query()
            ->where(
                'codigo',
                $codigo
            )
            ->exists()
        );

        return $codigo;
    }

    private function datosAuditoria(
        Convocatoria $convocatoria
    ): array {
        return [
            'id' =>
            $convocatoria->id,

            'codigo' =>
            $convocatoria->codigo,

            'area_id' =>
            $convocatoria->area_id,

            'cargo_id' =>
            $convocatoria->cargo_id,

            'usuario_id' =>
            $convocatoria->usuario_id,

            'tipo' =>
            $convocatoria->tipo,

            'titulo' =>
            $convocatoria->titulo,

            'descripcion' =>
            $convocatoria->descripcion,

            'perfil' =>
            $convocatoria->perfil,

            'requisitos' =>
            $convocatoria->requisitos,

            'cronograma' =>
            $convocatoria->cronograma,

            'vacantes' =>
            $convocatoria->vacantes,

            'fecha_inicio' =>
            $convocatoria->fecha_inicio,

            'fecha_cierre' =>
            $convocatoria->fecha_cierre,

            'fecha_publicacion' =>
            $convocatoria->fecha_publicacion,

            'destacada' =>
            (bool) $convocatoria->destacada,

            'estado' =>
            $convocatoria->estado,

            'created_at' =>
            $convocatoria->created_at,

            'updated_at' =>
            $convocatoria->updated_at,
        ];
    }
}
