<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Postulacion extends Model
{
    protected $table = 'postulaciones';
    
    protected $fillable = [
        'convocatoria_id',
        'usuario_revisor_id',
        'codigo',
        'tipo_postulante',
        'nombres',
        'apellidos',
        'dni',
        'correo',
        'telefono',
        'direccion',
        'universidad',
        'carrera',
        'ciclo',
        'estado',
        'observacion',
        'fecha_revision',
    ];

    protected function casts(): array
    {
        return [
            'ciclo' => 'integer',
            'fecha_revision' => 'datetime',
        ];
    }

    public function convocatoria(): BelongsTo
    {
        return $this->belongsTo(Convocatoria::class);
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_revisor_id'
        );
    }
}