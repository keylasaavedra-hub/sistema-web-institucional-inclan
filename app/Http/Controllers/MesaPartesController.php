<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class MesaPartesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE MESA DE PARTES
    |--------------------------------------------------------------------------
    */

    public function crear(): View
    {
        return view('mesa-partes.crear');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTRAR TRÁMITE
    |--------------------------------------------------------------------------
    */

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            [
                'tipo_persona' => [
                    'required',
                    'in:natural,juridica',
                ],

                'nombres' => [
                    'required_if:tipo_persona,natural',
                    'nullable',
                    'string',
                    'max:100',
                ],

                'apellidos' => [
                    'required_if:tipo_persona,natural',
                    'nullable',
                    'string',
                    'max:100',
                ],

                'razon_social' => [
                    'required_if:tipo_persona,juridica',
                    'nullable',
                    'string',
                    'max:180',
                ],

                'tipo_documento_identidad' => [
                    'required',
                    'in:dni,ce,ruc,pasaporte',
                ],

                'numero_documento' => [
                    'required',
                    'string',
                    'max:20',
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

                'tipo_documento' => [
                    'required',
                    'string',
                    'max:80',
                ],

                'numero_documento_presentado' => [
                    'nullable',
                    'string',
                    'max:50',
                ],

                'asunto' => [
                    'required',
                    'string',
                    'max:200',
                ],

                'descripcion' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],

                'archivo' => [
                    'required',
                    'file',
                    'mimes:pdf',
                    'max:10240',
                ],
            ],
            [
                'tipo_persona.required' => 'Selecciona el tipo de persona.',
                'tipo_persona.in' => 'El tipo de persona seleccionado no es válido.',

                'nombres.required_if' => 'Ingresa los nombres del remitente.',
                'nombres.max' => 'Los nombres no pueden superar los 100 caracteres.',

                'apellidos.required_if' => 'Ingresa los apellidos del remitente.',
                'apellidos.max' => 'Los apellidos no pueden superar los 100 caracteres.',

                'razon_social.required_if' => 'Ingresa la razón social.',
                'razon_social.max' => 'La razón social no puede superar los 180 caracteres.',

                'tipo_documento_identidad.required' => 'Selecciona el tipo de documento de identidad.',
                'tipo_documento_identidad.in' => 'El tipo de documento seleccionado no es válido.',

                'numero_documento.required' => 'Ingresa el número de documento.',
                'numero_documento.max' => 'El número de documento no puede superar los 20 caracteres.',

                'correo.required' => 'Ingresa el correo electrónico.',
                'correo.email' => 'Ingresa un correo electrónico válido.',
                'correo.max' => 'El correo no puede superar los 150 caracteres.',

                'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

                'direccion.max' => 'La dirección no puede superar los 250 caracteres.',

                'tipo_documento.required' => 'Selecciona el tipo de documento presentado.',
                'tipo_documento.max' => 'El tipo de documento no puede superar los 80 caracteres.',

                'numero_documento_presentado.max' => 'El número del documento presentado no puede superar los 50 caracteres.',

                'asunto.required' => 'Ingresa el asunto del trámite.',
                'asunto.max' => 'El asunto no puede superar los 200 caracteres.',

                'descripcion.max' => 'La descripción no puede superar los 3000 caracteres.',

                'archivo.required' => 'Adjunta el documento en formato PDF.',
                'archivo.file' => 'El archivo adjunto no es válido.',
                'archivo.mimes' => 'El documento debe estar en formato PDF.',
                'archivo.max' => 'El documento no puede superar los 10 MB.',
            ]
        );

        $numeroDocumento = trim(
            (string) $datos['numero_documento']
        );

        if (
            $datos['tipo_documento_identidad'] === 'dni'
            && ! preg_match('/^\d{8}$/', $numeroDocumento)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'numero_documento' =>
                    'El DNI debe contener exactamente 8 dígitos.',
                ]);
        }

        if (
            $datos['tipo_documento_identidad'] === 'ruc'
            && ! preg_match('/^\d{11}$/', $numeroDocumento)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'numero_documento' =>
                    'El RUC debe contener exactamente 11 dígitos.',
                ]);
        }

        $datos['numero_documento'] = $numeroDocumento;

        $archivo = $request->file('archivo');
        $codigo = $this->generarCodigo();

        $nombreBase = Str::slug(
            pathinfo(
                $archivo->getClientOriginalName(),
                PATHINFO_FILENAME
            )
        );

        $nombreBase = $nombreBase !== ''
            ? $nombreBase
            : 'documento';

        $nombreArchivo = $codigo
            . '-'
            . $nombreBase
            . '.pdf';

        $rutaArchivo = $archivo->storeAs(
            'mesa-partes',
            $nombreArchivo,
            'local'
        );

        try {
            $tramite = Tramite::create([
                'codigo' => $codigo,
                'tipo_persona' => $datos['tipo_persona'],

                'nombres' => $datos['tipo_persona'] === 'natural'
                    ? $datos['nombres']
                    : null,

                'apellidos' => $datos['tipo_persona'] === 'natural'
                    ? $datos['apellidos']
                    : null,

                'razon_social' => $datos['tipo_persona'] === 'juridica'
                    ? $datos['razon_social']
                    : null,

                'tipo_documento_identidad' => $datos['tipo_documento_identidad'],
                'numero_documento' => $datos['numero_documento'],
                'correo' => strtolower(trim($datos['correo'])),
                'telefono' => $datos['telefono'] ?? null,
                'direccion' => $datos['direccion'] ?? null,

                'tipo_documento' => $datos['tipo_documento'],
                'numero_documento_presentado' => $datos['numero_documento_presentado'] ?? null,
                'asunto' => $datos['asunto'],
                'descripcion' => $datos['descripcion'] ?? null,

                'archivo_original' => $archivo->getClientOriginalName(),
                'archivo_ruta' => $rutaArchivo,
                'archivo_tamanio' => $archivo->getSize(),

                'estado' => 'recibido',
            ]);
        } catch (\Throwable $error) {
            Storage::disk('local')->delete($rutaArchivo);

            throw $error;
        }

        return redirect()
            ->route('mesa-partes.crear')
            ->with([
                'tramite_enviado' => true,
                'codigo_tramite' => $tramite->codigo,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR SEGUIMIENTO
    |--------------------------------------------------------------------------
    */

    public function seguimiento(): View
    {
        return view('mesa-partes.seguimiento');
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR SEGUIMIENTO
    |--------------------------------------------------------------------------
    */

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

        $tramite = Tramite::query()
            ->where('codigo', $codigo)
            ->whereRaw('LOWER(correo) = ?', [$correo])
            ->first();

        return view('mesa-partes.seguimiento', [
            'tramite' => $tramite,
            'busquedaRealizada' => true,
            'codigoBuscado' => $codigo,
            'correoBuscado' => $datos['correo'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENERAR CÓDIGO ÚNICO
    |--------------------------------------------------------------------------
    */

    private function generarCodigo(): string
    {
        do {
            $codigo = 'MDP-'
                . now()->format('Ymd')
                . '-'
                . strtoupper(Str::random(5));
        } while (
            Tramite::where('codigo', $codigo)->exists()
        );

        return $codigo;
    }
}
