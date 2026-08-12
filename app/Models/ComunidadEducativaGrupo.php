<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComunidadEducativaGrupo extends Model
{
    protected $table = 'comunidad_educativa_grupos';

    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'imagen',
        'icono',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];
}