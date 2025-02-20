<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Modelo de Responsables
 */
class Responsable extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable=[
        'user_id',
        'centro_id'
    ];

    public $timestamps = false;

    /**
     * Comprueba si el usuario logueado es responsable
     * @return bool
     */
    public static function isRespons(): bool
    {  
        $userId = Auth::id();
        return self::where('user_id', $userId)->exists();
   }

    /**
     * Obtiene el centro asignado al responsable
     * @return Centro
     */
    public function getCentroAsignado(): Centro
    {
    return Centro::find($this->centro_id);
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
     * Relación uno a uno con la tabla de centros
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }


}
