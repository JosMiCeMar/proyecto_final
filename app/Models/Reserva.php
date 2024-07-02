<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable=[
        'cliente_id',
        'zona_id',
        'dia_id',
        'hora_inicio',
        'hora_fin'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function dia()
    {
        return $this->belongsTo(Dia::class);
    }
}
