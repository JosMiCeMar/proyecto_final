<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'email',
        'password',
    ];

    /**
     * Atributos que deben estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Relación uno a uno con la tabla de clientes
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    /**
     * Relación uno a uno con la tabla de responsables
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsable()
    {
        return $this->hasOne(Responsable::class);
    }

    /**
     * Relación uno a uno con la tabla de administradores
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administradore()
    {
        return $this->hasOne(Administradore::class);
    }

    /**
     * Relación uno a muchos con la tabla de codigos
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cod_registro()
    {
        return $this->hasMany(CodRegistro::class);
    }

    /**
     * Relación uno a muchos con la tabla de notificaciones (enviadas)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificacionesEnviadas()
    {
        return $this->hasMany(Notificacione::class, 'user_id_origen');
    }

    /**
     * Relación uno a muchos con la tabla de notificaciones (recibidas)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificacionesRecibidas()
    {
        return $this->hasMany(Notificacione::class, 'user_id_destino');
    }
}
