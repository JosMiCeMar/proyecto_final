<?php

namespace App\Traits;

use App\Models\Administradore;
use App\Models\Cliente;
use App\Models\Responsable;


trait TipoUsuario{


    public function obtenerTipoUsuario($id_usuario){

        $admin=Administradore::where('user_id',$id_usuario)->first();
        if($admin) return 'admin';

        $responsable=Responsable::where('user_id',$id_usuario)->first();
        if($responsable) return 'responsable';

        $cliente=Cliente::where('user_id',$id_usuario)->first();
        if($cliente) return 'cliente';
    }
}