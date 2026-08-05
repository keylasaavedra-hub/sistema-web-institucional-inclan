<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'area_id',
        'estado',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(
            AreaInstitucional::class,
            'area_id'
        );
    }

    public function convocatorias(): HasMany
    {
        return $this->hasMany(Convocatoria::class);
    }
}