<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class ClienteController extends Controller
{

    public function create(){
        return Inertia::render('Auth/ClientRegister');
    }

   public function store(Request $request){

    $fechaMaxima = Date::now()->subYears(13)->format('Y-m-d');

    $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:^[76]{1}[0-9]{8}$'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'fecha' => 'required|date|before_or_equal:'.$fechaMaxima,
            'condicion'=> 'boolean',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'nombre' => $request->name,
        'apellidos' => $request->lastname,
        'telefono'=>$request->tel,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Cliente::create([
        'user_id'=>$user->id,
        'condicion_especial'=>$request->condicion,
        'fecha_nacimiento'=>$request->fecha
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
   }
}
