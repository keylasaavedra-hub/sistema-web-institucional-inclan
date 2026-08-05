<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'dni',
        'name',
        'apellidos',
        'email',
        'telefono',
        'password',
        'rol_id',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'estado' => 'boolean',
        ];
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function tienePermiso(string $codigo): bool
    {
        if (! $this->estado || ! $this->rol || ! $this->rol->estado) {
            return false;
        }

        return $this->rol
            ->permisos()
            ->where('permisos.codigo', $codigo)
            ->where('permisos.estado', true)
            ->exists();
    }

    public function esAdministrador(): bool
    {
        return $this->rol?->nombre === 'Administrador';
    }
}