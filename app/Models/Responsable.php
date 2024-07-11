<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerarCodigoAleatorio;
use Illuminate\Support\Facades\Auth;

class Responsable extends Model
{
    use HasFactory;
    use GenerarCodigoAleatorio;

    protected $fillable=[
        'user_id',
        'centro_id'
    ];

    public static function isRespons(){
         
        $userId = Auth::id();
        return self::where('user_id', $userId)->exists();
   }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function genCode(){
        $codigo= $this->crearCodigo();

        $inst_cod=new CodRegistro();

        $inst_cod->codigo=$codigo;
        $inst_cod->id_creador=Auth::id();
        $inst_cod->para_cliente=true;

        $inst_cod->save();

        return $codigo;
    }

}
