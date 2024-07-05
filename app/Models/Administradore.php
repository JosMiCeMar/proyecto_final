<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerarCodigoAleatorio;
use Illuminate\Support\Facades\Auth;


class Administradore extends Model 
{
    use HasFactory;
    use GenerarCodigoAleatorio;
    

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generarCodigo(){
        $codigo= $this->crearCodigo();

        $inst_cod=new CodRegistro();

        $inst_cod->codigo=$codigo;
        $inst_cod->id_creador=Auth::id();
        $inst_cod->para_cliente=1;

        $inst_cod->save();

        return $codigo;
    }

}
