<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Notificacione;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    public function dashboard(){
        try{
             
            $notificaciones = Notificacione::where('user_id_dest', Auth::id())
            ->join('users', 'notificaciones.user_id_orig', '=', 'users.id')
            ->select(
                'notificaciones.*',
                DB::raw("CONCAT(users.nombre, ' ', users.apellidos) as origen")
            )
            ->get();

        return Inertia::render('Dashboard',['notificaciones'=>$notificaciones]);

        }catch(Exception $er){
            return Inertia::render('Dashboard')->withErrors('Error inesperado: '.$er->getMessage());
        }
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status')
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
