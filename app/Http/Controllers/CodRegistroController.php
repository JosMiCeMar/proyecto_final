<?php

namespace App\Http\Controllers;

use App\Models\CodRegistro;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador de los códigos de registro
 */
class CodRegistroController extends Controller
{
    //Constante para definir el tamaño del código
    private const LONGITUD_CODIGO = 8;

    //Máximo de códigos que puede generar un responsable
    private const MAX_CODIGOS_RESPONSABLE = 10;

    //-----------------FUNCIONES PARA EL REGISTRO DE USUARIOS----------------------
    
    /**
     * Vista para insertar el código de registro
     * @return Response|RedirectResponse Vista para insertar el código de registro
     */
    public function insertCode(): Response|RedirectResponse
    {
        if (session()->has('cod') && session()->has('client')) {
            if (session()->get('client')) {
                return redirect()->route('cliente.create');
            }
            return redirect()->route('responsable.create');
        }

        return Inertia::render('Auth/InsertCode');
    }

    /**
     * Comprueba si el código introducido es válido
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la vista de registro de cliente o responsable
     */
    public function checkCode(Request $request): RedirectResponse
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

    //-------------------FUNCIONES PARA ADMNISTRADOR-------------------------
    /**
     * Vista del index de códigos de registro para el administrador
     * @return Response Vista del index de códigos de registro
     */
    public function indexCodeAdmin(): Response
    {
        return Inertia::render('Users/Admin/RegCode/Index');
    }

    /**
     * Listado de códigos de registro para el administrador
     * @return Response|RedirectResponse Vista del listado de códigos de registro
     */
    public function listCodeAdmin(): Response|RedirectResponse
    {
        try {
            $usados = CodRegistro::where('usado', true)->exists();

            $codigos = CodRegistro::join('users', 'cod_registros.id_creador', '=', 'users.id')
                ->select('cod_registros.*', 'users.nombre', 'users.apellidos')
                ->orderBy('cod_registros.created_at')
                ->get();


            return Inertia::render('Users/Admin/RegCode/TableCode', ['codigos' => $codigos, 'usados' => $usados]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexCode')->withErrors('Error al generar el código de registro: ' . $er->getMessage());
        }
    }

    /**
     * Elimina un código de registro
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la vista de códigos de registro
     */
    public function deleteCodeAdmin(Request $request): RedirectResponse
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

    /**
     * Vista para generar un código de registro
     * @return Response Vista para generar un código de registro
     */
    public function genCodeAdmin(): Response
    {
        return Inertia::render('Users/Admin/RegCode/GenCode');
    }

    /**
     * Genera un código de registro
     * @param Request $request Datos del formulario
     * @return Response|RedirectResponse Vista del código de registro
     */
    public function showCodeAdmin(Request $request): Response|RedirectResponse
    {
        try {
            // Validación de la entrada
            $request->validate(['type' => 'required|boolean'], [
                'type.required' => 'Debes seleccionar una de las opciones.',
                'type.boolean' => 'El tipo de dato introducido es incorrecto.',
            ]);

            // Crear el código y asegurarse de que sea único
            do {
                $codigoGenerado = $this->crearCodigo();
            } while (CodRegistro::where('codigo', $codigoGenerado)->exists());

            $codigo = new CodRegistro();
            $codigo->codigo = $codigoGenerado;
            $codigo->id_creador = Auth::id();
            $codigo->para_cliente = $request->type;
            $codigo->save();

            return Inertia::render('Users/Admin/RegCode/ShowCode', [
                'codigo' => $codigoGenerado,
                'tipo' => boolval($request->type)
            ]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexCode')->withErrors('Error al generar el código de registro: ' . $er->getMessage());
        }
    }

    //-------------------FUNCIONES PARA RESPONSABLES-------------------------
    
    /**
     * Vista del index de códigos de registro para el responsable
     * @return Response Vista del index de códigos de registro
     */
    public function indexCodeRespon(): Response
    {
        return Inertia::render('Users/Responsable/RegCode/Index');
    }

    /**
     * Vista para generar un código de registro para el responsable
     * @return Response Vista para generar un código de registro
     */
    public function createCodeRespon(): Response
    {
        return Inertia::render('Users/Responsable/RegCode/GenCode');
    }

    /**
     * Genera un código de registro para el responsable
     * @return Response|RedirectResponse Vista del código de registro
     */
    public function storeCodeRespon(): Response|RedirectResponse
    {
        try {
            //Comprueba si el responsable autenticado ha generado la cantidad maxima de codigos
            if (
                CodRegistro::where('id_creador', Auth::id())
                ->where('usado', false)
                ->count() >= self::MAX_CODIGOS_RESPONSABLE
            ) {
                return redirect()->route('respon.indexCode')->withErrors('Has alcanzado el límite de códigos generados');
            }

            // Crear el código y asegurarse de que sea único
            do {
                $codigoGenerado = $this->crearCodigo();
            } while (CodRegistro::where('codigo', $codigoGenerado)->exists());

            $codigo = new CodRegistro();
            $codigo->codigo = $codigoGenerado;
            $codigo->id_creador = Auth::id();
            $codigo->para_cliente = true;
            $codigo->save();

            return Inertia::render('Users/Responsable/RegCode/ShowCode', [
                'codigo' => $codigoGenerado
            ]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexCode')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Listado de códigos de registro para el responsable
     * @return Response Vista del listado de códigos de registro
     */
    public function listCodeRespon(): Response
    {
        try {
            $codigos=CodRegistro::where('id_creador', Auth::id())->get();

            return Inertia::render('Users/Responsable/RegCode/TableCode',['codigos'=>$codigos]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexCode')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }


    //-------------------FUNCIONES PRIVADAS-------------------------
    /**
     * Crea un código de registro
     * @return string Código de registro
     */
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
