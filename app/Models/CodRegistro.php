<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CodRegistro extends Model
{
    use HasFactory;

    protected $fillable=[
        'codigo',
        'id_creador',
        'para_cliente'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
