<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CentroController extends Controller
{
    //Vista publica de todos los centros asociados
    public function all(){
        $centros=Centro::all();
        return Inertia::render('Centros',['centros'=>$centros]);
    }

    //Vista del admin para el menu de gestion
    public function index(){
        return Inertia::render('Users/Admin/Centros/Index');
    }

    public function create(){

    }

    public function store(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function list(){

    }

    public function delete(){
        
    }

    public static function centrosSinResponsable(){

        $centros=Centro::whereNotIn('id', function($query){
            $query->select('centro_id')->from('responsables');
        })->get();

       return $centros;
    }
}
