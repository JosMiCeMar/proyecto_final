<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;

    protected $fillable=[
        'centro_id',
        'fecha'
    ];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function reserva(){
        return $this->hasMany(Reserva::class);
    }
}
