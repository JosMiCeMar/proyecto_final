<?php

namespace App\Traits;

use App\Models\Administradore;
use App\Models\Cliente;
use App\Models\Responsable;


trait TipoUsuario{

//Funcion para obtener el tipo de usuario
    public function obtenerTipoUsuario($id_usuario){

        $admin=Administradore::where('user_id',$id_usuario)->first();
        if($admin) return 'admin';

        $responsable=Responsable::where('user_id',$id_usuario)->first();
        if($responsable) return 'responsable';

        $cliente=Cliente::where('user_id',$id_usuario)->first();
        if($cliente) return 'cliente';
    }

    //Funcion para obtener los datos extra de los tipos de usuario responsable y cliente
    public function datosExtra($id_usuario){
        $responsable=Responsable::where('user_id',$id_usuario)->first();
        if($responsable) return ['centro'=>$responsable->centro_id];

        $cliente=Cliente::where('user_id',$id_usuario)->first();
        if($cliente) return ['condicion'=>$cliente->condicion_especial,'fecha_nac'=>$cliente->fecha_nacimiento];
    }
}