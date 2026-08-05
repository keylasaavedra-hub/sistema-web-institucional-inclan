<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelEducativo extends Model
{
    use HasFactory;

    protected $table = 'niveles_educativos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
        ];
    }

    public function promociones(): HasMany
    {
        return $this->hasMany(
            Promocion::class,
            'nivel_educativo_id'
        );
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }
}