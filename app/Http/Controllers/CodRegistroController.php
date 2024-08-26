<?php

namespace App\Http\Controllers;

use App\Models\CodRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class CodRegistroController extends Controller
{

    public function insertCode()
    {
        if (session()->has('cod') && session()->has('client')) {
            if (session()->get('client')) {
                return redirect()->route('cliente.create');
            }
            return redirect()->route('responsable.create');
        }

        return Inertia::render('Auth/InsertCode');
    }

    public function checkCode(Request $request)
    {
        $codigoRecibido = $request->validate([
            'code' => 'required|alpha_num|max:8',
        ]);

        $codigo = CodRegistro::where('codigo', $codigoRecibido)->where('usado',0)->first();

        $mensajeError = "El código introducido no es válido";

        if ($codigo) {
            session()->put(['cod' => $codigo->id, 'client' => $codigo->para_cliente]);
            $codigo->save();
            if ($codigo->para_cliente) {
                return redirect(route('cliente.create'));
            } else {
                return redirect(route('responsable.create'));
            }
        }

        return redirect(route('cod_registro.check'))->withErrors($mensajeError, 'error');
    }

    //Menu de gestion del administrador
    public function indexCodeAdmin(){

        $user =session('status');

        return Inertia::render('Users/Admin/RegCode/Index',['usuario'=>$user]);
    }

    //Lista de codigos para el administrador
    public function listCodeAdmin(){

        $usados= CodRegistro::where('usado', true)->exists();

        $codigos=CodRegistro::orderByDesc('usado')->orderBy('para_cliente')->orderBy('created_at')->get();


       return Inertia::render('Users/Admin/RegCode/DelCode',['codigos'=>$codigos, 'usados'=>$usados]);

    }

    //Funcion para eliminar codigos del administrador
    public function deleteCodeAdmin(Request $request){
        $request->validate(['id'=>'required|integer']);
        
        $codigo = CodRegistro::find($request->id);
        
        if($codigo){
            $codigo->delete();
        }elseif(!$codigo || $request->id===0){
            CodRegistro::where('usado',true)->delete();
        }
        return back();
    }

    //Vista del generador de codigos para el administrador
    public function genCodeAdmin(){
        return Inertia::render('Users/Admin/RegCode/GenCode');
    }

    //Vista del codigo generado por el administrador
    public function showCodeAdmin(Request $request){

        $request->validate(['type' => 'required|boolean'], [
            'type.required' => 'Debes seleccionar una de las opciones.',
            'type.boolean' => 'El tipo de dato introducido es incorrecto.',
        ]);

        $codigo=new CodRegistro();
        $codigo->codigo=CodRegistro::crearCodigo();
        $codigo->id_creador=Auth::id();
        $codigo->para_cliente=$request->type;
        $codigo->save();
        
        return Inertia::render('Users/Admin/RegCode/ShowCode',['codigo'=>$codigo,'tipo'=>boolval($request->type)]);
    }
}
