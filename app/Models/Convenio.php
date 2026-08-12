<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = [
        'slug',
        'usuario_id',
        'nombre',
        'institucion',
        'tipo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'imagen',
        'archivo',
        'estado_texto',
        'objetivos',
        'beneficios',
        'orden',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'objetivos' => 'array',
        'beneficios' => 'array',
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    public function archivos(): HasMany
    {
        return $this->hasMany(
            ConvenioArchivo::class,
            'convenio_id'
        )
            ->orderBy('orden')
            ->orderBy('id');
    }
}