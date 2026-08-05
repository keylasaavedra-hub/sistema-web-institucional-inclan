<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\Postulacion;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostulacionController extends Controller
{
    public function crear(
        Convocatoria $convocatoria
    ): View {
        abort_unless(
            $convocatoria->estado === 'publicada',
            404
        );

        abort_if(
            now()->lt($convocatoria->fecha_inicio),
            403,
            'La convocatoria todavía no ha iniciado.'
        );

        abort_if(
            now()->gt($convocatoria->fecha_cierre),
            403,
            'La convocatoria ya cerró.'
        );

        return view('postulaciones.crear', [
            'convocatoria' => $convocatoria,
        ]);
    }

    public function guardar(
        Request $request,
        Convocatoria $convocatoria
    ): RedirectResponse {
        abort_unless(
            $convocatoria->estado === 'publicada',
            404
        );

        abort_if(
            now()->lt($convocatoria->fecha_inicio)
                || now()->gt($convocatoria->fecha_cierre),
            422,
            'La convocatoria no se encuentra disponible.'
        );

        $datos = $request->validate(
            [
                'tipo_postulante' => [
                    'required',
                    'in:estudiante,egresado,profesional,otro',
                ],
                'nombres' => [
                    'required',
                    'string',
                    'max:120',
                ],
                'apellidos' => [
                    'required',
                    'string',
                    'max:120',
                ],
                'dni' => [
                    'required',
                    'digits:8',
                ],
                'correo' => [
                    'required',
                    'email',
                    'max:150',
                ],
                'telefono' => [
                    'nullable',
                    'string',
                    'max:20',
                ],
                'direccion' => [
                    'nullable',
                    'string',
                    'max:250',
                ],
                'universidad' => [
                    'nullable',
                    'string',
                    'max:200',
                ],
                'carrera' => [
                    'nullable',
                    'string',
                    'max:180',
                ],
                'ciclo' => [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:20',
                ],
            ],
            [
                'tipo_postulante.required' => 'Selecciona el tipo de postulante.',
                'nombres.required' => 'Ingresa tus nombres.',
                'apellidos.required' => 'Ingresa tus apellidos.',
                'dni.required' => 'Ingresa tu DNI.',
                'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
                'correo.required' => 'Ingresa tu correo.',
                'correo.email' => 'El correo ingresado no es válido.',
                'ciclo.min' => 'El ciclo debe ser mayor a cero.',
                'ciclo.max' => 'El ciclo no puede ser mayor a 20.',
            ]
        );

        $datos['convocatoria_id'] = $convocatoria->id;
        $datos['codigo'] = $this->generarCodigo();
        $datos['estado'] = 'recibida';

        try {
            $postulacion = Postulacion::create($datos);
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return back()
                    ->withInput()
                    ->withErrors([
                        'dni' => 'Este DNI ya registró una postulación en esta convocatoria.',
                    ]);
            }

            throw $exception;
        }

        return redirect()
            ->route('postulaciones.exito', $postulacion)
            ->with('postulacion_registrada', true);
    }

    public function exito(
        Postulacion $postulacion
    ): View {
        abort_unless(
            session('postulacion_registrada'),
            404
        );

        $postulacion->load('convocatoria');

        return view('postulaciones.exito', [
            'postulacion' => $postulacion,
        ]);
    }

    public function seguimiento(): View
    {
        return view('postulaciones.seguimiento');
    }

    public function consultar(
        Request $request
    ): View {
        $datos = $request->validate(
            [
                'codigo' => [
                    'required',
                    'string',
                    'max:35',
                ],
                'identificador' => [
                    'required',
                    'string',
                    'max:150',
                ],
            ],
            [
                'codigo.required' => 'Ingresa el código de postulación.',
                'identificador.required' => 'Ingresa tu DNI o correo.',
            ]
        );

        $identificador = trim($datos['identificador']);

        $postulacion = Postulacion::query()
            ->with('convocatoria')
            ->where('codigo', trim($datos['codigo']))
            ->where(function ($query) use ($identificador) {
                $query
                    ->where('dni', $identificador)
                    ->orWhere('correo', $identificador);
            })
            ->first();

        return view('postulaciones.seguimiento', [
            'postulacion' => $postulacion,
            'consultaRealizada' => true,
        ]);
    }

    public function resultados(
        Request $request
    ): View {
        $convocatorias = Convocatoria::query()
            ->whereIn('estado', ['publicada', 'cerrada'])
            ->whereHas(
                'postulaciones',
                fn($query) => $query->whereIn(
                    'estado',
                    ['apta', 'seleccionada']
                )
            )
            ->with([
                'postulaciones' => fn($query) => $query
                    ->whereIn('estado', ['apta', 'seleccionada'])
                    ->orderBy('apellidos')
                    ->orderBy('nombres'),
            ])
            ->when(
                $request->filled('convocatoria'),
                fn($query) => $query->where(
                    'id',
                    $request->convocatoria
                )
            )
            ->latest('fecha_cierre')
            ->get();

        return view('postulaciones.resultados', [
            'convocatorias' => $convocatorias,
        ]);
    }

    private function generarCodigo(): string
    {
        do {
            $codigo = 'POST-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(6));
        } while (
            Postulacion::query()
            ->where('codigo', $codigo)
            ->exists()
        );

        return $codigo;
    }
}
