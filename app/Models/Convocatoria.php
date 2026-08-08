<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Convocatoria extends Model
{
    protected $fillable = [
        'area_id',
        'cargo_id',
        'usuario_id',
        'codigo',
        'tipo',
        'titulo',
        'descripcion',
        'perfil',
        'requisitos',
        'cronograma',
        'vacantes',
        'fecha_inicio',
        'fecha_cierre',
        'fecha_publicacion',
        'estado',
        'destacada',
        'resultados_publicados',
        'fecha_publicacion_resultados',
    ];

    protected function casts(): array
    {
        return [
            'vacantes' => 'integer',
            'fecha_inicio' => 'datetime',
            'fecha_cierre' => 'datetime',
            'fecha_publicacion' => 'datetime',
            'destacada' => 'boolean',
            'resultados_publicados' => 'boolean',
            'fecha_publicacion_resultados' => 'datetime',
        ];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(
            AreaInstitucional::class,
            'area_id'
        );
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class);
    }
}
