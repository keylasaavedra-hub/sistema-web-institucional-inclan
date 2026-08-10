<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformacionInstitucional extends Model
{
    protected $table = 'informacion_institucional';

    protected $fillable = [
        'tipo',
        'titulo',
        'subtitulo',
        'contenido',
        'imagen',
        'datos',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'datos' => 'array',
        'estado' => 'boolean',
        'orden' => 'integer',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function scopeActivos($query)
    {
        return $query
            ->where('estado', true)
            ->orderBy('orden');
    }
}