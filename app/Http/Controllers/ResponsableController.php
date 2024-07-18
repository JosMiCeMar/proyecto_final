<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class ResponsableController extends Controller
{
    public function create()
    {
        $centros = CentroController::centrosSinResponsable();

        return Inertia::render('Auth/RespRegister', ['centers' => $centros]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'center' => 'required|integer|exists:centros,id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], $this->messages());


        $user = User::create([
            'nombre' => $request->name,
            'apellidos' => $request->lastname,
            'telefono' => $request->tel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Responsable::create([
            'user_id' => $user->id,
            'centro_id' => $request->center
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }


    protected function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'lastname.required' => 'Los apellidos son obligatorios.',
            'tel.required' => 'El teléfono es obligatorio.',
            'tel.regex' => 'El teléfono debe tener 9 dígitos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'center.required' => 'El centro es obligatorio.',
            'center.exists' => 'El centro seleccionado no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
