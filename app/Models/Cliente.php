<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Modelo de Clientes
 */
class Cliente extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'condicion_especial',
        'fecha_nacimiento'
    ];

    public $timestamps = false;

    /**
     * Verifica si el usuario actual es cliente
     * @return bool
     */
    public static function isClient(): bool
    {
         
        $userId = Auth::id();
        return self::where('user_id', $userId)->exists();
   }

    /**
     * Relación uno a uno con la tabla de usuarios
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos con la tabla de reservas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }
}
