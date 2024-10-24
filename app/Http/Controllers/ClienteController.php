<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CodRegistro;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;


class ClienteController extends Controller
{

    public function create()
    {
        return Inertia::render('Auth/ClientRegister', ['cod', session()->get('cod')]);
    }

    public function store(Request $request)
    {

        $edadMinima = Carbon::now()->subYear(13)->startOfDay()->format('Y-m-d');
        $edadMaxima = Carbon::now()->subYear(120)->startOfDay()->format('Y-m-d');

        $fechaFormateada = Carbon::parse($request->input('fecha'))->setTimezone(config('app.timezone'))->format('Y-m-d');
        $request->merge(['fecha' => $fechaFormateada]);

        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'fecha' => 'required|date|before_or_equal:' . $edadMinima . '|after_or_equal:' . $edadMaxima,
            'condicion' => 'boolean',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        //Creacion del registro de usuario
        $user = User::create([
            'nombre' => $request->name,
            'apellidos' => $request->lastname,
            'telefono' => $request->tel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Creacion del registro de cliente
        Cliente::create([
            'user_id' => $user->id,
            'condicion_especial' => $request->condicion,
            'fecha_nacimiento' => $request->fecha
        ]);

        //Se marca como usado el codigo de registro almacenado en la sesion
        $codigoRegistro = CodRegistro::find(session()->get('cod'));
        if ($codigoRegistro) {
            $codigoRegistro->usado = 1;
            $codigoRegistro->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/EditClient', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status')
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $edadMinima = Carbon::now()->subYear(13)->startOfDay()->format('Y-m-d');
        $edadMaxima = Carbon::now()->subYear(120)->startOfDay()->format('Y-m-d');

        $fechaFormateada = Carbon::parse($request->input('date'))->setTimezone(config('app.timezone'))->format('Y-m-d');
        $request->merge(['date' => $fechaFormateada]);

        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255',
            'date' => 'required|date|before_or_equal:' . $edadMinima . '|after_or_equal:' . $edadMaxima,
            'condition' => 'boolean'
        ]);

        $request->user()->nombre = $request->name;
        $request->user()->apellidos = $request->lastname;
        $request->user()->telefono = $request->tel;
        if ($request->user()->email !== $request->email) {
            $request->user()->email = $request->email;
            $request->user()->email_verified_at = null;
            $request->user()->sendEmailVerificationNotification();
        }
        $request->user()->save();
        Cliente::where('user_id', $request->user()->id)->update(['fecha_nacimiento' => $request->date, 'condicion_especial' => $request->condition]);

        return Redirect::route('client.profileEdit');
    }

    //Métodos para la sección de Tratamientos
    public function indexTratamientos()
    {
        return Inertia::render('Users/Client/Tratamientos/Index');
    }
}
