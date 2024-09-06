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
use Inertia\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Centro;

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
        if ($codigoRegistro) {
            $codigoRegistro->usado = 1;
            $codigoRegistro->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function edit(Request $request)//: Response
    {
        $centros = CentroController::centrosSinResponsable();

        //Obtener el responsable y su centro asociado
        $responsable = Responsable::where('user_id', $request->user()->id)->first();
        $centroAsignado = Centro::find($responsable->centro_id);

        $centros->push($centroAsignado);

        return Inertia::render('Profile/EditResp', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'centros' => $centros
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255',
            'center'=>'required|integer|exists:centros,id'
        ]);

        $request->user()->nombre=$request->name;
        $request->user()->apellidos=$request->lastname;
        $request->user()->telefono=$request->tel;
        if($request->user()->email!==$request->email){
            $request->user()->email=$request->email;
        }
        $request->user()->save();
        Responsable::where('user_id',$request->user()->id)->update(['centro_id'=>$request->center]);

        return Redirect::route('resp.profileEdit');
    }
}
