<?php

namespace App\Http\Controllers;

use App\Models\Administradore;
use Illuminate\Http\Request;
use Inertia\Inertia;


class AdministradoreController extends Controller
{
    //

    public function pruebas(){

        $admin = new Administradore();

        $codigo=$admin->generarCodigo();
        $hash=password_hash($codigo, PASSWORD_DEFAULT);
        
        return Inertia::render('Pruebas', ['datos'=>$codigo,'hash'=>$hash,'verificar'=>password_verify('gilipollas',$hash)]);
    }
}
