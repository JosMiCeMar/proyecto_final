<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiaController extends Controller
{
    //Vista para el menu de gestion
    public function index()
    {
        return Inertia::render('Users/Admin/Dias/Index');
    }

    //Vista del formulario de asignacion de dia
    public function create()
    {

        $centros = Centro::select('id','nombre','localidad')->where('active', 1)->get();

        return Inertia::render('Users/Admin/Dias/FormDia', ['centros' => $centros]);
    }

}
