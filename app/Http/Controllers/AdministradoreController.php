<?php

namespace App\Http\Controllers;

use App\Models\Administradore;
use Illuminate\Http\Request;
use Inertia\Inertia;


class AdministradoreController extends Controller
{
    //
    public function genCode(){
        return Inertia::render('Users/Admin/GenCode');
    }

    public function showCode(Request $request){

        $request->validate(['type' => 'required|boolean'], [
            'type.required' => 'Debes seleccionar una de las opciones.',
            'type.boolean' => 'El tipo de dato introducido es incorrecto.',
        ]);

        $admin=new Administradore();
        $codigo=$admin->genCode($request->type);
        
        return Inertia::render('Users/Admin/ShowCode',['codigo'=>$codigo,'tipo'=>$request->type]);
    }
}
