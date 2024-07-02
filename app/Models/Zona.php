<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $fillable=[
        'nombre',
        'precio',
        'tiempo_estimado'
    ];

    public function reserva(){
        return $this->hasMany(Reserva::class);
    }
}
