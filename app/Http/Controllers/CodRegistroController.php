<?php

namespace App\Http\Controllers;

use App\Models\CodRegistro;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CodRegistroController extends Controller
{

    public function insertCode()
    {
        if (session()->has('cod') && session()->has('client')) {
            if (session()->get('client')) {
                return redirect(route('cliente.create'));
            }
            return redirect(route('responsable.create'));
        }

        return Inertia::render('Auth/InsertCode');
    }

    public function checkCode(Request $request)
    {
        $codigoRecibido = $request->validate([
            'code' => 'required|alpha_num|max:8',
        ]);

        $codigo = CodRegistro::where('codigo', $codigoRecibido)->first();

        $mensajeError = "El código introducido no es válido";

        if ($codigo) {
            session()->put(['cod' => $codigo->codigo, 'client' => $codigo->para_cliente]);
            $codigo->usado = 1;
            $codigo->save();
            if($codigo->para_cliente){
                return redirect(route('cliente.create'));
            }else{
                return redirect(route('responsable.create'));
            }
        }

        return redirect(route('cod_registro.check'))->withErrors($mensajeError, 'error');
    }



}
