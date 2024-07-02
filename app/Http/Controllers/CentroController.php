<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    //

    public static function centrosSinResponsable(){

        $centros=Centro::whereNotIn('id', function($query){
            $query->select('centro_id')->from('responsables');
        })->get();

       return $centros;
    }
}
