<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;


class AdministradoreController extends Controller
{
    //

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/EditAdmin', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status')
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^\d{9}$/'],
            'email' => 'required|string|lowercase|email|max:255' 
        ]);

        $request->user()->nombre=$request->name;
        $request->user()->apellidos=$request->lastname;
        $request->user()->telefono=$request->tel;
        
        if($request->user()->email!==$request->email){
            $request->user()->email=$request->email;
            $request->user()->email_verified_at=null;
            $request->user()->sendEmailVerificationNotification();
        }

        $request->user()->save();

        return Redirect::route('admin.profileEdit');
    }

}
