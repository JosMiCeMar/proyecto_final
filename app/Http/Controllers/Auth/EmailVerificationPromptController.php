<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Muestra el mensaje de verificación de correo electrónico o redirige al usuario a su destino original.
     *
     * Este método verifica si el usuario ha verificado su correo electrónico. Si es así, se le redirige a la página
     * de destino que había solicitado previamente. Si no ha verificado su correo, se le muestra una vista de
     * verificación de correo electrónico.
     *
     * @param Request $request La solicitud HTTP que contiene al usuario autenticado.
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
