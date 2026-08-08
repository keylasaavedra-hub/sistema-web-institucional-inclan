<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ConsultaController extends Controller
{
    public function index(Request $request): View
    {
        $consultas = Consulta::query()
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim((string) $request->buscar);

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
                fn ($query) => $query->where(
                    'estado',
                    $request->estado
                )
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.consultas.index', [
            'consultas' => $consultas,
        ]);
    }

    public function mostrar(
        Consulta $consulta
    ): View {
        return view('admin.consultas.mostrar', [
            'consulta' => $consulta,
        ]);
    }

    public function actualizar(
        Request $request,
        Consulta $consulta
    ): RedirectResponse {
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
                'estado.required' =>
                    'Selecciona el estado.',

                'estado.in' =>
                    'El estado seleccionado no es válido.',

                'respuesta.max' =>
                    'La respuesta no puede superar los 3000 caracteres.',
            ]
        );

        $valoresAnteriores = $this->datosAuditoria(
            $consulta
        );

        $estadoAnterior = $consulta->estado;
        $respuestaAnterior = $consulta->respuesta;

        DB::beginTransaction();

        try {
            $consulta->estado = $datos['estado'];
            $consulta->respuesta = $datos['respuesta'] ?? null;

            $tieneRespuesta = filled(
                $datos['respuesta'] ?? null
            );

            if ($tieneRespuesta) {
                $consulta->respondido_en = now();

                if ($consulta->estado === 'recibida') {
                    $consulta->estado = 'respondida';
                }
            }

            $consulta->save();
            $consulta->refresh();

            $estadoCambio =
                $estadoAnterior !== $consulta->estado;

            $respuestaCambio =
                $respuestaAnterior !== $consulta->respuesta;

            $accion = 'actualizar';

            if ($respuestaCambio && $tieneRespuesta) {
                $accion = 'responder';
            } elseif ($estadoCambio) {
                $accion = 'cambiar_estado';
            }

            $descripcion = sprintf(
                'Se actualizó la consulta %s.',
                $consulta->codigo
            );

            if ($respuestaCambio && $tieneRespuesta) {
                $descripcion = sprintf(
                    'Se registró o actualizó la respuesta de la consulta %s.',
                    $consulta->codigo
                );
            } elseif ($estadoCambio) {
                $descripcion = sprintf(
                    'La consulta %s cambió de estado de %s a %s.',
                    $consulta->codigo,
                    $estadoAnterior,
                    $consulta->estado
                );
            }

            AuditoriaService::registrar(
                modulo: 'Consultas',
                accion: $accion,
                modelo: $consulta,
                valoresAnteriores:
                    $valoresAnteriores,
                valoresNuevos:
                    $this->datosAuditoria(
                        $consulta
                    ),
                descripcion: $descripcion
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.consultas.mostrar',
                    $consulta->id
                )
                ->with(
                    'mensaje',
                    'La consulta fue actualizada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la consulta.'
                );
        }
    }

    private function datosAuditoria(
        Consulta $consulta
    ): array {
        return [
            'id' =>
                $consulta->id,

            'codigo' =>
                $consulta->codigo,

            'nombres' =>
                $consulta->nombres,

            'apellidos' =>
                $consulta->apellidos,

            'correo' =>
                $consulta->correo,

            'telefono' =>
                $consulta->telefono,

            'asunto' =>
                $consulta->asunto,

            'mensaje' =>
                $consulta->mensaje,

            'estado' =>
                $consulta->estado,

            'respuesta' =>
                $consulta->respuesta,

            'respondido_en' =>
                $consulta->respondido_en,

            'created_at' =>
                $consulta->created_at,

            'updated_at' =>
                $consulta->updated_at,
        ];
    }
}