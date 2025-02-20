<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Días
 */
class Dia extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable=[
        'centro_id',
        'fecha'
    ];

    /**
     * Relación uno a muchos con la tabla de centros
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    /**
     * Relación uno a muchos con la tabla de reservas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reserva(){
        return $this->hasMany(Reserva::class);
    }
}
