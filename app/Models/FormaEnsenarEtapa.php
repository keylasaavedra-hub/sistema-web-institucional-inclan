<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaEnsenarEtapa extends Model
{
    protected $table = 'forma_ensenar_etapas';

    protected $fillable = [
        'numero',
        'titulo',
        'descripcion',
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