<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador para el usuario registrado.
 */
class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/InsertCode');
    }

    /**
     * Almacena un usuario recién registrado.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nombre' => $request->name,
            'apellidos' => $request->lastname,
            'telefono'=>$request->tel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
 
    }
}
