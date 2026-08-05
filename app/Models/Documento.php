<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'categoria_documento_id',
        'area_id',
        'usuario_id',
        'titulo',
        'descripcion',
        'archivo',
        'nombre_original',
        'tipo_archivo',
        'tamano_bytes',
        'version',
        'fecha_publicacion',
        'es_publico',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_publicacion' => 'date',
            'es_publico' => 'boolean',
            'tamano_bytes' => 'integer',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            CategoriaDocumento::class,
            'categoria_documento_id'
        );
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(
            AreaInstitucional::class,
            'area_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function versiones(): HasMany
    {
        return $this->hasMany(
            VersionDocumento::class,
            'documento_id'
        )
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePublicos($query)
    {
        return $query
            ->where('es_publico', true)
            ->where('estado', 'activo');
    }
}