<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Centros
 */
class Centro extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'telefono',
        'localidad',
        'provincia',
        'web',
        'email',
        'ubicacion'
    ];

    /**
     * Relación uno a uno con la tabla de responsables
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsable()
    {
        return $this->hasOne(Responsable::class);
    }

    /**
     * Relación uno a muchos con la tabla de dias
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dia()
    {
        return $this->hasMany(Dia::class);
    }
}
