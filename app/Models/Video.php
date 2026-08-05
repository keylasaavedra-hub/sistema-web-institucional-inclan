<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'descripcion',
        'url_youtube',
        'youtube_id',
        'miniatura',
        'categoria',
        'fecha_publicacion',
        'orden',
        'destacado',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_publicacion' => 'date',
            'orden' => 'integer',
            'destacado' => 'boolean',
            'estado' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function scopePublicados($query)
    {
        return $query->where('estado', true);
    }

    public function scopeDestacados($query)
    {
        return $query
            ->where('estado', true)
            ->where('destacado', true);
    }

    public function getUrlMiniaturaAttribute(): string
    {
        if ($this->miniatura) {
            return asset('storage/' . $this->miniatura);
        }

        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }

        return asset('images/portada-institucion.jpg');
    }

    public function getUrlInsercionAttribute(): ?string
    {
        if (!$this->youtube_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }
}