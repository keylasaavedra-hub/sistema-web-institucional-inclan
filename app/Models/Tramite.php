<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $fillable = [
        'codigo',
        'tipo_persona',
        'nombres',
        'apellidos',
        'razon_social',
        'tipo_documento_identidad',
        'numero_documento',
        'correo',
        'telefono',
        'direccion',
        'tipo_documento',
        'numero_documento_presentado',
        'asunto',
        'descripcion',
        'archivo_original',
        'archivo_ruta',
        'archivo_tamanio',
        'estado',
        'observacion',
        'fecha_atencion',
        'fecha_cierre',
    ];

    protected function casts(): array
    {
        return [
            'archivo_tamanio' => 'integer',
            'fecha_atencion' => 'datetime',
            'fecha_cierre' => 'datetime',
        ];
    }
}