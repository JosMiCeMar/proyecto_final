<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CentroController extends Controller
{
    //
    public function all(){
        $centros=Centro::all();
        return Inertia::render('Centros',['centros'=>$centros]);
    }

    public static function centrosSinResponsable(){

        $centros=Centro::whereNotIn('id', function($query){
            $query->select('centro_id')->from('responsables');
        })->get();

       return $centros;
    }
}
