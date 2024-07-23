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
        return Inertia::render('Users/Admin/Centros/formCenter');
    }

    public function store(Request $request){

        $centro = new Centro();
        $centro->nombre=$request->name;
        $centro->direccion=$request->address;
        $centro->provincia=$request->province;
        $centro->localidad=$request->town;
        $centro->telefono=$request->tel;
        $centro->web=$request->web;
        $centro->ubicacion=$request->location;

        $centro->save();

        return redirect(route('admin.indexCenter'));
    }

    public function list(){
        $centros=Centro::select('id','nombre','direccion','localidad','provincia','telefono')->get();
        return Inertia::render('Users/Admin/Centros/TableCenter',['centros'=>$centros]);
    }

    public function mod(){

    }

    public function update(){

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
