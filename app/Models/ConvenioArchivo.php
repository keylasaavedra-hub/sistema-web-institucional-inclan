<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConvenioArchivo extends Model
{
    protected $table = 'convenio_archivos';

    protected $fillable = [
        'convenio_id',
        'archivo',
        'tipo',
        'orden',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    public function convenio(): BelongsTo
    {
        return $this->belongsTo(
            Convenio::class,
            'convenio_id'
        );
    }
}