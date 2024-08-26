<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

//Constante para definir el tamaño del código
define('LONGITUD_CODIGO', 8);

class CodRegistro extends Model
{
    use HasFactory;

    protected $fillable=[
        'codigo',
        'id_creador',
        'para_cliente'
    ];

    //Funcion estatica para generar el codigo aleatorio
    public static function crearCodigo()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $salida = '';

        for ($i = 0; $i < LONGITUD_CODIGO; $i++) {
            $salida .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $salida;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
