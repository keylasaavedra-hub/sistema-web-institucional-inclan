<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenPromocion extends Model
{
    use HasFactory;

    protected $table = 'imagenes_promocion';

    protected $fillable = [
        'promocion_id',
        'ruta',
        'nombre_original',
        'mime_type',
        'tamano_bytes',
        'titulo',
        'descripcion',
        'orden',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'tamano_bytes' => 'integer',
            'orden' => 'integer',
            'estado' => 'boolean',
        ];
    }

    public function promocion(): BelongsTo
    {
        return $this->belongsTo(
            Promocion::class,
            'promocion_id'
        );
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }
}