<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
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
}