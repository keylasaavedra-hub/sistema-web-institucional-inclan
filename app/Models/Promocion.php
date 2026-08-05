<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';

    protected $fillable = [
        'nivel_educativo_id',
        'usuario_id',
        'nombre',
        'anio',
        'lema',
        'descripcion',
        'imagen_portada',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'estado' => 'boolean',
        ];
    }

    public function nivelEducativo(): BelongsTo
    {
        return $this->belongsTo(
            NivelEducativo::class,
            'nivel_educativo_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(
            ImagenPromocion::class,
            'promocion_id'
        )
            ->orderBy('orden')
            ->orderBy('id');
    }

    public function imagenesActivas(): HasMany
    {
        return $this->hasMany(
            ImagenPromocion::class,
            'promocion_id'
        )
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id');
    }

    public function scopePublicadas($query)
    {
        return $query->where('estado', true);
    }
}