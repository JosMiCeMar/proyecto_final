<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador para manejar la autenticación de sesiones.
 */
class AuthenticatedSessionController extends Controller
{
     /**
     * Muestra la vista de inicio de sesión.
     *
     * @return Response La vista de inicio de sesión renderizada con Inertia.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Maneja una solicitud de autenticación entrante.
     *
     * @param LoginRequest $request La solicitud de inicio de sesión validada.
     * @return RedirectResponse Redirección al dashboard después de la autenticación.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        session()->forget(['cod','client']);
        
        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Cierra la sesión autenticada.
     *
     * @return RedirectResponse Redirección a la página de inicio tras cerrar sesión.
     */
    public function destroy(): RedirectResponse
    {
        Auth::guard('web')->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect(route('home'));
    }
}
