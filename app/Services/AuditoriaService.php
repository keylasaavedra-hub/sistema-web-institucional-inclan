<?php

namespace App\Services;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuditoriaService
{
    public static function registrar(
        string $modulo,
        string $accion,
        ?Model $modelo = null,
        ?array $valoresAnteriores = null,
        ?array $valoresNuevos = null,
        ?string $descripcion = null
    ): Auditoria {
        return Auditoria::create([
            'user_id' => Auth::id(),
            'modulo' => $modulo,
            'accion' => $accion,
            'tabla' => $modelo?->getTable(),
            'registro_id' => $modelo
                ? (string) $modelo->getKey()
                : null,
            'descripcion' => $descripcion,
            'valores_anteriores' => self::limpiarDatos(
                $valoresAnteriores
            ),
            'valores_nuevos' => self::limpiarDatos(
                $valoresNuevos
            ),
            'ip' => request()?->ip(),
            'user_agent' => Str::limit(
                (string) request()?->userAgent(),
                1000
            ),
        ]);
    }

    private static function limpiarDatos(?array $datos): ?array
    {
        if ($datos === null) {
            return null;
        }

        $camposSensibles = [
            'password',
            'remember_token',
            'token',
            'password_confirmation',
        ];

        foreach ($camposSensibles as $campo) {
            if (array_key_exists($campo, $datos)) {
                $datos[$campo] = '[PROTEGIDO]';
            }
        }

        return $datos;
    }
}