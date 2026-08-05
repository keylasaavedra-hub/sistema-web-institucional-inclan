<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTRAR CONSULTA
    |--------------------------------------------------------------------------
    */

    public function crear(): View
    {
        return view('consultas.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            [
                'nombres' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'apellidos' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'dni' => [
                    'nullable',
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

                'asunto' => [
                    'required',
                    'string',
                    'max:180',
                ],

                'mensaje' => [
                    'required',
                    'string',
                    'max:3000',
                ],
            ],
            [
                'nombres.required' => 'Ingresa tus nombres.',
                'nombres.max' => 'Los nombres no pueden superar los 100 caracteres.',

                'apellidos.required' => 'Ingresa tus apellidos.',
                'apellidos.max' => 'Los apellidos no pueden superar los 100 caracteres.',

                'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',

                'correo.required' => 'Ingresa tu correo electrónico.',
                'correo.email' => 'Ingresa un correo electrónico válido.',
                'correo.max' => 'El correo no puede superar los 150 caracteres.',

                'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

                'asunto.required' => 'Ingresa el asunto de la consulta.',
                'asunto.max' => 'El asunto no puede superar los 180 caracteres.',

                'mensaje.required' => 'Escribe el detalle de tu consulta.',
                'mensaje.max' => 'La consulta no puede superar los 3000 caracteres.',
            ]
        );

        $datos['codigo'] = $this->generarCodigo();
        $datos['estado'] = 'recibida';

        $consulta = Consulta::create($datos);

        return redirect()
            ->route('consultas.crear')
            ->with([
                'consulta_enviada' => true,
                'codigo_consulta' => $consulta->codigo,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEGUIMIENTO DE CONSULTA
    |--------------------------------------------------------------------------
    */

    public function seguimiento(): View
    {
        return view('consultas.seguimiento');
    }

    public function consultarSeguimiento(Request $request): View
    {
        $datos = $request->validate(
            [
                'codigo' => [
                    'required',
                    'string',
                    'max:30',
                ],

                'correo' => [
                    'required',
                    'email',
                    'max:150',
                ],
            ],
            [
                'codigo.required' => 'Ingresa el código de seguimiento.',
                'codigo.max' => 'El código ingresado no es válido.',

                'correo.required' => 'Ingresa el correo electrónico.',
                'correo.email' => 'Ingresa un correo electrónico válido.',
                'correo.max' => 'El correo no puede superar los 150 caracteres.',
            ]
        );

        $codigo = strtoupper(trim($datos['codigo']));
        $correo = strtolower(trim($datos['correo']));

        $consulta = Consulta::query()
            ->where('codigo', $codigo)
            ->whereRaw('LOWER(correo) = ?', [$correo])
            ->first();

        return view('consultas.seguimiento', [
            'consulta' => $consulta,
            'busquedaRealizada' => true,
            'codigoBuscado' => $codigo,
            'correoBuscado' => $datos['correo'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENERAR CÓDIGO
    |--------------------------------------------------------------------------
    */

    private function generarCodigo(): string
    {
        do {
            $codigo = 'CON-'
                . now()->format('Ymd')
                . '-'
                . strtoupper(Str::random(5));
        } while (
            Consulta::where('codigo', $codigo)->exists()
        );

        return $codigo;
    }
}