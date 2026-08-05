<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'codigo',
        'nombres',
        'apellidos',
        'dni',
        'correo',
        'telefono',
        'asunto',
        'mensaje',
        'estado',
        'respuesta',
        'respondido_en',
    ];

    protected function casts(): array
    {
        return [
            'respondido_en' => 'datetime',
        ];
    }
}