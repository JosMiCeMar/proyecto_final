<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relacion con clientes 1-1
    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    // Relacion con responsables 1-1
    public function responsable()
    {
        return $this->hasOne(Responsable::class);
    }

    // Relacion con administradores 1-1
    public function administradore()
    {
        return $this->hasOne(Administradore::class);
    }

    // Relaciones con codigos de registro 1 - N
    public function cod_registro()
    {
        return $this->hasMany(CodRegistro::class);
    }

    // Relaciones con las notificaciones enviadas 1 - N
    public function notificacionesEnviadas()
    {
        return $this->hasMany(Notificacione::class, 'user_id_origen');
    }

    // Relaciones con las notificaciones recibidas 1 - N
    public function notificacionesRecibidas()
    {
        return $this->hasMany(Notificacione::class, 'user_id_destino');
    }
}
