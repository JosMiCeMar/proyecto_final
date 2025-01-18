<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacione extends Model
{
    use HasFactory;

    //Relación con el usuario que crea la notificación
    public function origen()
    {
        return $this->belongsTo(User::class, 'user_id_origen');
    }

    // Relación con el usuario que recibe la notificación
    public function destino()
    {
        return $this->belongsTo(User::class, 'user_id_destino');
    }

}
