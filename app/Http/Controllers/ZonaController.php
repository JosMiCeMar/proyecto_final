<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZonaController extends Controller
{
    //

    public function index(){
        return Inertia::render('Users/Admin/Zonas/Index');
    }

    public function create(){

    }

    public function store(){
        
    }

    public function list(){
        $zonas = Zona::select('id', 'nombre', 'precio', 'tiempo_estimado')->where('active', 1)->get();
        return Inertia::render('Users/Admin/Zonas/TableZones', ['zonas' => $zonas]);
    }

    public function mod(){
        
    }

    public function update(){
        
    }

    public function delete(){
        
    }
}
