<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'descripcion',
        'tipo',
        'anio',
        'imagen_portada',
        'orden',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'orden' => 'integer',
            'estado' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoGaleria::class, 'galeria_id')
            ->orderBy('orden')
            ->orderBy('id');
    }

    public function archivosActivos(): HasMany
    {
        return $this->hasMany(ArchivoGaleria::class, 'galeria_id')
            ->where('estado', true)
            ->orderBy('orden')
            ->orderBy('id');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }

    public function scopeFotografias($query)
    {
        return $query->where('tipo', 'fotografias');
    }
}