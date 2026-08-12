<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfraestructuraImagen extends Model
{
    protected $table = 'infraestructura_imagenes';

    protected $fillable = [
        'infraestructura_ambiente_id',
        'imagen',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(
            InfraestructuraAmbiente::class,
            'infraestructura_ambiente_id'
        );
    }
}