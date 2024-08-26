<?php

namespace App\Http\Controllers;

use App\Models\CodRegistro;
use App\Models\Responsable;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);


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

        $codigoRegistro = CodRegistro::find(session()->get('cod'));
        if($codigoRegistro){
            $codigoRegistro->usado=1;
            $codigoRegistro->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function update(Request $request){
    
    }

}
