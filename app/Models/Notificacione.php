<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Notificaciones
 */
class Notificacione extends Model
{
    use HasFactory;

    /**
     * Relación uno a muchos con la tabla de usuarios como origen
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function origen()
    {
        return $this->belongsTo(User::class, 'user_id_origen');
    }

    /**
     * Relación uno a muchos con la tabla de usuarios como destino
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destino()
    {
        return $this->belongsTo(User::class, 'user_id_destino');
    }

}
