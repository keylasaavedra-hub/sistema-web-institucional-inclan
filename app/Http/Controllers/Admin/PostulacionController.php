<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\Postulacion;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

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
                                    'nombres',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'apellidos',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'dni',
                                    'like',
                                    "%{$buscar}%"
                                )
                                ->orWhere(
                                    'correo',
                                    'like',
                                    "%{$buscar}%"
                                );
                        }
                    );
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
            ->select(
                'id',
                'codigo',
                'titulo'
            )
            ->whereHas('postulaciones')
            ->latest('id')
            ->get();

        $estadisticas = [
            'total' =>
                Postulacion::query()->count(),

            'recibidas' =>
                Postulacion::query()
                    ->where(
                        'estado',
                        'recibida'
                    )
                    ->count(),

            'revision' =>
                Postulacion::query()
                    ->where(
                        'estado',
                        'en_revision'
                    )
                    ->count(),

            'observadas' =>
                Postulacion::query()
                    ->where(
                        'estado',
                        'observada'
                    )
                    ->count(),

            'aptas' =>
                Postulacion::query()
                    ->where(
                        'estado',
                        'apta'
                    )
                    ->count(),

            'seleccionadas' =>
                Postulacion::query()
                    ->where(
                        'estado',
                        'seleccionada'
                    )
                    ->count(),
        ];

        return view(
            'admin.postulaciones.index',
            [
                'postulaciones' =>
                    $postulaciones,

                'convocatorias' =>
                    $convocatorias,

                'estadisticas' =>
                    $estadisticas,
            ]
        );
    }

    public function mostrar(
        Postulacion $postulacion
    ): View {
        $postulacion->load([
            'convocatoria.area',
            'convocatoria.cargo',
            'revisor',
        ]);

        return view(
            'admin.postulaciones.mostrar',
            [
                'postulacion' =>
                    $postulacion,
            ]
        );
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
                'estado.required' =>
                    'Selecciona el estado de la postulación.',

                'estado.in' =>
                    'El estado seleccionado no es válido.',

                'observacion.max' =>
                    'La observación no puede superar los 5000 caracteres.',
            ]
        );

        $valoresAnteriores =
            $this->datosAuditoria(
                $postulacion
            );

        $estadoAnterior =
            $postulacion->estado;

        $observacionAnterior =
            $postulacion->observacion;

        DB::beginTransaction();

        try {
            $datos['usuario_revisor_id'] =
                auth()->id();

            $datos['fecha_revision'] =
                now();

            $postulacion->update(
                $datos
            );

            $postulacion->refresh();

            $estadoCambio =
                $estadoAnterior
                !== $postulacion->estado;

            $observacionCambio =
                $observacionAnterior
                !== $postulacion->observacion;

            $accion = 'actualizar';

            if ($estadoCambio) {
                $accion = match (
                    $postulacion->estado
                ) {
                    'apta' =>
                        'marcar_apta',

                    'no_apta' =>
                        'marcar_no_apta',

                    'seleccionada' =>
                        'seleccionar',

                    default =>
                        'cambiar_estado',
                };
            } elseif ($observacionCambio) {
                $accion =
                    'actualizar_observacion';
            }

            $descripcion = sprintf(
                'Se actualizó la postulación %s.',
                $postulacion->codigo
            );

            if ($estadoCambio) {
                $descripcion = match (
                    $postulacion->estado
                ) {
                    'apta' =>
                        sprintf(
                            'La postulación %s fue marcada como apta.',
                            $postulacion->codigo
                        ),

                    'no_apta' =>
                        sprintf(
                            'La postulación %s fue marcada como no apta.',
                            $postulacion->codigo
                        ),

                    'seleccionada' =>
                        sprintf(
                            'La postulación %s fue seleccionada.',
                            $postulacion->codigo
                        ),

                    default =>
                        sprintf(
                            'La postulación %s cambió de estado de %s a %s.',
                            $postulacion->codigo,
                            $estadoAnterior,
                            $postulacion->estado
                        ),
                };
            } elseif ($observacionCambio) {
                $descripcion = sprintf(
                    'Se actualizó la observación de la postulación %s.',
                    $postulacion->codigo
                );
            }

            AuditoriaService::registrar(
                modulo: 'Postulaciones',
                accion: $accion,
                modelo: $postulacion,
                valoresAnteriores:
                    $valoresAnteriores,
                valoresNuevos:
                    $this->datosAuditoria(
                        $postulacion
                    ),
                descripcion: $descripcion
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.postulaciones.mostrar',
                    $postulacion->id
                )
                ->with(
                    'mensaje',
                    'La postulación fue actualizada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la postulación.'
                );
        }
    }

    private function datosAuditoria(
        Postulacion $postulacion
    ): array {
        return [
            'id' =>
                $postulacion->id,

            'codigo' =>
                $postulacion->codigo,

            'convocatoria_id' =>
                $postulacion->convocatoria_id,

            'nombres' =>
                $postulacion->nombres,

            'apellidos' =>
                $postulacion->apellidos,

            'dni' =>
                $postulacion->dni,

            'correo' =>
                $postulacion->correo,

            'telefono' =>
                $postulacion->telefono,

            'estado' =>
                $postulacion->estado,

            'observacion' =>
                $postulacion->observacion,

            'usuario_revisor_id' =>
                $postulacion->usuario_revisor_id,

            'fecha_revision' =>
                $postulacion->fecha_revision,

            'created_at' =>
                $postulacion->created_at,

            'updated_at' =>
                $postulacion->updated_at,
        ];
    }
}