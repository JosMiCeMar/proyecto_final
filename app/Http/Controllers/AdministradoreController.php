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

        
        return Inertia::render('Pruebas', ['datos'=>$codigo]);
    }
}
