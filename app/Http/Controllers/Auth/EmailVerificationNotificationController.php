<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controlador para la notificación de verificación de correo electrónico.
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Enviar una nueva notificación de verificación de correo electrónico.
     * @param Request $request La solicitud HTTP.
     * @return RedirectResponse La respuesta de redirección.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
