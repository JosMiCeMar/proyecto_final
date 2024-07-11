<?php

namespace App\Http\Controllers;

use App\Models\Administradore;
use App\Models\CodRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AdministradoreController extends Controller
{
    //


    public function indexCode(){

        $user =session('status');

        return Inertia::render('Users/Admin/RegCode/Index',['usuario'=>$user]);
    }

    public function listCode(){

        $usados= CodRegistro::where('usado', true)->exists();

        $codigos=CodRegistro::orderByDesc('usado')->orderBy('para_cliente')->orderBy('created_at')->get();


       return Inertia::render('Users/Admin/RegCode/DelCode',['codigos'=>$codigos, 'usados'=>$usados]);

    }

    public function deleteCode(Request $request){
        $request->validate(['id'=>'required|integer']);
        
        $codigo = CodRegistro::find($request->id);
        
        if($codigo){
            $codigo->delete();
        }elseif(!$codigo && $request->id===0){
            CodRegistro::where('usado',true)->delete();
        }

        $this->listCode();
    }

    public function genCode(){
        return Inertia::render('Users/Admin/RegCode/GenCode');
    }

    public function showCode(Request $request){

        $request->validate(['type' => 'required|boolean'], [
            'type.required' => 'Debes seleccionar una de las opciones.',
            'type.boolean' => 'El tipo de dato introducido es incorrecto.',
        ]);

        $admin=new Administradore();
        $codigo=$admin->genCode($request->type);
        
        return Inertia::render('Users/Admin/RegCode/ShowCode',['codigo'=>$codigo,'tipo'=>boolval($request->type)]);
    }
}
