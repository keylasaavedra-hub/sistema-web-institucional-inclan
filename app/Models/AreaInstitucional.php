<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaInstitucional extends Model
{
    protected $table = 'areas_institucionales';

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

    public function documentos(): HasMany
    {
        return $this->hasMany(
            Documento::class,
            'area_id'
        );
    }
}