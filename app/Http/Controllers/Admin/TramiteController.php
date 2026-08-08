<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class TramiteController extends Controller
{
    public function index(Request $request): View
    {
        $tramites = Tramite::query()
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim((string) $request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('codigo', 'like', "%{$buscar}%")
                            ->orWhere('nombres', 'like', "%{$buscar}%")
                            ->orWhere('apellidos', 'like', "%{$buscar}%")
                            ->orWhere('razon_social', 'like', "%{$buscar}%")
                            ->orWhere('numero_documento', 'like', "%{$buscar}%")
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

        return view('admin.tramites.index', [
            'tramites' => $tramites,
        ]);
    }

    public function mostrar(
        Tramite $tramite
    ): View {
        return view('admin.tramites.mostrar', [
            'tramite' => $tramite,
        ]);
    }

    public function actualizar(
        Request $request,
        Tramite $tramite
    ): RedirectResponse {
        $datos = $request->validate(
            [
                'estado' => [
                    'required',
                    'in:recibido,en_revision,derivado,observado,atendido,cerrado',
                ],

                'observacion' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],
            ],
            [
                'estado.required' =>
                    'Selecciona el estado del trámite.',

                'estado.in' =>
                    'El estado seleccionado no es válido.',

                'observacion.max' =>
                    'La observación no puede superar los 3000 caracteres.',
            ]
        );

        $valoresAnteriores = $this->datosAuditoria(
            $tramite
        );

        $estadoAnterior = $tramite->estado;
        $observacionAnterior = $tramite->observacion;

        DB::beginTransaction();

        try {
            $tramite->estado = $datos['estado'];

            $tramite->observacion =
                $datos['observacion'] ?? null;

            if (
                in_array(
                    $tramite->estado,
                    [
                        'atendido',
                        'cerrado',
                    ],
                    true
                )
            ) {
                $tramite->fecha_atencion ??= now();
            }

            if ($tramite->estado === 'cerrado') {
                $tramite->fecha_cierre ??= now();
            } else {
                $tramite->fecha_cierre = null;
            }

            $tramite->save();
            $tramite->refresh();

            $estadoCambio =
                $estadoAnterior !== $tramite->estado;

            $observacionCambio =
                $observacionAnterior !== $tramite->observacion;

            $accion = 'actualizar';

            if ($estadoCambio) {
                $accion = match ($tramite->estado) {
                    'atendido' => 'atender',
                    'cerrado' => 'cerrar',
                    default => 'cambiar_estado',
                };
            } elseif ($observacionCambio) {
                $accion = 'actualizar_observacion';
            }

            $descripcion = sprintf(
                'Se actualizó el trámite %s.',
                $tramite->codigo
            );

            if ($estadoCambio) {
                $descripcion = match ($tramite->estado) {
                    'atendido' => sprintf(
                        'El trámite %s fue marcado como atendido.',
                        $tramite->codigo
                    ),

                    'cerrado' => sprintf(
                        'El trámite %s fue cerrado.',
                        $tramite->codigo
                    ),

                    default => sprintf(
                        'El trámite %s cambió de estado de %s a %s.',
                        $tramite->codigo,
                        $estadoAnterior,
                        $tramite->estado
                    ),
                };
            } elseif ($observacionCambio) {
                $descripcion = sprintf(
                    'Se actualizó la observación del trámite %s.',
                    $tramite->codigo
                );
            }

            AuditoriaService::registrar(
                modulo: 'Trámites',
                accion: $accion,
                modelo: $tramite,
                valoresAnteriores:
                    $valoresAnteriores,
                valoresNuevos:
                    $this->datosAuditoria(
                        $tramite
                    ),
                descripcion: $descripcion
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.tramites.mostrar',
                    $tramite->id
                )
                ->with(
                    'mensaje',
                    'El trámite fue actualizado correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar el trámite.'
                );
        }
    }

    public function descargar(
        Tramite $tramite
    ): StreamedResponse {
        abort_unless(
            filled($tramite->archivo_ruta),
            404,
            'El trámite no tiene un archivo adjunto.'
        );

        abort_unless(
            Storage::disk('local')->exists(
                $tramite->archivo_ruta
            ),
            404,
            'El archivo adjunto no fue encontrado.'
        );

        $nombreDescarga = $tramite->archivo_original
            ?: "tramite-{$tramite->codigo}.pdf";

        return Storage::disk('local')->download(
            $tramite->archivo_ruta,
            $nombreDescarga
        );
    }

    private function datosAuditoria(
        Tramite $tramite
    ): array {
        return [
            'id' =>
                $tramite->id,

            'codigo' =>
                $tramite->codigo,

            'tipo_persona' =>
                $tramite->tipo_persona,

            'tipo_documento' =>
                $tramite->tipo_documento,

            'numero_documento' =>
                $tramite->numero_documento,

            'nombres' =>
                $tramite->nombres,

            'apellidos' =>
                $tramite->apellidos,

            'razon_social' =>
                $tramite->razon_social,

            'correo' =>
                $tramite->correo,

            'telefono' =>
                $tramite->telefono,

            'asunto' =>
                $tramite->asunto,

            'descripcion' =>
                $tramite->descripcion,

            'archivo_original' =>
                $tramite->archivo_original,

            'estado' =>
                $tramite->estado,

            'observacion' =>
                $tramite->observacion,

            'fecha_atencion' =>
                $tramite->fecha_atencion,

            'fecha_cierre' =>
                $tramite->fecha_cierre,

            'created_at' =>
                $tramite->created_at,

            'updated_at' =>
                $tramite->updated_at,
        ];
    }
}