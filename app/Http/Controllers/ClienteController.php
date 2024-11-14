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
use App\Models\Reserva;
use Exception;

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

    public function ultimosTratamientos()
    {
        try {
            $hoy = Carbon::today();

            $cliente = Cliente::where('user_id', Auth::id())->first();

            if(!$cliente) {
               return redirect()->route('client.indexTratamientos')->withErrors('No se encontró el identificador de cliente');
            }

            $tratamientos = Reserva::where('cliente_id', $cliente->id)
                ->join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros','centros.id','dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<', $hoy)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'

                )
                ->orderBy('dias.fecha', 'desc')
                ->limit(5)
                ->get();
            
                if(!$tratamientos){
                    return redirect()->route('client.indexTratamientos')->withErrors('No se encontró ningún tratamiento');
                }

                
            return Inertia::render('Users/Client/Tratamientos/LastTreatment', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('client.indexTratamientos')->withErrors('Error al mostrar los últimos tratamientos: ' . $er->getMessage());
        }
    }

    public function resumenTratamientos()
    {
        try {
            $hoy = Carbon::today();

            $cliente = Cliente::where('user_id', Auth::id())->first();

            if(!$cliente) {
               return redirect()->route('client.indexTratamientos')->withErrors('No se encontró el identificador de cliente');
            }

            $tratamientos = Reserva::where('cliente_id', $cliente->id)
                ->join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros','centros.id','dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<', $hoy)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'

                )
                ->orderBy('dias.fecha', 'desc')
                ->get();
            
                if(!$tratamientos){
                    return redirect()->route('client.indexTratamientos')->withErrors('No se encontró ningún tratamiento');
                }

                
            return Inertia::render('Users/Client/Tratamientos/LastTreatment', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('client.indexTratamientos')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }
}
