<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfraestructuraAmbiente extends Model
{
    protected $table = 'infraestructura_ambientes';

    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'imagen',
        'icono',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    public function imagenes(): HasMany
    {
        return $this->hasMany(
            InfraestructuraImagen::class,
            'infraestructura_ambiente_id'
        )->orderBy('orden')->orderBy('id');
    }
}