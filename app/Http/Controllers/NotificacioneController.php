<?php

namespace App\Http\Controllers;

use App\Models\Notificacione;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificacioneController extends Controller
{

    //Funcion para eliminar las notificaciones
    public function eliminarNotificaciones(Request $request)
    {
        try {

            $request->validate([
                'checkboxes' => 'required|array',
                'checkboxes.*' => 'required|exists:notificaciones,id'
            ]);

            foreach ($request->checkboxes as $id) {
                $notificacion = Notificacione::find($id);
                $notificacion->delete();
            }

            $mensajeCorrecto = count($request->checkboxes) > 1
                ? 'Notificaciones eliminadas correctamente'
                : 'Notificación eliminada correctamente';

            return redirect(route('dashboard'))->with('msg', $mensajeCorrecto);
        } catch (Exception $er) {
            return redirect(route('dashboard'))->withErrors($er->getMessage(), 'msg');
        }
    }

    // Funcion para enviar notificaciones con texto personalizado
    public static function enviarNotificacion($userId, $mensaje)
    {
        $destinatario = User::find($userId);

        if ($destinatario) {
            $notificacion = new Notificacione();
            $notificacion->user_id_orig = Auth::id();
            $notificacion->user_id_dest = $userId;
            $notificacion->mensaje = $mensaje;
            $notificacion->save();
        }
    }
}
