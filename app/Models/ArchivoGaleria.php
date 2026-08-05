<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoGaleria extends Model
{
    use HasFactory;

    protected $table = 'archivos_galeria';

    protected $fillable = [
        'galeria_id',
        'tipo_archivo',
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

    public function galeria(): BelongsTo
    {
        return $this->belongsTo(Galeria::class, 'galeria_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeImagenes($query)
    {
        return $query->where('tipo_archivo', 'imagen');
    }
}