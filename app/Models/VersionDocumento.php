<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VersionDocumento extends Model
{
    use HasFactory;

    protected $table = 'versiones_documento';

    protected $fillable = [
        'documento_id',
        'usuario_id',
        'version',
        'archivo',
        'nombre_original',
        'tipo_archivo',
        'tamano_bytes',
        'descripcion_cambio',
    ];

    protected function casts(): array
    {
        return [
            'tamano_bytes' => 'integer',
        ];
    }

    public function documento(): BelongsTo
    {
        return $this->belongsTo(
            Documento::class,
            'documento_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
}