<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'categoria_publicacion_id',
        'usuario_id',
        'titulo',
        'slug',
        'contenido',
        'imagen_portada',
        'archivo_adjunto',
        'fecha_publicacion',
        'fecha_vencimiento',
        'destacada',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_publicacion' => 'datetime',
            'fecha_vencimiento' => 'datetime',
            'destacada' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            CategoriaPublicacion::class,
            'categoria_publicacion_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublicadas(Builder $query): Builder
    {
        return $query
            ->where('estado', 'publicado')
            ->where(function ($subquery) {
                $subquery
                    ->whereNull('fecha_publicacion')
                    ->orWhere('fecha_publicacion', '<=', now());
            })
            ->where(function ($subquery) {
                $subquery
                    ->whereNull('fecha_vencimiento')
                    ->orWhere('fecha_vencimiento', '>=', now());
            });
    }

    public function scopeDestacadas(Builder $query): Builder
    {
        return $query->where('destacada', true);
    }
}