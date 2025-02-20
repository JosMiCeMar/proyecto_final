<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Modelo de Administradores
 */
class Administradore extends Model 
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    public $timestamps = false;

    /**
     * Verifica si el usuario actual es administrador
     * @return bool
     */
    public static function isAdmin(): bool
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



}
