<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'localidad',
        'provincia',
        'web',
        'email'
    ];

    public function responsable()
    {
        return $this->hasOne(Responsable::class);
    }

    public function dia()
    {
        return $this->hasMany(Dia::class);
    }
}
