<?php

namespace App\Http\Controllers;

use App\Models\CodRegistro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CodRegistroController extends Controller
{
    //Constante para definir el tamaño del código
    private const LONGITUD_CODIGO = 8;

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
        try {
            $codigoRecibido = $request->validate([
                'code' => 'required|alpha_num|max:8',
            ]);

            $codigo = CodRegistro::where('codigo', $codigoRecibido)->where('usado', 0)->first();

            if ($codigo) {
                session()->put(['cod' => $codigo->id, 'client' => $codigo->para_cliente]);
                $codigo->save();
                if ($codigo->para_cliente) {
                    return redirect(route('cliente.create'));
                } else {
                    return redirect(route('responsable.create'));
                }
            }

            return redirect(route('cod_registro.check'))->withErrors("El código introducido no es válido");
        } catch (Exception $er) {
            return redirect(route('cod_registro.check'))->withErrors("Error inesperado: " . $er->getMessage());
        }
    }

    //Menu de gestion del administrador
    public function indexCodeAdmin()
    {
        return Inertia::render('Users/Admin/RegCode/Index');
    }

    //Lista de codigos para el administrador
    public function listCodeAdmin()
    {
        try {
            $usados = CodRegistro::where('usado', true)->exists();

            $codigos = CodRegistro::orderByDesc('usado')->orderBy('para_cliente')->orderBy('created_at')->get();


            return Inertia::render('Users/Admin/RegCode/DelCode', ['codigos' => $codigos, 'usados' => $usados]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexCode')->withErrors('Error al generar el código de registro: ' . $er->getMessage());
        }
    }

    //Funcion para eliminar codigos del administrador
    public function deleteCodeAdmin(Request $request)
    {
        try {
            $request->validate(['id' => 'required|integer']);

            $codigo = CodRegistro::find($request->id);

            if ($codigo) {
                $codigo->delete();
                return redirect(route('admin.delCode'))->with('msg', 'Código de registro eliminado correctamente');
            } elseif (!$codigo || $request->id === 0) {
                CodRegistro::where('usado', true)->delete();
                return redirect(route('admin.delCode'))->with('msg', 'Códigos usados eliminados correctamente');
            }
            return back();
        } catch (Exception $er) {
            return redirect(route('cod_registro.check'))->withErrors("Error inesperado: " . $er->getMessage());
        }
    }

    //Vista del generador de codigos para el administrador
    public function genCodeAdmin()
    {
        return Inertia::render('Users/Admin/RegCode/GenCode');
    }

    //Vista del codigo generado por el administrador
    public function showCodeAdmin(Request $request)
    {
        try {
            // Validación de la entrada
            $request->validate(['type' => 'required|boolean'], [
                'type.required' => 'Debes seleccionar una de las opciones.',
                'type.boolean' => 'El tipo de dato introducido es incorrecto.',
            ]);

            // Crear el código y asegurarse de que sea único
            do {
                $codigo = $this->crearCodigo();
            } while (CodRegistro::where('codigo', $codigo)->exists());  // Verificar si el código ya existe

            $codigo = new CodRegistro();
            $codigo->codigo = $codigo;
            $codigo->id_creador = Auth::id();
            $codigo->para_cliente = $request->type;
            $codigo->save();

            return Inertia::render('Users/Admin/RegCode/ShowCode', [
                'codigo' => $codigo,
                'tipo' => boolval($request->type)
            ]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexCode')->withErrors('Error al generar el código de registro: ' . $er->getMessage());
        }
    }

    //Funcion estatica para generar el codigo aleatorio
    private static function crearCodigo()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';

        for ($i = 0; $i < self::LONGITUD_CODIGO; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $codigo;
    }
}
