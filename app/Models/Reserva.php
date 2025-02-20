<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Reservas
 */
class Reserva extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable=[
        'cliente_id',
        'zona_id',
        'dia_id',
        'hora_inicio',
        'hora_fin'
    ];

    /**
     * Relación uno a muchos con la tabla de clientes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación uno a muchos con la tabla de zonas
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    /**
     * Relación uno a muchos con la tabla de días
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dia()
    {
        return $this->belongsTo(Dia::class);
    }
}
