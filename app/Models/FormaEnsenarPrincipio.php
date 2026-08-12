<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaEnsenarPrincipio extends Model
{
    protected $table = 'forma_ensenar_principios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',
        'imagen',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];
}