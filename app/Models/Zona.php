<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Zonas
 */
class Zona extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable=[
        'nombre',
        'precio',
        'tiempo_estimado'
    ];

    /**
     * Relación uno a muchos con la tabla de reservas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reserva(){
        return $this->hasMany(Reserva::class);
    }
}
