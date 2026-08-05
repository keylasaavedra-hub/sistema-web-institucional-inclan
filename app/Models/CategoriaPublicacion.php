<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaPublicacion extends Model
{
    use HasFactory;

    protected $table = 'categorias_publicacion';

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

    public function publicaciones(): HasMany
    {
        return $this->hasMany(
            Publicacion::class,
            'categoria_publicacion_id'
        );
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }
}